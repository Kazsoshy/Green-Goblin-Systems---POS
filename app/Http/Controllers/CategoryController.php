<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        // Search Filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Parent Category Filter
        if ($request->filled('parent')) {
            if ($request->parent === 'none') {
                $query->whereNull('parent_category_id');
            } else {
                $query->where('parent_category_id', $request->parent);
            }
        }

        $categories = $query->latest()->paginate(10)->withQueryString();
        $parentCategories = Category::whereNull('parent_category_id')->get();
        
        return view('admin.category_management.index', compact('categories', 'parentCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category_management.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_category_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->all());

        return redirect()->route('category_management.index')->with('success', 'Category added successfully.');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('admin.category_management.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'parent_category_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($request->all());

        return redirect()->route('category_management.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category_management.index')->with('success', 'Category deleted successfully.');
    }
}
