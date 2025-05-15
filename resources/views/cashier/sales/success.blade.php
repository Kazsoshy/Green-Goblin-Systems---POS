@extends('layouts.userdash')

@section('title', 'Order Success')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
        </div>
        <h1 class="mb-4">Order Successfully Paid!</h1>
        <p class="lead mb-4">Thank you for your purchase. Your order has been confirmed.</p>
        
        <div class="card mb-4 mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h5 class="card-title">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span>Receipt Number:</span>
                    <strong>{{ $sale->receipt_number }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Amount:</span>
                    <strong>₱{{ number_format($sale->total_amount, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Payment Method:</span>
                    <strong>{{ ucfirst($sale->payment_method) }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Date:</span>
                    <strong>{{ $sale->sale_date->format('M d, Y h:i A') }}</strong>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('sales.receipt', $sale->id) }}" class="btn btn-primary">
                <i class="fas fa-receipt me-2"></i>View Receipt
            </a>
            <a href="{{ route('user.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-shopping-cart me-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</div>

@section('styles')
<style>
    .text-success {
        color: var(--primary-green) !important;
    }
    .btn-primary {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
    }
    .btn-primary:hover {
        background-color: var(--dark-purple);
        border-color: var(--dark-purple);
    }
</style>
@endsection
@endsection 