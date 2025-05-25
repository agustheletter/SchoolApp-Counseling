@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

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

                    <form action="{{ route('counseling.request.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="counselor_id" class="form-label">Pilih Konselor</label>
                            <select class="form-select @error('counselor_id') is-invalid @enderror" 
                                    id="counselor_id" 
                                    name="counselor_id" 
                                    required>
                                <option value="" selected disabled>-- Pilih Konselor --</option>
                                @foreach($counselors as $counselor)
                                    <option value="{{ $counselor->id }}">{{ $counselor->nama }}</option>
                                @endforeach
                            </select>
                            @error('counselor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Konseling</label>
                            <select class="form-select @error('kategori') is-invalid @enderror" 
                                    id="kategori" 
                                    name="kategori" 
                                    required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Karir">Karir</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_permintaan" class="form-label">Tanggal Konseling</label>
                            <input type="datetime-local" 
                                   class="form-control @error('tanggal_permintaan') is-invalid @enderror" 
                                   id="tanggal_permintaan" 
                                   name="tanggal_permintaan" 
                                   value="{{ old('tanggal_permintaan') }}" 
                                   required>
                            @error('tanggal_permintaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Masalah</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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