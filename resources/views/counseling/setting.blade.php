@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <!-- Sidebar Menu -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
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
                    <a href="{{ route('counseling.schedule') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Konseling
                    </a>
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope me-2"></i> Pesan
                    </a>
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
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
                <div class="card-header bg-white">
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
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <h5 class="mb-4">Pengaturan Akun</h5>
                            
                            <!-- Profile Section with Avatar -->
                            <div class="mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
                                        <img src="{{ auth()->user()->avatar_url }}" 
                                             alt="Profile" 
                                             class="rounded-circle" 
                                             width="80" 
                                             height="80" 
                                             style="object-fit: cover;" 
                                             id="avatarPreview"
                                             data-original="{{ auth()->user()->avatar_url }}">
                                        
                                        <form action="{{ route('settings.avatar') }}" 
                                              method="POST" 
                                              enctype="multipart/form-data" 
                                              id="avatarForm">
                                            @csrf
                                            <input type="file" 
                                                   name="avatar" 
                                                   id="avatarInput" 
                                                   class="d-none" 
                                                   accept="image/*">
                                            <button type="button" 
                                                    onclick="document.getElementById('avatarInput').click()" 
                                                    class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-1" 
                                                    style="width: 28px; height: 28px;">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">{{ $user->nama }}</h6>
                                        <p class="text-muted mb-0 small">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Settings Form -->
                            <form action="{{ route('settings.account') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                               id="nama" name="nama" value="{{ $user->nama }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                                    </div>
                                </div>
                                
                                <!-- Add NIP field for guru role -->
                                @if($user->role === 'guru')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nip" class="form-label">Nomor Induk Kepegawaian (NIP)</label>
                                        <input type="text" 
                                               class="form-control @error('nip') is-invalid @enderror" 
                                               id="nip" 
                                               name="nip" 
                                               value="{{ $user->nip }}" 
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
                                    <textarea class="form-control" id="bio" name="bio" rows="3">{{ $user->bio }}</textarea>
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
                            <h5 class="mb-4">Pengaturan Keamanan</h5>
                            
                            <!-- Security Settings Form -->
                            <form action="{{ route('settings.security') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    <div class="form-text">Password harus minimal 8 karakter dan mengandung huruf, angka, dan simbol.</div>
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
                                        <tr>
                                            <td>Chrome di Windows</td>
                                            <td>Cimahi, Indonesia</td>
                                            <td>192.168.1.1</td>
                                            <td>Hari ini, 09:30</td>
                                            <td><span class="badge bg-success">Saat Ini</span></td>
                                        </tr>
                                        <tr>
                                            <td>Chrome di Android</td>
                                            <td>Cimahi, Indonesia</td>
                                            <td>192.168.1.2</td>
                                            <td>Kemarin, 15:45</td>
                                            <td><span class="badge bg-secondary">Berhasil</span></td>
                                        </tr>
                                        <tr>
                                            <td>Chrome di Windows</td>
                                            <td>Cimahi, Indonesia</td>
                                            <td>192.168.1.1</td>
                                            <td>3 hari lalu, 10:15</td>
                                            <td><span class="badge bg-secondary">Berhasil</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Notification Settings -->
                        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <h5 class="mb-4">Pengaturan Notifikasi</h5>
                            
                            <form action="" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <h6 class="mb-3">Metode Pemberitahuan</h6>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notifications" checked>
                                                <label class="form-check-label" for="emailNotifications">Email</label>
                                            </div>
                                            <div class="form-text">Terima notifikasi melalui email</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="browserNotifications" name="browser_notifications" checked>
                                                <label class="form-check-label" for="browserNotifications">Browser</label>
                                            </div>
                                            <div class="form-text">Terima notifikasi di browser saat online</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Jenis Notifikasi</h6>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="counselingNotifications" name="counseling_notifications" checked>
                                                <label class="form-check-label" for="counselingNotifications">Konseling</label>
                                            </div>
                                            <div class="form-text">Permintaan, persetujuan, dan pengingat konseling</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="messageNotifications" name="message_notifications" checked>
                                                <label class="form-check-label" for="messageNotifications">Pesan</label>
                                            </div>
                                            <div class="form-text">Pesan baru dari konselor</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="systemNotifications" name="system_notifications" checked>
                                                <label class="form-check-label" for="systemNotifications">Sistem</label>
                                            </div>
                                            <div class="form-text">Pembaruan sistem dan pengumuman</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="materialNotifications" name="material_notifications" checked>
                                                <label class="form-check-label" for="materialNotifications">Materi</label>
                                            </div>
                                            <div class="form-text">Materi dan sumber daya baru</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Frekuensi Email</h6>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="email_frequency" id="emailFrequencyRealtime" value="realtime" checked>
                                        <label class="form-check-label" for="emailFrequencyRealtime">
                                            Langsung
                                        </label>
                                        <div class="form-text">Kirim email segera saat ada notifikasi baru</div>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="email_frequency" id="emailFrequencyDaily" value="daily">
                                        <label class="form-check-label" for="emailFrequencyDaily">
                                            Harian
                                        </label>
                                        <div class="form-text">Kirim ringkasan harian dari semua notifikasi</div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="email_frequency" id="emailFrequencyWeekly" value="weekly">
                                        <label class="form-check-label" for="emailFrequencyWeekly">
                                            Mingguan
                                        </label>
                                        <div class="form-text">Kirim ringkasan mingguan dari semua notifikasi</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Privacy Settings -->
                        <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                            <h5 class="mb-4">Pengaturan Privasi</h5>
                            
                            <form action="#" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <h6 class="mb-3">Visibilitas Profil</h6>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="profile_visibility" id="profileVisibilityPublic" value="public">
                                        <label class="form-check-label" for="profileVisibilityPublic">
                                            Publik
                                        </label>
                                        <div class="form-text">Semua pengguna dapat melihat profil Anda</div>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="profile_visibility" id="profileVisibilitySchool" value="school" checked>
                                        <label class="form-check-label" for="profileVisibilitySchool">
                                            Sekolah
                                        </label>
                                        <div class="form-text">Hanya pengguna dari sekolah yang sama yang dapat melihat profil Anda</div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="profile_visibility" id="profileVisibilityPrivate" value="private">
                                        <label class="form-check-label" for="profileVisibilityPrivate">
                                            Pribadi
                                        </label>
                                        <div class="form-text">Hanya konselor dan administrator yang dapat melihat profil Anda</div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Riwayat Konseling</h6>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="counseling_history_visibility" id="counselingHistoryVisibilityAll" value="all">
                                        <label class="form-check-label" for="counselingHistoryVisibilityAll">
                                            Semua Konselor
                                        </label>
                                        <div class="form-text">Semua konselor dapat melihat riwayat konseling Anda</div>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="counseling_history_visibility" id="counselingHistoryVisibilityAssigned" value="assigned" checked>
                                        <label class="form-check-label" for="counselingHistoryVisibilityAssigned">
                                            Konselor yang Ditugaskan
                                        </label>
                                        <div class="form-text">Hanya konselor yang pernah menangani Anda yang dapat melihat riwayat konseling Anda</div>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="counseling_history_visibility" id="counselingHistoryVisibilityNone" value="none">
                                        <label class="form-check-label" for="counselingHistoryVisibilityNone">
                                            Tidak Ada
                                        </label>
                                        <div class="form-text">Konselor hanya dapat melihat sesi konseling yang mereka tangani</div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Data dan Privasi</h6>
                                <div class="mb-4">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="dataAnalytics" name="data_analytics" checked>
                                        <label class="form-check-label" for="dataAnalytics">Analitik Data</label>
                                        <div class="form-text">Izinkan penggunaan data Anda untuk analisis dan peningkatan layanan</div>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="thirdPartySharing" name="third_party_sharing">
                                        <label class="form-check-label" for="thirdPartySharing">Berbagi dengan Pihak Ketiga</label>
                                        <div class="form-text">Izinkan berbagi data Anda dengan pihak ketiga untuk tujuan pendidikan</div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </div>
                            </form>
                            
                            <hr class="my-4">
                            
                            <h5 class="mb-4">Unduh Data Anda</h5>
                            <p class="text-muted">Anda dapat mengunduh salinan data pribadi Anda yang disimpan dalam sistem kami.</p>
                            <button type="button" class="btn btn-outline-primary">
                                <i class="fas fa-download me-2"></i> Unduh Data Saya
                            </button>
                        </div>
                        
                        <!-- Appearance Settings -->
                        <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                            <h5 class="mb-4">Pengaturan Tampilan</h5>
                            
                            <!-- Appearance Settings Form -->
                            <form action="{{ route('settings.appearance') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <h6 class="mb-3">Tema</h6>
                                <div class="row mb-4">
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="themeLight" value="light" checked>
                                                    <label class="form-check-label w-100" for="themeLight">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="bg-light border rounded p-3 mb-2 w-100" style="height: 100px;">
                                                                <div class="bg-primary rounded" style="height: 20px; width: 100%;"></div>
                                                                <div class="bg-white rounded mt-2" style="height: 60px; width: 100%;"></div>
                                                            </div>
                                                            <span>Terang</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="themeDark" value="dark">
                                                    <label class="form-check-label w-100" for="themeDark">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="bg-dark border rounded p-3 mb-2 w-100" style="height: 100px;">
                                                                <div class="bg-primary rounded" style="height: 20px; width: 100%;"></div>
                                                                <div class="bg-secondary rounded mt-2" style="height: 60px; width: 100%;"></div>
                                                            </div>
                                                            <span>Gelap</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="theme" id="themeSystem" value="system">
                                                    <label class="form-check-label w-100" for="themeSystem">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <div class="bg-light border rounded p-3 mb-2 w-100" style="height: 100px; background: linear-gradient(to right, white 50%, #343a40 50%);">
                                                                <div class="bg-primary rounded" style="height: 20px; width: 100%;"></div>
                                                                <div style="height: 60px; width: 100%; margin-top: 0.5rem; background: linear-gradient(to right, white 50%, #6c757d 50%);" class="rounded"></div>
                                                            </div>
                                                            <span>Sistem</span>
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
    <div class="modal-dialog">
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
                    <p>Silakan ketik <strong>HAPUS AKUN SAYA</strong> untuk mengonfirmasi:</p>
                    <input type="text" class="form-control" id="deleteConfirmation" name="confirmation" placeholder="HAPUS AKUN SAYA">
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteConfirmation = document.getElementById('deleteConfirmation');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const deleteAccountForm = document.getElementById('deleteAccountForm');
        
        deleteConfirmation.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== 'HAPUS AKUN SAYA';
        });
        
        confirmDeleteBtn.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.')) {
                deleteAccountForm.submit();
            }
        });
    });
    
    // Avatar upload handler
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatarInput');
        const avatarForm = document.getElementById('avatarForm');
        const avatarPreview = document.getElementById('avatarPreview');

        if (avatarInput && avatarForm) {
            avatarInput.addEventListener('change', function(e) {
                e.preventDefault();
                if (this.files && this.files[0]) {
                    const formData = new FormData(avatarForm);
                    
                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);

                    // Send AJAX request
                    fetch(avatarForm.action, {
                        method: 'POST',
                        body: formData,
                        credentials: 'same-origin',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest',
                            // Don't set Content-Type header when sending FormData
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Success notification
                            alert('Foto profil berhasil diperbarui');
                        } else {
                            // Error notification
                            alert('Gagal mengupload foto profil');
                            // Revert preview
                            avatarPreview.src = avatarPreview.getAttribute('data-original');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengupload foto');
                        // Revert preview
                        avatarPreview.src = avatarPreview.getAttribute('data-original');
                    });
                }
            });
        }
    });
    
    function loadLoginHistory() {
        fetch('{{ route("settings.login-history") }}')
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#loginHistoryTable tbody');
                tbody.innerHTML = '';
                
                data.forEach(entry => {
                    const row = `
                        <tr>
                            <td>${entry.device}</td>
                            <td>${entry.location}</td>
                            <td>${entry.ip_address}</td>
                            <td>${formatLoginTime(entry.login_at)}</td>
                            <td>
                                <span class="badge bg-${entry.status === 'current' ? 'success' : 'secondary'}">
                                    ${entry.status === 'current' ? 'Saat Ini' : 'Berhasil'}
                            </span>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    function formatLoginTime(timestamp) {
        if (!timestamp) return 'Never';
        
        const date = new Date(timestamp);
        const now = new Date();
        const diff = now - date;
        
        // Less than 24 hours
        if (diff < 24 * 60 * 60 * 1000) {
            return 'Hari ini, ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
        
        // Less than 48 hours
        if (diff < 48 * 60 * 60 * 1000) {
            return 'Kemarin, ' + date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }
        
        // More than 48 hours
        return date.toLocaleDateString('id-ID', { 
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadLoginHistory();
    });
</script>
@endsection