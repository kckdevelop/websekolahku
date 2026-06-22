<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proposal Penawaran Pembuatan Aplikasi Web Sekolah & SPMB Terintegrasi</title>
    <style>
        @page {
            margin: 1.8cm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #334155;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        
        /* Fixed Header & Footer on every page */
        .header {
            position: fixed;
            top: -45px;
            left: 0;
            right: 0;
            height: 30px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 8pt;
            color: #94a3b8;
            line-height: 20px;
        }
        .header-left {
            float: left;
        }
        .header-right {
            float: right;
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: -45px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #e2e8f0;
            font-size: 8pt;
            color: #94a3b8;
            line-height: 30px;
        }
        .footer-left {
            float: left;
        }
        .footer-right {
            float: right;
            text-align: right;
        }
        .page-number:after {
            content: counter(page);
        }

        .page-break {
            page-break-after: always;
        }
        
        /* Clearfix */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Cover Page Styling */
        .cover-container {
            padding-top: 40px;
            text-align: center;
            height: 100%;
        }
        .cover-badge {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            padding: 6px 16px;
            font-size: 10pt;
            font-weight: bold;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 30px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .cover-title {
            font-size: 26pt;
            color: #1e3b8b;
            font-weight: bold;
            line-height: 1.25;
            margin-top: 20px;
            margin-bottom: 15px;
        }
        .cover-subtitle {
            font-size: 14pt;
            color: #64748b;
            margin-bottom: 60px;
            font-weight: normal;
        }
        .cover-accent {
            width: 120px;
            height: 4px;
            background-color: #2563eb;
            margin: 0 auto 50px auto;
            border-radius: 2px;
        }
        .cover-illustration {
            margin: 40px auto;
            width: 250px;
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid #e2e8f0;
        }
        .cover-illustration-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .cover-illustration-desc {
            font-size: 9pt;
            color: #64748b;
        }
        .cover-meta {
            margin-top: 100px;
            font-size: 10.5pt;
            color: #475569;
            line-height: 1.8;
            border-top: 1px solid #f1f5f9;
            padding-top: 30px;
        }
        .school-name {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
        }

        /* Headings & Content Styling */
        h1, h2, h3, h4 {
            color: #0f172a;
            font-weight: bold;
            margin-top: 0;
        }
        h1 {
            font-size: 20pt;
            color: #1e3a8a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 15pt;
            color: #1e3a8a;
            margin-top: 30px;
            margin-bottom: 15px;
            border-left: 4px solid #2563eb;
            padding-left: 10px;
        }
        h3 {
            font-size: 11.5pt;
            color: #0f172a;
            margin-top: 20px;
            margin-bottom: 8px;
        }
        p {
            margin-top: 0;
            margin-bottom: 12px;
            text-align: justify;
        }
        
        /* Lists */
        ul, ol {
            margin-top: 0;
            margin-bottom: 15px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 6px;
            text-align: justify;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0 25px 0;
            font-size: 9pt;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 8.5pt;
        }
        tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .table-total {
            font-weight: bold;
            background-color: #eff6ff !important;
            color: #1e3a8a;
        }

        /* Utilities */
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .font-bold {
            font-weight: bold;
        }
        .text-muted {
            color: #64748b;
        }
        .text-primary {
            color: #2563eb;
        }
        
        /* Callouts / Alert boxes */
        .callout {
            background-color: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 12px 15px;
            margin: 15px 0;
            border-radius: 0 6px 6px 0;
        }
        .callout-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 4px;
            font-size: 10pt;
        }
        .callout-content {
            font-size: 9pt;
            line-height: 1.4;
        }

        .highlight-box {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 12px;
            border-radius: 6px;
            margin: 15px 0;
        }

        /* Feature Cards */
        .feature-grid {
            margin: 15px 0;
        }
        .feature-card {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #ffffff;
        }
        .feature-title {
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 4px;
            font-size: 10pt;
        }
        .feature-desc {
            font-size: 9pt;
            color: #475569;
        }

        .price-badge {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 2px 8px;
            font-size: 8.5pt;
            font-weight: bold;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- COVER PAGE (No headers/footers displayed by keeping them in pages starting from page 2) -->
    <div class="cover-container">
        <div class="cover-badge">Proposal Penawaran</div>
        <div class="cover-title">SISTEM INFORMASI SEKOLAH INTEGRATIF &<br>PORTAL SPMB ONLINE MULTI-ROLE</div>
        <div class="cover-subtitle">Solusi Digitalisasi Administrasi Sekolah, Humas, dan Penerimaan Siswa Baru</div>
        <div class="cover-accent"></div>

        <div class="cover-illustration">
            <div class="cover-illustration-title">Web Portal & SPMB App</div>
            <div class="cover-illustration-desc">
                Sistem terintegrasi yang menghubungkan Calon Siswa, Panitia Pendaftaran, Tim Medis, Pewawancara, Bagian Keuangan, dan Administrator dalam satu alur kerja real-time.
            </div>
        </div>
        
        <div class="cover-meta">
            Diajukan Kepada:<br>
            <span class="school-name">Bapak/Ibu Kepala Sekolah & Pimpinan Institusi Pendidikan</span><br>
            <div style="margin-top: 15px; font-size: 9.5pt;" class="text-muted">
                Dibuat Oleh: <strong>Tim Pengembang Software</strong><br>
                Tanggal Pengajuan: {{ date('d F Y') }}<br>
                Status Dokumen: Rahasia & Terbatas
            </div>
        </div>
    </div>

    <!-- First page ends here -->
    <div class="page-break"></div>

    <!-- HEADERS & FOOTERS (Will apply from page 2 onwards in PDF renderer) -->
    <div class="header clearfix">
        <div class="header-left">Proposal Penawaran Aplikasi Web Sekolah & SPMB</div>
        <div class="header-right">Kerahasiaan Terjamin</div>
    </div>

    <div class="footer clearfix">
        <div class="footer-left">© {{ date('Y') }} Tim Pengembang Software. Hak Cipta Dilindungi.</div>
        <div class="footer-right">Halaman <span class="page-number"></span></div>
    </div>

    <!-- DAFTAR ISI / DAFTAR RINGKAS -->
    <h1>Ringkasan Eksekutif</h1>
    <p>
        Di era transformasi digital saat ini, institusi pendidikan dituntut untuk mengelola data secara cepat, akurat, dan transparan. Dua aspek krusial sekolah yang paling membutuhkan bantuan digitalisasi adalah <strong>pencitraan publik (kehumasan)</strong> melalui website profil sekolah, dan <strong>Sistem Seleksi Penerimaan Murid Baru (SPMB)</strong> yang efisien dan terstruktur.
    </p>
    <p>
        Seringkali sekolah menggunakan sistem pendaftaran online yang hanya berfungsi sebagai "formulir digital" statis (seperti Google Form) tanpa alur kerja kelanjutan. Akibatnya, panitia pendaftaran, tim kesehatan, pewawancara, dan bagian keuangan harus bekerja secara manual menggunakan kertas atau spreadsheet terpisah, yang berisiko memicu kesalahan data, kelambatan proses, serta ketidaknyamanan bagi calon siswa.
    </p>
    <div class="callout">
        <div class="callout-title">Solusi Terintegrasi Kami</div>
        <div class="callout-content">
            Kami menawarkan sistem <strong>Web Sekolah Integratif & SPMB Online Multi-Role</strong>. Sebuah platform web terpadu yang menggabungkan portal informasi publik sekolah dengan sistem penerimaan murid baru yang memiliki alur kerja penilaian (medis, wawancara, keuangan) secara terkomputerisasi penuh dan terintegrasi dengan WhatsApp Gateway.
        </div>
    </div>

    <h2>Tujuan Aplikasi</h2>
    <ul>
        <li><strong>Meningkatkan Citra Sekolah:</strong> Media informasi interaktif untuk memperkenalkan profil sekolah, program keahlian/jurusan, prestasi, fasilitas, dan berita terbaru kepada masyarakat luas secara profesional.</li>
        <li><strong>Efisiensi Operasional SPMB:</strong> Memangkas proses administrasi manual calon siswa baru melalui alur kerja digital yang terbagi dalam beberapa peran staf khusus.</li>
        <li><strong>Akurasi & Keamanan Data:</strong> Penyimpanan data pendaftaran, rekam kesehatan, hasil wawancara, dan riwayat pembayaran calon siswa dalam satu database terpusat yang aman.</li>
        <li><strong>Transparansi Pembayaran:</strong> Memudahkan pelacakan pembayaran biaya masuk sekolah (dapat diangsur/dicicil) dengan progress persentase dan cetak kwitansi digital secara langsung.</li>
    </ul>

    <h2>Keunggulan Utama Aplikasi</h2>
    <div class="feature-grid">
        <div class="feature-card">
            <div class="feature-title">1. Alur Kerja Multi-Role Profesional (Collaborative Workflow)</div>
            <div class="feature-desc">Sistem tidak hanya mengumpulkan data formulir, melainkan memprosesnya melalui dashboard khusus untuk Petugas Pendaftaran (cek berkas), Petugas Kesehatan (tes fisik), Petugas Wawancara (uji kompetensi/agama), dan Petugas Pembayaran (keuangan).</div>
        </div>
        <div class="feature-card">
            <div class="feature-title">2. Tes Diagnostic Gaya Belajar Mandiri (Learning Style Test)</div>
            <div class="feature-desc">Calon siswa dapat mengikuti tes gaya belajar (Visual, Auditori, Kinestetik) langsung dari portal aplikasi. Hasil analisis kognitif ini akan otomatis masuk ke database dan dapat dibaca langsung oleh petugas wawancara.</div>
        </div>
        <div class="feature-card">
            <div class="feature-title">3. Notifikasi WhatsApp Otomatis (WhatsApp Gateway Integration)</div>
            <div class="feature-desc">Integrasi dengan API WhatsApp (seperti Nobox) memungkinkan sistem mengirimkan kode OTP verifikasi pendaftaran, notifikasi kelulusan berkas, tagihan pembayaran, dan bukti pembayaran secara real-time ke nomor WhatsApp siswa/orang tua.</div>
        </div>
        <div class="feature-card">
            <div class="feature-title">4. Manajemen Pembayaran Fleksibel & Terperinci</div>
            <div class="feature-desc">Sistem mendukung penetapan tagihan biaya pendidikan (SPP, Sumbangan, Biaya Awal Tahun) secara custom per siswa (termasuk diskon khusus seperti status Yatim Piatu). Mendukung pelacakan cicilan pembayaran dan pencetakan bukti bayar instan.</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- ARSITEKTUR DAN DETAIL FITUR -->
    <h1>Fitur dan Spesifikasi Sistem</h1>
    <p>Aplikasi ini dikembangkan menggunakan arsitektur web modern yang aman dan responsif. Sistem terbagi menjadi dua bagian utama: <strong>Website Publik Sekolah (Frontend Portal)</strong> dan <strong>Sistem Aplikasi SPMB & CMS (Backend Portal)</strong>.</p>

    <h2>1. Modul Website Profil Publik</h2>
    <p>Sebagai sarana representasi sekolah di dunia digital, modul ini berisi:</p>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Halaman / Fitur</th>
                <th>Fungsi dan Kemampuan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Homepage Dinamis</strong></td>
                <td>Menampilkan Hero Slider promo, Sambutan Kepala Sekolah, cuplikan berita terbaru, daftar prestasi terbaru, ulasan testimoni, dan logotype mitra industri kerja sama.</td>
            </tr>
            <tr>
                <td><strong>Profil Sekolah Lengkap</strong></td>
                <td>Halaman statis yang memuat Identitas Sekolah, Visi & Misi, Sejarah Pendirian, serta galeri sarana dan prasarana Fasilitas Sekolah.</td>
            </tr>
            <tr>
                <td><strong>Katalog Jurusan Interaktif</strong></td>
                <td>Menyediakan informasi detail program keahlian (contoh: TKR, TBSM, TPM, TAV, RPL) yang berisi poin-poin unggulan, prospek kerja, dan galeri dokumentasi foto kegiatan masing-masing jurusan.</td>
            </tr>
            <tr>
                <td><strong>Galeri Multimedia</strong></td>
                <td>Galeri Foto (integrasi folder drive) dan Galeri Video (berbasis tautan YouTube) yang dikelompokkan berdasarkan kategori kegiatan.</td>
            </tr>
            <tr>
                <td><strong>Berita & Prestasi</strong></td>
                <td>Portal berita/artikel sekolah (dengan fitur pencarian dan paginasi) serta daftar prestasi siswa/guru tingkat Kabupaten, Provinsi, maupun Nasional.</td>
            </tr>
            <tr>
                <td><strong>Formulir Kontak Masuk</strong></td>
                <td>Halaman Hubungi Kami yang memungkinkan masyarakat mengirim pesan langsung ke sistem database administrator sekolah.</td>
            </tr>
        </tbody>
    </table>

    <h2>2. Modul Seleksi Penerimaan Murid Baru (SPMB)</h2>
    <p>Merupakan inti sistem administrasi penerimaan siswa baru, yang terbagi dalam alur kerja kolaboratif:</p>

    <h3>A. Portal Calon Siswa (Pendaftar)</h3>
    <ul>
        <li><strong>Autentikasi Aman & Verifikasi OTP:</strong> Registrasi calon siswa menggunakan email atau nomor HP yang divalidasi dengan kode OTP WhatsApp otomatis demi menghindari pendaftaran fiktif.</li>
        <li><strong>Wizard Formulir 5 Langkah (Step-by-Step Form):</strong> Pengisian formulir pendaftaran yang terbagi dalam step logis: Biodata Diri, Data Orang Tua, Alamat Asal & Tinggal, Pilihan Jurusan (pilihan 1, 2, dan 3), dan Unggah Dokumen Administrasi (Akta Kelahiran, Kartu Keluarga, Foto Diri).</li>
        <li><strong>Tes Diagnostic Mandiri:</strong> Fitur ujian online singkat untuk memetakan gaya belajar calon siswa guna membantu proses seleksi peminatan oleh pewawancara.</li>
        <li><strong>Cetak Kartu Pendaftaran:</strong> Setelah divalidasi, siswa dapat mengunduh dan mencetak Kartu Bukti Pendaftaran berformat PDF yang dilengkapi barcode.</li>
    </ul>

    <h3>B. Panel Multi-Role Staf (Petugas Penilai)</h3>
    <p>Petugas sekolah memiliki akses dashboard terbatas sesuai dengan tanggung jawabnya masing-masing:</p>
    <ul>
        <li><strong>Petugas Pendaftaran (Front-Office):</strong> Melakukan verifikasi keabsahan dokumen fisik dan digital calon siswa. Mengunggah pas foto resmi siswa, mencetak kartu pendaftaran fisik, serta mengubah status pendaftaran berkas menjadi verified.</li>
        <li><strong>Petugas Kesehatan (UKS):</strong> Melakukan pemeriksaan fisik dan memasukkan data medis berupa Tinggi Badan, Berat Badan, Golongan Darah, deteksi Buta Warna (Ya/Tidak), Mata Minus (Ya/Tidak), Tato/Tindik, dan riwayat penyakit kronis.</li>
        <li><strong>Petugas Wawancara (BK / Penguji):</strong> Melakukan penilaian baca tulis Al-Quran, kebiasaan sholat fardhu, penilaian kepribadian, minat bakat, membaca hasil analisis kognitif gaya belajar, memberikan catatan wawancara, dan mengusulkan jurusan final yang diterima.</li>
        <li><strong>Petugas Pembayaran (Keuangan):</strong> Menetapkan total tagihan biaya masuk (SPP, Uang Seragam, Dana Awal Tahun, Infaq, Zakat), menerapkan potongan beasiswa (termasuk pembebasan biaya beasiswa yatim piatu), menginput riwayat cicilan pembayaran siswa, serta mencetak tanda terima/kwitansi pembayaran digital.</li>
    </ul>

    <div class="page-break"></div>

    <h3>C. Panel Administrator Utama (Sistem Kontrol Penuh)</h3>
    <p>Dashboard kontrol bagi Kepala Sekolah atau Ketua Panitia SPMB:</p>
    <ul>
        <li><strong>Dashboard Statistik Real-time:</strong> Grafik dan metrik jumlah pendaftar per gelombang, persentase kelulusan, statistik pilihan jurusan, total uang pendaftaran masuk, dan sekolah asal pendaftar terbanyak.</li>
        <li><strong>Manajemen Gelombang:</strong> Menambah, mengaktifkan, dan menonaktifkan gelombang pendaftaran SPMB beserta tanggal mulai/berakhirnya.</li>
        <li><strong>Content Management System (CMS):</strong> Mengelola seluruh isi website sekolah seperti artikel berita, dokumentasi prestasi, foto galeri, video tutorial, data mitra industri, testimoni, dan sambutan kepala sekolah.</li>
        <li><strong>Manajemen User & Staf:</strong> Mendaftarkan akun administrator baru dan akun-akun staf petugas beserta penetapan hak akses role (Petugas Pendaftaran, Kesehatan, Wawancara, Pembayaran).</li>
        <li><strong>Pengaturan Sistem & API Gateway:</strong> Konfigurasi koneksi database, email SMTP, dan integrasi WhatsApp Gateway (token API, pengirim pesan massal, pengujian koneksi).</li>
        <li><strong>Ekspor Laporan Excel & Reset Database:</strong> Mengunduh seluruh data calon siswa yang masuk berdasarkan gelombang ke dalam berkas Excel (.xlsx) untuk kebutuhan pelaporan dinas, serta fitur pembersihan database/reset data sebelum memulai tahun ajaran baru.</li>
    </ul>

    <div class="highlight-box">
        <span class="font-bold">Keamanan Aplikasi & Keandalan Data:</span><br>
        Sistem dibangun menggunakan framework <strong>Laravel</strong> yang terkenal memiliki pertahanan bawaan sangat kuat terhadap serangan keamanan web standar seperti <em>SQL Injection, Cross-Site Request Forgery (CSRF)</em>, dan <em>Cross-Site Scripting (XSS)</em>. Keamanan berkas yang diunggah diproteksi menggunakan enkripsi nama file dan validasi tipe mime.
    </div>

    <h1>Alur Proses SPMB Terintegrasi</h1>
    <p>Diagram alur di bawah ini menunjukkan bagaimana proses pendaftaran dikelola dari awal hingga calon siswa resmi diterima:</p>
    <div style="background-color: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px; margin: 15px 0;">
        <ol style="margin-bottom: 0;">
            <li><strong>Tahap 1: Registrasi Online</strong><br><span class="text-muted">Calon siswa mendaftarkan akun di website SPMB, melakukan verifikasi OTP via WhatsApp, dan melakukan login ke sistem.</span></li>
            <li><strong>Tahap 2: Pengisian Data & Berkas</strong><br><span class="text-muted">Siswa mengisi formulir pendaftaran 5 langkah (biodata, ortu, alamat, jurusan) dan mengunggah berkas administrasi (KK, Akta, dll).</span></li>
            <li><strong>Tahap 3: Ujian Diagnostik Gaya Belajar</strong><br><span class="text-muted">Siswa mengisi kuesioner gaya belajar di sistem untuk mendeteksi profil belajarnya secara otomatis.</span></li>
            <li><strong>Tahap 4: Verifikasi & Cek Fisik Medis</strong><br><span class="text-muted">Petugas pendaftaran memverifikasi kelengkapan berkas fisik. Petugas UKS melakukan cek fisik (tinggi, berat badan, buta warna, tato/tindik) dan menginput hasilnya ke sistem.</span></li>
            <li><strong>Tahap 5: Tes Wawancara & Peminatan</strong><br><span class="text-muted">Petugas wawancara menguji kemampuan agama (Al-Quran, sholat), membaca hasil tes gaya belajar, menilai kepribadian, lalu merekomendasikan jurusan yang diterima.</span></li>
            <li><strong>Tahap 6: Penetapan Biaya & Pembayaran</strong><br><span class="text-muted">Bagian keuangan mengonfirmasi tagihan biaya masuk (termasuk diskon/potongan khusus), menerima pembayaran/cicilan pertama dari orang tua, menginput ke sistem, dan mencetak kwitansi pembayaran. Status pendaftaran siswa berubah menjadi "Diterima / Aktif".</span></li>
        </ol>
    </div>

    <div class="page-break"></div>

    <h1>Investasi dan Paket Penawaran</h1>
    <p>Kami menawarkan 3 skema paket investasi pengembangan aplikasi web sekolah & SPMB yang dapat disesuaikan dengan kebutuhan dan anggaran institusi Anda:</p>

    <table>
        <thead>
            <tr>
                <th style="width: 35%;">Fitur & Layanan</th>
                <th style="width: 20%;" class="text-center">Standard</th>
                <th style="width: 20%;" class="text-center">Professional</th>
                <th style="width: 25%;" class="text-center">Enterprise (Full)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-bold">Website Profil Sekolah (CMS)</td>
                <td class="text-center text-primary">✔</td>
                <td class="text-center text-primary">✔</td>
                <td class="text-center text-primary">✔</td>
            </tr>
            <tr>
                <td class="font-bold">Portal SPMB Online Calon Siswa</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-primary">✔</td>
                <td class="text-center text-primary">✔</td>
            </tr>
            <tr>
                <td class="font-bold">Integrasi WhatsApp Gateway</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-primary">✔ (OTP & Pengumuman)</td>
                <td class="text-center text-primary">✔ (OTP, Tagihan & Kwitansi)</td>
            </tr>
            <tr>
                <td class="font-bold">Tes Gaya Belajar Diagnostic</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-primary">✔ (Mandiri Online)</td>
            </tr>
            <tr>
                <td class="font-bold">Panel Multi-Role Staf Penilai</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-primary">✔ (Medis, Wawancara, Keuangan)</td>
            </tr>
            <tr>
                <td class="font-bold">Manajemen Cicilan Keuangan</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-primary">✔ (Kwitansi PDF)</td>
            </tr>
            <tr>
                <td class="font-bold">Ekspor Data Excel & Reset DB</td>
                <td class="text-center text-muted">✖</td>
                <td class="text-center text-primary">✔</td>
                <td class="text-center text-primary">✔</td>
            </tr>
            <tr>
                <td class="font-bold">Dukungan Pemeliharaan (Support)</td>
                <td class="text-center">3 Bulan</td>
                <td class="text-center">6 Bulan</td>
                <td class="text-center">12 Bulan (Prioritas)</td>
            </tr>
            <tr class="table-total">
                <td class="font-bold">Investasi Pengembangan</td>
                <td class="text-center"><span class="price-badge">IDR 15.000.000</span></td>
                <td class="text-center"><span class="price-badge">IDR 35.000.000</span></td>
                <td class="text-center"><span class="price-badge">IDR 50.000.000</span></td>
            </tr>
        </tbody>
    </table>

    <div class="callout" style="background-color: #f0fdf4; border-left-color: #22c55e;">
        <div class="callout-title" style="color: #15803d;">Rekomendasi Paket: Enterprise</div>
        <div class="callout-content" style="color: #1e3a8a;">
            Paket <strong>Enterprise</strong> adalah representasi penuh dari aplikasi yang sudah dirancang pada codebase saat ini. Memiliki semua modul multi-role (Administrasi, UKS, BK, Keuangan, dan Siswa) yang menjamin kelancaran SPMB tanpa hambatan komunikasi antar divisi kerja sekolah.
        </div>
    </div>

    <h2>Rencana Pelaksanaan Proyek (Timeline)</h2>
    <p>Pengembangan hingga serah terima sistem diperkirakan memakan waktu <strong>8 minggu (2 bulan)</strong> dengan rincian:</p>
    <table>
        <thead>
            <tr>
                <th style="width: 15%;" class="text-center">Tahap</th>
                <th style="width: 35%;">Aktivitas Pengerjaan</th>
                <th style="width: 20%;" class="text-center">Durasi</th>
                <th style="width: 30%;">Output / Hasil Kerja</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center font-bold">1</td>
                <td>Analisis Kebutuhan & Desain Database Finall</td>
                <td class="text-center">Minggu 1</td>
                <td>Dokumen SRD & Wireframe Desain</td>
            </tr>
            <tr>
                <td class="text-center font-bold">2</td>
                <td>Pembuatan Frontend Portal Sekolah & CMS Admin</td>
                <td class="text-center">Minggu 2 - 3</td>
                <td>Website Profil Aktif (CMS Profil)</td>
            </tr>
            <tr>
                <td class="text-center font-bold">3</td>
                <td>Pengembangan Portal SPMB Calon Siswa & Form Wizard</td>
                <td class="text-center">Minggu 4 - 5</td>
                <td>Sistem Registrasi & Form 5 Step Aktif</td>
            </tr>
            <tr>
                <td class="text-center font-bold">4</td>
                <td>Pengembangan Panel Staf Penilai (Kesehatan, Wawancara, Pembayaran)</td>
                <td class="text-center">Minggu 6</td>
                <td>Dashboard Petugas Medis/BK/Kasir Aktif</td>
            </tr>
            <tr>
                <td class="text-center font-bold">5</td>
                <td>Integrasi API WhatsApp (Nobox) & Uji Sistem</td>
                <td class="text-center">Minggu 7</td>
                <td>Sistem Notifikasi OTP & Konfirmasi Otomatis</td>
            </tr>
            <tr>
                <td class="text-center font-bold">6</td>
                <td>Pelatihan Operator, Deployment, & Serah Terima</td>
                <td class="text-center">Minggu 8</td>
                <td>Aplikasi live di Server Sekolah & Manual Book</td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <h1>Penutup</h1>
    <p>
        Penerapan aplikasi <strong>Web Sekolah Integratif & SPMB Online Multi-Role</strong> ini merupakan investasi strategis yang akan memberikan dampak positif jangka panjang bagi sekolah. Melalui sistem yang paperless, terkomputerisasi, dan saling terhubung, sekolah dapat menyajikan pelayanan yang modern, profesional, dan tepercaya bagi calon siswa dan masyarakat umum.
    </p>
    <p>
        Kami berkomitmen untuk mendampingi institusi Anda mulai dari tahap analisis, implementasi, pelatihan pengguna, hingga dukungan teknis pasca-rilis. Kami sangat berharap dapat bekerja sama dengan sekolah Bapak/Ibu untuk mewujudkan digitalisasi sekolah yang unggul dan berkemajuan.
    </p>
    <p>
        Demikian proposal penawaran ini kami ajukan. Atas perhatian, waktu, dan kerja sama yang baik dari Bapak/Ibu pimpinan sekolah, kami ucapkan terima kasih.
    </p>

    <div style="margin-top: 60px;">
        <table style="border: none; margin: 0; padding: 0;">
            <tr style="background: none;">
                <td style="border: none; width: 50%; padding: 0;">
                    Disetujui Oleh,<br>
                    <strong>Pihak Sekolah</strong>
                    <br><br><br><br><br>
                    (......................................................)<br>
                    <span class="text-muted">Jabatan:</span>
                </td>
                <td style="border: none; width: 50%; padding: 0;" class="text-right">
                    Diajukan Oleh,<br>
                    <strong>Pihak Pengembang</strong>
                    <br><br><br><br><br>
                    <strong><u>Tim Pengembang Software</u></strong><br>
                    <span class="text-muted">Project Manager</span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
