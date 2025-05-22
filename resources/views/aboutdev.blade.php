@extends('layouts.app')

@section('title', 'About Developer')

@section('styles')
<style>
    .developer-profile {
        transition: transform 0.3s ease;
    }
    
    .developer-profile:hover {
        transform: translateY(-10px);
    }
    
    .developer-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        border: 5px solid #f8f9fa;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #f8f9fa;
        color: #6c5ce7;
        margin: 0 5px;
        transition: all 0.3s ease;
    }
    
    .social-links a:hover {
        background-color: #6c5ce7;
        color: white;
    }
    
    .skill-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://via.placeholder.com/1920x400') no-repeat center center;
        background-size: cover;
        color: white;
        padding: 80px 0;
        margin-bottom: 60px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold">About Developer</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">About Developer</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h2 class="fw-bold mb-4">Tim Pengembang</h2>
            <p class="lead text-muted">Kenali tim developer yang bekerja keras membangun sistem konseling sekolah ini</p>
        </div>
    </div>

    <div class="row">
        <!-- Frontend Developer -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 developer-profile">
                <div class="card-body p-4 text-center">
                    <img src="https://via.placeholder.com/300x300" alt="Frontend Developer" class="developer-image">
                    <h3 class="card-title mb-1">Arkan Ardiansyah</h3>
                    <p class="text-primary mb-3">Frontend Developer</p>
                    
                    <div class="mb-4">
                        <h5 class="mb-3">Keahlian</h5>
                        <div>
                            <span class="skill-badge bg-primary">HTML5</span>
                            <span class="skill-badge bg-primary">CSS3</span>
                            <span class="skill-badge bg-primary">JavaScript</span>
                            <span class="skill-badge bg-primary">Bootstrap</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="mb-3">Status Pendidikan</h5>
                        <p class="mb-1">Siswa Rekayasa Perangkat Lunak</p>
                        <p class="text-muted">SMKN 1 CIMAHI</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="mb-3">Kontak</h5>
                        <p class="mb-1">Email: miptahfardi@gmail.com</p>
                        <p class="mb-3">Phone: +62 821 3088 6438</p>
                        
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-dribbble"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Backend Developer -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 developer-profile">
                <div class="card-body p-4 text-center">
                    <img src="https://via.placeholder.com/300x300" alt="Backend Developer" class="developer-image">
                    <h3 class="card-title mb-1"></h3>
                    <p class="text-primary mb-3">Backend Developer</p>  
                    
                    <div class="mb-4">
                        <h5 class="mb-3">Keahlian</h5>
                        <div>
                            <span class="skill-badge bg-primary">PHP</span>
                            <span class="skill-badge bg-primary">Laravel</span>
                            <span class="skill-badge bg-primary">MySQL</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="mb-3">Status Pendidikan</h5>
                        <p class="mb-1">Siswa Rekayasa Perangkat Lunak</p>
                        <p class="text-muted">SMKN 1 CIMAHI</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="mb-3">Kontak</h5>
                        <p class="mb-1">Email: hulukotak@gmail.com</p>
                        <p class="mb-3">Phone: +62 821 3030 4142</p>
                        
                        <div class="social-links">
                            <a href="#" target="_blank"><i class="fab fa-github"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="#" target="_blank"><i class="fab fa-stack-overflow"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Information -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4">Tentang Proyek</h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h5>Teknologi yang Digunakan</h5>
                            <ul>
                                <li><strong>Frontend:</strong> HTML5, CSS, JavaScript, Bootstrap 5</li>
                                <li><strong>Backend:</strong> PHP 8, Laravel 12</li>
                                <li><strong>Database:</strong> MySQL</li>
                                <li><strong>Tools:</strong> Git, GitHub, VS Code</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm bg-light">
                <div class="card-body p-5 text-center">
                    <h3 class="mb-3">Info Collaboration?</h3>
                    <p class="mb-4">Kami selalu terbuka untuk kolaborasi dan peluang pengembangan baru.</p>
                    <a href="mailto:miptahfardi@gmail.com | hulukotak@gmail.com" class="btn btn-primary">Hubungi Tim Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection