<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nis' => 'required|string|max:20|unique:tbl_siswa,nis',
            'nisn' => 'required|string|max:20|unique:tbl_siswa,nisn',
            'namasiswa' => 'required|string|max:255',
            'tempatlahir' => 'required|string|max:100',
            'tgllahir' => 'required|date_format:Y-m-d',
            'jenkel' => 'required|in:L,P',
            'alamat' => 'nullable|string|max:255',
            'idjurusan' => 'required|integer|exists:tbl_jurusan,idjurusan',
            // 'idprogramkeahlian' => 'required|integer|exists:tbl_programkeahlian,idprogramkeahlian', // DIHAPUS/DIKOMENTARI
            'idagama' => 'required|integer|exists:tbl_agama,idagama',
            'tlprumah' => 'nullable|string|max:255',
            'hpsiswa' => 'nullable|string|max:255',
            'idthnmasuk' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 5),
            'photosiswa' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        // Salin pesan dari jawaban sebelumnya, kecuali untuk idprogramkeahlian
        return [
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS sudah terdaftar.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'namasiswa.required' => 'Nama siswa wajib diisi.',
            'tempatlahir.required' => 'Tempat lahir wajib diisi.',
            'tgllahir.required' => 'Tanggal lahir wajib diisi.',
            'tgllahir.date_format' => 'Format tanggal lahir harus YYYY-MM-DD.',
            'jenkel.required' => 'Jenis kelamin wajib dipilih.',
            'idjurusan.required' => 'Jurusan wajib dipilih.',
            'idjurusan.exists' => 'Jurusan tidak valid.',
            'idagama.required' => 'Agama wajib dipilih.',
            'idagama.exists' => 'Agama tidak valid.',
            'idthnmasuk.required' => 'Tahun masuk wajib diisi.',
            'idthnmasuk.digits' => 'Tahun masuk harus 4 digit angka.',
            'photosiswa.image' => 'File harus berupa gambar.',
            'photosiswa.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'photosiswa.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}