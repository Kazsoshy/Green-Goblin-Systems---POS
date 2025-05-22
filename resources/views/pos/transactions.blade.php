@include('partials.header')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaction History - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 pt-24">
    <div class="container mx-auto px-4 pb-12">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Transaction History</h1>
            <div class="flex justify-between items-center">
                <p class="text-gray-600 mt-2">Orders from the past 30 days</p>
                <a href="{{ route('pos.sales-report') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Sales Report
                </a>
            </div>
            @php
            use Illuminate\Support\Facades\Auth;
            @endphp
        </div>

        <!-- Transaction Filters -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-8">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="flex-1">
                    <input type="text" id="searchTransactions" placeholder="Search transactions..."
                        class="w-full border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <input type="date" id="startDate"
                        class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <input type="date" id="endDate"
                        class="border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Transactions List -->
        <div class="space-y-6" id="transactions-container">
            @if($sales->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-700">No transactions found</h3>
                <p class="mt-2 text-gray-500">You haven't made any transactions in the last 30 days.</p>
                <div class="mt-6">
                    <a href="{{ route('pos.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Go to POS
                    </a>
                </div>
            </div>
            @else
            @foreach($sales as $sale)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden transaction-item border-2 border-gray-200 hover:border-blue-400 transition-colors"
                data-customer="{{ strtolower($sale->customer_name) }}" data-status="{{ strtolower($sale->status) }}"
                data-date="{{ $sale->created_at ? $sale->created_at->format('Y-m-d') : '' }}">
                <!-- Transaction Header -->
                <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex flex-wrap justify-between items-center">
                    <div>
                        <div class="flex items-center">
                            <h3 class="text-lg font-semibold text-gray-800">Order #{{ $sale->id }}</h3>
                            <span
                                class="ml-3 px-2 py-1 rounded-full text-xs font-medium 
                                                {{ $sale->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                                 ($sale->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $sale->created_at ? $sale->created_at->format('M d, Y h:i A') : 'No date' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-bold text-gray-800">₱{{ number_format($sale->total_amount, 2) }}</p>
                        <p class="text-sm text-gray-500">{{ ucfirst($sale->payment_method) }}</p>
                    </div>
                </div>

                <!-- Transaction Details (Collapsible) -->
                <div class="transaction-details px-6 py-4 hidden">
                    <!-- Customer Info -->
                    <div class="mb-4 pb-4 border-b border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">CUSTOMER INFORMATION</h4>
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="font-medium">{{ $sale->customer_name }}</p>
                            </div>
                            @if($sale->customer_email)
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $sale->customer_email }}</p>
                            </div>
                            @endif
                            @if($sale->customer_phone)
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium">{{ $sale->customer_phone }}</p>
                            </div>
                            @endif
                        </div>
                        @if($sale->customer_address)
                        <div class="mt-3">
                            <p class="text-sm text-gray-500">Delivery Address</p>
                            <p class="font-medium">{{ $sale->customer_address }}</p>
                        </div>
                        @endif
                        @if($sale->special_note)
                        <div class="mt-3">
                            <p class="text-sm text-gray-500">Special Notes</p>
                            <p class="font-medium">{{ $sale->special_note }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Order Items -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-2">ORDER ITEMS</h4>
                        <div class="space-y-2">
                            @foreach($sale->saleItems as $item)
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <div class="flex items-center">
                                    <span
                                        class="h-6 w-6 bg-blue-100 text-blue-800 flex items-center justify-center rounded-full text-xs font-medium mr-3">
                                        {{ $item->quantity }}
                                    </span>
                                    <span class="font-medium">{{ $item->product->name ?? 'Unknown Product' }}</span>
                                </div>
                                <span class="font-medium">
                                    ₱{{ number_format($item->quantity * ($item->product->price ?? 0), 2) }}
                                </span>

                            </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="mt-4 pt-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span>₱{{ number_format($sale->subtotal ?? collect($sale->saleItems)->sum(function($item) { 
                                    return ($item->quantity * ($item->product->price ?? 0)); 
                                }), 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-1">
                                <span class="text-gray-500">Tax (10%)</span>
                                <span>₱{{ number_format($sale->tax ?? (($sale->subtotal ?? collect($sale->saleItems)->sum(function($item) { 
                                    return ($item->quantity * ($item->product->price ?? 0)); 
                                })) * 0.1), 2) }}</span>
                            </div>
                            <div class="flex justify-between font-medium text-base mt-2 pt-2 border-t border-gray-200">
                                <span>Grand Total</span>
                                <span>₱{{ number_format($sale->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Footer -->
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex justify-between">
                    <button class="toggle-details text-sm text-blue-600 font-medium focus:outline-none">
                        Show Details
                    </button>
                    <form action="{{ route('pos.sales.destroy', $sale->id) }}" method="POST" class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="remove-transaction text-sm text-red-600 font-medium focus:outline-none">
                            Remove
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle transaction details
        const toggleButtons = document.querySelectorAll('.toggle-details');
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const details = this.closest('.transaction-item').querySelector(
                    '.transaction-details');
                details.classList.toggle('hidden');
                this.textContent = details.classList.contains('hidden') ? 'Show Details' :
                    'Hide Details';
            });
        });

        // Set default date values (last 30 days)
        const today = new Date();
        const thirtyDaysAgo = new Date(today);
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        document.getElementById('endDate').valueAsDate = today;
        document.getElementById('startDate').valueAsDate = thirtyDaysAgo;

        // Filter transactions
        document.getElementById('searchTransactions')?.addEventListener('input', filterTransactions);
        document.getElementById('startDate')?.addEventListener('change', filterTransactions);
        document.getElementById('endDate')?.addEventListener('change', filterTransactions);

        function filterTransactions() {
            const searchTerm = document.getElementById('searchTransactions').value.toLowerCase();
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            document.querySelectorAll('.transaction-item').forEach(item => {
                const customer = item.getAttribute('data-customer');
                const date = item.getAttribute('data-date');

                const matchesSearch = customer.includes(searchTerm);
                const matchesDate = (!startDate || !endDate || (date >= startDate && date <= endDate));

                if (matchesSearch && matchesDate) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Remove transaction
        const removeButtons = document.querySelectorAll('.remove-transaction');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                if (confirm('Are you sure you want to remove this transaction?')) {
                    const form = this.closest('.delete-form');
                    form.submit();
                }
            });
        });
    });
    </script>
</body>

</html>