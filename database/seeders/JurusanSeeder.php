<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Jurusan; // Pastikan path model benar

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        // ID Program Keahlian di sini merujuk pada 'idprogramkeahlian' yang Anda definisikan di ProgramKeahlianSeeder.php
        // PK_TE = Program Keahlian Teknik Elektronika (misal ID 1)
        // PK_TK = Program Keahlian Teknik Ketenagalistrikan (misal ID 2)
        // PK_PPLG = Program Keahlian Pengembangan Perangkat Lunak dan Gim (misal ID 3)
        // PK_BP = Program Keahlian Broadcasting dan Perfilman (misal ID 4)

        $jurusans = [
            // Konsentrasi di bawah "Teknik Elektronika" (ID Program Keahlian = 1)
            ['idjurusan' => 1, 'namajurusan' => 'Teknik Mekatronika', 'kodejurusan' => 'TM', 'idprogramkeahlian_fk' => 1],
            ['idjurusan' => 2, 'namajurusan' => 'Teknik Elektronika Industri', 'kodejurusan' => 'TEI', 'idprogramkeahlian_fk' => 1],
            ['idjurusan' => 3, 'namajurusan' => 'Teknik Otomasi Industri', 'kodejurusan' => 'TOI', 'idprogramkeahlian_fk' => 1],
            ['idjurusan' => 4, 'namajurusan' => 'Teknik Elektronika Komunikasi', 'kodejurusan' => 'TEK', 'idprogramkeahlian_fk' => 1],
            ['idjurusan' => 5, 'namajurusan' => 'Instrumentasi dan Otomatisasi Proses', 'kodejurusan' => 'IOP', 'idprogramkeahlian_fk' => 1],

            // Konsentrasi di bawah "Teknik Ketenagalistrikan" (ID Program Keahlian = 2)
            ['idjurusan' => 6, 'namajurusan' => 'Teknik Pemanasan, Tata Udara, dan Pendinginan', 'kodejurusan' => 'TPTUP', 'idprogramkeahlian_fk' => 2],
            // '(Heating, Ventilation, and Air Conditioning)' bisa dihilangkan dari nama jika terlalu panjang, atau kode bisa 'HVAC'

            // Konsentrasi di bawah "Pengembangan Perangkat Lunak dan Gim" (ID Program Keahlian = 3)
            ['idjurusan' => 7, 'namajurusan' => 'Rekayasa Perangkat Lunak', 'kodejurusan' => 'RPL', 'idprogramkeahlian_fk' => 3],
            ['idjurusan' => 8, 'namajurusan' => 'Sistem Informasi, Jaringan, dan Aplikasi', 'kodejurusan' => 'SIJA', 'idprogramkeahlian_fk' => 3],

            // Konsentrasi di bawah "Broadcasting dan Perfilman" (ID Program Keahlian = 4)
            ['idjurusan' => 9, 'namajurusan' => 'Produksi dan Siaran Program Televisi', 'kodejurusan' => 'PSPT', 'idprogramkeahlian_fk' => 4],

            // Tambahkan ID Jurusan lain jika ada
        ];

        foreach ($jurusans as $data_jurusan) {
            Jurusan::firstOrCreate(
                ['idjurusan' => $data_jurusan['idjurusan']], // Kriteria pencarian berdasarkan primary key
                [
                    'namajurusan' => $data_jurusan['namajurusan'],
                    'kodejurusan' => $data_jurusan['kodejurusan'],
                    // Kolom di tbl_jurusan adalah 'idprogramkeahlian'
                    'idprogramkeahlian' => $data_jurusan['idprogramkeahlian_fk'],
                ]
            );
        }
    }
}