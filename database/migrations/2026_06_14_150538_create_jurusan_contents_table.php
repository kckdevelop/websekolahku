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
        Schema::create('jurusan_contents', function (Blueprint $table) {
            $table->id();
            $table->string('slug'); // e.g. 'tkr', 'rpl', 'tpm'
            $table->string('nama_jurusan');
            $table->string('hero_gambar')->nullable();
            $table->string('hero_judul')->nullable();
            $table->string('hero_subjudul')->nullable();
            $table->text('deskripsi_1')->nullable();
            $table->text('deskripsi_2')->nullable();
            $table->text('poin_unggulan')->nullable(); // JSON array of strings
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurusan_contents');
    }
};
