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
                    <a href="#" class="list-group-item list-group-item-action">
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
                                    <th>Konselor</th>
                                    <th>Jadwal</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Contoh data -->
                                <tr>
                                    <td>1</td>
                                    <td>10 Mei 2023</td>
                                    <td>Dr. Andi Wijaya</td>
                                    <td>15 Mei 2023, 10:00</td>
                                    <td>Akademik</td>
                                    <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-info" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger" data-bs-toggle="tooltip" title="Batalkan">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>5 Mei 2023</td>
                                    <td>Siti Rahayu, M.Psi</td>
                                    <td>12 Mei 2023, 13:00</td>
                                    <td>Pribadi</td>
                                    <td><span class="badge bg-success">Disetujui</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-info" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="tooltip" title="Mulai Chat">
                                                <i class="fas fa-comments"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>1 Mei 2023</td>
                                    <td>Budi Santoso, S.Pd</td>
                                    <td>3 Mei 2023, 14:00</td>
                                    <td>Karir</td>
                                    <td><span class="badge bg-secondary">Selesai</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-info" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-success" data-bs-toggle="tooltip" title="Beri Ulasan">
                                                <i class="fas fa-star"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>25 April 2023</td>
                                    <td>Dewi Lestari, M.Pd</td>
                                    <td>28 April 2023, 09:00</td>
                                    <td>Sosial</td>
                                    <td><span class="badge bg-danger">Ditolak</span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="#" class="btn btn-info" data-bs-toggle="tooltip" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-primary" data-bs-toggle="tooltip" title="Ajukan Ulang">
                                                <i class="fas fa-redo"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center">
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