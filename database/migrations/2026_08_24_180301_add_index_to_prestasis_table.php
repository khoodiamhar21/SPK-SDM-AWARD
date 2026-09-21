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
        Schema::table('prestasis', function (Blueprint $table) {
            $table->index(['periode_id', 'status_validasi'], 'prestasis_periode_status_idx');
            $table->index(['periode_id', 'status_validasi', 'nilai_rubrik'], 'prestasis_saw_query_idx');
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropIndex('prestasis_periode_status_idx');
            $table->dropIndex('prestasis_saw_query_idx');
            $table->dropIndex(['tanggal']);
        });
    }
};
