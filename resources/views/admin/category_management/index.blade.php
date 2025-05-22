@extends('layouts.admindash')

@section('title', 'Category Management')

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
        background-color: white;
        color: var(--gray);
        border: 1px solid var(--gray);
        border-radius: 0.5rem;
        transition: all 0.3s;
    }
    
    .btn-danger:hover {
        background-color: #f8d7da;
        border-color: #dc3545;
        color: #dc3545;
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
        text-align: left;
        vertical-align: middle;
        border: none;
        position: relative;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
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
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
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
    
    .category-name {
        font-weight: 500;
        display: flex;
        align-items: center;
    }
    
    .category-name svg {
        color: var(--primary-purple);
        margin-right: 10px;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gray);
    }
    
    .empty-state svg {
        width: 48px;
        height: 48px;
        color: var(--light-purple);
        margin-bottom: 1rem;
        opacity: 0.7;
    }
    
    /* Animation for alert */
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    .alert-success {
        animation: fadeOut 5s ease 3s forwards;
    }
</style>
@endsection

@section('header', 'Category Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Categories List</h5>
        <a href="{{ route('category_management.create') }}" class="btn btn-primary btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Add New Category
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

        <div class="row mb-4">
            <form id="filterForm" class="row g-3" action="{{ route('category_management.index') }}" method="GET">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="searchInput" 
                               name="search" 
                               placeholder="Search categories..."
                               value="{{ request('search') }}"
                               autocomplete="off">
                        @if(request('search'))
                            <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <select class="form-select" id="parentFilter" name="parent" style="width: auto;">
                            <option value="">All Categories</option>
                            <option value="none" {{ request('parent') == 'none' ? 'selected' : '' }}>Main Categories</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ request('parent') == $parent->id ? 'selected' : '' }}>
                                    Sub-categories of {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->anyFilled(['search', 'parent']))
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <span class="me-2">Active Filters:</span>
                    @if(request('search'))
                        <span class="badge bg-info me-2">
                            Search: {{ request('search') }}
                        </span>
                    @endif
                    @if(request('parent'))
                        <span class="badge bg-info me-2">
                            @if(request('parent') === 'none')
                                Type: Main Categories
                            @else
                                Parent: {{ $parentCategories->find(request('parent'))?->name }}
                            @endif
                        </span>
                    @endif
                    <a href="{{ route('category_management.index') }}" class="btn btn-sm btn-outline-secondary">
                        Clear All Filters
                    </a>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th width="40%">Category Name</th>
                        <th width="30%">Parent Category</th>
                        <th width="30%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>
                                <div class="category-name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                    </svg>
                                    {{ $category->name }}
                                </div>
                            </td>
                            <td>
                                @if($category->parent)
                                    <span class="badge bg-light text-dark">
                                        {{ $category->parent->name }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Main Category</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('category_management.edit', $category->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                        <span class="ms-1">Edit</span>
                                    </a>
                                    <form action="{{ route('category_management.destroy', $category->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure you want to delete this category?')" class="btn btn-sm btn-danger" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                            <span class="ms-1">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-4">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16" class="mb-3">
                                        <path d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.825a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
                                    </svg>
                                    <h4>No Categories Found</h4>
                                    <p class="text-muted">Start by adding a new category using the button above.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($categories) && method_exists($categories, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const parentFilter = document.getElementById('parentFilter');
    let typingTimer;

    // Function to submit the form
    const submitForm = () => {
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
        typingTimer = setTimeout(submitForm, 500); // Wait 500ms after user stops typing
    });

    // Handle parent category filter change
    parentFilter.addEventListener('change', submitForm);

    // Auto-hide alert after 8 seconds
    setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 8000);
});
</script>
@endsection