<?php

namespace App\Http\Controllers;

use App\Models\BlogsModel;
use Illuminate\Http\Request;
use App\Models\BlogsCategories;
use App\Models\CatLinksModel;
use Carbon\Carbon;


class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BlogsCategories::all();
        return view('dashboard.Blogs.add', compact('categories'));
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
        $ValidateData = $request->validate([
            'blog_title'         => 'required|string|max:255',
            'blog_description'   => 'required|string',
            'blog_slug'          => 'required|string|unique:blogs_models,blog_slug',
            'blog_content'       => 'required|string',
            'blog_tags'          => 'nullable|string',
            'blog_image'         => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'image_alt_text'     => 'required|string',
            'meta_title'         => 'required|string|max:255',
            'meta_description'   => 'required|string',
            // 'shedule_date'       => 'required|date_format:Y-m-d',
            // 'shedule_time'       => 'required|date_format:H:i',
            'status'             => 'required|in:active,inactive',
            'shedule_date' => $request->status === 'inactive' ? 'required|date' : 'nullable|date',
            'shedule_time' => $request->status === 'inactive' ? 'required' : 'nullable',
        ]);

        if ($request->hasFile('blog_image')) {
            $file = $request->file('blog_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('blog_images');
            $file->move($path, $filename);
            $ValidateData['blog_image'] = $filename;
        }

        $blog = BlogsModel::create($ValidateData);

        // Validate category_id array if any
        $category_ids = $request->validate([
            'category_id' => 'array',
        ]);

        $ValidateData_2 = $request->validate([
            'status' => 'in:active,inactive',
        ]);

        // Insert only if categories are selected (non-empty array)
        if (!empty($category_ids['category_id'])) {
            foreach ($category_ids['category_id'] as $category_id) {
                CatLinksModel::updateOrCreate(
                    ['blog_id' => $blog->blog_id, 'category_id' => $category_id],
                    $ValidateData_2
                );
            }
        }

        return redirect()->route('blog.show')->with('success', 'Blog created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {
        $blogs = BlogsModel::all();
        return view('dashboard.Blogs.show', compact('blogs'));
    }

    public function view($id)
    {
        $blog = BlogsModel::findOrFail($id);  // model ka naam apne hisaab se change karo
        return view('dashboard.Blogs.view', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $blog = BlogsModel::with('categories')->findOrFail($id);
        $blog_category_ids = CatLinksModel::where('blog_id', $id)->pluck('category_id')->toArray();
        $categories = BlogsCategories::all();

        return view('dashboard.Blogs.edit', compact('blog', 'categories', 'blog_category_ids'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, string $id)
{
    $blog = BlogsModel::findOrFail($id);

    $ValidateData = $request->validate([
        'blog_title'         => 'required|string|max:255',
        'blog_description'   => 'required|string',
        'blog_slug'          => 'required|string|unique:blogs_models,blog_slug,' . $blog->blog_id . ',blog_id',
        'blog_content'       => 'required|string',
        'blog_tags'          => 'nullable|string',
        'blog_image'         => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
        'image_alt_text'     => 'required|string',
        'meta_title'         => 'required|string|max:255',
        'meta_description'   => 'required|string',
        'status'             => 'required|in:active,inactive',
        'shedule_date'       => $request->status === 'inactive' ? 'required|date' : 'nullable|date',
        'shedule_time'       => $request->status === 'inactive' ? 'required' : 'nullable',
    ]);

    //  Handle publish/schedule datetime logic
    if ($ValidateData['status'] === 'inactive') {
        $ValidateData['published_at'] = $ValidateData['shedule_date'] . ' ' . $ValidateData['shedule_time'];
    } else {
        // If active, remove any scheduled datetime
        $ValidateData['published_at'] = null;
        $ValidateData['shedule_date'] = null;
        $ValidateData['shedule_time'] = null;
    }

    //  Handle file upload (optional in edit)
    if ($request->hasFile('blog_image')) {
        // Delete old image if exists
        $oldImage = public_path('blog_images/' . $blog->blog_image);
        if ($blog->blog_image && file_exists($oldImage)) {
            unlink($oldImage);
        }

        $file = $request->file('blog_image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('blog_images'), $filename);
        $ValidateData['blog_image'] = $filename;
    } else {
        // Keep old image if no new image is uploaded
        $ValidateData['blog_image'] = $blog->blog_image;
    }

    //  Update blog data
    $blog->update($ValidateData);

    //  Handle category IDs (with pivot data)
    $category_ids = $request->validate([
        'category_id' => 'array',
    ]);
    $selectedCategoryIDs = $category_ids['category_id'] ?? [];

    $pivotData = [
        'status' => $request->input('status', 'inactive'),
    ];

    $syncData = collect($selectedCategoryIDs)->mapWithKeys(function ($id) use ($pivotData) {
        return [$id => $pivotData];
    })->toArray();

    $blog->categories()->sync($syncData);

    return redirect()->route('blog.show')->with('success', 'Blog updated successfully.');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = BlogsModel::findOrFail($id);

        // Delete the image if exists
        $imagePath = public_path('blog_images/' . $blog->blog_image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $blog->delete();
        return redirect()->route('blog.show')->with('success', 'Blog deleted successfully.');
    }
}
