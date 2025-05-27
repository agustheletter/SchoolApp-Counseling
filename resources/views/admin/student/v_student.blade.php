@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa')
@section('page-title', 'Data Siswa')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Data Siswa</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users mr-2"></i>
                    Daftar Siswa
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addSiswaModal">
                        <i class="fas fa-plus"></i> Tambah Siswa
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
                            <option value="1">Rekayasa Perangkat Lunak</option>
                            <option value="2">Sistem Informasi, Jaringan, dan Aplikasi</option>
                            <option value="3">Produksi dan Siaran Program Televisi</option>
                            <option value="4">Teknik Pemanasan, Tata Udara, dan Pendinginan</option>
                            <option value="5">Instrumentasi dan Otomatisasi Proses</option>
                            <option value="6">Teknik Elektronika Komunikasi</option>
                            <option value="7">Teknik Otomasi Industri</option>
                            <option value="8">Teknik Elektronika Industri</option>
                            <option value="9">Teknik Mekatronika</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterTahunMasuk">
                            <option value="">Semua Tahun Masuk</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterJenkel">
                            <option value="">Semua Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-secondary btn-block" onclick="resetFilter()">
                            <i class="fas fa-undo"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <table id="siswaTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="8%">NIS</th>
                            <th width="10%">NISN</th>
                            <th width="15%">Nama Siswa</th>
                            <th width="8%">Jenis Kelamin</th>
                            <th width="12%">Tempat, Tgl Lahir</th>
                            <th width="12%">Jurusan</th>
                            <th width="8%">Tahun Masuk</th>
                            <th width="8%">Photo</th>
                            <th width="14%">Aksi</th>
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

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="addSiswaModal" tabindex="-1" role="dialog" aria-labelledby="addSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addSiswaModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Data Siswa
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSiswaForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nis">NIS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nis" name="nis" required>
                                <small class="form-text text-muted">Nomor Induk Siswa</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="nisn">NISN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nisn" name="nisn" required>
                                <small class="form-text text-muted">Nomor Induk Siswa Nasional</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="namasiswa">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="namasiswa" name="namasiswa" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="tempatlahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="tgllahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgllahir" name="tgllahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="jenkel">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" id="jenkel" name="jenkel" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idjurusan">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="idjurusan" name="idjurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="1">Teknik Komputer dan Jaringan</option>
                                    <option value="2">Rekayasa Perangkat Lunak</option>
                                    <option value="3">Multimedia</option>
                                    <option value="4">Teknik Kendaraan Ringan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="idprogramkeahlian">Program Keahlian <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="idprogramkeahlian" name="idprogramkeahlian" required>
                                    <option value="">Pilih Program Keahlian</option>
                                    <!-- Options akan dimuat berdasarkan jurusan yang dipilih -->
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="idagama">Agama <span class="text-danger">*</span></label>
                                <select class="form-control" id="idagama" name="idagama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="1">Islam</option>
                                    <option value="2">Kristen Protestan</option>
                                    <option value="3">Kristen Katolik</option>
                                    <option value="4">Hindu</option>
                                    <option value="5">Buddha</option>
                                    <option value="6">Konghucu</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="tlprumah">Telepon Rumah</label>
                                <input type="text" class="form-control" id="tlprumah" name="tlprumah">
                            </div>
                            
                            <div class="form-group">
                                <label for="hpsiswa">HP Siswa</label>
                                <input type="text" class="form-control" id="hpsiswa" name="hpsiswa">
                            </div>
                            
                            <div class="form-group">
                                <label for="idthnmasuk">Tahun Masuk <span class="text-danger">*</span></label>
                                <select class="form-control" id="idthnmasuk" name="idthnmasuk" required>
                                    <option value="">Pilih Tahun Masuk</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="photosiswa">Photo Siswa</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photosiswa" name="photosiswa" accept="image/*">
                                        <label class="custom-file-label" for="photosiswa">Pilih file...</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                <div id="photoPreview" class="mt-2" style="display: none;">
                                    <img id="previewImg" src="/placeholder.svg" alt="Preview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
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

<!-- Modal Edit Siswa -->
<div class="modal fade" id="editSiswaModal" tabindex="-1" role="dialog" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="editSiswaModalLabel">
                    <i class="fas fa-user-edit mr-2"></i>Edit Data Siswa
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSiswaForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_idsiswa" name="idsiswa">
                <div class="modal-body">
                    <!-- Form fields sama seperti modal tambah, tapi dengan prefix edit_ -->
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nis">NIS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nis" name="nis" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_nisn">NISN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nisn" name="nisn" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_namasiswa">Nama Siswa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_namasiswa" name="namasiswa" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tempatlahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_tempatlahir" name="tempatlahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tgllahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tgllahir" name="tgllahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_jenkel">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_jenkel" name="jenkel" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_alamat">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_idjurusan">Jurusan <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="edit_idjurusan" name="idjurusan" required>
                                    <option value="">Pilih Jurusan</option>
                                    <option value="1">Teknik Komputer dan Jaringan</option>
                                    <option value="2">Rekayasa Perangkat Lunak</option>
                                    <option value="3">Multimedia</option>
                                    <option value="4">Teknik Kendaraan Ringan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_idprogramkeahlian">Program Keahlian <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="edit_idprogramkeahlian" name="idprogramkeahlian" required>
                                    <option value="">Pilih Program Keahlian</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_idagama">Agama <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_idagama" name="idagama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="1">Islam</option>
                                    <option value="2">Kristen Protestan</option>
                                    <option value="3">Kristen Katolik</option>
                                    <option value="4">Hindu</option>
                                    <option value="5">Buddha</option>
                                    <option value="6">Konghucu</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tlprumah">Telepon Rumah</label>
                                <input type="text" class="form-control" id="edit_tlprumah" name="tlprumah">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_hpsiswa">HP Siswa</label>
                                <input type="text" class="form-control" id="edit_hpsiswa" name="hpsiswa">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_idthnmasuk">Tahun Masuk <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_idthnmasuk" name="idthnmasuk" required>
                                    <option value="">Pilih Tahun Masuk</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_photosiswa">Photo Siswa</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="edit_photosiswa" name="photosiswa" accept="image/*">
                                        <label class="custom-file-label" for="edit_photosiswa">Pilih file...</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah photo</small>
                                <div id="editPhotoPreview" class="mt-2">
                                    <img id="editPreviewImg" src="/placeholder.svg" alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                                </div>
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

<!-- Modal Detail Siswa -->
<div class="modal fade" id="detailSiswaModal" tabindex="-1" role="dialog" aria-labelledby="detailSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="detailSiswaModalLabel">
                    <i class="fas fa-user mr-2"></i>Detail Data Siswa
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="detailPhoto" src="/placeholder.svg" alt="Photo Siswa" class="img-fluid rounded" style="max-width: 200px;">
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>NIS</strong></td>
                                <td width="5%">:</td>
                                <td id="detailNis"></td>
                            </tr>
                            <tr>
                                <td><strong>NISN</strong></td>
                                <td>:</td>
                                <td id="detailNisn"></td>
                            </tr>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td>:</td>
                                <td id="detailNama"></td>
                            </tr>
                            <tr>
                                <td><strong>Tempat, Tgl Lahir</strong></td>
                                <td>:</td>
                                <td id="detailTtl"></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>:</td>
                                <td id="detailJenkel"></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>:</td>
                                <td id="detailAlamat"></td>
                            </tr>
                            <tr>
                                <td><strong>Jurusan</strong></td>
                                <td>:</td>
                                <td id="detailJurusan"></td>
                            </tr>
                            <tr>
                                <td><strong>Program Keahlian</strong></td>
                                <td>:</td>
                                <td id="detailProgram"></td>
                            </tr>
                            <tr>
                                <td><strong>Agama</strong></td>
                                <td>:</td>
                                <td id="detailAgama"></td>
                            </tr>
                            <tr>
                                <td><strong>Telepon Rumah</strong></td>
                                <td>:</td>
                                <td id="detailTlpRumah"></td>
                            </tr>
                            <tr>
                                <td><strong>HP Siswa</strong></td>
                                <td>:</td>
                                <td id="detailHpSiswa"></td>
                            </tr>
                            <tr>
                                <td><strong>Tahun Masuk</strong></td>
                                <td>:</td>
                                <td id="detailTahunMasuk"></td>
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
                    <i class="fas fa-upload mr-2"></i>Import Data Siswa
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
                            <li>Pastikan format tanggal: YYYY-MM-DD</li>
                            <li>Jenis kelamin: L atau P</li>
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
    // Initialize DataTable
    var table = $('#siswaTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "#",
            type: 'GET',
            data: function(d) {
                d.jurusan = $('#filterJurusan').val();
                d.tahun_masuk = $('#filterTahunMasuk').val();
                d.jenkel = $('#filterJenkel').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nis', name: 'nis' },
            { data: 'nisn', name: 'nisn' },
            { data: 'namasiswa', name: 'namasiswa' },
            { data: 'jenkel', name: 'jenkel' },
            { data: 'ttl', name: 'ttl', orderable: false },
            { data: 'jurusan', name: 'jurusan' },
            { data: 'idthnmasuk', name: 'idthnmasuk' },
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

    // Filter events
    $('#filterJurusan, #filterTahunMasuk, #filterJenkel').change(function() {
        table.ajax.reload();
    });

    // Custom file input labels
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Photo preview
    $('#photosiswa').change(function() {
        previewImage(this, '#previewImg', '#photoPreview');
    });

    $('#edit_photosiswa').change(function() {
        previewImage(this, '#editPreviewImg', '#editPhotoPreview');
    });

    // Dependent dropdown - Program Keahlian berdasarkan Jurusan
    $('#idjurusan').change(function() {
        loadProgramKeahlian($(this).val(), '#idprogramkeahlian');
    });

    $('#edit_idjurusan').change(function() {
        loadProgramKeahlian($(this).val(), '#edit_idprogramkeahlian');
    });

    // Form submissions
    $('#addSiswaForm').on('submit', function(e) {
        e.preventDefault();
        submitForm(this, "#", 'POST', '#addSiswaModal');
    });

    $('#editSiswaForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_idsiswa').val();
        submitForm(this, "#" + id, 'POST', '#editSiswaModal');
    });

    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        submitForm(this, "#", 'POST', '#importModal');
    });
});

// Functions
function previewImage(input, imgSelector, containerSelector) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(imgSelector).attr('src', e.target.result);
            $(containerSelector).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function loadProgramKeahlian(jurusanId, targetSelector) {
    if (jurusanId) {
        $.ajax({
            url: "",
            type: 'GET',
            data: { jurusan_id: jurusanId },
            success: function(data) {
                $(targetSelector).empty().append('<option value="">Pilih Program Keahlian</option>');
                $.each(data, function(key, value) {
                    $(targetSelector).append('<option value="' + value.id + '">' + value.nama + '</option>');
                });
            }
        });
    } else {
        $(targetSelector).empty().append('<option value="">Pilih Program Keahlian</option>');
    }
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
                $('#siswaTable').DataTable().ajax.reload();
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

function editSiswa(id) {
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            $('#edit_idsiswa').val(data.idsiswa);
            $('#edit_nis').val(data.nis);
            $('#edit_nisn').val(data.nisn);
            $('#edit_namasiswa').val(data.namasiswa);
            $('#edit_tempatlahir').val(data.tempatlahir);
            $('#edit_tgllahir').val(data.tgllahir);
            $('#edit_jenkel').val(data.jenkel);
            $('#edit_alamat').val(data.alamat);
            $('#edit_idjurusan').val(data.idjurusan).trigger('change');
            $('#edit_idagama').val(data.idagama);
            $('#edit_tlprumah').val(data.tlprumah);
            $('#edit_hpsiswa').val(data.hpsiswa);
            $('#edit_idthnmasuk').val(data.idthnmasuk);
            
            if (data.photosiswa) {
                $('#editPreviewImg').attr('src', data.photosiswa).show();
            }
            
            // Load program keahlian and set value
            setTimeout(function() {
                $('#edit_idprogramkeahlian').val(data.idprogramkeahlian);
            }, 500);
            
            $('#editSiswaModal').modal('show');
        }
    });
}

function deleteSiswa(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data siswa akan dihapus permanen!",
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
                        $('#siswaTable').DataTable().ajax.reload();
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

function viewSiswa(id) {
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            $('#detailNis').text(data.nis);
            $('#detailNisn').text(data.nisn);
            $('#detailNama').text(data.namasiswa);
            $('#detailTtl').text(data.tempatlahir + ', ' + data.tgllahir);
            $('#detailJenkel').text(data.jenkel == 'L' ? 'Laki-laki' : 'Perempuan');
            $('#detailAlamat').text(data.alamat || '-');
            $('#detailJurusan').text(data.jurusan_nama);
            $('#detailProgram').text(data.program_nama);
            $('#detailAgama').text(data.agama_nama);
            $('#detailTlpRumah').text(data.tlprumah || '-');
            $('#detailHpSiswa').text(data.hpsiswa || '-');
            $('#detailTahunMasuk').text(data.idthnmasuk);
            
            if (data.photosiswa) {
                $('#detailPhoto').attr('src', data.photosiswa);
            } else {
                $('#detailPhoto').attr('src', '/images/default-avatar.png');
            }
            
            $('#detailSiswaModal').modal('show');
        }
    });
}

function resetFilter() {
    $('#filterJurusan, #filterTahunMasuk, #filterJenkel').val('');
    $('#siswaTable').DataTable().ajax.reload();
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