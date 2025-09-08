<?php

namespace App\Http\Controllers;

use App\Models\AlternatePageModel;
use App\Models\SiteMap;
use Illuminate\Http\Request;

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
        // Step 1: Validate input
        $validatedData = $request->validate([
            'url' => 'required|string|max:255',
            'canonical' => 'required|string|max:255',
            'priority' => 'numeric|min:0|max:1',
            'schema' => 'required|string',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
            'status' => 'in:active,inactive', // Adjust if needed
            'pagecontent' => 'required|string',

            // Alternate pages validation
            'alternate.*.hreflang' => 'nullable|string|max:10',
            'alternate.*.href' => 'nullable|string|max:255',
        ]);

        // Step 2: Create main sitemap record
        $sitemap = SiteMap::create($validatedData);

        // Step 3: Insert alternates if provided
        if ($request->has('alternate')) {
            foreach ($request->input('alternate') as $alt) {
                if (!empty($alt['hreflang']) && !empty($alt['href'])) {
                    AlternatePageModel::create([
                        'sitemap_id' => $sitemap->id,
                        'hreflang' => $alt['hreflang'],
                        'href' => $alt['href'],
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Page and alternates saved successfully!');
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
public function update(Request $request, $id)
{
    // Validation
    $validatedData = $request->validate([
        'url' => 'required|string|max:255',
        'canonical' => 'required|string|max:255',
        'priority' => 'numeric|min:0|max:1',
        'schema' => 'required|string',
        'meta_title' => 'required|string|max:255',
        'meta_description' => 'required|string|max:255',
        'status' => 'in:active,inactive',
        'pagecontent' => 'required|string',

        'alternate.*.alternate_id' => 'nullable|integer|exists:alternate_page_models,alternate_id',
        'alternate.*.hreflang' => 'nullable|string|max:10',
        'alternate.*.href' => 'nullable|string|max:255',
    ]);

    // Main record update
    $sitemap = SiteMap::findOrFail($id);
    $sitemap->update($validatedData);

    // Handle alternates
    $inputAlternates = $request->input('alternate', []);

    $existingIds = $sitemap->alternates()->pluck('alternate_id')->toArray();
    $inputIds = collect($inputAlternates)->pluck('alternate_id')->filter()->toArray();
    $idsToDelete = array_diff($existingIds, $inputIds);

    AlternatePageModel::destroy($idsToDelete);

    foreach ($inputAlternates as $alt) {
        if (!empty($alt['alternate_id'])) {
            AlternatePageModel::where('alternate_id', $alt['alternate_id'])->update([
                'hreflang' => $alt['hreflang'],
                'href' => $alt['href'],
            ]);
        } elseif (!empty($alt['hreflang']) && !empty($alt['href'])) {
            // Make sure sitemap_id is set automatically by relationship
            $sitemap->alternates()->create([
                'hreflang' => $alt['hreflang'],
                'href' => $alt['href'],
            ]);
        }
    }

    return redirect()->route('sitemap.show')->with('success', 'Page updated!');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sitemap = SiteMap::findOrFail($id);
        $sitemap->delete();
        return redirect()->route('sitemap.show')->with('success', 'Page deleted!');
    }
}
