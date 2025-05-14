@extends('layouts.admindash')

@section('title', 'Product Management')

@section('styles')
<style>
    :root {
        --indigo: #4B0082;
        --primary-purple: #5E35B1;
        --light-purple: #9575CD;
        --dark-green: #2E7D32;
        --green: #4CAF50;
        --light-green: #A5D6A7;
        --light-bg: #F5F7FA;
        --gray: #6C757D;
    }
    
    body {
        background-color: var(--light-bg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: transform 0.2s;
        overflow: hidden;
    }
    
    .card-header {
        background-color: var(--primary-purple);
        color: white;
        border-bottom: none;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        border-radius: 1rem 1rem 0 0 !important;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .btn-primary {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(94, 53, 177, 0.2);
    }
    
    .btn-primary:hover {
        background-color: var(--indigo);
        border-color: var(--indigo);
        box-shadow: 0 4px 12px rgba(75, 0, 130, 0.3);
        transform: translateY(-1px);
    }
    
    .btn-warning {
        background-color: var(--light-purple);
        border-color: var(--light-purple);
        color: white;
        border-radius: 0.5rem;
        transition: all 0.3s;
    }
    
    .btn-warning:hover {
        background-color: #8667c4;
        border-color: #8667c4;
        color: white;
    }
    
    .btn-danger {
        background-color: #f44336;
        border-color: #f44336;
        color: white;
        border-radius: 0.5rem;
        transition: all 0.3s;
    }
    
    .btn-danger:hover {
        background-color: #d32f2f;
        border-color: #d32f2f;
    }
    
    .btn-sm {
        padding: 0.35rem 0.65rem;
        font-size: 0.85rem;
        border-radius: 0.4rem;
    }
    
    .btn-icon {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 0.5rem;
        overflow: hidden;
        width: 100%;
    }
    
    .table thead th {
        background-color: var(--primary-purple);
        color: white;
        font-weight: 500;
        padding: 1rem;
        text-align: center;
        vertical-align: middle;
        border: none;
        position: relative;
    }
    
    .table thead th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 25%;
        height: 50%;
        width: 1px;
        background-color: rgba(255, 255, 255, 0.2);
    }
    
    .table tbody td {
        padding: 0.8rem 1rem;
        text-align: center;
        vertical-align: middle;
        border-color: #eaedf2;
        color: #333;
    }
    
    .table tbody tr {
        transition: background-color 0.2s;
    }
    
    .table tbody tr:hover {
        background-color: rgba(149, 117, 205, 0.05);
    }
    
    .alert-success {
        background-color: var(--light-green);
        color: var(--dark-green);
        border: none;
        border-left: 4px solid var(--green);
        border-radius: 0.5rem;
        padding: 1rem;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
        border-radius: 0.375rem;
    }
    
    .badge-success {
        background-color: var(--light-green);
        color: var(--dark-green);
    }
    
    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .badge-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }
    
    .search-input {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
    }
    
    .search-input:focus {
        border-color: var(--light-purple);
        box-shadow: 0 0 0 0.2rem rgba(94, 53, 177, 0.25);
    }
    
    .pagination {
        margin-top: 1.5rem;
        justify-content: center;
    }
    
    .page-item.active .page-link {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }
    
    .page-link {
        color: var(--primary-purple);
    }
    
    .table-responsive {
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .dropdown-menu {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item:hover {
        background-color: rgba(149, 117, 205, 0.1);
    }
    
    .stock-high {
        color: var(--dark-green);
        font-weight: 500;
    }
    
    .stock-medium {
        color: #856404;
        font-weight: 500;
    }
    
    .stock-low {
        color: #721c24;
        font-weight: 500;
    }
</style>
@endsection

@section('header', 'Product Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Products List</h5>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Add New Product
        </a>
    </div>
    
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="me-2">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input"
                            placeholder="Search products..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <select class="form-select me-2" name="category" onchange="document.getElementById('filterForm').submit();">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <select class="form-select" name="stock" onchange="document.getElementById('filterForm').submit();">
                            <option value="">All Stock</option>
                            <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>In Stock</option>
                            <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>


        <div class="table-responsive">
            <table class="table table-hover align-middle">
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
                            <td class="text-start"><strong>{{ $product->name }}</strong></td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock_quantity > 20)
                                    <span class="stock-high">{{ $product->stock_quantity }}</span>
                                @elseif($product->stock_quantity > 5)
                                    <span class="stock-medium">{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="stock-low">{{ $product->stock_quantity }}</span>
                                @endif
                            </td>
                            <td class="text-start">{{ Str::limit($product->description, 50) }}</td>
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->supplier ? $product->supplier->name : 'N/A' }}</td>
                            <td>
                                @if($product->category)
                                    <span class="badge badge-success">{{ $product->category->name }}</span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-sm btn-danger" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if($products->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="var(--gray)" viewBox="0 0 16 16" class="mb-3">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                    <p class="text-gray mb-0">No products found.</p>
                                    <p class="text-muted small">Try adjusting your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $products->appends(request()->except('page'))->links() }}
        </div>

        </div>
    </div>
</div>
@endsection