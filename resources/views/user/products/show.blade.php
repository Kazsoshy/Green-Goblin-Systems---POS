@extends('layouts.userdash')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6">
            <!-- Product Image -->
            <div class="card mb-4">
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height: 400px;">
                    <i class="fas fa-box-open fa-5x text-muted"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Product Details -->
            <h1 class="h2">{{ $product->name }}</h1>
            <h2 class="h4 text-muted mb-3">{{ $product->brand }}</h2>
            
            <div class="d-flex align-items-center mb-3">
                <span class="h3 text-primary me-3">₱{{ number_format($product->price, 2) }}</span>
                <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                    {{ $product->stock_quantity }} available
                </span>
            </div>
            
            <hr>
            
            <div class="mb-4">
                <h3 class="h5">Product Information</h3>
                <dl class="row">
                    <dt class="col-sm-3">Category</dt>
                    <dd class="col-sm-9">{{ $product->category->name }}</dd>
                    
                    <dt class="col-sm-3">Supplier</dt>
                    <dd class="col-sm-9">{{ $product->supplier->name ?? 'N/A' }}</dd>
                    
                    @if($product->barcode)
                    <dt class="col-sm-3">Barcode</dt>
                    <dd class="col-sm-9">{{ $product->barcode }}</dd>
                    @endif
                    
                    @if($product->location)
                    <dt class="col-sm-3">Location</dt>
                    <dd class="col-sm-9">{{ $product->location }}</dd>
                    @endif
                </dl>
            </div>
            
            <div class="mb-4">
                <h3 class="h5">Description</h3>
                <p>{{ $product->description ?? 'No description available.' }}</p>
            </div>
            
            <div class="d-flex gap-2">
                @if($product->stock_quantity > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-cart-plus me-2"></i> Add to Cart
                    </button>
                </form>
                @endif
                <a href="{{ route('user.products.index') }}" class="btn btn-outline-secondary btn-lg">
                    Back to Products
                </a>
            </div>
        </div>
    </div>
</div>
@endsection