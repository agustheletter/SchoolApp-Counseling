<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Agama;

class AgamaSeeder extends Seeder
{
    public function run(): void
    {
        $agamas = [
            ['idagama' => 1, 'agama' => 'Islam'],
            ['idagama' => 2, 'agama' => 'Kristen Protestan'],
            ['idagama' => 3, 'agama' => 'Kristen Katolik'],
            ['idagama' => 4, 'agama' => 'Hindu'],
            ['idagama' => 5, 'agama' => 'Buddha'],
            ['idagama' => 6, 'agama' => 'Konghucu'],
        ];
        foreach ($agamas as $data_agama) {
            Agama::firstOrCreate(
                ['idagama' => $data_agama['idagama']], // Kriteria pencarian
                ['agama' => $data_agama['agama']]      // Data untuk dibuat jika tidak ditemukan
            );
        }
    }
}