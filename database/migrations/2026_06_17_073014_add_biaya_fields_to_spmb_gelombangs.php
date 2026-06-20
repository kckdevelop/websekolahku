<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            $table->decimal('biaya_pendaftaran', 12, 2)->default(0)->after('keterangan')
                  ->comment('Biaya pendaftaran default untuk gelombang ini');
            $table->decimal('biaya_spp_default', 12, 2)->default(0)->after('biaya_pendaftaran')
                  ->comment('Nominal SPP default untuk gelombang ini');
            $table->decimal('biaya_zakat_default', 12, 2)->default(0)->after('biaya_spp_default')
                  ->comment('Nominal zakat/biaya pendidikan default');
            $table->decimal('potongan_subsidi', 12, 2)->default(0)->after('biaya_zakat_default')
                  ->comment('Nominal potongan subsidi sekolah untuk gelombang ini');
        });
    }

    public function down(): void
    {
        Schema::table('spmb_gelombangs', function (Blueprint $table) {
            $table->dropColumn(['biaya_pendaftaran', 'biaya_spp_default', 'biaya_zakat_default', 'potongan_subsidi']);
        });
    }
};
