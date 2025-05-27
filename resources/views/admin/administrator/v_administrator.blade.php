@extends('layouts.admin')

@section('title', 'Manajemen Administrator')
@section('page-title', 'Data Administrator')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Data Administrator</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users-cog mr-2"></i>
                    Daftar Administrator
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addAdminModal">
                        <i class="fas fa-plus"></i> Tambah Administrator
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
                        <select class="form-control" id="filterRole">
                            <option value="">Semua Role</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non Aktif</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-control" id="filterLastLogin">
                            <option value="">Semua</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="never">Belum Pernah Login</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-secondary btn-block" onclick="resetFilter()">
                            <i class="fas fa-undo"></i> Reset Filter
                        </button>
                    </div>
                </div>

                <table id="adminTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="8%">Photo</th>
                            <th width="12%">Username</th>
                            <th width="15%">Nama Lengkap</th>
                            <th width="15%">Email</th>
                            <th width="10%">Role</th>
                            <th width="8%">Status</th>
                            <th width="12%">Last Login</th>
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

<!-- Modal Tambah Administrator -->
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="addAdminModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Administrator Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addAdminForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <small class="form-text text-muted">Username untuk login (minimal 4 karakter)</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="password-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Minimal 8 karakter</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="no_hp">No. HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp">
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role <span class="text-danger">*</span></label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="operator">Operator</option>
                                </select>
                                <small class="form-text text-muted">
                                    <strong>Super Admin:</strong> Akses penuh<br>
                                    <strong>Admin:</strong> Akses terbatas<br>
                                    <strong>Operator:</strong> Akses data entry
                                </small>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" selected>Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="photo_profile">Photo Profile</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="photo_profile" name="photo_profile" accept="image/*">
                                        <label class="custom-file-label" for="photo_profile">Pilih file...</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                                <div id="photoPreview" class="mt-2" style="display: none;">
                                    <img id="previewImg" src="/placeholder.svg" alt="Preview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Catatan tambahan..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Permission Section -->
                    <div class="row mt-4" id="permissionSection">
                        <div class="col-12">
                            <h5><i class="fas fa-key mr-2"></i>Pengaturan Permission</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Manajemen User</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="user_create" id="user_create">
                                            <label class="form-check-label" for="user_create">Create</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="user_read" id="user_read">
                                            <label class="form-check-label" for="user_read">Read</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="user_update" id="user_update">
                                            <label class="form-check-label" for="user_update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="user_delete" id="user_delete">
                                            <label class="form-check-label" for="user_delete">Delete</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Manajemen Siswa</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="siswa_create" id="siswa_create">
                                            <label class="form-check-label" for="siswa_create">Create</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="siswa_read" id="siswa_read">
                                            <label class="form-check-label" for="siswa_read">Read</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="siswa_update" id="siswa_update">
                                            <label class="form-check-label" for="siswa_update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="siswa_delete" id="siswa_delete">
                                            <label class="form-check-label" for="siswa_delete">Delete</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Manajemen Konselor</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="konselor_create" id="konselor_create">
                                            <label class="form-check-label" for="konselor_create">Create</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="konselor_read" id="konselor_read">
                                            <label class="form-check-label" for="konselor_read">Read</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="konselor_update" id="konselor_update">
                                            <label class="form-check-label" for="konselor_update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="konselor_delete" id="konselor_delete">
                                            <label class="form-check-label" for="konselor_delete">Delete</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Laporan & Analitik</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="report_view" id="report_view">
                                            <label class="form-check-label" for="report_view">View Reports</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="report_export" id="report_export">
                                            <label class="form-check-label" for="report_export">Export Reports</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="analytics_view" id="analytics_view">
                                            <label class="form-check-label" for="analytics_view">View Analytics</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="system_settings" id="system_settings">
                                            <label class="form-check-label" for="system_settings">System Settings</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions()">
                                        <i class="fas fa-check-square"></i> Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary ml-2" onclick="clearAllPermissions()">
                                        <i class="fas fa-square"></i> Hapus Semua
                                    </button>
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

<!-- Modal Edit Administrator -->
<div class="modal fade" id="editAdminModal" tabindex="-1" role="dialog" aria-labelledby="editAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="editAdminModalLabel">
                    <i class="fas fa-user-edit mr-2"></i>Edit Administrator
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editAdminForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_username">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_username" name="username" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="edit_email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_password">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="edit_password" name="password">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('edit_password')">
                                            <i class="fas fa-eye" id="edit_password-icon"></i>
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_no_hp">No. HP</label>
                                <input type="text" class="form-control" id="edit_no_hp" name="no_hp">
                            </div>
                        </div>
                        
                        <!-- Kolom Kanan -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_role">Role <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_role" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    <option value="operator">Operator</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Non Aktif</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_alamat">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_photo_profile">Photo Profile</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="edit_photo_profile" name="photo_profile" accept="image/*">
                                        <label class="custom-file-label" for="edit_photo_profile">Pilih file...</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah photo</small>
                                <div id="editPhotoPreview" class="mt-2">
                                    <img id="editPreviewImg" src="/placeholder.svg" alt="Current Photo" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_keterangan">Keterangan</label>
                                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="2"></textarea>
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

<!-- Modal Detail Administrator -->
<div class="modal fade" id="detailAdminModal" tabindex="-1" role="dialog" aria-labelledby="detailAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="detailAdminModalLabel">
                    <i class="fas fa-user-tie mr-2"></i>Detail Administrator
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img id="detailPhoto" src="/placeholder.svg" alt="Photo Profile" class="img-fluid rounded" style="max-width: 200px;">
                        <div class="mt-3">
                            <span id="detailStatus" class="badge badge-success">Aktif</span>
                            <span id="detailRole" class="badge badge-primary ml-2">Admin</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Username</strong></td>
                                <td width="5%">:</td>
                                <td id="detailUsername"></td>
                            </tr>
                            <tr>
                                <td><strong>Nama Lengkap</strong></td>
                                <td>:</td>
                                <td id="detailNamaLengkap"></td>
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
                                <td><strong>Alamat</strong></td>
                                <td>:</td>
                                <td id="detailAlamat"></td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung</strong></td>
                                <td>:</td>
                                <td id="detailCreatedAt"></td>
                            </tr>
                            <tr>
                                <td><strong>Last Login</strong></td>
                                <td>:</td>
                                <td id="detailLastLogin"></td>
                            </tr>
                            <tr>
                                <td><strong>Keterangan</strong></td>
                                <td>:</td>
                                <td id="detailKeterangan"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <!-- Permission Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6><i class="fas fa-key mr-2"></i>Permission yang Dimiliki</h6>
                        <div id="detailPermissions" class="row">
                            <!-- Permissions akan dimuat via JavaScript -->
                        </div>
                    </div>
                </div>
                
                <!-- Activity Log -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6><i class="fas fa-history mr-2"></i>Aktivitas Terakhir</h6>
                        <div id="detailActivityLog" class="table-responsive">
                            <!-- Activity log akan dimuat via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button type="button" class="btn btn-warning" onclick="resetPassword()">
                    <i class="fas fa-key"></i> Reset Password
                </button>
                <button type="button" class="btn btn-primary" onclick="printDetail()">
                    <i class="fas fa-print"></i> Cetak
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-dark" id="resetPasswordModalLabel">
                    <i class="fas fa-key mr-2"></i>Reset Password
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="resetPasswordForm">
                @csrf
                <input type="hidden" id="reset_user_id" name="user_id">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian!</strong> Password akan direset dan dikirim ke email user.
                    </div>
                    
                    <div class="form-group">
                        <label for="reset_username">Username</label>
                        <input type="text" class="form-control" id="reset_username" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="reset_email">Email</label>
                        <input type="email" class="form-control" id="reset_email" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">Password Baru <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="generatePassword()">
                                    <i class="fas fa-random"></i> Generate
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="send_email" name="send_email" checked>
                        <label class="form-check-label" for="send_email">
                            Kirim password baru via email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="importModalLabel">
                    <i class="fas fa-upload mr-2"></i>Import Data Administrator
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
                            <li>Role: super_admin, admin, atau operator</li>
                            <li>Status: aktif, nonaktif, atau suspended</li>
                            <li>Password akan di-generate otomatis</li>
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
    var table = $('#adminTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "#",
            type: 'GET',
            data: function(d) {
                d.role = $('#filterRole').val();
                d.status = $('#filterStatus').val();
                d.last_login = $('#filterLastLogin').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'photo', name: 'photo', orderable: false, searchable: false },
            { data: 'username', name: 'username' },
            { data: 'nama_lengkap', name: 'nama_lengkap' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' },
            { data: 'status', name: 'status' },
            { data: 'last_login', name: 'last_login' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
        }
    });

    // Filter events
    $('#filterRole, #filterStatus, #filterLastLogin').change(function() {
        table.ajax.reload();
    });

    // Custom file input labels
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

    // Photo preview
    $('#photo_profile').change(function() {
        previewImage(this, '#previewImg', '#photoPreview');
    });

    $('#edit_photo_profile').change(function() {
        previewImage(this, '#editPreviewImg', '#editPhotoPreview');
    });

    // Role change event for permissions
    $('#role').change(function() {
        setDefaultPermissions($(this).val());
    });

    // Form submissions
    $('#addAdminForm').on('submit', function(e) {
        e.preventDefault();
        submitForm(this, "#", 'POST', '#addAdminModal');
    });

    $('#editAdminForm').on('submit', function(e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        submitForm(this, "#" + id, 'POST', '#editAdminModal');
    });

    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();
        submitForm(this, "#", 'POST', '#resetPasswordModal');
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

function togglePassword(fieldId) {
    var field = document.getElementById(fieldId);
    var icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function generatePassword() {
    var length = 12;
    var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    var password = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        password += charset.charAt(Math.floor(Math.random() * n));
    }
    $('#new_password').val(password);
}

function setDefaultPermissions(role) {
    // Clear all permissions first
    clearAllPermissions();
    
    if (role === 'super_admin') {
        selectAllPermissions();
    } else if (role === 'admin') {
        // Set default permissions for admin
        $('input[name="permissions[]"][value*="_read"]').prop('checked', true);
        $('input[name="permissions[]"][value*="_create"]').prop('checked', true);
        $('input[name="permissions[]"][value*="_update"]').prop('checked', true);
        $('input[name="permissions[]"][value="report_view"]').prop('checked', true);
    } else if (role === 'operator') {
        // Set default permissions for operator
        $('input[name="permissions[]"][value*="_read"]').prop('checked', true);
        $('input[name="permissions[]"][value*="_create"]').prop('checked', true);
    }
}

function selectAllPermissions() {
    $('input[name="permissions[]"]').prop('checked', true);
}

function clearAllPermissions() {
    $('input[name="permissions[]"]').prop('checked', false);
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
                clearAllPermissions();
                $('#adminTable').DataTable().ajax.reload();
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

function editAdmin(id) {
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            $('#edit_id').val(data.id);
            $('#edit_username').val(data.username);
            $('#edit_email').val(data.email);
            $('#edit_nama_lengkap').val(data.nama_lengkap);
            $('#edit_no_hp').val(data.no_hp);
            $('#edit_role').val(data.role);
            $('#edit_status').val(data.status);
            $('#edit_alamat').val(data.alamat);
            $('#edit_keterangan').val(data.keterangan);
            
            if (data.photo_profile) {
                $('#editPreviewImg').attr('src', data.photo_profile).show();
            }
            
            $('#editAdminModal').modal('show');
        }
    });
}

function deleteAdmin(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data administrator akan dihapus permanen!",
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
                        $('#adminTable').DataTable().ajax.reload();
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

function viewAdmin(id) {
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            // Basic info
            $('#detailUsername').text(data.username);
            $('#detailNamaLengkap').text(data.nama_lengkap);
            $('#detailEmail').text(data.email);
            $('#detailNoHp').text(data.no_hp || '-');
            $('#detailAlamat').text(data.alamat || '-');
            $('#detailCreatedAt').text(data.created_at);
            $('#detailLastLogin').text(data.last_login || 'Belum pernah login');
            $('#detailKeterangan').text(data.keterangan || '-');
            
            // Status and role badges
            var statusClass = data.status == 'aktif' ? 'badge-success' : (data.status == 'suspended' ? 'badge-warning' : 'badge-danger');
            $('#detailStatus').removeClass().addClass('badge ' + statusClass).text(data.status.charAt(0).toUpperCase() + data.status.slice(1));
            
            var roleClass = data.role == 'super_admin' ? 'badge-danger' : (data.role == 'admin' ? 'badge-primary' : 'badge-info');
            $('#detailRole').removeClass().addClass('badge ' + roleClass).text(data.role.replace('_', ' ').toUpperCase());
            
            // Photo
            if (data.photo_profile) {
                $('#detailPhoto').attr('src', data.photo_profile);
            } else {
                $('#detailPhoto').attr('src', '/images/default-avatar.png');
            }
            
            // Permissions
            if (data.permissions && data.permissions.length > 0) {
                var permissionsHtml = '';
                data.permissions.forEach(function(permission) {
                    permissionsHtml += '<div class="col-md-6"><span class="badge badge-success mr-1">' + permission + '</span></div>';
                });
                $('#detailPermissions').html(permissionsHtml);
            } else {
                $('#detailPermissions').html('<div class="col-12"><p class="text-muted">Tidak ada permission khusus</p></div>');
            }
            
            // Activity log (if available)
            if (data.activity_log) {
                var activityHtml = '<table class="table table-sm table-bordered">';
                activityHtml += '<thead><tr><th>Waktu</th><th>Aktivitas</th><th>IP Address</th></tr></thead><tbody>';
                
                data.activity_log.forEach(function(log) {
                    activityHtml += '<tr>';
                    activityHtml += '<td>' + log.created_at + '</td>';
                    activityHtml += '<td>' + log.description + '</td>';
                    activityHtml += '<td>' + log.ip_address + '</td>';
                    activityHtml += '</tr>';
                });
                
                activityHtml += '</tbody></table>';
                $('#detailActivityLog').html(activityHtml);
            } else {
                $('#detailActivityLog').html('<p class="text-muted">Tidak ada log aktivitas</p>');
            }
            
            $('#detailAdminModal').modal('show');
        }
    });
}

function resetPassword() {
    var id = $('#edit_id').val() || $('#reset_user_id').val();
    
    $.ajax({
        url: "#" + id,
        type: 'GET',
        success: function(data) {
            $('#reset_user_id').val(data.id);
            $('#reset_username').val(data.username);
            $('#reset_email').val(data.email);
            $('#detailAdminModal').modal('hide');
            $('#resetPasswordModal').modal('show');
        }
    });
}

function resetFilter() {
    $('#filterRole, #filterStatus, #filterLastLogin').val('');
    $('#adminTable').DataTable().ajax.reload();
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
