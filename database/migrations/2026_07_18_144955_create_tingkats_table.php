<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tingkats', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->foreignId('kriteria_id')->constrained('kriterias')->cascadeOnDelete();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Seed kriterias referenced by tingkats
        DB::table('kriterias')->insertOrIgnore([
            ['kode' => 'C1', 'nama' => 'Tingkat Nasional', 'keterangan' => 'bobot 0.5', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'C2', 'nama' => 'Tingkat Provinsi', 'keterangan' => 'bobot 0.3', 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'C3', 'nama' => 'Tingkat Kabupaten/Kota', 'keterangan' => 'bobot 0.2', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $c1 = DB::table('kriterias')->where('kode', 'C1')->value('id');
        $c2 = DB::table('kriterias')->where('kode', 'C2')->value('id');
        $c3 = DB::table('kriterias')->where('kode', 'C3')->value('id');

        DB::table('tingkats')->insert([
            ['kode' => 'kabupaten', 'nama' => 'Kabupaten/Kota', 'kriteria_id' => $c3, 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'provinsi', 'nama' => 'Provinsi', 'kriteria_id' => $c2, 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'nasional', 'nama' => 'Nasional', 'kriteria_id' => $c1, 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['kode' => 'internasional', 'nama' => 'Internasional', 'kriteria_id' => $c1, 'urutan' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tingkats');
    }
};
