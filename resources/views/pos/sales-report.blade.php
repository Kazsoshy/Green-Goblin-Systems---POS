<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sales Report - POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                font-size: 12pt;
                line-height: 1.3;
                padding-top: 0;
            }
            
            .no-print {
                display: none !important;
            }
            
            .print-only {
                display: block !important;
            }
            
            .container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
            
            .page-break {
                page-break-after: always;
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
            }
            
            td, th {
                padding: 5px;
                border: 1px solid #ddd;
            }
            
            /* Hide the header and sidebar */
            nav, #sidebar, #sidebarOverlay {
                display: none !important;
            }
            
            /* Reset the body padding that's normally added for the header */
            body.pt-24 {
                padding-top: 0 !important;
            }
        }
        
        .print-only {
            display: none;
        }
    </style>
</head>

<body class="bg-gray-50 pt-24">
    @include('partials.header')
    <div class="container mx-auto px-4 pb-12">
        <!-- Print Header - Only visible when printing -->
        <div class="print-only mb-8 text-center">
            <h1 class="text-3xl font-bold">Green Goblin POS System</h1>
            <h2 class="text-xl">Sales Report</h2>
            <p class="text-gray-600">{{ date('F j, Y', strtotime($startDate)) }} to {{ date('F j, Y', strtotime($endDate)) }}</p>
            <p class="text-gray-600">Generated: {{ now()->format('F j, Y h:i A') }}</p>
        </div>
        
        <!-- Page Header -->
        <div class="mb-8 flex flex-wrap items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Sales Report</h1>
                <p class="text-gray-600 mt-1">Summary of sales activity</p>
            </div>
            <div>
                <button onclick="window.print()" class="no-print bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Report
                </button>
            </div>
        </div>

        <!-- Report Filters -->
        <form action="{{ route('pos.sales-report') }}" method="GET" class="bg-white rounded-lg shadow-sm p-4 mb-8 no-print">
            <div class="flex flex-wrap gap-4 items-center">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $startDate }}" 
                           class="mt-1 block border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $endDate }}" 
                           class="mt-1 block border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                        Generate Report
                    </button>
                </div>
            </div>
        </form>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Sales Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-600">Total Orders</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSales }}</p>
            </div>
            
            <!-- Total Revenue Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-600">Total Revenue</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">₱{{ number_format($totalRevenue, 2) }}</p>
            </div>
            
            <!-- Total Items Sold Card -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-600">Total Items Sold</h3>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalItems }}</p>
            </div>
        </div>

        <!-- Top Products Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Top Selling Products</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600">Product Name</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Quantity Sold</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topProducts as $product)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $product['name'] }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">{{ $product['quantity'] }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">₱{{ number_format($product['revenue'], 2) }}</td>
                        </tr>
                        @endforeach
                        @if($topProducts->isEmpty())
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No product data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Methods Section -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Payment Method Breakdown</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600">Payment Method</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Orders</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentMethodTotals as $method => $data)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ ucfirst($method) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">{{ $data['count'] }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">₱{{ number_format($data['total'], 2) }}</td>
                        </tr>
                        @endforeach
                        @if($paymentMethodTotals->isEmpty())
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No payment data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daily Sales Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Daily Sales</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Orders</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailySales as $date => $data)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ date('M j, Y', strtotime($date)) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">{{ $data['count'] }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">₱{{ number_format($data['total'], 2) }}</td>
                        </tr>
                        @endforeach
                        @if($dailySales->isEmpty())
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">No sales data available</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detailed Transactions Section -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Transaction Details</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600">Order ID</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600">Date</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600">Customer</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Items</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-right text-xs font-semibold text-gray-600">Total</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-center text-xs font-semibold text-gray-600">Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">#{{ $sale->id }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $sale->created_at->format('M j, Y H:i') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm">{{ $sale->customer_name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right">{{ $sale->saleItems->sum('quantity') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-right font-medium">₱{{ number_format($sale->total_amount, 2) }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-sm text-center">{{ ucfirst($sale->payment_method) }}</td>
                        </tr>
                        @endforeach
                        @if($sales->isEmpty())
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">No transactions found for the selected period</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set min/max values for date inputs to prevent invalid date ranges
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');
        
        if (startDate && endDate) {
            endDate.addEventListener('change', function() {
                startDate.max = this.value;
            });
            
            startDate.addEventListener('change', function() {
                endDate.min = this.value;
            });
            
            // Set initial constraints
            endDate.min = startDate.value;
            startDate.max = endDate.value;
        }
    });
    </script>
</body>

</html> 