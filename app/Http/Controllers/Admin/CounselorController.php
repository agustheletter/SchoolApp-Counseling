<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CounselorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    if ($request->ajax()) {
        \Log::info('Ajax request received');
        
        $counselors = Counselor::select([
            'id', 'nip', 'nama_konselor', 'jenis_kelamin', 
            'email', 'no_hp', 'spesialisasi', 'status', 'photo_konselor'
        ]);

        return DataTables::of($counselors)
            ->addIndexColumn()
            ->addColumn('spesialisasi', function($row) {
                $spesialisasi = json_decode($row->spesialisasi, true);
                return is_array($spesialisasi) ? implode(', ', $spesialisasi) : $row->spesialisasi;
            })
            ->addColumn('photo', function($row) {
                if ($row->photo_konselor) {
                    return '<img src="'.asset('storage/counselors/'.$row->photo_konselor).'" class="img-thumbnail" width="50" alt="Photo">';
                }
                return '<img src="'.asset('images/'.($row->jenis_kelamin == 'L' ? 'default-male.png' : 'default-female.png')).'" class="img-thumbnail" width="50" alt="Photo">';
            })
            ->addColumn('action', function($row) {
                return '<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm" onclick="viewCounselor('.$row->id.')">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-warning btn-sm" onclick="editCounselor('.$row->id.')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteCounselor('.$row->id.')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>';
            })
            ->rawColumns(['photo', 'action'])
            ->make(true);
    }

    return view('admin.counselor.v_counselor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nip' => 'required|unique:tbl_counselor',
                'nama_konselor' => 'required',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required|date',
                'email' => 'required|email|unique:tbl_counselor',
                'no_hp' => 'required',
                'pendidikan_terakhir' => 'required',
                'spesialisasi' => 'required|array', // Change validation rule to array
                'status' => 'required|in:aktif,nonaktif,cuti',
                'tanggal_bergabung' => 'required|date',
                'photo_konselor' => 'nullable|image|max:2048'
            ]);

            // Convert spesialisasi array to string
            if (isset($validated['spesialisasi'])) {
                $validated['spesialisasi'] = json_encode($validated['spesialisasi']);
            }

            if ($request->hasFile('photo_konselor')) {
                $file = $request->file('photo_konselor');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/counselors', $filename);
                $validated['photo_konselor'] = $filename;
            }

            $counselor = Counselor::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data konselor berhasil ditambahkan',
                'data' => $counselor
            ]);

        } catch (\Exception $e) {
            Log::error('Error storing counselor: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $counselor = Counselor::findOrFail($id);
        return response()->json($counselor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $counselor = Counselor::findOrFail($id);

        $validated = $request->validate([
            'nip' => 'required|unique:tbl_counselor,nip,'.$id,
            'nama_konselor' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:tbl_counselor,email,'.$id,
            'no_hp' => 'required',
            'pendidikan_terakhir' => 'required',
            'spesialisasi' => 'required',
            'status' => 'required|in:aktif,nonaktif,cuti',
            'tanggal_bergabung' => 'required|date',
            'photo_konselor' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo_konselor')) {
            // Delete old photo
            if ($counselor->photo_konselor) {
                Storage::delete('public/counselors/' . $counselor->photo_konselor);
            }

            // Store new photo
            $file = $request->file('photo_konselor');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/counselors', $filename);
            $validated['photo_konselor'] = $filename;
        }

        $counselor->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data konselor berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $counselor = Counselor::findOrFail($id);

        // Delete photo if exists
        if ($counselor->photo_konselor) {
            Storage::delete('public/counselors/' . $counselor->photo_konselor);
        }

        $counselor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data konselor berhasil dihapus'
        ]);
    }
}
