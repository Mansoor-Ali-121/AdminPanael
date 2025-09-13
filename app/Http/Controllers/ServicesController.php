<?php

namespace App\Http\Controllers;

use App\Models\ServicesModel;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.Services.add');
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
        // Validate inputs
        $ValidatedData = $request->validate([
            'service_name'   => 'required|string|max:255',
            'service_slug'   => 'required|string|max:255|unique:services_models,service_slug',
            'booking_link'   => 'nullable|string|max:255',
            'booking_page'   => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'service_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('service_image')) {
            $file = $request->file('service_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('Uploads/service_images');
            $file->move($path, $filename);
            $ValidatedData['service_image'] = $filename;
        }
        ServicesModel::create($ValidatedData);
        return redirect()->route('service.show')->with('success', 'Service Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $services = ServicesModel::all();
        return view('dashboard.pages.Services.show', compact('services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = ServicesModel::findOrFail($id);
        return view('dashboard.pages.Services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = ServicesModel::findOrFail($id);

        $validatedData = $request->validate([
            'service_name'   => 'nullable|string|max:255',
            'service_slug'   => 'nullable|string|max:255|unique:services_models,service_slug,' . $id . 'id',
            'booking_link'   => 'nullable|string|max:255',
            'booking_page'   => 'nullable|string|max:255',
            'description'    => 'nullable|string',
            'service_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('service_image')) {
            // Delete old image if exists
            if ($service->service_image) {
                $oldImagePath = public_path('Uploads/service_images/' . $service->service_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload new image
            $file = $request->file('service_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Uploads/service_images'), $filename);

            // Save new filename to data
            $validatedData['service_image'] = $filename;
        } else {
            // Keep old image if no new image uploaded
            $validatedData['service_image'] = $service->service_image;
        }

        // Update the service
        $service->update($validatedData);

        return redirect()->route('service.show')->with('success', 'Service Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = ServicesModel::findOrFail($id);
        $service->delete();
        return redirect()->route('service.show')->with('success', 'Service Deleted Successfully');
    }
}
