<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramKeahlian; // Pastikan path model benar

class ProgramKeahlianSeeder extends Seeder
{
    public function run(): void
    {
        $programKeahlians = [
            // ID ini bebas Anda tentukan, tapi harus konsisten saat dirujuk oleh JurusanSeeder
            ['idprogramkeahlian' => 1, 'namaprogramkeahlian' => 'Teknik Elektronika', 'kodeprogramkeahlian' => 'TE'],
            ['idprogramkeahlian' => 2, 'namaprogramkeahlian' => 'Teknik Ketenagalistrikan', 'kodeprogramkeahlian' => 'TK'],
            ['idprogramkeahlian' => 3, 'namaprogramkeahlian' => 'Pengembangan Perangkat Lunak dan Gim', 'kodeprogramkeahlian' => 'PPLG'],
            ['idprogramkeahlian' => 4, 'namaprogramkeahlian' => 'Broadcasting dan Perfilman', 'kodeprogramkeahlian' => 'BP'],
            // Tambahkan program keahlian lain jika ada di gambar Anda yang belum tercakup
        ];

        foreach ($programKeahlians as $data_pk) {
            ProgramKeahlian::firstOrCreate(
                ['idprogramkeahlian' => $data_pk['idprogramkeahlian']],
                [
                    'namaprogramkeahlian' => $data_pk['namaprogramkeahlian'],
                    'kodeprogramkeahlian' => $data_pk['kodeprogramkeahlian'],
                ]
            );
        }
    }
}