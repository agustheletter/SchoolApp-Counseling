<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\ProgramKeahlian; // Dipertahankan untuk relasi di model
use App\Models\Agama;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Support\Facades\Storage;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $siswa = Siswa::with(['jurusan', 'agama']);

            // Apply filters
            if ($request->filled('jurusan')) {
                $siswa->where('idjurusan', $request->jurusan);
            }
            if ($request->filled('tahun_masuk')) {
                $siswa->where('idthnmasuk', $request->tahun_masuk);
            }
            if ($request->filled('jenkel')) {
                $siswa->where('jenkel', $request->jenkel);
            }

            return DataTables::of($siswa)
                ->addIndexColumn()
                ->addColumn('ttl', function ($row) {
                    return $row->tempatlahir . ', ' . \Carbon\Carbon::parse($row->tgllahir)->format('d-m-Y');
                })
                ->addColumn('jurusan', function ($row) {
                    return $row->jurusan ? $row->jurusan->namajurusan : '-';
                })
                ->addColumn('photo', function ($row) {
                    $photoUrl = $row->photosiswa ? asset('storage/' . $row->photosiswa) : asset('images/default-avatar.png');
                    return '<img src="' . $photoUrl . '" alt="Photo" class="img-thumbnail">';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group">
                            <button onclick="viewSiswa('.$row->idsiswa.')" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="editSiswa('.$row->idsiswa.')" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteSiswa('.$row->idsiswa.')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }

        $jurusans = Jurusan::all();
        $agamas = Agama::all();
        $tahunMasukOptions = range(date('Y'), date('Y')-10);

        return view('admin.student.v_student', compact('jurusans', 'agamas', 'tahunMasukOptions'));
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

    public function show(Siswa $student)
    {
        $student->load([
            'jurusan.programKeahlian', // Eager load ProgramKeahlian dari Jurusan
            'agama'
        ]);
        
        $data = $student->toArray();
        $data['jurusan_nama'] = $student->jurusan ? $student->jurusan->namajurusan : '-';
        // Program nama diambil dari ProgramKeahlian yang berelasi dengan Jurusan
        $data['program_nama'] = $student->jurusan && $student->jurusan->programKeahlian ? $student->jurusan->programKeahlian->namaprogramkeahlian : '-';
        $data['agama_nama'] = $student->agama ? $student->agama->agama : '-';
        $data['photosiswa_url'] = $student->photo_url;
        $data['tgllahir'] = $student->tgllahir ? $student->tgllahir->format('Y-m-d') : null;

        return response()->json($data);
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

    public function destroy(Siswa $student)
    {
        DB::beginTransaction();
        try {
            if ($student->photosiswa && Storage::disk('public')->exists($student->photosiswa)) {
                Storage::disk('public')->delete($student->photosiswa);
            }
            $student->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Data siswa berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting siswa: ' . $e->getMessage() . ' Stack: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data siswa.'], 500);
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
}