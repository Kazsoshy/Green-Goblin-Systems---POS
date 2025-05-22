@extends('layouts.pos')

@section('products-grid')
    @foreach($products as $product)
    <div class="bg-white rounded-lg shadow p-2 cursor-pointer hover:shadow-lg transition-shadow product-item"
         data-product-id="{{ $product->id }}"
         data-product-name="{{ strtolower($product->name) }}"
         data-product-category="{{ strtolower($product->category->name) }}"
         data-stock="{{ $product->stock_quantity }}"
         onclick="addToCart({{ $product->id }}, {{ $product->stock_quantity }})">
        <div class="aspect-square bg-gray-200 rounded-lg mb-2">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover rounded-lg">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                    No Image
                </div>
            @endif
        </div>
        <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $product->name }}</h3>
        <div class="flex justify-between items-center mt-1">
            <span class="text-gray-600 text-xs">{{ $product->category->name }}</span>
            <span class="text-gray-600 text-xs">Stock: {{ $product->stock_quantity }}</span>
        </div>
        <p class="text-blue-600 font-bold mt-1 text-right text-sm">₱{{ number_format($product->price, 2) }}</p>
    </div>
    @endforeach
@endsection

@section('order-items')
    <div id="cart-items" class="flex flex-col space-y-2">
        <!-- Cart items will be dynamically inserted here -->
    </div>
@endsection

@section('order-summary')
    <div class="space-y-2">
        <div class="flex justify-between text-gray-600">
            <span>Subtotal</span>
            <span id="subtotal">₱0.00</span>
        </div>
        <div class="flex justify-between text-gray-600">
            <span>Tax (10%)</span>
            <span id="tax">₱0.00</span>
        </div>
        <div class="flex justify-between font-bold text-lg">
            <span>Total</span>
            <span id="total">₱0.00</span>
        </div>
        <button onclick="proceedToCheckout()" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
            Proceed to Checkout
        </button>
    </div>
@endsection

@push('scripts')
<script>
let cart = [];
const taxRate = 0.1; // Hardcoded 10% tax rate

// Add search functionality
document.getElementById('searchProduct').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const products = document.querySelectorAll('.product-item');
    
    products.forEach(product => {
        const name = product.getAttribute('data-product-name');
        const category = product.getAttribute('data-product-category');
        
        if (name.includes(searchTerm) || category.includes(searchTerm)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });
});

function addToCart(productId, stock) {
    // Check current quantity in cart
    const existingItem = cart.find(item => item.id === productId);
    if (existingItem && existingItem.quantity >= stock) {
        alert('Cannot add more items. Stock limit reached.');
        return;
    }

    fetch(`/api/products/${productId}`)
        .then(response => response.json())
        .then(product => {
            const existingItem = cart.find(item => item.id === product.id);
            if (existingItem) {
                if (existingItem.quantity < stock) {
                    existingItem.quantity += 1;
                    updateCartDisplay();
                }
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    stock: stock
                });
                updateCartDisplay();
            }
        });
}

function updateCartDisplay() {
    const cartContainer = document.getElementById('cart-items');
    cartContainer.innerHTML = cart.map(item => `
        <div class="flex justify-between items-center border-b pb-2">
            <div>
                <h4 class="font-semibold text-sm">${item.name}</h4>
                <div class="flex items-center space-x-2 mt-1">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" 
                            class="text-gray-500 hover:text-gray-700 text-sm">-</button>
                    <span class="text-sm">${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})"
                            class="text-gray-500 hover:text-gray-700 text-sm ${item.quantity >= item.stock ? 'opacity-50 cursor-not-allowed' : ''}"
                            ${item.quantity >= item.stock ? 'disabled' : ''}>+</button>
                </div>
            </div>
            <div class="text-right">
                <p class="font-semibold text-sm">₱${(item.price * item.quantity).toFixed(2)}</p>
                <button onclick="removeItem(${item.id})" 
                        class="text-red-500 text-xs hover:text-red-700">Remove</button>
            </div>
        </div>
    `).join('');
    
    updateTotals();
}

function updateQuantity(productId, newQuantity) {
    const item = cart.find(item => item.id === productId);
    if (!item) return;

    if (newQuantity <= 0) {
        removeItem(productId);
        return;
    }

    if (newQuantity > item.stock) {
        alert('Cannot add more items. Stock limit reached.');
        return;
    }
    
    item.quantity = newQuantity;
    updateCartDisplay();
}

function removeItem(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartDisplay();
}

function updateTotals() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * taxRate;
    const total = subtotal + tax;
    
    document.getElementById('subtotal').textContent = `₱${subtotal.toFixed(2)}`;
    document.getElementById('tax').textContent = `₱${tax.toFixed(2)}`;
    document.getElementById('total').textContent = `₱${total.toFixed(2)}`;
}

function proceedToCheckout() {
    if (cart.length === 0) {
        alert('Please add items to cart first');
        return;
    }
    
    // Save cart to sessionStorage
    sessionStorage.setItem('cart', JSON.stringify(cart));
    
    // Redirect to checkout page
    window.location.href = "{{ route('pos.checkout') }}";
}
</script>
@endpush 