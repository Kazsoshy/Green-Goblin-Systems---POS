<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        
        $products = Product::with(['category', 'supplier'])
            ->search($request->input('search'))
            ->inCategory($request->input('category'))
            ->when($request->boolean('in_stock'), fn($q) => $q->inStock())
            ->orderByPrice($request->input('price_sort', 'asc'))
            ->paginate(12)
            ->withQueryString();

        return view('user.products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'in_stock', 'price_sort'])
        ]);
    }

    public function show(Product $product)
    {
        return view('user.products.show', [
            'product' => $product->load(['category', 'supplier'])
        ]);
    }
}