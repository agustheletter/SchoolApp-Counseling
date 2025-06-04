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
    
    .timeline-content {
        background-color: white;
        border-radius: 0.375rem;
        padding: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
                    @if (Auth::user()->role === 'user')
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action    ">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('counseling.request') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-plus-circle me-2"></i> Ajukan Konseling
                    </a>
                    <a href="{{ route('counseling.my-requests') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Permintaan Saya
                    </a>
                    <a href="{{ route('counseling.history') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-history me-2"></i> Riwayat Konseling
                    </a>
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-file-alt me-2"></i> Laporan
                    </a>
                    @endif
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-comments me-2"></i> Pesan
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
                    <form id="filterForm">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="all">Semua Kategori</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Karir">Karir</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="all">Semua Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Disetujui</option>
                                <option value="Completed">Selesai</option>
                                <option value="Rejected">Ditolak</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Summary Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-4 mb-md-0">
                    <div class="card shadow-sm report-card h-100">
                        <div class="card-body text-center">
                            <div class="report-icon bg-primary-subtle text-primary mx-auto">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h3 class="mb-0">{{ $counselingSessions->count() }}</h3>
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
                            <h3 class="mb-0">{{ $counselingSessions->where('status', 'Completed')->count() }}</h3>
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
                            <h3 class="mb-0">{{ $counselingSessions->where('status', 'Pending')->count() }}</h3>
                            <p class="text-muted mb-0">Sesi Pending</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm report-card h-100">
                        <div class="card-body text-center">
                            <div class="report-icon bg-danger-subtle text-danger mx-auto">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <h3 class="mb-0">{{ $counselingSessions->where('status', 'Rejected')->count() }}</h3>
                            <p class="text-muted mb-0">Sesi Ditolak</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Session Timeline -->
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Riwayat Sesi Konseling</h5>
                    <button class="btn btn-sm btn-success" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-1"></i> Export
                    </button>
                </div>
                <div class="card-body">
                    <div class="session-timeline">
                        @forelse($counselingSessions as $session)
                        <div class="timeline-item mb-4">
                            <div class="timeline-dot {{ $session->status === 'Completed' ? 'bg-success' : '' }}">
                                <i class="fas {{ $session->status === 'Completed' ? 'fa-check' : 'fa-clock' }}"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">{{ $session->kategori }}</h6>
                                    <span class="badge bg-{{ $session->status === 'Completed' ? 'success' : 
                                        ($session->status === 'Pending' ? 'warning' : 
                                        ($session->status === 'Rejected' ? 'danger' : 'primary')) }}">
                                        {{ $session->status }}
                                    </span>
                                </div>
                                <p class="mb-1">{{ $session->deskripsi }}</p>
                                <div class="d-flex justify-content-between align-items-center text-muted small">
                                    <span><i class="fas fa-user me-1"></i> {{ $session->counselor->nama }}</span>
                                    <span><i class="fas fa-calendar-alt me-1"></i> 
                                        {{ \Carbon\Carbon::parse($session->tanggal_permintaan)->format('d M Y') }}
                                    </span>
                                </div>
                                @if($session->counselingSession && $session->counselingSession->hasil_konseling)
                                <hr>
                                <div class="mt-2">
                                    <h6 class="mb-2">Hasil Konseling:</h6>
                                    <p class="mb-0 text-muted">{{ $session->counselingSession->hasil_konseling }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Belum ada sesi konseling.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const kategori = document.getElementById('kategori').value;
    const status = document.getElementById('status').value;
    
    window.location.href = `{{ route('counseling.reports') }}?kategori=${kategori}&status=${status}`;
});

function exportToExcel() {
    window.location.href = "{{ route('counseling.reports.export') }}";
}
</script>
@endsection