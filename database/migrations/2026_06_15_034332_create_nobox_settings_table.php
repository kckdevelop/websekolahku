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
        Schema::create('nobox_settings', function (Blueprint $table) {
            $table->id();
            $table->string('account_ids')->nullable();
            $table->string('api_key')->nullable();
            $table->string('channel_id')->default('1');
            $table->string('url')->default('https://id.nobox.ai');
            $table->boolean('otp_via_log')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nobox_settings');
    }
};
