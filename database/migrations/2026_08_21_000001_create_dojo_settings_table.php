<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dojo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Dojo SMK Standar Industri');
            $table->string('hero_subtitle')->default('Pusat Pelatihan Keterampilan Teknis, Kedisiplinan & Keselamatan Kerja');
            $table->string('hero_gambar')->nullable();
            $table->text('deskripsi_utama')->nullable();

            // 3 Fungsi Utama Dojo
            $table->string('fungsi_1_judul')->default('Pelatihan Standar Industri');
            $table->text('fungsi_1_deskripsi')->nullable();
            $table->string('fungsi_2_judul')->default('Peningkatan Kompetensi');
            $table->text('fungsi_2_deskripsi')->nullable();
            $table->string('fungsi_3_judul')->default('Penanaman Budaya Kerja');
            $table->text('fungsi_3_deskripsi')->nullable();

            // 4 Unit Pelatihan
            $table->text('safety_deskripsi')->nullable();
            $table->text('welding_deskripsi')->nullable();
            $table->text('assembling_deskripsi')->nullable();
            $table->text('behavior_deskripsi')->nullable();

            // Informasi Kerja Sama
            $table->text('kerjasama_info')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dojo_settings');
    }
};
