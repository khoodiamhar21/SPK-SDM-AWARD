<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubriks', function (Blueprint $table) {
            $table->id();
            $table->enum('penyelenggara', ['pemerintah', 'swasta']);
            $table->enum('peringkat', ['juara1', 'juara2', 'juara3']);
            $table->enum('jenis', ['perorangan', 'beregu']);
            $table->enum('tingkat', ['nasional', 'provinsi', 'kabupaten']);
            $table->string('kode');   // AA1, BA1, CA1, ...
            $table->decimal('skor', 5, 2); // 40 - 100
            $table->timestamps();

            $table->unique(['penyelenggara', 'peringkat', 'jenis', 'tingkat'], 'rubrik_uniq');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubriks');
    }
};
