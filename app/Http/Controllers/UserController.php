<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Role Filter
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(7);

        return view('admin.user management.index', compact('users'));
    }

    public function dashboard()
    {
        // Get product stock data grouped by category
        $stocksByCategory = Category::with(['products' => function($query) {
            $query->select('products.id', 'category_id', 'stock_quantity');
        }])
        ->select('id', 'name')
        ->get()
        ->map(function($category) {
            return [
                'category' => $category->name,
                'total_stock' => $category->products->sum('stock_quantity')
            ];
        });

        // Get categories and their stock counts for the chart
        $categories = $stocksByCategory->pluck('category');
        $stockCounts = $stocksByCategory->pluck('total_stock');

        return view('admin.dashboard', compact('categories', 'stockCounts'));
    }

    public function create()
    {
        return view('admin.user management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'password' => 'required|confirmed',
            'role' => 'required|in:user,admin'
        ]);

        User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user management.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'role' => 'required|in:user,admin'
        ]);

        $user->update([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
