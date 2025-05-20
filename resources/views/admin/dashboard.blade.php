@extends('layouts.admindash')

@section('title', 'Admin Dashboard')
@section('header', 'Welcome Admin!')

@section('styles')
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
    
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 24px;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    }
    
    .card-title {
        color: var(--primary-purple);
        font-weight: 600;
        margin-bottom: 12px;
    }
    
    .stat-card {
        padding: 24px;
        border-radius: 12px;
        position: relative;
        overflow: hidden;
        min-height: 140px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .stat-card.purple {
        background: linear-gradient(45deg, var(--primary-purple), var(--light-purple));
        color: white;
    }
    
    .stat-card.green {
        background: linear-gradient(45deg, var(--primary-green), var(--light-green));
        color: white;
    }
    
    .stat-card h3 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        position: relative;
        z-index: 1;
    }
    
    .stat-card p {
        font-size: 15px;
        margin-bottom: 0;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }
    
    .stat-card .stat-icon {
        position: absolute;
        right: 20px;
        bottom: 20px;
        font-size: 64px;
        opacity: 0.2;
    }
    
    .stat-trend {
        display: inline-flex;
        align-items: center;
        font-size: 12px;
        background: rgba(255, 255, 255, 0.2);
        padding: 3px 8px;
        border-radius: 12px;
        margin-top: 5px;
    }
    
    .stat-trend i {
        margin-right: 4px;
    }
    
    .alert-custom {
        border-radius: 10px;
        border: none;
        padding: 16px 20px;
    }
    
    .alert-custom-success {
        background-color: rgba(46, 125, 50, 0.1);
        color: var(--primary-green);
        border-left: 4px solid var(--primary-green);
    }
    
    .btn-primary {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: var(--dark-purple);
        border-color: var(--dark-purple);
        box-shadow: 0 4px 10px rgba(94, 53, 177, 0.3);
    }
    
    .btn-success {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-success:hover {
        background-color: #1B5E20;
        border-color: #1B5E20;
        box-shadow: 0 4px 10px rgba(46, 125, 50, 0.3);
    }
    
    .btn-outline {
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
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
    
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .recent-orders-table th {
        background-color: rgba(94, 53, 177, 0.1);
        color: var(--primary-purple);
        font-weight: 600;
        border: none;
    }
    
    .recent-orders-table td {
        vertical-align: middle;
    }
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 12px;
    }
    
    .badge-completed {
        background-color: var(--light-green);
        color: white;
    }
    
    .badge-processing {
        background-color: var(--light-purple);
        color: white;
    }
    
    .badge-cancelled {
        background-color: #F44336;
        color: white;
    }
    
    .badge-shipped {
        background-color: #2196F3;
        color: white;
    }
    
    .badge-pending {
        background-color: #FFC107;
        color: #333;
    }
    
    .feature-card {
        position: relative;
        overflow: hidden;
        padding-bottom: 10px;
    }
    
    .feature-card::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 20px;
        right: 20px;
        height: 3px;
        background: linear-gradient(to right, var(--primary-purple), var(--primary-green));
        border-radius: 2px;
    }
    
    .feature-icon {
        display: inline-flex;
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background-color: rgba(94, 53, 177, 0.1);
        color: var(--primary-purple);
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 24px;
    }
    
    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .activity-item {
        padding: 15px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(94, 53, 177, 0.1);
        color: var(--primary-purple);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-content h6 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .activity-content p {
        color: var(--text-muted);
        margin-bottom: 0;
        font-size: 13px;
    }
</style>
@endsection

@section('sidebar')
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
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-link btn btn-link" style="padding:0; border:none; background:none;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</div>
@endsection

@section('content')
    <div class="alert alert-custom alert-custom-success">
        <i class="fas fa-check-circle me-2"></i> You are logged in as an admin. Welcome to the admin dashboard.
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stat-card purple">
                <h3>$12,586</h3>
                <p>Total Revenue</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> 12.5%
                </div>
                <i class="fas fa-dollar-sign stat-icon"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card green">
                <h3>126</h3>
                <p>New Orders</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> 8.2%
                </div>
                <i class="fas fa-shopping-cart stat-icon"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card purple">
                <h3>287</h3>
                <p>Products</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> 3.5%
                </div>
                <i class="fas fa-box stat-icon"></i>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card green">
                <h3>1,652</h3>
                <p>Customers</p>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i> 5.8%
                </div>
                <i class="fas fa-users stat-icon"></i>
            </div>
        </div>
    </div>

    <!-- Admin Features and Chart -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product Stock by Category</h5>
                    <div class="chart-container">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Activity</h5>
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="activity-content">
                                <h6>New Product Added</h6>
                                <p>AMD Ryzen 9 5900X added to inventory</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="activity-content">
                                <h6>New Customer</h6>
                                <p>Jonathan Paran registered an account</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Order Completed</h6>
                                <p>Order #35721 was marked as completed</p>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-money-bill"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Payment Received</h6>
                                <p>$582.50 payment received for order #35672</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Features -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body">
                    <div class="feature-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <h5 class="card-title">Manage Products</h5>
                    <p class="card-text">Add, edit, or remove products from your inventory.</p>
                    <a href="{{ route('product management.index') }}" class="{{ request()->is('admin/product management') ? 'active' : '' }} btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i> Go to Products
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">View, add, edit, or remove system users and permissions.</p>
                    <a href="{{ route('user management.index') }}" class="{{ request()->is('admin/user management') ? 'active' : '' }} btn btn-success">
                        <i class="fas fa-arrow-right me-2"></i> Go to Users
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card feature-card">
                <div class="card-body">
                    <div class="feature-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h5 class="card-title">System Settings</h5>
                    <p class="card-text">Configure system preferences and global settings.</p>
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-arrow-right me-2"></i> Go to Settings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title">Recent Orders</h5>
                <a href="#" class="btn btn-success btn-sm">View All Orders</a>
            </div>
            <div class="table-responsive">
                <table class="table recent-orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-2025-1001</td>
                            <td>Rameses Bernabe</td>
                            <td>Apr 12, 2025</td>
                            <td>$389.99</td>
                            <td><span class="badge badge-status badge-completed">Completed</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-success"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ORD-2025-1002</td>
                            <td>William Duncombe</td>
                            <td>Apr 11, 2025</td>
                            <td>$129.50</td>
                            <td><span class="badge badge-status badge-processing">Processing</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-success"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ORD-2025-1003</td>
                            <td>Jonathan Paran</td>
                            <td>Apr 11, 2025</td>
                            <td>$749.99</td>
                            <td><span class="badge badge-status badge-shipped">Shipped</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-success"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>#ORD-2025-1004</td>
                            <td>Ambatukam</td>
                            <td>Apr 10, 2025</td>
                            <td>$85.25</td>
                            <td><span class="badge badge-status badge-pending">Pending</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-sm btn-success"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('stockChart').getContext('2d');
        
        const stockChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($categories),
                datasets: [{
                    label: 'Stock Quantity',
                    data: @json($stockCounts),
                    backgroundColor: 'rgba(94, 53, 177, 0.6)',
                    borderColor: '#5E35B1',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Product Stock Levels by Category'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Stock Quantity'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection