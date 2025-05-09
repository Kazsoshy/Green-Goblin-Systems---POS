<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;



// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboards
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');

Route::get('/user/dashboard', function () {
    return view('user.dashboard');
})->middleware('auth');


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/user management', [UserController::class, 'index'])->name('user management.index');
    Route::get('/admin/user management/create', [UserController::class, 'create'])->name('user management.create');
    Route::post('/admin/user management', [UserController::class, 'store'])->name('user management.store');
    Route::get('/admin/user management/{user}/edit', [UserController::class, 'edit'])->name('user management.edit');
    Route::put('/admin/user management/{user}', [UserController::class, 'update'])->name('user management.update');
    Route::delete('/admin/user management/{user}', [UserController::class, 'destroy'])->name('user management.destroy');

    Route::get('/admin/product management', [ProductController::class, 'index'])->name('product management.index');
    Route::get('/admin/product management/create', [ProductController::class, 'create'])->name('product management.create');
    Route::post('/admin/product management', [ProductController::class, 'store'])->name('product management.store');
    Route::get('/admin/product management/{product}/edit', [ProductController::class, 'edit'])->name('product management.edit');
    Route::put('/admin/product management/{product}', [ProductController::class, 'update'])->name('product management.update');
    Route::delete('/admin/product management/{product}', [ProductController::class, 'destroy'])->name('product management.destroy');

    Route::get('/admin/category_management', [CategoryController::class, 'index'])->name('category_management.index');
    Route::get('/admin/category_management/create', [CategoryController::class, 'create'])->name('category_management.create');
    Route::post('/admin/category_management', [CategoryController::class, 'store'])->name('category_management.store');
    Route::get('/admin/category_management/{category}/edit', [CategoryController::class, 'edit'])->name('category_management.edit');
    Route::put('/admin/category_management/{category}', [CategoryController::class, 'update'])->name('category_management.update');
    Route::delete('/admin/category_management/{category}', [CategoryController::class, 'destroy'])->name('category_management.destroy');


});

Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
});


Route::resource('products', ProductController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
});


Route::prefix('admin')->group(function () {
    Route::resource('suppliers', SupplierController::class);
});


