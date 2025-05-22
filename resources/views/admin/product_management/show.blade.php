@extends('layouts.admindash')

@section('title', 'Product Details')

@section('header', 'Product Details')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Product Details</h5>
            <div>
                <a href="{{ route('product_management.edit', $product->id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('product_management.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 300px;">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>

                <table class="table">
                    <tr>
                        <th style="width: 150px;">Name:</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Price:</th>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Stock:</th>
                        <td>
                            @if($product->stock_quantity > 10)
                                <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                            @elseif($product->stock_quantity > 0)
                                <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Location:</th>
                        <td>{{ $product->location }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table">
                    <tr>
                        <th style="width: 150px;">Category:</th>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Supplier:</th>
                        <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Brand:</th>
                        <td>{{ $product->brand ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Barcode:</th>
                        <td>{{ $product->barcode ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $product->created_at->format('M d, Y H:i A') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $product->updated_at->format('M d, Y H:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 