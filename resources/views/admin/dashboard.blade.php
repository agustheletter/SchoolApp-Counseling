@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Administrator')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Siswa</span>
                <span class="info-box-number">
                    1,410
                    <small>siswa</small>
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user-tie"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Konselor</span>
                <span class="info-box-number">
                    24
                    <small>konselor</small>
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-comments"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Sesi Bulan Ini</span>
                <span class="info-box-number">
                    186
                    <small>sesi</small>
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Permintaan Pending</span>
                <span class="info-box-number">
                    8
                    <small>permintaan</small>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>
                <p>Siswa Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>
                <p>Tingkat Kehadiran</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>
                <p>Sesi Minggu Ini</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>65</h3>
                <p>Kasus Diselesaikan</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Statistik Konseling
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut Chart</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart">
                        <div class="chart-container">
                            <canvas id="revenue-chart-canvas"></canvas>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="sales-chart">
                        <div class="chart-container">
                            <canvas id="sales-chart-canvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terbaru -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-history mr-1"></i>
                    Aktivitas Terbaru
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="activity-item academic">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Sesi konseling akademik selesai</h6>
                            <p class="text-muted mb-0 small">Dr. Sarah dengan siswa Rina Wijaya - Kelas XII IPA 1</p>
                        </div>
                        <small class="text-muted">5 menit lalu</small>
                    </div>
                </div>
                
                <div class="activity-item career">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Permintaan konseling karir baru</h6>
                            <p class="text-muted mb-0 small">Dari siswa Budi Santoso - Kelas XI IPS 2</p>
                        </div>
                        <small class="text-muted">15 menit lalu</small>
                    </div>
                </div>
                
                <div class="activity-item personal">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Laporan konseling pribadi dibuat</h6>
                            <p class="text-muted mb-0 small">Ahmad Wijaya membuat laporan untuk siswa Sari Indah</p>
                        </div>
                        <small class="text-muted">1 jam lalu</small>
                    </div>
                </div>
                
                <div class="activity-item social">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Siswa baru terdaftar</h6>
                            <p class="text-muted mb-0 small">5 siswa baru ditambahkan ke sistem</p>
                        </div>
                        <small class="text-muted">2 jam lalu</small>
                    </div>
                </div>
                
                <div class="activity-item academic">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">Backup data sistem berhasil</h6>
                            <p class="text-muted mb-0 small">Backup otomatis database dan file sistem</p>
                        </div>
                        <small class="text-muted">3 jam lalu</small>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua Aktivitas</a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-primary quick-action-btn btn-block">
                            <i class="fas fa-user-plus mr-2"></i>Tambah Siswa Baru
                        </button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-success quick-action-btn btn-block">
                            <i class="fas fa-user-tie mr-2"></i>Tambah Konselor
                        </button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-info quick-action-btn btn-block">
                            <i class="fas fa-download mr-2"></i>Export Data
                        </button>
                    </div>
                    <div class="col-md-6 mb-3">
                        <button class="btn btn-warning quick-action-btn btn-block">
                            <i class="fas fa-database mr-2"></i>Backup Sistem
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Right col -->
    <section class="col-lg-5 connectedSortable">
        <!-- Notifikasi Penting -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-bell mr-1"></i>
                    Notifikasi Penting
                </h3>
                <div class="card-tools">
                    <span class="badge badge-danger">3</span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="notification-item">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon bg-danger">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Permintaan Konseling Darurat</h6>
                            <p class="text-muted mb-0 small">Siswa membutuhkan konseling segera</p>
                            <small class="text-muted">2 menit lalu</small>
                        </div>
                    </div>
                </div>
                
                <div class="notification-item">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon bg-warning">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Jadwal Konseling Bentrok</h6>
                            <p class="text-muted mb-0 small">2 sesi dijadwalkan pada waktu yang sama</p>
                            <small class="text-muted">15 menit lalu</small>
                        </div>
                    </div>
                </div>
                
                <div class="notification-item">
                    <div class="d-flex align-items-center">
                        <div class="notification-icon bg-info">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">Update Sistem Tersedia</h6>
                            <p class="text-muted mb-0 small">Versi 1.1.0 siap untuk diinstall</p>
                            <small class="text-muted">1 jam lalu</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua Notifikasi</a>
            </div>
        </div>

        <!-- Statistik Konselor -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-1"></i>
                    Performa Konselor
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">Dr. Sarah Johnson</h6>
                        <small class="text-muted">Konselor Akademik</small>
                    </div>
                    <div class="text-right">
                        <h6 class="mb-0">24 sesi</h6>
                        <small class="text-success">+12%</small>
                    </div>
                </div>
                <div class="progress progress-sm mb-3">
                    <div class="progress-bar bg-primary" style="width: 80%"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">Ahmad Wijaya, M.Pd</h6>
                        <small class="text-muted">Konselor Karir</small>
                    </div>
                    <div class="text-right">
                        <h6 class="mb-0">18 sesi</h6>
                        <small class="text-success">+8%</small>
                    </div>
                </div>
                <div class="progress progress-sm mb-3">
                    <div class="progress-bar bg-success" style="width: 65%"></div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">Siti Nurhaliza, S.Psi</h6>
                        <small class="text-muted">Konselor Pribadi</small>
                    </div>
                    <div class="text-right">
                        <h6 class="mb-0">15 sesi</h6>
                        <small class="text-warning">-2%</small>
                    </div>
                </div>
                <div class="progress progress-sm mb-3">
                    <div class="progress-bar bg-warning" style="width: 55%"></div>
                </div>
            </div>
        </div>

        <!-- Jadwal Hari Ini -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-day mr-1"></i>
                    Jadwal Hari Ini
                </h3>
                <div class="card-tools">
                    <span class="badge badge-primary">5 sesi</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Konselor</th>
                                <th>Siswa</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09:00</td>
                                <td>Dr. Sarah</td>
                                <td>Rina W.</td>
                                <td><span class="badge badge-success badge-status">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>10:30</td>
                                <td>Ahmad W.</td>
                                <td>Budi S.</td>
                                <td><span class="badge badge-primary badge-status">Berlangsung</span></td>
                            </tr>
                            <tr>
                                <td>13:00</td>
                                <td>Siti N.</td>
                                <td>Sari I.</td>
                                <td><span class="badge badge-warning badge-status">Terjadwal</span></td>
                            </tr>
                            <tr>
                                <td>14:30</td>
                                <td>Dr. Sarah</td>
                                <td>Andi P.</td>
                                <td><span class="badge badge-warning badge-status">Terjadwal</span></td>
                            </tr>
                            <tr>
                                <td>15:30</td>
                                <td>Ahmad W.</td>
                                <td>Dewi S.</td>
                                <td><span class="badge badge-warning badge-status">Terjadwal</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-server mr-1"></i>
                    Status Sistem
                </h3>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Server Status</span>
                    <span class="badge badge-success">Online</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Database</span>
                    <span class="badge badge-success">Connected</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Storage</span>
                    <span class="badge badge-warning">75% Used</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Last Backup</span>
                    <span class="badge badge-info">2 hours ago</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Active Users</span>
                    <span class="badge badge-primary">42 online</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    'use strict'

    // Area Chart
    var areaChartCanvas = $('#revenue-chart-canvas').get(0).getContext('2d')
    var areaChartData = {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        datasets: [
            {
                label: 'Akademik',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: [28, 48, 40, 19, 86, 27, 90, 65, 45, 78, 52, 69]
            },
            {
                label: 'Karir',
                backgroundColor: 'rgba(40, 167, 69, 0.9)',
                borderColor: 'rgba(40, 167, 69, 0.8)',
                pointRadius: false,
                pointColor: 'rgba(40, 167, 69, 1)',
                pointStrokeColor: '#28a745',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(40, 167, 69, 1)',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 38, 42, 48, 55]
            },
            {
                label: 'Pribadi',
                backgroundColor: 'rgba(255, 193, 7, 0.9)',
                borderColor: 'rgba(255, 193, 7, 0.8)',
                pointRadius: false,
                pointColor: '#ffc107',
                pointStrokeColor: 'rgba(255, 193, 7, 1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(255, 193, 7, 1)',
                data: [12, 16, 27, 18, 40, 39, 24, 28, 35, 32, 29, 31]
            },
            {
                label: 'Sosial',
                backgroundColor: 'rgba(23, 162, 184, 0.9)',
                borderColor: 'rgba(23, 162, 184, 0.8)',
                pointRadius: false,
                pointColor: '#17a2b8',
                pointStrokeColor: 'rgba(23, 162, 184, 1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(23, 162, 184, 1)',
                data: [8, 12, 15, 22, 18, 25, 20, 16, 19, 24, 21, 18]
            }
        ]
    }

    var areaChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true,
            position: 'top'
        },
        scales: {
            x: {
                grid: {
                    display: false,
                }
            },
            y: {
                grid: {
                    display: true,
                },
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false,
            }
        },
        interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
        }
    }

    new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
    })

    // Donut Chart
    var donutChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
    var donutData = {
        labels: [
            'Akademik',
            'Karir', 
            'Pribadi',
            'Sosial',
            'Lainnya'
        ],
        datasets: [
            {
                data: [700, 500, 400, 300, 100],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#6c757d'],
                borderWidth: 2,
                borderColor: '#fff'
            }
        ]
    }
    
    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'bottom'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        var label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += context.parsed + ' sesi';
                        return label;
                    }
                }
            }
        }
    }

    new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
    })

    // Make the dashboard widgets sortable Using jquery UI
    $('.connectedSortable').sortable({
        placeholder: 'sort-highlight',
        connectWith: '.connectedSortable',
        handle: '.card-header, .nav-tabs',
        forcePlaceholderSize: true,
        zIndex: 999999
    })
    $('.connectedSortable .card-header').css('cursor', 'move')

    // Real-time clock
    function updateClock() {
        var now = new Date();
        var timeString = now.toLocaleTimeString('id-ID');
        var dateString = now.toLocaleDateString('id-ID', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric'
        });
        
        // Update clock display if element exists
        if ($('#current-time').length) {
            $('#current-time').text(timeString);
        }
        if ($('#current-date').length) {
            $('#current-date').text(dateString);
        }
    }

    // Update clock every second
    setInterval(updateClock, 1000);
    updateClock(); // Initial call

    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // Refresh statistics
        refreshDashboardStats();
    }, 300000);

    function refreshDashboardStats() {
        // Implementation for refreshing dashboard statistics
        console.log('Refreshing dashboard statistics...');
        
        // Example AJAX call to refresh data
        /*
        $.ajax({
            url: '/admin/dashboard/stats',
            type: 'GET',
            success: function(data) {
                // Update statistics
                updateStatistics(data);
            },
            error: function() {
                console.log('Error refreshing dashboard stats');
            }
        });
        */
    }

    // Quick action button handlers
    $('.quick-action-btn').on('click', function() {
        var action = $(this).text().trim();
        
        Swal.fire({
            title: 'Konfirmasi',
            text: 'Apakah Anda yakin ingin melakukan: ' + action + '?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Handle specific actions
                handleQuickAction(action);
            }
        });
    });

    function handleQuickAction(action) {
        switch(action) {
            case 'Tambah Siswa Baru':
                // Redirect to add student page or open modal
                window.location.href = '/admin/users/students/create';
                break;
            case 'Tambah Konselor':
                // Redirect to add counselor page or open modal
                window.location.href = '/admin/users/counselors/create';
                break;
            case 'Export Data':
                // Trigger data export
                window.location.href = '/admin/export/all-data';
                break;
            case 'Backup Sistem':
                // Trigger system backup
                performSystemBackup();
                break;
            default:
                console.log('Unknown action:', action);
        }
    }

    function performSystemBackup() {
        Swal.fire({
            title: 'Memulai Backup...',
            text: 'Proses backup sedang berjalan, mohon tunggu.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate backup process
        setTimeout(() => {
            Swal.fire({
                icon: 'success',
                title: 'Backup Berhasil!',
                text: 'Data sistem telah berhasil di-backup.',
                timer: 3000,
                showConfirmButton: false
            });
        }, 3000);
    }

    // Initialize tooltips for all elements
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // Card widget collapse functionality
    $('[data-card-widget="collapse"]').on('click', function() {
        var card = $(this).closest('.card');
        var cardBody = card.find('.card-body');
        
        if (cardBody.is(':visible')) {
            cardBody.slideUp();
            $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
        } else {
            cardBody.slideDown();
            $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
        }
    });

    // Notification click handlers
    $('.notification-item').on('click', function() {
        var notificationType = $(this).find('.notification-icon').hasClass('bg-danger') ? 'urgent' : 'normal';
        
        if (notificationType === 'urgent') {
            Swal.fire({
                icon: 'warning',
                title: 'Notifikasi Penting',
                text: 'Ini adalah notifikasi yang memerlukan perhatian segera.',
                confirmButtonText: 'Tangani Sekarang',
                showCancelButton: true,
                cancelButtonText: 'Nanti'
            });
        }
    });
});

// Global functions for dashboard
function updateStatistics(data) {
    // Update dashboard statistics with new data
    if (data.totalStudents) {
        $('.info-box-number').first().text(data.totalStudents);
    }
    // Add more updates as needed
}

function showNotification(title, message, type = 'info') {
    Swal.fire({
        icon: type,
        title: title,
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

// Export function for external use
window.dashboardUtils = {
    refreshStats: refreshDashboardStats,
    showNotification: showNotification,
    updateStatistics: updateStatistics
};
</script>
@endsection
