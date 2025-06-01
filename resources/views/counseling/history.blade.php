@extends('layouts.app')

@section('title', 'Riwayat Konseling')

@section('styles')
<style>
    .status-badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
    
    .counseling-card {
        transition: transform 0.3s ease;
    }
    
    .counseling-card:hover {
        transform: translateY(-5px);
    }
    
    .timeline {
        position: relative;
        padding-left: 3rem;
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Ringkasan Aktivitas Konseling</h5>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary filter-btn active" data-filter="all">Semua</button>
                            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="Completed">Selesai</button>
                            <button type="button" class="btn btn-outline-primary filter-btn" data-filter="Canceled">Dibatalkan</button>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">{{ $totalSessions }}</h3>
                                    <p class="mb-0">Total Sesi</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">{{ $completedSessions }}</h3>
                                    <p class="mb-0">Sesi Selesai</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">{{ $pendingSessions }}</h3>
                                    <p class="mb-0">Sesi Pending</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <h3 class="display-4 fw-bold">{{ $canceledSessions }}</h3>
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
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Sesi Konseling</h5>
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari sesi...">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($counselingSessions as $session)
                            <div class="list-group-item p-3 counseling-card">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold">Konseling {{ $session->kategori }}</h6>
                                    <span class="badge bg-{{ $session->status === 'Completed' ? 'success' : 
                        ($session->status === 'Pending' ? 'warning' : 
                        ($session->status === 'Rejected' ? 'danger' : 'primary')) }} status-badge">
                                        {{ $session->status }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <p class="mb-0 text-muted">
                                            <i class="fas fa-calendar-alt me-2"></i>
                                            {{ \Carbon\Carbon::parse($session->tanggal_permintaan)->format('d M Y, H:i') }}
                                        </p>
                                        <p class="mb-0 text-muted">
                                            <i class="fas fa-user me-2"></i>
                                            {{ $session->counselor->nama ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                                <p class="mb-2"><small>{{ $session->deskripsi }}</small></p>
                                
                                @if($session->counselingSession && $session->counselingSession->hasil_konseling)
                                    <div class="mt-2 pt-2 border-top">
                                        <h6 class="mb-1">Hasil Konseling:</h6>
                                        <p class="mb-0 text-muted">{{ $session->counselingSession->hasil_konseling }}</p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">Belum ada riwayat konseling.</p>
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
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const cards = document.querySelectorAll('.counseling-card');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');
            
            // Update active state of buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            // Filter cards
            cards.forEach(card => {
                if (filter === 'all') {
                    card.style.display = '';
                } else {
                    const status = card.querySelector('.status-badge').textContent.trim();
                    card.style.display = status === filter ? '' : 'none';
                }
            });
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
});
</script>
@endsection