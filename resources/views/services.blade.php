@extends('layouts.app')

@section('title', 'Layanan Konseling')

@section('styles')
<style>
    .service-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }
    
    .service-card {
        transition: transform 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-10px);
    }
    
    .process-step {
        position: relative;
        padding-bottom: 3rem;
    }
    
    .process-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 40px;
        bottom: 0;
        left: 25px;
        width: 2px;
        background-color: #dee2e6;
    }
    
    .step-number {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.25rem;
        font-weight: bold;
        margin-right: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">STMCounseling</h1>
            <p class="lead text-muted">Kami menawarkan berbagai layanan konseling untuk mendukung kesejahteraan akademik, sosial, dan emosional siswa.</p>
        </div>
    </div>

    <!-- Services Overview -->
    <div class="row mb-5">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 service-card">
                <div class="card-body p-4">
                    <div class="service-icon bg-primary bg-opacity-10 text-primary mx-auto">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="card-title text-center mb-3">Konseling Akademik</h3>
                    <p class="card-text">Layanan konseling akademik kami membantu siswa mengatasi tantangan belajar, meningkatkan keterampilan studi, dan mencapai tujuan akademik mereka. Konselor kami bekerja sama dengan siswa untuk mengidentifikasi hambatan belajar dan mengembangkan strategi yang efektif.</p>
                    <h5 class="mt-4 mb-3">Layanan Meliputi:</h5>
                    <ul>
                        <li>Strategi belajar efektif dan manajemen waktu</li>
                        <li>Bantuan untuk kesulitan belajar spesifik</li>
                        <li>Persiapan ujian dan mengatasi kecemasan ujian</li>
                        <li>Perencanaan akademik dan pemilihan mata pelajaran</li>
                        <li>Dukungan untuk siswa dengan kebutuhan khusus</li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Jadwalkan Konseling</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 service-card">
                <div class="card-body p-4">
                    <div class="service-icon bg-success bg-opacity-10 text-success mx-auto">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3 class="card-title text-center mb-3">Konseling Karir</h3>
                    <p class="card-text">Layanan konseling karir kami membantu siswa mengeksplorasi minat, bakat, dan jalur karir potensial. Kami menyediakan penilaian, informasi, dan bimbingan untuk membantu siswa membuat keputusan pendidikan dan karir yang terinformasi.</p>
                    <h5 class="mt-4 mb-3">Layanan Meliputi:</h5>
                    <ul>
                        <li>Penilaian minat, bakat, dan kepribadian</li>
                        <li>Eksplorasi karir dan informasi pendidikan tinggi</li>
                        <li>Bantuan aplikasi perguruan tinggi dan beasiswa</li>
                        <li>Pengembangan keterampilan kerja dan persiapan wawancara</li>
                        <li>Perencanaan jalur karir dan pendidikan</li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-outline-success">Jadwalkan Konseling</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 service-card">
                <div class="card-body p-4">
                    <div class="service-icon bg-warning bg-opacity-10 text-warning mx-auto">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3 class="card-title text-center mb-3">Konseling Pribadi</h3>
                    <p class="card-text">Layanan konseling pribadi kami menyediakan dukungan untuk masalah emosional dan psikologis yang mungkin dihadapi siswa. Konselor kami terlatih untuk membantu siswa mengatasi stres, kecemasan, depresi, dan tantangan kesehatan mental lainnya.</p>
                    <h5 class="mt-4 mb-3">Layanan Meliputi:</h5>
                    <ul>
                        <li>Manajemen stres dan kecemasan</li>
                        <li>Dukungan untuk masalah kesehatan mental</li>
                        <li>Pengembangan keterampilan koping dan ketahanan</li>
                        <li>Konseling krisis dan intervensi</li>
                        <li>Dukungan untuk masalah keluarga dan pribadi</li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-outline-warning">Jadwalkan Konseling</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 service-card">
                <div class="card-body p-4">
                    <div class="service-icon bg-info bg-opacity-10 text-info mx-auto">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="card-title text-center mb-3">Konseling Sosial</h3>
                    <p class="card-text">Layanan konseling sosial kami membantu siswa mengembangkan keterampilan interpersonal, mengatasi konflik, dan membangun hubungan yang sehat. Kami fokus pada membantu siswa bernavigasi dalam dinamika sosial kompleks di sekolah dan di luar sekolah.</p>
                    <h5 class="mt-4 mb-3">Layanan Meliputi:</h5>
                    <ul>
                        <li>Pengembangan keterampilan sosial dan komunikasi</li>
                        <li>Resolusi konflik dan mediasi teman sebaya</li>
                        <li>Dukungan untuk masalah pertemanan dan hubungan</li>
                        <li>Pencegahan dan intervensi bullying</li>
                        <li>Adaptasi sosial untuk siswa baru atau pindahan</li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-outline-info">Jadwalkan Konseling</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Services -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center">Layanan Kelompok</h2>
            <p class="text-center text-muted mb-5">Selain konseling individual, kami juga menawarkan berbagai program dan workshop kelompok</p>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Layanan 1</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Atque odio possimus, unde eum distinctio non consectetur ducimus doloremque illum, rerum iste assumenda? Doloremque laudantium amet quisquam nihil. Quae, enim architecto.</p>
                    <p class="text-muted small">Durasi: 4 sesi, 90 menit per sesi</p>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Akademik</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Layanan 2</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores, ullam cum atque aut alias officia eum optio reiciendis beatae rem. Dolor vitae iure nam accusantium eos reprehenderit labore doloremque reiciendis.</p>
                    <p class="text-muted small">Durasi: Berkelanjutan, pertemuan mingguan 60 menit</p>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-warning">Pribadi</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Layanan 3</h4>
                    <p class="card-text">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Saepe optio maxime tempore quis at inventore consequatur. Sequi, eum dolores rerum doloribus iure magnam at odit obcaecati iste eaque amet? Voluptate.</p>
                    <p class="text-muted small">Durasi: 6 sesi, 2 jam per sesi</p>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">Karir</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Layanan 4</h4>
                    <p class="card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit quo quisquam magnam, autem minima corrupti! Quia, vero facere exercitationem pariatur eos nulla repellat. Deleniti vel minus eos, eius rem harum.</p>
                    <p class="text-muted small">Durasi: 3 sesi, 2 jam per sesi</p>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-info">Sosial</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Layanan 5</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum soluta ipsum ducimus dolorum est, eos asperiores reiciendis. Aut, dicta eligendi?</p>
                    <p class="text-muted small">Durasi: 1 hari penuh (6 jam)</p>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-success">Karir</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h4 class="card-title mb-3">Layanan 6</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque cumque eum adipisci officia asperiores, officiis reiciendis praesentium recusandae magnam ut doloremque quos tempora quod pariatur aspernatur soluta nisi labore non!</p>
                    <p class="text-muted small">Durasi: 4 sesi, 90 menit per sesi</p>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-info">Sosial</span>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Jadwal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="row mb-5">
        <div class="col-12 mb-4">
            <h2 class="text-center">Pertanyaan Umum</h2>
            <p class="text-center text-muted mb-5">Jawaban untuk pertanyaan yang sering diajukan tentang layanan konseling kami</p>
        </div>

        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                    Apakah layanan konseling bersifat rahasia?
                                </button>
                            </h2>
                            <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, semua sesi konseling bersifat rahasia. Informasi yang Anda bagikan dengan konselor tidak akan dibagikan kepada pihak lain tanpa persetujuan Anda, kecuali dalam situasi di mana ada risiko bahaya terhadap diri sendiri atau orang lain, atau jika diwajibkan oleh hukum.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                    Berapa biaya layanan konseling?
                                </button>
                            </h2>
                            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Layanan konseling kami tersedia secara gratis untuk semua siswa terdaftar. Layanan ini merupakan bagian dari program dukungan siswa yang disediakan oleh sekolah kami.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                                    Berapa lama durasi satu sesi konseling?
                                </button>
                            </h2>
                            <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Durasi standar untuk satu sesi konseling adalah 45-60 menit. Namun, durasi dapat disesuaikan berdasarkan kebutuhan dan rekomendasi konselor. Untuk sesi pertama, biasanya akan memakan waktu sedikit lebih lama karena mencakup asesmen awal.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                    Apakah saya bisa memilih konselor saya sendiri?
                                </button>
                            </h2>
                            <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, Anda dapat memilih konselor berdasarkan spesialisasi, keahlian, atau preferensi pribadi. Namun, ketersediaan konselor tertentu mungkin terbatas. Jika konselor pilihan Anda tidak tersedia, kami akan mencocokkan Anda dengan konselor lain yang memiliki keahlian yang sesuai dengan kebutuhan Anda.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                                    Apakah layanan konseling tersedia secara online?
                                </button>
                            </h2>
                            <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, kami menawarkan layanan konseling baik secara tatap muka maupun online. Konseling online dilakukan melalui platform video conference yang aman dan mematuhi standar privasi. Anda dapat memilih metode yang paling nyaman untuk Anda saat mengajukan permintaan konseling.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse6" aria-expanded="false" aria-controls="faqCollapse6">
                                    Berapa banyak sesi konseling yang saya butuhkan?
                                </button>
                            </h2>
                            <div id="faqCollapse6" class="accordion-collapse collapse" aria-labelledby="faqHeading6" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Jumlah sesi konseling bervariasi tergantung pada kebutuhan individu dan jenis masalah yang dihadapi. Beberapa siswa mungkin hanya membutuhkan 1-2 sesi untuk masalah spesifik, sementara yang lain mungkin memerlukan dukungan berkelanjutan. Konselor Anda akan mendiskusikan rencana konseling yang sesuai dengan Anda selama sesi pertama.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <h3 class="mb-3">Siap untuk memulai perjalanan konseling Anda?</h3>
                    <p class="mb-4">Jadwalkan sesi konseling pertama Anda atau hubungi kami untuk informasi lebih lanjut.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('login') }}" class="btn btn-light">Jadwalkan Konseling</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-light">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection