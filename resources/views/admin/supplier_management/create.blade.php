@extends('layouts.admindash')

@section('title', 'Add New Supplier')

@section('header', 'Add New Supplier')

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

    .btn-submit {
        background-color: #2E7D32;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(46, 125, 50, 0.2);
    }

    .btn-submit:hover {
        background-color: #1B5E20;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(46, 125, 50, 0.3);
        color: white;
    }

    .btn-submit i {
        margin-right: 8px;
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

    .action-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
    }

    .supplier-icon {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }

    .supplier-icon i {
        color: #5E35B1;
        font-size: 1.5rem;
        margin-right: 0.75rem;
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
                        <h3 class="form-title">Add New Supplier</h3>
                        <p class="form-subtitle">Enter the supplier details to register a new vendor</p>
                    </div>
                    <a href="{{ route('supplier_management.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Back to Suppliers
                    </a>
                </div>

                <div class="supplier-icon">
                    <i class="fas fa-truck-loading"></i>
                    <div>Provide complete information for the new supplier</div>
                </div>

                <form action="{{ route('supplier_management.store') }}" method="POST">
                    @csrf

                    @include('admin.supplier_management.form')

                    <div class="action-buttons">
                        <a href="{{ route('supplier_management.index') }}" class="btn btn-cancel">Cancel</a>
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-check"></i> Save Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
