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
            $table->decimal('biaya_dana_awal_tahun', 12, 2)->nullable()->after('biaya_spp')
                  ->comment('Nominal dana awal tahun yang disepakati');
            $table->decimal('biaya_infaq', 12, 2)->nullable()->after('biaya_zakat')
                  ->comment('Nominal infaq bulanan/sukarela');
            $table->string('diterima_di_jurusan')->nullable()->after('pil3')
                  ->comment('Jurusan tempat pendaftar diterima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['biaya_dana_awal_tahun', 'biaya_infaq', 'diterima_di_jurusan']);
        });
    }
};
