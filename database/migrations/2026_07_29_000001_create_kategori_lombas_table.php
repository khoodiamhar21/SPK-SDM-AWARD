<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_lombas', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        Schema::table('rubriks', function (Blueprint $table) {
            $table->dropUnique('rubrik_uniq');
            $table->dropColumn('penyelenggara');
            $table->foreignId('kategori_lomba_id')->nullable()->after('id')->constrained('kategori_lombas')->nullOnDelete();
            $table->unique(['kategori_lomba_id', 'peringkat', 'jenis', 'tingkat'], 'rubrik_uniq');
        });

        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropColumn('penyelenggara');
            $table->foreignId('kategori_lomba_id')->nullable()->after('peringkat')->constrained('kategori_lombas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kategori_lomba_id');
            $table->enum('penyelenggara', ['pemerintah', 'swasta'])->default('pemerintah')->after('peringkat');
        });

        Schema::table('rubriks', function (Blueprint $table) {
            $table->dropUnique('rubrik_uniq');
            $table->dropConstrainedForeignId('kategori_lomba_id');
            $table->enum('penyelenggara', ['pemerintah', 'swasta'])->after('id');
            $table->unique(['penyelenggara', 'peringkat', 'jenis', 'tingkat'], 'rubrik_uniq');
        });

        Schema::dropIfExists('kategori_lombas');
    }
};