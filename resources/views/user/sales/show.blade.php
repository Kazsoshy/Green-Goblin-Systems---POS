@extends('layouts.userdash')

@section('title', 'Sale Details')

@section('header', 'Sale Details')

@section('styles')
<style>
    .sale-details-container {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
    }

    .info-group {
        margin-bottom: 2rem;
    }

    .info-group h5 {
        color: #5E35B1;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }

    .info-item {
        margin-bottom: 0.5rem;
    }

    .info-label {
        font-weight: 600;
        color: #495057;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
    }

    .status-completed {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .purchase-type-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.875rem;
    }

    .purchase-type-delivery {
        background-color: #cfe2ff;
        color: #084298;
    }

    .purchase-type-walkin {
        background-color: #e2e3e5;
        color: #41464b;
    }

    .items-table th {
        background-color: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('user.sales.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i>Back to Sales
        </a>
    </div>

    <div class="sale-details-container">
        <div class="row">
            <!-- Sale Information -->
            <div class="col-md-6">
                <div class="info-group">
                    <h5>Sale Information</h5>
                    <div class="info-item">
                        <span class="info-label">Receipt Number:</span>
                        <span>{{ $sale->receipt_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Date:</span>
                        <span>{{ $sale->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="status-badge {{ $sale->status === 'completed' ? 'status-completed' : 'status-pending' }}">
                            {{ ucfirst($sale->status) }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Purchase Type:</span>
                        <span class="purchase-type-badge {{ $sale->purchase_type === 'delivery' ? 'purchase-type-delivery' : 'purchase-type-walkin' }}">
                            {{ ucfirst($sale->purchase_type) }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment Method:</span>
                        <span>{{ ucfirst($sale->payment_method) }}</span>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-md-6">
                <div class="info-group">
                    <h5>Customer Information</h5>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span>{{ $sale->customer_name }}</span>
                    </div>
                    @if($sale->customer_phone)
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span>{{ $sale->customer_phone }}</span>
                    </div>
                    @endif
                    @if($sale->customer_email)
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span>{{ $sale->customer_email }}</span>
                    </div>
                    @endif
                    @if($sale->customer_address)
                    <div class="info-item">
                        <span class="info-label">Address:</span>
                        <span>{{ $sale->customer_address }}</span>
                    </div>
                    @endif
                    @if($sale->notes)
                    <div class="info-item">
                        <span class="info-label">Notes:</span>
                        <span>{{ $sale->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items -->
        <div class="info-group">
            <h5>Items</h5>
            <div class="table-responsive">
                <table class="table table-bordered items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₱{{ number_format($item->unit_price, 2) }}</td>
                            <td>₱{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>₱{{ number_format($sale->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 