<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('foto_path');
            $table->string('judul')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori')->default('Prestasi');
            $table->date('tanggal');
            $table->text('isi')->nullable();
            $table->string('foto_path')->nullable();
            $table->timestamps();
        });

        Schema::create('pengumumans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('isi')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('photo_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumumans');
        Schema::dropIfExists('beritas');
        Schema::dropIfExists('banners');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo_path');
        });
    }
};
