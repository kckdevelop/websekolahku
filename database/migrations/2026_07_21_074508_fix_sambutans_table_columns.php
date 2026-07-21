<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sambutans', function (Blueprint $table) {
            // Rename nama_kepala_sekolah -> nama_kepala
            if (Schema::hasColumn('sambutans', 'nama_kepala_sekolah') && !Schema::hasColumn('sambutans', 'nama_kepala')) {
                $table->renameColumn('nama_kepala_sekolah', 'nama_kepala');
            }

            // Rename foto -> foto_kepala
            if (Schema::hasColumn('sambutans', 'foto') && !Schema::hasColumn('sambutans', 'foto_kepala')) {
                $table->renameColumn('foto', 'foto_kepala');
            }

            // Add gelar_kepala if not exists
            if (!Schema::hasColumn('sambutans', 'gelar_kepala')) {
                $table->string('gelar_kepala')->nullable()->after('nama_kepala');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sambutans', function (Blueprint $table) {
            if (Schema::hasColumn('sambutans', 'nama_kepala') && !Schema::hasColumn('sambutans', 'nama_kepala_sekolah')) {
                $table->renameColumn('nama_kepala', 'nama_kepala_sekolah');
            }

            if (Schema::hasColumn('sambutans', 'foto_kepala') && !Schema::hasColumn('sambutans', 'foto')) {
                $table->renameColumn('foto_kepala', 'foto');
            }

            if (Schema::hasColumn('sambutans', 'gelar_kepala')) {
                $table->dropColumn('gelar_kepala');
            }
        });
    }
};
