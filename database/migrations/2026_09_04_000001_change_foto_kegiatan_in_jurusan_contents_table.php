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
        Schema::table('jurusan_contents', function (Blueprint $table) {
            $table->longText('foto_kegiatan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurusan_contents', function (Blueprint $table) {
            $table->string('foto_kegiatan', 255)->nullable()->change();
        });
    }
};
