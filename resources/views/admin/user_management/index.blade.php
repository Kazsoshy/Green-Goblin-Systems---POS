@extends('layouts.admindash')

@section('title', 'User Management')

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
        text-align: left;
        vertical-align: middle;
        border: none;
        position: relative;
    }
    
    .table tbody td {
        padding: 1rem;
        text-align: left;
        vertical-align: middle;
        border-color: #eaedf2;
        color: #333;
        font-size: 0.95rem;
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
        justify-content: flex-start;
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
        margin-bottom: 1.5rem;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
        border-radius: 0.375rem;
        font-size: 0.85rem;
    }
    
    .badge.bg-primary {
        background-color: var(--light-purple) !important;
        color: var(--indigo);
    }

    .user-name {
        font-weight: 500;
        color: #2d3748;
    }

    .user-email {
        color: #4a5568;
    }

    .table-header {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .created-date {
        color: #718096;
        font-size: 0.9rem;
    }

    .btn-sm {
        padding: 0.4rem 0.75rem;
    }

    .btn-sm i {
        font-size: 0.875rem;
    }

    .table-container {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection

@section('header', 'User Management')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Users List</h5>
        <a href="{{ route('user_management.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Add New User
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
            <form id="filterForm" class="row g-3" action="{{ route('user_management.index') }}" method="GET">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="searchInput" 
                               name="search" 
                               placeholder="Search by username, full name or email..."
                               value="{{ request('search') }}"
                               autocomplete="off">
                        @if(request('search'))
                            <button type="button" class="btn btn-outline-secondary" onclick="clearSearch()">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 mb-3 mb-md-0">
                    <select class="form-select" id="roleFilter" name="role">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="cashier" {{ request('role') == 'cashier' ? 'selected' : '' }}>Cashier</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="dateFilter" name="date_range">
                        <option value="">All Time</option>
                        <option value="today" {{ request('date_range') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="week" {{ request('date_range') == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ request('date_range') == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="year" {{ request('date_range') == 'year' ? 'selected' : '' }}>This Year</option>
                    </select>
                </div>
            </form>
        </div>

        @if(request()->anyFilled(['search', 'role', 'date_range']))
            <div class="mb-3">
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="me-2">Active Filters:</span>
                    @if(request('search'))
                        <span class="badge bg-info me-2">
                            Search: {{ request('search') }}
                        </span>
                    @endif
                    @if(request('role'))
                        <span class="badge bg-info me-2">
                            Role: {{ ucfirst(request('role')) }}
                        </span>
                    @endif
                    @if(request('date_range'))
                        <span class="badge bg-info me-2">
                            Date: {{ ucfirst(request('date_range')) }}
                        </span>
                    @endif
                    <a href="{{ route('user_management.index') }}" class="btn btn-sm btn-outline-secondary">
                        Clear All Filters
                    </a>
                </div>
            </div>
        @endif

        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="table-header">Username</th>
                            <th class="table-header">Full Name</th>
                            <th class="table-header">Email</th>
                            <th class="table-header">Role</th>
                            <th class="table-header">Created At</th>
                            <th class="table-header">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>
                                    <span class="user-name">{{ $user->username }}</span>
                                </td>
                                <td>
                                    <span class="user-name">{{ $user->full_name }}</span>
                                </td>
                                <td>
                                    <span class="user-email">{{ $user->email }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>
                                    <span class="created-date">{{ $user->created_at->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('user_management.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('user_management.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <span class="text-gray-500">No users found</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const dateFilter = document.getElementById('dateFilter');
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

    // Handle filter changes
    roleFilter.addEventListener('change', submitForm);
    dateFilter.addEventListener('change', submitForm);

    // Auto-hide alert after 5 seconds
    setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.display = 'none';
        }
    }, 5000);
});
</script>
@endsection 