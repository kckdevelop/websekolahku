<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Foto siswa diambil via webcam oleh petugas
            $table->string('foto_siswa')->nullable()->after('foto_kk');
            // JSON array checklist kelengkapan berkas
            $table->json('berkas_lengkap')->nullable()->after('foto_siswa');
            // Catatan petugas
            $table->text('catatan_petugas')->nullable()->after('berkas_lengkap');
            // Tanggal verifikasi petugas
            $table->timestamp('verified_at')->nullable()->after('catatan_petugas');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn(['foto_siswa', 'berkas_lengkap', 'catatan_petugas', 'verified_at']);
        });
    }
};
