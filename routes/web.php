<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Redirect root to login
Route::redirect('/', '/login');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboards
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    // POS routes
    Route::get('/pos', [POSController::class, 'index'])->name('pos.index');
    Route::get('/pos/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
    Route::post('/pos/checkout', [POSController::class, 'processCheckout'])->name('pos.process-checkout');
    Route::get('/pos/transactions', [POSController::class, 'transactions'])->name('pos.transactions');
    Route::get('/pos/debug-sales', [POSController::class, 'debugSales'])->name('pos.debug-sales');
    Route::delete('/pos/sales/{id}', [POSController::class, 'destroySale'])->name('pos.sales.destroy');
    Route::get('/pos/sales-report', [POSController::class, 'salesReport'])->name('pos.sales-report');

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');

        // User Management
        Route::get('/user_management', [UserController::class, 'index'])->name('user_management.index');
        Route::get('/user_management/create', [UserController::class, 'create'])->name('user_management.create');
        Route::post('/user_management', [UserController::class, 'store'])->name('user_management.store');
        Route::get('/user_management/{user}/edit', [UserController::class, 'edit'])->name('user_management.edit');
        Route::put('/user_management/{user}', [UserController::class, 'update'])->name('user_management.update');
        Route::delete('/user_management/{user}', [UserController::class, 'destroy'])->name('user_management.destroy');

        // Product Management
        Route::get('/product_management', [ProductController::class, 'index'])->name('product_management.index');
        Route::get('/product_management/create', [ProductController::class, 'create'])->name('product_management.create');
        Route::post('/product_management', [ProductController::class, 'store'])->name('product_management.store');
        Route::get('/product_management/{product}/edit', [ProductController::class, 'edit'])->name('product_management.edit');
        Route::put('/product_management/{product}', [ProductController::class, 'update'])->name('product_management.update');
        Route::delete('/product_management/{product}', [ProductController::class, 'destroy'])->name('product_management.destroy');

        // Category Management
        Route::get('/category_management', [CategoryController::class, 'index'])->name('category_management.index');
        Route::get('/category_management/create', [CategoryController::class, 'create'])->name('category_management.create');
        Route::post('/category_management', [CategoryController::class, 'store'])->name('category_management.store');
        Route::get('/category_management/{category}/edit', [CategoryController::class, 'edit'])->name('category_management.edit');
        Route::put('/category_management/{category}', [CategoryController::class, 'update'])->name('category_management.update');
        Route::delete('/category_management/{category}', [CategoryController::class, 'destroy'])->name('category_management.destroy');

        // Supplier Management
        Route::get('/supplier_management', [SupplierController::class, 'index'])->name('supplier_management.index');
        Route::get('/supplier_management/create', [SupplierController::class, 'create'])->name('supplier_management.create');
        Route::post('/supplier_management', [SupplierController::class, 'store'])->name('supplier_management.store');
        Route::get('/supplier_management/{supplier}/edit', [SupplierController::class, 'edit'])->name('supplier_management.edit');
        Route::put('/supplier_management/{supplier}', [SupplierController::class, 'update'])->name('supplier_management.update');
        Route::delete('/supplier_management/{supplier}', [SupplierController::class, 'destroy'])->name('supplier_management.destroy');

        // Service Management
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

        // Settings Management
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings_management.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings_management.update');
    });
});

// API routes for POS
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/products/{id}', [POSController::class, 'getProduct']);
    Route::get('/services/{id}', [POSController::class, 'getService']);
    Route::post('/orders', [POSController::class, 'createOrder']);
});

// Debug route
Route::get('/debug/tables', function() {
    return response()->json([
        'tables' => DB::select('SHOW TABLES'),
        'sales_exists' => Schema::hasTable('sales'),
        'sale_items_exists' => Schema::hasTable('sale_items')
    ]);
});