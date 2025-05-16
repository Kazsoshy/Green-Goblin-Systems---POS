@extends('layouts.userdash')

@section('title', 'Sales History')

@section('header', 'Sales History')

@section('styles')
<style>
    .sales-container {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
    }

    .sale-item {
        transition: all 0.3s ease;
    }

    .sale-item:hover {
        background-color: #f8f9fa;
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

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
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
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="sales-container">
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-3">
                <input type="text" class="form-control" id="searchInput" placeholder="Search by receipt number...">
            </div>
            <div class="col-md-2">
                <select class="form-select" id="purchaseTypeFilter">
                    <option value="">All Purchase Types</option>
                    <option value="walk-in">Walk-in</option>
                    <option value="delivery">Delivery</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select" id="paymentMethodFilter">
                    <option value="">All Payment Methods</option>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" id="dateFilter">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" onclick="applyFilters()">
                    <i class="fas fa-filter me-2"></i>Filter
                </button>
            </div>
        </div>

        <!-- Sales Table -->
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Receipt #</th>
                        <th>Customer</th>
                        <th>Purchase Type</th>
                        <th>Payment Method</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr class="sale-item">
                        <td>{{ $sale->receipt_number }}</td>
                        <td>
                            {{ $sale->customer_name }}
                            @if($sale->customer_phone)
                                <br>
                                <small class="text-muted">{{ $sale->customer_phone }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="purchase-type-badge {{ $sale->purchase_type === 'delivery' ? 'purchase-type-delivery' : 'purchase-type-walkin' }}">
                                {{ ucfirst($sale->purchase_type) }}
                            </span>
                        </td>
                        <td>{{ ucfirst($sale->payment_method) }}</td>
                        <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            <span class="status-badge {{ $sale->status === 'completed' ? 'status-completed' : 'status-pending' }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('user.sales.show', $sale) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="h5 text-muted">No sales records found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function applyFilters() {
    const searchQuery = document.getElementById('searchInput').value;
    const purchaseType = document.getElementById('purchaseTypeFilter').value;
    const paymentMethod = document.getElementById('paymentMethodFilter').value;
    const date = document.getElementById('dateFilter').value;

    let url = new URL(window.location.href);
    url.searchParams.set('search', searchQuery);
    url.searchParams.set('purchase_type', purchaseType);
    url.searchParams.set('payment_method', paymentMethod);
    url.searchParams.set('date', date);

    window.location.href = url.toString();
}

// Initialize filters from URL params
document.addEventListener('DOMContentLoaded', function() {
    const url = new URL(window.location.href);
    document.getElementById('searchInput').value = url.searchParams.get('search') || '';
    document.getElementById('purchaseTypeFilter').value = url.searchParams.get('purchase_type') || '';
    document.getElementById('paymentMethodFilter').value = url.searchParams.get('payment_method') || '';
    document.getElementById('dateFilter').value = url.searchParams.get('date') || '';
});
</script>
@endsection 