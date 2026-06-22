<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Buku Panduan Aplikasi Web Sekolah & SPMB</title>
<style>
/* ================================================
   BASE STYLES
   ================================================ */
@page { margin: 1.8cm 1.8cm 2cm 1.8cm; }
body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 10pt;
    line-height: 1.6;
    color: #1e293b;
    background: #fff;
    margin: 0; padding: 0;
}
.page-break { page-break-after: always; }
.clearfix::after { content:''; display:table; clear:both; }

/* ================================================
   RUNNING HEADER / FOOTER
   ================================================ */
.doc-header {
    position: fixed; top: -50px; left:0; right:0; height:28px;
    border-bottom: 2px solid #2563eb;
    font-size: 8pt; color: #64748b;
    display: flex; justify-content: space-between; align-items: center;
}
.doc-footer {
    position: fixed; bottom: -50px; left:0; right:0; height:28px;
    border-top: 1px solid #e2e8f0;
    font-size: 8pt; color: #64748b;
    display: flex; justify-content: space-between; align-items: center;
}

/* ================================================
   COVER PAGE
   ================================================ */
.cover {
    text-align: center;
    padding: 0;
    height: 100%;
    background: #fff;
}
.cover-top-bar {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    color: #fff;
    padding: 40px 30px 50px;
    margin: -10px -10px 0 -10px;
}
.cover-icon {
    font-size: 42pt;
    margin-bottom: 15px;
    display: block;
}
.cover-title {
    font-size: 22pt;
    font-weight: bold;
    line-height: 1.3;
    margin-bottom: 8px;
    color: #fff;
}
.cover-subtitle {
    font-size: 13pt;
    color: #bfdbfe;
    margin-bottom: 0;
}
.cover-body {
    padding: 35px 20px;
}
.cover-desc {
    font-size: 11pt;
    color: #475569;
    line-height: 1.7;
    margin-bottom: 35px;
    text-align: center;
}
.cover-versions-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 9.5pt;
}
.cover-versions-table th {
    background: #eff6ff;
    color: #1e40af;
    border: 1px solid #bfdbfe;
    padding: 7px 10px;
    text-align: left;
    font-weight: bold;
}
.cover-versions-table td {
    border: 1px solid #e2e8f0;
    padding: 7px 10px;
    vertical-align: top;
}
.cover-roles {
    display: table;
    width: 100%;
    margin: 25px 0;
}
.cover-role-item {
    display: table-cell;
    width: 20%;
    text-align: center;
    padding: 12px 5px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}
.cover-role-icon { font-size: 18pt; display: block; margin-bottom: 5px; }
.cover-role-name { font-size: 8pt; font-weight: bold; color: #1e3a8a; }
.cover-role-sub  { font-size: 7.5pt; color: #64748b; }
.cover-footer-meta {
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    font-size: 9.5pt;
    color: #64748b;
    line-height: 2;
}
.cover-footer-meta strong { color: #1e293b; }

/* ================================================
   TOC
   ================================================ */
.toc-title {
    font-size: 18pt;
    font-weight: bold;
    color: #1e3a8a;
    border-bottom: 3px solid #2563eb;
    padding-bottom: 8px;
    margin-bottom: 25px;
}
.toc-section { margin-bottom: 4px; }
.toc-section-title {
    font-size: 11pt;
    font-weight: bold;
    color: #1e3a8a;
    display: inline-block;
    width: 80%;
}
.toc-page { float: right; font-size: 10pt; color: #64748b; }
.toc-sub {
    padding-left: 20px;
    font-size: 9.5pt;
    color: #475569;
    margin: 3px 0;
}
.toc-separator {
    border: none;
    border-top: 1px dashed #e2e8f0;
    margin: 6px 0;
}
.toc-chapter-header {
    background: #eff6ff;
    border-left: 4px solid #2563eb;
    padding: 6px 12px;
    margin: 15px 0 8px;
    font-size: 10pt;
    font-weight: bold;
    color: #1e40af;
}

/* ================================================
   CHAPTER & SECTION HEADINGS
   ================================================ */
.chapter-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    color: #fff;
    padding: 18px 20px;
    margin: -5px -5px 25px;
    border-radius: 0;
}
.chapter-number {
    font-size: 9pt;
    color: #93c5fd;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 4px;
}
.chapter-title {
    font-size: 18pt;
    font-weight: bold;
    color: #fff;
    margin: 0;
}
.chapter-desc {
    font-size: 10pt;
    color: #bfdbfe;
    margin-top: 5px;
}

h2 {
    font-size: 14pt;
    color: #1e3a8a;
    border-left: 4px solid #2563eb;
    padding: 6px 12px;
    background: #eff6ff;
    margin: 25px 0 12px;
}
h3 {
    font-size: 11.5pt;
    color: #0f172a;
    margin: 18px 0 8px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 4px;
}
h4 {
    font-size: 10.5pt;
    color: #1e40af;
    margin: 14px 0 6px;
}
p { margin: 0 0 10px; text-align: justify; }
ul, ol { margin: 0 0 12px; padding-left: 20px; }
li { margin-bottom: 5px; text-align: justify; }

/* ================================================
   CALLOUT / ALERT BOXES
   ================================================ */
.callout {
    padding: 10px 14px;
    margin: 12px 0;
    border-radius: 0 5px 5px 0;
    font-size: 9.5pt;
}
.callout-info {
    background: #eff6ff;
    border-left: 4px solid #2563eb;
}
.callout-success {
    background: #f0fdf4;
    border-left: 4px solid #22c55e;
}
.callout-warning {
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
}
.callout-danger {
    background: #fff1f2;
    border-left: 4px solid #ef4444;
}
.callout-title {
    font-weight: bold;
    margin-bottom: 4px;
    font-size: 10pt;
}
.callout-info    .callout-title { color: #1e40af; }
.callout-success .callout-title { color: #15803d; }
.callout-warning .callout-title { color: #92400e; }
.callout-danger  .callout-title { color: #b91c1c; }

/* ================================================
   TABLES
   ================================================ */
table.std-table {
    width: 100%;
    border-collapse: collapse;
    margin: 12px 0 20px;
    font-size: 9.5pt;
}
table.std-table th {
    background: #1e3a8a;
    color: #fff;
    padding: 8px 10px;
    text-align: left;
    font-weight: bold;
}
table.std-table td {
    border: 1px solid #cbd5e1;
    padding: 7px 10px;
    vertical-align: top;
}
table.std-table tr:nth-child(even) td { background: #f8fafc; }

/* ================================================
   STEP BOXES (numbered workflow steps)
   ================================================ */
.steps-container { margin: 14px 0; }
.step-item {
    display: table;
    width: 100%;
    margin-bottom: 10px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
}
.step-number {
    display: table-cell;
    width: 36px;
    background: #2563eb;
    color: #fff;
    font-size: 14pt;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
    padding: 12px 8px;
}
.step-content {
    display: table-cell;
    padding: 10px 14px;
    vertical-align: top;
    background: #f8fafc;
}
.step-content-title {
    font-weight: bold;
    color: #1e3a8a;
    font-size: 10.5pt;
    margin-bottom: 3px;
}
.step-content-desc { font-size: 9.5pt; color: #475569; }

/* ================================================
   SCREENSHOT / IMAGE FRAMES
   ================================================ */
.screenshot-container {
    margin: 14px 0;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    overflow: hidden;
}
.screenshot-topbar {
    background: #334155;
    padding: 6px 12px;
    font-size: 8.5pt;
    color: #cbd5e1;
}
.screenshot-topbar .dots { color: #94a3b8; margin-right: 8px; }
.screenshot-img {
    display: block;
    width: 100%;
    border-top: 1px solid #e2e8f0;
}
.screenshot-caption {
    background: #f1f5f9;
    padding: 6px 12px;
    font-size: 8.5pt;
    color: #64748b;
    border-top: 1px solid #e2e8f0;
    font-style: italic;
}

/* ================================================
   FIELD / INPUT REFERENCE CARDS
   ================================================ */
.field-card {
    border: 1px solid #e2e8f0;
    border-radius: 5px;
    margin-bottom: 8px;
    overflow: hidden;
}
.field-name {
    background: #f1f5f9;
    padding: 5px 10px;
    font-weight: bold;
    font-size: 9.5pt;
    color: #0f172a;
    border-bottom: 1px solid #e2e8f0;
}
.field-desc {
    padding: 6px 10px;
    font-size: 9pt;
    color: #475569;
}
.field-req {
    display: inline-block;
    padding: 1px 6px;
    border-radius: 3px;
    font-size: 7.5pt;
    font-weight: bold;
    float: right;
}
.field-req-wajib  { background: #fee2e2; color: #b91c1c; }
.field-req-opsional { background: #f0fdf4; color: #166534; }

/* ================================================
   BADGE / STATUS PILLS
   ================================================ */
.badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 8pt;
    font-weight: bold;
}
.badge-pending  { background: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
.badge-verified { background: #dbeafe; color: #1e40af; border: 1px solid #93c5fd; }
.badge-accepted { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
.badge-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

/* ================================================
   ROLE HEADER BANNER
   ================================================ */
.role-banner {
    padding: 14px 18px;
    border-radius: 6px;
    margin-bottom: 18px;
    display: table;
    width: 100%;
}
.role-banner-icon {
    display: table-cell;
    width: 50px;
    font-size: 26pt;
    vertical-align: middle;
    text-align: center;
}
.role-banner-content { display: table-cell; vertical-align: middle; padding-left: 10px; }
.role-banner-title   { font-size: 14pt; font-weight: bold; margin-bottom: 2px; }
.role-banner-sub     { font-size: 9pt; opacity: 0.8; }
.role-admin    { background: #1e3a8a; color: #fff; }
.role-petugas  { background: #0f766e; color: #fff; }
.role-kesehatan{ background: #7c3aed; color: #fff; }
.role-wawancara{ background: #c2410c; color: #fff; }
.role-pembayaran{ background: #0369a1; color: #fff; }
.role-siswa    { background: #15803d; color: #fff; }

/* Layout helpers */
.two-col { display: table; width: 100%; margin-bottom: 12px; }
.col-left  { display: table-cell; width: 48%; vertical-align: top; padding-right: 10px; }
.col-right { display: table-cell; width: 48%; vertical-align: top; padding-left: 10px; }
.highlight { background: #fef9c3; padding: 1px 4px; border-radius: 3px; font-weight: bold; }
.kbd { background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 3px; padding: 1px 5px; font-family: monospace; font-size: 9pt; }
.url-box { background: #0f172a; color: #7dd3fc; padding: 8px 12px; border-radius: 4px; font-family: monospace; font-size: 9.5pt; margin: 8px 0; }
.divider  { border: none; border-top: 2px solid #e2e8f0; margin: 25px 0; }
</style>
</head>
<body>

{{-- ============================================================ --}}
{{-- RUNNING HEADER / FOOTER                                      --}}
{{-- ============================================================ --}}
<div class="doc-header">
    <span style="padding-left:4px">📘 Buku Panduan Aplikasi Web Sekolah &amp; SPMB — SMK Muhammadiyah 1 Bantul</span>
    <span style="padding-right:4px">Versi 1.0 · {{ date('Y') }}</span>
</div>
<div class="doc-footer">
    <span style="padding-left:4px">Dokumen ini bersifat rahasia dan hanya untuk pengguna sistem terdaftar.</span>
    <span style="padding-right:4px">Halaman <span style="font-weight:bold" class="page-number"></span></span>
</div>

{{-- ============================================================ --}}
{{-- COVER PAGE                                                   --}}
{{-- ============================================================ --}}
<div class="cover">
    <div class="cover-top-bar">
        <div class="cover-icon">📘</div>
        <div class="cover-title">BUKU PANDUAN PENGGUNA<br>APLIKASI WEB SEKOLAH &amp; SPMB</div>
        <div class="cover-subtitle">Sistem Informasi Sekolah Integratif — SMK Muhammadiyah 1 Bantul</div>
    </div>
    <div class="cover-body">
        <p class="cover-desc">
            Panduan lengkap penggunaan sistem untuk seluruh peran pengguna:<br>
            Administrator, Petugas Pendaftaran, Petugas Kesehatan,<br>
            Petugas Wawancara, Petugas Pembayaran, dan Calon Siswa.
        </p>

        {{-- Role icons --}}
        <table style="width:100%; border-collapse:separate; border-spacing:6px; margin:20px 0;">
            <tr>
                <td style="text-align:center; background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px; padding:14px 8px; width:16%;">
                    <div style="font-size:20pt;">👑</div>
                    <div style="font-size:8.5pt; font-weight:bold; color:#1e40af; margin-top:5px;">Admin</div>
                    <div style="font-size:7.5pt; color:#64748b;">Kontrol Penuh</div>
                </td>
                <td style="text-align:center; background:#f0fdf4; border:1px solid #86efac; border-radius:8px; padding:14px 8px; width:16%;">
                    <div style="font-size:20pt;">📋</div>
                    <div style="font-size:8.5pt; font-weight:bold; color:#166534; margin-top:5px;">Petugas<br>Pendaftaran</div>
                    <div style="font-size:7.5pt; color:#64748b;">Front Office</div>
                </td>
                <td style="text-align:center; background:#faf5ff; border:1px solid #d8b4fe; border-radius:8px; padding:14px 8px; width:16%;">
                    <div style="font-size:20pt;">🩺</div>
                    <div style="font-size:8.5pt; font-weight:bold; color:#7c3aed; margin-top:5px;">Petugas<br>Kesehatan</div>
                    <div style="font-size:7.5pt; color:#64748b;">UKS</div>
                </td>
                <td style="text-align:center; background:#fff7ed; border:1px solid #fdba74; border-radius:8px; padding:14px 8px; width:16%;">
                    <div style="font-size:20pt;">🎤</div>
                    <div style="font-size:8.5pt; font-weight:bold; color:#c2410c; margin-top:5px;">Petugas<br>Wawancara</div>
                    <div style="font-size:7.5pt; color:#64748b;">BK / Penguji</div>
                </td>
                <td style="text-align:center; background:#eff6ff; border:1px solid #93c5fd; border-radius:8px; padding:14px 8px; width:16%;">
                    <div style="font-size:20pt;">💳</div>
                    <div style="font-size:8.5pt; font-weight:bold; color:#0369a1; margin-top:5px;">Petugas<br>Pembayaran</div>
                    <div style="font-size:7.5pt; color:#64748b;">Keuangan</div>
                </td>
                <td style="text-align:center; background:#fef9c3; border:1px solid #fde047; border-radius:8px; padding:14px 8px; width:16%;">
                    <div style="font-size:20pt;">🎓</div>
                    <div style="font-size:8.5pt; font-weight:bold; color:#854d0e; margin-top:5px;">Calon<br>Siswa</div>
                    <div style="font-size:7.5pt; color:#64748b;">Pendaftar</div>
                </td>
            </tr>
        </table>

        <table class="cover-versions-table">
            <tr>
                <th>Versi Dokumen</th>
                <th>Tanggal Rilis</th>
                <th>Platform</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><strong>1.0.0</strong></td>
                <td>{{ date('d F Y') }}</td>
                <td>Web Browser (Laravel {{ app()->version() }})</td>
                <td><span class="badge badge-accepted">Aktif</span></td>
            </tr>
        </table>

        <div class="cover-footer-meta">
            <strong>Diterbitkan oleh:</strong> Tim IT SMK Muhammadiyah 1 Bantul &nbsp;|&nbsp;
            <strong>URL Sistem:</strong> <span style="font-family:monospace; color:#2563eb;">http://[domain-sekolah]/</span><br>
            Harap simpan dokumen ini dengan baik. Jangan disebarluaskan kepada pihak yang tidak berkepentingan.
        </div>
    </div>
</div>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- DAFTAR ISI                                                   --}}
{{-- ============================================================ --}}
<div class="toc-title">Daftar Isi</div>

<div class="toc-chapter-header">Pendahuluan &amp; Informasi Umum</div>
<div class="toc-section">
    <span class="toc-section-title">BAB 1 — Pengenalan Sistem</span>
    <span class="toc-page">3</span>
</div>
<div class="toc-sub">1.1 Deskripsi Aplikasi &nbsp;·&nbsp; 1.2 Arsitektur Sistem &nbsp;·&nbsp; 1.3 Persyaratan Perangkat &nbsp;·&nbsp; 1.4 Alur Kerja Umum</div>
<hr class="toc-separator">

<div class="toc-chapter-header">Akses &amp; Login</div>
<div class="toc-section">
    <span class="toc-section-title">BAB 2 — Cara Login ke Sistem</span>
    <span class="toc-page">5</span>
</div>
<div class="toc-sub">2.1 Halaman Login &nbsp;·&nbsp; 2.2 Username &amp; Password &nbsp;·&nbsp; 2.3 Lupa Password &nbsp;·&nbsp; 2.4 Logout</div>
<hr class="toc-separator">

<div class="toc-chapter-header">Panel Administrator</div>
<div class="toc-section">
    <span class="toc-section-title">BAB 3 — Panduan Administrator</span>
    <span class="toc-page">7</span>
</div>
<div class="toc-sub">3.1 Dashboard &nbsp;·&nbsp; 3.2 Kelola Berita &amp; Prestasi &nbsp;·&nbsp; 3.3 Kelola Galeri &nbsp;·&nbsp; 3.4 Kelola Gelombang SPMB &nbsp;·&nbsp; 3.5 Manajemen User &nbsp;·&nbsp; 3.6 Laporan &amp; Ekspor</div>
<hr class="toc-separator">

<div class="toc-chapter-header">Panel Petugas</div>
<div class="toc-section">
    <span class="toc-section-title">BAB 4 — Panduan Petugas Pendaftaran</span>
    <span class="toc-page">12</span>
</div>
<div class="toc-sub">4.1 Dashboard &nbsp;·&nbsp; 4.2 Verifikasi Berkas &nbsp;·&nbsp; 4.3 Upload Foto Siswa &nbsp;·&nbsp; 4.4 Cetak Kartu Pendaftaran</div>
<hr class="toc-separator">
<div class="toc-section">
    <span class="toc-section-title">BAB 5 — Panduan Petugas Kesehatan (UKS)</span>
    <span class="toc-page">15</span>
</div>
<div class="toc-sub">5.1 Dashboard &nbsp;·&nbsp; 5.2 Input Data Kesehatan &nbsp;·&nbsp; 5.3 Laporan Pemeriksaan</div>
<hr class="toc-separator">
<div class="toc-section">
    <span class="toc-section-title">BAB 6 — Panduan Petugas Wawancara (BK)</span>
    <span class="toc-page">17</span>
</div>
<div class="toc-sub">6.1 Dashboard &nbsp;·&nbsp; 6.2 Penilaian Wawancara &nbsp;·&nbsp; 6.3 Menetapkan Jurusan &amp; Biaya</div>
<hr class="toc-separator">
<div class="toc-section">
    <span class="toc-section-title">BAB 7 — Panduan Petugas Pembayaran (Keuangan)</span>
    <span class="toc-page">20</span>
</div>
<div class="toc-sub">7.1 Dashboard &nbsp;·&nbsp; 7.2 Input Pembayaran &nbsp;·&nbsp; 7.3 Cetak Kwitansi</div>
<hr class="toc-separator">

<div class="toc-chapter-header">Portal Calon Siswa</div>
<div class="toc-section">
    <span class="toc-section-title">BAB 8 — Panduan Calon Siswa (Pendaftar Online)</span>
    <span class="toc-page">23</span>
</div>
<div class="toc-sub">8.1 Registrasi Akun &nbsp;·&nbsp; 8.2 Verifikasi OTP &nbsp;·&nbsp; 8.3 Mengisi Formulir Pendaftaran &nbsp;·&nbsp; 8.4 Tes Gaya Belajar &nbsp;·&nbsp; 8.5 Cetak Kartu</div>
<hr class="toc-separator">

<div class="toc-chapter-header">Referensi</div>
<div class="toc-section">
    <span class="toc-section-title">BAB 9 — Pertanyaan Umum (FAQ) &amp; Kontak Bantuan</span>
    <span class="toc-page">28</span>
</div>
<hr class="toc-separator">
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 1: PENGENALAN SISTEM                                     --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 1</div>
    <div class="chapter-title">Pengenalan Sistem</div>
    <div class="chapter-desc">Gambaran umum aplikasi, arsitektur, dan alur kerja</div>
</div>

<h2>1.1 Deskripsi Aplikasi</h2>
<p>
    Aplikasi <strong>Web Sekolah &amp; SPMB (Seleksi Penerimaan Murid Baru)</strong> adalah sistem informasi berbasis web yang dibangun dengan framework <strong>Laravel</strong>. Sistem ini dirancang khusus untuk SMK Muhammadiyah 1 Bantul guna mengotomasi dua fungsi utama sekolah secara terpadu:
</p>
<div class="two-col">
    <div class="col-left">
        <div class="callout callout-info">
            <div class="callout-title">🌐 Website Profil Publik</div>
            Portal informasi sekolah yang dapat diakses siapa saja melalui internet. Berisi profil sekolah, berita, prestasi, galeri, dan informasi jurusan secara lengkap.
        </div>
    </div>
    <div class="col-right">
        <div class="callout callout-success">
            <div class="callout-title">📝 Sistem SPMB Online</div>
            Platform penerimaan siswa baru digital dengan alur kerja multi-peran: dari pendaftaran online calon siswa hingga proses verifikasi, pemeriksaan kesehatan, wawancara, dan pembayaran.
        </div>
    </div>
</div>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://127.0.0.1:8000/ — Beranda Sekolah</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/01_homepage.png') }}" alt="Homepage Sekolah">
    <div class="screenshot-caption">Gambar 1.1 — Halaman utama (Beranda) website SMK Muhammadiyah 1 Bantul yang bisa diakses publik.</div>
</div>

<h2>1.2 Arsitektur &amp; Komponen Sistem</h2>
<table class="std-table">
    <tr>
        <th style="width:22%;">Komponen</th>
        <th style="width:25%;">Teknologi</th>
        <th>Fungsi</th>
    </tr>
    <tr>
        <td><strong>Backend Framework</strong></td>
        <td>Laravel 12 (PHP 8.2+)</td>
        <td>Logika bisnis, routing, autentikasi, manajemen database</td>
    </tr>
    <tr>
        <td><strong>Database</strong></td>
        <td>MySQL 8.0+</td>
        <td>Penyimpanan seluruh data pendaftaran, konten website, dan akun pengguna</td>
    </tr>
    <tr>
        <td><strong>Frontend</strong></td>
        <td>Blade Template + Vite</td>
        <td>Tampilan antarmuka pengguna yang responsif di semua perangkat</td>
    </tr>
    <tr>
        <td><strong>PDF Engine</strong></td>
        <td>DomPDF (Laravel)</td>
        <td>Cetak kartu pendaftaran, kwitansi pembayaran, dan laporan</td>
    </tr>
    <tr>
        <td><strong>WhatsApp Gateway</strong></td>
        <td>Nobox.ai API</td>
        <td>Pengiriman OTP verifikasi, notifikasi pembayaran, dan konfirmasi pendaftaran</td>
    </tr>
    <tr>
        <td><strong>Storage</strong></td>
        <td>Laravel Storage (lokal/cloud)</td>
        <td>Penyimpanan foto siswa, berkas KK, akta kelahiran, foto berita, dll.</td>
    </tr>
</table>

<h2>1.3 Persyaratan Perangkat Pengguna</h2>
<div class="two-col">
    <div class="col-left">
        <h4>Perangkat yang Didukung</h4>
        <ul>
            <li>💻 Komputer / Laptop (Windows, Mac, Linux)</li>
            <li>📱 Smartphone / Tablet (Android &amp; iOS)</li>
            <li>Layout responsif untuk semua ukuran layar</li>
        </ul>
    </div>
    <div class="col-right">
        <h4>Browser yang Direkomendasikan</h4>
        <ul>
            <li>Google Chrome versi 100+</li>
            <li>Mozilla Firefox versi 100+</li>
            <li>Microsoft Edge versi 100+</li>
            <li>Safari versi 15+</li>
        </ul>
    </div>
</div>
<div class="callout callout-warning">
    <div class="callout-title">⚠️ Perhatian</div>
    Pastikan koneksi internet Anda stabil saat menggunakan sistem. Untuk petugas yang akan mengunggah file (foto, dokumen), kecepatan upload minimal yang disarankan adalah <strong>2 Mbps</strong>.
</div>

<h2>1.4 Alur Kerja Umum SPMB</h2>
<div class="steps-container">
    <div class="step-item">
        <div class="step-number">1</div>
        <div class="step-content">
            <div class="step-content-title">Calon Siswa — Daftar &amp; Isi Formulir Online</div>
            <div class="step-content-desc">Siswa mendaftar akun, verifikasi OTP via WhatsApp, kemudian mengisi formulir 5 langkah dan mengunggah dokumen persyaratan.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">2</div>
        <div class="step-content">
            <div class="step-content-title">Petugas Pendaftaran — Verifikasi Berkas</div>
            <div class="step-content-desc">Petugas memeriksa kelengkapan berkas fisik, mengunggah foto resmi siswa, dan memperbarui status berkas menjadi terverifikasi.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">3</div>
        <div class="step-content">
            <div class="step-content-title">Petugas Kesehatan (UKS) — Pemeriksaan Fisik</div>
            <div class="step-content-desc">Tim medis melakukan cek fisik (TB, BB, buta warna, dll.) dan mencatat hasilnya di sistem.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">4</div>
        <div class="step-content">
            <div class="step-content-title">Petugas Wawancara (BK) — Seleksi &amp; Peminatan</div>
            <div class="step-content-desc">Penguji mewawancarai siswa, menilai kemampuan keagamaan, membaca hasil tes gaya belajar, dan menentukan jurusan yang diterima beserta biaya yang ditetapkan.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">5</div>
        <div class="step-content">
            <div class="step-content-title">Petugas Pembayaran — Konfirmasi &amp; Kwitansi</div>
            <div class="step-content-desc">Bagian keuangan menerima pembayaran uang masuk (bisa cicilan), menginputnya ke sistem, dan mencetak kwitansi digital untuk orang tua siswa.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number" style="background:#22c55e;">✓</div>
        <div class="step-content">
            <div class="step-content-title" style="color:#15803d;">Siswa Resmi Diterima</div>
            <div class="step-content-desc">Setelah semua tahap selesai, status siswa berubah menjadi <span class="badge badge-accepted">Diterima</span> dan data tersimpan di database untuk keperluan administrasi sekolah.</div>
        </div>
    </div>
</div>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 2: LOGIN                                                 --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 2</div>
    <div class="chapter-title">Cara Login ke Sistem</div>
    <div class="chapter-desc">Akses halaman login, masukkan kredensial, dan navigasi sesuai peran</div>
</div>

<h2>2.1 Membuka Halaman Login</h2>
<p>Buka browser Anda, lalu ketikkan alamat URL sistem sekolah di bilah alamat:</p>
<div class="url-box">http://[domain-sekolah]/login</div>
<p>Anda akan melihat halaman login seperti berikut:</p>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://[domain]/login — Halaman Login Admin &amp; Petugas</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/02_login.png') }}" alt="Halaman Login">
    <div class="screenshot-caption">Gambar 2.1 — Halaman login untuk Administrator dan seluruh Petugas. Gunakan username atau email beserta kata sandi yang telah diberikan.</div>
</div>

<h2>2.2 Data Login per Peran Pengguna</h2>
<div class="callout callout-danger">
    <div class="callout-title">🔒 Informasi Kerahasiaan</div>
    Tabel di bawah berisi data login default. Segera ubah kata sandi setelah pertama kali login melalui menu profil. Jangan bagikan kata sandi kepada siapapun.
</div>

<table class="std-table">
    <tr>
        <th>Peran</th>
        <th>Username / Email</th>
        <th>Kata Sandi Default</th>
        <th>Redirect Setelah Login</th>
    </tr>
    <tr>
        <td><strong>👑 Administrator</strong></td>
        <td><span class="kbd">admin</span> atau <span class="kbd">admin@admin.com</span></td>
        <td><span class="kbd">password</span></td>
        <td>/admin/dashboard</td>
    </tr>
    <tr>
        <td><strong>📋 Petugas Pendaftaran</strong></td>
        <td><span class="kbd">petugas@[domain]</span></td>
        <td><em>Diatur oleh Admin</em></td>
        <td>/petugas/dashboard</td>
    </tr>
    <tr>
        <td><strong>🩺 Petugas Kesehatan</strong></td>
        <td><span class="kbd">kesehatan</span> atau <span class="kbd">kesehatan@admin.com</span></td>
        <td><span class="kbd">kesehatan</span></td>
        <td>/petugas/kesehatan/dashboard</td>
    </tr>
    <tr>
        <td><strong>🎤 Petugas Wawancara</strong></td>
        <td><span class="kbd">wawancara</span> atau <span class="kbd">wawancara@admin.com</span></td>
        <td><span class="kbd">wawancara</span></td>
        <td>/petugas/wawancara/dashboard</td>
    </tr>
    <tr>
        <td><strong>💳 Petugas Pembayaran</strong></td>
        <td><span class="kbd">pembayaran</span> atau <span class="kbd">pembayaran@admin.com</span></td>
        <td><span class="kbd">pembayaran</span></td>
        <td>/petugas/pembayaran/dashboard</td>
    </tr>
</table>

<h2>2.3 Langkah-Langkah Login</h2>
<div class="steps-container">
    <div class="step-item">
        <div class="step-number">1</div>
        <div class="step-content">
            <div class="step-content-title">Buka Halaman Login</div>
            <div class="step-content-desc">Navigasikan browser ke <strong>/login</strong>. Pastikan halaman termuat penuh.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">2</div>
        <div class="step-content">
            <div class="step-content-title">Isi Kolom "Email atau Username"</div>
            <div class="step-content-desc">Ketik username singkat (contoh: <span class="kbd">admin</span>) atau alamat email lengkap (contoh: <span class="kbd">admin@admin.com</span>).</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">3</div>
        <div class="step-content">
            <div class="step-content-title">Isi Kolom "Kata Sandi"</div>
            <div class="step-content-desc">Masukkan kata sandi yang sesuai dengan akun Anda. Kata sandi bersifat sensitif terhadap huruf besar/kecil.</div>
        </div>
    </div>
    <div class="step-item">
        <div class="step-number">4</div>
        <div class="step-content">
            <div class="step-content-title">Klik Tombol "Masuk"</div>
            <div class="step-content-desc">Sistem akan memverifikasi kredensial dan secara otomatis mengarahkan Anda ke dashboard sesuai peran yang dimiliki.</div>
        </div>
    </div>
</div>

<h2>2.4 Cara Logout (Keluar dari Sistem)</h2>
<p>Untuk keamanan data, selalu keluar dari sistem setelah selesai bekerja. Cara logout:</p>
<ul>
    <li>Klik nama pengguna atau ikon profil di pojok kanan atas dashboard.</li>
    <li>Pilih menu <strong>"Keluar"</strong> atau <strong>"Logout"</strong> dari dropdown yang muncul.</li>
    <li>Sistem akan mengakhiri sesi Anda dan mengarahkan kembali ke halaman login.</li>
</ul>
<div class="callout callout-warning">
    <div class="callout-title">⚠️ Keamanan Sesi</div>
    Jika komputer Anda akan ditinggalkan atau digunakan bersama, <strong>selalu logout</strong> terlebih dahulu. Sesi login aktif selama 120 menit tanpa aktivitas akan otomatis berakhir.
</div>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 3: ADMINISTRATOR                                         --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 3</div>
    <div class="chapter-title">Panduan Administrator</div>
    <div class="chapter-desc">Kontrol penuh terhadap seluruh konten website dan pengaturan sistem</div>
</div>

<div class="role-banner role-admin">
    <div class="role-banner-icon">👑</div>
    <div class="role-banner-content">
        <div class="role-banner-title">Peran: Administrator</div>
        <div class="role-banner-sub">Login: admin / admin@admin.com · URL Panel: /admin/dashboard</div>
    </div>
</div>

<h2>3.1 Dashboard Administrator</h2>
<p>Setelah login sebagai admin, Anda akan masuk ke halaman <strong>Dashboard</strong> yang menampilkan ringkasan statistik real-time sistem:</p>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://[domain]/admin/dashboard</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/03_admin_dashboard.png') }}" alt="Dashboard Admin">
    <div class="screenshot-caption">Gambar 3.1 — Dashboard administrator dengan statistik pendaftar, grafik, dan menu navigasi lengkap di sidebar kiri.</div>
</div>

<p>Informasi yang tersedia di dashboard:</p>
<table class="std-table">
    <tr><th>Widget / Kartu Statistik</th><th>Keterangan</th></tr>
    <tr><td>Total Pendaftar</td><td>Jumlah keseluruhan calon siswa yang telah mendaftar di semua gelombang tahun aktif</td></tr>
    <tr><td>Terverifikasi</td><td>Pendaftar yang berkasnya sudah diperiksa dan divalidasi oleh petugas pendaftaran</td></tr>
    <tr><td>Menunggu</td><td>Pendaftar yang berstatus pending (belum diproses petugas)</td></tr>
    <tr><td>Pesan Masuk</td><td>Jumlah pesan kontak dari masyarakat yang belum dibaca</td></tr>
</table>

<h2>3.2 Mengelola Berita</h2>
<p>Menu <strong>Berita</strong> pada sidebar memungkinkan admin menambah, mengedit, dan menghapus artikel berita sekolah yang tampil di website publik.</p>
<h3>Menambah Berita Baru</h3>
<div class="steps-container">
    <div class="step-item"><div class="step-number">1</div><div class="step-content"><div class="step-content-title">Klik menu "Berita" di sidebar kiri</div><div class="step-content-desc">Halaman daftar berita akan terbuka menampilkan semua artikel yang sudah ada.</div></div></div>
    <div class="step-item"><div class="step-number">2</div><div class="step-content"><div class="step-content-title">Klik tombol "+ Tambah Berita"</div><div class="step-content-desc">Formulir penambahan berita baru akan muncul.</div></div></div>
    <div class="step-item"><div class="step-number">3</div><div class="step-content"><div class="step-content-title">Isi seluruh kolom yang tersedia</div><div class="step-content-desc">Judul, konten (editor teks kaya), tanggal terbit, gambar thumbnail, dan status draft/publikasi.</div></div></div>
    <div class="step-item"><div class="step-number">4</div><div class="step-content"><div class="step-content-title">Klik "Simpan" untuk mempublikasikan</div><div class="step-content-desc">Jika status "Draft" diaktifkan, berita tidak akan tampil di website publik sampai draft dinonaktifkan.</div></div></div>
</div>

<h2>3.3 Mengelola Galeri Foto &amp; Video</h2>
<div class="two-col">
    <div class="col-left">
        <h4>Galeri Foto</h4>
        <p>Galeri foto menggunakan sistem folder berbasis Google Drive. Admin cukup mengatur <strong>Folder ID</strong> yang mengarah ke folder Google Drive publik berisi foto-foto kegiatan sekolah.</p>
        <ul><li>Klik menu <strong>Galeri Foto</strong> di sidebar</li><li>Edit Folder ID sesuai folder Google Drive yang diinginkan</li><li>Foto akan otomatis tampil di halaman publik</li></ul>
    </div>
    <div class="col-right">
        <h4>Galeri Video</h4>
        <p>Video galeri berbasis embed YouTube. Admin menginput ID video YouTube beserta judul, kategori, dan deskripsinya.</p>
        <ul><li>Klik menu <strong>Galeri Video</strong> di sidebar</li><li>Klik <strong>"+ Tambah Video"</strong></li><li>Masukkan YouTube Video ID (contoh: <span class="kbd">9c0dJnFd8RY</span>)</li><li>Isi judul, kategori, dan durasi video</li></ul>
    </div>
</div>

<h2>3.4 Mengelola Gelombang SPMB</h2>
<p>Menu <strong>Gelombang SPMB</strong> digunakan untuk mengatur periode penerimaan siswa baru. Satu periode penerimaan disebut satu "gelombang".</p>
<table class="std-table">
    <tr><th>Fungsi</th><th>Cara Penggunaan</th></tr>
    <tr><td>Tambah Gelombang Baru</td><td>Klik "+ Tambah Gelombang", isi nama, tanggal mulai, dan tanggal berakhir, lalu simpan.</td></tr>
    <tr><td>Aktifkan / Nonaktifkan</td><td>Klik tombol <strong>Toggle Aktif</strong> untuk membuka atau menutup penerimaan pendaftaran secara instan.</td></tr>
    <tr><td>Edit Gelombang</td><td>Klik ikon edit (pensil) pada baris gelombang yang ingin diubah.</td></tr>
    <tr><td>Hapus Gelombang</td><td>Klik ikon hapus (tempat sampah). Hanya gelombang yang belum memiliki pendaftar yang bisa dihapus.</td></tr>
</table>
<div class="callout callout-info">
    <div class="callout-title">💡 Tips Gelombang</div>
    Pastikan hanya satu gelombang yang berstatus <strong>Aktif</strong> pada satu waktu. Pendaftar baru akan secara otomatis masuk ke gelombang yang sedang aktif.
</div>

<h2>3.5 Manajemen Pengguna (User)</h2>
<p>Admin dapat membuat dan mengelola akun untuk seluruh staf petugas melalui menu <strong>Kelola User</strong>.</p>
<div class="field-card"><div class="field-name">Nama Lengkap <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nama lengkap petugas yang akan tampil di sistem.</div></div>
<div class="field-card"><div class="field-name">Email <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Alamat email unik yang digunakan sebagai identitas login.</div></div>
<div class="field-card"><div class="field-name">Kata Sandi <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Kata sandi awal akun. Informasikan ke petugas agar segera diubah setelah login pertama.</div></div>
<div class="field-card"><div class="field-name">Peran (Role) <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih salah satu: <strong>Petugas Pendaftaran</strong>, <strong>Petugas Kesehatan</strong>, <strong>Petugas Wawancara</strong>, atau <strong>Petugas Pembayaran</strong>. Peran menentukan akses dan fitur yang tersedia.</div></div>

<h2>3.6 Ekspor Laporan &amp; Reset Data</h2>
<div class="two-col">
    <div class="col-left">
        <h4>📥 Ekspor Data ke Excel</h4>
        <p>Unduh seluruh data pendaftar ke berkas Excel (<em>.xlsx</em>) untuk kebutuhan pelaporan ke dinas pendidikan atau arsip sekolah.</p>
        <ul>
            <li>Klik menu <strong>Download Pendaftaran</strong></li>
            <li>Pilih gelombang atau tahun yang ingin diekspor</li>
            <li>Klik tombol <strong>"Unduh Excel"</strong></li>
            <li>File akan otomatis terunduh ke komputer Anda</li>
        </ul>
    </div>
    <div class="col-right">
        <h4>🗑️ Reset Data Pendaftaran</h4>
        <p>Fitur untuk membersihkan semua data pendaftaran sebelum tahun ajaran baru dimulai.</p>
        <div class="callout callout-danger">
            <div class="callout-title">⛔ PERINGATAN KERAS</div>
            Reset akan menghapus PERMANEN semua data pendaftaran. Lakukan ekspor Excel terlebih dahulu sebelum reset!
        </div>
        <ul>
            <li>Klik menu <strong>Reset Pendaftaran</strong></li>
            <li>Baca peringatan dengan seksama</li>
            <li>Ketik konfirmasi yang diminta</li>
            <li>Klik <strong>"Reset Sekarang"</strong></li>
        </ul>
    </div>
</div>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 4: PETUGAS PENDAFTARAN                                  --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 4</div>
    <div class="chapter-title">Panduan Petugas Pendaftaran</div>
    <div class="chapter-desc">Verifikasi berkas, upload foto, dan cetak kartu pendaftaran</div>
</div>

<div class="role-banner role-petugas">
    <div class="role-banner-icon">📋</div>
    <div class="role-banner-content">
        <div class="role-banner-title">Peran: Petugas Pendaftaran (Front Office)</div>
        <div class="role-banner-sub">Login: email petugas · URL Panel: /petugas/dashboard</div>
    </div>
</div>

<h2>4.1 Dashboard Petugas Pendaftaran</h2>
<p>Setelah login, Anda akan diarahkan ke dashboard yang menampilkan daftar seluruh pendaftar beserta status berkas mereka.</p>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://[domain]/petugas/dashboard</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/05_petugas_dashboard.png') }}" alt="Dashboard Petugas Pendaftaran">
    <div class="screenshot-caption">Gambar 4.1 — Dashboard Petugas Pendaftaran. Tabel berisi daftar pendaftar dengan filter status dan tombol aksi.</div>
</div>

<h3>Memahami Status Pendaftaran</h3>
<table class="std-table">
    <tr><th style="width:25%;">Status</th><th>Arti</th><th style="width:30%;">Tindakan yang Diperlukan</th></tr>
    <tr><td><span class="badge badge-pending">Pending</span></td><td>Siswa baru saja mendaftar, belum diproses sama sekali</td><td>Segera panggil siswa untuk verifikasi berkas fisik</td></tr>
    <tr><td><span class="badge badge-verified">Verifikasi</span></td><td>Berkas sudah diperiksa dan dinyatakan lengkap</td><td>Lanjut ke tahap pemeriksaan kesehatan</td></tr>
    <tr><td><span class="badge badge-accepted">Diterima</span></td><td>Seluruh proses (medis, wawancara, bayar) telah selesai</td><td>Cetak kartu peserta didik baru jika perlu</td></tr>
    <tr><td><span class="badge badge-rejected">Ditolak</span></td><td>Pendaftaran ditolak karena tidak memenuhi syarat</td><td>Tidak ada tindakan lanjut</td></tr>
</table>

<h2>4.2 Memverifikasi Berkas Pendaftar</h2>
<div class="steps-container">
    <div class="step-item"><div class="step-number">1</div><div class="step-content"><div class="step-content-title">Klik nama atau tombol "Lihat" pada baris pendaftar</div><div class="step-content-desc">Halaman detail pendaftaran akan terbuka, menampilkan semua data yang diisi siswa dan berkas yang diunggah.</div></div></div>
    <div class="step-item"><div class="step-number">2</div><div class="step-content"><div class="step-content-title">Periksa data biodata dan berkas unggahan</div><div class="step-content-desc">Pastikan nama, tanggal lahir, asal sekolah, dan pilihan jurusan sudah benar. Klik berkas (Akta, KK) untuk membuka dan memverifikasi keasliannya.</div></div></div>
    <div class="step-item"><div class="step-number">3</div><div class="step-content"><div class="step-content-title">Upload foto resmi siswa (jika belum ada)</div><div class="step-content-desc">Pada bagian foto, klik <strong>"Unggah Foto"</strong> dan pilih file foto pas siswa dari komputer Anda. Format yang didukung: JPG, PNG. Ukuran maksimal: 2 MB.</div></div></div>
    <div class="step-item"><div class="step-number">4</div><div class="step-content"><div class="step-content-title">Centang status berkas dan tambahkan catatan</div><div class="step-content-desc">Tandai berkas apa saja yang sudah lengkap (KK ✓, Akta ✓, Foto ✓) dan isi catatan petugas jika diperlukan.</div></div></div>
    <div class="step-item"><div class="step-number">5</div><div class="step-content"><div class="step-content-title">Ubah status ke "Verifikasi" lalu klik "Simpan"</div><div class="step-content-desc">Status pendaftaran akan berubah menjadi <span class="badge badge-verified">Verifikasi</span> dan pendaftar siap untuk tahap selanjutnya.</div></div></div>
</div>

<h2>4.3 Mencetak Kartu Pendaftaran</h2>
<p>Kartu pendaftaran adalah dokumen resmi yang harus dibawa siswa saat mengikuti seluruh tahapan seleksi (medis, wawancara).</p>
<ul>
    <li>Buka halaman detail pendaftaran siswa yang bersangkutan.</li>
    <li>Klik tombol <strong>"Cetak Kartu"</strong> (ikon printer) di pojok kanan atas halaman detail.</li>
    <li>Sistem akan membuka tab baru berisi kartu pendaftaran berformat PDF siap cetak.</li>
    <li>Tekan <span class="kbd">Ctrl+P</span> (atau <span class="kbd">⌘P</span> di Mac) untuk mencetak.</li>
    <li>Rekomendasikan ukuran kertas <strong>A4</strong> dengan orientasi <strong>Portrait</strong>.</li>
</ul>
<div class="callout callout-info">
    <div class="callout-title">💡 Info Kartu Pendaftaran</div>
    Kartu pendaftaran berisi: Nomor Pendaftaran, Nama Lengkap, Foto Siswa, Asal Sekolah, Pilihan Jurusan, dan informasi gelombang SPMB. Siswa wajib membawa kartu ini ke setiap tahapan seleksi.
</div>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 5: PETUGAS KESEHATAN                                     --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 5</div>
    <div class="chapter-title">Panduan Petugas Kesehatan (UKS)</div>
    <div class="chapter-desc">Input data pemeriksaan fisik dan kesehatan calon siswa</div>
</div>

<div class="role-banner role-kesehatan">
    <div class="role-banner-icon">🩺</div>
    <div class="role-banner-content">
        <div class="role-banner-title">Peran: Petugas Kesehatan (UKS)</div>
        <div class="role-banner-sub">Login: kesehatan / kesehatan@admin.com · URL Panel: /petugas/kesehatan/dashboard</div>
    </div>
</div>

<h2>5.1 Dashboard Petugas Kesehatan</h2>
<p>Dashboard menampilkan daftar pendaftar yang status berkasnya sudah <span class="badge badge-verified">Verifikasi</span> (sudah diproses petugas pendaftaran) dan siap menjalani pemeriksaan kesehatan.</p>

<div class="callout callout-info">
    <div class="callout-title">ℹ️ Catatan Urutan Proses</div>
    Petugas Kesehatan hanya bisa memproses siswa yang berkasnya sudah diverifikasi oleh Petugas Pendaftaran. Jika daftar kosong, hubungi Petugas Pendaftaran untuk melakukan verifikasi berkas terlebih dahulu.
</div>

<h2>5.2 Mengisi Data Pemeriksaan Kesehatan</h2>
<p>Klik nama pendaftar atau tombol <strong>"Periksa"</strong> untuk membuka formulir input data kesehatan:</p>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://[domain]/petugas/kesehatan/pendaftaran/{id}</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/06_kesehatan_form.png') }}" alt="Form Pemeriksaan Kesehatan">
    <div class="screenshot-caption">Gambar 5.1 — Formulir input data pemeriksaan kesehatan calon siswa oleh Petugas UKS.</div>
</div>

<h3>Panduan Pengisian Formulir Kesehatan</h3>
<div class="field-card"><div class="field-name">Tinggi Badan (cm) <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Ukuran tinggi badan siswa dalam satuan sentimeter, contoh: <strong>165</strong>. Diukur tanpa alas kaki.</div></div>
<div class="field-card"><div class="field-name">Berat Badan (kg) <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Ukuran berat badan siswa dalam satuan kilogram, contoh: <strong>55</strong>. Diukur tanpa sepatu.</div></div>
<div class="field-card"><div class="field-name">Golongan Darah <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih golongan darah dari dropdown: <strong>A</strong>, <strong>B</strong>, <strong>AB</strong>, <strong>O</strong>, atau <strong>Tidak Diketahui</strong>.</div></div>
<div class="field-card"><div class="field-name">Buta Warna <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih <strong>Ya</strong> jika siswa teridentifikasi mengalami buta warna dari tes Ishihara, atau <strong>Tidak</strong> jika normal. Penting untuk penempatan jurusan tertentu (TKR, TBSM, TPM).</div></div>
<div class="field-card"><div class="field-name">Mata Minus <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih <strong>Ya</strong> jika siswa menggunakan kacamata minus/plus, atau <strong>Tidak</strong> jika tidak.</div></div>
<div class="field-card"><div class="field-name">Tato / Tindik <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih <strong>Ya</strong> jika ditemukan tato atau tindik (selain tindik daun telinga untuk perempuan), atau <strong>Tidak</strong> jika tidak ada.</div></div>
<div class="field-card"><div class="field-name">Riwayat Penyakit Kronis <span class="field-req field-req-opsional">OPSIONAL</span></div><div class="field-desc">Tulis riwayat penyakit kronis yang dimiliki siswa berdasarkan pernyataan orang tua, misal: Asma, Diabetes, Epilepsi. Isi tanda <strong>"-"</strong> jika tidak ada.</div></div>
<div class="field-card"><div class="field-name">Catatan Petugas <span class="field-req field-req-opsional">OPSIONAL</span></div><div class="field-desc">Catatan tambahan hasil pemeriksaan yang perlu diketahui petugas lain atau pewawancara.</div></div>

<p style="margin-top:14px;">Setelah semua kolom diisi, klik tombol <strong>"Simpan Data Kesehatan"</strong>. Data akan tersimpan dan status pemeriksaan kesehatan siswa tersebut akan berubah menjadi <strong>Selesai</strong>.</p>

<h2>5.3 Laporan Pemeriksaan Kesehatan</h2>
<p>Untuk melihat atau mengunduh laporan ringkasan hasil pemeriksaan kesehatan seluruh pendaftar:</p>
<ul>
    <li>Klik menu <strong>"Laporan"</strong> di navigasi atas dashboard.</li>
    <li>Halaman laporan akan menampilkan tabel statistik: total diperiksa, persentase buta warna, rata-rata BMI, dll.</li>
</ul>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 6: PETUGAS WAWANCARA                                     --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 6</div>
    <div class="chapter-title">Panduan Petugas Wawancara (BK)</div>
    <div class="chapter-desc">Penilaian keagamaan, minat bakat, gaya belajar, dan penetapan jurusan</div>
</div>

<div class="role-banner role-wawancara">
    <div class="role-banner-icon">🎤</div>
    <div class="role-banner-content">
        <div class="role-banner-title">Peran: Petugas Wawancara (BK / Penguji)</div>
        <div class="role-banner-sub">Login: wawancara / wawancara@admin.com · URL Panel: /petugas/wawancara/dashboard</div>
    </div>
</div>

<h2>6.1 Dashboard Petugas Wawancara</h2>
<p>Dashboard menampilkan daftar pendaftar yang sudah melewati pemeriksaan kesehatan dan siap diwawancarai. Klik nama pendaftar untuk membuka halaman detail yang berisi data lengkap siswa, hasil tes kesehatan, dan formulir penilaian wawancara.</p>

<h2>6.2 Mengisi Formulir Penilaian Wawancara</h2>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://[domain]/petugas/wawancara/pendaftaran/{id}</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/07_wawancara_form.png') }}" alt="Form Wawancara">
    <div class="screenshot-caption">Gambar 6.1 — Formulir penilaian wawancara. Pewawancara dapat membaca hasil tes gaya belajar mandiri siswa dan memberikan penilaian komprehensif.</div>
</div>

<h3>Panduan Pengisian Formulir Wawancara</h3>
<div class="field-card"><div class="field-name">Baca Tulis Al-Qur'an <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nilai kemampuan membaca dan menulis huruf Al-Qur'an: <strong>Lancar</strong> (tartil, fasih), <strong>Cukup</strong> (bisa tapi masih ada kesalahan), atau <strong>Kurang</strong> (belum bisa/tidak tahu).</div></div>
<div class="field-card"><div class="field-name">Sholat Fardhu <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Penilaian kedisiplinan sholat wajib 5 waktu: <strong>Rutin</strong> (selalu sholat 5 waktu), <strong>Kadang-Kadang</strong>, atau <strong>Tidak</strong>.</div></div>
<div class="field-card"><div class="field-name">Minat &amp; Bakat <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Tulis hasil penilaian minat dan bakat siswa dari sesi wawancara, meliputi hobi, keahlian, dan cita-cita. Contoh: <em>"Siswa memiliki minat kuat di bidang otomotif dan sering membantu perbaikan kendaraan di rumah."</em></div></div>
<div class="field-card"><div class="field-name">Penilaian Kepribadian <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Deskripsikan kepribadian siswa berdasarkan observasi selama wawancara: sikap, keberanian, kejujuran, dan motivasi belajar.</div></div>

<div class="callout callout-success">
    <div class="callout-title">📊 Membaca Hasil Tes Gaya Belajar</div>
    Di halaman detail siswa, Anda akan menemukan badge <strong>Tipe Gaya Belajar</strong> yang diisi otomatis berdasarkan jawaban tes mandiri siswa:
    <ul style="margin-top:6px;">
        <li><strong>Visual</strong> — Belajar lebih efektif dengan gambar, diagram, dan video. Cocok untuk jurusan TAV, RPL.</li>
        <li><strong>Auditori</strong> — Belajar lebih efektif dengan mendengar penjelasan. Cocok untuk semua jurusan.</li>
        <li><strong>Kinestetik</strong> — Belajar lebih efektif dengan praktik langsung. Sangat cocok untuk TKR, TBSM, TPM.</li>
    </ul>
    Gunakan informasi ini sebagai bahan pertimbangan tambahan saat merekomendasikan jurusan.
</div>

<div class="field-card"><div class="field-name">Jurusan yang Diterima <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih jurusan final tempat siswa diterima berdasarkan hasil seleksi keseluruhan. Pilihan: <strong>TKR</strong>, <strong>TBSM</strong>, <strong>TPM</strong>, <strong>TAV</strong>, atau <strong>RPL</strong>. Bandingkan dengan pilihan 1, 2, 3 siswa saat mendaftar.</div></div>
<div class="field-card"><div class="field-name">Ukuran Seragam <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih ukuran seragam: <strong>S</strong>, <strong>M</strong>, <strong>L</strong>, <strong>XL</strong>, <strong>XXL</strong>, atau ukuran custom. Data ini diperlukan bagian kesiswaan.</div></div>
<div class="field-card"><div class="field-name">Status Yatim Piatu <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih status: <strong>Tidak</strong>, <strong>Yatim</strong> (ayah meninggal), <strong>Piatu</strong> (ibu meninggal), atau <strong>Yatim Piatu</strong> (keduanya meninggal). Status ini berpengaruh pada penetapan biaya pendidikan (diskon/beasiswa).</div></div>

<h2>6.3 Menetapkan Biaya Pendidikan</h2>
<p>Setelah mengisi data wawancara dan status siswa, bagian biaya dapat diisi langsung di formulir yang sama atau dilanjutkan ke petugas pembayaran. Sistem mendukung penetapan biaya komponen:</p>

<table class="std-table">
    <tr><th>Komponen Biaya</th><th>Keterangan</th><th style="width:25%;">Contoh Nilai</th></tr>
    <tr><td><strong>Biaya SPP</strong></td><td>Iuran Sumbangan Pembinaan Pendidikan (per bulan × 12)</td><td>Rp 1.200.000</td></tr>
    <tr><td><strong>Biaya Dana Awal Tahun</strong></td><td>Biaya seragam, buku, perlengkapan awal</td><td>Rp 2.000.000</td></tr>
    <tr><td><strong>Biaya Zakat</strong></td><td>Zakat pendidikan (opsional sesuai kebijakan)</td><td>Rp 100.000</td></tr>
    <tr><td><strong>Biaya Infaq</strong></td><td>Infaq bulanan (opsional)</td><td>Rp 50.000</td></tr>
    <tr><td><strong>Potongan / Diskon</strong></td><td>Diskon beasiswa (misal: yatim piatu, prestasi, dll.)</td><td>Rp 500.000</td></tr>
    <tr style="background:#f0fdf4;"><td><strong>Total Tagihan</strong></td><td>Dihitung otomatis: (Jumlah semua biaya) − Potongan</td><td><strong>Rp 2.850.000</strong></td></tr>
</table>

<p>Klik <strong>"Simpan Penilaian Wawancara"</strong> setelah semua kolom terisi. Status pendaftar akan otomatis berubah menjadi siap proses pembayaran.</p>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 7: PETUGAS PEMBAYARAN                                    --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 7</div>
    <div class="chapter-title">Panduan Petugas Pembayaran</div>
    <div class="chapter-desc">Kelola cicilan pembayaran, catat riwayat, dan cetak kwitansi</div>
</div>

<div class="role-banner role-pembayaran">
    <div class="role-banner-icon">💳</div>
    <div class="role-banner-content">
        <div class="role-banner-title">Peran: Petugas Pembayaran (Keuangan)</div>
        <div class="role-banner-sub">Login: pembayaran / pembayaran@admin.com · URL Panel: /petugas/pembayaran/dashboard</div>
    </div>
</div>

<h2>7.1 Dashboard Petugas Pembayaran</h2>
<p>Dashboard menampilkan daftar pendaftar yang sudah selesai melalui tahap wawancara (biaya sudah ditetapkan oleh pewawancara). Anda dapat melihat status pembayaran masing-masing siswa secara langsung.</p>
<table class="std-table">
    <tr><th>Indikator Status</th><th>Arti</th></tr>
    <tr><td><span class="badge badge-rejected">Belum Bayar</span></td><td>Siswa belum melakukan pembayaran sama sekali. Total terbayar: Rp 0</td></tr>
    <tr><td><span class="badge badge-pending">Cicilan</span></td><td>Siswa sudah membayar sebagian. Masih ada sisa tagihan yang belum dilunasi</td></tr>
    <tr><td><span class="badge badge-accepted">Lunas</span></td><td>Siswa sudah melunasi seluruh tagihan biaya pendidikan</td></tr>
</table>

<h2>7.2 Menginput Pembayaran Baru</h2>
<div class="steps-container">
    <div class="step-item"><div class="step-number">1</div><div class="step-content"><div class="step-content-title">Klik nama siswa di daftar dashboard</div><div class="step-content-desc">Halaman detail pembayaran akan terbuka, menampilkan rincian tagihan dan riwayat pembayaran yang sudah masuk.</div></div></div>
    <div class="step-item"><div class="step-number">2</div><div class="step-content"><div class="step-content-title">Periksa ringkasan tagihan</div><div class="step-content-desc">Pastikan <strong>Total Tagihan</strong>, <strong>Total Terbayar</strong>, dan <strong>Sisa Tagihan</strong> sudah sesuai. Jika tagihan belum ditetapkan, hubungi Petugas Wawancara.</div></div></div>
    <div class="step-item"><div class="step-number">3</div><div class="step-content"><div class="step-content-title">Isi formulir "Tambah Pembayaran"</div><div class="step-content-desc">Masukkan nominal yang diterima dari siswa/orang tua, pilih metode pembayaran (Tunai/Transfer), dan tambahkan keterangan (contoh: "Cicilan 1", "Lunas"). Isi juga nomor bukti transfer jika ada.</div></div></div>
    <div class="step-item"><div class="step-number">4</div><div class="step-content"><div class="step-content-title">Klik "Simpan Pembayaran"</div><div class="step-content-desc">Pembayaran akan masuk ke riwayat. Total terbayar dan sisa tagihan akan otomatis diperbarui. Jika terbayar ≥ total tagihan, status otomatis berubah menjadi <span class="badge badge-accepted">Lunas</span>.</div></div></div>
</div>

<h2>7.3 Mencetak Kwitansi Pembayaran</h2>
<p>Kwitansi adalah bukti pembayaran resmi yang diberikan kepada orang tua/wali siswa setiap kali melakukan pembayaran.</p>
<ul>
    <li>Di halaman detail pembayaran, temukan baris pembayaran di tabel <strong>Riwayat Pembayaran</strong>.</li>
    <li>Klik tombol <strong>"Cetak Kwitansi"</strong> (ikon printer) pada baris pembayaran yang ingin dicetak.</li>
    <li>File PDF kwitansi akan terbuka di tab baru, berisi: nama siswa, nomor daftar, tanggal, nominal, metode, dan tanda tangan petugas.</li>
    <li>Cetak menggunakan ukuran kertas <strong>A5</strong> (setengah A4) untuk efisiensi kertas, atau A4 jika perlu.</li>
</ul>

<div class="callout callout-success">
    <div class="callout-title">✅ Siswa Resmi Diterima</div>
    Setelah status pembayaran berubah menjadi <strong>Lunas</strong>, status keseluruhan pendaftaran siswa secara otomatis berubah menjadi <span class="badge badge-accepted">Diterima</span>. Siswa telah resmi menjadi peserta didik baru SMK Muhammadiyah 1 Bantul!
</div>

<h2>7.4 Menghapus Riwayat Pembayaran (Koreksi)</h2>
<p>Jika terjadi kesalahan input nominal, Petugas Pembayaran dapat menghapus entri riwayat pembayaran:</p>
<ul>
    <li>Temukan baris riwayat yang salah di tabel <strong>Riwayat Pembayaran</strong>.</li>
    <li>Klik ikon <strong>hapus</strong> (tempat sampah merah) pada baris tersebut.</li>
    <li>Konfirmasi penghapusan pada dialog yang muncul.</li>
    <li>Masukkan kembali data pembayaran yang benar.</li>
</ul>
<div class="callout callout-warning">
    <div class="callout-title">⚠️ Peringatan</div>
    Penghapusan riwayat pembayaran bersifat permanen dan tidak bisa dibatalkan. Pastikan Anda benar-benar yakin sebelum menghapus. Catat nomor riwayat yang dihapus sebagai referensi koreksi.
</div>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 8: CALON SISWA                                           --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 8</div>
    <div class="chapter-title">Panduan Calon Siswa (Pendaftar Online)</div>
    <div class="chapter-desc">Cara mendaftar, mengisi formulir, tes gaya belajar, dan cetak kartu</div>
</div>

<div class="role-banner role-siswa">
    <div class="role-banner-icon">🎓</div>
    <div class="role-banner-content">
        <div class="role-banner-title">Untuk: Calon Siswa Baru</div>
        <div class="role-banner-sub">Akses portal SPMB: /spmb/daftar · Tidak perlu akun khusus, daftar langsung di portal</div>
    </div>
</div>

<h2>8.1 Memulai Pendaftaran Online</h2>
<p>Buka browser di smartphone atau komputer, kemudian akses halaman SPMB:</p>
<div class="url-box">http://[domain-sekolah]/spmb/daftar</div>
<p>Di halaman ini terdapat informasi gelombang pendaftaran yang sedang aktif. Klik tombol <strong>"Daftar Sekarang"</strong> untuk memulai proses pendaftaran.</p>

<div class="callout callout-info">
    <div class="callout-title">📅 Pastikan Gelombang Aktif</div>
    Pendaftaran online hanya bisa dilakukan saat gelombang SPMB sedang dibuka. Periksa informasi tanggal mulai dan berakhirnya gelombang. Jika gelombang sudah ditutup, hubungi sekolah untuk informasi gelombang berikutnya.
</div>

<h2>8.2 Membuat Akun &amp; Verifikasi OTP</h2>
<div class="steps-container">
    <div class="step-item"><div class="step-number">1</div><div class="step-content"><div class="step-content-title">Akses halaman Register</div><div class="step-content-desc">Klik "Daftar Akun Baru" di halaman SPMB, atau langsung buka <strong>/spmb/register</strong>.</div></div></div>
    <div class="step-item"><div class="step-number">2</div><div class="step-content"><div class="step-content-title">Isi data registrasi awal</div><div class="step-content-desc">Masukkan <strong>nama lengkap</strong>, <strong>nomor WhatsApp aktif</strong> (diawali 08 atau +62), dan <strong>email</strong>. Buat kata sandi yang kuat (minimal 8 karakter).</div></div></div>
    <div class="step-item"><div class="step-number">3</div><div class="step-content"><div class="step-content-title">Terima &amp; masukkan Kode OTP</div><div class="step-content-desc">Sistem akan mengirim kode OTP 6 digit ke nomor WhatsApp yang didaftarkan. Buka WhatsApp Anda dan cari pesan dari sistem. Masukkan kode OTP tersebut ke kolom verifikasi dalam waktu <strong>5 menit</strong>.</div></div></div>
    <div class="step-item"><div class="step-number">4</div><div class="step-content"><div class="step-content-title">Akun berhasil — Login otomatis</div><div class="step-content-desc">Setelah OTP valid, akun Anda terverifikasi dan sistem akan otomatis mengarahkan ke halaman formulir pendaftaran.</div></div></div>
</div>

<div class="callout callout-warning">
    <div class="callout-title">📱 Kode OTP Tidak Diterima?</div>
    <ul style="margin-bottom:0;">
        <li>Pastikan nomor WhatsApp yang dimasukkan benar dan aktif.</li>
        <li>Tunggu 30 detik, lalu klik tombol <strong>"Kirim Ulang OTP"</strong>.</li>
        <li>Pastikan WhatsApp Anda tidak dalam mode pesawat atau diblokir.</li>
        <li>Hubungi panitia SPMB jika masalah berlanjut.</li>
    </ul>
</div>

<h2>8.3 Mengisi Formulir Pendaftaran (5 Langkah)</h2>
<p>Formulir pendaftaran terbagi dalam <strong>5 langkah</strong> yang harus diselesaikan secara berurutan. Anda bisa menyimpan progress dan melanjutkan di lain waktu.</p>

<div class="screenshot-container">
    <div class="screenshot-topbar"><span class="dots">● ● ●</span> http://[domain]/spmb/formulir/1 — Langkah 1: Biodata Diri</div>
    <img class="screenshot-img" src="{{ public_path('images/docs/04_spmb_form.png') }}" alt="Formulir SPMB">
    <div class="screenshot-caption">Gambar 8.1 — Wizard formulir pendaftaran 5 langkah. Indikator langkah di atas menunjukkan progress pengisian.</div>
</div>

<h3>Langkah 1 — Biodata Diri</h3>
<div class="field-card"><div class="field-name">Nama Lengkap <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nama lengkap sesuai akta kelahiran, <strong>huruf kapital semua</strong>. Contoh: <em>BUDI SANTOSO PRASETYO</em>. Jangan disingkat.</div></div>
<div class="field-card"><div class="field-name">Tempat Lahir <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Kota atau kabupaten tempat lahir sesuai akta kelahiran. Contoh: <em>Bantul</em>.</div></div>
<div class="field-card"><div class="field-name">Tanggal Lahir <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Klik kolom tanggal, lalu pilih tanggal dari kalender yang muncul. Format: <strong>DD/MM/YYYY</strong>.</div></div>
<div class="field-card"><div class="field-name">Jenis Kelamin <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih <strong>Laki-laki</strong> atau <strong>Perempuan</strong>.</div></div>
<div class="field-card"><div class="field-name">Agama <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pilih agama dari dropdown: Islam, Kristen, Katolik, Hindu, Buddha, Konghucu.</div></div>
<div class="field-card"><div class="field-name">No. HP Siswa <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nomor HP aktif siswa yang bisa dihubungi. Format: <strong>08xxxxxxxxxx</strong> (tanpa spasi atau tanda baca).</div></div>
<div class="field-card"><div class="field-name">Asal Sekolah <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nama lengkap SMP/MTs asal. Contoh: <em>SMP Negeri 3 Bantul</em> atau <em>MTs Negeri 4 Bantul</em>.</div></div>
<div class="field-card"><div class="field-name">Prestasi <span class="field-req field-req-opsional">OPSIONAL</span></div><div class="field-desc">Daftar prestasi akademik maupun non-akademik yang pernah diraih (piala, sertifikat, juara lomba). Isi tanda <strong>"-"</strong> jika tidak ada.</div></div>

<h3>Langkah 2 — Data Orang Tua / Wali</h3>
<div class="field-card"><div class="field-name">Nama Orang Tua / Wali <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nama ayah, ibu, atau wali yang bertanggung jawab atas siswa.</div></div>
<div class="field-card"><div class="field-name">Pekerjaan Orang Tua <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Pekerjaan utama orang tua/wali. Contoh: PNS, Wiraswasta, Petani, TNI/Polri, Guru, dll.</div></div>
<div class="field-card"><div class="field-name">No. HP Orang Tua <span class="field-req field-req-wajib">WAJIB</span></div><div class="field-desc">Nomor WhatsApp aktif orang tua/wali untuk keperluan komunikasi dan notifikasi sistem.</div></div>

<h3>Langkah 3 — Alamat</h3>
<p>Diisi dua bagian: <strong>Alamat Asal (KK)</strong> dan <strong>Alamat Tinggal Sekarang</strong>. Jika sama, centang opsi <em>"Alamat tinggal sama dengan alamat asal"</em>.</p>
<table class="std-table">
    <tr><th>Kolom</th><th>Contoh Pengisian</th></tr>
    <tr><td>Jalan</td><td>Jl. Parangtritis No. 42</td></tr>
    <tr><td>Dusun / Dukuh</td><td>Klodran</td></tr>
    <tr><td>RT / RW</td><td>03 / 02</td></tr>
    <tr><td>Desa / Kelurahan</td><td>Bantul</td></tr>
    <tr><td>Kecamatan</td><td>Bantul</td></tr>
    <tr><td>Kabupaten / Kota</td><td>Bantul</td></tr>
    <tr><td>Provinsi</td><td>DI Yogyakarta</td></tr>
</table>

<h3>Langkah 4 — Pilihan Jurusan</h3>
<p>Pilih jurusan yang diinginkan dalam urutan prioritas:</p>
<table class="std-table">
    <tr><th style="width:15%;">Pilihan</th><th style="width:20%;">Kode</th><th>Nama Jurusan</th></tr>
    <tr><td>Pilihan 1</td><td>TKR</td><td>Teknik Kendaraan Ringan (Otomotif Mobil)</td></tr>
    <tr><td>Pilihan 2</td><td>TBSM</td><td>Teknik Bisnis Sepeda Motor</td></tr>
    <tr><td>Pilihan 3</td><td>TPM / TAV / RPL</td><td>Teknik Permesinan / Teknik Audio Video / Rekayasa Perangkat Lunak</td></tr>
</table>
<div class="callout callout-info">
    <div class="callout-title">💡 Tips Memilih Jurusan</div>
    Pilihlah jurusan berdasarkan minat, bakat, dan cita-cita Anda. Penempatan akhir ditentukan oleh pewawancara berdasarkan hasil seleksi menyeluruh. Siswa tetap bisa menyatakan preferensi melalui pilihan 1, 2, dan 3.
</div>

<h3>Langkah 5 — Unggah Berkas / Dokumen</h3>
<p>Unggah dokumen persyaratan pendaftaran. Pastikan file yang diunggah:</p>
<ul>
    <li>Format file: <strong>JPG, PNG, atau PDF</strong></li>
    <li>Ukuran file: <strong>Maksimal 2 MB per file</strong></li>
    <li>Resolusi foto: cukup dan terbaca jelas</li>
</ul>
<table class="std-table">
    <tr><th>Dokumen</th><th>Ketentuan</th></tr>
    <tr><td><strong>Foto Siswa</strong></td><td>Foto formal terbaru, latar polos (putih atau merah), tampak wajah jelas</td></tr>
    <tr><td><strong>Kartu Keluarga (KK)</strong></td><td>Foto/scan KK asli yang masih berlaku dan terbaca jelas</td></tr>
    <tr><td><strong>Akta Kelahiran</strong></td><td>Foto/scan akta kelahiran asli yang masih berlaku</td></tr>
</table>

<p>Setelah semua berkas diunggah dan formulir langkah ke-5 disimpan, Anda akan diarahkan ke halaman <strong>Sukses</strong> yang menampilkan Nomor Pendaftaran Anda. Catat dan simpan nomor ini!</p>

<h2>8.4 Tes Diagnostik Gaya Belajar</h2>
<p>Setelah formulir selesai diisi, Anda akan mendapat akses ke <strong>Tes Gaya Belajar Mandiri</strong>. Tes ini bersifat wajib dan membantu pihak sekolah memahami cara belajar Anda yang paling efektif.</p>
<ul>
    <li>Akses melalui menu di dashboard siswa, atau via link: <strong>/spmb/tes-gaya-belajar</strong></li>
    <li>Terdiri dari kurang lebih <strong>20–30 pertanyaan</strong> seputar kebiasaan dan preferensi belajar</li>
    <li>Jawab sejujur-jujurnya, tidak ada jawaban benar atau salah</li>
    <li>Waktu pengerjaan tidak dibatasi</li>
    <li>Hasil analisis (Visual, Auditori, atau Kinestetik) akan langsung tersimpan di profil pendaftaran Anda</li>
</ul>

<h2>8.5 Mencetak Kartu Pendaftaran Mandiri</h2>
<p>Setelah pendaftaran berhasil, Anda dapat mencetak sendiri kartu pendaftaran sebagai bukti:</p>
<ol>
    <li>Buka halaman sukses pendaftaran atau masuk kembali ke akun Anda.</li>
    <li>Klik tombol <strong>"Cetak Kartu Pendaftaran"</strong>.</li>
    <li>Halaman cetak PDF akan terbuka di tab baru.</li>
    <li>Tekan <span class="kbd">Ctrl+P</span> untuk mencetak atau simpan sebagai PDF.</li>
    <li><strong>Bawa kartu ini saat datang ke sekolah</strong> untuk proses verifikasi, tes kesehatan, dan wawancara.</li>
</ol>
<div class="page-break"></div>

{{-- ============================================================ --}}
{{-- BAB 9: FAQ & KONTAK                                          --}}
{{-- ============================================================ --}}
<div class="chapter-header">
    <div class="chapter-number">Bab 9</div>
    <div class="chapter-title">Pertanyaan Umum (FAQ) &amp; Kontak Bantuan</div>
    <div class="chapter-desc">Solusi atas masalah umum dan informasi kontak dukungan teknis</div>
</div>

<h2>9.1 Pertanyaan yang Sering Diajukan</h2>

<h3>Untuk Calon Siswa</h3>
<div class="callout callout-info" style="margin-bottom:8px;">
    <div class="callout-title">❓ Kode OTP tidak diterima di WhatsApp, apa yang harus dilakukan?</div>
    Pastikan nomor WhatsApp yang dimasukkan benar dan aktif. Tunggu 30 detik lalu klik "Kirim Ulang OTP". Jika masih gagal, hubungi panitia dengan menyebutkan nama lengkap dan nomor HP Anda.
</div>
<div class="callout callout-info" style="margin-bottom:8px;">
    <div class="callout-title">❓ Apakah formulir bisa diisi bertahap (tidak harus selesai sekaligus)?</div>
    Ya. Setiap kali Anda klik "Simpan &amp; Lanjutkan", data tersimpan ke sistem. Anda bisa login kembali di lain waktu dan melanjutkan dari langkah terakhir yang sudah disimpan.
</div>
<div class="callout callout-info" style="margin-bottom:8px;">
    <div class="callout-title">❓ Apakah pilihan jurusan bisa diubah setelah formulir dikirim?</div>
    Perubahan pilihan jurusan setelah formulir dikirim harus dilakukan oleh Petugas Pendaftaran. Hubungi petugas dan sampaikan perubahan yang diinginkan beserta alasannya.
</div>
<div class="callout callout-info" style="margin-bottom:8px;">
    <div class="callout-title">❓ Berapa lama proses pendaftaran dari awal hingga dinyatakan diterima?</div>
    Durasi tergantung jadwal sekolah. Umumnya 1–2 minggu setelah formulir online dikirim hingga proses wawancara selesai. Pantau status pendaftaran Anda melalui akun siswa.
</div>

<h3>Untuk Petugas</h3>
<div class="callout callout-warning" style="margin-bottom:8px;">
    <div class="callout-title">❓ Petugas tidak bisa login, muncul pesan "Username/Password salah"</div>
    Pastikan tidak ada kesalahan pengetikan. Kata sandi bersifat case-sensitive (huruf besar/kecil berbeda). Jika lupa kata sandi, hubungi Administrator untuk melakukan reset.
</div>
<div class="callout callout-warning" style="margin-bottom:8px;">
    <div class="callout-title">❓ Daftar pendaftar di dashboard saya kosong</div>
    Kemungkinan belum ada pendaftar yang statusnya sesuai dengan tahap Anda. Contoh: Petugas Kesehatan hanya melihat pendaftar yang sudah diverifikasi berkasnya. Konfirmasi ke Petugas Pendaftaran.
</div>
<div class="callout callout-warning" style="margin-bottom:8px;">
    <div class="callout-title">❓ Bagaimana jika ada salah input data siswa setelah disimpan?</div>
    Data yang sudah disimpan dapat diubah selama statusnya belum ke tahap berikutnya. Jika perlu mengedit data yang sudah melewati tahap, mintalah kepada Administrator untuk melakukan koreksi.
</div>
<div class="callout callout-warning" style="margin-bottom:8px;">
    <div class="callout-title">❓ Upload foto/berkas siswa gagal</div>
    Pastikan ukuran file tidak melebihi 2 MB dan format file adalah JPG, PNG, atau PDF. Coba compress foto terlebih dahulu menggunakan aplikasi seperti TinyPNG atau Canva.
</div>

<h3>Untuk Administrator</h3>
<div class="callout callout-danger" style="margin-bottom:8px;">
    <div class="callout-title">❓ Notifikasi WhatsApp tidak terkirim ke siswa</div>
    Periksa konfigurasi di menu Pengaturan &gt; Nobox Gateway. Pastikan API Key, Account ID, dan Channel ID sudah benar. Gunakan fitur "Test Kirim Pesan" untuk memverifikasi koneksi. Jika gagal, periksa saldo/kuota akun Nobox.ai Anda.
</div>
<div class="callout callout-danger" style="margin-bottom:8px;">
    <div class="callout-title">❓ Laporan Excel tidak bisa diunduh</div>
    Pastikan ada data pendaftaran yang tersimpan. Jika masalah berlanjut, mungkin ada kendala pada konfigurasi server. Hubungi tim IT atau pengembang sistem.
</div>

<h2>9.2 Informasi Kontak Bantuan</h2>
<table class="std-table">
    <tr>
        <th style="width:30%;">Jenis Bantuan</th>
        <th style="width:35%;">Kontak / Cara Menghubungi</th>
        <th>Jam Layanan</th>
    </tr>
    <tr>
        <td><strong>Masalah Pendaftaran Online</strong><br><em>(OTP, formulir, login siswa)</em></td>
        <td>WhatsApp Panitia SPMB:<br><strong>[Nomor WA Panitia]</strong></td>
        <td>Senin–Sabtu<br>07.30–15.30 WIB</td>
    </tr>
    <tr>
        <td><strong>Bantuan Teknis Sistem</strong><br><em>(error, bug, fitur tidak berfungsi)</em></td>
        <td>Email IT Sekolah:<br><strong>[email-IT@sekolah.sch.id]</strong></td>
        <td>Senin–Jumat<br>08.00–16.00 WIB</td>
    </tr>
    <tr>
        <td><strong>Reset Password Petugas</strong></td>
        <td>Hubungi Administrator Sistem secara langsung atau melalui WhatsApp internal sekolah</td>
        <td>Jam Kerja Sekolah</td>
    </tr>
    <tr>
        <td><strong>Informasi SPMB &amp; Jurusan</strong></td>
        <td>Datang langsung ke sekretariat sekolah atau kunjungi halaman <strong>/informasi/spmb</strong></td>
        <td>Jam Kerja Sekolah</td>
    </tr>
</table>

<hr class="divider">

<div style="text-align:center; padding: 20px; background:#f8fafc; border-radius:6px; border: 1px solid #e2e8f0;">
    <div style="font-size:14pt; font-weight:bold; color:#1e3a8a; margin-bottom:8px;">📘 Buku Panduan Aplikasi Web Sekolah &amp; SPMB</div>
    <div style="font-size:9.5pt; color:#64748b;">SMK Muhammadiyah 1 Bantul &nbsp;·&nbsp; Versi 1.0 &nbsp;·&nbsp; {{ date('d F Y') }}</div>
    <div style="font-size:9pt; color:#94a3b8; margin-top:8px;">Dokumen ini dibuat secara otomatis oleh sistem dan dilindungi hak ciptanya.</div>
    <div style="font-size:9pt; color:#94a3b8;">Dilarang memperbanyak, menyebarluaskan, atau memodifikasi tanpa izin tertulis dari pihak sekolah.</div>
</div>

</body>
</html>
