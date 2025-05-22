<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-purple: #5E35B1;
            --dark-purple: #4527A0;
            --light-purple: #9575CD;
            --primary-green: #2E7D32;
            --light-green: #4CAF50;
            --pale-green: #A5D6A7;
            --bg-color: #F5F7FA;
            --text-dark: #333;
            --text-muted: #6C757D;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            --danger-red: #dc3545;
            --danger-dark: #bb2d3b;
        }
        
        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .sidebar {
            height: 100vh;
            background: linear-gradient(to bottom, var(--dark-purple), var(--primary-purple));
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
            box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }
        
        .sidebar .px-3 {
            margin-bottom: 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 20px;
        }
        
        .sidebar h3 {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
            margin: 5px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            color: white;
            background-color: var(--primary-green);
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.4);
        }
        
        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Sidebar Navigation Container */
        .sidebar-nav {
            flex-grow: 1;
            overflow-y: auto;
        }
        
        /* Logout Button Container */
        .logout-container {
            padding: 20px;
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn-logout {
            background-color: var(--danger-red);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            text-align: left;
            border: none;
        }
        
        .btn-logout:hover {
            background-color: var(--danger-dark);
            color: white;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
        }
        
        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            background-color: var(--bg-color);
            transition: all 0.3s ease;
        }
        
        /* Additional navbar styles */
        .top-navbar {
            background-color: white;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 12px 24px;
            position: relative;
        }
        
        .page-header {
            font-weight: 600;
            color: var(--primary-purple);
            position: relative;
            padding-left: 14px;
        }
        
        .page-header:before {
            content: '';
            position: absolute;
            left: 0;
            top: 25%;
            height: 50%;
            width: 4px;
            background-color: var(--primary-green);
            border-radius: 2px;
        }
        
        .notification-btn {
            background-color: transparent;
            border: 1px solid var(--primary-purple);
            color: var(--primary-purple);
            border-radius: 8px;
            position: relative;
        }
        
        .notification-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            font-size: 0.65rem;
        }
        
        .goblin-logo {
            width: 100px;
            display: block;
            margin: 0 auto 10px;
            filter: drop-shadow(2px 2px 2px rgba(0,0,0,0.3));
        }
        .navbar-brand {
            font-weight: bold;
            color: #4B0082;
            text-align: center;
            font-size:xx-large;
            font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Dropdown Styles for Sidebar */
        .sidebar .dropdown-toggle::after {
            float: right;
            margin-top: 8px;
        }

        .sidebar .nav-link.dropdown-toggle {
            position: relative;
        }

        .sidebar .nav-link.dropdown-toggle:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar ul.collapse {
            padding-left: 0;
        }

        .sidebar ul.collapse .nav-link {
            padding: 8px 15px;
            font-size: 0.9rem;
            margin: 2px 12px 2px 5px;
        }

        .sidebar ul.collapse .nav-link:hover {
            transform: translateX(3px);
        }

        .sidebar ul.collapse .nav-link i {
            font-size: 0.85rem;
        }

        /* Add animation for dropdown */
        .sidebar .collapse {
            transition: all 0.3s ease;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar Implementation -->
    <div class="sidebar">
        <div class="px-3 mb-4">
            <img src="{{ asset('./logopartial.jpg') }}" alt="Goblin Icon" class="goblin-logo">
        </div>
        
        <!-- Navigation Container -->
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <!-- Product Management -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#productsSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-box"></i> Products
                    </a>
                    <ul class="collapse list-unstyled ms-4" id="productsSubmenu">
                        <li>
                            <a class="nav-link {{ request()->is('admin/product_management') ? 'active' : '' }}" href="{{ route('product_management.index') }}">
                                <i class="fas fa-list"></i> View All
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->is('admin/product_management/create') ? 'active' : '' }}" href="{{ route('product_management.create') }}">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Categories -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#categoriesSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <ul class="collapse list-unstyled ms-4" id="categoriesSubmenu">
                        <li>
                            <a class="nav-link {{ request()->is('admin/category_management') ? 'active' : '' }}" href="{{ route('category_management.index') }}">
                                <i class="fas fa-list"></i> View All
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->is('admin/category_management/create') ? 'active' : '' }}" href="{{ route('category_management.create') }}">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Suppliers -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#suppliersSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-truck"></i> Suppliers
                    </a>
                    <ul class="collapse list-unstyled ms-4" id="suppliersSubmenu">
                        <li>
                            <a class="nav-link {{ request()->is('admin/supplier_management') ? 'active' : '' }}" href="{{ route('supplier_management.index') }}">
                                <i class="fas fa-list"></i> View All
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->is('admin/supplier_management/create') ? 'active' : '' }}" href="{{ route('supplier_management.create') }}">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Services -->
                <li class="nav-item">
                    <a class="nav-link dropdown-toggle" href="#servicesSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-wrench"></i> Services
                    </a>
                    <ul class="collapse list-unstyled ms-4" id="servicesSubmenu">
                        <li>
                            <a class="nav-link {{ request()->is('admin/services') ? 'active' : '' }}" href="{{ route('services.index') }}">
                                <i class="fas fa-list"></i> View All
                            </a>
                        </li>
                        <li>
                            <a class="nav-link {{ request()->is('admin/services/create') ? 'active' : '' }}" href="{{ route('services.create') }}">
                                <i class="fas fa-plus"></i> Add New
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/user_management') ? 'active' : '' }}" href="{{ route('user_management.index') }}">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}" href="{{ route('settings_management.index') }}">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout Container -->
        <div class="logout-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
    
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light top-navbar px-4">
            <div class="container-fluid">
                <a class="navbar-brand nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Green Goblin Systems</a>
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown me-3">
                        <button class="btn btn-sm btn-outline notification-btn" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="badge bg-danger">3</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown">
                            <li><a class="dropdown-item" href="#">New order received</a></li>
                            <li><a class="dropdown-item" href="#">Low inventory alert</a></li>
                            <li><a class="dropdown-item" href="#">Payment confirmed</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid mt-4 px-4">
            <h2 class="page-header mb-4">@yield('header')</h2>
            @yield('content')
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    @yield('scripts')
</body>
</html>