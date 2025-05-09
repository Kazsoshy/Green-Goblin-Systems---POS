@extends('layouts.admindash')

@section('title', 'Edit Category')

@section('header', 'Edit Category')

@section('styles')
<style>
    .form-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #F5F7FA;
    }
    
    .form-title {
        color: #4B0082;
        font-weight: 600;
        margin-bottom: 0;
    }
    
    .form-subtitle {
        color: #6C757D;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .btn-back {
        color: #5E35B1;
        background-color: transparent;
        border: 1px solid #5E35B1;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background-color: #F5F7FA;
        color: #4B0082;
    }
    
    .btn-back i {
        margin-right: 8px;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 500;
    }
    
    .form-hint {
        display: block;
        font-size: 0.8rem;
        color: #6C757D;
        margin-top: 0.25rem;
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #9575CD;
        box-shadow: 0 0 0 0.2rem rgba(149, 117, 205, 0.25);
        outline: none;
    }
    
    .form-select {
        display: block;
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 8px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%235E35B1' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
        appearance: none;
    }
    
    .form-select:focus {
        border-color: #9575CD;
        box-shadow: 0 0 0 0.2rem rgba(149, 117, 205, 0.25);
        outline: none;
    }
    
    .btn-submit {
        background-color: #5E35B1;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(94, 53, 177, 0.2);
    }
    
    .btn-submit:hover {
        background-color: #4B0082;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(94, 53, 177, 0.3);
        color: white;
    }
    
    .btn-submit i {
        margin-right: 8px;
    }
    
    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
    }
    
    .btn-cancel {
        background-color: transparent;
        color: #6C757D;
        border: 1px solid #6C757D;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background-color: #F5F7FA;
        color: #333;
    }
    
    .category-icon {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .category-icon i {
        color: #5E35B1;
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }
    
    .validation-feedback {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        color: #dc3545;
    }
    
    /* Input with icon */
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .form-control {
        padding-left: 2.5rem;
    }
    
    .input-with-icon i {
        position: absolute;
        left: 0.85rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6C757D;
    }
    
    .input-with-icon .form-control:focus + i {
        color: #5E35B1;
    }
    
    /* Badge for current category */
    .category-badge {
        display: inline-block;
        background-color: #F5F7FA;
        color: #5E35B1;
        border: 1px solid #9575CD;
        border-radius: 4px;
        padding: 0.25rem 0.75rem;
        margin-left: 0.5rem;
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <div class="form-container">
                <div class="form-header">
                    <div>
                        <h3 class="form-title">Edit Category</h3>
                        <p class="form-subtitle">
                            Modify details for category <span class="category-badge">{{ $category->name }}</span>
                        </p>
                    </div>
                    <a href="{{ route('category_management.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
                </div>
                
                <div class="category-icon">
                    <i class="fas fa-edit"></i>
                    <div>Update the details for this category below</div>
                </div>

                <form action="{{ route('category_management.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">Category Name</label>
                        <div class="input-with-icon">
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            <i class="fas fa-tag"></i>
                        </div>
                        <span class="form-hint">Choose a descriptive name for this category</span>
                        @error('name')
                            <div class="validation-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_category_id" class="form-label">Parent Category</label>
                        <select id="parent_category_id" name="parent_category_id" class="form-select @error('parent_category_id') is-invalid @enderror">
                            <option value="">None (Top-Level Category)</option>
                            @foreach ($categories as $cat)
                                @if($cat->id != $category->id)
                                    <option value="{{ $cat->id }}" {{ old('parent_category_id', $category->parent_category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <span class="form-hint">Optional: Select a parent category if this is a subcategory</span>
                        @error('parent_category_id')
                            <div class="validation-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="action-buttons">
                        <a href="{{ route('category_management.index') }}" class="btn btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save"></i> Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection