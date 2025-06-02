@extends('layouts.admin')

@section('title', 'Manajemen Data Konselor')
@section('page-title', 'Data Konselor')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Data Konselor</li>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Konselor</h3>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" onclick="showAddCounselorModal()">
                            <i class="fas fa-user-plus"></i> Tambah Konselor
                        </button>
                        <button type="button" class="btn btn-outline-primary active" id="showActive">
                            <i class="fas fa-user-tie"></i> Konselor Aktif
                        </button>
                        <button type="button" class="btn btn-outline-danger" id="showDeleted">
                            <i class="fas fa-user-slash"></i> Konselor Nonaktif
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="konselorTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Konselor</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Pendidikan</th>
                            <th>Spesialisasi</th>
                            <th>Status</th>
                            <th>Photo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Konselor -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Konselor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="counselorPhoto" src="" class="img-fluid rounded mb-3" alt="Photo">
                        <h5 id="counselorName" class="mb-2"></h5>
                        <span id="counselorStatus" class="badge badge-success"></span>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">NIP</th>
                                <td id="counselorNip"></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td id="counselorEmail"></td>
                            </tr>
                            <tr>
                                <th>No. HP</th>
                                <td id="counselorPhone"></td>
                            </tr>
                            <tr>
                                <th>Pendidikan</th>
                                <td id="counselorEducation"></td>
                            </tr>
                            <tr>
                                <th>Spesialisasi</th>
                                <td id="counselorSpecialization"></td>
                            </tr>
                            <tr>
                                <th>Pengalaman</th>
                                <td id="counselorExperience"></td>
                            </tr>
                            <tr>
                                <th>Bergabung Sejak</th>
                                <td id="counselorJoinDate"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Counselor Modal -->
<div class="modal fade" id="addCounselorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Konselor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih User</label>
                    <select class="form-control select2" id="userSelect" style="width: 100%;">
                        <option value="">Pilih User...</option>
                    </select>
                </div>
                <small class="text-muted">
                    * Data konselor dapat dilengkapi oleh yang bersangkutan di menu pengaturan
                </small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveCounselor">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let table = $('#konselorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.counselor.index') }}",
            data: function(d) {
                d.show_deleted = $('#showDeleted').hasClass('active');
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            {data: 'nip', name: 'nip'},
            {data: 'nama_konselor', name: 'nama_konselor'},
            {data: 'email', name: 'email'},
            {data: 'no_hp', name: 'no_hp'},
            {data: 'pendidikan_terakhir', name: 'pendidikan_terakhir'},
            {data: 'spesialisasi', name: 'spesialisasi'},
            {data: 'status_counselor', name: 'status'},
            {data: 'photo', name: 'photo', orderable: false},
            {data: 'action', name: 'action', orderable: false}
        ]
    });

    // Toggle between active and deleted counselors
    $('#showActive, #showDeleted').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        table.ajax.reload();
    });

    // Initialize select2 for user selection
    $('#userSelect').select2({
        placeholder: 'Pilih User...',
        ajax: {
            url: '{{ route("admin.counselor.getUsers") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: `${item.nis} - ${item.nama}`
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Handle save button click - Move this inside document.ready
    $('#saveCounselor').on('click', function() {
        const userId = $('#userSelect').val();
        
        if (!userId) {
            Swal.fire('Error', 'Silakan pilih user terlebih dahulu', 'error');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: 'Jadikan user ini sebagai konselor?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, jadikan konselor!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/counselor/convert/${userId}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#addCounselorModal').modal('hide');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 
                            xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses permintaan', 
                            'error'
                        );
                    }
                });
            }
        });
    });
});

function showAddCounselorModal() {
    $('#userSelect').val(null).trigger('change');
    $('#addCounselorModal').modal('show');
}

// Function to handle saving the counselor conversion
$('#saveCounselor').click(function() {
    const userId = $('#userSelect').val();
    
    if (!userId) {
        Swal.fire('Error', 'Silakan pilih user terlebih dahulu', 'error');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Jadikan user ini sebagai konselor?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, jadikan konselor!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/counselor/convert/${userId}`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Loading...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        $('#addCounselorModal').modal('hide');
                        $('#konselorTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', 
                        xhr.responseJSON?.message || 'Terjadi kesalahan saat memproses permintaan', 
                        'error'
                    );
                    console.error('Ajax error:', xhr);
                }
            });
        }
    });
});

function viewCounselor(id) {
    $.ajax({
        url: `/admin/counselor/${id}`,
        method: 'GET',
        success: function(response) {
            $('#counselorPhoto').attr('src', response.avatar ? 
                `/storage/avatars/${response.avatar}` : 
                `/images/${response.gender === 'L' ? 'default-male.png' : 'default-female.png'}`);
            $('#counselorName').text(response.nama);
            $('#counselorStatus').text(response.status || 'Pending').addClass(`badge-${response.status === 'aktif' ? 'success' : 'secondary'}`);
            $('#counselorNip').text(response.nis);
            $('#counselorEmail').text(response.email);
            $('#counselorPhone').text(response.nohp);
            $('#counselorEducation').text(response.pendidikan_terakhir || '-');
            $('#counselorSpecialization').text(response.spesialisasi || '-');
            $('#counselorExperience').text(response.pengalaman_kerja ? `${response.pengalaman_kerja} tahun` : '-');
            $('#counselorJoinDate').text(response.tanggal_bergabung || '-');
            
            $('#detailModal').modal('show');
        },
        error: function(xhr) {
            Swal.fire('Error', 'Failed to load counselor details', 'error');
        }
    });
}

function deleteCounselor(id) {
    Swal.fire({
        title: 'Hapus Konselor?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/counselor/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        $('#konselorTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Failed to delete counselor', 'error');
                }
            });
        }
    });
}

// Add restore function
function restoreCounselor(id) {
    Swal.fire({
        title: 'Aktifkan Kembali?',
        text: "Konselor akan diaktifkan kembali!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, aktifkan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/counselor/${id}/restore`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        table.ajax.reload();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Gagal mengaktifkan konselor', 'error');
                }
            });
        }
    });
}
</script>
@endpush