<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('SMK Muhammadiyah 1 Bantul');
            $table->string('singkatan')->default('SMK MUSABA');
            $table->string('logo')->nullable()->comment('Path logo utama sekolah di storage/public');
            $table->string('favicon')->nullable()->comment('Path favicon sekolah di storage/public');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
