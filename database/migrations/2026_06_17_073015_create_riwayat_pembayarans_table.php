<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riwayat_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                  ->constrained('pendaftarans')
                  ->onDelete('cascade');
            $table->decimal('nominal', 12, 2)->comment('Jumlah yang dibayarkan pada transaksi ini');
            $table->string('keterangan')->nullable()->comment('Catatan/keterangan transaksi');
            $table->string('petugas')->comment('Nama petugas/kasir yang mencatat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembayarans');
    }
};
