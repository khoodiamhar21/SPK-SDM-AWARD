<?php

namespace Database\Seeders;

use App\Models\Rubrik;
use Illuminate\Database\Seeder;

class RubrikSeeder extends Seeder
{
    public function run(): void
    {
        // Kode skor dari Panduan Penilaian SDM Award.
        // [penyelenggara, peringkat, jenis, tingkat, kode, skor]
        $data = [
            // Instansi Pemerintahan - Nasional
            ['pemerintah', 'juara1', 'perorangan', 'nasional', 'AA1', 100],
            ['pemerintah', 'juara2', 'perorangan', 'nasional', 'AA2', 95],
            ['pemerintah', 'juara3', 'perorangan', 'nasional', 'AA3', 90],
            ['pemerintah', 'juara1', 'beregu', 'nasional', 'AA4', 95],
            ['pemerintah', 'juara2', 'beregu', 'nasional', 'AA5', 90],
            ['pemerintah', 'juara3', 'beregu', 'nasional', 'AA6', 85],
            // Instansi Pemerintahan - Provinsi
            ['pemerintah', 'juara1', 'perorangan', 'provinsi', 'BA1', 95],
            ['pemerintah', 'juara1', 'perorangan', 'provinsi', 'BA2', 90],
            ['pemerintah', 'juara1', 'perorangan', 'provinsi', 'BA3', 85],
            ['pemerintah', 'juara1', 'perorangan', 'provinsi', 'BA4', 90],
            ['pemerintah', 'juara1', 'perorangan', 'provinsi', 'BA5', 85],
            ['pemerintah', 'juara1', 'perorangan', 'provinsi', 'BA6', 80],
            ['pemerintah', 'juara2', 'perorangan', 'provinsi', 'BB1', 85],
            ['pemerintah', 'juara2', 'perorangan', 'provinsi', 'BB2', 80],
            ['pemerintah', 'juara2', 'perorangan', 'provinsi', 'BB3', 75],
            ['pemerintah', 'juara2', 'perorangan', 'provinsi', 'BB4', 80],
            ['pemerintah', 'juara2', 'perorangan', 'provinsi', 'BB5', 75],
            ['pemerintah', 'juara2', 'perorangan', 'provinsi', 'BB6', 70],
            // Instansi Pemerintahan - Kabupaten/Kota
            ['pemerintah', 'juara1', 'perorangan', 'kabupaten', 'CA1', 90],
            ['pemerintah', 'juara2', 'perorangan', 'kabupaten', 'CA2', 85],
            ['pemerintah', 'juara3', 'perorangan', 'kabupaten', 'CA3', 80],
            ['pemerintah', 'juara1', 'beregu', 'kabupaten', 'CA4', 85],
            ['pemerintah', 'juara2', 'beregu', 'kabupaten', 'CA5', 80],
            ['pemerintah', 'juara3', 'beregu', 'kabupaten', 'CA6', 75],
            // Instansi Swasta - Nasional
            ['swasta', 'juara1', 'perorangan', 'nasional', 'AB1', 90],
            ['swasta', 'juara2', 'perorangan', 'nasional', 'AB2', 85],
            ['swasta', 'juara3', 'perorangan', 'nasional', 'AB3', 80],
            ['swasta', 'juara1', 'beregu', 'nasional', 'AB4', 85],
            ['swasta', 'juara2', 'beregu', 'nasional', 'AB5', 80],
            ['swasta', 'juara3', 'beregu', 'nasional', 'AB6', 75],
            // Instansi Swasta - Kabupaten/Kota
            ['swasta', 'juara1', 'perorangan', 'kabupaten', 'CB1', 80],
            ['swasta', 'juara2', 'perorangan', 'kabupaten', 'CB2', 75],
            ['swasta', 'juara3', 'perorangan', 'kabupaten', 'CB3', 70],
            ['swasta', 'juara1', 'beregu', 'kabupaten', 'CB4', 75],
            ['swasta', 'juara2', 'beregu', 'kabupaten', 'CB5', 70],
            ['swasta', 'juara3', 'beregu', 'kabupaten', 'CB6', 65],
        ];

        foreach ($data as [$peny, $peringkat, $jenis, $tingkat, $kode, $skor]) {
            Rubrik::updateOrCreate(
                ['penyelenggara' => $peny, 'peringkat' => $peringkat, 'jenis' => $jenis, 'tingkat' => $tingkat],
                ['kode' => $kode, 'skor' => $skor]
            );
        }
    }
}
