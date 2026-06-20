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
            $table->unsignedBigInteger('petugas_wawancara_id')->nullable()->after('diterima_di_jurusan')
                  ->comment('ID petugas pewawancara');
            $table->foreign('petugas_wawancara_id')
                  ->references('id')->on('petugas_wawancaras')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropForeign(['petugas_wawancara_id']);
            $table->dropColumn('petugas_wawancara_id');
        });
    }
};
