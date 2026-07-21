<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            if (Schema::hasColumn('spmb_gelombangs', 'tanggal_buka') && !Schema::hasColumn('spmb_gelombangs', 'tanggal_mulai')) {
                $table->renameColumn('tanggal_buka', 'tanggal_mulai');
            }
            if (Schema::hasColumn('spmb_gelombangs', 'tanggal_tutup') && !Schema::hasColumn('spmb_gelombangs', 'tanggal_selesai')) {
                $table->renameColumn('tanggal_tutup', 'tanggal_selesai');
            }
            if (!Schema::hasColumn('spmb_gelombangs', 'tahun_ajaran')) {
                $table->string('tahun_ajaran')->nullable()->after('kode_gelombang');
            }
        });
    }

    public function down(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            if (Schema::hasColumn('spmb_gelombangs', 'tanggal_mulai') && !Schema::hasColumn('spmb_gelombangs', 'tanggal_buka')) {
                $table->renameColumn('tanggal_mulai', 'tanggal_buka');
            }
            if (Schema::hasColumn('spmb_gelombangs', 'tanggal_selesai') && !Schema::hasColumn('spmb_gelombangs', 'tanggal_tutup')) {
                $table->renameColumn('tanggal_selesai', 'tanggal_tutup');
            }
            if (Schema::hasColumn('spmb_gelombangs', 'tahun_ajaran')) {
                $table->dropColumn('tahun_ajaran');
            }
        });
    }
};
