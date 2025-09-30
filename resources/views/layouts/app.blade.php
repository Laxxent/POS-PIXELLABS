<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS Application')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Remove any default margins/padding that could cause gaps */
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            overflow-x: hidden;
        }
        
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0.5rem;
            margin: 0.2rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.8;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-1px);
        }
        .table {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .alert {
            border-radius: 0.75rem;
            border: none;
        }
        .dropdown-menu {
            border-radius: 0.75rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            min-width: 200px;
        }
        .dropdown-item {
            border-radius: 0.5rem;
            margin: 0.125rem 0;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            font-weight: 500;
            color: #495057;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #2c3e50;
        }
        .dropdown-item i {
            width: 16px;
            margin-right: 0.75rem;
            color: #6c757d;
        }
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e9ecef;
        }
        .navbar {
            padding: 1rem 0 !important;
        }
        
        /* Remove default Bootstrap container padding completely */
        .container-fluid {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        
        /* Remove gap from main content area completely */
        .main-content {
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Ensure main content container has no right gap */
        .main-content .container-fluid {
            padding-right: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Force navbar content to use full width */
        .navbar .container-fluid {
            max-width: 100% !important;
            width: 100% !important;
        }
        
        /* Add internal padding to navbar content */
        .navbar .d-flex {
            padding-left: 1rem;
            padding-right: 0;
            width: 100%;
            justify-content: space-between;
        }
        
        /* Remove any margin/padding from navbar container */
        .navbar .container-fluid {
            padding-right: 0 !important;
            margin-right: 0 !important;
        }
        
        /* Force navbar to use full width without any gaps */
        .navbar {
            margin-right: 0 !important;
            padding-right: 0 !important;
        }
        
        /* Ensure user dropdown is positioned at the very right edge */
        .navbar-nav {
            margin-right: 0 !important;
            padding-right: 0 !important;
        }
        
        .navbar-nav .nav-item {
            margin-right: 0 !important;
        }
        
        /* Add right margin to user info to prevent it from being covered */
        .user-info {
            margin-right: 0.7rem !important;
        }
        
        /* Ensure navbar nav has proper spacing */
        .navbar-nav {
            margin-right: 1.5rem !important;
            padding-right: 0 !important;
        }
        
        /* Ensure dropdown menu has proper positioning */
        .dropdown-menu-end {
            right: 1.5rem !important;
            left: auto !important;
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            letter-spacing: -0.025em;
        }
        
        .navbar-nav .nav-link {
            color: #6c757d;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: #495057;
            background-color: #f8f9fa;
        }
        
        .user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 0.375rem 1rem 0.375rem 0.5rem;
            min-width: 140px;
            max-width: 180px;
            position: relative;
        }
        
        .user-name {
            font-weight: 500;
            color: #2c3e50;
            margin: 0 0.375rem;
            flex-grow: 1;
            font-size: 0.875rem;
        }
        
        .user-role {
            font-size: 0.7rem;
            color: #495057;
            background-color: #e9ecef;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            border: none;
            margin-right: 0.75rem;
            font-weight: 600;
        }
        
        .dropdown-toggle::after {
            margin-left: 0.5rem;
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
        
        .user-info.dropdown-toggle::after {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 0;
            border-top: 0.25em solid #6c757d;
            border-right: 0.25em solid transparent;
            border-bottom: 0;
            border-left: 0.25em solid transparent;
        }
        
        .user-info.dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .user-info.dropdown-toggle:hover {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }
        .content-wrapper {
            padding: 1rem 0 !important;
        }
        
        /* Add internal padding to content wrapper */
        .content-wrapper > * {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        /* Professional spacing and typography */
        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0;
            letter-spacing: -0.025em;
        }
        
        /* Improved card styling */
        .card {
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            border-color: #dee2e6;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1rem 1.5rem;
        }
        
        .card-header h6 {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }
        
        /* Professional button styling */
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        /* Professional table styling */
        .table {
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            padding: 1rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
            .content-wrapper {
                padding: 1rem 0.5rem;
            }
            .navbar {
                padding: 0.75rem 1rem;
            }
            .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
        }

        /* Dark Mode Styles */
        [data-theme="dark"] {
            color-scheme: dark;
        }

        [data-theme="dark"] body {
            background-color: #1a1a1a;
            color: #e9ecef;
        }

        [data-theme="dark"] .main-content {
            background-color: #1a1a1a;
        }

        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] h4,
        [data-theme="dark"] h5,
        [data-theme="dark"] h6 {
            color: #ffffff;
        }

        [data-theme="dark"] p,
        [data-theme="dark"] span,
        [data-theme="dark"] div,
        [data-theme="dark"] a {
            color: #e9ecef;
        }

        [data-theme="dark"] a:hover {
            color: #ffffff;
        }

        [data-theme="dark"] .card {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e9ecef;
        }

        [data-theme="dark"] .card-header {
            background-color: #4a5568;
            border-bottom-color: #718096;
            color: #ffffff;
        }

        [data-theme="dark"] .table {
            color: #e9ecef;
        }

        [data-theme="dark"] .table-light {
            background-color: #4a5568;
        }

        [data-theme="dark"] .table td,
        [data-theme="dark"] .table th {
            border-color: #4a5568;
            color: #e9ecef;
        }

        [data-theme="dark"] .table thead th {
            background-color: #4a5568;
            border-bottom-color: #718096;
            color: #ffffff;
        }

        [data-theme="dark"] .table tbody td {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e9ecef;
        }

        [data-theme="dark"] .table tbody tr:hover td {
            background-color: #4a5568;
            color: #ffffff;
        }

        [data-theme="dark"] .table-bordered {
            border-color: #4a5568;
        }

        [data-theme="dark"] .table-bordered th,
        [data-theme="dark"] .table-bordered td {
            border-color: #4a5568;
        }

        [data-theme="dark"] .navbar {
            background-color: #2d3748 !important;
            border-bottom-color: #4a5568;
        }

        [data-theme="dark"] .navbar-brand {
            color: #ffffff !important;
        }

        [data-theme="dark"] .navbar-nav .nav-link {
            color: #e9ecef !important;
        }

        [data-theme="dark"] .navbar-nav .nav-link:hover {
            color: #ffffff !important;
            background-color: #4a5568;
        }

        [data-theme="dark"] .user-name {
            color: #ffffff !important;
        }

        [data-theme="dark"] .user-info {
            background-color: #2d3748;
            border-color: #4a5568;
        }

        [data-theme="dark"] .dropdown-toggle::after {
            border-top-color: #e9ecef;
        }

        [data-theme="dark"] .user-info.dropdown-toggle:hover {
            background-color: #4a5568;
            border-color: #718096;
        }

        [data-theme="dark"] .user-role {
            background-color: #4a5568;
            color: #e9ecef;
            border-color: #718096;
        }

        [data-theme="dark"] .dropdown-menu {
            background-color: #2d3748;
            border-color: #4a5568;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        [data-theme="dark"] .dropdown-item {
            color: #e9ecef;
        }

        [data-theme="dark"] .dropdown-item:hover {
            background-color: #4a5568;
            color: #ffffff;
        }

        [data-theme="dark"] .dropdown-item:focus {
            background-color: #4a5568;
            color: #ffffff;
        }

        [data-theme="dark"] .dropdown-item:active {
            background-color: #718096;
            color: #ffffff;
        }

        [data-theme="dark"] .dropdown-divider {
            border-top-color: #4a5568;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: #2d3748;
            border-color: #4a5568;
            color: #e9ecef;
        }

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background-color: #2d3748;
            border-color: #667eea;
            color: #e9ecef;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        [data-theme="dark"] .form-control::placeholder {
            color: #a0aec0;
        }

        [data-theme="dark"] .btn-outline-secondary {
            color: #e9ecef;
            border-color: #4a5568;
        }

        [data-theme="dark"] .btn-outline-secondary:hover {
            background-color: #4a5568;
            border-color: #4a5568;
            color: #ffffff;
        }

        [data-theme="dark"] .btn-outline-secondary:focus {
            background-color: #4a5568;
            border-color: #4a5568;
            color: #ffffff;
            box-shadow: 0 0 0 0.2rem rgba(74, 85, 104, 0.5);
        }

        [data-theme="dark"] .btn-outline-secondary:active {
            background-color: #4a5568;
            border-color: #4a5568;
            color: #ffffff;
        }

        [data-theme="dark"] .alert-success {
            background-color: #22543d;
            border-color: #38a169;
            color: #c6f6d5;
        }

        [data-theme="dark"] .alert-danger {
            background-color: #742a2a;
            border-color: #e53e3e;
            color: #fed7d7;
        }

        [data-theme="dark"] .alert-warning {
            background-color: #744210;
            border-color: #dd6b20;
            color: #fbd38d;
        }

        [data-theme="dark"] .alert-info {
            background-color: #2a4365;
            border-color: #3182ce;
            color: #bee3f8;
        }

        [data-theme="dark"] .badge {
            color: #ffffff;
        }

        [data-theme="dark"] .text-muted {
            color: #a0aec0 !important;
        }

        [data-theme="dark"] .border-bottom {
            border-bottom-color: #4a5568 !important;
        }

    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="fas fa-cash-register me-2"></i>
                            POS System
                        </h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" 
                               href="{{ route('products.index') }}">
                                <i class="fas fa-box"></i>
                                Produk
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" 
                               href="{{ route('categories.index') }}">
                                <i class="fas fa-tags"></i>
                                Kategori
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}" 
                               href="{{ route('units.index') }}">
                                <i class="fas fa-ruler"></i>
                                Satuan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" 
                               href="{{ route('suppliers.index') }}">
                                <i class="fas fa-truck"></i>
                                Supplier
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" 
                               href="{{ route('customers.index') }}">
                                <i class="fas fa-users"></i>
                                Pelanggan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" 
                               href="{{ route('sales.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                Penjualan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}" 
                               href="{{ route('purchases.index') }}">
                                <i class="fas fa-shopping-bag"></i>
                                Pembelian
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" 
                               href="{{ route('users.index') }}">
                                <i class="fas fa-user-cog"></i>
                                Pengguna
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('store-settings.*') ? 'active' : '' }}" 
                               href="{{ route('store-settings.index') }}">
                                <i class="fas fa-cog"></i>
                                Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-0 main-content">
                <!-- Top Navigation -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center">
                            <h1 class="navbar-brand mb-0">
                                @yield('page-title', 'POS Application')
                            </h1>
                        </div>
                        
                        <div class="navbar-nav ms-auto">
                            <div class="nav-item dropdown">
                                <div class="user-info dropdown-toggle" 
                                     id="navbarDropdown" 
                                     role="button" 
                                     data-bs-toggle="dropdown" 
                                     aria-expanded="false">
                                    <div class="user-avatar">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <span class="user-name">{{ Auth::user()->name }}</span>
                                    <span class="user-role">{{ Auth::user()->role }}</span>
                                </div>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                                            <i class="fas fa-user me-2"></i>
                                            Profil Saya
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="toggleDarkMode(); return false;" id="darkModeToggle">
                                            <i class="fas fa-moon me-2" id="darkModeIcon"></i>
                                            <span id="darkModeText">Dark Mode</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('store-settings.index') }}">
                                            <i class="fas fa-cog me-2"></i>
                                            Pengaturan Toko
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>
                                                Keluar
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Content -->
                <div class="content-wrapper">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Dark Mode JS -->
    <script src="{{ asset('js/dark-mode.js') }}"></script>
    
    <script>
        // Dark Mode Functions
        function initializeTheme() {
            const html = document.documentElement;
            const savedTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', savedTheme);
            updateDarkModeButton(savedTheme);
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateDarkModeButton(newTheme);
        }

        function updateDarkModeButton(theme) {
            const darkModeIcon = document.getElementById('darkModeIcon');
            const darkModeText = document.getElementById('darkModeText');
            
            if (theme === 'dark') {
                // Currently in dark mode, show "Light Mode" option
                darkModeIcon.className = 'fas fa-sun me-2';
                darkModeText.textContent = 'Light Mode';
            } else {
                // Currently in light mode, show "Dark Mode" option
                darkModeIcon.className = 'fas fa-moon me-2';
                darkModeText.textContent = 'Dark Mode';
            }
        }

        // Initialize theme on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeTheme();
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialize popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
    
    @stack('scripts')
</body>
</html>
