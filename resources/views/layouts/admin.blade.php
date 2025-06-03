<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') | Sistem Konseling</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.15.2/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">

    @stack('css')

    <style>
        /* Enhanced Responsive Styles */
        :root {
            --sidebar-width: 250px;
            --sidebar-mini-width: 4.6rem;
            --navbar-height: 57px;
            --mobile-breakpoint: 768px;
            --tablet-breakpoint: 992px;
        }

        /* Base responsive improvements */
        .main-header .navbar-nav .nav-link {
            height: auto;
            padding: 0.5rem 0.75rem;
        }

        .content-wrapper {
            background: #f4f6f9;
            min-height: calc(100vh - var(--navbar-height));
        }

        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
            border-radius: 0.5rem;
        }

        .is-invalid-select2 .select2-selection {
            border-color: #dc3545 !important;
        }

        /* Enhanced Mobile Navigation */
        @media (max-width: 767.98px) {
            /* Mobile-first navbar adjustments */
            .main-header .navbar {
                padding: 0.5rem 1rem;
            }
            
            .navbar-nav .nav-link {
                padding: 0.5rem;
                font-size: 0.9rem;
            }
            
            .navbar-nav .dropdown-menu {
                position: absolute !important;
                right: 0;
                left: auto;
                min-width: 200px;
                margin-top: 0.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }

            /* Brand logo responsive */
            .brand-link {
                padding: 0.8rem 0.5rem;
            }
            
            .brand-link .brand-image {
                width: 28px;
                height: 28px;
            }
            
            .brand-text {
                font-size: 1rem;
                margin-left: 0.5rem;
            }

            /* Sidebar mobile optimization */
            .main-sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                z-index: 1050;
                transition: left 0.3s ease-in-out;
                height: 100vh;
                overflow-y: auto;
            }
            
            .sidebar-open .main-sidebar {
                left: 0;
            }
            
            /* Mobile sidebar overlay */
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
                display: none;
            }
            
            .sidebar-open .sidebar-overlay {
                display: block;
            }

            /* Content adjustments for mobile */
            .content-wrapper {
                margin-left: 0 !important;
                padding-top: 1rem;
            }
            
            .content-header {
                padding: 0.5rem 1rem;
            }
            
            .content-header h1 {
                font-size: 1.5rem;
                margin: 0;
            }
            
            .breadcrumb {
                background: transparent;
                padding: 0;
                margin: 0.5rem 0 0 0;
                font-size: 0.85rem;
            }
            
            .breadcrumb-item + .breadcrumb-item::before {
                content: "›";
                padding: 0 0.25rem;
            }

            /* User panel mobile optimization */
            .user-panel {
                padding: 0.75rem 1rem;
            }
            
            .user-panel .image img {
                width: 30px;
                height: 30px;
            }
            
            .user-panel .info a {
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 150px;
                display: inline-block;
            }

            /* Navigation menu mobile styles */
            .nav-sidebar .nav-item .nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
            
            .nav-sidebar .nav-item .nav-link .nav-icon {
                width: 20px;
                text-align: center;
                margin-right: 0.75rem;
            }
            
            .nav-treeview .nav-link {
                padding-left: 2.5rem;
                font-size: 0.85rem;
            }

            /* Footer mobile adjustments */
            .main-footer {
                padding: 1rem;
                text-align: center;
                font-size: 0.85rem;
            }
            
            .main-footer .float-right {
                float: none !important;
                margin-top: 0.5rem;
            }
        }

        /* Tablet optimizations */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .main-sidebar {
                width: 200px;
            }
            
            .content-wrapper {
                margin-left: 200px;
            }
            
            .brand-text {
                font-size: 1.1rem;
            }
            
            .nav-sidebar .nav-item .nav-link {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
            
            .content-header h1 {
                font-size: 1.75rem;
            }
        }

        /* Large screen optimizations */
        @media (min-width: 1200px) {
            .content-wrapper {
                padding: 0 1rem;
            }
            
            .content-header {
                padding: 1rem 1.5rem;
            }
            
            .main-footer {
                padding: 1rem 1.5rem;
            }
        }

        /* Card responsive improvements */
        .card-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        
        .card-body {
            padding: 1rem;
        }
        
        @media (max-width: 575.98px) {
            .card-header {
                padding: 0.5rem 0.75rem;
            }
            
            .card-body {
                padding: 0.75rem;
            }
            
            .card-title {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }
        }

        /* Button responsive improvements */
        .btn-group {
            flex-wrap: wrap;
        }
        
        @media (max-width: 575.98px) {
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.875rem;
                margin-bottom: 0.25rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .btn-group .btn {
                margin-bottom: 0;
            }
            
            .card-tools .btn {
                margin-left: 0.25rem;
                margin-bottom: 0.25rem;
            }
        }

        /* Table responsive enhancements */
        .table-responsive {
            border-radius: 0.5rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125);
        }
        
        @media (max-width: 767.98px) {
            .table-responsive {
                font-size: 0.85rem;
            }
            
            .table th,
            .table td {
                padding: 0.5rem 0.25rem;
                vertical-align: middle;
            }
            
            .table .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        /* Form responsive improvements */
        @media (max-width: 575.98px) {
            .form-group {
                margin-bottom: 1rem;
            }
            
            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .input-group {
                flex-wrap: wrap;
            }
            
            .input-group .form-control {
                min-width: 0;
                flex: 1 1 auto;
            }
            
            .input-group-append,
            .input-group-prepend {
                flex-wrap: wrap;
            }
        }

        /* Modal responsive improvements */
        @media (max-width: 575.98px) {
            .modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem);
            }
            
            .modal-header {
                padding: 0.75rem;
            }
            
            .modal-body {
                padding: 0.75rem;
            }
            
            .modal-footer {
                padding: 0.75rem;
                flex-wrap: wrap;
            }
            
            .modal-footer .btn {
                margin: 0.25rem;
                flex: 1;
            }
        }

        /* DataTables responsive improvements */
        @media (max-width: 767.98px) {
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                text-align: left;
                margin-bottom: 0.5rem;
            }
            
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                text-align: center;
                margin-top: 0.5rem;
            }
            
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.25rem 0.5rem;
                margin: 0 0.125rem;
            }
        }

        /* Select2 responsive improvements */
        @media (max-width: 575.98px) {
            .select2-container {
                width: 100% !important;
            }
            
            .select2-dropdown {
                font-size: 16px; /* Prevents zoom on iOS */
            }
            
            .select2-selection {
                min-height: 38px;
            }
        }

        /* Utility classes for responsive design */
        .mobile-only {
            display: none;
        }
        
        .desktop-only {
            display: block;
        }
        
        @media (max-width: 767.98px) {
            .mobile-only {
                display: block;
            }
            
            .desktop-only {
                display: none;
            }
            
            .mobile-hide {
                display: none !important;
            }
            
            .mobile-center {
                text-align: center !important;
            }
            
            .mobile-full-width {
                width: 100% !important;
            }
        }

        /* Loading states */
        .loading {
            position: relative;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid #007bff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 1001;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        
        /* Focus improvements */
        .nav-link:focus,
        .btn:focus,
        .form-control:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .card {
                border: 2px solid #000;
            }
            
            .btn {
                border: 2px solid;
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print styles */
        @media print {
            .main-sidebar,
            .main-header,
            .main-footer,
            .btn,
            .card-tools {
                display: none !important;
            }
            
            .content-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            
            .card {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay d-lg-none" onclick="closeMobileSidebar()"></div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button" onclick="toggleMobileSidebar()">
                    <i class="fas fa-bars"></i>
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- User Menu -->
            @auth
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ Auth::user()->avatar ?? '/placeholder.svg?height=30&width=30' }}" 
                         alt="User Avatar" 
                         class="img-circle" 
                         style="width: 30px; height: 30px; object-fit: cover;">
                    <span class="ml-1 d-none d-md-inline">{{ Auth::user()->name }}</span>
                    <span class="sr-only">User menu</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-header">
                        <strong>{{ Auth::user()->name }}</strong><br>
                        <small class="text-muted">{{ Auth::user()->email }}</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.settings') }}" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> Pengaturan Profil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                    <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            @endauth

            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                    <span class="sr-only">Toggle fullscreen</span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="/placeholder.svg?height=33&width=33" 
                 alt="Logo" 
                 class="brand-image img-circle elevation-3" 
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Sistem Konseling</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            @auth
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ Auth::user()->avatar ?? '/placeholder.svg?height=160&width=160' }}" 
                         class="img-circle elevation-2" 
                         alt="User Image" 
                         style="width: 34px; height: 34px; object-fit: cover;">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>
            @endauth

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- User Management -->
                    <li class="nav-item {{ request()->routeIs('admin.student') || request()->is('admin/students*') || request()->routeIs('admin.counselor') || request()->routeIs('admin.administrator') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.student') || request()->is('admin/students*') || request()->routeIs('admin.counselor') || request()->routeIs('admin.administrator') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Manajemen User
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.student') }}" class="nav-link {{ request()->routeIs('admin.student') || request()->is('admin/student*') ? 'active' : '' }}">
                                    <i class="far fa-id-card nav-icon"></i>
                                    <p>Siswa</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.counselor.index') }}" class="nav-link {{ request()->routeIs('admin.counselor') ? 'active' : '' }}">
                                    <i class="fas fa-user-tie nav-icon"></i>
                                    <p>Konselor</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- School Management -->
                    <li class="nav-item {{ request()->routeIs('admin.class') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.class') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Manajemen Sekolah
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.class') }}" class="nav-link {{ request()->routeIs('admin.class') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-header">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="{{ route('profile.settings') }}" class="nav-link {{ request()->routeIs('profile.settings') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-cog"></i>
                            <p>Pengaturan Akun</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                            <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                            <p class="text">Logout</p>
                        </a>
                        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <strong>Copyright © {{ date('Y') }} <a href="#">STMCounseling</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.15.2/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
<!-- Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>

@stack('scripts')

<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize popovers
    $('[data-toggle="popover"]').popover();

    // Mobile sidebar functionality
    initializeMobileSidebar();
    
    // Responsive table initialization
    initializeResponsiveTables();
    
    // Responsive form enhancements
    initializeResponsiveForms();
    
    // Window resize handler
    $(window).on('resize', function() {
        handleWindowResize();
    });
    
    // Initial responsive setup
    handleWindowResize();
});

// Mobile sidebar functions
function toggleMobileSidebar() {
    if (window.innerWidth < 992) {
        $('body').toggleClass('sidebar-open');
        $('.sidebar-overlay').toggle();
    }
}

function closeMobileSidebar() {
    $('body').removeClass('sidebar-open');
    $('.sidebar-overlay').hide();
}

function initializeMobileSidebar() {
    // Close sidebar when clicking on content on mobile
    $('.content-wrapper').on('click', function() {
        if (window.innerWidth < 992 && $('body').hasClass('sidebar-open')) {
            closeMobileSidebar();
        }
    });
    
    // Handle sidebar menu clicks on mobile
    $('.nav-sidebar .nav-link').on('click', function(e) {
        if (window.innerWidth < 992) {
            // If it's a parent menu item, don't close sidebar
            if ($(this).next('.nav-treeview').length > 0) {
                return;
            }
            // Close sidebar for regular menu items
            setTimeout(function() {
                closeMobileSidebar();
            }, 300);
        }
    });
}

// Responsive table initialization
function initializeResponsiveTables() {
    // Initialize DataTables with responsive options
    if ($.fn.DataTable) {
        $('.table').each(function() {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable({
                    responsive: true,
                    autoWidth: false,
                    columnDefs: [
                        { responsivePriority: 1, targets: 0 },
                        { responsivePriority: 2, targets: -1 }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                    }
                });
            }
        });
    }
}

// Responsive form enhancements
function initializeResponsiveForms() {
    // Initialize Select2 with responsive options
    if ($.fn.select2) {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            dropdownAutoWidth: true
        });
    }
    
    // Handle form validation display on mobile
    $('.form-control').on('invalid', function() {
        $(this).addClass('is-invalid');
    });
    
    $('.form-control').on('input', function() {
        if (this.validity.valid) {
            $(this).removeClass('is-invalid');
        }
    });
}

// Window resize handler
function handleWindowResize() {
    const windowWidth = $(window).width();
    
    // Close mobile sidebar on desktop
    if (windowWidth >= 992) {
        closeMobileSidebar();
    }
    
    // Adjust DataTables on resize
    if ($.fn.DataTable) {
        $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust().responsive.recalc();
    }
    
    // Adjust Select2 dropdowns
    if ($.fn.select2) {
        $('.select2').select2('close');
    }
}

// Global AJAX setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Global error handler with responsive considerations
$(document).ajaxError(function(event, xhr, settings, thrownError) {
    if (xhr.status === 419) {
        Swal.fire({
            icon: 'warning',
            title: 'Sesi Berakhir',
            text: 'Sesi Anda telah berakhir karena tidak ada aktivitas. Silakan muat ulang halaman dan coba lagi.',
            confirmButtonText: 'Muat Ulang Halaman',
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                container: 'responsive-swal'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload(true);
            }
        });
    } else if (xhr.status === 500) {
        Swal.fire({
            icon: 'error',
            title: 'Oops... Terjadi Kesalahan Server!',
            text: 'Bentar dibenerin dulu ya',
            customClass: {
                container: 'responsive-swal'
            }
        });
    }
});

// Utility functions for responsive behavior
function isMobile() {
    return window.innerWidth < 768;
}

function isTablet() {
    return window.innerWidth >= 768 && window.innerWidth < 992;
}

function isDesktop() {
    return window.innerWidth >= 992;
}

function showLoading(element) {
    $(element).addClass('loading');
}

function hideLoading(element) {
    $(element).removeClass('loading');
}

$(document).on('show.bs.modal', '.modal', function() {
    if (isMobile()) {
        $(this).find('.modal-dialog').addClass('modal-fullscreen-sm-down');
    }
});

$(document).on('keydown', function(e) {
    // ESC key closes mobile sidebar
    if (e.key === 'Escape' && $('body').hasClass('sidebar-open')) {
        closeMobileSidebar();
    }
});

let touchStartX = 0;
let touchEndX = 0;

$(document).on('touchstart', function(e) {
    touchStartX = e.changedTouches[0].screenX;
});

$(document).on('touchend', function(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipeGesture();
});

function handleSwipeGesture() {
    if (isMobile()) {
        const swipeThreshold = 100;
        const swipeDistance = touchEndX - touchStartX;
        
        if (swipeDistance > swipeThreshold && touchStartX < 50) {
            if (!$('body').hasClass('sidebar-open')) {
                toggleMobileSidebar();
            }
        }
        
        if (swipeDistance < -swipeThreshold && $('body').hasClass('sidebar-open')) {
            closeMobileSidebar();
        }
    }
}
</script>
</body>
</html>
