@extends('layouts.admindash')

@section('title', 'Supplier Management')

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
    
    .status-active {
        color: var(--dark-green);
        background-color: var(--light-green);
        font-weight: 500;
        padding: 0.5em 0.75em;
        border-radius: 0.375rem;
    }
    
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
        font-weight: 500;
        padding: 0.5em 0.75em;
        border-radius: 0.375rem;
    }
</style>
@endsection

@section('header', 'Supplier Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Suppliers List</h5>
        <a href="{{ route('supplier_management.create') }}" class="btn btn-primary btn-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
            Add New Supplier
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
            <form id="filterForm" class="row g-3" action="{{ route('supplier_management.index') }}" method="GET">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control search-input" 
                               id="searchInput" 
                               name="search" 
                               placeholder="Search by name, contact, email, phone or address..."
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
                        <select class="form-select" id="statusFilter" name="status" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->anyFilled(['search', 'status']))
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <span class="me-2">Active Filters:</span>
                    @if(request('search'))
                        <span class="badge bg-info me-2">
                            Search: {{ request('search') }}
                        </span>
                    @endif
                    @if(request('status'))
                        <span class="badge bg-info me-2">
                            Status: {{ ucfirst(request('status')) }}
                        </span>
                    @endif
                    <a href="{{ route('supplier_management.index') }}" class="btn btn-sm btn-outline-secondary">
                        Clear All Filters
                    </a>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td class="text-start"><strong>{{ $supplier->name }}</strong></td>
                            <td>{{ $supplier->contact_person }}</td>
                            <td>{{ $supplier->email }}</td>
                            <td>{{ $supplier->phone }}</td>
                            <td class="text-start">{{ $supplier->address }}</td>
                            <td>
                                <span class="status-{{ $supplier->status ?? 'active' }}">
                                    {{ ucfirst($supplier->status ?? 'active') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('supplier_management.edit', $supplier->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('supplier_management.destroy', $supplier->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Are you sure you want to delete this supplier?')" class="btn btn-sm btn-danger" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="var(--gray)" viewBox="0 0 16 16" class="mb-3">
                                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                                    </svg>
                                    <p class="text-gray mb-0">No suppliers found.</p>
                                    <p class="text-muted small">Try adjusting your search or filters.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            <div>
                <span class="text-muted">{{ $suppliers->links() }} </span>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
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

    // Handle status filter change
    statusFilter.addEventListener('change', submitForm);
});
</script>
@endsection