<?php

namespace App\Http\Controllers;

use App\Models\Service; // ✅ make sure the model exists in app/Models
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('user.products.services.index', compact('services')); // ✅
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create'); // Optional if you have a separate create form
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Service added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'service_type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $service = Service::findOrFail($id);
        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}