<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('role', 20)->nullable();
            $table->string('action');             // generate_ranking, validasi_kelas, umumkan, etc
            $table->string('description')->nullable();
            $table->nullableMorphs('subject');     // model yang terlibat (Ranking, Prestasi, etc)
            $table->ipAddress('ip')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
