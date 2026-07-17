<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['I', 1], ['II', 2], ['III', 3], ['IV', 4], ['V', 5], ['VI', 6],
        ];
        foreach ($data as [$nama, $urutan]) {
            Kelas::updateOrCreate(['urutan' => $urutan], ['nama' => $nama]);
        }
    }
}
