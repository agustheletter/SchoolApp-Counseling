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
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .request-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }
    
    .student-info {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .student-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        margin-right: 1rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .status-badge {
        font-size: 0.875rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
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
                    <button class="btn btn-success me-2" onclick="exportToExcel()">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                    <button class="btn btn-primary" onclick="refreshPage()">
                        <i class="fas fa-sync-alt me-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Permintaan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daftar Permintaan Konseling</h5>
                </div>
                <div class="card-body">
                    @forelse ($requests as $request)
                    <div class="request-card p-3 {{ $request->priorityClass }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="student-info">
                                <img src="{{ asset('storage/avatars/' . ($request->student->avatar ?? 'default.png')) }}" 
                                     alt="Avatar" 
                                     class="student-avatar">
                                <div>
                                    <h6 class="mb-1">{{ $request->student->nama }}</h6>
                                    <p class="text-muted mb-0">{{ $request->kategori }}</p>
                                </div>
                            </div>
                            <span class="badge bg-{{ $request->priorityBadge }} status-badge">
                                {{ $request->priorityLabel }}
                            </span>
                        </div>
                        
                        <div class="mt-3">
                            <p class="mb-1"><strong>Tanggal Permintaan:</strong> 
                                {{ \Carbon\Carbon::parse($request->tanggal_permintaan)->format('d M Y H:i') }}
                            </p>
                            <p class="mb-2"><strong>Deskripsi:</strong> {{ $request->deskripsi }}</p>
                        </div>

                        <div class="action-buttons mt-3">
                            @if($request->status === 'Pending')
                            <button class="btn btn-success btn-sm" onclick="handleAction('approve', {{ $request->id }})">
                                <i class="fas fa-check me-1"></i> Terima
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="handleAction('reject', {{ $request->id }})">
                                <i class="fas fa-times me-1"></i> Tolak
                            </button>
                            @endif
                            
                            @if($request->status === 'Approved')
                            <button class="btn btn-primary btn-sm" onclick="handleAction('complete', {{ $request->id }})">
                                <i class="fas fa-check-circle me-1"></i> Selesaikan
                            </button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-muted mb-0">Belum ada permintaan konseling.</p>
                    </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                Apakah Anda yakin ingin melakukan tindakan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmAction">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentAction = '';
let currentRequestId = null;
const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));

function handleAction(action, requestId) {
    currentAction = action;
    currentRequestId = requestId;
    
    // Configure modal based on action
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    const confirmBtn = document.getElementById('confirmAction');
    
    switch(action) {
        case 'approve':
            modalTitle.textContent = 'Terima Permintaan';
            modalBody.textContent = 'Apakah Anda yakin ingin menerima permintaan konseling ini?';
            confirmBtn.className = 'btn btn-success';
            break;
        case 'reject':
            modalTitle.textContent = 'Tolak Permintaan';
            modalBody.textContent = 'Apakah Anda yakin ingin menolak permintaan konseling ini?';
            confirmBtn.className = 'btn btn-danger';
            break;
        case 'complete':
            modalTitle.textContent = 'Selesaikan Permintaan';
            modalBody.textContent = 'Apakah Anda yakin ingin menyelesaikan permintaan konseling ini?';
            confirmBtn.className = 'btn btn-primary';
            break;
    }
    
    modal.show();
}

document.getElementById('confirmAction').addEventListener('click', function() {
    if (!currentRequestId || !currentAction) return;
    
    const url = `/teacher/request/${currentRequestId}/${currentAction}`;
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        modal.hide();
        // Show success message
        alert(data.message || 'Tindakan berhasil dilakukan');
        // Refresh the page to show updated data
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});

function refreshPage() {
    location.reload();
}

function exportToExcel() {
    window.location.href = "{{ route('teacher.request.export') }}";
}
</script>
@endsection