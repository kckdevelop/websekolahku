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
                $table->string('tahun_ajaran', 20)->nullable()->after('kode_gelombang');
            }
            if (Schema::hasColumn('spmb_gelombangs', 'tanggal_mulai')) {
                $table->date('tanggal_mulai')->nullable()->change();
            }
            if (Schema::hasColumn('spmb_gelombangs', 'tanggal_selesai')) {
                $table->date('tanggal_selesai')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            // rollback logic if needed
        });
    }
};
