<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:siswa')->group(function () {
        Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
        Route::get('/prestasi/create', [PrestasiController::class, 'create'])->name('prestasi.create');
        Route::post('/prestasi', [PrestasiController::class, 'store'])->name('prestasi.store');
    });

    Route::middleware('role:panitia,wakasiswa')->group(function () {
        Route::get('/panel/prestasi', [PrestasiController::class, 'index'])->name('panel.prestasi.index');
        Route::post('/panel/prestasi/{prestasi}/validasi', [PrestasiController::class, 'validasi'])
            ->name('panel.prestasi.validasi');
        Route::get('/panel/kriteria', [KriteriaController::class, 'index'])->name('panel.kriteria.index');
        Route::post('/panel/kriteria/bobot', [KriteriaController::class, 'updateBobot'])->name('panel.kriteria.bobot');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
