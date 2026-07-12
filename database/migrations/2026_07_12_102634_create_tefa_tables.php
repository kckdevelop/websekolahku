<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Settings / content page
        if (!Schema::hasTable('tefa_settings')) {
            Schema::create('tefa_settings', function (Blueprint $table) {
                $table->id();
                $table->string('hero_title')->default('Teaching Factory (Tefa)');
                $table->string('hero_subtitle')->default('Unit produksi berbasis kompetensi yang menghasilkan produk dan jasa berkualitas industri');
                $table->string('hero_gambar')->nullable();
                $table->string('tentang_judul')->default('Apa itu Teaching Factory?');
                $table->text('tentang_deskripsi')->nullable();
                $table->string('telepon_wa')->nullable();
                $table->timestamps();
            });
        }

        // Products catalog
        if (!Schema::hasTable('tefa_products')) {
            Schema::create('tefa_products', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->text('deskripsi')->nullable();
                $table->unsignedBigInteger('harga')->nullable();
                $table->string('gambar')->nullable();
                $table->boolean('aktif')->default(true);
                $table->unsignedInteger('urutan')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tefa_products');
        Schema::dropIfExists('tefa_settings');
    }
};

