@extends('layouts.admindash')

@section('title', 'Product Details')

@section('styles')
<style>
    .product-details {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
    }

    .detail-row {
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        font-weight: 600;
        color: #5E35B1;
        margin-bottom: 0.5rem;
    }

    .detail-value {
        color: #333;
        font-size: 1.1rem;
    }

    .stock-badge {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        display: inline-block;
    }

    .stock-high {
        background-color: #A5D6A7;
        color: #2E7D32;
    }

    .stock-medium {
        background-color: #FFE082;
        color: #F57F17;
    }

    .stock-low {
        background-color: #EF9A9A;
        color: #C62828;
    }

    .actions {
        margin-top: 2rem;
        display: flex;
        gap: 1rem;
    }

    .btn-back {
        background-color: #6C757D;
        color: white;
    }

    .btn-back:hover {
        background-color: #5a6268;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="product-details">
        <h2 class="mb-4">{{ $product->name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="detail-row">
                    <div class="detail-label">Description</div>
                    <div class="detail-value">{{ $product->description }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Price</div>
                    <div class="detail-value">₱{{ number_format($product->price, 2) }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Stock Quantity</div>
                    <div class="detail-value">
                        @if($product->stock_quantity > 20)
                            <span class="stock-badge stock-high">{{ $product->stock_quantity }} (High Stock)</span>
                        @elseif($product->stock_quantity > 5)
                            <span class="stock-badge stock-medium">{{ $product->stock_quantity }} (Medium Stock)</span>
                        @else
                            <span class="stock-badge stock-low">{{ $product->stock_quantity }} (Low Stock)</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="detail-row">
                    <div class="detail-label">Category</div>
                    <div class="detail-value">{{ $product->category ? $product->category->name : 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Supplier</div>
                    <div class="detail-value">{{ $product->supplier ? $product->supplier->name : 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Barcode</div>
                    <div class="detail-value">{{ $product->barcode ?: 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Location</div>
                    <div class="detail-value">{{ $product->location ?: 'N/A' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Brand</div>
                    <div class="detail-value">{{ $product->brand ?: 'N/A' }}</div>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('products.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Product
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="fas fa-trash"></i> Delete Product
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 