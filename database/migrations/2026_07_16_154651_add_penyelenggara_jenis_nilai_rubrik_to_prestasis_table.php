<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->enum('penyelenggara', ['pemerintah', 'swasta'])->default('pemerintah')->after('peringkat');
            $table->enum('jenis', ['perorangan', 'beregu'])->default('perorangan')->after('penyelenggara');
            $table->decimal('nilai_rubrik', 5, 2)->nullable()->after('jenis');
        });
    }

    public function down(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropColumn(['penyelenggara', 'jenis', 'nilai_rubrik']);
        });
    }
};
