{{-- filepath: d:\Project\School_App\counseling\counseling-fix\SchoolApp-Counseling\resources\views\teacher\dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Konselor')

@section('styles')
<style>
    .stats-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    
    .request-card {
        border-left: 4px solid #6c5ce7;
        transition: all 0.3s ease;
    }
    
    .request-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .priority-high {
        border-left-color: #dc3545;
    }
    
    .priority-medium {
        border-left-color: #ffc107;
    }
    
    .priority-low {
        border-left-color: #28a745;
    }
    
    .calendar-event {
        background-color: #6c5ce7;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-bottom: 2px;
        display: block;
    }
    
    .quick-action-btn {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .activity-item {
        border-left: 3px solid #e9ecef;
        padding-left: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #6c5ce7;
    }
    
    .activity-time {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Dashboard Konselor</h1>
                    <p class="text-muted mb-0">Selamat datang kembali, {{ auth()->user()->name }}</p>
                </div>
                <div>
                   <a href="{{ route('teacher.request') }}" class="btn btn-outline-primary quick-action-btn">
                        <i class="fas fa-file-alt me-2"></i>Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $pendingRequests }}</h3>
                            <p class="text-muted mb-0">Permintaan Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success me-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $todaySessions }}</h3>
                            <p class="text-muted mb-0">Sesi Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $activeStudents }}</h3>
                            <p class="text-muted mb-0">Siswa Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info me-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">{{ $monthlySessions }}</h3>
                            <p class="text-muted mb-0">Total Sesi Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permintaan Konseling Terbaru -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Permintaan Konseling Terbaru</h5>
                </div>
                <div class="card-body">
                    @forelse ($latestRequests as $request)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1"><strong>{{ $request->student->nama }}</strong> mengajukan konseling.</p>
                                <p class="mb-1"><strong>Kategori:</strong> {{ $request->kategori }}</p>
                                <p class="mb-1"><strong>Deskripsi:</strong> {{ $request->deskripsi }}</p>
                                <div class="activity-time">{{ $request->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="badge bg-{{ $request->priorityBadge }}">{{ $request->priorityLabel }}</span>
                        </div>
                        <!-- Action Buttons -->
                        <div class="mt-2">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal" onclick="setRequestId({{ $request->id }})">
                                <i class="fas fa-check"></i> Terima
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal" onclick="setRequestId({{ $request->id }})">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#completeModal" onclick="setRequestId({{ $request->id }})">
                                <i class="fas fa-check-circle"></i> Selesaikan
                            </button>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada permintaan konseling terbaru.</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Jadwal Hari Ini -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Jadwal Hari Ini</h5>
                    <small class="text-muted">{{ now()->format('d F Y') }}</small>
                </div>
                <div class="card-body">
                    @forelse ($todaySchedule as $schedule)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold">{{ $schedule->tanggal_permintaan->format('H:i') }}</span>
                            <span class="badge bg-primary">{{ $schedule->kategori }}</span>
                        </div>
                        <p class="mb-1">{{ $schedule->student->nama }} - Kelas {{ $schedule->student->class }}</p>
                        <small class="text-muted">{{ $schedule->deskripsi }}</small>
                    </div>
                    @empty
                    <p class="text-muted">Tidak ada jadwal konseling untuk hari ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Terima Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menerima permintaan konseling ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="approveRequest()">Terima</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menolak permintaan konseling ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="rejectRequest()">Tolak</button>
            </div>
        </div>
    </div>
</div>

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="completeModalLabel">Selesaikan Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menyelesaikan permintaan konseling ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="completeRequest()">Selesaikan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentRequestId = null;

    function setRequestId(requestId) {
        currentRequestId = requestId;
    }

    function approveRequest() {
        if (currentRequestId) {
            fetch(`/request/${currentRequestId}/approve`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    alert('Permintaan konseling berhasil diterima!');
                    location.reload();
                } else {
                    alert('Gagal menerima permintaan konseling.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }

    function rejectRequest() {
        if (currentRequestId) {
            fetch(`/request/${currentRequestId}/reject`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    alert('Permintaan konseling berhasil ditolak.');
                    location.reload();
                } else {
                    alert('Gagal menolak permintaan konseling.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }

    function completeRequest() {
        if (currentRequestId) {
            fetch(`/request/${currentRequestId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    alert('Permintaan konseling berhasil diselesaikan.');
                    location.reload();
                } else {
                    alert('Gagal menyelesaikan permintaan konseling.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    }
</script>
@endsection