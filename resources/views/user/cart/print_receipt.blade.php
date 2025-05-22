<!DOCTYPE html>
<html>
<head>
    <title>Printable Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #fff; color: #222; }
        .receipt-box { max-width: 400px; margin: 30px auto; border: 1px solid #eee; padding: 24px; border-radius: 8px; }
        .receipt-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; text-align: center; }
        .table th, .table td { padding: 0.5rem; }
        .total-row { font-weight: bold; font-size: 1.1rem; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt-box">
        <div class="receipt-title">Order Receipt</div>
        <table class="table table-bordered mb-3">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>₱{{ number_format($item['price'], 2) }}</td>
                    <td>₱{{ number_format($item['total'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-2 d-flex justify-content-between">
            <span>Subtotal:</span>
            <span>₱{{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="mb-2 d-flex justify-content-between">
            <span>Tax (10%):</span>
            <span>₱{{ number_format($tax, 2) }}</span>
        </div>
        <div class="mb-3 d-flex justify-content-between total-row">
            <span>Total:</span>
            <span>₱{{ number_format($total, 2) }}</span>
        </div>
        <div class="text-center no-print">
            <button class="btn btn-primary" onclick="window.print()">Print Again</button>
            <button class="btn btn-secondary" onclick="window.close()">Close</button>
        </div>
    </div>
</body>
</html> 