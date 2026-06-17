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
        Schema::create('siswa_akuns', function (Blueprint $table) {
            $table->id();
            $table->string('no_wa')->unique(); // Nomor WhatsApp (format: 628xxx)
            $table->string('password');
            $table->boolean('is_verified')->default(false);
            $table->string('otp_code', 6)->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->timestamp('last_otp_sent_at')->nullable();
            $table->string('tahun_aktif')->default('2026');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_akuns');
    }
};
