@extends('layouts.admindash')

@section('title', 'Add New Service')

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
    
    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--light-purple);
        box-shadow: 0 0 0 0.2rem rgba(94, 53, 177, 0.25);
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
    
    .btn-secondary {
        background-color: var(--gray);
        border-color: var(--gray);
        border-radius: 0.5rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        transition: all 0.3s;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('header', 'Add New Service')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Add New Service</h5>
        <a href="{{ route('services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Services
        </a>
    </div>

    <div class="card-body">
        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="service_type" class="form-label">Service Type</label>
                <input type="text" class="form-control @error('service_type') is-invalid @enderror" 
                       id="service_type" name="service_type" value="{{ old('service_type') }}" required>
                @error('service_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                           id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 