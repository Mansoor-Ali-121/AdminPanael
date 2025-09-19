<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\SiteMap;
use Illuminate\Http\Request;
use App\Models\AlternatePageModel;
use Illuminate\Support\Facades\Log;
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
            // Validate input
            $validatedData = $request->validate([
                'url' => 'required|string|unique:site_maps,url|max:255',
                'send_to_google' => 'nullable|in:yes,no',
                'send_to_indexnow' => 'nullable|in:yes,no',
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

            // Checkbox values ko request se set karen
            $validatedData['send_to_google'] = $request->has('send_to_google') ? 'yes' : 'no';
            $validatedData['send_to_indexnow'] = $request->has('send_to_indexnow') ? 'yes' : 'no';

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

            // Initialize messages
            $messages = [];
            $googleApiResponse = '';
            $indexNowApiResponse = '';

            // Google Indexing API call, agar checkbox checked ho
            if ($validatedData['send_to_google'] === 'yes') {
                $googleApiResponse = $this->sendIndexingRequest($validatedData['url']);
                $messages[] = "Google: " . $googleApiResponse;
            }

            // IndexNow API call, agar checkbox checked ho
            if ($validatedData['send_to_indexnow'] === 'yes') {
                $this->sendIndexNowRequest($validatedData['url']);
                $messages[] = "IndexNow: URL sent for indexing.";
            }

            // Final success message banayen
            $finalMessage = 'URL added!';
            if (!empty($messages)) {
                $finalMessage .= ' Status: ' . implode(' | ', $messages);
            }

            return redirect()->route('sitemap.show')->with('success', $finalMessage);
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()
                    ->withErrors(['url' => 'The URL has already been taken.'])
                    ->withInput();
            }

            throw $e;
        }
    }

    // Google Indexing API Call
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
            return "✅ URL successfully sent to Google for indexing: {$url}";
        } catch (\Google_Service_Exception $e) {
            // Google API specific error
            return "❌ Google Indexing Failed for {$url}. Reason: " . $e->getMessage();
        } catch (\Exception $e) {
            // General error
            return "❌ Something went wrong for {$url}. Error: " . $e->getMessage();
        }
    }

    // 🟢 IndexNow API Call
    private function sendIndexNowRequest($url)
    {
        try {
            $client = new Client();
            $key = env('INDEXNOW_KEY');
            $host = config('app.url');

            $params = [
                'host' => $host,
                'key' => $key,
                'urlList' => [$url]
            ];

            $response = $client->post('https://api.indexnow.org/indexnow', [
                'json' => $params
            ]);

            // Agar response 200 OK hai to true return karen
            if ($response->getStatusCode() === 200) {
                return true;
            }

            // Agar response 200 nahi hai, to error log karen
            Log::error('IndexNow submission failed with status code: ' . $response->getStatusCode());
            return false;
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            // Kisi bhi Guzzle error par error log karen aur false return karen
            Log::error('IndexNow submission failed: ' . $e->getMessage());
            return false;
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
        $alternatePages = AlternatePageModel::where('sitemap_id', $sitemap->sitemap_id)->get();

        $indexingStatus = [];
        if ($sitemap->send_to_google === 'yes') {
            $indexingStatus[] = 'Google: Already indexed';
        }
        if ($sitemap->send_to_indexnow === 'yes') {
            $indexingStatus[] = 'IndexNow: Already indexed';
        }

        $indexingMessage = implode(' | ', $indexingStatus);

        return view('dashboard.Sitemap.edit', compact('sitemap', 'alternatePages', 'indexingMessage'));
    }
    
    // Naya method URL Inspection API ke liye
    // Is method ko apne AJAX request se call karen
    public function inspectUrl(Request $request)
    {
        $url = $request->input('url');
        if (!$url) {
            return response()->json(['error' => 'URL is required.'], 400);
        }

        try {
            $status = $this->checkUrlStatus($url);
            return response()->json(['status' => 'success', 'inspection_result' => $status]);
        } catch (\Exception $e) {
            Log::error('URL Inspection failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Failed to inspect URL. ' . $e->getMessage()], 500);
        }
    }

    // URL Inspection API ka private method
    private function checkUrlStatus($url)
    {
        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google/service-account.json'));
        // URL Inspection API ka naya scope shamil karen
        $client->addScope('https://www.googleapis.com/auth/webmasters.readonly');
    
        $service = new \Google_Service_Webmasters($client);
    
        // Request body banayen
        $request = new \Google_Service_Webmasters_InspectUrlIndexRequest();
        $request->setInspectionUrl($url);
        // Is line ko apni domain se badlen
        $request->setSiteUrl('https://devshieldit.com/'); 
    
        // API call karen
        $response = $service->urlInspection->get($request);
    
        // API ka response return karen
        return $response;
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
                'send_to_google' => 'nullable|in:yes,no', // 'nullable' add kiya hai
                'send_to_indexnow' => 'nullable|in:yes,no', // 'nullable' add kiya hai
                'pagecontent' => 'nullable|string',
                'alternate.*.alternate_id' => 'nullable|integer|exists:alternate_page_models,alternate_id',
                'alternate.*.hreflang' => 'nullable|string|max:10',
                'alternate.*.href' => 'nullable|string|max:255',
            ]);

            // Checkbox handle
            $validatedData['send_to_google'] = $request->has('send_to_google') ? 'yes' : 'no';
            $validatedData['send_to_indexnow'] = $request->has('send_to_indexnow') ? 'yes' : 'no';

            // Update main sitemap
            $sitemap = SiteMap::findOrFail($id);
            $sitemap->update($validatedData);
            
            // Initialize messages
            $messages = [];
            
            // Google Indexing API call, agar checkbox checked ho
            if ($validatedData['send_to_google'] === 'yes') {
                $googleApiResponse = $this->sendIndexingRequest($validatedData['url']);
                $messages[] = "Google: " . $googleApiResponse;
            }

            // IndexNow API call, agar checkbox checked ho
            if ($validatedData['send_to_indexnow'] === 'yes') {
                $this->sendIndexNowRequest($validatedData['url']);
                $messages[] = "IndexNow: URL sent for indexing.";
            }

            // Final success message banayen
            $finalMessage = 'Page updated!';
            if (!empty($messages)) {
                $finalMessage .= ' Status: ' . implode(' | ', $messages);
            }

            return redirect()->route('sitemap.show')->with('success', $finalMessage);

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