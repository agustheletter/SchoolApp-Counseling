@extends('layouts.admin')

@section('title', 'Manajemen Kelas')
@section('page-title', 'Data Kelas')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="#">Manajemen Sekolah</a></li>
<li class="breadcrumb-item active">Data Kelas</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-school mr-2"></i>
                    Daftar Kelas
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addKelasModal">
                        <i class="fas fa-plus"></i> Tambah Kelas
                    </button>
                    <button type="button" class="btn btn-success btn-sm" onclick="exportData()">
                        <i class="fas fa-download"></i> Export Excel
                    </button>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">
                        <i class="fas fa-upload"></i> Import Excel
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-control" id="filterJurusan">
                            <option value="">Semua Jurusan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterTingkat">
                            <option value="">Semua Tingkat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non Aktif</option>
                            <option value="lulus">Lulus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-secondary btn-block" onclick="resetFilter()">
                            <i class="fas fa-undo"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <table id="kelasTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Nama Kelas</th>
                            <th width="20%">Jurusan</th>
                            <th width="15%">Tingkat</th>
                            <th width="15%">Wali Kelas</th>
                            <th width="10%">Jml Siswa</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat via DataTables AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="addKelasModal" tabindex="-1" role="dialog" aria-labelledby="addKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addKelasModalLabel">
                    <i class="fas fa-plus mr-2"></i>Tambah Kelas Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addKelasForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="namakelas">Nama Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namakelas" name="namakelas" required placeholder="Contoh: XI RPL A">
                            </div>
                            
                            <div class="form-group">
                                <label for="idjurusan">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-control" id="idjurusan" name="idjurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="idtingkat">Tingkat <span class="text-danger">*</span></label>
                                <select class="form-control" id="idtingkat" name="idtingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="kapasitas">Kapasitas Siswa</label>
                                <input type="number" class="form-control" id="kapasitas" name="kapasitas" min="1" max="50" value="30">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wali_kelas">Wali Kelas</label>
                                <select class="form-control" id="wali_kelas" name="wali_kelas">
                                    <option value="">Pilih Wali Kelas</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="ruang_kelas">Ruang Kelas</label>
                                <input type="text" class="form-control" id="ruang_kelas" name="ruang_kelas" placeholder="Contoh: R.101">
                            </div>
                            
                            <div class="form-group">
                                <label for="tahun_ajaran">Tahun Ajaran</label>
                                <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="2024/2025">
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status Kelas</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                    <option value="lulus">Lulus</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Catatan tambahan..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="modal fade" id="editKelasModal" tabindex="-1" role="dialog" aria-labelledby="editKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="editKelasModalLabel">
                    <i class="fas fa-edit mr-2"></i>Edit Kelas
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editKelasForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_idkelas" name="idkelas">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_namakelas">Nama Kelas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_namakelas" name="namakelas" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_idjurusan">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_idjurusan" name="idjurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_idtingkat">Tingkat <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_idtingkat" name="idtingkat" required>
                                    <option value="">Pilih Tingkat</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_kapasitas">Kapasitas Siswa</label>
                                <input type="number" class="form-control" id="edit_kapasitas" name="kapasitas" min="1" max="50">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_wali_kelas">Wali Kelas</label>
                                <select class="form-control" id="edit_wali_kelas" name="wali_kelas">
                                    <option value="">Pilih Wali Kelas</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_ruang_kelas">Ruang Kelas</label>
                                <input type="text" class="form-control" id="edit_ruang_kelas" name="ruang_kelas">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tahun_ajaran">Tahun Ajaran</label>
                                <input type="text" class="form-control" id="edit_tahun_ajaran" name="tahun_ajaran">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_status">Status Kelas</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                    <option value="lulus">Lulus</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="edit_keterangan">Keterangan</label>
                                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Kelas -->
<div class="modal fade" id="detailKelasModal" tabindex="-1" role="dialog" aria-labelledby="detailKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="detailKelasModalLabel">
                    <i class="fas fa-info-circle mr-2"></i>Detail Kelas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Nama Kelas</strong></td>
                                <td width="5%">:</td>
                                <td id="detailNamaKelas"></td>
                            </tr>
                            <tr>
                                <td><strong>Jurusan</strong></td>
                                <td>:</td>
                                <td id="detailJurusan"></td>
                            </tr>
                            <tr>
                                <td><strong>Tingkat</strong></td>
                                <td>:</td>
                                <td id="detailTingkat"></td>
                            </tr>
                            <tr>
                                <td><strong>Wali Kelas</strong></td>
                                <td>:</td>
                                <td id="detailWaliKelas"></td>
                            </tr>
                            <tr>
                                <td><strong>Ruang Kelas</strong></td>
                                <td>:</td>
                                <td id="detailRuangKelas"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="40%"><strong>Tahun Ajaran</strong></td>
                                <td width="5%">:</td>
                                <td id="detailTahunAjaran"></td>
                            </tr>
                            <tr>
                                <td><strong>Kapasitas</strong></td>
                                <td>:</td>
                                <td id="detailKapasitas"></td>
                            </tr>
                            <tr>
                                <td><strong>Jumlah Siswa</strong></td>
                                <td>:</td>
                                <td id="detailJumlahSiswa"></td>
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td>:</td>
                                <td id="detailStatus"></td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td>:</td>
                                <td id="detailKeterangan"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="printDetail()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="importModalLabel">
                    <i class="fas fa-upload mr-2"></i>Import Data Kelas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="importForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="import_file">File Excel <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="import_file" name="import_file" accept=".xlsx,.xls" required>
                                <label class="custom-file-label" for="import_file">Pilih file...</label>
                            </div>
                        </div>
                        <small class="form-text text-muted">Format file: .xlsx atau .xls</small>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Petunjuk Import:</h6>
                        <ol class="mb-0">
                            <li>Download template Excel terlebih dahulu</li>
                            <li>Isi data sesuai format yang tersedia</li>
                            <li>Upload file yang sudah diisi</li>
                        </ol>
                    </div>
                    
                    <a href="#" class="btn btn-outline-primary btn-sm" onclick="downloadTemplate()">
                        <i class="fas fa-download"></i> Download Template Excel
                    </a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-upload"></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Load dropdown data
    loadDropdownData();

    // Initialize DataTable
    var table = $('#kelasTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "#",
            type: 'GET',
            data: function(d) {
                d.jurusan = $('#filterJurusan').val();
                d.tingkat = $('#filterTingkat').val();
                d.status = $('#filterStatus').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'namakelas', name: 'namakelas' },
            { data: 'jurusan', name: 'jurusan.namajurusan' },
            { data: 'tingkat', name: 'tingkat.namattingkat' },
            { data: 'wali_kelas', name: 'wali_kelas' },
            { data: 'jumlah_siswa', name: 'jumlah_siswa', orderable: false, searchable: false },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
        }
    });

    // Filter events
    $('#filterJurusan, #filterTingkat, #filterStatus').change(function() {
        table.ajax.reload();
    });

    // Custom file input labels
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Form submissions
    $('#addKelasForm').on('submit', function(e) {
        e.preventDefault();
        submitForm(this, "#", 'POST', '#addKelasModal');
    });

    $('#editKelasForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_idkelas').val();
        submitForm(this, "#" + id, 'POST', '#editKelasModal');
    });

    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        submitForm(this, "#", 'POST', '#importModal');
    });
});

// Functions
function loadDropdownData() {
    // Load Jurusan
    $.ajax({
        url: "#",
        type: 'GET',
        data: { type: 'jurusan' },
        success: function(data) {
            var options = '<option value="">Pilih Jurusan</option>';
            var filterOptions = '<option value="">Semua Jurusan</option>';
            
            $.each(data, function(index, item) {
                options += '<option value="' + item.idjurusan + '">' + item.namajurusan + ' (' + item.kodejurusan + ')</option>';
                filterOptions += '<option value="' + item.idjurusan + '">' + item.namajurusan + '</option>';
            });
            
            $('#idjurusan, #edit_idjurusan').html(options);
            $('#filterJurusan').html(filterOptions);
        }
    });

    // Load Tingkat
    $.ajax({
        url: "#",
        type: 'GET',
        data: { type: 'tingkat' },
        success: function(data) {
            var options = '<option value="">Pilih Tingkat</option>';
            var filterOptions = '<option value="">Semua Tingkat</option>';
            
            $.each(data, function(index, item) {
                options += '<option value="' + item.idtingkat + '">' + item.namattingkat + '</option>';
                filterOptions += '<option value="' + item.idtingkat + '">' + item.namattingkat + '</option>';
            });
            
            $('#idtingkat, #edit_idtingkat').html(options);
            $('#filterTingkat').html(filterOptions);
        }
    });

    // Load Guru
    $.ajax({
        url: "#",
        type: 'GET',
        data: { type: 'guru' },
        success: function(data) {
            var options = '<option value="">Pilih Wali Kelas</option>';
            
            $.each(data, function(index, item) {
                options += '<option value="' + item.idguru + '">' + item.namaguru + ' - ' + item.nip + '</option>';
            });
            
            $('#wali_kelas, #edit_wali_kelas').html(options);
        }
    });
}

function submitForm(form, url, method, modalSelector) {
    var formData = new FormData(form);
    
    $.ajax({
        url: url,
        type: method,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                $(modalSelector).modal('hide');
                $(form)[0].reset();
                $('#kelasTable').DataTable().ajax.reload();
            }
        },
        error: function(xhr) {
            var errors = xhr.responseJSON.errors;
            var errorMessage = '';
            
            if (errors) {
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '\n';
                });
            } else {
                errorMessage = xhr.responseJSON.message || 'Terjadi kesalahan';
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage
            });
        }
    });
}

function editKelas(id) {
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            $('#edit_idkelas').val(data.idkelas);
            $('#edit_namakelas').val(data.namakelas);
            $('#edit_idjurusan').val(data.idjurusan);
            $('#edit_idtingkat').val(data.idtingkat);
            $('#edit_kapasitas').val(data.kapasitas);
            $('#edit_wali_kelas').val(data.wali_kelas);
            $('#edit_ruang_kelas').val(data.ruang_kelas);
            $('#edit_tahun_ajaran').val(data.tahun_ajaran);
            $('#edit_status').val(data.status);
            $('#edit_keterangan').val(data.keterangan);
            
            $('#editKelasModal').modal('show');
        }
    });
}

function deleteKelas(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data kelas akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "#" + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#kelasTable').DataTable().ajax.reload();
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menghapus data'
                    });
                }
            });
        }
    });
}

function viewKelas(id) {
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            $('#detailNamaKelas').text(data.namakelas);
            $('#detailJurusan').text(data.jurusan_nama);
            $('#detailTingkat').text(data.tingkat_nama);
            $('#detailWaliKelas').text(data.wali_kelas_nama || '-');
            $('#detailRuangKelas').text(data.ruang_kelas || '-');
            $('#detailTahunAjaran').text(data.tahun_ajaran || '-');
            $('#detailKapasitas').text(data.kapasitas + ' siswa');
            $('#detailJumlahSiswa').text(data.jumlah_siswa + ' siswa');
            $('#detailKeterangan').text(data.keterangan || '-');
            
            // Status badge
            var statusClass = data.status == 'aktif' ? 'badge-success' : (data.status == 'lulus' ? 'badge-info' : 'badge-danger');
            $('#detailStatus').html('<span class="badge ' + statusClass + '">' + data.status.charAt(0).toUpperCase() + data.status.slice(1) + '</span>');
            
            $('#detailKelasModal').modal('show');
        }
    });
}

function resetFilter() {
    $('#filterJurusan, #filterTingkat, #filterStatus').val('');
    $('#kelasTable').DataTable().ajax.reload();
}

function exportData() {
    window.location.href = "#";
}

function downloadTemplate() {
    window.location.href = "#";
}

function printDetail() {
    window.print();
}
</script>
@endsection
