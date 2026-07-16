<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // mis. "SDM Award 2025/2026"
            $table->year('tahun');  // tahun penilaian (filter 1 tahun)
            $table->date('tgl_buka')->nullable();
            $table->date('tgl_tutup')->nullable();
            $table->boolean('aktif')->default(false);
            $table->timestamps();
        });

        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nis')->nullable();
            $table->string('nama');
            $table->string('kelas'); // I - VI
            $table->timestamps();
        });

        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode'); // C1, C2, ...
            $table->string('nama'); // Tingkat Kejuaraan, Peringkat Juara
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('bobots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained()->cascadeOnDelete();
            $table->decimal('bobot', 5, 4)->default(0); // total = 1
            $table->foreignId('periode_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained()->cascadeOnDelete();
            $table->string('nama_kegiatan');
            $table->enum('tingkat', ['kota', 'provinsi', 'nasional', 'internasional']);
            $table->enum('peringkat', ['juara1', 'juara2', 'juara3']);
            $table->date('tanggal');
            $table->string('sertifikat_path')->nullable();
            $table->enum('status_validasi', ['menunggu', 'valid', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasis');
        Schema::dropIfExists('bobots');
        Schema::dropIfExists('kriterias');
        Schema::dropIfExists('siswas');
        Schema::dropIfExists('periodes');
    }
};
