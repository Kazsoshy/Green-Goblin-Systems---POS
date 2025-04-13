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
        
        .btn-logout {
            background-color: var(--primary-purple);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-logout:hover {
            background-color: var(--dark-purple);
            color: white;
            box-shadow: 0 4px 8px rgba(94, 53, 177, 0.3);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar Implementation -->
    <div class="sidebar">
        <div class="px-3 mb-4">
            <h3>GGS-Admin</h3>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-box"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-users"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-chart-bar"></i> Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-light top-navbar px-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">GGS-TD-POS</a>
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
                    <a class="btn btn-logout" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
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