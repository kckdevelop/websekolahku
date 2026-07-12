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
        Schema::table('tefa_products', function (Blueprint $table) {
            $table->unsignedInteger('urutan')->default(0)->after('aktif');
        });
    }

    public function down(): void
    {
        Schema::table('tefa_products', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }
};
