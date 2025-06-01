<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AgamaSeeder::class,           // 1. Tidak ada dependensi
            ProgramKeahlianSeeder::class,  // 2. Tidak ada dependensi ke Jurusan (sesuai struktur tabel saat ini)
            JurusanSeeder::class,          // 3. Mungkin bergantung pada ProgramKeahlian jika Anda mengisi FK 'idprogramkeahlian'
        ]);
    }
}