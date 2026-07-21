<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('heros', function (Blueprint $table) {
            if (!Schema::hasColumn('heros', 'gambar_url')) {
                $table->string('gambar_url')->nullable()->after('gambar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('heros', function (Blueprint $table) {
            if (Schema::hasColumn('heros', 'gambar_url')) {
                $table->dropColumn('gambar_url');
            }
        });
    }
};
