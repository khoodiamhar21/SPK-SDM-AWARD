<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Panel\RubrikController;
use App\Http\Controllers\Panel\ValidasiController;
use App\Http\Controllers\Panel\PenilaianController;
use App\Http\Controllers\Panel\RekapController;
use App\Http\Controllers\Panel\PeriodeController;
use App\Http\Controllers\Panel\KelasController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:siswa')->group(function () {
        Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
        Route::get('/prestasi/status', [PrestasiController::class, 'statusSeleksi'])->name('prestasi.status');
        Route::get('/prestasi/create', [PrestasiController::class, 'create'])->name('prestasi.create');
        Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    });

    Route::middleware('role:panitia,wakasiswa')->group(function () {
        Route::get('/panel/ranking', [SiswaController::class, 'ranking'])->name('panel.ranking');
    });

    Route::middleware('role:panitia')->group(function () {
        Route::get('/panel/prestasi', [PrestasiController::class, 'index'])->name('panel.prestasi.index');
        Route::post('/panel/prestasi/{prestasi}/validasi', [PrestasiController::class, 'validasi'])
            ->name('panel.prestasi.validasi');
        Route::get('/panel/prestasi/{prestasi}', [PrestasiController::class, 'show'])->name('panel.prestasi.show');
        Route::get('/panel/prestasi/{prestasi}/dokumen', [PrestasiController::class, 'dokumen'])->name('panel.prestasi.dokumen');

        // Validasi Sertifikat (cek berkas)
        Route::get('/panel/validasi', [ValidasiController::class, 'index'])->name('panel.validasi.index');
        Route::get('/panel/validasi/{prestasi}', [ValidasiController::class, 'show'])->name('panel.validasi.show');
        Route::post('/panel/validasi/{prestasi}/putusan', [ValidasiController::class, 'putusan'])->name('panel.validasi.putusan');

        // Validasi berjenjang: Kelas -> Siswa -> Prestasi
        Route::get('/panel/validasi/kelas', [ValidasiController::class, 'kelas'])->name('panel.validasi.kelas');
        Route::get('/panel/validasi/kelas/{kelas}', [ValidasiController::class, 'siswa'])->name('panel.validasi.siswa');
        Route::get('/panel/validasi/siswa/{siswa}', [ValidasiController::class, 'prestasi'])->name('panel.validasi.prestasi');

        // Penilaian (input nilai rubrik)
        Route::get('/panel/penilaian', [PenilaianController::class, 'index'])->name('panel.penilaian.index');
        Route::get('/panel/penilaian/{prestasi}', [PenilaianController::class, 'show'])->name('panel.penilaian.show');
        Route::post('/panel/penilaian/{prestasi}/nilai', [PenilaianController::class, 'nilai'])->name('panel.penilaian.nilai');

        // Penilaian berjenjang: Kelas -> Siswa -> Prestasi
        Route::get('/panel/penilaian/kelas', [PenilaianController::class, 'kelas'])->name('panel.penilaian.kelas');
        Route::get('/panel/penilaian/kelas/{kelas}', [PenilaianController::class, 'siswa'])->name('panel.penilaian.siswa');
        Route::get('/panel/penilaian/siswa/{siswa}', [PenilaianController::class, 'prestasi'])->name('panel.penilaian.prestasi');

        // Rekap Penilaian
        Route::get('/panel/rekap', [RekapController::class, 'index'])->name('panel.rekap.index');

        Route::get('/panel/kriteria', [KriteriaController::class, 'index'])->name('panel.kriteria.index');
        Route::post('/panel/kriteria/bobot', [KriteriaController::class, 'updateBobot'])->name('panel.kriteria.bobot');

        Route::get('/panel/rubrik', [RubrikController::class, 'index'])->name('panel.rubrik.index');
        Route::get('/panel/rubrik/create', [RubrikController::class, 'create'])->name('panel.rubrik.create');
        Route::post('/panel/rubrik', [RubrikController::class, 'store'])->name('panel.rubrik.store');
        Route::get('/panel/rubrik/{rubrik}/edit', [RubrikController::class, 'edit'])->name('panel.rubrik.edit');
        Route::put('/panel/rubrik/{rubrik}', [RubrikController::class, 'update'])->name('panel.rubrik.update');
        Route::delete('/panel/rubrik/{rubrik}', [RubrikController::class, 'destroy'])->name('panel.rubrik.destroy');

        Route::get('/panel/siswa', [SiswaController::class, 'index'])->name('panel.siswa.index');
        Route::get('/panel/siswa/create', [SiswaController::class, 'create'])->name('panel.siswa.create');
        Route::post('/panel/siswa', [SiswaController::class, 'store'])->name('panel.siswa.store');
        Route::get('/panel/siswa/{siswa}', [SiswaController::class, 'show'])->name('panel.siswa.show');
        Route::get('/panel/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('panel.siswa.edit');
        Route::put('/panel/siswa/{siswa}', [SiswaController::class, 'update'])->name('panel.siswa.update');
        Route::delete('/panel/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('panel.siswa.destroy');
        Route::post('/panel/ranking/generate', [SiswaController::class, 'generateRanking'])->name('panel.ranking.generate');
        Route::post('/panel/ranking/{ranking}/umumkan', [SiswaController::class, 'umumkanHasil'])->name('panel.ranking.umumkan');

        Route::get('/panel/banner', [ContentController::class, 'bannerIndex'])->name('panel.banner.index');
        Route::post('/panel/banner', [ContentController::class, 'bannerStore'])->name('panel.banner.store');
        Route::delete('/panel/banner/{banner}', [ContentController::class, 'bannerDestroy'])->name('panel.banner.destroy');

        Route::get('/panel/berita', [ContentController::class, 'beritaIndex'])->name('panel.berita.index');
        Route::post('/panel/berita', [ContentController::class, 'beritaStore'])->name('panel.berita.store');
        Route::delete('/panel/berita/{berita}', [ContentController::class, 'beritaDestroy'])->name('panel.berita.destroy');

        Route::get('/panel/pengumuman', [ContentController::class, 'pengumumanIndex'])->name('panel.pengumuman.index');
        Route::post('/panel/pengumuman', [ContentController::class, 'pengumumanStore'])->name('panel.pengumuman.store');
        Route::delete('/panel/pengumuman/{pengumuman}', [ContentController::class, 'pengumumanDestroy'])->name('panel.pengumuman.destroy');

        // Kelola Akun (Panitia saja)
        Route::get('/panel/akun', [UserController::class, 'index'])->name('panel.akun.index');
        Route::get('/panel/akun/create', [UserController::class, 'create'])->name('panel.akun.create');
        Route::post('/panel/akun', [UserController::class, 'store'])->name('panel.akun.store');
        Route::get('/panel/akun/{user}/edit', [UserController::class, 'edit'])->name('panel.akun.edit');
        Route::patch('/panel/akun/{user}', [UserController::class, 'update'])->name('panel.akun.update');
        Route::delete('/panel/akun/{user}', [UserController::class, 'destroy'])->name('panel.akun.destroy');

        Route::get('/panel/periode', [PeriodeController::class, 'index'])->name('panel.periode.index');
        Route::get('/panel/periode/create', [PeriodeController::class, 'create'])->name('panel.periode.create');
        Route::post('/panel/periode', [PeriodeController::class, 'store'])->name('panel.periode.store');
        Route::get('/panel/periode/{periode}/edit', [PeriodeController::class, 'edit'])->name('panel.periode.edit');
        Route::put('/panel/periode/{periode}', [PeriodeController::class, 'update'])->name('panel.periode.update');
        Route::delete('/panel/periode/{periode}', [PeriodeController::class, 'destroy'])->name('panel.periode.destroy');

        Route::get('/panel/kelas', [KelasController::class, 'index'])->name('panel.kelas.index');
        Route::get('/panel/kelas/create', [KelasController::class, 'create'])->name('panel.kelas.create');
        Route::post('/panel/kelas', [KelasController::class, 'store'])->name('panel.kelas.store');
        Route::get('/panel/kelas/{k}/edit', [KelasController::class, 'edit'])->name('panel.kelas.edit');
        Route::put('/panel/kelas/{k}', [KelasController::class, 'update'])->name('panel.kelas.update');
        Route::delete('/panel/kelas/{k}', [KelasController::class, 'destroy'])->name('panel.kelas.destroy');
    });

    Route::middleware('role:wakasiswa')->group(function () {
        Route::post('/panel/ranking/{ranking}/setujui', [SiswaController::class, 'setujuiRanking'])->name('panel.ranking.setujui');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
