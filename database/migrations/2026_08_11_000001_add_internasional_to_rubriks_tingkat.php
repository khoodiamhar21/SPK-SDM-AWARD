<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rubriks', function (Blueprint $table) {
            $table->enum('tingkat', ['nasional', 'provinsi', 'kabupaten', 'internasional'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('rubriks', function (Blueprint $table) {
            $table->enum('tingkat', ['nasional', 'provinsi', 'kabupaten'])->change();
        });
    }
};