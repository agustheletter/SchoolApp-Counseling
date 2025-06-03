<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CounselorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $counselors = DB::table('tbl_users as u')
                ->leftJoin('tbl_counselor as c', 'u.id', '=', 'c.idkonselor')
                ->where('u.role', 'guru')
                ->when($request->show_deleted === 'true', function($query) {
                    return $query->whereNotNull('u.deleted_at');
                }, function($query) {
                    return $query->whereNull('u.deleted_at');
                })
                ->select([
                    'u.id',
                    'u.nis as nip',
                    'u.nama as nama_konselor',
                    'u.gender as jenis_kelamin',
                    'u.email',
                    'u.nohp as no_hp',
                    'u.avatar as photo',
                    'u.deleted_at',
                    'c.pendidikan_terakhir',
                    'c.jurusan_pendidikan',
                    'c.spesialisasi',
                    'c.pengalaman_kerja',
                    'c.status'
                ]);

            return DataTables::of($counselors)
                ->addIndexColumn()
                ->addColumn('status_counselor', function($row) {
                    $status = $row->status ?? 'pending';
                    $badges = [
                        'aktif' => 'success',
                        'nonaktif' => 'danger',
                        'cuti' => 'warning',
                        'pending' => 'secondary'
                    ];
                    $badge = $badges[$status] ?? 'secondary';
                    return '<span class="badge badge-'.$badge.'">'.$status.'</span>';
                })
                ->addColumn('photo', function($row) {
                    if ($row->photo) {
                        return '<img src="'.asset('storage/avatars/'.$row->photo).'" class="img-thumbnail" width="50" alt="Photo">';
                    }
                    return '<img src="'.asset('images/'.($row->jenis_kelamin == 'L' ? 'default-male.png' : 'default-female.png')).'" class="img-thumbnail" width="50" alt="Photo">';
                })
                ->addColumn('action', function($row) use ($request) {
                    if ($request->show_deleted === 'true') {
                        return '<button onclick="restoreCounselor('.$row->id.')" class="btn btn-success btn-sm">
                            <i class="fas fa-undo"></i> Restore
                        </button>';
                    }
                    return '<div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm" onclick="viewCounselor('.$row->id.')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteCounselor('.$row->id.')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
                })
                ->rawColumns(['status_counselor', 'photo', 'action'])
                ->make(true);
        }

        return view('admin.counselor.v_counselor');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $counselorData = DB::table('tbl_users as u')
            ->leftJoin('tbl_counselor as c', 'u.id', '=', 'c.idkonselor')
            ->where('u.id', $id)
            ->where('u.role', 'guru')
            ->select([
                'u.*',
                'c.pendidikan_terakhir',
                'c.jurusan_pendidikan',
                'c.spesialisasi',
                'c.pengalaman_kerja',
                'c.sertifikasi',
                'c.status',
                'c.tanggal_bergabung'
            ])
            ->first();

        if (!$counselorData) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($counselorData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $user = User::where('id', $id)
                ->where('role', 'guru')
                ->firstOrFail();

            // Soft delete both records
            $user->delete(); // This will trigger soft delete on User
            
            Counselor::where('idkonselor', $id)->delete(); // This will trigger soft delete on Counselor

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konselor berhasil dinonaktifkan'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error soft deleting counselor: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan konselor'
            ], 500);
        }
    }

    public function restore($id)
    {
        try {
            DB::beginTransaction();

            // Restore both user and counselor records
            User::withTrashed()
                ->where('id', $id)
                ->where('role', 'guru')
                ->restore();

            Counselor::withTrashed()
                ->where('idkonselor', $id)
                ->restore();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Konselor berhasil diaktifkan kembali'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error restoring counselor: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan kembali konselor'
            ], 500);
        }
    }

    public function getUsers()
    {
        try {
            $users = User::where('role', 'user')
                ->whereNotIn('id', function($query) {
                    $query->select('idkonselor')
                        ->from('tbl_counselor')
                        ->whereNull('deleted_at');
                })
                ->whereNull('deleted_at')
                ->select('id', 'nis', 'nama', 'email')
                ->get();
            
            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'Tidak ada user yang tersedia untuk dijadikan konselor'
                ], 404);
            }

            return response()->json($users);

        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat memuat data user'
            ], 500);
        }
    }

    public function convertToCounselor(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            
            // Check if user already exists as counselor
            $existingCounselor = Counselor::where('idkonselor', $id)->exists();
            if ($existingCounselor) {
                throw new \Exception('User sudah terdaftar sebagai konselor');
            }

            // Update user role and clear NIS
            $user->update([
                'role' => 'guru',
                'nis' => null
            ]);

            // Create initial counselor record
            Counselor::create([
                'idkonselor' => $user->id,
                'pendidikan_terakhir' => '-',
                'jurusan_pendidikan' => '-',
                'spesialisasi' => null,
                'pengalaman_kerja' => 0,
                'sertifikasi' => null,
                'status' => 'pending',
                'tanggal_bergabung' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dijadikan konselor'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error converting user to counselor: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah user menjadi konselor'
            ], 500);
        }
    }
}
