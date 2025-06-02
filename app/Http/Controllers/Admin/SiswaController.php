<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Add this import
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Add this import

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = User::query()
                    ->where('role', 'user');

                if ($request->show_deleted == 'true') {
                    $query->onlyTrashed();
                }

                $users = $query->select([
                    'id',
                    'nis',
                    'nama',
                    'email',
                    'gender',
                    'nohp',
                    'tgllahir',
                    'alamat',
                    'avatar'
                ]);

                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('ttl', function($row) {
                        return $row->tgllahir ? date('d-m-Y', strtotime($row->tgllahir)) : '-';
                    })
                    ->addColumn('avatar', function($row) {
                        $avatarUrl = $row->avatar ? asset('storage/avatars/'.$row->avatar) 
                            : asset('images/'.($row->gender == 'L' ? 'default-male.png' : 'default-female.png'));
                        return '<img src="'.$avatarUrl.'" class="img-thumbnail">';
                    })
                    ->addColumn('action', function($row) use ($request) {
                        if ($request->show_deleted == 'true') {
                            return '<button onclick="restoreUser('.$row->id.')" class="btn btn-success btn-sm">
                                <i class="fas fa-undo"></i> Restore
                            </button>';
                        }
                        return '<div class="btn-group">
                            <button onclick="viewUser('.$row->id.')" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="deleteUser('.$row->id.')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
                    })
                    ->rawColumns(['avatar', 'action'])
                    ->make(true);

            } catch (\Exception $e) {
                \Log::error('DataTables Error:', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);
                
                return response()->json([
                    'error' => true,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
        }
        
        return view('admin.student.v_student');
    }

    public function store(StoreSiswaRequest $request)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated(); // idprogramkeahlian tidak ada di sini

            if (!empty($validatedData['idjurusan'])) {
                $jurusan = Jurusan::find($validatedData['idjurusan']);
                // $jurusan->idprogramkeahlian adalah FK di tabel tbl_jurusan yang merujuk ke PK di tbl_programkeahlian
                $validatedData['idprogramkeahlian'] = $jurusan ? $jurusan->idprogramkeahlian : null;
            } else {
                $validatedData['idprogramkeahlian'] = null; // Jika tidak ada jurusan, program keahlian juga null
            }

            if ($request->hasFile('photosiswa')) {
                $path = $request->file('photosiswa')->store('siswa_photos', 'public');
                $validatedData['photosiswa'] = $path;
            }

            Siswa::create($validatedData);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data siswa berhasil ditambahkan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing siswa: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            $userMessage = 'Gagal menambahkan data siswa.';
            if (str_contains(strtolower($e->getMessage()), 'foreign key constraint fails')) {
                 $userMessage .= ' Pastikan data referensi (Jurusan, Agama) yang dipilih valid.';
            } else if (str_contains(strtolower($e->getMessage()), "doesn't have a default value")) {
                 $userMessage .= ' Ada field wajib yang tidak terisi atau tidak memiliki nilai default.';
            }
            return response()->json(['success' => false, 'message' => $userMessage ], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = DB::table('tbl_users')
                ->where('id', $id)
                ->where('role', 'user')
                ->select([
                    'id',
                    'nis',
                    'nama',
                    'email',
                    'gender',
                    'nohp',
                    'tgllahir',
                    'alamat',
                    'avatar'
                ])
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching user details'
            ], 500);
        }
    }
    
    public function edit(Siswa $student)
    {
        return $this->show($student);
    }

    public function update(UpdateSiswaRequest $request, Siswa $student)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validated();

            if (!empty($validatedData['idjurusan'])) {
                $jurusan = Jurusan::find($validatedData['idjurusan']);
                $validatedData['idprogramkeahlian'] = $jurusan ? $jurusan->idprogramkeahlian : null;
            } else {
                // Jika idjurusan tidak ada dalam request (misalnya tidak diubah),
                // maka idprogramkeahlian juga tidak perlu diubah dari nilai yang sudah ada di $student
                unset($validatedData['idprogramkeahlian']);
            }

            if ($request->hasFile('photosiswa')) {
                if ($student->photosiswa && Storage::disk('public')->exists($student->photosiswa)) {
                    Storage::disk('public')->delete($student->photosiswa);
                }
                $path = $request->file('photosiswa')->store('siswa_photos', 'public');
                $validatedData['photosiswa'] = $path;
            } else {
                unset($validatedData['photosiswa']);
            }

            $student->update($validatedData);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data siswa berhasil diperbarui.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating siswa: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
             $userMessage = 'Gagal memperbarui data siswa.';
            if (str_contains(strtolower($e->getMessage()), 'foreign key constraint fails')) {
                 $userMessage .= ' Pastikan data referensi (Jurusan, Agama) yang dipilih valid.';
            } else if (str_contains(strtolower($e->getMessage()), "doesn't have a default value")) {
                 $userMessage .= ' Ada field wajib yang tidak terisi atau tidak memiliki nilai default.';
            }
            return response()->json(['success' => false, 'message' => $userMessage ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::where('id', $id)
                ->where('role', 'user')
                ->firstOrFail();

            // Soft delete the user
            $user->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting user: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus user'
            ], 500);
        }
    }

    // Metode getProgramKeahlianInduk atau getProgramKeahlian TIDAK DIPERLUKAN LAGI
    // karena dropdown program keahlian di form sudah dihapus.

    public function exportExcel()
    {
        return response()->json(['message' => 'Fungsi export Excel belum diimplementasikan.']);
    }

    public function importExcel(Request $request)
    {
        $request->validate(['import_file' => 'required|mimes:xls,xlsx']);
        // TODO: Implementasi import
        // Saat import, Anda juga perlu logika untuk mengisi Siswa.idprogramkeahlian berdasarkan Jurusan.idprogramkeahlian
        return response()->json(['success' => true, 'message' => 'Fungsi import Excel belum diimplementasikan.']);
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_import_siswa.xlsx');
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
        Log::warning('File template import siswa tidak ditemukan di: ' . $filePath);
        return response()->json(['message' => 'Template tidak ditemukan.'], 404);
    }

    public function checkTable()
    {
        try {
            $tables = DB::select('SHOW TABLES');
            $columns = [];
            
            if (Schema::hasTable('tbl_users')) {  // Changed from 'users' to 'tbl_users'
                $columns = Schema::getColumnListing('tbl_users');
            }
            
            return response()->json([
                'tables' => $tables,
                'users_exists' => Schema::hasTable('tbl_users'),
                'columns' => $columns
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            $user = User::onlyTrashed()
                ->where('id', $id)
                ->where('role', 'user')
                ->firstOrFail();

            $user->restore();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diaktifkan kembali'
            ]);

        } catch (\Exception $e) {
            Log::error('Error restoring user: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan kembali user'
            ], 500);
        }
    }
}