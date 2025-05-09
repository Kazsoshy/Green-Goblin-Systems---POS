<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->get();
        $categories = Category::paginate(7);
        return view('admin.category_management.index', compact('categories'));
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
