<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // UKS / Kesehatan
            $table->string('kesehatan_tinggi_badan')->nullable();
            $table->string('kesehatan_berat_badan')->nullable();
            $table->string('kesehatan_tensi')->nullable();
            $table->string('kesehatan_buta_warna')->nullable(); // 'ya', 'tidak'
            $table->string('kesehatan_tato_tindik')->nullable(); // 'tato', 'tindik', 'tato_tindik', 'tidak'
            $table->string('kesehatan_riwayat_penyakit')->nullable();
            $table->text('kesehatan_catatan')->nullable();
            $table->string('kesehatan_petugas')->nullable();
            $table->timestamp('kesehatan_verified_at')->nullable();

            // Gaya Belajar & Minat
            $table->string('gaya_belajar_tipe')->nullable(); // 'visual', 'auditori', 'kinestetik'
            $table->text('gaya_belajar_minat_bakat')->nullable();
            $table->text('gaya_belajar_catatan')->nullable();
            $table->string('gaya_belajar_petugas')->nullable();
            $table->timestamp('gaya_belajar_verified_at')->nullable();

            // Wawancara
            $table->text('wawancara_baca_tulis_alquran')->nullable();
            $table->text('wawancara_solat_fardhu')->nullable();
            $table->text('wawancara_kepribadian')->nullable();
            $table->text('wawancara_catatan')->nullable();
            $table->string('wawancara_petugas')->nullable();
            $table->timestamp('wawancara_verified_at')->nullable();

            // Pembayaran
            $table->integer('pembayaran_nominal')->default(0);
            $table->string('pembayaran_status')->default('belum_bayar'); // 'belum_bayar', 'lunas'
            $table->string('pembayaran_keterangan')->nullable();
            $table->string('pembayaran_petugas')->nullable();
            $table->timestamp('pembayaran_verified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'kesehatan_tinggi_badan',
                'kesehatan_berat_badan',
                'kesehatan_tensi',
                'kesehatan_buta_warna',
                'kesehatan_tato_tindik',
                'kesehatan_riwayat_penyakit',
                'kesehatan_catatan',
                'kesehatan_petugas',
                'kesehatan_verified_at',

                'gaya_belajar_tipe',
                'gaya_belajar_minat_bakat',
                'gaya_belajar_catatan',
                'gaya_belajar_petugas',
                'gaya_belajar_verified_at',

                'wawancara_baca_tulis_alquran',
                'wawancara_solat_fardhu',
                'wawancara_kepribadian',
                'wawancara_catatan',
                'wawancara_petugas',
                'wawancara_verified_at',

                'pembayaran_nominal',
                'pembayaran_status',
                'pembayaran_keterangan',
                'pembayaran_petugas',
                'pembayaran_verified_at',
            ]);
        });
    }
};
