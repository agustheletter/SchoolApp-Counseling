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

    <!-- Daftar Permintaan -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daftar Permintaan Konseling</h5>
                </div>
                <div class="card-body">
                    @forelse ($requests as $request)
                    <div class="request-card {{ $request->priorityClass }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $request->student->nama }}</h6>
                                <p class="mb-1"><strong>Kategori:</strong> {{ $request->kategori }}</p>
                                <p class="mb-1"><strong>Deskripsi:</strong> {{ $request->deskripsi }}</p>
                                <p class="mb-1"><strong>Tanggal:</strong> {{ $request->tanggal_permintaan }}</p>
                            </div>
                            <span class="badge bg-{{ $request->priorityBadge }}">{{ $request->priorityLabel }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">Belum ada permintaan konseling.</p>
                    @endforelse

                    <div class="mt-3">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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