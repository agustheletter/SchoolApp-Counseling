@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* ------------------------------------------------------------- */
    /* CSS Variables untuk Dashboard (Light Mode Defaults)          */
    /* ------------------------------------------------------------- */
    :root {
        /* Warna dasar yang mungkin sudah ada dari app.blade.php, tapi kita definisikan ulang untuk kejelasan */
        --db-primary-color: #0d6efd; /* Warna primary Bootstrap default */
        --db-text-muted-color: #6c757d;

        /* Warna spesifik untuk card di dashboard (Light Mode) */
        --db-card-bg: #ffffff;
        --db-card-color: #212529; /* Warna teks dalam card */
        --db-card-header-bg: #ffffff; /* Atau sedikit berbeda jika diinginkan, misal #f8f9fa */
        --db-card-header-color: #212529; /* Warna teks di header card */
        --db-card-border-color: #dee2e6;

        /* Warna untuk list group item (Light Mode) */
        --db-list-group-item-bg: #ffffff;
        --db-list-group-item-color: #212529;
        --db-list-group-item-border-color: rgba(0, 0, 0, 0.125);
        --db-list-group-item-active-bg: var(--db-primary-color);
        --db-list-group-item-active-color: #ffffff;
        --db-list-group-item-action-hover-bg: #f8f9fa;
    }

    /* ------------------------------------------------------------- */
    /* CSS Variables untuk Dashboard (Dark Mode Overrides)           */
    /* Menggunakan [data-bs-theme="dark"] sebagai selector utama     */
    /* karena itu yang diatur oleh JavaScript theme-toggle Anda      */
    /* ------------------------------------------------------------- */
    [data-bs-theme="dark"] { /* Atau body.dark-mode jika Anda menggunakan class itu */
        --db-primary-color: #4dabf7; /* Warna primary yang lebih cerah untuk dark mode */
        --db-text-muted-color: #adb5bd;

        /* Warna spesifik untuk card di dashboard (Dark Mode) */
        --db-card-bg: #343a40; /* Background card gelap */
        --db-card-color: #f8f9fa; /* Teks terang dalam card */
        --db-card-header-bg: #3e444a; /* Background header card sedikit lebih terang dari body card */
        --db-card-header-color: #f8f9fa; /* Teks terang di header card */
        --db-card-border-color: #495057;

        /* Warna untuk list group item (Dark Mode) */
        --db-list-group-item-bg: #343a40;
        --db-list-group-item-color: #f8f9fa;
        --db-list-group-item-border-color: rgba(255, 255, 255, 0.125);
        --db-list-group-item-active-bg: var(--db-primary-color);
        --db-list-group-item-active-color: #212529; /* Teks gelap di atas primary terang */
        --db-list-group-item-action-hover-bg: #3e444a; /* Warna hover sedikit berbeda */
    }

    /* ------------------------------------------------------------- */
    /* Menerapkan Variabel ke Elemen Card di Dashboard             */
    /* ------------------------------------------------------------- */

    /* Target card umum di dalam kolom .col-md-3 (sidebar) dan .col-md-9 (konten utama) */
    /* Ini untuk menghindari mempengaruhi card lain di luar dashboard jika ada */
    .container .row .col-md-3 .card,
    .container .row .col-md-9 .card {
        background-color: var(--db-card-bg) !important; /* !important untuk override style inline atau Bootstrap */
        color: var(--db-card-color) !important;
        border-color: var(--db-card-border-color) !important;
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .container .row .col-md-3 .card .card-title,
    .container .row .col-md-9 .card .card-title {
        color: var(--db-card-header-color) !important; /* Judul card */
    }
    
    .container .row .col-md-3 .card p,
    .container .row .col-md-9 .card p {
        color: var(--db-card-color) !important; /* Teks paragraf dalam card */
    }

    .container .row .col-md-3 .card .text-muted,
    .container .row .col-md-9 .card .text-muted {
        color: var(--db-text-muted-color) !important; /* Teks muted dalam card */
    }
    
    /* Target card-header spesifik di dashboard */
    .container .row .col-md-9 .card .card-header {
        background-color: var(--db-card-header-bg) !important;
        color: var(--db-card-header-color) !important;
        border-bottom-color: var(--db-card-border-color) !important; /* Border bawah header card */
    }
    .container .row .col-md-9 .card .card-header .card-title {
        color: var(--db-card-header-color) !important; /* Judul di dalam header card */
    }

    /* List Group di Sidebar dan Aktivitas Terbaru */
    .list-group {
        --bs-list-group-border-color: var(--db-list-group-item-border-color); /* Bootstrap 5.3 variable */
    }
    .list-group-item {
        background-color: var(--db-list-group-item-bg) !important;
        color: var(--db-list-group-item-color) !important;
        border-color: var(--db-list-group-item-border-color) !important;
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
    .list-group-item.active {
        background-color: var(--db-list-group-item-active-bg) !important;
        color: var(--db-list-group-item-active-color) !important;
        border-color: var(--db-list-group-item-active-bg) !important;
    }
    .list-group-item-action:hover,
    .list-group-item-action:focus {
        background-color: var(--db-list-group-item-action-hover-bg) !important;
        /* color: var(--db-list-group-item-color) !important; (opsional, tergantung desain) */
    }

    /* Styling untuk ikon display-4 di card summary */
    .container .row .col-md-9 .card .display-4.text-primary {
        color: var(--db-primary-color) !important;
    }

    /* Tombol Outline Primary di Sidebar */
    .btn-outline-primary {
        --bs-btn-color: var(--db-primary-color);
        --bs-btn-border-color: var(--db-primary-color);
        --bs-btn-hover-color: #fff; /* Teks putih saat hover */
        --bs-btn-hover-bg: var(--db-primary-color);
        --bs-btn-hover-border-color: var(--db-primary-color);
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: var(--db-primary-color);
        --bs-btn-active-border-color: var(--db-primary-color);
        --bs-btn-disabled-color: var(--db-primary-color);
        --bs-btn-disabled-bg: transparent;
    }

    /* Tombol Primary (jika tidak dihandle global) */
    .btn-primary {
        --bs-btn-color: #fff; /* Teks selalu putih untuk tombol primary solid */
        --bs-btn-bg: var(--db-primary-color);
        --bs-btn-border-color: var(--db-primary-color);
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: color-mix(in srgb, var(--db-primary-color) 85%, black); /* Sedikit lebih gelap */
        --bs-btn-hover-border-color: color-mix(in srgb, var(--db-primary-color) 80%, black);
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: color-mix(in srgb, var(--db-primary-color) 80%, black);
        --bs-btn-active-border-color: color-mix(in srgb, var(--db-primary-color) 75%, black);
    }

</style>
@endsection

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
                {{-- bg-white bisa dihapus, atau biarkan jika ingin fallback jika CSS gagal load --}}
                {{-- Dengan !important di CSS, bg-white akan di-override --}}
                <div class="card-header"> 
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
                <div class="card-header">
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

@section('scripts')
{{-- Tidak ada JavaScript spesifik yang dibutuhkan di sini untuk tema, --}}
{{-- karena perubahan tema dihandle global oleh script di app.blade.php --}}
{{-- atau oleh theme-toggle.js Anda --}}
@endsection