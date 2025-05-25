@extends('layouts.app')

@section('title', 'Permintaan Konseling Saya')

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
                    <a href="{{ route('counseling.my-requests') }}" class="list-group-item list-group-item-action active">
                        <i class="fas fa-list me-2"></i> Permintaan Saya
                    </a>
                    <a href="{{ route('counseling.history') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-history me-2"></i> Riwayat Konseling
                    </a>
                    <a href="{{ route('counseling.setting') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-edit me-2"></i> Edit Profil
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Permintaan Konseling Saya</h5>
                        <a href="{{ route('counseling.request') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus-circle me-1"></i> Ajukan Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jadwal</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $key => $request)
                                <tr>
                                    <td>{{ $requests->firstItem() + $key }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($request->tanggal_permintaan)->format('d M Y, H:i') }}</td>
                                    <td>{{ Str::limit($request->deskripsi, 30) }}</td>
                                    <td>
                                        @switch($request->status)
                                            @case('Pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                                @break
                                            @case('Approved')
                                                <span class="badge bg-success">Disetujui</span>
                                                @break
                                            @case('Completed')
                                                <span class="badge bg-secondary">Selesai</span>
                                                @break
                                            @case('Rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('counseling.request.show', $request->id) }}" 
                                               class="btn btn-info" 
                                               data-bs-toggle="tooltip" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($request->status == 'Pending')
                                                <form action="{{ route('counseling.request.cancel', $request->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-danger" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Batalkan"
                                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Belum ada permintaan konseling</h5>
                                            <a href="{{ route('counseling.request') }}" class="btn btn-primary mt-2">
                                                Ajukan Konseling Sekarang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($requests->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $requests->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Legend -->
            <div class="card shadow-sm mt-4">
                <div class="card-body">
                    <h6 class="card-title">Keterangan Status:</h6>
                    <div class="d-flex flex-wrap gap-3">
                        <div><span class="badge bg-warning text-dark me-1">Menunggu</span> - Permintaan sedang menunggu persetujuan konselor</div>
                        <div><span class="badge bg-success me-1">Disetujui</span> - Permintaan telah disetujui dan dijadwalkan</div>
                        <div><span class="badge bg-secondary me-1">Selesai</span> - Sesi konseling telah selesai</div>
                        <div><span class="badge bg-danger me-1">Ditolak</span> - Permintaan ditolak (lihat detail untuk alasan)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endsection