<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->decimal('biaya_spp', 12, 2)->nullable()->after('pembayaran_verified_at')
                  ->comment('Nominal SPP yang ditetapkan saat wawancara');
            $table->decimal('biaya_zakat', 12, 2)->nullable()->after('biaya_spp')
                  ->comment('Nominal zakat/infaq/biaya pendidikan');
            $table->decimal('biaya_potongan', 12, 2)->default(0)->after('biaya_zakat')
                  ->comment('Potongan subsidi dari gelombang');
            $table->decimal('total_tagihan', 12, 2)->nullable()->after('biaya_potongan')
                  ->comment('Total tagihan = SPP + Zakat - Potongan, dihitung otomatis');
            $table->string('biaya_petugas')->nullable()->after('total_tagihan')
                  ->comment('Petugas yang menetapkan biaya');
            $table->timestamp('biaya_verified_at')->nullable()->after('biaya_petugas')
                  ->comment('Waktu penetapan biaya');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'biaya_spp', 'biaya_zakat', 'biaya_potongan',
                'total_tagihan', 'biaya_petugas', 'biaya_verified_at',
            ]);
        });
    }
};
