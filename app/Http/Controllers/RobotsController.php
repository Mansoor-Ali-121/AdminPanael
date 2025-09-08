<?php

namespace App\Http\Controllers;

use App\Models\RobotsModel;
use Illuminate\Http\Request;

class RobotsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.Robots.add');
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

        'allowed' => 'nullable|string',
        'disallowed' => 'nullable|string',
        ]);
        RobotsModel::create($ValidateData);
        return redirect()->route('robots.show')->with('success', 'Robots Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $allowed_entries = RobotsModel::where('allowed', '!=', null)->get();
        $disallowed_entries = RobotsModel::where('disallowed', '!=', null)->get();
        return view('dashboard.Robots.show', compact('allowed_entries', 'disallowed_entries'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $robots = RobotsModel::find($id);
        return view('dashboard.Robots.edit', compact('robots'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ValidateData = $request->validate([

        'allowed' => 'nullable|string',
        'disallowed' => 'nullable|string',
        ]);
        RobotsModel::whereId($id)->update($ValidateData);
        return redirect()->route('robots.show')->with('success', 'Robots Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $robots = RobotsModel::findOrFail($id);
       $robots->delete();
        return redirect()->route('robots.show')->with('success', 'Robots Deleted Successfully');
    }
}
