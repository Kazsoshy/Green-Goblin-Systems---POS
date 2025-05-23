<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'supplier']);

        // Search Filter
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('barcode', 'like', '%' . $request->search . '%');
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Stock Filter
        if ($request->filled('stock')) {
            switch ($request->stock) {
                case 'in':
                    $query->where('stock_quantity', '>', 10);
                    break;
                case 'low':
                    $query->whereBetween('stock_quantity', [1, 10]);
                    break;
                case 'out':
                    $query->where('stock_quantity', '<=', 0);
                    break;
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();
        
        return view('admin.product_management.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product_management.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
    
        Product::create($data);
    
        return redirect()->route('product_management.index')->with('success', 'Product added successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product_management.edit', compact('product', 'categories', 'suppliers'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        $data = $request->all();
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
    
        $product->update($data);
    
        return redirect()->route('product_management.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $product->delete();
            return redirect()->route('product_management.index')->with('success', 'Product deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { // Foreign key constraint violation code
                return redirect()->route('product_management.index')
                    ->with('error', 'This product cannot be deleted because it is associated with sales records. To maintain sales history, products that have been sold cannot be removed.');
            }
            return redirect()->route('product_management.index')
                ->with('error', 'An error occurred while deleting the product.');
        }
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        return view('admin.product_management.show', compact('product'));
    }
}
