@extends('layouts.app')

@section('title', 'Riwayat Konseling')

@section('styles')
<style>
    .status-badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
    
    .timeline {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 3rem;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        height: 100%;
        width: 2px;
        background-color: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        left: -3rem;
        top: 0.25rem;
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        border: 2px solid white;
        background-color: #6c5ce7;
        box-shadow: 0 0 0 4px rgba(108, 92, 231, 0.2);
    }
    
    .timeline-content {
        position: relative;
    }
    
    .timeline-date {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    
    .counseling-card {
        transition: transform 0.3s ease;
    }
    
    .counseling-card:hover {
        transform: translateY(-5px);
    }
    
    .rating-stars {
        color: #ffc107;
    }
    
    .rating-stars .far {
        color: #e9ecef;
    }
    
    .filter-btn.active {
        background-color: #6c5ce7;
        color: white;
    }
    
    /* PERBAIKAN UNTUK RATING PROGRESS BARS */
    .rating-row {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        min-height: 24px; /* Konstrain tinggi minimum */
    }
    
    .rating-row:last-child {
        margin-bottom: 0;
    }
    
    .rating-stars-fixed {
        width: 80px; /* Fixed width untuk konsistensi */
        flex-shrink: 0; /* Prevent shrinking */
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: #ffc107;
    }
    
    .rating-stars-fixed .far {
        color: #e9ecef;
    }
    
    .progress-container {
        flex: 1; /* Take remaining space */
        margin: 0 12px; /* Consistent spacing */
        min-width: 0; /* Allow shrinking if needed */
    }
    
    .progress-fixed {
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .rating-count {
        width: 20px; /* Fixed width untuk angka */
        flex-shrink: 0;
        text-align: right;
        font-size: 0.9rem;
        font-weight: 500;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold mb-0">Riwayat Konseling</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Riwayat Konseling</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                        <h5 class="card-title mb-3 mb-md-0">Ringkasan Aktivitas Konseling</h5>
                        <div class="btn-group" role="group" aria-label="Filter riwayat">
                            <button type="button" class="btn btn-outline-primary filter-btn active" data-filter="all">Semua</button>
                            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="completed">Selesai</button>
                            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="cancelled">Dibatalkan</button>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">12</h3>
                                    <p class="mb-0">Total Sesi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">10</h3>
                                    <p class="mb-0">Sesi Selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">0</h3>
                                    <p class="mb-0">Sesi Mendatang</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">2</h3>
                                    <p class="mb-0">Sesi Dibatalkan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Sesi Konseling</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" placeholder="Cari sesi..." aria-label="Cari sesi">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Sesi 1 -->
                        <div class="list-group-item p-3 counseling-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold">Konseling Akademik</h6>
                                <span class="badge bg-success status-badge">Selesai</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i> 15 Mei 2023, 10:00 - 11:00</p>
                                    <p class="mb-0 text-muted"><i class="fas fa-user me-2"></i> Guru Konseling 1</p>
                                </div>
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="mb-2"><small>Topik: Strategi belajar efektif untuk persiapan ujian akhir</small></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-light text-dark me-1">Akademik</span>
                                    <span class="badge bg-light text-dark">Ujian</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionDetailModal1">Detail</a>
                            </div>
                        </div>
                        
                        <!-- Sesi 2 -->
                        <div class="list-group-item p-3 counseling-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold">Konseling Karir</h6>
                                <span class="badge bg-success status-badge">Selesai</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i> 28 April 2023, 13:00 - 14:00</p>
                                    <p class="mb-0 text-muted"><i class="fas fa-user me-2"></i> Guru Konseling 2</p>
                                </div>
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <p class="mb-2"><small>Topik: Eksplorasi minat dan bakat untuk pemilihan jurusan kuliah</small></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-light text-dark me-1">Karir</span>
                                    <span class="badge bg-light text-dark">Kuliah</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionDetailModal2">Detail</a>
                            </div>
                        </div>
                        
                        <!-- Sesi 3 -->
                        <div class="list-group-item p-3 counseling-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold">Konseling Pribadi</h6>
                                <span class="badge bg-danger status-badge">Dibatalkan</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i> 10 April 2023, 15:00 - 16:00</p>
                                    <p class="mb-0 text-muted"><i class="fas fa-user me-2"></i> Guru Konseling 3</p>
                                </div>
                                <div class="rating-stars">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <p class="mb-2"><small>Topik: Manajemen stres dan kecemasan</small></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-light text-dark me-1">Pribadi</span>
                                    <span class="badge bg-light text-dark">Stres</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionDetailModal3">Detail</a>
                            </div>
                        </div>
                        
                        <!-- Sesi 4 -->
                        <div class="list-group-item p-3 counseling-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold">Konseling Sosial</h6>
                                <span class="badge bg-success status-badge">Selesai</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i> 22 Maret 2023, 09:00 - 10:00</p>
                                    <p class="mb-0 text-muted"><i class="fas fa-user me-2"></i> Guru Konseling 4</p>
                                </div>
                                <div class="rating-stars">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <p class="mb-2"><small>Topik: Pengembangan keterampilan komunikasi dan resolusi konflik</small></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-light text-dark me-1">Sosial</span>
                                    <span class="badge bg-light text-dark">Komunikasi</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionDetailModal4">Detail</a>
                            </div>
                        </div>
                        
                        <!-- Sesi 5 -->
                        <div class="list-group-item p-3 counseling-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 fw-bold">Konseling Akademik</h6>
                                <span class="badge bg-danger status-badge">Dibatalkan</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="mb-0 text-muted"><i class="fas fa-calendar-alt me-2"></i> 5 Maret 2023, 14:00 - 15:00</p>
                                    <p class="mb-0 text-muted"><i class="fas fa-user me-2"></i> Guru Konseling 5</p>
                                </div>
                                <div class="rating-stars">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <p class="mb-2"><small>Topik: Perencanaan studi dan pemilihan mata pelajaran</small></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-light text-dark me-1">Akademik</span>
                                    <span class="badge bg-light text-dark">Perencanaan</span>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sessionDetailModal5">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistik Konseling</h5>
                </div>

                    <div>
                        <h6 class="mb-3">Konselor yang Paling Sering Dikonsultasi</h6>
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/50x50" class="rounded-circle me-3" alt="Guru Konseling 1">
                            <div>
                                <h6 class="mb-0">Guru Konseling 1</h6>
                                <p class="text-muted mb-0 small">5 sesi</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://via.placeholder.com/50x50" class="rounded-circle me-3" alt="Guru Konseling 2">
                            <div>
                                <h6 class="mb-0">Guru Konseling 2</h6>
                                <p class="text-muted mb-0 small">3 sesi</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/50x50" class="rounded-circle me-3" alt="Guru Konseling 3">
                            <div>
                                <h6 class="mb-0">Guru Konseling 3</h6>
                                <p class="text-muted mb-0 small">2 sesi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="sessionDetailModal1" tabindex="-1" aria-labelledby="sessionDetailModal1Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sessionDetailModal1Label">Detail Sesi Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Informasi Sesi</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Jenis Konseling</strong></td>
                                <td>Konseling Akademik</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal & Waktu</strong></td>
                                <td>15 Mei 2023, 10:00 - 11:00</td>
                            </tr>
                            <tr>
                                <td><strong>Konselor</strong></td>
                                <td>Dr. Andi Wijaya</td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><strong>Metode</strong></td>
                                <td>Tatap Muka</td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi</strong></td>
                                <td>Ruang Konseling 2, Gedung A</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Topik & Tujuan</h6>
                        <p>Strategi belajar efektif untuk persiapan ujian akhir</p>
                        <p><strong>Tujuan:</strong> Mengembangkan strategi belajar yang efektif dan manajemen waktu untuk persiapan ujian akhir semester.</p>
                        
                        <h6 class="mt-4">Penilaian</h6>
                        <div class="rating-stars mb-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p><strong>Komentar:</strong> "Sesi yang sangat membantu. Dr. Andi memberikan strategi belajar yang praktis dan sesuai dengan gaya belajar saya."</p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h6>Ringkasan Sesi</h6>
                    <p>Dalam sesi ini, kami membahas berbagai strategi belajar yang efektif untuk persiapan ujian akhir. Dr. Andi membantu saya mengidentifikasi gaya belajar yang paling sesuai untuk saya dan memberikan teknik-teknik spesifik untuk memaksimalkan waktu belajar.</p>
                    <p>Kami juga membuat jadwal belajar yang terstruktur dengan mempertimbangkan mata pelajaran yang perlu fokus lebih dan teknik manajemen waktu untuk menghindari prokrastinasi.</p>
                </div>
                
                <div class="mb-4">
                    <h6>Rekomendasi & Tindak Lanjut</h6>
                    <ul>
                        <li>Menerapkan teknik Pomodoro (25 menit belajar, 5 menit istirahat) untuk meningkatkan fokus</li>
                        <li>Membuat mind mapping untuk mata pelajaran yang membutuhkan pemahaman konsep</li>
                        <li>Menggunakan flashcard untuk mata pelajaran yang membutuhkan hafalan</li>
                        <li>Bergabung dengan kelompok belajar untuk mata pelajaran Matematika dan Fisika</li>
                        <li>Tindak lanjut sesi dalam 2 minggu untuk evaluasi kemajuan</li>
                    </ul>
                </div>
                
                <div>
                    <h6>Dokumen & Materi</h6>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-file-pdf me-2 text-danger"></i> Panduan Teknik Belajar Efektif.pdf
                            </div>
                            <span class="badge bg-primary rounded-pill">Download</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-file-excel me-2 text-success"></i> Template Jadwal Belajar.xlsx
                            </div>
                            <span class="badge bg-primary rounded-pill">Download</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-link me-2 text-info"></i> Sumber Belajar Online
                            </div>
                            <span class="badge bg-primary rounded-pill">Buka</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Cetak Ringkasan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Sesi 2-5 (struktur serupa dengan Modal 1) -->
<!-- Untuk menghemat ruang, modal lainnya tidak ditampilkan di sini -->

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart untuk jenis konseling
        var ctx = document.getElementById('counselingTypeChart').getContext('2d');
        var counselingTypeChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Akademik', 'Karir', 'Pribadi', 'Sosial'],
                datasets: [{
                    data: [5, 3, 2, 2],
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
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12
                        }
                    }
                },
                cutout: '70%'
            }
        });
        
        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');
                
                // Implementasi filter sebenarnya akan memerlukan AJAX atau manipulasi DOM
                // Ini hanya contoh sederhana
                var filter = this.getAttribute('data-filter');
                console.log('Filter by: ' + filter);
                
                // Untuk demo, kita hanya menampilkan alert
                if (filter === 'all') {
                    alert('Menampilkan semua sesi konseling');
                } else if (filter === 'completed') {
                    alert('Menampilkan sesi konseling yang selesai');
                } else if (filter === 'cancelled') {
                    alert('Menampilkan sesi konseling yang dibatalkan');
                }
            });
        });
    });
</script>
@endsection