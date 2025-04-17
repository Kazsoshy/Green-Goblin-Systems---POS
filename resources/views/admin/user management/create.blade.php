@extends('layouts.admindash')

@section('title', 'Create User')

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
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.05);
    }
    .form-label {
        font-weight: 600;
    }
</style>
@endsection

@section('header', 'Create User')

@section('content')
<div class="card p-4">
    <h3 class="mb-4 text-center text-primary">Create New User</h3>

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
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
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
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">Create User</button>
        </div>
    </form>
</div>
@endsection