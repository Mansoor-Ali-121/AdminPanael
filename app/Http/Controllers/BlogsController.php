<?php

namespace App\Http\Controllers;

use App\Models\BlogsModel;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.Blogs.add');
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
            'blog_tags'          => 'required|string',
            'blog_image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
            'image_alt_text'     => 'required|string',
            'meta_title'         => 'required|string|max:255',
            'meta_description'   => 'required|string',
            'shedule_date'       => 'nullable|date',
            'shedule_time'       => 'nullable',
            'status'             => 'required|in:active,inactive',
        ]);

        // Upload file 
        if ($request->hasFile('blog_image')) {
            $file = $request->file('blog_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('blog_images');
            $file->move($path, $filename);
            $ValidateData['blog_image'] = $filename;
        }

        BlogsModel::create($ValidateData);
        return redirect()->back()->with('success', 'Blog created successfully');
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
    public function edit(string $id)
    {
        $blogs = BlogsModel::findOrFail($id);
        return view('dashboard.Blogs.edit', compact('blogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
