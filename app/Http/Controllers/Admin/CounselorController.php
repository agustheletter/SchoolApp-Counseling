<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counselor;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CounselorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $counselors = Counselor::select('*');

            return DataTables::of($counselors)
                ->addIndexColumn()
                ->addColumn('nama_lengkap', function($row) {
                    return $row->name_with_title;
                })
                ->addColumn('photo', function($row) {
                    $photoUrl = $row->photo_konselor 
                        ? asset('storage/counselors/' . $row->photo_konselor)
                        : asset('images/' . ($row->jenis_kelamin == 'L' ? 'default-male.png' : 'default-female.png'));
                    return '<img src="'.$photoUrl.'" class="img-thumbnail" width="50">';
                })
                ->addColumn('action', function($row) {
                    return '<div class="btn-group">
                        <button onclick="viewCounselor('.$row->id.')" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button onclick="editCounselor('.$row->id.')" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteCounselor('.$row->id.')" class="btn btn-danger btn-sm">
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
        $validated = $request->validate([
            'nip' => 'required|unique:tbl_counselor',
            'nama_konselor' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:tbl_counselor',
            'no_hp' => 'required',
            'pendidikan_terakhir' => 'required',
            'spesialisasi' => 'required',
            'status' => 'required|in:aktif,nonaktif,cuti',
            'tanggal_bergabung' => 'required|date',
            'photo_konselor' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo_konselor')) {
            $file = $request->file('photo_konselor');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/counselors', $filename);
            $validated['photo_konselor'] = $filename;
        }

        Counselor::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data konselor berhasil ditambahkan'
        ]);
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
