<?php

namespace App\Http\Controllers;

use App\Models\Service; // ✅ make sure the model exists in app/Models
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_type' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0'
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')
            ->with('success', 'Service added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('admin.services.edit', compact('service'));
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

    public function addToCart(Service $service)
    {
        $cart = Session::get('cart', []);
        
        $cartItem = [
            'id' => 'service_' . $service->service_id,
            'type' => 'service',
            'name' => $service->service_type,
            'price' => $service->price,
            'quantity' => 1,
            'subtotal' => $service->price
        ];

        // Check if service already exists in cart
        $exists = false;
        foreach ($cart as $key => $item) {
            if ($item['id'] === $cartItem['id']) {
                $cart[$key]['quantity']++;
                $cart[$key]['subtotal'] = $cart[$key]['quantity'] * $cart[$key]['price'];
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $cart[] = $cartItem;
        }

        Session::put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Service added to cart successfully.');
    }
}