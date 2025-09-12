<?php

namespace App\Http\Controllers;

use App\Models\BlogsModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = BlogsModel::all();
        // return view('dashboard.Blogs.show', compact('blogs'));
        return view('dashboard.pages.dashboard', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function blogs()
    {
        return view('dashboard.Blogs.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
