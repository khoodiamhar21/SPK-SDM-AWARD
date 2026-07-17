<?php

namespace Database\Seeders;

use App\Models\Bobot;
use App\Models\Kelas;
use App\Models\Kriteria;
use App\Models\Periode;
use App\Models\Prestasi;
use App\Models\Rubrik;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SpkSeeder extends Seeder
{
    public function run(): void
    {
        // ===== PERIODE =====
        $periode = Periode::firstOrCreate(
            ['tahun' => 2025],
            ['nama' => 'SDM Award 2025/2026', 'tgl_buka' => '2025-01-01', 'tgl_tutup' => '2025-12-31', 'aktif' => true]
        );

        // ===== KELAS =====
        $this->call(KelasSeeder::class);

        // ===== AKUN PENGGUNA =====
        $kelasI = Kelas::where('urutan', 1)->first();
        $kelasII = Kelas::where('urutan', 2)->first();
        $kelasIV = Kelas::where('urutan', 4)->first();
        $kelasV = Kelas::where('urutan', 5)->first();
        $kelasVI = Kelas::where('urutan', 6)->first();

        $accounts = [
            ['email' => 'panitia@sdmaward.test', 'name' => 'Panitia SDM Award', 'role' => 'panitia'],
            ['email' => 'waka@sdmaward.test', 'name' => 'Waka Kesiswaan', 'role' => 'wakasiswa'],
            ['nisn' => '2024001', 'name' => 'Budi Santoso', 'role' => 'siswa', 'kelas' => $kelasV->id],
            ['nisn' => '2024002', 'name' => 'Siti Aminah', 'role' => 'siswa', 'kelas' => $kelasVI->id],
            ['nisn' => '2024003', 'name' => 'Rizki Pratama', 'role' => 'siswa', 'kelas' => $kelasIV->id],
            ['nisn' => '2024004', 'name' => 'Nadia Lestari', 'role' => 'siswa', 'kelas' => $kelasV->id],
            ['nisn' => '2024005', 'name' => 'Fajar Nugroho', 'role' => 'siswa', 'kelas' => $kelasVI->id],
        ];

        $siswaUsers = [];
        foreach ($accounts as $a) {
            if ($a['role'] === 'siswa') {
                $siswa = Siswa::firstOrCreate(
                    ['nisn' => $a['nisn']],
                    ['nama' => $a['name'], 'kelas_id' => $a['kelas']]
                );
                $user = User::firstOrCreate(
                    ['nisn' => $a['nisn']],
                    ['name' => $a['name'], 'email' => $a['nisn'].'@sdmaward.test', 'password' => Hash::make('password'), 'role' => 'siswa']
                );
                $siswa->update([
                    'user_id' => $user->id,
                    'waktu_registrasi_pertama' => now(),
                    'periode_terakhir_ikuti' => $periode->id,
                ]);
                $siswaUsers[$a['nisn']] = $user;
            } else {
                User::firstOrCreate(
                    ['email' => $a['email']],
                    ['name' => $a['name'], 'password' => Hash::make('password'), 'role' => $a['role']]
                );
            }
        }

        // Map siswa
        $siswa = Siswa::where('nisn', '2024001')->first();
        $siswa2 = Siswa::where('nisn', '2024002')->first();
        $siswa3 = Siswa::where('nisn', '2024003')->first();
        $siswa4 = Siswa::where('nisn', '2024004')->first();
        $siswa5 = Siswa::where('nisn', '2024005')->first();

        // ===== KRITERIA & BOBOT (SAW - tingkat kejuaraan) =====
        $c1 = Kriteria::firstOrCreate(['kode' => 'C1'], ['nama' => 'Tingkat Nasional', 'keterangan' => 'bobot 0.5']);
        $c2 = Kriteria::firstOrCreate(['kode' => 'C2'], ['nama' => 'Tingkat Provinsi', 'keterangan' => 'bobot 0.3']);
        $c3 = Kriteria::firstOrCreate(['kode' => 'C3'], ['nama' => 'Tingkat Kabupaten/Kota', 'keterangan' => 'bobot 0.2']);
        Bobot::firstOrCreate(['kriteria_id' => $c1->id, 'periode_id' => $periode->id], ['bobot' => 0.5]);
        Bobot::firstOrCreate(['kriteria_id' => $c2->id, 'periode_id' => $periode->id], ['bobot' => 0.3]);
        Bobot::firstOrCreate(['kriteria_id' => $c3->id, 'periode_id' => $periode->id], ['bobot' => 0.2]);

        // ===== RUBRIK (dari Panduan Penilaian SDM Award) =====
        $this->call(RubrikSeeder::class);

        // ===== DATA PRESTASI CONTOH =====
        // [siswa, kegiatan, tingkat, peringkat, penyelenggara, jenis, tgl, status]
        $seed = [
            [$siswa,  'OSN Matematika',     'nasional',     'juara1', 'pemerintah', 'perorangan', '2025-06-10', 'valid'],
            [$siswa,  'Festival Seni',       'provinsi',     'juara2', 'pemerintah', 'perorangan', '2025-08-15', 'valid'],
            [$siswa2, 'Olimpiade Sains',     'nasional',     'juara3', 'pemerintah', 'perorangan', '2025-09-20', 'valid'],
            [$siswa2, 'Lomba Tahfidz',       'kabupaten',    'juara1', 'pemerintah', 'perorangan', '2025-03-05', 'menunggu'],
            [$siswa3, 'Lomba Pidato',        'provinsi',     'juara1', 'pemerintah', 'perorangan', '2025-07-12', 'valid'],
            [$siswa3, 'MTQ Tingkat Kota',    'kabupaten',    'juara2', 'pemerintah', 'perorangan', '2025-04-18', 'valid'],
            [$siswa4, 'Lomba Melukis',       'nasional',     'juara2', 'swasta',     'perorangan', '2025-10-01', 'valid'],
            [$siswa4, 'Lomba Menyanyi',      'provinsi',     'juara3', 'swasta',     'perorangan', '2025-05-22', 'menunggu'],
            [$siswa5, 'Olympiade IPS',       'nasional',     'juara1', 'pemerintah', 'beregu',    '2025-11-03', 'valid'],
            [$siswa5, 'Lomba Basket',        'kabupaten',    'juara1', 'swasta',     'beregu',    '2025-02-14', 'valid'],
        ];

        foreach ($seed as [$s, $keg, $tk, $pr, $peny, $jenis, $tgl, $st]) {
            $p = Prestasi::firstOrCreate(
                ['siswa_id' => $s->id, 'nama_kegiatan' => $keg],
                [
                    'periode_id' => $periode->id, 'tingkat' => $tk, 'peringkat' => $pr,
                    'penyelenggara' => $peny, 'jenis' => $jenis,
                    'tanggal' => $tgl, 'status_validasi' => $st,
                ]
            );
            if ($p->nilai_rubrik === null) {
                $p->isiNilaiRubrik();
            }
        }
    }
}
