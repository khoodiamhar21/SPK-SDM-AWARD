<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kategori_lombas', function (Blueprint $table) {
            $table->enum('jenis_prestasi', ['akademik', 'non_akademik'])->default('non_akademik')->after('nama');
        });

        Schema::table('prestasis', function (Blueprint $table) {
            $table->enum('jenis_prestasi', ['akademik', 'non_akademik'])->default('non_akademik')->after('kategori_lomba_id');
        });
    }

    public function down(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropColumn('jenis_prestasi');
        });

        Schema::table('kategori_lombas', function (Blueprint $table) {
            $table->dropColumn('jenis_prestasi');
        });
    }
};
