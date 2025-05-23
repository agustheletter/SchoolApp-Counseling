@extends('layouts.app')

@section('title', 'Manajemen Permintaan Konseling')

@section('styles')
<style>
    .filter-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    .request-card {
        border-left: 4px solid #6c5ce7;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    
    .request-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
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
    
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    
    .status-approved {
        background-color: #d1edff;
        color: #0c5460;
    }
    
    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    
    .filter-btn {
        border-radius: 20px;
        padding: 0.5rem 1rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        border: 1px solid #dee2e6;
        background-color: white;
        color: #495057;
        transition: all 0.3s ease;
    }
    
    .filter-btn.active {
        background-color: #6c5ce7;
        color: white;
        border-color: #6c5ce7;
    }
    
    .filter-btn:hover {
        background-color: #f8f9fa;
        border-color: #6c5ce7;
    }
    
    .filter-btn.active:hover {
        background-color: #5b4ecc;
    }
    
    .student-avatar {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }
    
    .urgency-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
    }
    
    .urgency-high {
        background-color: #dc3545;
        animation: pulse 2s infinite;
    }
    
    .urgency-medium {
        background-color: #ffc107;
    }
    
    .urgency-low {
        background-color: #28a745;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .bulk-actions {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: none;
    }
    
    .bulk-actions.show {
        display: block;
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
                    <h1 class="h3 mb-0">Manajemen Permintaan Konseling</h1>
                    <p class="text-muted mb-0">Kelola semua permintaan konseling dari siswa</p>
                </div>
                <div>
                    <button class="btn btn-outline-primary me-2" onclick="exportRequests()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                    <button class="btn btn-primary" onclick="refreshRequests()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card filter-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3 mb-lg-0">
                            <label class="form-label fw-bold">Filter Status:</label>
                            <div>
                                <button class="filter-btn active" data-filter="all">Semua (24)</button>
                                <button class="filter-btn" data-filter="pending">Pending (8)</button>
                                <button class="filter-btn" data-filter="approved">Disetujui (12)</button>
                                <button class="filter-btn" data-filter="rejected">Ditolak (3)</button>
                                <button class="filter-btn" data-filter="completed">Selesai (1)</button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label fw-bold">Filter Jenis:</label>
                            <div>
                                <button class="filter-btn" data-filter="academic">Akademik</button>
                                <button class="filter-btn" data-filter="career">Karir</button>
                                <button class="filter-btn" data-filter="personal">Pribadi</button>
                                <button class="filter-btn" data-filter="social">Sosial</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-lg-4 mb-2 mb-lg-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Cari nama siswa..." id="searchInput">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2 mb-lg-0">
                            <select class="form-select" id="priorityFilter">
                                <option value="">Semua Prioritas</option>
                                <option value="high">Prioritas Tinggi</option>
                                <option value="medium">Prioritas Sedang</option>
                                <option value="low">Prioritas Rendah</option>
                            </select>
                        </div>
                        <div class="col-lg-3 mb-2 mb-lg-0">
                            <select class="form-select" id="dateFilter">
                                <option value="">Semua Tanggal</option>
                                <option value="today">Hari Ini</option>
                                <option value="week">Minggu Ini</option>
                                <option value="month">Bulan Ini</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Pilih Semua
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions" id="bulkActions">
        <div class="d-flex justify-content-between align-items-center">
            <span><strong id="selectedCount">0</strong> permintaan dipilih</span>
            <div>
                <button class="btn btn-sm btn-success me-2" onclick="bulkApprove()">
                    <i class="fas fa-check me-1"></i>Setujui Terpilih
                </button>
                <button class="btn btn-sm btn-danger me-2" onclick="bulkReject()">
                    <i class="fas fa-times me-1"></i>Tolak Terpilih
                </button>
                <button class="btn btn-sm btn-outline-secondary" onclick="clearSelection()">
                    <i class="fas fa-times me-1"></i>Batal
                </button>
            </div>
        </div>
    </div>

    <!-- Daftar Permintaan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div id="requestsList">
                        <!-- Request 1 - Prioritas Tinggi -->
                        <div class="card request-card priority-high" data-status="pending" data-type="personal" data-priority="high">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3 mt-1">
                                        <input class="form-check-input request-checkbox" type="checkbox" value="1">
                                    </div>
                                    <img src="https://via.placeholder.com/50x50" class="student-avatar me-3" alt="Student">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1">
                                                    <span class="urgency-indicator urgency-high"></span>
                                                    Hasby Muhammad Sahwa
                                                </h5>
                                                <p class="text-muted mb-0">Kelas XI RPL A • NIS: 1234567890</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge status-pending">Pending</span>
                                                <br>
                                                <small class="text-muted">2 jam yang lalu</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jenis Konseling:</strong> Konseling Pribadi</p>
                                                <p class="mb-1"><strong>Topik:</strong> Masalah kecemasan dan stres menghadapi hidup sebagai perantau</p>
                                                <p class="mb-1"><strong>Prioritas:</strong> <span class="badge bg-danger">Tinggi</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Preferensi Waktu:</strong> Senin-Rabu, 10:00-12:00</p>
                                                <p class="mb-1"><strong>Metode:</strong> Tatap Muka</p>
                                                <p class="mb-1"><strong>Kontak:</strong> 081234567890</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <p class="mb-1"><strong>Deskripsi Masalah:</strong></p>
                                            <p class="text-muted">Saya merasakan resah ingin locat indah</p>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest(1)">
                                                <i class="fas fa-check me-1"></i>Terima
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="rejectRequest(1)">
                                                <i class="fas fa-times me-1"></i>Tolak
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewDetails(1)">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </button>
                                            <button class="btn btn-outline-info btn-sm" onclick="contactStudent(1)">
                                                <i class="fas fa-phone me-1"></i>Hubungi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Request 2 - Prioritas Sedang -->
                        <div class="card request-card priority-medium" data-status="pending" data-type="academic" data-priority="medium">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3 mt-1">
                                        <input class="form-check-input request-checkbox" type="checkbox" value="2">
                                    </div>
                                    <img src="https://via.placeholder.com/50x50" class="student-avatar me-3" alt="Student">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1">
                                                    <span class="urgency-indicator urgency-medium"></span>
                                                    Kitna Mahardika Favian
                                                </h5>
                                                <p class="text-muted mb-0">Kelas XII RPL A • NIS: 1234567891</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge status-pending">Pending</span>
                                                <br>
                                                <small class="text-muted">4 jam yang lalu</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jenis Konseling:</strong> Konseling Akademik</p>
                                                <p class="mb-1"><strong>Topik:</strong> Strategi belajar untuk persiapan UTBK</p>
                                                <p class="mb-1"><strong>Prioritas:</strong> <span class="badge bg-warning">Sedang</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Preferensi Waktu:</strong> Selasa-Kamis, 13:00-15:00</p>
                                                <p class="mb-1"><strong>Metode:</strong> Tatap Muka</p>
                                                <p class="mb-1"><strong>Kontak:</strong> 081234567891</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <p class="mb-1"><strong>Deskripsi Masalah:</strong></p>
                                            <p class="text-muted">Saya membutuhkan bimbingan untuk menyusun strategi belajar yang efektif dalam persiapan UTBK. Nilai try out saya masih belum stabil dan saya bingung cara mengatur waktu belajar yang optimal.</p>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn btn-success btn-sm" onclick="approveRequest(2)">
                                                <i class="fas fa-check me-1"></i>Terima
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="rejectRequest(2)">
                                                <i class="fas fa-times me-1"></i>Tolak
                                            </button>
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewDetails(2)">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </button>
                                            <button class="btn btn-outline-info btn-sm" onclick="contactStudent(2)">
                                                <i class="fas fa-phone me-1"></i>Hubungi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Request 3 - Sudah Disetujui -->
                        <div class="card request-card priority-low" data-status="approved" data-type="career" data-priority="low">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3 mt-1">
                                        <input class="form-check-input request-checkbox" type="checkbox" value="3">
                                    </div>
                                    <img src="https://via.placeholder.com/50x50" class="student-avatar me-3" alt="Student">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1">
                                                    <span class="urgency-indicator urgency-low"></span>
                                                    Raden Airlangga Dewanata
                                                </h5>
                                                <p class="text-muted mb-0">Kelas X IPS 1 • NIS: 1234567892</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge status-approved">Disetujui</span>
                                                <br>
                                                <small class="text-muted">1 hari yang lalu</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jenis Konseling:</strong> Konseling Karir</p>
                                                <p class="mb-1"><strong>Topik:</strong> Eksplorasi minat dan bakat</p>
                                                <p class="mb-1"><strong>Prioritas:</strong> <span class="badge bg-success">Rendah</span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jadwal:</strong> Rabu, 25 Mei 2023, 09:00-10:00</p>
                                                <p class="mb-1"><strong>Lokasi:</strong> Ruang Konseling 1</p>
                                                <p class="mb-1"><strong>Status:</strong> Menunggu konfirmasi siswa</p>
                                            </div>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewSchedule(3)">
                                                <i class="fas fa-calendar me-1"></i>Lihat Jadwal
                                            </button>
                                            <button class="btn btn-outline-warning btn-sm" onclick="reschedule(3)">
                                                <i class="fas fa-edit me-1"></i>Ubah Jadwal
                                            </button>
                                            <button class="btn btn-outline-info btn-sm" onclick="sendReminder(3)">
                                                <i class="fas fa-bell me-1"></i>Kirim Pengingat
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Request 4 - Ditolak -->
                        <div class="card request-card" data-status="rejected" data-type="social" data-priority="medium">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="form-check me-3 mt-1">
                                        <input class="form-check-input request-checkbox" type="checkbox" value="4">
                                    </div>
                                    <img src="https://via.placeholder.com/50x50" class="student-avatar me-3" alt="Student">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="mb-1">
                                                    <span class="urgency-indicator urgency-medium"></span>
                                                    Males Ah
                                                </h5>
                                                <p class="text-muted mb-0">Kelas XI TEI A • NIS: 1234567893</p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge status-rejected">Ditolak</span>
                                                <br>
                                                <small class="text-muted">2 hari yang lalu</small>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Jenis Konseling:</strong> Konseling Sosial</p>
                                                <p class="mb-1"><strong>Topik:</strong> Masalah pertemanan</p>
                                                <p class="mb-1"><strong>Alasan Ditolak:</strong> GAJELAS</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Konselor Alternatif:</strong> Siti Maryam S.KOM M.KOM</p>
                                                <p class="mb-1"><strong>Status Follow-up:</strong> Sudah dirujuk</p>
                                            </div>
                                        </div>
                                        
                                        <div class="action-buttons">
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewRejectionDetails(4)">
                                                <i class="fas fa-eye me-1"></i>Detail Penolakan
                                            </button>
                                            <button class="btn btn-outline-success btn-sm" onclick="reconsiderRequest(4)">
                                                <i class="fas fa-redo me-1"></i>Pertimbangkan Ulang
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer bg-white">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk approve request (sama seperti di dashboard) -->
<!-- Modal untuk reject request (sama seperti di dashboard) -->
<!-- Modal untuk view details -->
<!-- Modal untuk contact student -->

@endsection

@section('scripts')
<script>
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons in the same group
            const group = this.closest('div');
            group.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Apply filter
            applyFilters();
        });
    });
    
    // Checkbox functionality
    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.request-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = this.checked;
        });
        updateBulkActions();
    });
    
    document.querySelectorAll('.request-checkbox').forEach(cb => {
        cb.addEventListener('change', updateBulkActions);
    });
    
    function updateBulkActions() {
        const selectedCheckboxes = document.querySelectorAll('.request-checkbox:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCount = document.getElementById('selectedCount');
        
        if (selectedCheckboxes.length > 0) {
            bulkActions.classList.add('show');
            selectedCount.textContent = selectedCheckboxes.length;
        } else {
            bulkActions.classList.remove('show');
        }
    }
    
    function applyFilters() {
        // Implementation for filtering requests
        console.log('Applying filters...');
    }
    
    function approveRequest(id) {
        // Implementation sama seperti di dashboard
        console.log('Approving request:', id);
    }
    
    function rejectRequest(id) {
        // Implementation sama seperti di dashboard
        console.log('Rejecting request:', id);
    }
    
    function viewDetails(id) {
        console.log('Viewing details for request:', id);
    }
    
    function contactStudent(id) {
        console.log('Contacting student for request:', id);
    }
    
    function bulkApprove() {
        const selected = document.querySelectorAll('.request-checkbox:checked');
        console.log('Bulk approving:', selected.length, 'requests');
    }
    
    function bulkReject() {
        const selected = document.querySelectorAll('.request-checkbox:checked');
        console.log('Bulk rejecting:', selected.length, 'requests');
    }
    
    function clearSelection() {
        document.querySelectorAll('.request-checkbox').forEach(cb => {
            cb.checked = false;
        });
        document.getElementById('selectAll').checked = false;
        updateBulkActions();
    }
    
    function exportRequests() {
        console.log('Exporting requests...');
    }
    
    function refreshRequests() {
        console.log('Refreshing requests...');
        location.reload();
    }
</script>
@endsection