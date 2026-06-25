<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ============================================================
 * CONSOLIDATED MIGRATION - SMK Muhammadiyah 1 Bantul
 * ============================================================
 * File ini menggabungkan SELURUH migration menjadi satu file
 * untuk kemudahan deployment ke hosting / server baru.
 *
 * Gunakan file ini HANYA pada database yang KOSONG / fresh.
 * Jalankan dengan: php artisan migrate
 *
 * Dibuat: 2026-06-25
 * ============================================================
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. USERS ─────────────────────────────────────────
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('admin')
                  ->comment('admin | petugas | petugas_kesehatan | petugas_wawancara | petugas_pembayaran');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // ── 2. CACHE & JOBS ──────────────────────────────────
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // ── 3. PERSONAL ACCESS TOKENS (Sanctum) ──────────────
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // ── 4. SISWA AKUN ────────────────────────────────────
        Schema::create('siswa_akuns', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->timestamps();
        });

        // ── 5. SPMB GELOMBANG ─────────────────────────────────
        Schema::create('spmb_gelombangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gelombang');
            $table->unsignedTinyInteger('kode_gelombang')->nullable()
                  ->comment('Kode angka gelombang (1,2,3,...) untuk nomor pendaftaran MSBxx-WW-NNN');
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->boolean('is_aktif')->default(false);
            $table->text('keterangan')->nullable();
            $table->decimal('biaya_pendaftaran', 12, 2)->default(0)
                  ->comment('Biaya pendaftaran default gelombang ini');
            $table->decimal('biaya_spp_default', 12, 2)->default(0)
                  ->comment('Nominal SPP default gelombang ini');
            $table->decimal('biaya_zakat_default', 12, 2)->default(0)
                  ->comment('Nominal zakat/biaya pendidikan default');
            $table->decimal('potongan_subsidi', 12, 2)->default(0)
                  ->comment('Nominal potongan subsidi sekolah');
            $table->timestamps();
        });

        // ── 6. PETUGAS WAWANCARA ──────────────────────────────
        Schema::create('petugas_wawancaras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ── 7. PENDAFTARAN (tabel utama) ──────────────────────
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();

            // Identitas & Referensi
            $table->string('no_daftar')->unique();
            $table->string('nomor_pembayaran')->nullable();
            $table->string('tahun_aktif', 4)->nullable();
            $table->string('gelombang')->nullable();
            $table->foreignId('siswa_akun_id')->nullable()->constrained('siswa_akuns')->nullOnDelete();
            $table->foreignId('petugas_wawancara_id')->nullable()
                  ->references('id')->on('petugas_wawancaras')->nullOnDelete()
                  ->comment('ID petugas pewawancara');

            // Data Siswa
            $table->string('nama_lengkap');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 1)->nullable()->comment('L atau P');
            $table->string('agama')->nullable();
            $table->string('no_hp_siswa')->nullable();
            $table->string('nik')->nullable();
            $table->string('no_kk')->nullable();
            $table->string('asal_sekolah')->nullable();
            $table->string('alamat_sekolah')->nullable();
            $table->string('nilai_rata_rata')->nullable();
            $table->text('prestasi')->nullable();
            $table->string('status_yatim_piatu')->default('normal')
                  ->comment('normal | yatim | piatu | yatim_piatu');
            $table->string('ukuran_seragam')->nullable();

            // Data Orang Tua
            $table->string('nama_ortu')->nullable();
            $table->string('pekerjaan_ortu')->nullable();
            $table->string('no_hp_ortu')->nullable();

            // Alamat Asal
            $table->string('jalan_asal')->nullable();
            $table->string('dusun_asal')->nullable();
            $table->string('rt_asal')->nullable();
            $table->string('rw_asal')->nullable();
            $table->string('desa_asal')->nullable();
            $table->string('kecamatan_asal')->nullable();
            $table->string('kabupaten_asal')->nullable();
            $table->string('provinsi_asal')->nullable();

            // Alamat Tinggal
            $table->string('jalan_tinggal')->nullable();
            $table->string('dusun_tinggal')->nullable();
            $table->string('rt_tinggal')->nullable();
            $table->string('rw_tinggal')->nullable();
            $table->string('desa_tinggal')->nullable();
            $table->string('kecamatan_tinggal')->nullable();
            $table->string('kabupaten_tinggal')->nullable();
            $table->string('provinsi_tinggal')->nullable();

            // Pilihan Jurusan
            $table->string('pil1')->nullable();
            $table->string('pil2')->nullable();
            $table->string('pil3')->nullable();
            $table->string('jurusan_diterima')->nullable();

            // Berkas Upload
            $table->string('foto_siswa')->nullable();
            $table->string('berkas_ijazah')->nullable();
            $table->string('berkas_kk')->nullable();
            $table->string('berkas_akta')->nullable();
            $table->string('berkas_kip')->nullable();
            $table->string('berkas_raport')->nullable();

            // Status Pendaftaran
            $table->string('status')->default('pending')
                  ->comment('pending | verifikasi | diterima | ditolak | mengundurkan_diri');

            // Tes Kesehatan
            $table->string('kesehatan_tinggi_badan')->nullable();
            $table->string('kesehatan_berat_badan')->nullable();
            $table->string('kesehatan_golongan_darah')->nullable();
            $table->string('kesehatan_buta_warna')->nullable();
            $table->string('kesehatan_mata_minus')->nullable();
            $table->string('kesehatan_tato_tindik')->nullable();
            $table->text('kesehatan_riwayat_penyakit')->nullable();
            $table->text('kesehatan_catatan')->nullable();
            $table->string('kesehatan_petugas')->nullable();
            $table->timestamp('kesehatan_verified_at')->nullable();

            // Gaya Belajar
            $table->string('gaya_belajar_tipe')->nullable()->comment('visual | auditori | kinestetik');
            $table->text('gaya_belajar_minat_bakat')->nullable();
            $table->text('gaya_belajar_catatan')->nullable();
            $table->string('gaya_belajar_petugas')->nullable();
            $table->timestamp('gaya_belajar_verified_at')->nullable();

            // Wawancara
            $table->text('wawancara_baca_tulis_alquran')->nullable();
            $table->text('wawancara_solat_fardhu')->nullable();
            $table->text('wawancara_kepribadian')->nullable();
            $table->text('wawancara_catatan')->nullable();
            $table->string('wawancara_petugas')->nullable();
            $table->timestamp('wawancara_verified_at')->nullable();

            // Pembayaran
            $table->integer('pembayaran_nominal')->default(0);
            $table->string('pembayaran_status')->default('belum_bayar')
                  ->comment('belum_bayar | lunas');
            $table->string('pembayaran_keterangan')->nullable();
            $table->string('pembayaran_petugas')->nullable();
            $table->timestamp('pembayaran_verified_at')->nullable();

            // Biaya (dari wawancara)
            $table->decimal('biaya_spp', 12, 2)->nullable()
                  ->comment('Nominal SPP yang ditetapkan saat wawancara');
            $table->decimal('biaya_zakat', 12, 2)->nullable()
                  ->comment('Nominal zakat/infaq/biaya pendidikan');
            $table->decimal('biaya_potongan', 12, 2)->default(0)
                  ->comment('Potongan subsidi dari gelombang');
            $table->decimal('total_tagihan', 12, 2)->nullable()
                  ->comment('Total tagihan = SPP + Zakat - Potongan');
            $table->string('biaya_petugas')->nullable()
                  ->comment('Petugas yang menetapkan biaya');
            $table->timestamp('biaya_verified_at')->nullable()
                  ->comment('Waktu penetapan biaya');

            $table->timestamps();
        });

        // ── 8. RIWAYAT PEMBAYARAN ─────────────────────────────
        Schema::create('riwayat_pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                  ->constrained('pendaftarans')
                  ->onDelete('cascade');
            $table->decimal('nominal', 12, 2)->comment('Jumlah yang dibayarkan');
            $table->string('keterangan')->nullable()->comment('Catatan transaksi');
            $table->string('petugas')->comment('Nama petugas/kasir yang mencatat');
            $table->timestamps();
        });

        // ── 9. BERITA ─────────────────────────────────────────
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('konten');
            $table->string('gambar')->nullable();
            $table->date('tanggal');
            $table->boolean('draft')->default(false);
            $table->timestamps();
        });

        // ── 10. PRESTASI ──────────────────────────────────────
        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable();
            $table->string('tingkat')->nullable()
                  ->comment('kecamatan | kabupaten | provinsi | nasional | internasional');
            $table->string('peraih')->nullable();
            $table->string('foto')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });

        // ── 11. GALERI FOTO ───────────────────────────────────
        Schema::create('galeri_fotos', function (Blueprint $table) {
            $table->id();
            $table->string('folder_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // ── 12. GALERI VIDEO ──────────────────────────────────
        Schema::create('galeri_videos', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('youtube_id');
            $table->string('kategori')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('views')->default(0);
            $table->string('durasi')->nullable();
            $table->timestamps();
        });

        // ── 13. TESTIMONI ─────────────────────────────────────
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alumni_tahun', 4)->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('kutipan');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // ── 14. HERO SLIDES ───────────────────────────────────
        Schema::create('heros', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('label_tombol')->nullable();
            $table->string('link_tombol')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ── 15. JURUSAN CONTENT ───────────────────────────────
        Schema::create('jurusan_contents', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jurusan')->unique()
                  ->comment('tkr | tbsm | tpm | tav | rpl');
            $table->string('nama_jurusan');
            $table->string('hero_gambar')->nullable();
            $table->string('hero_judul')->nullable();
            $table->string('hero_subjudul')->nullable();
            $table->text('deskripsi_1')->nullable();
            $table->text('deskripsi_2')->nullable();
            $table->json('poin_unggulan')->nullable();
            $table->json('kompetensi')->nullable();
            $table->json('fasilitas')->nullable();
            $table->json('peluang_karir')->nullable();
            $table->string('foto_kegiatan')->nullable()
                  ->comment('Foto kegiatan/praktikum jurusan');
            $table->timestamps();
        });

        // ── 16. SAMBUTAN KEPALA SEKOLAH ───────────────────────
        Schema::create('sambutans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kepala_sekolah');
            $table->string('foto')->nullable();
            $table->text('isi_sambutan');
            $table->timestamps();
        });

        // ── 17. MITRA ─────────────────────────────────────────
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        // ── 18. NOBOX SETTINGS ────────────────────────────────
        Schema::create('nobox_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('aktif')->default(false);
            $table->string('gambar')->nullable();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });

        // ── 19. PESAN KONTAK ──────────────────────────────────
        Schema::create('pesans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email');
            $table->string('subjek');
            $table->text('pesan');
            $table->timestamps();
        });

        // ── 20. SPMB PAGE CONTENT ─────────────────────────────
        Schema::create('spmb_page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('SPMB 2026/2027');
            $table->string('hero_subtitle')->default('Seleksi Penerimaan Peserta Didik Baru');
            $table->string('hero_gambar')->nullable();
            $table->string('kuota_tkro')->default('5 Kelas');
            $table->string('kuota_tbsm')->default('3 Kelas');
            $table->string('kuota_tpm')->default('3 Kelas');
            $table->string('kuota_tav')->default('2 Kelas');
            $table->string('kuota_rpl')->default('3 Kelas');
            $table->json('alur_pendaftaran');
            $table->json('persyaratan');
            $table->json('foto_galeri');
            $table->string('cta_title')->default('Siap Bergabung?');
            $table->string('cta_subtitle')->default('Daftar sekarang dan dapatkan bonus eksklusif untuk pendaftar awal!');
            $table->timestamps();
        });

        // ── 21. BKK SETTINGS ──────────────────────────────────
        Schema::create('bkk_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('Bursa Kerja Khusus (BKK)');
            $table->string('hero_subtitle')->default('Jembatan karir lulusan SMK Muhammadiyah 1 Bantul menuju dunia kerja profesional');
            $table->string('hero_gambar')->nullable();
            $table->string('tentang_judul')->default('Tentang BKK SMK Muh. 1 Bantul');
            $table->text('tentang_deskripsi')->nullable();
            $table->json('statistik')->nullable()->comment('[{label, nilai, ikon}]');
            $table->json('layanan')->nullable()->comment('[{judul, deskripsi, ikon}]');
            $table->json('mitra_perusahaan')->nullable()->comment('[{nama, logo}]');
            $table->string('kontak_nama')->nullable();
            $table->string('kontak_telepon')->nullable();
            $table->string('kontak_email')->nullable();
            $table->string('kontak_jam_operasional')->nullable();
            $table->string('kontak_lokasi')->nullable();
            $table->string('cta_title')->default('Siap Memasuki Dunia Kerja?');
            $table->string('cta_subtitle')->default('Hubungi BKK kami dan temukan peluang karir terbaik untuk Anda.');
            $table->timestamps();
        });

        // ── 22. LOWONGAN KERJA ────────────────────────────────
        Schema::create('lowongan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('logo_perusahaan')->nullable();
            $table->string('posisi');
            $table->string('lokasi');
            $table->string('tipe_pekerjaan')->default('Full Time')
                  ->comment('Full Time | Part Time | Magang | Kontrak');
            $table->string('jurusan_relevan')->nullable()
                  ->comment('TKR | TBSM | RPL | dll atau "Semua Jurusan"');
            $table->date('batas_lamaran');
            $table->text('deskripsi')->nullable();
            $table->string('brosur')->nullable();
            $table->json('persyaratan')->nullable()->comment('Array of strings');
            $table->string('kontak_lamaran')->nullable()->comment('email / WA / link');
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Hapus dalam urutan terbalik (foreign key constraint)
        Schema::dropIfExists('lowongan_kerjas');
        Schema::dropIfExists('bkk_settings');
        Schema::dropIfExists('spmb_page_contents');
        Schema::dropIfExists('pesans');
        Schema::dropIfExists('nobox_settings');
        Schema::dropIfExists('mitras');
        Schema::dropIfExists('sambutans');
        Schema::dropIfExists('jurusan_contents');
        Schema::dropIfExists('heros');
        Schema::dropIfExists('testimonis');
        Schema::dropIfExists('galeri_videos');
        Schema::dropIfExists('galeri_fotos');
        Schema::dropIfExists('prestasis');
        Schema::dropIfExists('beritas');
        Schema::dropIfExists('riwayat_pembayarans');
        Schema::dropIfExists('pendaftarans');
        Schema::dropIfExists('petugas_wawancaras');
        Schema::dropIfExists('spmb_gelombangs');
        Schema::dropIfExists('siswa_akuns');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
