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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addKonselorModal">
                    <i class="fas fa-plus"></i> Tambah Konselor
                </button>
            </div>
            <div class="card-body">
                <table id="konselorTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Konselor</th>
                            <th>Jenis Kelamin</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Spesialisasi</th>
                            <th>Status</th>
                            <th>Photo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
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

<!-- Modal Tambah Konselor -->
<div class="modal fade" id="addKonselorModal" tabindex="-1" role="dialog" aria-labelledby="addKonselorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addKonselorModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Data Konselor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addKonselorForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                                <small class="form-text text-muted">Nomor Induk Pegawai</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama_konselor">Nama Konselor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_konselor" name="nama_konselor" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="gelar_depan">Gelar Depan</label>
                                <input type="text" class="form-control" id="gelar_depan" name="gelar_depan" placeholder="Dr., Prof., dll">
                            </div>
                            
                            <div class="form-group">
                                <label for="gelar_belakang">Gelar Belakang</label>
                                <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang" placeholder="S.Pd., M.Pd., Ph.D., dll">
                            </div>
                            
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="no_hp">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="pendidikan_terakhir">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <select class="form-control" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="jurusan_pendidikan">Jurusan Pendidikan</label>
                                <input type="text" class="form-control" id="jurusan_pendidikan" name="jurusan_pendidikan" placeholder="Psikologi, Bimbingan Konseling, dll">
                            </div>
                            
                            <div class="form-group">
                                <label for="spesialisasi">Spesialisasi Konseling <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="spesialisasi" name="spesialisasi[]" multiple required>
                                    <option value="akademik">Konseling Akademik</option>
                                    <option value="karir">Konseling Karir</option>
                                    <option value="pribadi">Konseling Pribadi</option>
                                    <option value="sosial">Konseling Sosial</option>
                                </select>
                                <small class="form-text text-muted">Pilih satu atau lebih spesialisasi</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="pengalaman_kerja">Pengalaman Kerja (Tahun)</label>
                                <input type="number" class="form-control" id="pengalaman_kerja" name="pengalaman_kerja" min="0">
                            </div>
                            
                            <div class="form-group">
                                <label for="sertifikasi">Sertifikasi</label>
                                <textarea class="form-control" id="sertifikasi" name="sertifikasi" rows="2" placeholder="Sertifikat konselor, pelatihan, dll"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="tanggal_bergabung">Tanggal Bergabung</label>
                                <input type="date" class="form-control" id="tanggal_bergabung" name="tanggal_bergabung">
                            </div>
                            
                            <div class="form-group">
                                <label for="photo_konselor">Photo Konselor</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo_konselor" name="photo_konselor" accept="image/*">
                                        <label class="custom-file-label" for="photo_konselor">Pilih file...</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                <div id="photoPreview" class="mt-2" style="display: none;">
                                    <img id="previewImg" src="/placeholder.svg" alt="Preview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Jadwal Ketersediaan -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5><i class="fas fa-calendar-alt mr-2"></i>Jadwal Ketersediaan</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Hari</th>
                                            <th>Tersedia</th>
                                            <th>Jam Mulai</th>
                                            <th>Jam Selesai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Senin</td>
                                            <td><input type="checkbox" name="jadwal[senin][tersedia]" value="1"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[senin][jam_mulai]"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[senin][jam_selesai]"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="jadwal[senin][keterangan]"></td>
                                        </tr>
                                        <tr>
                                            <td>Selasa</td>
                                            <td><input type="checkbox" name="jadwal[selasa][tersedia]" value="1"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[selasa][jam_mulai]"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[selasa][jam_selesai]"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="jadwal[selasa][keterangan]"></td>
                                        </tr>
                                        <tr>
                                            <td>Rabu</td>
                                            <td><input type="checkbox" name="jadwal[rabu][tersedia]" value="1"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[rabu][jam_mulai]"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[rabu][jam_selesai]"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="jadwal[rabu][keterangan]"></td>
                                        </tr>
                                        <tr>
                                            <td>Kamis</td>
                                            <td><input type="checkbox" name="jadwal[kamis][tersedia]" value="1"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[kamis][jam_mulai]"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[kamis][jam_selesai]"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="jadwal[kamis][keterangan]"></td>
                                        </tr>
                                        <tr>
                                            <td>Jumat</td>
                                            <td><input type="checkbox" name="jadwal[jumat][tersedia]" value="1"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[jumat][jam_mulai]"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[jumat][jam_selesai]"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="jadwal[jumat][keterangan]"></td>
                                        </tr>
                                        <tr>
                                            <td>Sabtu</td>
                                            <td><input type="checkbox" name="jadwal[sabtu][tersedia]" value="1"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[sabtu][jam_mulai]"></td>
                                            <td><input type="time" class="form-control form-control-sm" name="jadwal[sabtu][jam_selesai]"></td>
                                            <td><input type="text" class="form-control form-control-sm" name="jadwal[sabtu][keterangan]"></td>
                                        </tr>
                                    </tbody>
                                </table>
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

<!-- Modal Edit Konselor -->
<div class="modal fade" id="editKonselorModal" tabindex="-1" role="dialog" aria-labelledby="editKonselorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="editKonselorModalLabel">
                    <i class="fas fa-user-edit mr-2"></i>Edit Data Konselor
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editKonselorForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id_konselor" name="id_konselor">
                <div class="modal-body">
                    <!-- Form fields sama seperti modal tambah, tapi dengan prefix edit_ -->
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nip">NIP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nip" name="nip" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_nama_konselor">Nama Konselor <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_konselor" name="nama_konselor" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_gelar_depan">Gelar Depan</label>
                                <input type="text" class="form-control" id="edit_gelar_depan" name="gelar_depan">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_gelar_belakang">Gelar Belakang</label>
                                <input type="text" class="form-control" id="edit_gelar_belakang" name="gelar_belakang">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_tempat_lahir" name="tempat_lahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_alamat">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_no_hp">No. HP <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_no_hp" name="no_hp" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_pendidikan_terakhir">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_pendidikan_terakhir" name="pendidikan_terakhir" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_jurusan_pendidikan">Jurusan Pendidikan</label>
                                <input type="text" class="form-control" id="edit_jurusan_pendidikan" name="jurusan_pendidikan">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_spesialisasi">Spesialisasi Konseling <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="edit_spesialisasi" name="spesialisasi[]" multiple required>
                                    <option value="akademik">Konseling Akademik</option>
                                    <option value="karir">Konseling Karir</option>
                                    <option value="pribadi">Konseling Pribadi</option>
                                    <option value="sosial">Konseling Sosial</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_pengalaman_kerja">Pengalaman Kerja (Tahun)</label>
                                <input type="number" class="form-control" id="edit_pengalaman_kerja" name="pengalaman_kerja" min="0">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_sertifikasi">Sertifikasi</label>
                                <textarea class="form-control" id="edit_sertifikasi" name="sertifikasi" rows="2"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_tanggal_bergabung">Tanggal Bergabung</label>
                                <input type="date" class="form-control" id="edit_tanggal_bergabung" name="tanggal_bergabung">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_photo_konselor">Photo Konselor</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="edit_photo_konselor" name="photo_konselor" accept="image/*">
                                        <label class="custom-file-label" for="edit_photo_konselor">Pilih file...</label>
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

<!-- Modal Detail Konselor -->
<div class="modal fade" id="detailKonselorModal" tabindex="-1" role="dialog" aria-labelledby="detailKonselorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="detailKonselorModalLabel">
                    <i class="fas fa-user-tie mr-2"></i>Detail Data Konselor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="detailPhoto" src="/placeholder.svg" alt="Photo Konselor" class="img-fluid rounded" style="max-width: 200px;">
                        <div class="mt-3">
                            <span id="detailStatus" class="badge badge-success">Aktif</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>NIP</strong></td>
                                <td width="5%">:</td>
                                <td id="detailNip"></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>:</td>
                                <td id="detailNamaLengkap"></td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>:</td>
                                <td id="detailJenisKelamin"></td>
                            </tr>
                            <tr>
                                <td><strong>Tempat, Tgl Lahir</strong></td>
                                <td>:</td>
                                <td id="detailTtl"></td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>:</td>
                                <td id="detailAlamat"></td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>:</td>
                                <td id="detailEmail"></td>
                            </tr>
                            <tr>
                                <td><strong>No. HP</strong></td>
                                <td>:</td>
                                <td id="detailNoHp"></td>
                            </tr>
                            <tr>
                                <td><strong>Pendidikan</strong></td>
                                <td>:</td>
                                <td id="detailPendidikan"></td>
                            </tr>
                            <tr>
                                <td><strong>Jurusan</strong></td>
                                <td>:</td>
                                <td id="detailJurusan"></td>
                            </tr>
                            <tr>
                                <td><strong>Spesialisasi</strong></td>
                                <td>:</td>
                                <td id="detailSpesialisasi"></td>
                            </tr>
                            <tr>
                                <td><strong>Pengalaman</strong></td>
                                <td>:</td>
                                <td id="detailPengalaman"></td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Bergabung</strong></td>
                                <td>:</td>
                                <td id="detailTanggalBergabung"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Jadwal Ketersediaan -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6><i class="fas fa-calendar-alt mr-2"></i>Jadwal Ketersediaan</h6>
                        <div id="detailJadwal" class="table-responsive">
                            <!-- Jadwal akan dimuat via JavaScript -->
                        </div>
                    </div>
                </div>
                
                <!-- Statistik Konseling -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Siswa</span>
                                <span class="info-box-number" id="detailTotalSiswa">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Sesi Selesai</span>
                                <span class="info-box-number" id="detailSesiSelesai">0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Rating</span>
                                <span class="info-box-number" id="detailRating">0.0</span>
                            </div>
                        </div>
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
                    <i class="fas fa-upload mr-2"></i>Import Data Konselor
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
                            <li>Status: aktif, nonaktif, atau cuti</li>
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#konselorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.counselor.index') }}",
            type: 'GET',
            error: function(xhr, error, thrown) {
                console.log('Ajax error:', error);
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nip', name: 'nip'},
            {data: 'nama_konselor', name: 'nama_konselor'},
            {data: 'jenis_kelamin', name: 'jenis_kelamin'},
            {data: 'email', name: 'email'},
            {data: 'no_hp', name: 'no_hp'},
            {data: 'spesialisasi', name: 'spesialisasi'},
            {data: 'status', name: 'status'},
            {data: 'photo', name: 'photo', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[1, 'asc']],
        language: {
            processing: "Loading...",
            zeroRecords: "No data available"
        }
    });
});
</script>
@endsection