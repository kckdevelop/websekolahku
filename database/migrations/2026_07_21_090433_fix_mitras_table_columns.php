<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mitras', function (Blueprint $table) {
            if (!Schema::hasColumn('mitras', 'logo_url')) {
                $table->string('logo_url')->nullable()->after('logo');
            }
            if (Schema::hasColumn('mitras', 'website') && !Schema::hasColumn('mitras', 'link')) {
                $table->renameColumn('website', 'link');
            } elseif (!Schema::hasColumn('mitras', 'link')) {
                $table->string('link')->nullable()->after('logo_url');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mitras', function (Blueprint $table) {
            if (Schema::hasColumn('mitras', 'logo_url')) {
                $table->dropColumn('logo_url');
            }
            if (Schema::hasColumn('mitras', 'link') && !Schema::hasColumn('mitras', 'website')) {
                $table->renameColumn('link', 'website');
            }
        });
    }
};
