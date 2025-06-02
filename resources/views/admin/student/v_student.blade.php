@extends('layouts.admin')

@section('title', 'Manajemen Data User')
@section('page-title', 'Data User')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/admin') }}">Admin</a></li>
<li class="breadcrumb-item active">Data User</li>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<style>
    #userTable img.img-thumbnail { 
        max-width: 60px; 
        max-height: 60px; 
        object-fit: cover; 
    }
    #detailPhoto { 
        max-width: 200px; 
        max-height: 250px; 
        object-fit: cover; 
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>
                    Daftar User
                </h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="userTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">NIS</th>
                                <th width="20%">Nama</th>
                                <th width="15%">Email</th>
                                <th width="10%">Jenis Kelamin</th>
                                <th width="10%">No. HP</th>
                                <th width="15%">Tanggal Lahir</th>
                                <th width="8%">Avatar</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail User -->
<div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="detailAvatar" src="" alt="Avatar" class="img-fluid rounded mb-3">
                    </div>
                    <div class="col-md-8">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="30%">NIS</td>
                                <td width="5%">:</td>
                                <td id="detailNis"></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td id="detailNama"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td id="detailEmail"></td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td id="detailGender"></td>
                            </tr>
                            <tr>
                                <td>No. HP</td>
                                <td>:</td>
                                <td id="detailNohp"></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td id="detailTglLahir"></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td id="detailAlamat"></td>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.student') }}",
            type: 'GET',
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error);
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    console.error('Server message:', xhr.responseJSON.message);
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error Loading Data',
                    text: xhr.responseJSON?.message || 'An error occurred while loading the data'
                });
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            {data: 'nis', name: 'nis', defaultContent: '-'},
            {data: 'nama', name: 'nama', defaultContent: '-'},
            {data: 'email', name: 'email', defaultContent: '-'},
            {data: 'gender', name: 'gender', defaultContent: '-'},
            {data: 'nohp', name: 'nohp', defaultContent: '-'},
            {data: 'ttl', name: 'ttl', defaultContent: '-'},
            {data: 'avatar', name: 'avatar', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            processing: "Memproses...",
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data yang dapat ditampilkan",
            infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });
});

// View User Function
function viewUser(id) {
    $.ajax({
        url: `/admin/student/${id}`,
        method: 'GET',
        success: function(response) {
            $('#detailNis').text(response.nis || '-');
            $('#detailNama').text(response.nama);
            $('#detailEmail').text(response.email);
            $('#detailGender').text(response.gender === 'male' ? 'Laki-laki' : 'Perempuan');
            $('#detailNohp').text(response.nohp || '-');
            $('#detailTglLahir').text(response.tgllahir ? moment(response.tgllahir).format('DD-MM-YYYY') : '-');
            $('#detailAlamat').text(response.alamat || '-');
            
            const avatarUrl = response.avatar 
                ? `/storage/avatars/${response.avatar}`
                : `/images/${response.gender === 'male' ? 'default-male.png' : 'default-female.png'}`;
            $('#detailAvatar').attr('src', avatarUrl);
            
            $('#detailUserModal').modal('show');
        },
        error: function(xhr) {
            Swal.fire('Error!', 'Gagal memuat data user', 'error');
            console.error('Ajax error:', xhr);
        }
    });
}

// Delete User Function
function deleteUser(id) {
    Swal.fire({
        title: 'Anda yakin?',
        text: "Data user akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/student/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Sukses!', response.message, 'success');
                        $('#userTable').DataTable().ajax.reload();
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Gagal menghapus data user', 'error');
                    console.error('Ajax error:', xhr);
                }
            });
        }
    });
}
</script>
@endpush