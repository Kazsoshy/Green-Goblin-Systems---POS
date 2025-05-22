<div>
    <h4 class="mb-4 d-flex justify-content-between align-items-center">
        Order Receipt
        @if(session('cart') && count(session('cart')) > 0)
            <button class="btn btn-outline-danger btn-sm" onclick="clearCart()">
                <i class="fas fa-trash"></i>
            </button>
        @endif
    </h4>
    <div id="cart-items">
        @if(session('cart') && count(session('cart')) > 0)
            @php $subtotal = 0; @endphp
            @foreach(session('cart') as $productId => $item)
                @php $product = \App\Models\Product::find($productId); @endphp
                @if($product)
                    <div class="d-flex justify-content-between align-items-center mb-2" id="cart-item-{{ $product->id }}">
                        <div>
                            <div>{{ $product->name }}</div>
                            <div class="input-group input-group-sm mt-1" style="max-width: 120px;">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $product->id }}, -1)">-</button>
                                <input type="number" class="form-control text-center" value="{{ $item['quantity'] }}" min="1" onchange="updateQuantity({{ $product->id }}, 0, this.value)">
                                <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $product->id }}, 1)">+</button>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-end">
                            <div>₱{{ number_format($product->price * $item['quantity'], 2) }}</div>
                            <button class="btn btn-link text-danger p-0 mt-1" onclick="removeItem({{ $product->id }})" title="Remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    @php $subtotal += $product->price * $item['quantity']; @endphp
                @endif
            @endforeach
        @else
            <div class="text-muted">No items in cart.</div>
        @endif
    </div>
</div>
<div>
    @php
        $tax = isset($subtotal) ? $subtotal * 0.10 : 0;
        $total = isset($subtotal) ? $subtotal + $tax : 0;
    @endphp
    <div class="d-flex justify-content-between">
        <span>Subtotal</span>
        <span>₱{{ number_format($subtotal ?? 0, 2) }}</span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Tax (10%)</span>
        <span>₱{{ number_format($tax, 2) }}</span>
    </div>
    <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
        <span>Total</span>
        <span>₱{{ number_format($total, 2) }}</span>
    </div>
    <button class="btn btn-primary w-100 mt-3" onclick="showPaymentModal()">Process Payment</button>
</div>

<script>
function updateQuantity(productId, delta, newValue = null) {
    let quantity;
    if (newValue !== undefined && newValue !== null) {
        quantity = parseInt(newValue);
    } else {
        const input = document.querySelector(`#cart-item-${productId} input`);
        quantity = parseInt(input.value) + delta;
    }
    if (quantity < 1) return;
    fetch(`/cart/update/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            refreshOrderReceipt();
        } else {
            alert(data.message);
        }
    });
}

function removeItem(productId) {
    if (!confirm('Remove this item from the cart?')) return;
    fetch(`/cart/remove/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            refreshOrderReceipt();
        }
    });
}

function clearCart() {
    if (!confirm('Clear all items from the cart?')) return;
    fetch('/cart/clear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            refreshOrderReceipt();
        }
    });
}

function refreshOrderReceipt() {
    fetch(`{{ route('cart.receipt') }}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('order-receipt-panel').innerHTML = html;
        });
}
</script> 