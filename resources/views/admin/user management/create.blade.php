@extends('layouts.admindash')

@section('title', 'Create User')

@section('header', 'Create User')

@section('styles')
<style>
    .form-card {
        background-color: white;
        border-radius: 1rem;
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #4B0082;
    }

    .form-subtitle {
        color: #6C757D;
        font-size: 0.9rem;
    }

    .form-label {
        font-weight: 600;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background-color: transparent;
        color: #6C757D;
        border: 1px solid #6C757D;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #f8f9fa;
        color: #343a40;
    }

    .user-icon {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .user-icon i {
        color: #5E35B1;
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }
</style>
@endsection

@section('content')
<div class="form-card">
    <div class="user-icon">
        <i class="fas fa-user-plus"></i>
        <div>
            <h4 class="form-title mb-0">Create New User</h4>
            <div class="form-subtitle">Fill in the form below to register a new system user</div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-cancel">Cancel</a>
            <button type="submit" class="btn btn-submit">
                <i class="fas fa-check-circle me-1"></i> Create User
            </button>
        </div>
    </form>
</div>
@endsection
