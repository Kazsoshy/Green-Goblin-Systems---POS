<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $products = Product::paginate(7);
        return view('admin.product management.index', compact('products'));

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
