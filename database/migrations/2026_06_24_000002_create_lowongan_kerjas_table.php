<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('logo_perusahaan')->nullable();
            $table->string('posisi');
            $table->string('lokasi');
            $table->string('tipe_pekerjaan')->default('Full Time'); // Full Time, Part Time, Magang, Kontrak
            $table->string('jurusan_relevan')->nullable(); // TKR, TBSM, RPL, dll atau 'Semua Jurusan'
            $table->date('batas_lamaran');
            $table->text('deskripsi')->nullable();
            $table->json('persyaratan')->nullable(); // array of strings
            $table->string('kontak_lamaran')->nullable(); // email/WA/link
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan_kerjas');
    }
};
