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
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Rename nama_ortu → nama_ayah, pekerjaan_ortu → pekerjaan_ayah
            $table->renameColumn('nama_ortu', 'nama_ayah');
            $table->renameColumn('pekerjaan_ortu', 'pekerjaan_ayah');
            // Tambah kolom ibu (nullable) setelah pekerjaan_ayah
            $table->string('nama_ibu')->nullable()->after('pekerjaan_ayah');
            $table->string('pekerjaan_ibu')->nullable()->after('nama_ibu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['nama_ibu', 'pekerjaan_ibu']);
            $table->renameColumn('nama_ayah', 'nama_ortu');
            $table->renameColumn('pekerjaan_ayah', 'pekerjaan_ortu');
        });
    }
};
