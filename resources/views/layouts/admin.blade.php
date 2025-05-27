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
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">
    
    @yield('styles')
    
    <style>
        .main-header .navbar-nav .nav-link {
            height: auto;
        }
        
        .content-wrapper {
            background: #f4f6f9;
        }
        
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            margin-bottom: 1rem;
            border-radius: 0.5rem;
        }
        
        .small-box {
            border-radius: 0.5rem;
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            display: block;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .small-box > .inner {
            padding: 15px;
        }
        
        .small-box .icon {
            color: rgba(255,255,255,0.8);
            z-index: 0;
        }
        
        .small-box .icon > i {
            font-size: 70px;
            position: absolute;
            right: 15px;
            top: 15px;
            transition: transform .3s linear;
        }
        
        .small-box:hover .icon > i {
            transform: scale(1.1);
        }
        
        .small-box .small-box-footer {
            background: rgba(0,0,0,0.1);
            color: rgba(255,255,255,0.8);
            display: block;
            padding: 8px 0;
            position: relative;
            text-align: center;
            text-decoration: none;
            z-index: 10;
            transition: all 0.3s ease;
        }
        
        .small-box .small-box-footer:hover {
            color: #fff;
            background: rgba(0,0,0,0.15);
            text-decoration: none;
        }
        
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 0.5rem;
            background: #fff;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            width: 100%;
        }
        
        .info-box .info-box-icon {
            border-radius: 0.5rem;
            align-items: center;
            display: flex;
            font-size: 1.875rem;
            justify-content: center;
            text-align: center;
            width: 70px;
        }
        
        .info-box .info-box-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.8;
            flex: 1;
            padding: 0 10px;
        }
        
        .sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active {
            background-color: #007bff;
            color: #fff;
        }
        
        .navbar-badge {
            font-size: 0.6rem;
            font-weight: 700;
            padding: 0.25rem 0.4rem;
            position: absolute;
            right: -0.4rem;
            top: -0.4rem;
        }
        
        .user-panel {
            border-bottom: 1px solid #4f5962;
            padding: 10px;
        }
        
        .user-panel .info {
            display: inline-block;
            line-height: 1;
            padding: 5px 5px 5px 15px;
        }
        
        .user-panel .image {
            display: inline-block;
            padding-left: 10px;
        }
        
        .user-panel img {
            height: auto;
            width: 2.1rem;
        }
        
        .brand-link {
            border-bottom: 1px solid #4f5962;
            color: rgba(255,255,255,0.8);
            display: block;
            font-size: 1.25rem;
            line-height: 1.5;
            padding: 0.8125rem 0.5rem;
            text-decoration: none;
            white-space: nowrap;
        }
        
        .brand-link:hover {
            color: #fff;
            text-decoration: none;
        }
        
        .brand-image {
            float: left;
            line-height: .8;
            margin-left: .8rem;
            margin-right: .5rem;
            margin-top: -3px;
            max-height: 33px;
            width: auto;
        }
        
        .content-header {
            padding: 15px .5rem;
        }
        
        .content-header h1 {
            font-size: 1.8rem;
            margin: 0;
        }
        
        .breadcrumb {
            background: transparent;
            margin-bottom: 0;
            padding: 0;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        .activity-item {
            border-left: 3px solid #007bff;
            padding: 10px 15px;
            margin-bottom: 10px;
            background: #fff;
            border-radius: 0 0.5rem 0.5rem 0;
            transition: all 0.3s ease;
        }
        
        .activity-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }
        
        .activity-item.academic {
            border-left-color: #007bff;
        }
        
        .activity-item.career {
            border-left-color: #28a745;
        }
        
        .activity-item.personal {
            border-left-color: #ffc107;
        }
        
        .activity-item.social {
            border-left-color: #17a2b8;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .stats-card p {
            margin-bottom: 0;
            opacity: 0.9;
        }
        
        .quick-action-btn {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0.25rem;
        }
        
        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .notification-item {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }
        
        .notification-item:hover {
            background-color: #f8f9fa;
        }
        
        .notification-item:last-child {
            border-bottom: none;
        }
        
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            background-color: #f8f9fa;
        }
        
        .badge-status {
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .progress-sm {
            height: 0.5rem;
        }
        
        .sidebar-mini.sidebar-collapse .main-sidebar:hover .brand-text,
        .sidebar-mini.sidebar-collapse .main-sidebar:hover .user-panel > .info {
            display: inline-block !important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="/placeholder.svg?height=60&width=60" alt="Logo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Cari..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            
            <!-- User Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <img src="/placeholder.svg?height=30&width=30" alt="User Avatar" class="img-circle" style="width: 30px; height: 30px;">
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <div class="dropdown-header">
                        <strong>Administrator</strong><br>
                        <small class="text-muted">admin@sekolah.com</small>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profil
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-cog mr-2"></i> Pengaturan
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <img src="/placeholder.svg?height=33&width=33" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Sistem Konseling</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/placeholder.svg?height=160&width=160" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Administrator</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

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
                    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Manajemen User
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">3</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.student') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Siswa</p>
                                    <span class="badge badge-primary right">150</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.counselor') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Konselor</p>
                                    <span class="badge badge-success right">12</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.administrator') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Administrator</p>
                                    <span class="badge badge-warning right">3</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- School Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-school"></i>
                            <p>
                                Manajemen Sekolah
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.class') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Counseling Management -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>
                                Manajemen Konseling
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-danger right">8</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Permintaan Konseling</p>
                                    <span class="badge badge-danger right">8</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-header">AKSI CEPAT</li>
                    
                    <!-- Quick Actions -->
                    <li class="nav-item">
                        <a href="{{ route('admin.student') }}" class="nav-link">
                            <i class="nav-icon fas fa-plus text-success"></i>
                            <p>Tambah Siswa</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.counselor') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-plus text-info"></i>
                            <p>Tambah Konselor</p>
                        </a>
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
        <strong>Copyright &copy; 2025 <a href="#">STMCounseling</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.15.2/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>
<!-- Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<!-- Bootstrap DateRangePicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js"></script>

@yield('scripts')

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Initialize DataTables
    $('.data-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
        }
    });
    
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-toggle="popover"]').popover();
    
    // Auto-hide alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Sidebar toggle
    $('[data-widget="pushmenu"]').on('click', function() {
        $('body').toggleClass('sidebar-collapse');
    });
});

// Global AJAX setup
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Global error handler
$(document).ajaxError(function(event, xhr, settings, thrownError) {
    if (xhr.status === 419) {
        Swal.fire({
            icon: 'error',
            title: 'Session Expired',
            text: 'Sesi Anda telah berakhir. Silakan refresh halaman.',
            confirmButtonText: 'Refresh'
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    }
});

// Real-time notifications (placeholder)
function updateNotifications() {
    // Implementation for real-time notifications
    console.log('Checking for new notifications...');
}

// Check for notifications every 30 seconds
setInterval(updateNotifications, 30000);
</script>
</body>
</html>
