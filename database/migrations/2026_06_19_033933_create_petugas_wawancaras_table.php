<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas_wawancaras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->nullable()->comment('Jabatan / bidang tugas');
            $table->string('nip')->nullable()->comment('NIP atau nomor induk petugas');
            $table->boolean('aktif')->default(true)->comment('Status aktif/non-aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas_wawancaras');
    }
};
