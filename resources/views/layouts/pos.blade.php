<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS UI</title>
    <!-- Include CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Hide scrollbar but keep functionality */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;     /* Firefox */
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;             /* Chrome, Safari and Opera */
        }

        /* Custom styles */
        .pos-content {
            height: calc(100vh - 4rem);
        }

        .pos-sidebar {
            width: 320px;
        }

        .pos-main {
            width: calc(100% - 320px);
        }

        .cart-items-container {
            height: calc(100vh - 20rem);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div id="sidebar" class="fixed top-16 left-0 h-[calc(100vh-4rem)] w-64 bg-white shadow-lg z-30 hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <span class="text-lg font-bold text-blue-600">Menu</span>
            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <ul class="p-4 space-y-4">
            <li>
                <a href="{{ route('pos.index') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                    <i class="fas fa-box w-5 mr-3"></i>
                    Products
                </a>
            </li>
            <li>
                <a href="{{ route('services.index') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                    <i class="fas fa-briefcase w-5 mr-3"></i>
                    Services
                </a>
            </li>
            <li>
                <a href="{{ route('pos.transactions') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                    <i class="fas fa-history w-5 mr-3"></i>
                    Transaction History
                </a>
            </li>
            <li>
                <a href="{{ route('pos.sales-report') }}" class="flex items-center text-gray-700 hover:text-blue-600">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    Sales Report
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-gray-700 hover:text-blue-600">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-30 z-20 hidden" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm fixed top-0 left-0 right-0 z-10 h-16">
            <div class="flex items-center justify-between px-4 h-full">
                <div class="flex items-center space-x-4">
                    <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800">Green Goblin POS</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">
                        <i class="fas fa-user mr-2"></i>
                        {{ Auth::user()->name }}
                    </span>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <div class="flex pos-content mt-16">
            <!-- Products/Services Grid - Left Side -->
            <div class="pos-main overflow-y-auto scrollbar-hide bg-gray-50">
                @yield('products-grid')
            </div>

            <!-- Receipt - Right Side -->
            <div class="pos-sidebar bg-white border-l">
                <div class="p-4 border-b bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-800">Current Order</h2>
                </div>
                
                <!-- Cart Items -->
                <div class="cart-items-container overflow-y-auto scrollbar-hide p-4">
                    @yield('order-items')
                </div>

                <!-- Order Summary -->
                <div class="border-t p-4">
                    @yield('order-summary')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const isOpen = !sidebar.classList.contains('hidden');
        
        if (isOpen) {
            sidebar.classList.add('hidden');
            overlay.classList.add('hidden');
        } else {
            sidebar.classList.remove('hidden');
            overlay.classList.remove('hidden');
        }
    }
    </script>
    @stack('scripts')
</body>
</html> 