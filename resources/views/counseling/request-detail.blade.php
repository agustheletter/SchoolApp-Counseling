@extends('layouts.app')

@section('title', 'Detail Permintaan Konseling')

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
                    @if (Auth::user()->role === 'user')
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action    ">
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
                    <a href="{{ route('counseling.reports') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-file-alt me-2"></i> Laporan
                    </a>
                    @endif
                    <a href="{{ route('counseling.messages') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-comments me-2"></i> Pesan
                    </a>
                    <a href="{{ route('profile.settings') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-cog me-2"></i> Pengaturan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Permintaan Konseling</h5>
                        <a href="{{ route('counseling.my-requests') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Status</td>
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
                                </tr>
                                <tr>
                                    <td class="fw-bold">Tanggal Pengajuan</td>
                                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Jadwal Konseling</td>
                                    <td>{{ \Carbon\Carbon::parse($request->tanggal_permintaan)->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Kategori</td>
                                    <td>{{ $request->kategori }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-bold" width="40%">Konselor</td>
                                    <td>{{ $request->counselor->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">NIP</td>
                                    <td>{{ $request->counselor->nip }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Email</td>
                                    <td>{{ $request->counselor->email }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">Deskripsi:</h6>
                        <p class="mb-4">{{ $request->deskripsi }}</p>
                    </div>

                    @if($request->status == 'Rejected')
                    <div class="alert alert-danger">
                        <h6 class="fw-bold">Alasan Penolakan:</h6>
                        <p class="mb-0">{{ $request->alasan_penolakan ?? 'Tidak ada alasan yang diberikan.' }}</p>
                    </div>
                    @endif

                    @if($request->status == 'Pending')
                    <div class="mt-4">
                        <form action="{{ route('counseling.request.cancel', $request->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan permintaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i> Batalkan Permintaan
                            </button>
                        </form>
                    </div>
                    @endif

                    @if($request->status == 'Approved')
                    <div class="alert alert-info mt-4">
                        <h6 class="fw-bold">Informasi Sesi:</h6>
                        <p class="mb-0">Silakan datang ke ruang BK sesuai jadwal yang telah ditentukan.</p>
                    </div>
                    @endif
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