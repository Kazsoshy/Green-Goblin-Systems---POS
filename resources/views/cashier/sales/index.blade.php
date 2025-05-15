@extends('layouts.app')

@section('title', 'Sales History')

@section('styles')
<style>
    .sales-container {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
    }

    .table thead th {
        background-color: #5E35B1;
        color: white;
        padding: 1rem;
        font-weight: 500;
    }

    .badge-completed {
        background-color: #A5D6A7;
        color: #2E7D32;
    }

    .badge-pending {
        background-color: #FFE082;
        color: #F57F17;
    }

    .badge-refunded {
        background-color: #EF9A9A;
        color: #C62828;
    }

    .btn-new-sale {
        background-color: #5E35B1;
        color: white;
        border-radius: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-new-sale:hover {
        background-color: #4527A0;
        color: white;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="sales-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Sales History</h2>
            <a href="{{ route('sales.create') }}" class="btn btn-new-sale">
                <i class="fas fa-plus-circle me-2"></i>New Sale
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Receipt #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->receipt_number }}</td>
                            <td>{{ $sale->sale_date->format('M d, Y H:i') }}</td>
                            <td>{{ $sale->items->count() }}</td>
                            <td>₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ ucfirst($sale->payment_method) }}</td>
                            <td>
                                <span class="badge badge-{{ $sale->status }}">
                                    {{ ucfirst($sale->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info text-white" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('sales.receipt', $sale) }}" class="btn btn-sm btn-secondary" title="Print Receipt">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    @if($sale->status === 'completed')
                                        <button type="button" class="btn btn-sm btn-danger" onclick="initiateRefund({{ $sale->id }})" title="Refund">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No sales records found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $sales->links() }}
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Refund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="refundForm" action="" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for Refund</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Process Refund</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function initiateRefund(saleId) {
    const modal = new bootstrap.Modal(document.getElementById('refundModal'));
    document.getElementById('refundForm').action = `/sales/${saleId}/refund`;
    modal.show();
}
</script>
@endsection 