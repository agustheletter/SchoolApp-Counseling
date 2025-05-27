@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <!-- Sidebar Menu -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white"> {{-- Biarkan bg-primary untuk styling spesifik sidebar header --}}
                    <h5 class="mb-0">Menu Siswa</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
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
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <!-- Settings Tabs -->
            <div class="card shadow-sm">
                {{-- bg-white DIHAPUS dari sini. Warna akan dikontrol oleh CSS Variables. --}}
                <div class="card-header"> 
                    <ul class="nav nav-tabs card-header-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true">
                                <i class="fas fa-user me-2"></i> Akun
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">
                                <i class="fas fa-lock me-2"></i> Keamanan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="appearance-tab" data-bs-toggle="tab" data-bs-target="#appearance" type="button" role="tab" aria-controls="appearance" aria-selected="false">
                                <i class="fas fa-palette me-2"></i> Tampilan
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="settingsTabsContent">
                        <!-- Account Settings -->
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            {{-- Pesan sukses spesifik untuk Akun --}}
                            @if(session('success') && !session('success_security') && !session('success_appearance'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            {{-- Menampilkan error validasi umum untuk tab akun --}}
                            @if ($errors->any() && 
                                 !$errors->has('current_password') && !$errors->has('new_password') && /* Error Keamanan */
                                 !$errors->has('theme') && /* Error Tampilan */
                                 !$errors->has('confirmation') /* Error Hapus Akun */
                                )
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Oops! Terjadi kesalahan.</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <h5 class="mb-4">Pengaturan Akun</h5>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="{{ Auth::user()->avatar_url }}" 
                                             alt="Profile {{ Auth::user()->nama }}" 
                                             class="rounded-circle" 
                                             width="80" 
                                             height="80" 
                                             style="object-fit: cover;" 
                                             id="avatarPreview"
                                             data-original="{{ Auth::user()->avatar_url }}">
                                        
                                        <form action="{{ route('settings.avatar') }}" 
                                              method="POST" 
                                              enctype="multipart/form-data" 
                                              id="avatarForm">
                                            @csrf
                                            <input type="file" 
                                                   name="avatar" 
                                                   id="avatarInput" 
                                                   class="d-none" 
                                                   accept="image/jpeg,image/png,image/jpg">
                                            <button type="button" 
                                                    onclick="document.getElementById('avatarInput').click()" 
                                                    class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-1" 
                                                    style="width: 28px; height: 28px;"
                                                    title="Ubah Foto Profil">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ Auth::user()->nama }}</h6>
                                        <p class="text-muted mb-0 small">{{ ucfirst(Auth::user()->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('settings.account') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" name="nama" value="{{ old('nama', Auth::user()->nama) }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                               id="username" name="username" value="{{ old('username', Auth::user()->username) }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                @if(Auth::user()->role === 'guru')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nip" class="form-label">Nomor Induk Kepegawaian (NIP)</label>
                                        <input type="text" 
                                               class="form-control @error('nip') is-invalid @enderror" 
                                               id="nip" 
                                               name="nip" 
                                               value="{{ old('nip', Auth::user()->nip) }}" 
                                               pattern="[0-9]{18}" 
                                               maxlength="18"
                                               placeholder="Masukkan 18 digit NIP">
                                        <div class="form-text">Format: 18 digit angka</div>
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                                              id="bio" name="bio" rows="3">{{ old('bio', Auth::user()->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                            
                            <hr class="my-4">
                            
                            <h5 class="mb-4 text-danger">Hapus Akun</h5>
                            <p class="text-muted">Menghapus akun Anda akan menghapus semua data dan tidak dapat dikembalikan. Pastikan Anda telah mengunduh data yang diperlukan sebelum menghapus akun.</p>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                Hapus Akun Saya
                            </button>
                        </div>
                        
                        <!-- Security Settings -->
                        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                            @if(session('success_security'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success_security') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if($errors->has('current_password') || $errors->has('new_password') || $errors->has('error') && session('from_security'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Oops! Terjadi kesalahan.</strong>
                                    <ul class="mb-0 mt-2">
                                        @error('current_password') <li>{{ $message }}</li> @enderror
                                        @error('new_password') <li>{{ $message }}</li> @enderror
                                        @error('error') <li>{{ $message }}</li> @enderror
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <h5 class="mb-4">Pengaturan Keamanan</h5>
                            
                            <form action="{{ route('settings.security') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" name="new_password" required
                                           aria-describedby="newPasswordHelp">
                                    <div id="newPasswordHelp" class="form-text">Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol.</div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <h5 class="mb-4">Riwayat Login</h5>
                            <div class="table-responsive">
                                <table class="table table-hover" id="loginHistoryTable">
                                    <thead>
                                        <tr>
                                            <th>Perangkat</th>
                                            <th>Lokasi</th>
                                            <th>Alamat IP</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan="5" class="text-center py-4">Memuat riwayat login...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Appearance Settings -->
                        <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                            @if(session('success_appearance'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success_appearance') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                             @error('theme')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @enderror

                            <h5 class="mb-4">Pengaturan Tampilan</h5>
                            
                            <form action="{{ route('settings.appearance') }}" method="POST" id="appearanceForm">
                                @csrf
                                @method('PUT')
                                
                                <h6 class="mb-3">Tema</h6>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 card-theme-option" data-theme-value="light">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="themeLight" value="light" {{ (Auth::user()->theme ?? config('app.default_theme', 'light')) == 'light' ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="themeLight">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="theme-preview bg-light border rounded p-3 mb-2 w-100" style="height: 100px;">
                                                                <div class="theme-preview-header bg-primary rounded" style="height: 20px; width: 100%;"></div>
                                                                <div class="theme-preview-body bg-white rounded mt-2" style="height: 60px; width: 100%;"></div>
                                                            </div>
                                                            <span>Terang</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100 card-theme-option" data-theme-value="dark">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="themeDark" value="dark" {{ (Auth::user()->theme ?? config('app.default_theme', 'light')) == 'dark' ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="themeDark">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="theme-preview bg-dark border rounded p-3 mb-2 w-100" style="height: 100px;">
                                                                <div class="theme-preview-header bg-primary rounded" style="height: 20px; width: 100%;"></div>
                                                                <div class="theme-preview-body bg-secondary rounded mt-2" style="height: 60px; width: 100%;"></div>
                                                            </div>
                                                            <span>Gelap</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteAccountForm" action="{{ route('settings.delete-account') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i> Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
                    </div>
                    @error('confirmation')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                     @error('error')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                    <p>Untuk mengonfirmasi, silakan ketik: <br><strong>HAPUS AKUN SAYA</strong></p>
                    <input type="text" class="form-control @error('confirmation') is-invalid @enderror" 
                           id="deleteConfirmation" name="confirmation" placeholder="HAPUS AKUN SAYA" required>
                    
                    <div class="mt-3">
                        <label for="deleteReason" class="form-label">Alasan penghapusan (opsional):</label>
                        <textarea class="form-control" id="deleteReason" name="reason" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>Hapus Akun Saya</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
{{-- CSS Variables ini bisa dipindahkan ke file CSS global (misal public/css/app.css) jika diinginkan --}}
{{-- Jika dipindahkan, Anda tidak perlu :root dan [data-bs-theme="dark"] body di sini, hanya styling spesifik tabs --}}
<style>
    /* Jika CSS Variables umum sudah ada di app.blade.php atau app.css, bagian :root dan [data-bs-theme="dark"] body ini bisa dihapus dari sini */
    :root {
        /* Nav Tabs Specific Variables (Light Mode) */
        --app-nav-tabs-link-color: var(--bs-gray-600); /* Warna teks link tab tidak aktif */
        --app-nav-tabs-link-hover-color: var(--app-primary); /* Warna teks link tab hover */
        --app-nav-tabs-link-active-color: var(--app-body-color); /* Warna teks link tab aktif */
        --app-nav-tabs-link-active-bg: var(--app-card-bg); /* Background link tab aktif */
        --app-nav-tabs-link-active-border-color: var(--bs-border-color); /* Warna border untuk tab aktif */
        --app-nav-tabs-border-color: var(--bs-border-color); /* Warna border bawah nav-tabs */
    }

    [data-bs-theme="dark"] {
        /* Nav Tabs Specific Overrides for Dark Mode */
        --app-nav-tabs-link-color: var(--bs-gray-500);
        --app-nav-tabs-link-hover-color: var(--app-primary); /* Primary dark */
        --app-nav-tabs-link-active-color: var(--app-white-text); /* Teks putih */
        --app-nav-tabs-link-active-bg: var(--app-primary); /* Background primary dark */
        --app-nav-tabs-link-active-border-color: var(--app-primary); /* Border primary dark */
        --app-nav-tabs-border-color: var(--bs-border-color);
    }

    /* Styling untuk Card Header tempat Tabs berada */
    .card-header {
        background-color: var(--app-card-header-bg, var(--app-card-bg)) !important; /* Fallback ke app-card-bg jika app-card-header-bg tidak didefinisikan */
        border-bottom-color: var(--app-nav-tabs-border-color) !important;
    }

    /* Styling Nav Tabs */
    .nav-tabs {
        border-bottom-color: var(--app-nav-tabs-border-color);
    }

    .nav-tabs .nav-link {
        color: var(--app-nav-tabs-link-color);
        border: 1px solid transparent;
        border-bottom-color: transparent !important; /* Hilangkan border bawah default Bootstrap */
        margin-bottom: -1px; /* Untuk menempelkan border bawah .nav-link.active ke border .nav-tabs */
    }

    .nav-tabs .nav-link:hover,
    .nav-tabs .nav-link:focus {
        color: var(--app-nav-tabs-link-hover-color);
        border-color: transparent transparent var(--app-nav-tabs-border-color) transparent; /* Hanya border bawah saat hover non-aktif */
        isolation: isolate; /* Untuk z-index stacking jika diperlukan */
    }

    .nav-tabs .nav-link.active {
        color: var(--app-nav-tabs-link-active-color);
        background-color: var(--app-nav-tabs-link-active-bg);
        border-color: var(--app-nav-tabs-link-active-border-color) var(--app-nav-tabs-link-active-border-color) var(--app-nav-tabs-link-active-bg); /* Border bawah sama dengan background aktif */
    }
    /* Hapus border atas card-header-tabs jika ada */
    .nav-tabs.card-header-tabs {
        margin-bottom: -1px; /* Overlap border card-header */
    }


    /* Styling untuk Theme Preview Cards */
    .card-theme-option {
        cursor: pointer;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: 1px solid var(--bs-border-color); /* Gunakan variabel Bootstrap untuk border */
    }
    .card-theme-option:hover {
        transform: translateY(-5px);
        box-shadow: var(--bs-box-shadow-lg) !important; /* Gunakan variabel Bootstrap untuk shadow */
    }
    .card-theme-option .form-check-input {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }
    .card-theme-option label {
        cursor: pointer;
    }

    /* Fix untuk preview tema agar tidak terpengaruh tema utama saat di dark mode */
    .theme-preview.bg-light { /* Tidak perlu [data-bs-theme="dark"] di sini karena ini adalah preview */
        background-color: #f8f9fa !important;
    }
    .theme-preview.bg-light .theme-preview-body.bg-white {
        background-color: #ffffff !important;
    }
    .theme-preview.bg-dark {
         background-color: #212529 !important;
    }
    .theme-preview .theme-preview-header.bg-primary {
         background-color: #0d6efd !important; /* Warna primary Bootstrap default untuk preview */
    }
    .theme-preview.bg-dark .theme-preview-body.bg-secondary {
        background-color: #343a40 !important; /* Mirip --dark-surface-bg untuk preview */
    }
</style>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Delete Account Modal Logic ---
    const deleteConfirmationInput = document.getElementById('deleteConfirmation');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const deleteAccountForm = document.getElementById('deleteAccountForm');

    if (deleteConfirmationInput && confirmDeleteBtn && deleteAccountForm) {
        deleteConfirmationInput.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== 'HAPUS AKUN SAYA';
        });

        confirmDeleteBtn.addEventListener('click', function() {
            deleteAccountForm.submit();
        });
    }

    // --- Avatar Upload Handler ---
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    const avatarPreview = document.getElementById('avatarPreview');

    if (avatarInput && avatarForm && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const formData = new FormData(avatarForm);
                const originalSrc = avatarPreview.getAttribute('data-original');

                const reader = new FileReader();
                reader.onload = function(event) {
                    avatarPreview.src = event.target.result;
                };
                reader.readAsDataURL(this.files[0]);

                fetch(avatarForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.avatar_url) {
                        avatarPreview.setAttribute('data-original', data.avatar_url);
                        alert(data.message || 'Foto profil berhasil diperbarui.');
                    } else {
                        throw new Error(data.message || 'Gagal mengupload foto profil.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    let errorMessage = 'Terjadi kesalahan saat mengupload foto.';
                    if (error && error.message) {
                        errorMessage = error.message;
                    } else if (error && error.errors && error.errors.avatar && error.errors.avatar[0]) {
                        errorMessage = error.errors.avatar[0];
                    }
                    alert(errorMessage);
                    avatarPreview.src = originalSrc;
                });
            }
        });
    }

    // --- Load Login History ---
    function loadLoginHistory() {
        const loginHistoryTable = document.getElementById('loginHistoryTable');
        if (!loginHistoryTable) return;

        const tbody = loginHistoryTable.querySelector('tbody');
        tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Memuat riwayat login...</td></tr>';

        fetch("{{ route('settings.login-history') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                tbody.innerHTML = '';
                if (data && data.length > 0) {
                    data.forEach(entry => {
                        const row = `
                            <tr>
                                <td>${entry.device || 'N/A'}</td>
                                <td>${entry.location || 'N/A'}</td>
                                <td>${entry.ip_address || 'N/A'}</td>
                                <td>${formatLoginTime(entry.login_at)}</td>
                                <td>
                                    <span class="badge bg-${entry.status === 'current' ? 'success' : 'secondary'}">
                                        ${entry.status === 'current' ? 'Saat Ini' : (entry.status || 'Berhasil')}
                                    </span>
                                </td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML('beforeend', row);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Tidak ada riwayat login untuk ditampilkan.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error loading login history:', error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger py-4">Gagal memuat riwayat login. Silakan coba lagi nanti.</td></tr>';
            });
    }

    function formatLoginTime(timestamp) {
        if (!timestamp) return 'N/A';
        try {
            const date = new Date(timestamp);
            const now = new Date();

            if (isNaN(date.getTime())) {
                return 'Invalid Date';
            }

            const optionsDate = { day: 'numeric', month: 'long', year: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: false };

            const dateString = date.toLocaleDateString('id-ID', optionsDate);
            const timeString = date.toLocaleTimeString('id-ID', optionsTime).replace(/\./g, ':');

            if (date.toDateString() === now.toDateString()) {
                return `Hari ini, ${timeString}`;
            }

            const yesterday = new Date(now);
            yesterday.setDate(now.getDate() - 1);
            if (date.toDateString() === yesterday.toDateString()) {
                return `Kemarin, ${timeString}`;
            }
            
            return `${dateString}, ${timeString}`;

        } catch (e) {
            console.error("Error formatting date:", e, "Timestamp:", timestamp);
            return 'Error Date';
        }
    }

    loadLoginHistory();

    // --- Theme Card Click Handler ---
    const themeOptionCards = document.querySelectorAll('.card-theme-option');
    themeOptionCards.forEach(card => {
        card.addEventListener('click', function(event) {
            if (event.target.type === 'radio') return; // Jangan lakukan apa-apa jika radio yang diklik
            
            const radioInput = this.querySelector('input[type="radio"]');
            if (radioInput) {
                radioInput.checked = true;
                // Trigger perubahan tema secara langsung untuk preview (opsional)
                // const themeValue = radioInput.value;
                // document.documentElement.setAttribute('data-bs-theme', themeValue);
                // localStorage.setItem('theme', themeValue); // Simpan untuk konsistensi jika pengguna tidak submit
            }
        });
    });

    // Ketika radio button tema diubah, update atribut data-bs-theme secara langsung untuk preview
    const themeRadioButtons = document.querySelectorAll('input[name="theme"]');
    themeRadioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.setAttribute('data-bs-theme', this.value);
                // Tidak perlu localStorage.setItem di sini karena form akan disubmit
            }
        });
    });


    // --- Tab Persistence ---
    const settingsTabs = document.querySelectorAll('#settingsTabs .nav-link');
    const savedTab = localStorage.getItem('activeSettingsTab');

    if (savedTab) {
        const tabToActivate = document.querySelector(`#settingsTabs .nav-link[data-bs-target="${savedTab}"]`);
        if (tabToActivate) {
            const tab = new bootstrap.Tab(tabToActivate);
            tab.show();
        }
    }

    settingsTabs.forEach(tabEl => {
        tabEl.addEventListener('shown.bs.tab', function (event) {
            localStorage.setItem('activeSettingsTab', event.target.dataset.bsTarget);
        });
    });

    // Activate tab based on server-side errors/success messages
    @if($errors->has('current_password') || $errors->has('new_password') || session('success_security') || (session('error') && session('from_security')))
        const securityTab = new bootstrap.Tab(document.getElementById('security-tab'));
        securityTab.show();
        localStorage.setItem('activeSettingsTab', '#security');
    @elseif($errors->has('theme') || session('success_appearance'))
        const appearanceTab = new bootstrap.Tab(document.getElementById('appearance-tab'));
        appearanceTab.show();
        localStorage.setItem('activeSettingsTab', '#appearance');
    @elseif($errors->any() && !$errors->has('current_password') && !$errors->has('new_password') && !$errors->has('theme') && !$errors->has('confirmation') || (session('success') && !session('success_security') && !session('success_appearance')))
        // Default to account tab if no other specific errors/success
        const accountTab = new bootstrap.Tab(document.getElementById('account-tab'));
        if (!savedTab) { // Hanya tampilkan jika tidak ada tab yang disimpan sebelumnya
            accountTab.show();
            localStorage.setItem('activeSettingsTab', '#account');
        }
    @endif

    // Show delete account modal if there are errors
    @if($errors->has('confirmation') || ($errors->has('error') && session('from_delete_account')))
        const deleteAccountModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        deleteAccountModal.show();
    @endif

});
</script>
@endsection