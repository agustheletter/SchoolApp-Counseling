@extends('layouts.admin')

@section('title', 'Manajemen Data Siswa')
@section('page-title', 'Data Siswa')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('/admin') }}">Admin</a></li>
<li class="breadcrumb-item active">Data Siswa</li>
@endsection

@push('css')
    {{-- CSS untuk Select2 dan styling kustom --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
    <style>
        #siswaTable img.img-thumbnail { max-width: 60px; max-height: 60px; object-fit: cover; }
        #detailPhoto { max-width: 200px; max-height: 250px; object-fit: cover; }
        .select2-container--bootstrap4 .select2-selection--single { height: calc(2.25rem + 2px) !important; }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered { line-height: 1.5 !important; padding-left: .75rem !important; }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow { height: calc(2.25rem + 2px) !important; }
        .is-invalid-select2 .select2-selection { border-color: #dc3545 !important; } /* Untuk error Select2 */
    </style>
@endpush

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
                            @if(isset($jurusans) && $jurusans->count() > 0)
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->idjurusan }}">{{ $jurusan->namajurusan }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterTahunMasuk">
                            <option value="">Semua Tahun Masuk</option>
                             @if(isset($tahunMasukOptions) && count($tahunMasukOptions) > 0)
                                @foreach($tahunMasukOptions as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            @endif
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
                            <th width="12%">Jurusan (Konsentrasi)</th>
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
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addSiswaModalLabel"><i class="fas fa-user-plus mr-2"></i>Tambah Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form id="addSiswaForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.student.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> <label for="nis">NIS <span class="text-danger">*</span></label> <input type="text" class="form-control" id="nis" name="nis" required> <small class="form-text text-muted">Nomor Induk Siswa</small> </div>
                            <div class="form-group"> <label for="nisn">NISN <span class="text-danger">*</span></label> <input type="text" class="form-control" id="nisn" name="nisn" required> <small class="form-text text-muted">Nomor Induk Siswa Nasional</small> </div>
                            <div class="form-group"> <label for="namasiswa">Nama Siswa <span class="text-danger">*</span></label> <input type="text" class="form-control" id="namasiswa" name="namasiswa" required> </div>
                            <div class="form-group"> <label for="tempatlahir">Tempat Lahir <span class="text-danger">*</span></label> <input type="text" class="form-control" id="tempatlahir" name="tempatlahir" required> </div>
                            <div class="form-group"> <label for="tgllahir">Tanggal Lahir <span class="text-danger">*</span></label> <input type="date" class="form-control" id="tgllahir" name="tgllahir" required> </div>
                            <div class="form-group"> <label for="jenkel">Jenis Kelamin <span class="text-danger">*</span></label> <select class="form-control" id="jenkel" name="jenkel" required> <option value="">Pilih Jenis Kelamin</option> <option value="L">Laki-laki</option> <option value="P">Perempuan</option> </select> </div>
                            <div class="form-group"> <label for="alamat">Alamat</label> <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea> </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="idjurusan">Jurusan (Konsentrasi Keahlian) <span class="text-danger">*</span></label>
                                <select class="form-control select2-add" id="idjurusan" name="idjurusan" style="width: 100%;" required>
                                    <option value="">Pilih Jurusan</option>
                                    @if(isset($jurusans) && $jurusans->count() > 0)
                                        @foreach($jurusans as $jurusan)
                                            <option value="{{ $jurusan->idjurusan }}">{{ $jurusan->namajurusan }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            {{-- INPUT DROPDOWN UNTUK PROGRAM KEAHLIAN (INDUK) SUDAH DIHAPUS --}}
                            <div class="form-group"> <label for="idagama">Agama <span class="text-danger">*</span></label> <select class="form-control" id="idagama" name="idagama" required> <option value="">Pilih Agama</option> @if(isset($agamas) && $agamas->count() > 0) @foreach($agamas as $agama) <option value="{{ $agama->idagama }}">{{ $agama->agama }}</option> @endforeach @endif </select> </div>
                            <div class="form-group"> <label for="tlprumah">Telepon Rumah</label> <input type="text" class="form-control" id="tlprumah" name="tlprumah"> </div>
                            <div class="form-group"> <label for="hpsiswa">HP Siswa</label> <input type="text" class="form-control" id="hpsiswa" name="hpsiswa"> </div>
                            <div class="form-group"> <label for="idthnmasuk">Tahun Masuk <span class="text-danger">*</span></label> <select class="form-control" id="idthnmasuk" name="idthnmasuk" required> <option value="">Pilih Tahun Masuk</option> @if(isset($tahunMasukOptions) && count($tahunMasukOptions) > 0) @foreach($tahunMasukOptions as $tahun) <option value="{{ $tahun }}">{{ $tahun }}</option> @endforeach @endif </select> </div>
                            <div class="form-group"> <label for="photosiswa">Photo Siswa</label> <div class="input-group"> <div class="custom-file"> <input type="file" class="custom-file-input" id="photosiswa" name="photosiswa" accept="image/*"> <label class="custom-file-label" for="photosiswa">Pilih file...</label> </div> </div> <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small> <div id="photoPreview" class="mt-2 text-center" style="display: none;"> <img id="previewImg" src="{{ asset('images/default-avatar.png') }}" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 200px; object-fit: cover;"> </div> </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button> <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button> </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Siswa -->
<div class="modal fade" id="editSiswaModal" tabindex="-1" role="dialog" aria-labelledby="editSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editSiswaModalLabel"><i class="fas fa-user-edit mr-2"></i>Edit Data Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form id="editSiswaForm" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_idsiswa" name="idsiswa">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group"> <label for="edit_nis">NIS <span class="text-danger">*</span></label> <input type="text" class="form-control" id="edit_nis" name="nis" required> </div>
                            <div class="form-group"> <label for="edit_nisn">NISN <span class="text-danger">*</span></label> <input type="text" class="form-control" id="edit_nisn" name="nisn" required> </div>
                            <div class="form-group"> <label for="edit_namasiswa">Nama Siswa <span class="text-danger">*</span></label> <input type="text" class="form-control" id="edit_namasiswa" name="namasiswa" required> </div>
                            <div class="form-group"> <label for="edit_tempatlahir">Tempat Lahir <span class="text-danger">*</span></label> <input type="text" class="form-control" id="edit_tempatlahir" name="tempatlahir" required> </div>
                            <div class="form-group"> <label for="edit_tgllahir">Tanggal Lahir <span class="text-danger">*</span></label> <input type="date" class="form-control" id="edit_tgllahir" name="tgllahir" required> </div>
                            <div class="form-group"> <label for="edit_jenkel">Jenis Kelamin <span class="text-danger">*</span></label> <select class="form-control" id="edit_jenkel" name="jenkel" required> <option value="">Pilih Jenis Kelamin</option> <option value="L">Laki-laki</option> <option value="P">Perempuan</option> </select> </div>
                            <div class="form-group"> <label for="edit_alamat">Alamat</label> <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea> </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_idjurusan">Jurusan (Konsentrasi Keahlian) <span class="text-danger">*</span></label>
                                <select class="form-control select2-edit" id="edit_idjurusan" name="idjurusan" style="width: 100%;" required>
                                    <option value="">Pilih Jurusan</option>
                                     @if(isset($jurusans) && $jurusans->count() > 0)
                                        @foreach($jurusans as $jurusan)
                                            <option value="{{ $jurusan->idjurusan }}">{{ $jurusan->namajurusan }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            {{-- INPUT DROPDOWN UNTUK PROGRAM KEAHLIAN (INDUK) SUDAH DIHAPUS --}}
                            <div class="form-group"> <label for="edit_idagama">Agama <span class="text-danger">*</span></label> <select class="form-control" id="edit_idagama" name="idagama" required> <option value="">Pilih Agama</option> @if(isset($agamas) && $agamas->count() > 0) @foreach($agamas as $agama) <option value="{{ $agama->idagama }}">{{ $agama->agama }}</option> @endforeach @endif </select> </div>
                            <div class="form-group"> <label for="edit_tlprumah">Telepon Rumah</label> <input type="text" class="form-control" id="edit_tlprumah" name="tlprumah"> </div>
                            <div class="form-group"> <label for="edit_hpsiswa">HP Siswa</label> <input type="text" class="form-control" id="edit_hpsiswa" name="hpsiswa"> </div>
                            <div class="form-group"> <label for="edit_idthnmasuk">Tahun Masuk <span class="text-danger">*</span></label> <select class="form-control" id="edit_idthnmasuk" name="idthnmasuk" required> <option value="">Pilih Tahun Masuk</option> @if(isset($tahunMasukOptions) && count($tahunMasukOptions) > 0) @foreach($tahunMasukOptions as $tahun) <option value="{{ $tahun }}">{{ $tahun }}</option> @endforeach @endif </select> </div>
                            <div class="form-group"> <label for="edit_photosiswa">Photo Siswa</label> <div class="input-group"> <div class="custom-file"> <input type="file" class="custom-file-input" id="edit_photosiswa" name="photosiswa" accept="image/*"> <label class="custom-file-label" for="edit_photosiswa">Pilih file...</label> </div> </div> <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah photo</small> <div id="editPhotoPreviewContainer" class="mt-2 text-center"> <img id="editPreviewImg" src="{{ asset('images/default-avatar.png') }}" alt="Current Photo" class="img-thumbnail" style="max-width: 150px; max-height: 200px; object-fit: cover;"> </div> </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button> <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update</button> </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Detail Siswa -->
<div class="modal fade" id="detailSiswaModal" tabindex="-1" role="dialog" aria-labelledby="detailSiswaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailSiswaModalLabel"><i class="fas fa-user mr-2"></i>Detail Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center"> <img id="detailPhoto" src="{{ asset('images/default-avatar.png') }}" alt="Photo Siswa" class="img-fluid rounded"> </div>
                    <div class="col-md-8">
                        <table class="table table-sm table-borderless table-hover">
                            <tr> <td width="30%"><strong>NIS</strong></td> <td width="5%">:</td> <td id="detailNis"></td> </tr>
                            <tr> <td><strong>NISN</strong></td> <td>:</td> <td id="detailNisn"></td> </tr>
                            <tr> <td><strong>Nama</strong></td> <td>:</td> <td id="detailNama"></td> </tr>
                            <tr> <td><strong>Tempat, Tgl Lahir</strong></td> <td>:</td> <td id="detailTtl"></td> </tr>
                            <tr> <td><strong>Jenis Kelamin</strong></td> <td>:</td> <td id="detailJenkel"></td> </tr>
                            <tr> <td><strong>Alamat</strong></td> <td>:</td> <td id="detailAlamat"></td> </tr>
                            <tr> <td><strong>Jurusan (Konsentrasi)</strong></td> <td>:</td> <td id="detailJurusan"></td> </tr>
                            <tr> <td><strong>Program Keahlian (Induk)</strong></td> <td>:</td> <td id="detailProgram"></td> </tr>
                            <tr> <td><strong>Agama</strong></td> <td>:</td> <td id="detailAgama"></td> </tr>
                            <tr> <td><strong>Telepon Rumah</strong></td> <td>:</td> <td id="detailTlpRumah"></td> </tr>
                            <tr> <td><strong>HP Siswa</strong></td> <td>:</td> <td id="detailHpSiswa"></td> </tr>
                            <tr> <td><strong>Tahun Masuk</strong></td> <td>:</td> <td id="detailTahunMasuk"></td> </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Tutup</button> </div>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="importModalLabel"><i class="fas fa-upload mr-2"></i>Import Data Siswa</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form id="importForm" enctype="multipart/form-data" method="POST" action="{{ route('admin.students.import') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group"> <label for="import_file">File Excel <span class="text-danger">*</span></label> <div class="input-group"> <div class="custom-file"> <input type="file" class="custom-file-input" id="import_file" name="import_file" accept=".xlsx,.xls" required> <label class="custom-file-label" for="import_file">Pilih file...</label> </div> </div> <small class="form-text text-muted">Format file: .xlsx atau .xls</small> </div>
                    <div class="alert alert-info"> <h6><i class="fas fa-info-circle"></i> Petunjuk Import:</h6> <ol class="mb-0"> <li>Download template Excel terlebih dahulu</li> <li>Isi data sesuai format yang tersedia di template</li> <li>Pastikan format tanggal lahir: <strong>YYYY-MM-DD</strong></li> <li>Jenis kelamin: <strong>L</strong> atau <strong>P</strong></li> <li>ID Jurusan, ID Agama: Gunakan <strong>ID angka</strong> dari database.</li> <li>Kolom ID Program Keahlian di template dapat dikosongkan (akan diisi otomatis berdasarkan Jurusan).</li> <li>Tahun Masuk: <strong>YYYY</strong></li> <li>Upload file yang sudah diisi</li> </ol> </div>
                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm" onclick="downloadTemplate()"> <i class="fas fa-download"></i> Download Template Excel </a>
                </div>
                <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Batal</button> <button type="submit" class="btn btn-info"><i class="fas fa-upload"></i> Import</button> </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// CSRF Token setup
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$(document).ready(function() {
    // Initialize Select2
    $('.select2-add, .select2-edit').each(function () {
        $(this).select2({
            theme: 'bootstrap4',
            dropdownParent: $(this).closest('.modal'),
            placeholder: $(this).find('option[value=""]').text() || "Pilih Opsi" // Ambil placeholder dari opsi pertama jika ada
        });
    });

    // DataTable Initialization
    var table = $('#siswaTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.student.index') }}", // Using student (singular) instead of students
            type: 'GET',
            error: function(xhr, error, thrown) {
                console.error('DataTables error:', error, thrown);
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'nis', name: 'nis'},
            {data: 'nisn', name: 'nisn'},
            {data: 'namasiswa', name: 'namasiswa'},
            {data: 'jenkel', name: 'jenkel'},
            {data: 'ttl', name: 'ttl'},
            {data: 'jurusan', name: 'jurusan'},
            {data: 'idthnmasuk', name: 'idthnmasuk'},
            {
                data: 'photo', 
                name: 'photo',
                orderable: false, 
                searchable: false,
                render: function(data) {
                    return data;
                }
            },
            {
                data: 'action', 
                name: 'action', 
                orderable: false, 
                searchable: false,
                render: function(data) {
                    return data;
                }
            }
        ],
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json'
        }
    });

    // Reload table when filters change
    $('#filterJurusan, #filterTahunMasuk, #filterJenkel').change(function() {
        table.ajax.reload();
    });

    // Custom file input labels and preview
    $('.custom-file-input').on('change', function(event) {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
        var inputId = $(this).attr('id');
        if (inputId === 'photosiswa') { previewImage(this, '#previewImg', '#photoPreview'); }
        else if (inputId === 'edit_photosiswa') { previewImage(this, '#editPreviewImg', '#editPhotoPreviewContainer'); }
    });

    // Form submissions (Pastikan e.preventDefault() ada di awal setiap handler)
    $('#addSiswaForm').on('submit', function(e) {
        e.preventDefault();
        console.log('Add Siswa Form Submitted via JS');
        submitForm(this, "{{ route('admin.students.store') }}", 'POST', '#addSiswaModal', table);
    });
    $('#editSiswaForm').on('submit', function(e) {
        e.preventDefault();
        console.log('Edit Siswa Form Submitted via JS');
        var id = $('#edit_idsiswa').val();
        submitForm(this, "{{ url('admin/students') }}/" + id, 'POST', '#editSiswaModal', table);
    });
    $('#importForm').on('submit', function(e) {
        e.preventDefault();
        console.log('Import Form Submitted via JS');
        submitForm(this, "{{ route('admin.students.import') }}", 'POST', '#importModal', table);
    });

    // Reset Modals
    $('#addSiswaModal').on('hidden.bs.modal', function () {
        $('#addSiswaForm')[0].reset();
        $('#idjurusan').val(null).trigger('change.select2'); // Reset Jurusan
        $('#idagama').val(null).trigger('change'); // Reset agama jika bukan select2
        // Jika agama adalah select2: $('#idagama').val(null).trigger('change.select2');
        $('#photosiswa').next('.custom-file-label').html('Pilih file...');
        $('#previewImg').attr('src', '{{ asset('images/default-avatar.png') }}');
        $('#photoPreview').hide();
        $('#addSiswaForm .is-invalid').removeClass('is-invalid');
        $('#addSiswaForm .invalid-feedback').remove();
        $('#addSiswaForm .select2-container .select2-selection').removeClass('is-invalid-select2');
    });

    $('#editSiswaModal').on('hidden.bs.modal', function () {
        $('#editSiswaForm')[0].reset();
        $('#edit_idjurusan').val(null).trigger('change.select2');
        $('#edit_idagama').val(null).trigger('change');
        // Jika agama adalah select2: $('#edit_idagama').val(null).trigger('change.select2');
        $('#edit_photosiswa').next('.custom-file-label').html('Pilih file...');
        $('#editPreviewImg').attr('src', '{{ asset('images/default-avatar.png') }}');
        $('#editSiswaForm .is-invalid').removeClass('is-invalid');
        $('#editSiswaForm .invalid-feedback').remove();
        $('#editSiswaForm .select2-container .select2-selection').removeClass('is-invalid-select2');
    });

}); // End document ready

// --- Fungsi-fungsi Helper ---
function previewImage(input, imgSelector, containerSelector) {
    const defaultImage = '{{ asset('images/default-avatar.png') }}';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { $(imgSelector).attr('src', e.target.result); }
        reader.readAsDataURL(input.files[0]);
        $(containerSelector).show();
    } else {
        if(containerSelector === '#photoPreview') $(containerSelector).hide();
        $(imgSelector).attr('src', defaultImage);
    }
}

function submitForm(form, url, method, modalSelector, dataTableInstance) {
    var formData = new FormData(form);
    var originalButtonText = $(form).find('button[type="submit"]').html();

    // Log data form untuk debugging
    console.log("Data yang akan dikirim ke URL:", url);
    for (var pair of formData.entries()) {
        console.log(pair[0]+ ': ' + pair[1]);
    }

    $(form).find('.is-invalid').removeClass('is-invalid');
    $(form).find('.invalid-feedback').remove();
    $(form).find('.select2-container .select2-selection').removeClass('is-invalid-select2');

    $.ajax({
        url: url, type: 'POST', data: formData, processData: false, contentType: false,
        beforeSend: function() { $(form).find('button[type="submit"]').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...'); },
        success: function(response) {
            console.log('AJAX Success Response dari URL ' + url + ':', response);
            if (response.success) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.message, timer: 2000, showConfirmButton: false });
                $(modalSelector).modal('hide');
                if (dataTableInstance) { dataTableInstance.ajax.reload(null, false); }
            } else {
                 Swal.fire({ icon: 'error', title: 'Gagal!', text: response.message || 'Terjadi kesalahan.' });
            }
        },
        error: function(xhr) {
            console.error('AJAX Error Response dari URL ' + url + ':', xhr.status, xhr.responseText);
            var response = xhr.responseJSON;
            var errorMessage = response && response.message ? response.message : 'Terjadi kesalahan saat memproses permintaan Anda.';
            if (xhr.status === 422 && response && response.errors) { // Error validasi
                var errorMessagesHtml = '<ul class="list-unstyled text-left mb-0">';
                $.each(response.errors, function(key, value) {
                    errorMessagesHtml += '<li>' + value[0] + '</li>';
                    // Penamaan ID di form tambah: 'nis', 'nisn', 'idjurusan', dll.
                    // Penamaan ID di form edit: 'edit_nis', 'edit_nisn', 'edit_idjurusan', dll.
                    var fieldId = key;
                    if ($(form).attr('id') === 'editSiswaForm' && !key.startsWith('edit_')) {
                        // Jika form edit dan key tidak punya prefix 'edit_', coba tambahkan.
                        // Ini asumsi, mungkin perlu disesuaikan jika name di form edit tidak pakai prefix 'edit_'
                        // fieldId = 'edit_' + key;
                    }
                     // Jika key adalah 'idjurusan' di form edit, ID elemennya adalah 'edit_idjurusan'
                    if ($(form).attr('id') === 'editSiswaForm' && key === 'idjurusan') {
                        fieldId = 'edit_idjurusan';
                    }


                    var $field = $('#' + fieldId);
                    if ($field.length === 0 && $(form).attr('id') === 'editSiswaForm') { // Coba lagi dengan prefix jika di form edit
                         $field = $('#edit_' + fieldId);
                    }


                    $field.addClass('is-invalid');
                    var $fieldGroup = $field.closest('.form-group');

                    if ($field.data('select2')) {
                        $field.next('.select2-container').find('.select2-selection').addClass('is-invalid-select2');
                    }
                    // Hapus pesan error lama sebelum menambahkan yang baru
                    $fieldGroup.find('.invalid-feedback.d-block').remove();
                    $fieldGroup.append('<div class="invalid-feedback d-block">' + value[0] + '</div>');
                });
                errorMessagesHtml += '</ul>';
                Swal.fire({ icon: 'error', title: 'Error Validasi Formulir!', html: errorMessagesHtml, customClass: { htmlContainer: 'text-left' } });
            } else {
                 Swal.fire({ icon: 'error', title: 'Error ' + xhr.status + '!', text: errorMessage });
            }
        },
        complete: function() { $(form).find('button[type="submit"]').prop('disabled', false).html(originalButtonText); }
    });
}

function editSiswa(id) {
    $('#editSiswaForm')[0].reset();
    $('#edit_idjurusan').val(null).trigger('change.select2');
    $('#edit_idagama').val(null).trigger('change');
    $('#edit_photosiswa').next('.custom-file-label').html('Pilih file...');
    $('#editPreviewImg').attr('src', '{{ asset('images/default-avatar.png') }}');
    $('#editSiswaForm .is-invalid').removeClass('is-invalid');
    $('#editSiswaForm .invalid-feedback').remove();
    $('#editSiswaForm .select2-container .select2-selection').removeClass('is-invalid-select2');

    $.ajax({
        url: "{{ url('admin/students') }}/" + id + "/edit", type: 'GET',
        success: function(data) {
            $('#edit_idsiswa').val(data.idsiswa);
            $('#edit_nis').val(data.nis);
            $('#edit_nisn').val(data.nisn);
            $('#edit_namasiswa').val(data.namasiswa);
            $('#edit_tempatlahir').val(data.tempatlahir);
            $('#edit_tgllahir').val(data.tgllahir);
            $('#edit_jenkel').val(data.jenkel);
            $('#edit_alamat').val(data.alamat);
            $('#edit_idagama').val(data.idagama).trigger('change'); // Trigger change jika agama adalah select biasa
            // Jika agama adalah select2: $('#edit_idagama').val(data.idagama).trigger('change.select2');
            $('#edit_tlprumah').val(data.tlprumah);
            $('#edit_hpsiswa').val(data.hpsiswa);
            $('#edit_idthnmasuk').val(data.idthnmasuk).trigger('change'); // Trigger change jika tahun masuk adalah select biasa
            // Jika tahun masuk adalah select2: $('#edit_idthnmasuk').val(data.idthnmasuk).trigger('change.select2');

            if (data.idjurusan) {
                $('#edit_idjurusan').val(data.idjurusan).trigger('change.select2');
            }

            if (data.photosiswa_url && data.photosiswa_url !== '{{ asset('images/default-avatar.png') }}') {
                $('#editPreviewImg').attr('src', data.photosiswa_url);
            } else {
                $('#editPreviewImg').attr('src', '{{ asset('images/default-avatar.png') }}');
            }
            $('#editPhotoPreviewContainer').show(); // Pastikan preview container terlihat
            $('#edit_photosiswa').next('.custom-file-label').html(data.photosiswa ? data.photosiswa.split('/').pop() : 'Pilih file (jika ingin ganti)');
            $('#editSiswaModal').modal('show');
        },
        error: function(xhr) { Swal.fire({ icon: 'error', title: 'Gagal Memuat Data Edit', text: xhr.responseJSON?.message || 'Tidak dapat mengambil data siswa.' }); }
    });
}

function deleteSiswa(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?', text: "Data siswa ini akan dihapus permanen!", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('admin/students') }}/" + id, type: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'Berhasil Dihapus!', text: response.message, timer: 2000, showConfirmButton: false });
                        $('#siswaTable').DataTable().ajax.reload(null, false);
                    } else { Swal.fire({ icon: 'error', title: 'Gagal Menghapus!', text: response.message }); }
                },
                error: function(xhr) { Swal.fire({ icon: 'error', title: 'Error!', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' }); }
            });
        }
    });
}

function viewSiswa(id) {
    $.ajax({
        url: "{{ url('admin/students') }}/" + id, type: 'GET',
        success: function(data) {
            $('#detailNis').text(data.nis || '-'); $('#detailNisn').text(data.nisn || '-');
            $('#detailNama').text(data.namasiswa || '-');
            let tglLahirFormatted = '-';
            if(data.tgllahir) {
                if (!isNaN(new Date(data.tgllahir))) { tglLahirFormatted = new Date(data.tgllahir).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }); }
                else { tglLahirFormatted = data.tgllahir; }
            }
            $('#detailTtl').text((data.tempatlahir || '-') + ', ' + tglLahirFormatted);
            $('#detailJenkel').text(data.jenkel == 'L' ? 'Laki-laki' : (data.jenkel == 'P' ? 'Perempuan' : '-'));
            $('#detailAlamat').html(data.alamat ? data.alamat.replace(/\n/g, '<br>') : '-');
            $('#detailJurusan').text(data.jurusan_nama || '-'); // Ini adalah Konsentrasi Keahlian
            $('#detailProgram').text(data.program_nama || '-'); // Ini adalah Program Keahlian Induk
            $('#detailAgama').text(data.agama_nama || '-');
            $('#detailTlpRumah').text(data.tlprumah || '-'); $('#detailHpSiswa').text(data.hpsiswa || '-');
            $('#detailTahunMasuk').text(data.idthnmasuk || '-');
            $('#detailPhoto').attr('src', data.photosiswa_url || '{{ asset('images/default-avatar.png') }}');
            $('#detailSiswaModal').modal('show');
        },
        error: function(xhr) { Swal.fire({ icon: 'error', title: 'Gagal Memuat Detail', text: xhr.responseJSON?.message || 'Tidak dapat mengambil detail siswa.' }); }
    });
}

function resetFilter() {
    $('#filterJurusan').val(''); $('#filterTahunMasuk').val(''); $('#filterJenkel').val('');
    $('#filterJurusan, #filterTahunMasuk, #filterJenkel').trigger('change.select2'); // Jika filter menggunakan select2
    $('#siswaTable').DataTable().ajax.reload();
}

function exportData() { Swal.fire('Info', 'Fungsi export Excel belum diimplementasikan.', 'info'); }
function downloadTemplate() { window.location.href = "{{ route('admin.students.downloadTemplate') }}"; }

</script>
@endpush