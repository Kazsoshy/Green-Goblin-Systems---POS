<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $query = Product::with(['category', 'supplier']);

    // Search Filter
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Category Filter
    if ($request->has('category') && $request->category != '') {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('name', $request->category);
        });
    }

    // Stock Filter
    if ($request->has('stock') && $request->stock != '') {
        switch ($request->stock) {
            case 'in':
                $query->where('stock_quantity', '>', 10);
                break;
            case 'low':
                $query->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10);
                break;
            case 'out':
                $query->where('stock_quantity', '=', 0);
                break;
        }
    }

    $products = $query->paginate(7);
    $categories = Category::all(); // fetch for dropdown
    return view('admin.product management.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.product management.create', compact('categories', 'suppliers'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',  // Add this
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'brand' => 'nullable',  // (making it nullable since it's not required in your form)
            'barcode' => 'nullable', 
        ]);
    
        Product::create([
            'name' => $request->name,
            'description' => $request->description,  
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'brand' => $request->brand,  
            'barcode' => $request->barcode,  
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
    
        return view('admin.product management.edit', compact('product', 'categories', 'suppliers'));
    }
    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required', 
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'brand' => 'nullable',  
            'barcode' => 'nullable', 
        ]);
    
        $product->update([
            'name' => $request->name,
            'description' => $request->description,  
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'location' => $request->location,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'brand' => $request->brand,  
            'barcode' => $request->barcode,  
        ]);
    
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
