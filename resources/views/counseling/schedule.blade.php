@extends('layouts.app')

@section('title', 'Jadwal Konseling')

@section('styles')
<style>
    .fc-event {
        cursor: pointer;
    }
    .calendar-container {
        height: 650px;
    }
    .status-badge {
        width: 12px;
        height: 12px;
        display: inline-block;
        border-radius: 50%;
        margin-right: 5px;
    }
    .status-pending {
        background-color: #ffc107;
    }
    .status-approved {
        background-color: #28a745;
    }
    .status-completed {
        background-color: #6c757d;
    }
    .status-rejected {
        background-color: #dc3545;
    }
    .status-cancelled {
        background-color: #dc3545;
    }
    .event-details {
        font-size: 0.9rem;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
@endsection

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
                    <a href="{{ route('counseling.schedule') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-calendar-alt me-2"></i> Jadwal Konseling
                    </a>
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-envelope me-2"></i> Pesan
                    </a>
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar me-2"></i> Laporan
                    </a>
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>

            <!-- Upcoming Sessions -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Sesi Mendatang</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Konseling Akademik</h6>
                                <small class="text-success">Hari ini</small>
                            </div>
                            <p class="mb-1">Dr. Andi Wijaya</p>
                            <small class="text-muted">10:00 - 11:00 • Online</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Konseling Karir</h6>
                                <small class="text-muted">3 hari lagi</small>
                            </div>
                            <p class="mb-1">Budi Santoso, S.Pd</p>
                            <small class="text-muted">13:00 - 14:00 • Ruang Konseling</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Konseling Pribadi</h6>
                                <small class="text-muted">1 minggu lagi</small>
                            </div>
                            <p class="mb-1">Siti Rahayu, M.Psi</p>
                            <small class="text-muted">09:00 - 10:00 • Online</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="{{ route('counseling.my-requests') }}" class="btn btn-sm btn-outline-primary d-block">Lihat Semua Jadwal</a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Jadwal Konseling</h5>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary me-2" id="todayBtn">
                                Hari Ini
                            </button>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" id="prevBtn">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-outline-secondary" id="nextBtn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <div class="btn-group btn-group-sm ms-2">
                                <button class="btn btn-outline-secondary active" id="monthBtn">Bulan</button>
                                <button class="btn btn-outline-secondary" id="weekBtn">Minggu</button>
                                <button class="btn btn-outline-secondary" id="dayBtn">Hari</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="calendar-container" id="calendar"></div>
                </div>
            </div>

            <!-- Legend -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title">Keterangan Status:</h6>
                    <div class="d-flex flex-wrap gap-3">
                        <div><span class="status-badge status-pending"></span> Menunggu - Permintaan sedang menunggu persetujuan konselor</div>
                        <div><span class="status-badge status-approved"></span> Disetujui - Permintaan telah disetujui dan dijadwalkan</div>
                        <div><span class="status-badge status-completed"></span> Selesai - Sesi konseling telah selesai</div>
                        <div><span class="status-badge status-rejected"></span> Ditolak - Permintaan ditolak</div>
                        <div><span class="status-badge status-cancelled"></span> Dibatalkan - Permintaan dibatalkan oleh siswa</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailModalLabel">Detail Sesi Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="event-details">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <span class="status-badge status-approved me-2"></span>
                            <h6 class="mb-0" id="eventTitle">Konseling Akademik</h6>
                        </div>
                        <p class="mb-1" id="eventDescription">Kesulitan dalam memahami pelajaran Matematika</p>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>Tanggal:</strong>
                                <div id="eventDate">15 Mei 2023</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>Waktu:</strong>
                                <div id="eventTime">10:00 - 11:00</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>Konselor:</strong>
                                <div id="eventCounselor">Dr. Andi Wijaya</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <strong>Lokasi:</strong>
                                <div id="eventLocation">Online (Video Call)</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Catatan Konselor:</strong>
                        <div id="eventNotes">Silakan siapkan pertanyaan spesifik tentang materi yang sulit dipahami.</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="startChatBtn">Mulai Chat</button>
                <button type="button" class="btn btn-danger" id="cancelSessionBtn">Batalkan Sesi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize calendar
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: false, // We're using our own header
            height: '100%',
            events: [
                {
                    id: '1',
                    title: 'Konseling Akademik',
                    start: '2023-05-15T10:00:00',
                    end: '2023-05-15T11:00:00',
                    extendedProps: {
                        status: 'approved',
                        counselor: 'Dr. Andi Wijaya',
                        location: 'Online (Video Call)',
                        description: 'Kesulitan dalam memahami pelajaran Matematika',
                        notes: 'Silakan siapkan pertanyaan spesifik tentang materi yang sulit dipahami.'
                    },
                    backgroundColor: '#28a745',
                    borderColor: '#28a745'
                },
                {
                    id: '2',
                    title: 'Konseling Karir',
                    start: '2023-05-18T13:00:00',
                    end: '2023-05-18T14:00:00',
                    extendedProps: {
                        status: 'approved',
                        counselor: 'Budi Santoso, S.Pd',
                        location: 'Ruang Konseling',
                        description: 'Diskusi tentang pilihan jurusan kuliah',
                        notes: 'Bawa hasil tes minat bakat yang telah dilakukan sebelumnya.'
                    },
                    backgroundColor: '#28a745',
                    borderColor: '#28a745'
                },
                {
                    id: '3',
                    title: 'Konseling Pribadi',
                    start: '2023-05-22T09:00:00',
                    end: '2023-05-22T10:00:00',
                    extendedProps: {
                        status: 'approved',
                        counselor: 'Siti Rahayu, M.Psi',
                        location: 'Online',
                        description: 'Mengatasi kecemasan menghadapi ujian',
                        notes: 'Persiapkan jurnal kecemasan yang telah Anda isi selama seminggu.'
                    },
                    backgroundColor: '#28a745',
                    borderColor: '#28a745'
                },
                {
                    id: '4',
                    title: 'Konseling Sosial',
                    start: '2023-05-10T14:00:00',
                    end: '2023-05-10T15:00:00',
                    extendedProps: {
                        status: 'completed',
                        counselor: 'Dewi Lestari, M.Pd',
                        location: 'Ruang Konseling',
                        description: 'Adaptasi dengan lingkungan sekolah baru',
                        notes: 'Sesi telah selesai. Lihat catatan konselor di halaman laporan.'
                    },
                    backgroundColor: '#6c757d',
                    borderColor: '#6c757d'
                },
                {
                    id: '5',
                    title: 'Konseling Akademik',
                    start: '2023-05-05T10:00:00',
                    end: '2023-05-05T11:00:00',
                    extendedProps: {
                        status: 'cancelled',
                        counselor: 'Dr. Andi Wijaya',
                        location: 'Online',
                        description: 'Strategi belajar efektif',
                        notes: 'Dibatalkan oleh siswa.'
                    },
                    backgroundColor: '#dc3545',
                    borderColor: '#dc3545'
                }
            ],
            eventClick: function(info) {
                // Populate modal with event details
                document.getElementById('eventTitle').textContent = info.event.title;
                document.getElementById('eventDescription').textContent = info.event.extendedProps.description;
                
                const startDate = new Date(info.event.start);
                const endDate = new Date(info.event.end);
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('eventDate').textContent = startDate.toLocaleDateString('id-ID', options);
                
                const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: false };
                const startTime = startDate.toLocaleTimeString('id-ID', timeOptions);
                const endTime = endDate.toLocaleTimeString('id-ID', timeOptions);
                document.getElementById('eventTime').textContent = `${startTime} - ${endTime}`;
                
                document.getElementById('eventCounselor').textContent = info.event.extendedProps.counselor;
                document.getElementById('eventLocation').textContent = info.event.extendedProps.location;
                document.getElementById('eventNotes').textContent = info.event.extendedProps.notes;
                
                // Update status badge
                const statusBadge = document.querySelector('.modal-body .status-badge');
                statusBadge.className = 'status-badge me-2';
                statusBadge.classList.add(`status-${info.event.extendedProps.status}`);
                
                // Show/hide buttons based on status
                const startChatBtn = document.getElementById('startChatBtn');
                const cancelSessionBtn = document.getElementById('cancelSessionBtn');
                
                if (info.event.extendedProps.status === 'approved') {
                    startChatBtn.style.display = 'block';
                    cancelSessionBtn.style.display = 'block';
                } else if (info.event.extendedProps.status === 'completed') {
                    startChatBtn.style.display = 'none';
                    cancelSessionBtn.style.display = 'none';
                } else if (info.event.extendedProps.status === 'cancelled') {
                    startChatBtn.style.display = 'none';
                    cancelSessionBtn.style.display = 'none';
                }
                
                // Show modal
                const eventDetailModal = new bootstrap.Modal(document.getElementById('eventDetailModal'));
                eventDetailModal.show();
            }
        });
        
        calendar.render();
        
        // Button handlers
        document.getElementById('todayBtn').addEventListener('click', function() {
            calendar.today();
        });
        
        document.getElementById('prevBtn').addEventListener('click', function() {
            calendar.prev();
        });
        
        document.getElementById('nextBtn').addEventListener('click', function() {
            calendar.next();
        });
        
        document.getElementById('monthBtn').addEventListener('click', function() {
            calendar.changeView('dayGridMonth');
            updateViewButtons('monthBtn');
        });
        
        document.getElementById('weekBtn').addEventListener('click', function() {
            calendar.changeView('timeGridWeek');
            updateViewButtons('weekBtn');
        });
        
        document.getElementById('dayBtn').addEventListener('click', function() {
            calendar.changeView('timeGridDay');
            updateViewButtons('dayBtn');
        });
        
        function updateViewButtons(activeId) {
            document.getElementById('monthBtn').classList.remove('active');
            document.getElementById('weekBtn').classList.remove('active');
            document.getElementById('dayBtn').classList.remove('active');
            document.getElementById(activeId).classList.add('active');
        }
        
        // Modal button handlers
        document.getElementById('startChatBtn').addEventListener('click', function() {
            // Redirect to chat page (in a real app, this would use the event ID)
            window.location.href = "{{ route('counseling.chat', ['id' => 1]) }}";
        });
        
        document.getElementById('cancelSessionBtn').addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin membatalkan sesi konseling ini?')) {
                // In a real app, this would send an AJAX request to cancel the session
                alert('Sesi konseling telah dibatalkan.');
                const eventDetailModal = bootstrap.Modal.getInstance(document.getElementById('eventDetailModal'));
                eventDetailModal.hide();
            }
        });
    });
</script>
@endsection