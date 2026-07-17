<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'nis')) {
                $table->dropColumn('nis');
            }

            if (!Schema::hasColumn('siswas', 'nisn')) {
                $table->string('nisn')->nullable()->unique()->after('user_id');
            }

            if (!Schema::hasColumn('siswas', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable()->after('nama')->constrained('kelas')->nullOnDelete();
            }

            if (!Schema::hasColumn('siswas', 'foto')) {
                $table->string('foto')->nullable()->after('kelas_id');
            }
            if (!Schema::hasColumn('siswas', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('foto');
            }
            if (!Schema::hasColumn('siswas', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (!Schema::hasColumn('siswas', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('siswas', 'alamat')) {
                $table->text('alamat')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('siswas', 'no_hp_ortu')) {
                $table->string('no_hp_ortu')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('siswas', 'waktu_registrasi_pertama')) {
                $table->timestamp('waktu_registrasi_pertama')->nullable()->after('no_hp_ortu');
            }
            if (!Schema::hasColumn('siswas', 'periode_terakhir_ikuti')) {
                $table->foreignId('periode_terakhir_ikuti')->nullable()->after('waktu_registrasi_pertama')->constrained('periodes')->nullOnDelete();
            }
        });

        // Drop the legacy varchar kelas column if still present.
        if (Schema::hasColumn('siswas', 'kelas')) {
            Schema::table('siswas', function (Blueprint $table) {
                $table->dropColumn('kelas');
            });
        }

        // Ensure nisn uniqueness (idempotent).
        $indexes = Illuminate\Support\Facades\DB::select("SHOW INDEX FROM siswas WHERE Key_name = 'siswas_nisn_unique'");
        if (empty($indexes)) {
            Illuminate\Support\Facades\Schema::table('siswas', function (Blueprint $table) {
                $table->unique('nisn', 'siswas_nisn_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            if (Schema::hasColumn('siswas', 'kelas_id')) {
                $table->dropConstrainedForeignId('kelas_id');
            }
            if (Schema::hasColumn('siswas', 'periode_terakhir_ikuti')) {
                $table->dropConstrainedForeignId('periode_terakhir_ikuti');
            }
            $table->dropColumn(array_filter(
                ['nisn', 'foto', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_hp_ortu', 'waktu_registrasi_pertama'],
                fn ($c) => Schema::hasColumn('siswas', $c)
            ));
            if (!Schema::hasColumn('siswas', 'nis')) {
                $table->string('nis')->nullable();
            }
        });
    }
};

