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
        Schema::create('spmb_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('SPMB 2026/2027');
            $table->string('hero_subtitle')->default('Seleksi Penerimaan Peserta Didik Baru');
            $table->string('hero_gambar')->nullable();
            $table->string('kuota_tkro')->default('5 Kelas');
            $table->string('kuota_tbsm')->default('3 Kelas');
            $table->string('kuota_tpm')->default('3 Kelas');
            $table->string('kuota_tav')->default('2 Kelas');
            $table->string('kuota_rpl')->default('3 Kelas');
            $table->json('alur_pendaftaran');
            $table->json('persyaratan');
            $table->json('foto_galeri');
            $table->string('cta_title')->default('Siap Bergabung?');
            $table->string('cta_subtitle')->default('Daftar sekarang dan dapatkan bonus eksklusif untuk pendaftar awal!');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmb_page_contents');
    }
};
