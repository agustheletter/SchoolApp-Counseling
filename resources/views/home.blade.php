@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-4">Tempat terbaik untuk <span class="highlight">belajar</span> dan <span class="highlight">berkembang</span></h1>
                    <p class="lead mb-4">Kami bertujuan membantu siswa menemukan kegembiraan dalam belajar dan tumbuh menjadi individu yang mandiri.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg px-4 me-md-2">Mulai Sekarang</a>
                        <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg px-4">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="Konseling Sekolah" class="img-fluid rounded-3">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 mt-5">
        <div class="container">
            <h2 class="section-title text-center">Fitur <span class="highlight">Utama</span> Kami</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <h3>Layanan Konseling Edukatif & Fleksibel</h3>
                        <p>Temukan kenyamanan dalam berbicara dan berkonsultasi dengan guru pilihan Anda kapan pun Anda butuhkan.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3>Pilih Guru Konseling Sesuai Kebutuhan</h3>
                        <p>Setiap orang punya kebutuhan yang berbeda. Kami menyediakan berbagai pilihan guru profesional yang siap mendengarkan dan membantu Anda, sesuai dengan bidang dan pendekatan yang Anda cari.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <h3>Materi Edukatif & Artikel Pembelajaran</h3>
                        <p>Akses berbagai materi pembelajaran yang dirancang untuk membantu perkembangan akademik dan pribadi Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-center">Tim <span class="highlight">Konselor</span> Kami</h2>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Konselor">
                        <h4>Guru 1</h4>
                        <p class="text-muted">Konselor Pendidikan</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Konselor">
                        <h4>Guru 2</h4>
                        <p class="text-muted">Konselor Pendidikan</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Konselor">
                        <h4>Guru 3</h4>
                        <p class="text-muted">Konselor Pendidikan</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="https://via.placeholder.com/150" alt="Konselor">
                        <h4>Guru 4</h4>
                        <p class="text-muted">Konselor Pendidikan</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center">Baca <span class="highlight">Blog</span> Kami</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="blog-card">
                        <img src="https://via.placeholder.com/400x250" alt="Blog Post">
                        <div class="blog-content">
                            <h4>Mengatasi Kecemasan Ujian</h4>
                            <p class="text-muted">12 Mei 2023</p>
                            <p>Tips dan strategi untuk mengatasi kecemasan saat menghadapi ujian sekolah.</p>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card">
                        <img src="https://via.placeholder.com/400x250" alt="Blog Post">
                        <div class="blog-content">
                            <h4>Memilih Jurusan Kuliah</h4>
                            <p class="text-muted">5 Juni 2023</p>
                            <p>Panduan lengkap untuk memilih jurusan kuliah yang sesuai dengan minat dan bakat.</p>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="blog-card">
                        <img src="https://via.placeholder.com/400x250" alt="Blog Post">
                        <div class="blog-content">
                            <h4>Pentingnya Kesehatan Mental</h4>
                            <p class="text-muted">20 Juli 2023</p>
                            <p>Mengapa kesehatan mental sama pentingnya dengan kesehatan fisik bagi pelajar.</p>
                            <a href="#" class="btn btn-sm btn-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Siap untuk memulai perjalanan konseling Anda?</h2>
            <p class="lead mb-4">Daftar sekarang dan temukan potensi terbaik dalam diri Anda!</p>
            <a href="{{ route('register') }}" class="btn btn-lg btn-secondary">Daftar Sekarang</a>
        </div>
    </section>
@endsection