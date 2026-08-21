<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dojo_photos', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('unit_dojo')->default('Dojo Safety');
            $table->text('deskripsi')->nullable();
            $table->string('foto');
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dojo_photos');
    }
};
