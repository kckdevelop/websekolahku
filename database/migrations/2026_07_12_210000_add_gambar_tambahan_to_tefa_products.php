<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tefa_products', function (Blueprint $table) {
            // Menyimpan array path gambar tambahan (galeri produk)
            $table->json('gambar_tambahan')->nullable()->after('gambar')
                  ->comment('Array path gambar tambahan / galeri produk');
        });
    }

    public function down(): void
    {
        Schema::table('tefa_products', function (Blueprint $table) {
            $table->dropColumn('gambar_tambahan');
        });
    }
};
