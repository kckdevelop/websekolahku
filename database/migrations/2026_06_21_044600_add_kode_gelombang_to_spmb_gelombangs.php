<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            $table->unsignedTinyInteger('kode_gelombang')
                  ->nullable()
                  ->after('nama_gelombang')
                  ->comment('Kode angka gelombang (1, 2, 3, ...) yang dipakai di nomor pendaftaran MSBxx-WW-NNN');
        });
    }

    public function down(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            $table->dropColumn('kode_gelombang');
        });
    }
};
