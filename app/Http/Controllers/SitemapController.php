<?php

namespace App\Http\Controllers;

use App\Models\AlternatePageModel;
use App\Models\SiteMap;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SitemapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.Sitemap.add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            // Step 1: Validate input
            $validatedData = $request->validate([
                'url' => 'required|string|unique:site_maps,url|max:255',
                'canonical' => 'nullable|string|max:255',
                'priority' => 'numeric',
                'schema' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:255',
                'status' => 'in:active,inactive',
                'pagecontent' => 'nullable|string',
                'alternate.*.hreflang' => 'nullable|string|max:10',
                'alternate.*.href' => 'nullable|string|max:255',
            ]);

            // Step 2: Create main sitemap record
            $sitemap = SiteMap::create($validatedData);

            // Step 3: Insert alternates only if both fields are filled
            $sitemapId = $sitemap->sitemap_id;

            $alternates = $request->input('alternate', []); // default to []

            foreach ($alternates as $alt) {
                if (!empty($alt['hreflang']) && !empty($alt['href'])) {
                    AlternatePageModel::create([
                        'sitemap_id' => $sitemapId,
                        'hreflang' => $alt['hreflang'],
                        'href' => $alt['href'],
                    ]);
                }
            }

            return redirect()->route('sitemap.show')->with('success', 'Page and alternates saved successfully!');
        } catch (QueryException $e) {
            // Agar duplicate entry error aaye to ye message show kar
            if ($e->getCode() == 23000) { // MySQL duplicate entry code
                return redirect()->back()
                    ->withErrors(['url' => 'The url has already been taken.'])
                    ->withInput();
            }

            // Agar koi aur error ho to usko phir se throw kar
            throw $e;
        }
    }




    /**
     * Display the specified resource.
     */
    public function show()
    {
        $urls = SiteMap::all();
        return view('dashboard.Sitemap.show', compact('urls'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sitemap = SiteMap::findOrFail($id);
        $alternatePages = AlternatePageModel::where('sitemap_id', $sitemap->id)->get();
        return view('dashboard.Sitemap.edit', compact('sitemap', 'alternatePages'));
    }

    /**
     * Update the specified resource in storage.
     */
    //    use Illuminate\Database\QueryException;

    public function update(Request $request, $id)
    {
        // AJAX delete request handle karo
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
                'pagecontent' => 'nullable|string',

                'alternate.*.alternate_id' => 'nullable|integer|exists:alternate_page_models,alternate_id',
                'alternate.*.hreflang' => 'nullable|string|max:10',
                'alternate.*.href' => 'nullable|string|max:255',
            ]);

            // Find the main sitemap record
            $sitemap = SiteMap::findOrFail($id);

            // Update main sitemap record with validated data
            $sitemap->update($validatedData);

            // Process alternates
            $inputAlternates = $request->input('alternate', []);

            // Get existing alternate IDs
            $existingIds = $sitemap->alternates()->pluck('alternate_id')->toArray();

            // Get IDs from the request input (filtering out empty/null)
            $inputIds = collect($inputAlternates)
                ->pluck('alternate_id')
                ->filter() // removes null and empty values
                ->toArray();

            // Find IDs that need to be deleted (existing but not in the new input)
            $idsToDelete = array_diff($existingIds, $inputIds);

            // Delete alternates that are removed
            AlternatePageModel::destroy($idsToDelete);

            // Loop through input alternates to update or create
            foreach ($inputAlternates as $alt) {
                // Update existing alternate page
                if (!empty($alt['alternate_id'])) {
                    // Only update if both hreflang and href are provided (to avoid saving empty data)
                    if (!empty($alt['hreflang']) && !empty($alt['href'])) {
                        AlternatePageModel::where('alternate_id', $alt['alternate_id'])->update([
                            'hreflang' => $alt['hreflang'],
                            'href' => $alt['href'],
                        ]);
                    } else {
                        // If either field is empty, delete this alternate to avoid empty rows
                        AlternatePageModel::where('alternate_id', $alt['alternate_id'])->delete();
                    }
                }
                // Create new alternate page if both fields are filled
                elseif (!empty($alt['hreflang']) && !empty($alt['href'])) {
                    $sitemap->alternates()->create([
                        'hreflang' => $alt['hreflang'],
                        'href' => $alt['href'],
                    ]);
                }
            }

            return redirect()->route('sitemap.show')->with('success', 'Page updated!');
        } catch (QueryException $e) {
            // Agar duplicate entry error aaye to ye message show kar
            if ($e->getCode() == 23000) { // MySQL duplicate entry code
                return redirect()->back()
                    ->withErrors(['url' => 'The url has already been taken.'])
                    ->withInput();
            }

            // Agar koi aur error ho to usko phir se throw kar
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
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
