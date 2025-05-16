@extends('layouts.userdash')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Product Catalog</h1>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('user.products.index') }}" method="GET">
                <div class="row g-3">
                    <!-- Search Field -->
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search products..." value="{{ $filters['search'] ?? '' }}">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- In Stock Toggle -->
                    <div class="col-md-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock" 
                                   value="1" {{ ($filters['in_stock'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="in_stock">
                                In Stock Only
                            </label>
                        </div>
                    </div>
                    
                    <!-- Price Sorting -->
                    <div class="col-md-2">
                        <select name="price_sort" class="form-select">
                            <option value="asc" {{ ($filters['price_sort'] ?? 'asc') == 'asc' ? 'selected' : '' }}>
                                Price: Low to High
                            </option>
                            <option value="desc" {{ ($filters['price_sort'] ?? 'asc') == 'desc' ? 'selected' : '' }}>
                                Price: High to Low
                            </option>
                        </select>
                    </div>
                    
                    <!-- Submit/Reset -->
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Grid -->
    @if($products->count())
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-md-4 col-lg-3">
            <div class="card h-100">
                <!-- Product Image Placeholder -->
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height: 180px;">
                    <i class="fas fa-box fa-3x text-muted"></i>
                </div>
                
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-secondary">{{ $product->category->name }}</span>
                        <span class="text-muted">{{ $product->brand }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 text-primary">₱{{ number_format($product->price, 2) }}</span>
                        <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                            {{ $product->stock_quantity }} in stock
                        </span>
                    </div>
                </div>
                
                <div class="card-footer bg-white">
                    <a href="{{ route('user.products.show', $product) }}" 
                       class="btn btn-sm btn-outline-primary w-100 mb-2">
                        View Details
                    </a>
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>
    @else
    <div class="alert alert-info">
        No products found matching your criteria.
    </div>
    @endif
</div>
@endsection