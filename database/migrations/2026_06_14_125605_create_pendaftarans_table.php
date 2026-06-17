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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('no_daftar')->unique();
            $table->string('tahun_aktif')->default('2026');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('agama')->default('islam');
            $table->string('no_hp_siswa');
            $table->string('asal_sekolah');
            $table->text('alamat_sekolah')->nullable();
            $table->text('prestasi')->nullable();
            $table->string('nama_ortu');
            $table->string('pekerjaan_ortu');
            $table->string('no_hp_ortu');
            
            // Alamat Asal (KK)
            $table->string('jalan_asal')->nullable();
            $table->string('dusun_asal')->nullable();
            $table->string('rt_asal');
            $table->string('rw_asal')->nullable();
            $table->string('desa_asal');
            $table->string('kecamatan_asal');
            $table->string('kabupaten_asal');
            $table->string('provinsi_asal');

            // Alamat Tinggal Sekarang
            $table->string('jalan_tinggal')->nullable();
            $table->string('dusun_tinggal')->nullable();
            $table->string('rt_tinggal');
            $table->string('rw_tinggal')->nullable();
            $table->string('desa_tinggal');
            $table->string('kecamatan_tinggal');
            $table->string('kabupaten_tinggal');
            $table->string('provinsi_tinggal');

            // Pilihan Jurusan
            $table->string('pil1');
            $table->string('pil2');
            $table->string('pil3');

            // Berkas Upload (Optional)
            $table->string('foto_akta')->nullable();
            $table->string('foto_kk')->nullable();

            $table->enum('status', ['pending', 'verifikasi', 'diterima', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
