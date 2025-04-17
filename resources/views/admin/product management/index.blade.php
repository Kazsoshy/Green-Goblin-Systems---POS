@extends('layouts.admindash')

@section('title', 'Product Management')

@section('styles')
<style>
    .table thead th {
        background-color:var(--primary-purple);
        color: white;
        vertical-align: middle;
        text-align: center;
    }
    .table tbody td {
        vertical-align: middle;
        text-align: center;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
    .card {
        border-radius: 1rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('header', 'Product Management')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock Qty</th>
                    <th>Description</th>
                    <th>Barcode</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>₱{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->stock_quantity }}</td>
                        <td>{{ Str::limit($product->description, 50) }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->supplier ? $product->supplier->name : 'N/A' }}</td>
                        <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($products->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No products found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection