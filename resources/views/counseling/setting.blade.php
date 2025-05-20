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
                            <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">
                                <i class="fas fa-bell me-2"></i> Notifikasi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">
                                <i class="fas fa-shield-alt me-2"></i> Privasi
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
                            
                            <form action="{{ route('profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="position-relative me-3">
                                            <img src="https://via.placeholder.com/100" alt="Profile" class="rounded-circle" width="80" height="80">
                                            <button type="button" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle p-1" style="width: 28px; height: 28px;">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Ahmad Rizki</h6>
                                            <p class="text-muted mb-0 small">Siswa</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name" value="Ahmad Rizki" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="ahmad.rizki" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="ahmad.rizki@example.com" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="081234567890">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3">Siswa kelas XI IPA 2 yang tertarik dengan matematika dan teknologi.</textarea>
                                </div>
                                
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
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
                            
                            <form action="{{ route('profile.update-password') }}" method="POST">
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
                                <table class="table table-hover">
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
                                            <td>Jakarta, Indonesia</td>
                                            <td>192.168.1.1</td>
                                            <td>Hari ini, 09:30</td>
                                            <td><span class="badge bg-success">Saat Ini</span></td>
                                        </tr>
                                        <tr>
                                            <td>Safari di iPhone</td>
                                            <td>Jakarta, Indonesia</td>
                                            <td>192.168.1.2</td>
                                            <td>Kemarin, 15:45</td>
                                            <td><span class="badge bg-secondary">Berhasil</span></td>
                                        </tr>
                                        <tr>
                                            <td>Chrome di Windows</td>
                                            <td>Jakarta, Indonesia</td>
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
                            
                            <form action="{{ route('profile.notifications.update') }}" method="POST">
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
                            
                            <form action="{{ route('profile.privacy.update') }}" method="POST">
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
                            
                            <form action="{{ route('profile.appearance.update') }}" method="POST">
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
                                
                                <h6 class="mb-3">Warna Aksen</h6>
                                <div class="mb-4">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="accent_color" id="accentBlue" value="blue" checked style="display: none;">
                                            <label class="form-check-label" for="accentBlue">
                                                <div class="rounded-circle p-3 bg-primary" style="width: 40px; height: 40px; cursor: pointer;"></div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="accent_color" id="accentGreen" value="green" style="display: none;">
                                            <label class="form-check-label" for="accentGreen">
                                                <div class="rounded-circle p-3 bg-success" style="width: 40px; height: 40px; cursor: pointer;"></div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="accent_color" id="accentPurple" value="purple" style="display: none;">
                                            <label class="form-check-label" for="accentPurple">
                                                <div class="rounded-circle p-3" style="width: 40px; height: 40px; cursor: pointer; background-color: #6c5ce7;"></div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="accent_color" id="accentRed" value="red" style="display: none;">
                                            <label class="form-check-label" for="accentRed">
                                                <div class="rounded-circle p-3 bg-danger" style="width: 40px; height: 40px; cursor: pointer;"></div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="accent_color" id="accentOrange" value="orange" style="display: none;">
                                            <label class="form-check-label" for="accentOrange">
                                                <div class="rounded-circle p-3 bg-warning" style="width: 40px; height: 40px; cursor: pointer;"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <h6 class="mb-3">Ukuran Font</h6>
                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="font_size" id="fontSizeSmall" value="small">
                                        <label class="form-check-label" for="fontSizeSmall">
                                            Kecil
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="font_size" id="fontSizeMedium" value="medium" checked>
                                        <label class="form-check-label" for="fontSizeMedium">
                                            Sedang
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="font_size" id="fontSizeLarge" value="large">
                                        <label class="form-check-label" for="fontSizeLarge">
                                            Besar
                                        </label>
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
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i> Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.
                </div>
                <p>Silakan ketik <strong>HAPUS AKUN SAYA</strong> untuk mengonfirmasi:</p>
                <input type="text" class="form-control" id="deleteConfirmation" placeholder="HAPUS AKUN SAYA">
                <div class="mt-3">
                    <label for="deleteReason" class="form-label">Alasan penghapusan (opsional):</label>
                    <textarea class="form-control" id="deleteReason" rows="3"></textarea>
                </div>
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
        // Delete account confirmation
        const deleteConfirmation = document.getElementById('deleteConfirmation');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        
        deleteConfirmation.addEventListener('input', function() {
            if (this.value === 'HAPUS AKUN SAYA') {
                confirmDeleteBtn.disabled = false;
            } else {
                confirmDeleteBtn.disabled = true;
            }
        });
        
        confirmDeleteBtn.addEventListener('click', function() {
            // In a real app, this would send an AJAX request to delete the account
            alert('Akun Anda telah dihapus.');
            window.location.href = "{{ route('home') }}";
        });
        
        // Accent color selection
        const accentColors = document.querySelectorAll('input[name="accent_color"]');
        accentColors.forEach(color => {
            color.nextElementSibling.addEventListener('click', function() {
                // Remove border from all colors
                accentColors.forEach(c => {
                    c.nextElementSibling.querySelector('div').style.border = 'none';
                });
                
                // Add border to selected color
                this.querySelector('div').style.border = '2px solid #000';
                
                // Check the radio button
                color.checked = true;
            });
            
            // Set initial border for checked color
            if (color.checked) {
                color.nextElementSibling.querySelector('div').style.border = '2px solid #000';
            }
        });
    });
</script>
@endsection