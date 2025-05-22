@include('partials.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row min-h-screen">
            <!-- Main Content Area (75%) -->
            <div class="lg:w-3/4 h-full flex flex-col">
                <!-- Page Header with Progress Bar -->
                <div class="bg-white border-b border-gray-200 py-4 px-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-bold text-gray-800">Complete Your Order</h1>
                        <div class="text-sm text-gray-500">
                            <span class="font-medium">Step 2 of 2</span> - Checkout
                        </div>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-6">
                    <div class="grid md:grid-cols-5 gap-8">
                        <!-- Left Column - 3/5 width for customer details -->
                        <div class="md:col-span-3 space-y-6">
                            <!-- Customer Details Card -->
                            <div class="bg-white rounded-lg shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Customer Information</h2>

                                <div class="grid grid-cols-2 gap-5">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="customerName"
                                            class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                        <input type="text" id="customerName" name="customerName"
                                            placeholder="Enter your name"
                                            class="w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                            Number</label>
                                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
                                            class="w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div class="col-span-2">
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                            Address</label>
                                        <input type="email" id="email" name="email"
                                            placeholder="Enter your email address"
                                            class="w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Options Card -->
                            <div class="bg-white rounded-lg shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Delivery Information</h2>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Delivery
                                        Address</label>
                                    <textarea id="address" name="address" rows="3"
                                        placeholder="Enter your complete address for delivery"
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>

                                <div class="mt-4">
                                    <label for="specialNote"
                                        class="block text-sm font-medium text-gray-700 mb-1">Special Instructions
                                        (Optional)</label>
                                    <textarea id="specialNote" name="specialNote" rows="2"
                                        placeholder="Add any special notes or delivery instructions"
                                        class="w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>
                            </div>

                            <!-- Payment Method Card -->
                            <div class="bg-white rounded-lg shadow-sm p-6">
                                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Payment Method</h2>

                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label
                                            class="payment-method-option block bg-white border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" id="cash" name="paymentMethod" value="cash"
                                                class="sr-only" checked>
                                            <div class="text-center">
                                                <div
                                                    class="bg-blue-100 text-blue-600 h-10 w-10 rounded-full mx-auto mb-2 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <span class="block font-medium text-gray-800">Cash</span>
                                                <span class="text-xs text-gray-500">Pay at delivery</span>
                                            </div>
                                        </label>
                                    </div>

                                    <div>
                                        <label
                                            class="payment-method-option block bg-white border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" id="ewallet" name="paymentMethod" value="ewallet"
                                                class="sr-only">
                                            <div class="text-center">
                                                <div
                                                    class="bg-blue-100 text-blue-600 h-10 w-10 rounded-full mx-auto mb-2 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <span class="block font-medium text-gray-800">E-Wallet</span>
                                                <span class="text-xs text-gray-500">GCash, PayMaya</span>
                                            </div>
                                        </label>
                                    </div>

                                    <div>
                                        <label
                                            class="payment-method-option block bg-white border border-gray-200 rounded-lg p-3 cursor-pointer hover:bg-gray-50 transition-colors">
                                            <input type="radio" id="card" name="paymentMethod" value="card"
                                                class="sr-only">
                                            <div class="text-center">
                                                <div
                                                    class="bg-blue-100 text-blue-600 h-10 w-10 rounded-full mx-auto mb-2 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                </div>
                                                <span class="block font-medium text-gray-800">Card</span>
                                                <span class="text-xs text-gray-500">Credit/Debit</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - 2/5 width for order summary -->
                        <div class="md:col-span-2">
                            <div class="bg-white rounded-lg shadow-sm sticky top-6">
                                <!-- Order Summary Header -->
                                <div class="bg-gray-800 text-white py-4 px-6 rounded-t-lg">
                                    <h2 class="text-xl font-bold">Order Summary</h2>
                                    <p class="text-gray-300 text-sm mt-1" id="order-count"></p>
                                </div>

                                <!-- Order Items List -->
                                <div class="max-h-48 overflow-y-auto p-4 border-b border-gray-200"
                                    id="order-items-list">
                                    <!-- Items will be dynamically inserted here -->
                                </div>

                                <!-- Order Totals -->
                                <div class="p-6">
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-medium text-gray-800" id="checkout-subtotal">₱0.00</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Tax (10%)</span>
                                            <span class="text-gray-800" id="checkout-tax">₱0.00</span>
                                        </div>

                                    </div>

                                    <div class="border-t border-gray-200 mt-4 pt-4">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-gray-800">Total</span>
                                            <span class="text-xl font-bold text-gray-800"
                                                id="checkout-total">₱0.00</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="mt-6 grid grid-cols-2 gap-3">
                                        <button type="button" id="cancelOrder"
                                            class="text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium rounded-md py-3 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                            Back to Cart
                                        </button>
                                        <button type="button" id="confirmOrder"
                                            class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-md py-3 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                            Place Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let cart = [];

    // Store URL parameters if any cart data is passed
    function getUrlParameter(name) {
        name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Safely format a price with 2 decimal places
    function formatPrice(price) {
        // Convert to number and fix to 2 decimal places
        const numPrice = parseFloat(price);
        if (isNaN(numPrice)) {
            console.warn('Invalid price found:', price);
            return '0.00'; // Default to 0 if price is invalid
        }
        return numPrice.toFixed(2);
    }

    // Safely calculate total for an item
    function calculateItemTotal(item) {
        const price = parseFloat(item.price || 0);
        const quantity = parseInt(item.quantity || 0, 10);
        return (price * quantity).toFixed(2);
    }

    // Validate and fix cart data
    function validateCart(cartData) {
        if (!Array.isArray(cartData)) {
            console.warn('Cart is not an array, resetting to empty array');
            return [];
        }

        return cartData.map(item => {
            // Ensure item has correct structure
            if (!item || typeof item !== 'object') {
                console.warn('Invalid item found in cart:', item);
                return null;
            }

            // Make sure price is a number
            if (item.price !== undefined) {
                item.price = parseFloat(item.price);
                if (isNaN(item.price)) {
                    console.warn('Invalid price for item:', item);
                    item.price = 0;
                }
            } else {
                console.warn('Item missing price:', item);
                item.price = 0;
            }

            // Make sure quantity is a number
            if (item.quantity !== undefined) {
                item.quantity = parseInt(item.quantity, 10);
                if (isNaN(item.quantity)) {
                    console.warn('Invalid quantity for item:', item);
                    item.quantity = 1;
                }
            } else {
                console.warn('Item missing quantity:', item);
                item.quantity = 1;
            }

            return item;
        }).filter(item => item !== null); // Remove any nulls
    }

    // For testing purposes - create a dummy cart if none exists
    function createDummyCart() {
        return [{
                id: 1,
                name: "Test Product 1",
                price: 100,
                quantity: 2
            },
            {
                id: 2,
                name: "Test Product 2",
                price: 50,
                quantity: 1
            }
        ];
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Checkout page loaded, checking cart data...');

        try {
            // First check localStorage instead of sessionStorage (more reliable between pages)
            const localCart = localStorage.getItem('pos_cart');
            console.log('Cart from localStorage:', localCart);

            // If not in localStorage, try sessionStorage
            const sessionCart = sessionStorage.getItem('cart');
            console.log('Cart from sessionStorage:', sessionCart);

            // Try to get the cart data from either source
            if (localCart) {
                const parsedCart = JSON.parse(localCart);
                cart = validateCart(parsedCart);
            } else if (sessionCart) {
                const parsedCart = JSON.parse(sessionCart);
                cart = validateCart(parsedCart);
            } else {
                console.log('No cart data found in storage');

                // For development/testing only - add dummy cart data
                // Comment this out in production
                cart = createDummyCart();
                console.log('Created dummy cart for testing');
            }

            console.log('Loaded and validated cart:', cart);

            // Display cart items
            updateOrderItemsList();
            updateOrderCount();
            updateTotals();

            // Setup payment method toggle behavior
            const paymentOptions = document.querySelectorAll('.payment-method-option');
            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    paymentOptions.forEach(opt => {
                        opt.classList.remove('border-blue-500', 'ring-2',
                            'ring-blue-500');
                    });

                    // Add selected class to clicked option
                    this.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');

                    // Check the radio inside this option
                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                    }
                });

                // Set initial selected state
                const radio = option.querySelector('input[type="radio"]');
                if (radio && radio.checked) {
                    option.classList.add('border-blue-500', 'ring-2', 'ring-blue-500');
                }
            });
        } catch (error) {
            console.error('Error loading cart:', error);
            alert('Could not load your cart. ' + error.message);
        }

        document.getElementById('cancelOrder').addEventListener('click', () => {
            if (confirm('Are you sure you want to go back to cart?')) {
                window.location.href = "{{ route('pos.index') }}";
            }
        });

        document.getElementById('confirmOrder').addEventListener('click', () => {
            processCheckout();
        });
    });

    function updateOrderCount() {
        if (!cart || cart.length === 0) {
            document.getElementById('order-count').textContent = "No items";
            return;
        }

        const itemCount = cart.reduce((total, item) => total + (parseInt(item.quantity) || 0), 0);
        const countText = itemCount === 1 ? '1 item' : `${itemCount} items`;
        document.getElementById('order-count').textContent = countText;
    }

    function updateOrderItemsList() {
        const orderList = document.getElementById('order-items-list');
        if (!orderList) {
            console.error('Order items list container not found');
            return;
        }

        orderList.innerHTML = '';

        console.log('Updating order items list with cart:', cart);

        if (!cart || cart.length === 0) {
            orderList.innerHTML = '<p class="text-gray-500 p-3 text-center">Your cart is empty</p>';
            return;
        }

        cart.forEach(item => {
            console.log('Processing item:', item);
            const itemElement = document.createElement('div');
            itemElement.className = 'flex items-start py-2 border-b border-gray-100';
            itemElement.innerHTML = `
            <div class="flex-1">
                <div class="font-medium text-gray-800">${item.name || 'Unknown Item'}</div>
                <div class="text-sm text-gray-500">₱${formatPrice(item.price)} × ${item.quantity}</div>
            </div>
            <div class="font-medium text-gray-800">₱${calculateItemTotal(item)}</div>
        `;
            orderList.appendChild(itemElement);
        });
    }

    function updateTotals() {
        console.log('Updating totals with cart:', cart);

        if (!cart || cart.length === 0) {
            // Update main summary
            document.getElementById('checkout-subtotal').textContent = '₱0.00';
            document.getElementById('checkout-tax').textContent = '₱0.00';
            document.getElementById('checkout-total').textContent = '₱0.00';
            return;
        }

        // Calculate subtotal
        const subtotal = cart.reduce((sum, item) => {
            const price = parseFloat(item.price || 0);
            const quantity = parseInt(item.quantity || 0, 10);
            return sum + (price * quantity);
        }, 0);

        console.log('Calculated subtotal:', subtotal);

        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        // Update main summary
        document.getElementById('checkout-subtotal').textContent = `₱${subtotal.toFixed(2)}`;
        document.getElementById('checkout-tax').textContent = `₱${tax.toFixed(2)}`;
        document.getElementById('checkout-total').textContent = `₱${total.toFixed(2)}`;
    }

    function processCheckout() {
        if (!cart || cart.length === 0) {
            alert('Your cart is empty. Please add items before checkout.');
            return;
        }

        const customerName = document.getElementById('customerName').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();
        const specialNote = document.getElementById('specialNote').value.trim();
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        if (!customerName || !email || !phone) {
            alert('Please fill in all customer details.');
            return;
        }

        // Calculate order total
        const subtotal = cart.reduce((sum, item) => {
            const price = parseFloat(item.price || 0);
            const quantity = parseInt(item.quantity || 0, 10);
            return sum + (price * quantity);
        }, 0);

        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        // Format data in the structure expected by the backend
        const orderData = {
            customer: {
                name: customerName,
                email: email,
                phone: phone,
                address: address,
                specialNote: specialNote,
                paymentMethod: paymentMethod
            },
            items: cart,
            total: total
        };

        // Log the data being sent
        console.log('Sending order data:', orderData);

        fetch("{{ route('pos.process-checkout') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(orderData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Order placed successfully!');
                    localStorage.removeItem('pos_cart');
                    sessionStorage.removeItem('cart');
                    window.location.href = "{{ route('pos.index') }}";
                } else {
                    alert('Error: ' + (data.message || 'Unable to process order.'));
                }
            })
            .catch(error => {
                console.error('Checkout error:', error);
                alert('An error occurred during checkout.');
            });
    }
    </script>
</body>

</html>