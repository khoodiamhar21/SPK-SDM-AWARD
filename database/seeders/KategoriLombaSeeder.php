<?php

namespace Database\Seeders;

use App\Models\KategoriLomba;
use Illuminate\Database\Seeder;

class KategoriLombaSeeder extends Seeder
{
    public function run(): void
    {
        $namaList = [
            'KEISLAMAN',
            'KEPANDUAN',
            'LITERASI',
            'OLAHRAGA',
            'SENI',
            'TEKNOLOGI',
            'OLIMPIADE',
        ];

        foreach ($namaList as $nama) {
            KategoriLomba::firstOrCreate(['nama' => $nama]);
        }
    }
}