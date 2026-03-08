<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - tattooink12studio.com</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary-dark: #0f0f1a;
            --secondary-dark: #1a1a2e;
            --gold-primary: #d4af37;
            --gold-light: #f4d03f;
            --text-primary: #ffffff;
            --text-secondary: #a0a0b0;
            --text-muted: #6b6b7b;
            --border-color: rgba(212, 175, 55, 0.2);
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-dark);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--secondary-dark);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 1.5rem;
        }

        .sidebar-logo h1 {
            font-size: 1.1rem;
            color: var(--gold-primary);
            letter-spacing: 1px;
        }

        .sidebar-logo span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 0.25rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-primary);
            border-right: 3px solid var(--gold-primary);
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border-color);
            margin: 1.5rem 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 260px;
            min-height: 100vh;
        }

        .top-bar {
            background: var(--secondary-dark);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h2 {
            font-size: 1.25rem;
        }

        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 8px;
        }

        .user-menu span {
            color: var(--gold-primary);
        }

        .content-area {
            padding: 2rem;
        }

        /* Cards */
        .card {
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            color: var(--gold-primary);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-icon.gold {
            background: rgba(212, 175, 55, 0.2);
            color: var(--gold-primary);
        }

        .stat-icon.green {
            background: rgba(34, 197, 94, 0.2);
            color: var(--success);
        }

        .stat-icon.blue {
            background: rgba(59, 130, 246, 0.2);
            color: var(--info);
        }

        .stat-icon.orange {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .stat-info h3 {
            font-size: 1.75rem;
            margin-bottom: 0.25rem;
        }

        .stat-info p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .table th {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .table tr:hover {
            background: rgba(212, 175, 55, 0.05);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: var(--gold-primary);
            color: var(--primary-dark);
        }

        .btn-primary:hover {
            background: var(--gold-light);
        }

        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .btn-edit {
            background: rgba(59, 130, 246, 0.2);
            color: var(--info);
        }

        .btn-delete {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .btn-view {
            background: rgba(34, 197, 94, 0.2);
            color: var(--success);
        }

        /* Badge */
        .badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge.bg-warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .badge.bg-success {
            background: rgba(34, 197, 94, 0.2);
            color: var(--success);
        }

        .badge.bg-info {
            background: rgba(59, 130, 246, 0.2);
            color: var(--info);
        }

        .badge.bg-danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .badge.bg-primary {
            background: rgba(139, 92, 246, 0.2);
            color: #8b5cf6;
        }

        .badge.bg-secondary {
            background: rgba(107, 114, 128, 0.2);
            color: #9ca3af;
        }

        .badge.bg-dark {
            background: rgba(31, 41, 55, 0.5);
            color: #9ca3af;
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            background: var(--primary-dark);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--gold-primary);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-check input {
            width: 18px;
            height: 18px;
            accent-color: var(--gold-primary);
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: var(--success);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--danger);
        }

        /* Product Image */
        .product-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }

        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
                padding: 1rem 0;
            }

            .sidebar-logo h1,
            .sidebar-logo span,
            .sidebar-menu span {
                display: none;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 1rem;
            }

            .main-content {
                margin-left: 70px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <h1>tattooink12studio.com</h1>
                <span>Admin Panel</span>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}"
                        class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-folder"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}"
                        class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}"
                        class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.invoices.index') }}"
                        class="{{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
                        <i class="fas fa-file-invoice"></i>
                        <span>Invoices</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.about-images.index') }}"
                        class="{{ request()->routeIs('admin.about-images.*') ? 'active' : '' }}">
                        <i class="fas fa-images"></i>
                        <span>About Images</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.banners.index') }}"
                        class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-divider"></div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span>View Site</span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('admin.logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <a href="#" onclick="document.getElementById('logoutForm').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <h2>@yield('page-title', 'Dashboard')</h2>
                <div class="top-bar-actions">
                    <div class="user-menu">
                        <i class="fas fa-user"></i>
                        <span>{{ Auth::guard('admin')->user()->name }}</span>
                    </div>
                </div>
            </div>

            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>

</html>