@include('partials.header')
@extends('layouts.pos')

@section('products-grid')
    <div class="mb-4 px-4 pt-4">
        <div class="flex space-x-4">
            <button onclick="showProducts()" class="px-6 py-2 bg-blue-600 text-white rounded-lg" id="productsTab">Products</button>
            <button onclick="showServices()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg" id="servicesTab">Services</button>
        </div>
    </div>

    <div id="productsGrid" class="px-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow p-3 cursor-pointer hover:shadow-md transition-shadow product-item"
             data-product-id="{{ $product->id }}"
             data-product-name="{{ strtolower($product->name) }}"
             data-product-category="{{ strtolower($product->category->name) }}"
             data-stock="{{ $product->stock_quantity }}"
             onclick="addToCart({{ $product->id }}, 'product', {{ $product->stock_quantity }})">
            <div class="aspect-square bg-gray-100 rounded-lg mb-3">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover rounded-lg">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        No Image
                    </div>
                @endif
            </div>
            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $product->name }}</h3>
            <div class="flex justify-between items-center mt-2">
                <span class="text-gray-600 text-xs">{{ $product->category->name }}</span>
                <span class="text-gray-600 text-xs">Stock: {{ $product->stock_quantity }}</span>
            </div>
            <p class="text-blue-600 font-bold mt-2 text-right">₱{{ number_format($product->price, 2) }}</p>
        </div>
        @endforeach
    </div>

    <div id="servicesGrid" class="hidden px-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($services as $service)
        <div class="bg-white rounded-lg shadow p-3 cursor-pointer hover:shadow-md transition-shadow service-item"
             data-service-id="{{ $service->service_id }}"
             data-service-name="{{ strtolower($service->service_type) }}"
             onclick="addToCart({{ $service->service_id }}, 'service')">
            <div class="aspect-square bg-gray-100 rounded-lg mb-3 flex items-center justify-center">
                <i class="fas fa-briefcase text-4xl text-gray-400"></i>
            </div>
            <h3 class="font-semibold text-gray-800 text-sm truncate">{{ $service->service_type }}</h3>
            <p class="text-gray-600 text-xs truncate mt-2">{{ $service->description }}</p>
            <p class="text-blue-600 font-bold mt-2 text-right">₱{{ number_format($service->price, 2) }}</p>
        </div>
        @endforeach
    </div>
@endsection

@section('order-items')
    <div id="cart-items" class="flex flex-col space-y-3">
        <!-- Cart items will be dynamically inserted here -->
    </div>
@endsection

@section('order-summary')
    <div class="space-y-3">
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
const taxRate = 0.1;

function showProducts() {
    document.getElementById('productsGrid').classList.remove('hidden');
    document.getElementById('servicesGrid').classList.add('hidden');
    document.getElementById('productsTab').classList.remove('bg-gray-200', 'text-gray-700');
    document.getElementById('productsTab').classList.add('bg-blue-600', 'text-white');
    document.getElementById('servicesTab').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('servicesTab').classList.add('bg-gray-200', 'text-gray-700');
}

function showServices() {
    document.getElementById('productsGrid').classList.add('hidden');
    document.getElementById('servicesGrid').classList.remove('hidden');
    document.getElementById('servicesTab').classList.remove('bg-gray-200', 'text-gray-700');
    document.getElementById('servicesTab').classList.add('bg-blue-600', 'text-white');
    document.getElementById('productsTab').classList.remove('bg-blue-600', 'text-white');
    document.getElementById('productsTab').classList.add('bg-gray-200', 'text-gray-700');
}

document.getElementById('searchProduct').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const products = document.querySelectorAll('.product-item');
    const services = document.querySelectorAll('.service-item');
    
    products.forEach(product => {
        const name = product.getAttribute('data-product-name');
        const category = product.getAttribute('data-product-category');
        
        if (name.includes(searchTerm) || category.includes(searchTerm)) {
            product.style.display = '';
        } else {
            product.style.display = 'none';
        }
    });

    services.forEach(service => {
        const name = service.getAttribute('data-service-name');
        
        if (name.includes(searchTerm)) {
            service.style.display = '';
        } else {
            service.style.display = 'none';
        }
    });
});

function addToCart(id, type, stock = null) {
    if (type === 'product') {
        const existingItem = cart.find(item => item.id === id && item.type === 'product');
        if (existingItem && existingItem.quantity >= stock) {
            alert('Cannot add more items. Stock limit reached.');
            return;
        }

        fetch(`/api/products/${id}`)
            .then(response => response.json())
            .then(product => {
                const existingItem = cart.find(item => item.id === product.id && item.type === 'product');
                if (existingItem) {
                    if (existingItem.quantity < stock) {
                        existingItem.quantity += 1;
                        updateCartDisplay();
                    }
                } else {
                    cart.push({
                        id: product.id,
                        type: 'product',
                        name: product.name,
                        price: product.price,
                        quantity: 1,
                        stock: stock
                    });
                    updateCartDisplay();
                }
            });
    } else {
        fetch(`/api/services/${id}`)
            .then(response => response.json())
            .then(service => {
                const existingItem = cart.find(item => item.id === service.id && item.type === 'service');
                if (existingItem) {
                    existingItem.quantity += 1;
                    updateCartDisplay();
                } else {
                    cart.push({
                        id: service.id,
                        type: 'service',
                        name: service.name,
                        price: service.price,
                        quantity: 1
                    });
                    updateCartDisplay();
                }
            })
            .catch(error => {
                console.error('Error fetching service:', error);
                alert('Error adding service to cart');
            });
    }
}

function updateCartDisplay() {
    const cartContainer = document.getElementById('cart-items');
    cartContainer.innerHTML = cart.map(item => `
        <div class="bg-white p-3 rounded-lg shadow-sm">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="font-semibold text-gray-800">${item.name}</h4>
                    <span class="text-xs text-gray-500">${item.type}</span>
                </div>
                <button onclick="removeItem(${item.id})" 
                        class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="flex justify-between items-center mt-2">
                <div class="flex items-center space-x-3">
                    <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})" 
                            class="text-gray-500 hover:text-gray-700">-</button>
                    <span class="text-gray-800">${item.quantity}</span>
                    <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})"
                            class="text-gray-500 hover:text-gray-700 ${item.type === 'product' && item.quantity >= item.stock ? 'opacity-50 cursor-not-allowed' : ''}"
                            ${item.type === 'product' && item.quantity >= item.stock ? 'disabled' : ''}>+</button>
                </div>
                <p class="font-bold text-blue-600">₱${(item.price * item.quantity).toFixed(2)}</p>
            </div>
        </div>
    `).join('');
    
    updateTotals();
}

function updateQuantity(id, newQuantity) {
    const item = cart.find(item => item.id === id);
    if (!item) return;

    if (newQuantity <= 0) {
        removeItem(id);
        return;
    }

    if (item.type === 'product' && newQuantity > item.stock) {
        alert('Cannot add more items. Stock limit reached.');
        return;
    }
    
    item.quantity = newQuantity;
    updateCartDisplay();
}

function removeItem(id) {
    cart = cart.filter(item => item.id !== id);
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