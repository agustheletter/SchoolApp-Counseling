@extends('layouts.app')

@section('title', 'Permintaan Konseling')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ajukan Permintaan Konseling</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="counselor_id" class="form-label">Pilih Konselor</label>
                            <select class="form-select @error('counselor_id') is-invalid @enderror" id="counselor_id" name="counselor_id" required>
                                <option value="" selected disabled>-- Pilih Konselor --</option>
                                <option value="1">Guru Konselor 1</option>
                                <option value="2">Guru Konselor 2 </option>
                                <option value="3">Guru Konselor 3</option>
                                <option value="4">Guru Konselor 4</option>
                            </select>
                            @error('counselor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori Konseling</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="academic">Akademik</option>
                                <option value="career">Karir</option>
                                <option value="personal">Pribadi</option>
                                <option value="social">Sosial</option>
                                <option value="other">Lainnya</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="preferred_date" class="form-label">Tanggal yang Diinginkan</label>
                            <input type="date" class="form-control @error('preferred_date') is-invalid @enderror" id="preferred_date" name="preferred_date" min="{{ date('Y-m-d') }}" required>
                            @error('preferred_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="preferred_time" class="form-label">Waktu yang Diinginkan</label>
                            <select class="form-select @error('preferred_time') is-invalid @enderror" id="preferred_time" name="preferred_time" required>
                                <option value="" selected disabled>-- Pilih Waktu --</option>
                                <option value="08:00">08:00 - 09:00</option>
                                <option value="09:00">09:00 - 10:00</option>
                                <option value="10:00">10:00 - 11:00</option>
                                <option value="11:00">11:00 - 12:00</option>
                                <option value="13:00">13:00 - 14:00</option>
                            </select>
                            @error('preferred_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Judul Konseling</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Masukkan judul konseling" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Masalah</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" placeholder="Jelaskan masalah yang ingin Anda konsultasikan..." required></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Deskripsi Anda akan dijaga kerahasiaannya dan hanya dapat diakses oleh konselor yang Anda pilih.</div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">Saya menyetujui <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">syarat dan ketentuan</a> layanan konseling</label>
                            @error('terms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title">Informasi Penting</h5>
                    <ul class="mb-0">
                        <li>Permintaan konseling akan diproses dalam 1x24 jam.</li>
                        <li>Konselor akan mengonfirmasi jadwal konseling melalui email atau whatsapp.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Syarat dan Ketentuan -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Syarat dan Ketentuan Layanan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>1. Kerahasiaan</h6>
                <p>Semua informasi yang Anda berikan dalam sesi konseling akan dijaga kerahasiaannya dan hanya digunakan untuk kepentingan konseling.</p>
                
                <h6>2. Jadwal Konseling</h6>
                <p>Jadwal konseling yang telah dikonfirmasi harus dipatuhi. Jika Anda tidak dapat hadir, harap memberitahu minimal 6 jam sebelumnya.</p>
                
                <h6>3. Etika Konseling</h6>
                <p>Siswa diharapkan untuk menghormati konselor dan mengikuti arahan yang diberikan selama sesi konseling.</p>
                
                <h6>4. Pembatalan</h6>
                <p>Pembatalan sesi konseling tanpa pemberitahuan sebelumnya sebanyak 3 kali akan mengakibatkan penundaan layanan konseling berikutnya.</p>
                
                <h6>5. Keadaan Darurat</h6>
                <p>Layanan konseling ini tidak menggantikan penanganan medis atau psikiatris dalam keadaan darurat. Jika Anda mengalami krisis, segera hubungi layanan darurat.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Saya Mengerti</button>
            </div>
        </div>
    </div>
</div>
@endsection