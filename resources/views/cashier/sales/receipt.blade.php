@extends('layouts.userdash')

@section('title', 'Sale Receipt')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <div class="text-center mb-4">
                <h2>Sale Receipt</h2>
                <p class="mb-1">Receipt #: {{ $sale->receipt_number }}</p>
                <p class="mb-1">Date: {{ $sale->sale_date->format('M d, Y h:i A') }}</p>
            </div>

            <div class="table-responsive mb-4">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">₱{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">₱{{ number_format($item->quantity * $item->unit_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="text-end"><strong>₱{{ number_format($sale->total_amount, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h5>Payment Information</h5>
                    <p class="mb-1">Method: {{ ucfirst($sale->payment_method) }}</p>
                    @foreach($sale->payments as $payment)
                    <p class="mb-1">Reference #: {{ $payment->reference_number }}</p>
                    <p class="mb-1">Status: {{ ucfirst($payment->status) }}</p>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-primary me-2" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Receipt
                </button>
                <a href="{{ route('user.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    @media print {
        .sidebar, .navbar, .btn {
            display: none !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .container {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }
</style>
@endsection
@endsection 