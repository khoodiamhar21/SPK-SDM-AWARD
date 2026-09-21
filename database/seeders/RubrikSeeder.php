<?php

namespace Database\Seeders;

use App\Models\KategoriLomba;
use App\Models\Rubrik;
use Illuminate\Database\Seeder;

class RubrikSeeder extends Seeder
{
    public function run(): void
    {
        // Skor rubrik per KATEGORI LOMBA (cabang lomba).
        // Rumus: skor = B_K + bonus tingkat + gap peringkat + gap jenis, dibatasi 40-100.
        $base = [
            'OLIMPIADE' => 100,
            'LITERASI' => 98,
            'KEISLAMAN' => 96,
            'TEKNOLOGI' => 94,
            'KEPANDUAN' => 92,
            'OLAHRAGA' => 90,
            'SENI' => 88,
        ];

        $bonusTingkat = [
            'internasional' => 5,
            'nasional' => 0,
            'provinsi' => -10,
            'kabupaten' => -20,
        ];

        $gapPeringkat = [
            'juara1' => 0,
            'juara2' => -8,
            'juara3' => -16,
        ];

        $gapJenis = [
            'perorangan' => 0,
            'beregu' => -4,
        ];

        // Hapus rubrik lama tanpa kategori (skema penyelenggara sudah tidak dipakai)
        Rubrik::whereNull('kategori_lomba_id')->delete();

        foreach ($base as $namaKategori => $b) {
            $kategori = KategoriLomba::firstOrCreate(['nama' => $namaKategori]);

            foreach ($bonusTingkat as $tingkat => $tb) {
                foreach ($gapPeringkat as $peringkat => $pg) {
                    foreach ($gapJenis as $jenis => $jg) {
                        $skor = max(40, min(100, $b + $tb + $pg + $jg));

                        Rubrik::updateOrCreate(
                            ['kategori_lomba_id' => $kategori->id, 'peringkat' => $peringkat, 'jenis' => $jenis, 'tingkat' => $tingkat],
                            [
                                'kode' => strtoupper(substr($namaKategori, 0, 4)).'-'.substr($peringkat, -1).substr($jenis, 0, 1).strtoupper(substr($tingkat, 0, 1)),
                                'skor' => $skor,
                            ]
                        );
                    }
                }
            }
        }
    }
}