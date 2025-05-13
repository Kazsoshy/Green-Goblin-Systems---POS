<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class UserProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'category', 'in_stock', 'price_sort']);

        $query = Product::query()->with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('in_stock')) {
            $query->where('stock_quantity', '>', 0);
        }

        $query->orderBy('price', $request->price_sort === 'desc' ? 'desc' : 'asc');

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('user.products.index', compact('products', 'categories', 'filters'));
    }

    public function show(Product $product)
    {
        $product->load('category', 'supplier');
        return view('user.products.show', compact('product'));
    }
}
