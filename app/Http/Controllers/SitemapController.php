<?php

namespace App\Http\Controllers;

use App\Models\AlternatePageModel;
use App\Models\SiteMap;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SitemapController extends Controller
{
    public function index()
    {
        return view('dashboard.Sitemap.add');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // Checkbox handle: agar checked hai tabhi aage validate aur store hoga
            if (!$request->has('send_to_google')) {
                return redirect()->back()->with('info', 'Send to Google checkbox was not checked. Nothing saved.');
            }

            // Validate input
            $validatedData = $request->validate([
                'url' => 'required|string|unique:site_maps,url|max:255',
                'send_to_google' => 'nullable|in:yes,no',
                'canonical' => 'nullable|string|max:255',
                'priority' => 'nullable|numeric',
                'schema' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive',
                'pagecontent' => 'nullable|string',
                'alternate.*.hreflang' => 'nullable|string|max:10',
                'alternate.*.href' => 'nullable|string|max:255',
            ]);

            // Checkbox ke liye set karen
            $validatedData['send_to_google'] = 'yes';

            // Create main sitemap record
            $sitemap = SiteMap::create($validatedData);

            // Insert alternates
            $sitemapId = $sitemap->sitemap_id;
            $alternates = $request->input('alternate', []);
            foreach ($alternates as $alt) {
                if (!empty($alt['hreflang']) && !empty($alt['href'])) {
                    AlternatePageModel::create([
                        'sitemap_id' => $sitemapId,
                        'hreflang' => $alt['hreflang'],
                        'href' => $alt['href'],
                    ]);
                }
            }

            // Google Indexing API call
            $apiResponse = $this->sendIndexingRequest($validatedData['url']);

            return redirect()->route('sitemap.show')
                ->with('success', 'URL added & sent to Google for indexing! API response: ' . $apiResponse);
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()
                    ->withErrors(['url' => 'The URL has already been taken.'])
                    ->withInput();
            }

            throw $e;
        }
    }


    private function sendIndexingRequest($url, $type = 'URL_UPDATED')
    {
        try {
            // Google client setup
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('app/google/service-account.json'));
            $client->addScope('https://www.googleapis.com/auth/indexing');

            // Indexing service init
            $service = new \Google_Service_Indexing($client);

            // Request body
            $body = new \Google_Service_Indexing_UrlNotification();
            $body->setUrl($url);
            $body->setType($type);

            // API call
            $response = $service->urlNotifications->publish($body);

            // Friendly success message
            return "✅ URL successfully send to google for indexing: {$url}";
        } catch (\Google_Service_Exception $e) {
            // Google API specific error
            return "❌ Google Indexing Failed for {$url}. Reason: " . $e->getMessage();
        } catch (\Exception $e) {
            // General error
            return "❌ Something went wrong for {$url}. Error: " . $e->getMessage();
        }
    }


    public function show()
    {
        $urls = SiteMap::all();
        return view('dashboard.Sitemap.show', compact('urls'));
    }

    public function edit(string $id)
    {
        $sitemap = SiteMap::findOrFail($id);
        $alternatePages = AlternatePageModel::where('sitemap_id', $sitemap->id)->get();
        return view('dashboard.Sitemap.edit', compact('sitemap', 'alternatePages'));
    }

  public function update(Request $request, $id)
{
    // AJAX delete alternate handling
    if ($request->ajax() && $request->input('action') === 'delete_alternate') {
        $alternateId = $request->input('alternate_id');
        $alternate = AlternatePageModel::find($alternateId);
        if ($alternate) {
            $alternate->delete();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error', 'message' => 'Alternate not found']);
    }

    try {
        // Validation
        $validatedData = $request->validate([
            'url' => 'required|string|max:255|unique:site_maps,url,' . $id . ',sitemap_id',
            'canonical' => 'nullable|string|max:255',
            'priority' => 'numeric|min:0|max:1',
            'schema' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'send_to_google' => 'in:yes,no',
            'pagecontent' => 'nullable|string',
            'alternate.*.alternate_id' => 'nullable|integer|exists:alternate_page_models,alternate_id',
            'alternate.*.hreflang' => 'nullable|string|max:10',
            'alternate.*.href' => 'nullable|string|max:255',
        ]);

        // Checkbox handle
        $validatedData['send_to_google'] = $request->has('send_to_google') ? 'yes' : 'no';

        // Update main sitemap
        $sitemap = SiteMap::findOrFail($id);
        $sitemap->update($validatedData);

        // Google Indexing API call
        $apiResponse = null;
        if ($validatedData['send_to_google'] === 'yes') {
            $apiResponse = $this->sendIndexingRequest($validatedData['url']);
        }

        // Handle alternates
        $inputAlternates = $request->input('alternate', []);
        $existingIds = $sitemap->alternates()->pluck('alternate_id')->toArray();
        $inputIds = collect($inputAlternates)->pluck('alternate_id')->filter()->toArray();
        $idsToDelete = array_diff($existingIds, $inputIds);
        AlternatePageModel::destroy($idsToDelete);

        foreach ($inputAlternates as $alt) {
            if (!empty($alt['alternate_id'])) {
                if (!empty($alt['hreflang']) && !empty($alt['href'])) {
                    AlternatePageModel::where('alternate_id', $alt['alternate_id'])->update([
                        'hreflang' => $alt['hreflang'],
                        'href' => $alt['href'],
                    ]);
                } else {
                    AlternatePageModel::where('alternate_id', $alt['alternate_id'])->delete();
                }
            } elseif (!empty($alt['hreflang']) && !empty($alt['href'])) {
                $sitemap->alternates()->create([
                    'hreflang' => $alt['hreflang'],
                    'href' => $alt['href'],
                ]);
            }
        }

        // ✅ Redirect with API response if exists
        $message = 'Page updated!';
        if ($apiResponse) {
            $message .= ' ' . $apiResponse;
        }

        return redirect()->route('sitemap.show')->with('success', $message);

    } catch (QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->back()
                ->withErrors(['url' => 'The URL has already been taken.'])
                ->withInput();
        }

        throw $e;
    }
}


    public function destroy(string $id)
    {
        $sitemap = SiteMap::findOrFail($id);
        $sitemap->delete();
        return redirect()->route('sitemap.show')->with('success', 'Sitemap Page deleted!');
    }

    public function deleteAlternate($id)
    {
        $alternate = AlternatePageModel::find($id);

        if (!$alternate) {
            return response()->json(['status' => 'error', 'message' => 'Alternate not found'], 404);
        }

        $alternate->delete();

        return response()->json(['status' => 'success']);
    }
}
