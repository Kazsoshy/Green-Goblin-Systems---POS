@extends('layouts.app')

@section('title', 'New Sale')

@section('styles')
<style>
    .pos-container {
        min-height: calc(100vh - 100px);
    }

    .products-section {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 1.5rem;
        height: calc(100vh - 120px);
        overflow-y: auto;
    }

    .cart-section {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 1.5rem;
        height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
    }

    .product-card {
        border: 1px solid #eee;
        border-radius: 0.5rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .product-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .cart-items {
        flex-grow: 1;
        overflow-y: auto;
    }

    .cart-item {
        border-bottom: 1px solid #eee;
        padding: 0.75rem 0;
    }

    .cart-total {
        border-top: 2px solid #5E35B1;
        padding-top: 1rem;
        margin-top: auto;
    }

    .btn-checkout {
        background-color: #5E35B1;
        color: white;
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 500;
        border-radius: 0.5rem;
    }

    .btn-checkout:hover {
        background-color: #4527A0;
        color: white;
    }

    .search-box {
        position: sticky;
        top: 0;
        background: white;
        padding: 1rem 0;
        z-index: 1000;
    }

    .category-filter {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding: 0.5rem 0;
        margin-bottom: 1rem;
    }

    .category-badge {
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        background-color: #f0f0f0;
        cursor: pointer;
        white-space: nowrap;
    }

    .category-badge.active {
        background-color: #5E35B1;
        color: white;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row pos-container">
        <!-- Products Section -->
        <div class="col-lg-8">
            <div class="products-section">
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Search products..." id="searchProduct">
                    
                    <div class="category-filter">
                        <span class="category-badge active" data-category="all">All</span>
                        @foreach($categories as $category)
                            <span class="category-badge" data-category="{{ $category->id }}">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="row g-3" id="productsGrid">
                    @foreach($products as $product)
                        <div class="col-md-3 product-item" data-category="{{ $product->category_id }}">
                            <div class="product-card" onclick="addToCart({{ $product->id }})">
                                <h6 class="mb-2">{{ $product->name }}</h6>
                                <p class="text-muted mb-2">Stock: {{ $product->stock_quantity }}</p>
                                <p class="mb-0 fw-bold">₱{{ number_format($product->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Cart Section -->
        <div class="col-lg-4">
            <div class="cart-section">
                <h4 class="mb-4">Current Sale</h4>
                
                <div class="cart-items" id="cartItems">
                    <!-- Cart items will be dynamically added here -->
                </div>

                <div class="cart-total">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">₱0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Total:</span>
                        <span class="h5 mb-0" id="total">₱0.00</span>
                    </div>

                    <select class="form-select mb-3" id="paymentMethod">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                    </select>

                    <button class="btn btn-checkout" onclick="processCheckout()">
                        Complete Sale
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3"></div>
                <p class="mb-0">Processing sale...</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let cart = [];
const products = @json($products);

function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    if (!product) return;

    const existingItem = cart.find(item => item.product_id === productId);
    if (existingItem) {
        if (existingItem.quantity >= product.stock_quantity) {
            alert('Not enough stock!');
            return;
        }
        existingItem.quantity++;
    } else {
        if (product.stock_quantity < 1) {
            alert('Product out of stock!');
            return;
        }
        cart.push({
            product_id: product.id,
            name: product.name,
            price: product.price,
            quantity: 1,
            discount: 0
        });
    }
    updateCartDisplay();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function updateQuantity(index, delta) {
    const item = cart[index];
    const product = products.find(p => p.id === item.product_id);
    
    const newQuantity = item.quantity + delta;
    if (newQuantity < 1 || newQuantity > product.stock_quantity) return;
    
    item.quantity = newQuantity;
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartContainer = document.getElementById('cartItems');
    cartContainer.innerHTML = '';

    let subtotal = 0;

    cart.forEach((item, index) => {
        const itemTotal = (item.price * item.quantity) - item.discount;
        subtotal += itemTotal;

        cartContainer.innerHTML += `
            <div class="cart-item">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="mb-0">${item.name}</h6>
                    <button class="btn btn-sm btn-link text-danger" onclick="removeFromCart(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                        <button class="btn btn-outline-secondary" disabled>${item.quantity}</button>
                        <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    <span>₱${itemTotal.toFixed(2)}</span>
                </div>
            </div>
        `;
    });

    document.getElementById('subtotal').textContent = `₱${subtotal.toFixed(2)}`;
    document.getElementById('total').textContent = `₱${subtotal.toFixed(2)}`;
}

function processCheckout() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }

    const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
    loadingModal.show();

    fetch('/sales', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            items: cart,
            payment_method: document.getElementById('paymentMethod').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect_url;
        } else {
            alert(data.message || 'Error processing sale');
        }
    })
    .catch(error => {
        alert('Error processing sale');
        console.error(error);
    })
    .finally(() => {
        loadingModal.hide();
    });
}

// Search and filter functionality
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    filterProducts(search, getCurrentCategory());
});

document.querySelectorAll('.category-badge').forEach(badge => {
    badge.addEventListener('click', function() {
        document.querySelectorAll('.category-badge').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        filterProducts(document.getElementById('searchProduct').value.toLowerCase(), this.dataset.category);
    });
});

function getCurrentCategory() {
    return document.querySelector('.category-badge.active').dataset.category;
}

function filterProducts(search, category) {
    document.querySelectorAll('.product-item').forEach(item => {
        const productCard = item.querySelector('.product-card');
        const product = products.find(p => p.id === parseInt(productCard.dataset.productId));
        const matchesSearch = product.name.toLowerCase().includes(search);
        const matchesCategory = category === 'all' || product.category_id === parseInt(category);
        
        item.style.display = matchesSearch && matchesCategory ? 'block' : 'none';
    });
}
</script>
@endsection 