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
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
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
    
    .alert-success {
        background-color: var(--light-green);
        color: var(--dark-green);
        border: none;
        border-left: 4px solid var(--green);
        border-radius: 0.5rem;
        padding: 1rem;
    }
    
    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--light-purple);
        box-shadow: 0 0 0 0.2rem rgba(94, 53, 177, 0.25);
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
        border-radius: 0.375rem;
    }
    
    .badge.bg-success {
        background-color: var(--light-green) !important;
        color: var(--dark-green);
    }
    
    .badge.bg-warning {
        background-color: #fff3cd !important;
        color: #856404;
    }
    
    .badge.bg-danger {
        background-color: #f8d7da !important;
        color: #721c24;
    }
</style>
@endsection

@section('header', 'Product Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Products List</h5>
        <a href="{{ route('product_management.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New Product
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <form id="filterForm" class="row g-3" action="{{ route('product_management.index') }}" method="GET">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="searchInput" 
                               name="search" 
                               placeholder="Search by name, description, or barcode..."
                               value="{{ request('search') }}"
                               autocomplete="off">
                        @if(request('search'))
                            <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="categoryFilter" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="stockFilter" name="stock">
                        <option value="">All Stock Status</option>
                        <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>In Stock (>10)</option>
                        <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Low Stock (1-10)</option>
                        <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" id="filterButton">
                        <i class="fas fa-filter me-1"></i> Filter
                        <span class="spinner-border spinner-border-sm d-none" role="status" id="filterSpinner"></span>
                    </button>
                </div>
            </form>
        </div>

        @if(request()->anyFilled(['search', 'category', 'stock']))
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <span class="me-2">Active Filters:</span>
                    @if(request('search'))
                        <span class="badge bg-info me-2">
                            Search: {{ request('search') }}
                        </span>
                    @endif
                    @if(request('category'))
                        <span class="badge bg-info me-2">
                            Category: {{ $categories->find(request('category'))->name }}
                        </span>
                    @endif
                    @if(request('stock'))
                        <span class="badge bg-info me-2">
                            Stock: {{ ucfirst(request('stock')) }}
                        </span>
                    @endif
                    <a href="{{ route('product_management.index') }}" class="btn btn-sm btn-outline-secondary">
                        Clear All Filters
                    </a>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 0.5rem;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock_quantity > 10)
                                    <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('product_management.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('product_management.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const stockFilter = document.getElementById('stockFilter');
    const filterButton = document.getElementById('filterButton');
    const filterSpinner = document.getElementById('filterSpinner');
    let typingTimer;

    // Function to show loading state
    const showLoading = () => {
        filterButton.disabled = true;
        filterSpinner.classList.remove('d-none');
    };

    // Function to submit the form
    const submitForm = () => {
        showLoading();
        form.submit();
    };

    // Function to clear search
    window.clearSearch = () => {
        searchInput.value = '';
        submitForm();
    };

    // Handle search input with debounce
    searchInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(submitForm, 500);
    });

    // Handle select changes
    categoryFilter.addEventListener('change', submitForm);
    stockFilter.addEventListener('change', submitForm);

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        showLoading();
        this.submit();
    });
});
</script>
@endsection 