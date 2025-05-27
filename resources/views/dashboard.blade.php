@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Profil Saya</h5>
                    <div class="text-center mb-3">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Profile" width="80" height="80" class="rounded-circle">
                    </div>
                    <h6 class="text-center">{{ Auth::user()->name }}</h6>
                    <p class="text-center text-muted">{{ Auth::user()->email }}</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('profile.settings') }}" class="btn btn-outline-primary btn-sm">Edit Profil</a>
                    </div>
                </div>
            </div>
            <div class="list-group mt-4 shadow-sm">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action active">
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
                <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-comments me-2"></i> Pesan
                </a>
                <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-alt me-2"></i> Laporan
                </a>
                <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-cog me-2"></i> Pengaturan
                </a>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}</h5>
                    <p>Ini adalah dashboard layanan konseling STM. Didalam halaman ini anda bisa menggunakan beberapa fitur yang disediakan oleh kami.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-2">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h5 class="card-title">Jadwal Konseling</h5>
                            <p class="card-text">0 Jadwal Aktif</p>
                            <a href="{{ route('counseling.my-requests') }}" class="btn btn-sm btn-primary">Buat Jadwal</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-2">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5 class="card-title">Pesan</h5>
                            <p class="card-text">0 Pesan Baru</p>
                            <a href="{{ route('counseling.messages') }}" class="btn btn-sm btn-primary">Lihat Pesan</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <div class="display-4 text-primary mb-2">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h5 class="card-title">Materi</h5>
                            <p class="card-text">5 Materi Tersedia</p>
                            <a href="#" class="btn btn-sm btn-primary">Lihat Materi</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Pendaftaran Akun</h6>
                                <small class="text-muted">Hari ini</small>
                            </div>
                            <p class="mb-1">Anda telah berhasil mendaftar dan membuat akun.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Konselor yang Tersedia</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/50" alt="Konselor" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Guru 1</h6>
                                    <p class="text-muted mb-0">Konselor Pendidikan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/50" alt="Konselor" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Guru 2</h6>
                                    <p class="text-muted mb-0">Psikolog Anak</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/50" alt="Konselor" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Guru 3</h6>
                                    <p class="text-muted mb-0">Konselor Karir</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/50" alt="Konselor" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Guru 4</h6>
                                    <p class="text-muted mb-0">Konselor Akademik</p>
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