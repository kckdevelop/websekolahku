<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            if (Schema::hasColumn('pendaftarans', 'kesehatan_tensi')) {
                $table->dropColumn('kesehatan_tensi');
            }
            $table->string('kesehatan_golongan_darah')->nullable()->after('kesehatan_berat_badan');
            $table->string('kesehatan_mata_minus')->nullable()->after('kesehatan_buta_warna');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('kesehatan_tensi')->nullable()->after('kesehatan_berat_badan');
            $table->dropColumn(['kesehatan_golongan_darah', 'kesehatan_mata_minus']);
        });
    }
};
