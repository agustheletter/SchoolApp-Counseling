@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">Hubungi Kami</h1>
            <p class="lead text-muted mb-0">Ada pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami.</p>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                        <i class="fas fa-map-marker-alt text-primary fa-2x"></i>
                    </div>
                    <h4>Alamat</h4>
                    <p class="text-muted mb-0">Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel.<br>Kota Cimahi, 40533<br>Jawa Barat</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                        <i class="fas fa-phone-alt text-primary fa-2x"></i>
                    </div>
                    <h4>Telepon</h4>
                    <p class="text-muted mb-0">	+022-6629683<br>+62 21 3088 6438</p>
                    <p class="small text-muted mt-2">Senin - Jumat: 08.00 - 16.00</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 d-inline-flex mb-3">
                        <i class="fas fa-envelope text-primary fa-2x"></i>
                    </div>
                    <h4>Email</h4>
                    <p class="text-muted mb-0">info@smkn1-cmi.sch.id<br>konseling@stmnpbdg.com</p>
                    <p class="small text-muted mt-2">Kami akan merespons dalam 24 jam</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4">Kirim Pesan</h3>
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body p-0">
                    <div class="ratio ratio-16x9 h-100">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.9017962842836!2d107.53591817430862!3d-6.902346567547533!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e5a529094097%3A0x5d638aee4fd75b1d!2sSMKN%201%20Cimahi!5e0!3m2!1sid!2sid!4v1747877421311!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title mb-4">Pertanyaan Umum</h3>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                                    Bagaimana cara mendaftar untuk layanan konseling?
                                </button>
                            </h2>
                            <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Untuk mendaftar layanan konseling, Anda perlu login ke akun siswa Anda dan mengakses menu "Ajukan Konseling". Isi formulir yang tersedia dengan informasi yang diperlukan, pilih konselor dan jadwal yang diinginkan, lalu kirimkan permintaan Anda. Konselor akan merespons permintaan Anda dalam waktu 24 jam.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                                    Apakah layanan konseling bersifat rahasia?
                                </button>
                            </h2>
                            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Ya, semua sesi konseling bersifat rahasia. Informasi yang Anda bagikan dengan konselor tidak akan dibagikan kepada pihak lain tanpa persetujuan Anda, kecuali dalam situasi di mana ada risiko bahaya terhadap diri sendiri atau orang lain, atau jika diwajibkan oleh hukum.
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
                                    Durasi standar untuk satu sesi konseling adalah 45-60 menit. Namun, durasi dapat disesuaikan berdasarkan kebutuhan dan rekomendasi konselor.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faqHeading4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                                    Bagaimana jika saya perlu membatalkan atau menjadwalkan ulang sesi?
                                </button>
                            </h2>
                            <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Anda dapat membatalkan atau menjadwalkan ulang sesi melalui sistem online minimal 24 jam sebelum jadwal yang telah ditentukan. Masuk ke akun Anda, buka menu "Jadwal Konseling", pilih sesi yang ingin diubah, dan ikuti petunjuk untuk membatalkan atau menjadwalkan ulang.
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