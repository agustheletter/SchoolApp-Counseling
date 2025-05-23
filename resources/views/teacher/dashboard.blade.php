@extends('layouts.app')

@section('title', 'Dashboard Konselor')

@section('styles')
<style>
    .stats-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    
    .request-card {
        border-left: 4px solid #6c5ce7;
        transition: all 0.3s ease;
    }
    
    .request-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .priority-high {
        border-left-color: #dc3545;
    }
    
    .priority-medium {
        border-left-color: #ffc107;
    }
    
    .priority-low {
        border-left-color: #28a745;
    }
    
    .calendar-event {
        background-color: #6c5ce7;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-bottom: 2px;
        display: block;
    }
    
    .quick-action-btn {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .activity-item {
        border-left: 3px solid #e9ecef;
        padding-left: 1rem;
        margin-bottom: 1rem;
        position: relative;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #6c5ce7;
    }
    
    .activity-time {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">Dashboard Konselor</h1>
                    <p class="text-muted mb-0">Selamat datang kembali, Arkan Ardiansyah</p>
                </div>
                <div>
                   <a href="{{ route('teacher.request') }}" class="btn btn-outline-primary quick-action-btn">
                        <i class="fas fa-file-alt me-2"></i>Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary me-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">8</h3>
                            <p class="text-muted mb-0">Permintaan Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success me-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">5</h3>
                            <p class="text-muted mb-0">Sesi Hari Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">42</h3>
                            <p class="text-muted mb-0">Siswa Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info me-3">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 class="mb-0">156</h3>
                            <p class="text-muted mb-0">Total Sesi Bulan Ini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Permintaan Konseling Terbaru -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Permintaan Konseling Terbaru</h5>
                    <a href="" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <!-- Request 1 -->
                        <div class="list-group-item request-card priority-high">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="Student">
                                        <div>
                                            <h6 class="mb-0">Hasby Muhammad Sahwa</h6>
                                            <small class="text-muted">Kelas XI RPL A • NIS: 1234567890</small>
                                        </div>
                                        <span class="badge bg-danger ms-auto">Prioritas Tinggi</span>
                                    </div>
                                    <p class="mb-2"><strong>Jenis:</strong> Konseling Pribadi</p>
                                    <p class="mb-2"><strong>Topik:</strong> Masalah kecemasan dan stres menghadapi hidup sebagai perantau</p>
                                    <p class="mb-2 text-muted"><i class="fas fa-clock me-1"></i> Diajukan 2 jam yang lalu</p>
                                    <p class="mb-0"><strong>Preferensi Waktu:</strong> Senin-Rabu, 10:00-12:00</p>
                                </div>
                                <div class="ms-3">
                                    <button class="btn btn-sm btn-success me-1" onclick="approveRequest(1)">
                                        <i class="fas fa-check"></i> Terima
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="rejectRequest(1)">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Request 2 -->
                        <div class="list-group-item request-card priority-medium">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="Student">
                                        <div>
                                            <h6 class="mb-0">Kitna Mahardika Favian</h6>
                                            <small class="text-muted">Kelas XII RPL A • NIS: 1234567891</small>
                                        </div>
                                        <span class="badge bg-warning ms-auto">Prioritas Sedang</span>
                                    </div>
                                    <p class="mb-2"><strong>Jenis:</strong> Konseling Akademik</p>
                                    <p class="mb-2"><strong>Topik:</strong> Strategi belajar untuk persiapan UTBK</p>
                                    <p class="mb-2 text-muted"><i class="fas fa-clock me-1"></i> Diajukan 4 jam yang lalu</p>
                                    <p class="mb-0"><strong>Preferensi Waktu:</strong> Selasa-Kamis, 13:00-15:00</p>
                                </div>
                                <div class="ms-3">
                                    <button class="btn btn-sm btn-success me-1" onclick="approveRequest(2)">
                                        <i class="fas fa-check"></i> Terima
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="rejectRequest(2)">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Request 3 -->
                        <div class="list-group-item request-card priority-low">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://via.placeholder.com/40x40" class="rounded-circle me-3" alt="Student">
                                        <div>
                                            <h6 class="mb-0">Raden Airlangga Dewanata</h6>
                                            <small class="text-muted">Kelas XI RPL A • NIS: 1234567892</small>
                                        </div>
                                        <span class="badge bg-success ms-auto">Prioritas Rendah</span>
                                    </div>
                                    <p class="mb-2"><strong>Jenis:</strong> Konseling Karir</p>
                                    <p class="mb-2"><strong>Topik:</strong> Eksplorasi minat dan bakat untuk pemilihan jurusan</p>
                                    <p class="mb-2 text-muted"><i class="fas fa-clock me-1"></i> Diajukan 1 hari yang lalu</p>
                                    <p class="mb-0"><strong>Preferensi Waktu:</strong> Senin-Jumat, 08:00-10:00</p>
                                </div>
                                <div class="ms-3">
                                    <button class="btn btn-sm btn-success me-1" onclick="approveRequest(3)">
                                        <i class="fas fa-check"></i> Terima
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="rejectRequest(3)">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Jadwal Hari Ini -->
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Jadwal Hari Ini</h5>
                    <small class="text-muted">{{ date('d F Y') }}</small>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold">09:00 - 10:00</span>
                            <span class="badge bg-primary">Akademik</span>
                        </div>
                        <p class="mb-1">Yusuf Leonardo - Kelas XI TEI A</p>
                        <small class="text-muted">Strategi belajar matematika</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold">11:00 - 12:00</span>
                            <span class="badge bg-warning">Pribadi</span>
                        </div>
                        <p class="mb-1">Rizky Prasetya - Kelas XI RPL A</p>
                        <small class="text-muted">Manajemen stres</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold">13:00 - 14:00</span>
                            <span class="badge bg-success">Karir</span>
                        </div>
                        <p class="mb-1">Supri Stending - Kelas X MEKA A</p>
                        <small class="text-muted">Pemilihan jurusan kuliah</small>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold">15:00 - 16:00</span>
                            <span class="badge bg-info">Sosial</span>
                        </div>
                        <p class="mb-1">Saepodein - Kelas Ruang Guru</p>
                        <small class="text-muted">Adaptasi lingkungan sekolah</small>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="" class="btn btn-outline-primary btn-sm">Lihat Jadwal Lengkap</a>
                    </div>
                </div>
            </div>
            
            <!-- Aktivitas Terbaru -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">Sesi konseling dengan <strong>Yusuf Leonardo</strong> selesai</p>
                                <div class="activity-time">2 jam yang lalu</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">Permintaan konseling dari <strong>Rizky Prasetya</strong> diterima</p>
                                <div class="activity-time">3 jam yang lalu</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">Laporan konseling untuk <strong>Supri Stending</strong> dibuat</p>
                                <div class="activity-time">5 jam yang lalu</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-1">Jadwal konseling minggu depan diperbarui</p>
                                <div class="activity-time">1 hari yang lalu</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="#" class="btn btn-outline-primary btn-sm">Lihat Semua Aktivitas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve Request -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approveModalLabel">Terima Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="approveForm">
                    <div class="mb-3">
                        <label for="scheduledDate" class="form-label">Tanggal Konseling</label>
                        <input type="date" class="form-control" id="scheduledDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="scheduledTime" class="form-label">Waktu Konseling</label>
                        <input type="time" class="form-control" id="scheduledTime" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration" class="form-label">Durasi (menit)</label>
                        <select class="form-select" id="duration">
                            <option value="45">45 menit</option>
                            <option value="60" selected>60 menit</option>
                            <option value="90">90 menit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <select class="form-select" id="location">
                            <option value="room1">Ruang Konseling 1</option>
                            <option value="room2">Ruang Konseling 2</option>
                            <option value="online">Online (Video Call)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" rows="3" placeholder="Catatan tambahan untuk siswa..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" onclick="confirmApprove()">Terima Permintaan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reject Request -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Permintaan Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectForm">
                    <div class="mb-3">
                        <label for="rejectReason" class="form-label">Alasan Penolakan</label>
                        <select class="form-select" id="rejectReason" required>
                            <option value="">Pilih alasan...</option>
                            <option value="schedule_conflict">Konflik jadwal</option>
                            <option value="not_suitable">Tidak sesuai dengan keahlian</option>
                            <option value="insufficient_info">Informasi tidak lengkap</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rejectNotes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" id="rejectNotes" rows="3" placeholder="Berikan penjelasan lebih detail..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alternativeCounselor" class="form-label">Saran Konselor Alternatif (Opsional)</label>
                        <select class="form-select" id="alternativeCounselor">
                            <option value="">Pilih konselor alternatif...</option>
                            <option value="counselor1">Guru Konseling 1 - Konseling Pribadi</option>
                            <option value="counselor2">Guru Konseling 2 - Konseling Karir</option>
                            <option value="counselor3">Guru Konseling 3 - Konseling Sosial</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmReject()">Tolak Permintaan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentRequestId = null;
    
    function approveRequest(requestId) {
        currentRequestId = requestId;
        const approveModal = new bootstrap.Modal(document.getElementById('approveModal'));
        approveModal.show();
    }
    
    function rejectRequest(requestId) {
        currentRequestId = requestId;
        const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
        rejectModal.show();
    }
    
    function confirmApprove() {
        // Validasi form
        const form = document.getElementById('approveForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Simulasi AJAX request
        console.log('Approving request ID:', currentRequestId);
        
        // Tampilkan notifikasi sukses
        alert('Permintaan konseling berhasil diterima! Notifikasi telah dikirim ke siswa.');
        
        // Tutup modal
        const approveModal = bootstrap.Modal.getInstance(document.getElementById('approveModal'));
        approveModal.hide();
        
        // Refresh halaman atau update UI
        location.reload();
    }
    
    function confirmReject() {
        // Validasi form
        const form = document.getElementById('rejectForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Simulasi AJAX request
        console.log('Rejecting request ID:', currentRequestId);
        
        // Tampilkan notifikasi sukses
        alert('Permintaan konseling telah ditolak. Notifikasi telah dikirim ke siswa.');
        
        // Tutup modal
        const rejectModal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
        rejectModal.hide();
        
        // Refresh halaman atau update UI
        location.reload();
    }
    
    // Auto-refresh untuk update real-time (opsional)
    setInterval(function() {
        // Implementasi auto-refresh untuk permintaan baru
        console.log('Checking for new requests...');
    }, 30000); // Check setiap 30 detik
</script>
@endsection