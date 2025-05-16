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

                        <div class="customer-details mb-4">
                            <h5 class="mb-3">Customer Details</h5>
                            <div class="mb-3">
                                <label for="purchaseType" class="form-label">Purchase Type</label>
                                <select class="form-select" id="purchaseType" onchange="toggleDeliveryFields()">
                                    <option value="walk-in">Walk-in Purchase</option>
                                    <option value="delivery">Delivery</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="customerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="customerPhone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="customerPhone">
                            </div>
                            <div class="mb-3">
                                <label for="customerEmail" class="form-label">Email (Optional)</label>
                                <input type="email" class="form-control" id="customerEmail">
                            </div>
                            <div id="deliveryFields" style="display: none;">
                                <div class="mb-3">
                                    <label for="customerAddress" class="form-label">Delivery Address</label>
                                    <textarea class="form-control" id="customerAddress" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" id="notes" rows="2" placeholder="Special instructions or notes"></textarea>
                            </div>
                        </div>

                        <div class="payment-details">
                            <h5 class="mb-3">Payment Details</h5>
                            <select class="form-select mb-3" id="paymentMethod">
                                <option value="cash">Cash Payment</option>
                                <option value="card">Card Payment</option>
                            </select>
                        </div>

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

    $.ajax({
        url: `/cart/update/${productId}`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { quantity: quantity },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            alert(response?.message || 'Error updating cart');
        }
    });
}

function removeItem(productId) {
    if (!confirm('Are you sure you want to remove this item?')) return;

    $.ajax({
        url: `/cart/remove/${productId}`,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Error removing item from cart');
        }
    });
}

function clearCart() {
    if (!confirm('Are you sure you want to clear your cart?')) return;

    $.ajax({
        url: '/cart/clear',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Error clearing cart');
        }
    });
}

function toggleDeliveryFields() {
    const purchaseType = document.getElementById('purchaseType').value;
    const deliveryFields = document.getElementById('deliveryFields');
    const addressField = document.getElementById('customerAddress');
    
    if (purchaseType === 'delivery') {
        deliveryFields.style.display = 'block';
        addressField.required = true;
    } else {
        deliveryFields.style.display = 'none';
        addressField.required = false;
    }
}

function checkout() {
    const purchaseType = document.getElementById('purchaseType').value;
    const customerName = document.getElementById('customerName').value;
    
    if (!customerName) {
        alert('Please enter customer name');
        return;
    }

    if (purchaseType === 'delivery') {
        const address = document.getElementById('customerAddress').value;
        if (!address) {
            alert('Please enter delivery address');
            return;
        }
    }

    const customerData = {
        name: customerName,
        phone: document.getElementById('customerPhone').value,
        email: document.getElementById('customerEmail').value,
        address: document.getElementById('customerAddress').value,
        notes: document.getElementById('notes').value
    };

    const paymentMethod = document.getElementById('paymentMethod').value;
    
    $.ajax({
        url: '{{ route("checkout.store") }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            payment_method: paymentMethod,
            purchase_type: purchaseType,
            customer_details: customerData
        },
        success: function(response) {
            if (response.success) {
                showToast('Order placed successfully!');
                setTimeout(() => {
                    window.location.href = response.redirect_url;
                }, 1500);
            } else {
                alert(response.message || 'Error processing checkout');
            }
        },
        error: function(xhr) {
            const response = xhr.responseJSON;
            alert('Error: ' + (response?.message || 'Could not process checkout'));
        }
    });
}
</script>
@endsection 