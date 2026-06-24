<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bkk_settings', function (Blueprint $table) {
            $table->id();
            // Hero Section
            $table->string('hero_title')->default('Bursa Kerja Khusus (BKK)');
            $table->string('hero_subtitle')->default('Jembatan karir lulusan SMK Muhammadiyah 1 Bantul menuju dunia kerja profesional');
            $table->string('hero_gambar')->nullable();

            // Tentang BKK
            $table->string('tentang_judul')->default('Tentang BKK SMK Muh. 1 Bantul');
            $table->text('tentang_deskripsi')->nullable();
            $table->json('statistik')->nullable(); // [{label, nilai, ikon}]

            // Layanan BKK
            $table->json('layanan')->nullable(); // [{judul, deskripsi, ikon}]

            // Mitra Perusahaan
            $table->json('mitra_perusahaan')->nullable(); // [{nama, logo}]

            // Kontak BKK
            $table->string('kontak_nama')->nullable();
            $table->string('kontak_telepon')->nullable();
            $table->string('kontak_email')->nullable();
            $table->string('kontak_jam_operasional')->nullable();
            $table->string('kontak_lokasi')->nullable();

            // CTA
            $table->string('cta_title')->default('Siap Memasuki Dunia Kerja?');
            $table->string('cta_subtitle')->default('Hubungi BKK kami dan temukan peluang karir terbaik untuk Anda.');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bkk_settings');
    }
};
