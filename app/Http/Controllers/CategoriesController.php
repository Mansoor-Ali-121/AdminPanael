<?php

namespace App\Http\Controllers;

use App\Models\BlogsCategories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.Blogs_Categories.add');
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

            'category_name' => 'required|string|max:255|',
            'category_slug' => 'required|string|max:255|unique:blogs_categories',
            'category_status' => 'required|in:active,inactive',
        ]);
        BlogsCategories::create($ValidateData);
        return redirect()->route('category.show')->with('success', 'Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $categories = BlogsCategories::all();
        return view('dashboard.Blogs_Categories.show', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(string $id)
{
    $category = BlogsCategories::findOrFail($id);
    return view('dashboard.Blogs_Categories.edit', compact('category'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
    $validateData = $request->validate([
        'category_name' => 'required|string|max:255',
        'category_slug' => 'required|string|max:255|unique:blogs_categories,category_slug,' . $id . ',category_id',
        'category_status' => 'required|in:active,inactive',
    ]);

    $category = BlogsCategories::findOrFail($id);
    $category->update($validateData);

    return redirect()->route('category.show')->with('success', 'Category Updated Successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = BlogsCategories::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category Deleted Successfully');
    }
}
