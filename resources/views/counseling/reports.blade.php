@extends('layouts.app')

@section('title', 'Laporan Konseling')

@section('styles')
<style>
    .report-card {
        transition: transform 0.2s;
    }
    
    .report-card:hover {
        transform: translateY(-5px);
    }
    
    .report-icon {
        font-size: 2rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 1rem;
    }
    
    .chart-container {
        height: 300px;
        position: relative;
    }
    
    .session-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .session-timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    
    .timeline-dot {
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #6c5ce7;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
    }
    
    .timeline-dot.completed {
        background-color: #28a745;
    }
    
    .timeline-content {
        background-color: white;
        border-radius: 0.375rem;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .progress-label {
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .progress {
        height: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <!-- Sidebar Menu -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Menu Siswa</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('counseling.request') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Ajukan Konseling
                    </a>
                    <a href="{{ route('counseling.my-requests') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Permintaan Saya
                    </a>
                    <a href="{{ route('counseling.schedule') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Konseling
                    </a>
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope me-2"></i> Pesan
                    </a>
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
                    </a>
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>
            
            <!-- Report Filters -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="reportPeriod" class="form-label">Periode</label>
                            <select class="form-select" id="reportPeriod">
                                <option value="all" selected>Semua Waktu</option>
                                <option value="month">Bulan Ini</option>
                                <option value="quarter">3 Bulan Terakhir</option>
                                <option value="semester">Semester Ini</option>
                                <option value="year">Tahun Ini</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reportCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="reportCategory">
                                <option value="all" selected>Semua Kategori</option>
                                <option value="academic">Akademik</option>
                                <option value="career">Karir</option>
                                <option value="personal">Pribadi</option>
                                <option value="social">Sosial</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reportCounselor" class="form-label">Konselor</label>
                            <select class="form-select" id="reportCounselor">
                                <option value="all" selected>Semua Konselor</option>
                                <option value="1">Dr. Andi Wijaya</option>
                                <option value="2">Siti Rahayu, M.Psi</option>
                                <option value="3">Budi Santoso, S.Pd</option>
                                <option value="4">Dewi Lestari, M.Pd</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" id="applyFilters">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="card shadow-sm report-card h-100">
                        <div class="card-body text-center">
                            <div class="report-icon bg-primary-subtle text-primary mx-auto">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h3 class="mb-0">5</h3>
                            <p class="text-muted mb-0">Total Sesi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="card shadow-sm report-card h-100">
                        <div class="card-body text-center">
                            <div class="report-icon bg-success-subtle text-success mx-auto">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h3 class="mb-0">4</h3>
                            <p class="text-muted mb-0">Sesi Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="card shadow-sm report-card h-100">
                        <div class="card-body text-center">
                            <div class="report-icon bg-warning-subtle text-warning mx-auto">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3 class="mb-0">1</h3>
                            <p class="text-muted mb-0">Sesi Mendatang</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm report-card h-100">
                        <div class="card-body text-center">
                            <div class="report-icon bg-info-subtle text-info mx-auto">
                                <i class="fas fa-star"></i>
                            </div>
                            <h3 class="mb-0">4.8</h3>
                            <p class="text-muted mb-0">Rating Rata-rata</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Charts -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Kategori Konseling</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Tren Konseling</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Tracking -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Perkembangan Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="progress-label d-flex justify-content-between">
                                <span>Pemahaman Materi Akademik</span>
                                <span>75%</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">Peningkatan pemahaman materi Matematika, terutama Kalkulus.</small>
                        </div>
                        <div class="col-md-6">
                            <div class="progress-label d-flex justify-content-between">
                                <span>Manajemen Kecemasan</span>
                                <span>60%</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">Kemampuan mengelola kecemasan saat menghadapi ujian.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="progress-label d-flex justify-content-between">
                                <span>Perencanaan Karir</span>
                                <span>40%</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">Pemahaman tentang pilihan jurusan dan karir masa depan.</small>
                        </div>
                        <div class="col-md-6">
                            <div class="progress-label d-flex justify-content-between">
                                <span>Keterampilan Sosial</span>
                                <span>85%</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">Kemampuan berinteraksi dan beradaptasi dengan lingkungan baru.</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Session Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Riwayat Sesi Konseling</h5>
                </div>
                <div class="card-body">
                    <div class="session-timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot completed">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Konseling Sosial</h6>
                                    <span class="badge bg-secondary">Selesai</span>
                                </div>
                                <p class="mb-1">Adaptasi dengan lingkungan sekolah baru</p>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="fas fa-user me-1"></i> Dewi Lestari, M.Pd</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> 10 Mei 2023</span>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <strong>Catatan Konselor:</strong>
                                    <p class="mb-0 small">Ahmad menunjukkan kemajuan yang signifikan dalam beradaptasi dengan lingkungan sekolah baru. Ia mulai aktif berpartisipasi dalam kegiatan ekstrakurikuler dan membentuk pertemanan baru.</p>
                                </div>
                                <div>
                                    <strong>Rekomendasi:</strong>
                                    <p class="mb-0 small">Terus berpartisipasi dalam kegiatan sosial dan bergabung dengan klub sesuai minat untuk memperluas jaringan pertemanan.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot completed">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Konseling Akademik</h6>
                                    <span class="badge bg-secondary">Selesai</span>
                                </div>
                                <p class="mb-1">Strategi belajar efektif</p>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="fas fa-user me-1"></i> Dr. Andi Wijaya</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> 5 Mei 2023</span>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <strong>Catatan Konselor:</strong>
                                    <p class="mb-0 small">Ahmad memiliki potensi akademik yang baik, tetapi perlu meningkatkan manajemen waktu dan teknik belajar. Kami telah mendiskusikan beberapa strategi belajar yang sesuai dengan gaya belajarnya.</p>
                                </div>
                                <div>
                                    <strong>Rekomendasi:</strong>
                                    <p class="mb-0 small">Menerapkan teknik Pomodoro untuk manajemen waktu dan membuat jadwal belajar mingguan. Fokus pada pemahaman konsep daripada menghafal.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot completed">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Konseling Pribadi</h6>
                                    <span class="badge bg-secondary">Selesai</span>
                                </div>
                                <p class="mb-1">Mengatasi kecemasan menghadapi ujian</p>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="fas fa-user me-1"></i> Siti Rahayu, M.Psi</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> 28 April 2023</span>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <strong>Catatan Konselor:</strong>
                                    <p class="mb-0 small">Ahmad mengalami kecemasan yang cukup tinggi saat menghadapi ujian. Kami telah membahas teknik relaksasi dan perubahan pola pikir untuk mengatasi kecemasan tersebut.</p>
                                </div>
                                <div>
                                    <strong>Rekomendasi:</strong>
                                    <p class="mb-0 small">Praktikkan teknik pernapasan dan mindfulness sebelum ujian. Persiapkan diri dengan baik dan hindari belajar berlebihan di menit-menit terakhir.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot completed">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Konseling Karir</h6>
                                    <span class="badge bg-secondary">Selesai</span>
                                </div>
                                <p class="mb-1">Eksplorasi minat dan bakat</p>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="fas fa-user me-1"></i> Budi Santoso, S.Pd</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> 15 April 2023</span>
                                </div>
                                <hr>
                                <div class="mb-2">
                                    <strong>Catatan Konselor:</strong>
                                    <p class="mb-0 small">Ahmad memiliki minat yang kuat di bidang sains dan teknologi. Kami telah melakukan tes minat bakat dan mendiskusikan berbagai pilihan jurusan yang sesuai dengan minatnya.</p>
                                </div>
                                <div>
                                    <strong>Rekomendasi:</strong>
                                    <p class="mb-0 small">Mengikuti kegiatan ekstrakurikuler yang berkaitan dengan sains dan teknologi. Mencari informasi lebih lanjut tentang jurusan Teknik Informatika, Teknik Elektro, dan Ilmu Komputer.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Konseling Akademik</h6>
                                    <span class="badge bg-success">Disetujui</span>
                                </div>
                                <p class="mb-1">Kesulitan dalam memahami pelajaran Matematika</p>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="fas fa-user me-1"></i> Dr. Andi Wijaya</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> 15 Mei 2023</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Akademik', 'Karir', 'Pribadi', 'Sosial'],
                datasets: [{
                    data: [2, 1, 1, 1],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#f6c23e',
                        '#e74a3b'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9',
                        '#17a673',
                        '#f4b619',
                        '#e02d1b'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });
        
        // Trend Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        const trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei'],
                datasets: [{
                    label: 'Jumlah Sesi',
                    data: [0, 1, 1, 2, 1],
                    backgroundColor: 'rgba(108, 92, 231, 0.2)',
                    borderColor: 'rgba(108, 92, 231, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(108, 92, 231, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Filter button handler
        document.getElementById('applyFilters').addEventListener('click', function() {
            // In a real app, this would send an AJAX request to filter the data
            alert('Filter diterapkan. Data akan diperbarui sesuai filter yang dipilih.');
            
            // For demo purposes, we'll just show a loading indicator
            const chartContainers = document.querySelectorAll('.chart-container');
            chartContainers.forEach(container => {
                container.innerHTML = '<div class="d-flex justify-content-center align-items-center h-100"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            });
            
            // Simulate loading data
            setTimeout(() => {
                location.reload();
            }, 1500);
        });
    });
</script>
@endsection