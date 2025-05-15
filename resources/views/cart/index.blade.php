@extends('layouts.userdash')

@section('styles')
<style>
    .cart-container {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 2rem;
    }

    .cart-item {
        border-bottom: 1px solid #eee;
        padding: 1rem 0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .quantity-control {
        width: 120px;
    }

    .cart-total {
        border-top: 2px solid #5E35B1;
        margin-top: 2rem;
        padding-top: 1rem;
    }

    .btn-checkout {
        background-color: #5E35B1;
        color: white;
        padding: 1rem 2rem;
        font-size: 1.1rem;
        border-radius: 0.5rem;
    }

    .btn-checkout:hover {
        background-color: #4527A0;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="cart-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Shopping Cart</h2>
            @if(count($items) > 0)
            <button class="btn btn-outline-danger" onclick="clearCart()">
                <i class="fas fa-trash me-2"></i>Clear Cart
            </button>
            @endif
        </div>

        @if(count($items) > 0)
            <div class="cart-items">
                @foreach($items as $item)
                    <div class="cart-item" id="cart-item-{{ $item['id'] }}">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-1">{{ $item['name'] }}</h5>
                                <p class="text-muted mb-0">₱{{ number_format($item['price'], 2) }} each</p>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group quantity-control">
                                    <button class="btn btn-outline-secondary" type="button" 
                                            onclick="updateQuantity({{ $item['id'] }}, -1)">-</button>
                                    <input type="number" class="form-control text-center" 
                                           value="{{ $item['quantity'] }}" min="1"
                                           onchange="updateQuantity({{ $item['id'] }}, 0, this.value)">
                                    <button class="btn btn-outline-secondary" type="button"
                                            onclick="updateQuantity({{ $item['id'] }}, 1)">+</button>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="h5">₱{{ number_format($item['total'], 2) }}</span>
                            </div>
                            <div class="col-md-1 text-end">
                                <button class="btn btn-link text-danger" onclick="removeItem({{ $item['id'] }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="cart-total">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="h5">₱{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total:</span>
                            <span class="h4">₱{{ number_format($total, 2) }}</span>
                        </div>

                        <select class="form-select mb-3" id="paymentMethod">
                            <option value="cash">Cash Payment</option>
                            <option value="card">Card Payment</option>
                        </select>

                        <button class="btn btn-checkout w-100" onclick="checkout()">
                            <i class="fas fa-shopping-cart me-2"></i>Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h3>Your cart is empty</h3>
                <p class="text-muted">Add some items to your cart to proceed with checkout.</p>
                <a href="{{ route('user.products.index') }}" class="btn btn-primary">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Toast Notification -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastMessage"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showToast(message) {
    const toastEl = document.getElementById('cartToast');
    const toast = new bootstrap.Toast(toastEl);
    document.getElementById('toastMessage').textContent = message;
    toast.show();
}

function updateQuantity(productId, delta, newValue = null) {
    let quantity;
    if (newValue !== null) {
        quantity = parseInt(newValue);
    } else {
        const input = document.querySelector(`#cart-item-${productId} input`);
        quantity = parseInt(input.value) + delta;
    }

    if (quantity < 1) return;

    fetch(`/cart/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
}

function removeItem(productId) {
    if (!confirm('Are you sure you want to remove this item?')) return;

    fetch(`/cart/remove`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your cart?')) return;

    fetch(`/cart/clear`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function checkout() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    
    // Format cart items for the sales controller
    const items = @json($items).map(item => ({
        product_id: item.id,
        quantity: item.quantity,
        discount: 0
    }));

    $.ajax({
        url: '/sales',
        method: 'POST',
        data: JSON.stringify({
            items: items,
            payment_method: paymentMethod
        }),
        contentType: 'application/json',
        success: function(data) {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || 'Error processing checkout');
            }
        },
        error: function(xhr) {
            console.error('Error:', xhr);
            const response = xhr.responseJSON;
            alert('Error: ' + (response?.message || 'Could not process checkout'));
        }
    });
}
</script>
@endsection 