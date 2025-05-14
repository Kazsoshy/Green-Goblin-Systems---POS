@extends('layouts.admindash')

@section('title', 'User Management')

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

@section('header', 'User Management')

@section('content')
<div class="card p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Add New User</a>
    </div>

    <form method="GET" action="{{ route('users.index') }}" id="filterForm">
    <div class="row mb-3">
        <div class="col-md-6 mb-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Search name, username, or email..."
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
        </div>

            <div class="col-md-6 mb-2">
                <select class="form-select" name="role" onchange="document.getElementById('filterForm').submit();">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        </div>
    </form>


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
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-primary">Admin</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>{{ $user->last_login }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($users->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">No users found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <p class="text-muted mb-3">
            Showing {{ $users->total() }} {{ Str::plural('user', $users->total()) }}
        </p>

    </div>
</div>
@endsection