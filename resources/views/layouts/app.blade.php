<!DOCTYPE html>
{{-- Tambahkan atribut data-bs-theme di sini --}}
<html lang="id" data-bs-theme="{{ Auth::check() && Auth::user()->theme ? Auth::user()->theme : config('app.default_theme', 'light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Konseling SMK NEGERI 1 CIMAHI - @yield('title', 'Beranda')</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> {{-- Versi Bootstrap diperbarui ke 5.3.2 untuk dukungan data-bs-theme yang lebih baik --}}
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Variabel warna dasar */
        :root {
            --primary-light: #6c5ce7;
            --secondary-light: #ffc107;
            --light-bg: #f8f9fa;
            --dark-text: #343a40;
            --white-text: #ffffff;
            --primary-hover-light: #5649c0;
            --secondary-hover-light: #e0a800;

            /* Dark theme colors (contoh, bisa disesuaikan) */
            --primary-dark: #8a7ff0; /* Sedikit lebih terang dari primary-light */
            --secondary-dark: #ffd043; /* Sedikit lebih terang dari secondary-light */
            --dark-bg: #212529; /* Bootstrap $dark */
            --dark-surface-bg: #343a40; /* Bootstrap $gray-800, untuk cards, navbar, footer */
            --light-text-dark-theme: #f8f9fa; /* Teks terang di tema gelap */
            --muted-text-dark-theme: #adb5bd; /* Bootstrap $gray-500 */
            --primary-hover-dark: #796de0;
            --secondary-hover-dark: #f0c032;
        }

        /* Default (Light Theme) Variables */
        body {
            --app-primary: var(--primary-light);
            --app-secondary: var(--secondary-light);
            --app-body-bg: var(--light-bg);
            --app-body-color: var(--dark-text);
            --app-card-bg: var(--white-text);
            --app-card-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            --app-navbar-bg: var(--white-text);
            --app-navbar-color: var(--dark-text); /* Warna link navbar */
            --app-footer-bg: var(--dark-text);
            --app-footer-color: var(--white-text);
            --app-btn-primary-bg: var(--primary-light);
            --app-btn-primary-border: var(--primary-light);
            --app-btn-primary-hover-bg: var(--primary-hover-light);
            --app-btn-primary-hover-border: var(--primary-hover-light);
            --app-btn-secondary-bg: var(--secondary-light);
            --app-btn-secondary-border: var(--secondary-light);
            --app-btn-secondary-color: var(--dark-text);
            --app-btn-secondary-hover-bg: var(--secondary-hover-light);
            --app-btn-secondary-hover-border: var(--secondary-hover-light);
        }

        [data-bs-theme="dark"] body {
            --app-primary: var(--primary-dark);
            --app-secondary: var(--secondary-dark);
            --app-body-bg: var(--dark-bg);
            --app-body-color: var(--light-text-dark-theme);
            --app-card-bg: var(--dark-surface-bg);
            --app-card-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Shadow lebih gelap */
            --app-navbar-bg: var(--dark-surface-bg);
            --app-navbar-color: var(--light-text-dark-theme); /* Warna link navbar di dark mode */
            --app-footer-bg: var(--dark-surface-bg); /* Footer di dark mode */
            --app-footer-color: var(--light-text-dark-theme);
            --app-btn-primary-bg: var(--primary-dark);
            --app-btn-primary-border: var(--primary-dark);
            --app-btn-primary-hover-bg: var(--primary-hover-dark);
            --app-btn-primary-hover-border: var(--primary-hover-dark);
            --app-btn-secondary-bg: var(--secondary-dark);
            --app-btn-secondary-border: var(--secondary-dark);
            --app-btn-secondary-color: var(--dark-text); /* Tetap gelap untuk kontras */
            --app-btn-secondary-hover-bg: var(--secondary-hover-dark);
            --app-btn-secondary-hover-border: var(--secondary-hover-dark);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--app-body-bg);
            color: var(--app-body-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Navbar styling */
        .navbar {
            background-color: var(--app-navbar-bg) !important; /* !important untuk override Bootstrap jika perlu */
            transition: background-color 0.3s ease;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--app-primary) !important;
        }
        .navbar .nav-link {
            color: var(--app-navbar-color) !important;
        }
        .navbar .nav-link:hover {
            color: var(--app-primary) !important;
        }
         .navbar-toggler-icon { /* Pastikan ikon toggler terlihat di dark mode */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28var%28--app-navbar-color-rgb-tuple, 0, 0, 0%29, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        [data-bs-theme="dark"] .navbar-toggler-icon {
             background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28248, 249, 250, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }


        /* Button styling */
        .btn-primary {
            background-color: var(--app-btn-primary-bg);
            border-color: var(--app-btn-primary-border);
            color: var(--white-text); /* Warna teks tombol primary */
        }
        .btn-primary:hover {
            background-color: var(--app-btn-primary-hover-bg);
            border-color: var(--app-btn-primary-hover-border);
        }
        
        .btn-secondary {
            background-color: var(--app-btn-secondary-bg);
            border-color: var(--app-btn-secondary-border);
            color: var(--app-btn-secondary-color);
        }
        .btn-secondary:hover {
            background-color: var(--app-btn-secondary-hover-bg);
            border-color: var(--app-btn-secondary-hover-border);
            color: var(--app-btn-secondary-color);
        }
        
        /* Hero section styling */
        .hero-section {
            background-color: var(--app-primary);
            color: var(--white-text); /* Teks di hero section selalu putih */
            padding: 80px 0;
            border-radius: 0 0 50px 50px;
            position: relative;
            overflow: hidden;
        }
        .hero-section::before, .hero-section::after {
            background-color: rgba(255, 255, 255, 0.1); /* Tetap sama */
        }
        
        /* Feature card styling */
        .feature-card {
            background-color: var(--app-card-bg);
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--app-card-shadow);
            transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            color: var(--app-body-color); /* Warna teks dalam card */
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            background-color: var(--app-primary); /* Ikon tetap primary */
            color: var(--white-text);
            /* ... sisa style feature-icon ... */
        }
        
        /* Team member styling - avatar border */
        .team-member img {
            border: 5px solid var(--app-primary);
            /* ... sisa style team-member img ... */
        }
        
        /* Blog card styling */
        .blog-card {
            background-color: var(--app-card-bg);
            color: var(--app-body-color); /* Warna teks dalam card */
            /* ... sisa style blog-card ... */
        }
        
        /* Auth form styling */
        .auth-form {
            background-color: var(--app-card-bg);
            color: var(--app-body-color); /* Warna teks dalam card */
            /* ... sisa style auth-form ... */
        }
        .auth-form h2 {
            color: var(--app-primary);
            /* ... sisa style auth-form h2 ... */
        }
        
        /* Footer styling */
        .footer {
            background-color: var(--app-footer-bg);
            color: var(--app-footer-color);
            padding: 50px 0 20px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .footer a, .footer a:hover { /* Pastikan link di footer juga berubah warna */
             color: var(--app-footer-color) !important;
             text-decoration: none;
        }
        .footer .social-icons a {
            color: var(--app-footer-color) !important;
        }
        .footer hr {
            background-color: rgba(255, 255, 255, 0.2); /* Garis pemisah di footer */
        }
        [data-bs-theme="dark"] .footer hr {
            background-color: rgba(248, 249, 250, 0.2);
        }
        
        /* Highlight dan section title */
        .highlight {
            color: var(--app-secondary);
            font-weight: 600;
        }
        .section-title::after {
            background-color: var(--app-primary);
        }
        
        /* Dropdown menu styling */
        .dropdown-menu { /* Pastikan dropdown menu mengikuti tema */
            --bs-dropdown-bg: var(--app-card-bg);
            --bs-dropdown-link-color: var(--app-body-color);
            --bs-dropdown-link-hover-bg: var(--app-primary);
            --bs-dropdown-link-hover-color: var(--white-text);
            --bs-dropdown-border-color: rgba(0,0,0,0.10); /* Sedikit lebih soft */
        }
        [data-bs-theme="dark"] .dropdown-menu {
            --bs-dropdown-border-color: rgba(255,255,255,0.15);
        }
        .nav-item.dropdown img {
            border: 2px solid var(--app-primary);
            transition: border-color 0.3s ease;
        }
        .nav-item.dropdown:hover img {
            border-color: var(--app-secondary);
        }
    </style>
    
    @yield('styles') {{-- Tempat untuk CSS spesifik per halaman --}}
</head>
<body>
    <!-- Navbar -->
    {{-- bg-white akan di-override oleh var(--app-navbar-bg) atau oleh Bootstrap di dark mode --}}
    <nav class="navbar navbar-expand-lg py-3 shadow-sm"> 
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">STMCounseling</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services') ? 'active fw-bold' : '' }}" href="{{ route('services') }}">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active fw-bold' : '' }}" href="{{ route('about') }}">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-bold' : '' }}" href="{{ route('contact') }}">Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown d-flex align-items-center">
                            <img src="{{ Auth::user()->avatar_url }}" 
                                 alt="Profile {{ Auth::user()->nama }}" 
                                 class="rounded-circle me-2" 
                                 width="32" 
                                 height="32"
                                 style="object-fit: cover;">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Layanan Konseling</a></li>
                                {{-- Tambahkan link ke halaman pengaturan di sini --}}
                                <li><a class="dropdown-item" href="{{ route('profile.settings') }}">Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3"> {{-- Hapus mt-5, biarkan mt-auto jika konten pendek --}}
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Konseling Sekolah</h5>
                    <p>Membantu siswa menemukan potensi terbaik mereka melalui layanan konseling yang profesional dan terpercaya.</p>
                    <div class="social-icons mt-3">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('services') }}">Layanan</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}">Tentang Kami</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}">Kontak</a></li>
                        <li class="mb-2"><a href="{{ route('aboutdev') }}">About Developer</a></li>
                    </ul>
                </div>
                <div class="col-md-5 mb-4">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> Jl. Mahar Martanegara No.48 Leuwigajah, Utama 40533 Cimahi West Java</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (082)130886438</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> konseling@stmnpbdg.com</li>
                    </ul>
                </div>
            </div>
            <hr class="mt-4 mb-4"> {{-- Dihapus bg-light karena akan dihandle CSS --}}
            <div class="text-center">
                <p class="mb-0">© {{ date('Y') }} STMCounseling. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    @yield('scripts') {{-- Tempat untuk JS spesifik per halaman --}}
</body>
</html>