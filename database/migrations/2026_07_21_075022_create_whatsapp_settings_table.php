<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('api_key')->nullable()->comment('Token API Fonnte (dari dashboard fonnte.com)');
            $table->boolean('otp_via_log')->default(false)->comment('Mode dev: OTP hanya dicatat di log, tidak dikirim ke WA');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
    }
};
