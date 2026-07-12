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
        Schema::create('tefa_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Teaching Factory (Tefa)');
            $table->string('hero_subtitle')->default('Mengembangkan Keterampilan Nyata Melalui Produk & Jasa Berkualitas');
            $table->string('hero_gambar')->nullable();
            $table->string('tentang_judul')->default('Apa itu Tefa SMK Muhammadiyah 1 Bantul?');
            $table->text('tentang_deskripsi')->nullable();
            $table->string('telepon_wa')->nullable();
            $table->timestamps();
        });

        Schema::create('tefa_products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('harga')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tefa_products');
        Schema::dropIfExists('tefa_settings');
    }
};
