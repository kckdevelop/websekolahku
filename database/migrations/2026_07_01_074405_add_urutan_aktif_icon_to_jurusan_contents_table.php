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
            $table->integer('urutan')->default(0)->after('slug');
            $table->boolean('aktif')->default(true)->after('urutan');
            $table->string('icon')->nullable()->default('fas fa-graduation-cap')->after('nama_jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jurusan_contents', function (Blueprint $table) {
            $table->dropColumn(['urutan', 'aktif', 'icon']);
        });
    }
};
