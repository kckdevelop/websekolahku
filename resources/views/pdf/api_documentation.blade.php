<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dokumentasi API Berita dan Prestasi</title>
    <style>
        @page {
            margin: 2cm;
            @bottom-right {
                content: counter(page);
            }
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #334155;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4 {
            color: #0f172a;
            font-weight: bold;
            margin-top: 0;
        }
        h1 {
            font-size: 26pt;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 30px;
            color: #1e3a8a;
        }
        h2 {
            font-size: 18pt;
            color: #1e3a8a;
            margin-top: 40px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }
        h3 {
            font-size: 13pt;
            color: #0f172a;
            margin-top: 25px;
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 15px;
        }
        .text-muted {
            color: #64748b;
        }
        .page-break {
            page-break-after: always;
        }
        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 10pt;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            color: #1e293b;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 9pt;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-get {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }
        .badge-post {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }
        /* Code boxes */
        pre {
            background-color: #0f172a;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 6px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 9.5pt;
            overflow-x: auto;
            margin: 15px 0;
            white-space: pre-wrap;
            word-break: break-all;
        }
        code {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 2px 5px;
            border-radius: 4px;
            font-size: 9.5pt;
        }
        pre code {
            background-color: transparent;
            color: inherit;
            padding: 0;
        }
        /* Callouts */
        .callout {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 6px 6px 0;
        }
        .callout-title {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }
        /* Cover Page Styling */
        .cover-page {
            text-align: center;
            padding-top: 100px;
            height: 100%;
        }
        .cover-title {
            font-size: 28pt;
            color: #1e3a8a;
            margin-bottom: 10px;
            font-weight: bold;
            line-height: 1.2;
        }
        .cover-subtitle {
            font-size: 16pt;
            color: #64748b;
            margin-bottom: 80px;
        }
        .cover-meta {
            margin-top: 200px;
            font-size: 11pt;
            color: #475569;
            line-height: 1.8;
        }
        .school-name {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <!-- COVER PAGE -->
    <div class="cover-page">
        <div style="margin-bottom: 50px;">
            <span style="font-size: 48pt; color: #1e3a8a; font-weight: bold;">API</span>
        </div>
        <div class="cover-title">DOKUMENTASI API<br>BERITA & PRESTASI</div>
        <div class="cover-subtitle">SMK Muhammadiyah 1 Bantul</div>
        
        <div class="cover-meta">
            <div class="school-name">SMK Muhammadiyah 1 Bantul</div>
            <div>Tahun Ajaran 2026/2027</div>
            <div class="text-muted">Dibuat otomatis oleh Sistem Dokumentasi Sekolah</div>
            <div class="text-muted" style="margin-top: 15px;">Terakhir Diperbarui: {{ date('d F Y') }}</div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- TABLE OF CONTENTS / OVERVIEW -->
    <h2>1. Deskripsi Umum</h2>
    <p>Dokumentasi ini berisi panduan penggunaan Application Programming Interface (API) untuk menampilkan data berita dan prestasi dari sistem informasi SMK Muhammadiyah 1 Bantul. API ini dirancang untuk dapat diintegrasikan dengan aplikasi mobile, website eksternal, maupun platform digital lainnya.</p>

    <div class="callout">
        <div class="callout-title">Base URL</div>
        <div>Semua permintaan API harus diarahkan ke URL dasar berikut:</div>
        <div style="font-family: monospace; font-weight: bold; margin-top: 5px; font-size: 11pt; color: #0f172a;">
            {{ url('/api') }}
        </div>
    </div>

    <h3>Format Respon</h3>
    <p>API mengembalikan data dalam format <strong>JSON</strong> standar. Setiap respon sukses yang berupa daftar data (paginated) akan dibungkus dalam objek <code>data</code> beserta metadata navigasi pagination standar Laravel.</p>

    <h3>HTTP Status Code</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Status Code</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>200 OK</code></td>
                <td>Permintaan sukses dijalankan. Data dikembalikan dalam format JSON.</td>
            </tr>
            <tr>
                <td><code>404 Not Found</code></td>
                <td>Resource yang dicari tidak ditemukan (misal: ID atau Slug tidak valid).</td>
            </tr>
            <tr>
                <td><code>500 Server Error</code></td>
                <td>Terjadi kesalahan internal pada server aplikasi.</td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <!-- BERITA ENDPOINTS -->
    <h2>2. API Berita</h2>

    <!-- GET ALL BERITA -->
    <h3>2.1 Menampilkan Daftar Berita</h3>
    <p>Digunakan untuk mengambil semua data berita yang berstatus aktif (bukan draft), diurutkan dari berita terbaru.</p>
    
    <p>
        <span class="badge badge-get">GET</span> 
        <code>/berita</code>
    </p>

    <h4>Parameter Query (Opsional)</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Parameter</th>
                <th style="width: 15%;">Tipe</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>search</code></td>
                <td>String</td>
                <td>Pencarian berita berdasarkan <code>judul</code> atau isi <code>konten</code>.</td>
            </tr>
            <tr>
                <td><code>limit</code></td>
                <td>Integer</td>
                <td>Jumlah berita per halaman (default: <code>10</code>).</td>
            </tr>
            <tr>
                <td><code>page</code></td>
                <td>Integer</td>
                <td>Nomor halaman pagination (default: <code>1</code>).</td>
            </tr>
        </tbody>
    </table>

    <h4>Contoh Respon Sukses (200 OK)</h4>
    <pre>{
  "data": [
    {
      "id": 5,
      "judul": "SMK Muhammadiyah 1 Bantul Menjuarai Lomba Coding DIY",
      "slug": "smk-muhammadiyah-1-bantul-menjuarai-lomba-coding-diy",
      "konten": "<p>Siswa RPL SMK Muhammadiyah 1 Bantul berhasil meraih juara pertama...</p>",
      "ringkasan": "Siswa RPL SMK Muhammadiyah 1 Bantul berhasil meraih juara pertama dalam ajang Lomba Coding...",
      "gambar_url": "/storage/berita/lomba-coding.jpg",
      "tanggal": "2026-06-20",
      "created_at": "2026-06-20T13:00:00+07:00"
    }
  ],
  "links": {
    "first": "{{ url('/api/berita?page=1') }}",
    "last": "{{ url('/api/berita?page=1') }}",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "{{ url('/api/berita') }}",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}</pre>

    <div class="page-break"></div>

    <!-- GET SINGLE BERITA -->
    <h3>2.2 Menampilkan Detail Berita</h3>
    <p>Digunakan untuk mengambil satu data berita secara detail berdasarkan <strong>ID</strong> atau <strong>Slug</strong>.</p>
    
    <p>
        <span class="badge badge-get">GET</span> 
        <code>/berita/{id_or_slug}</code>
    </p>

    <h4>Contoh URL Permintaan</h4>
    <ul>
        <li>Menggunakan Slug (Rekomendasi): <code>/api/berita/smk-muhammadiyah-1-bantul-menjuarai-lomba-coding-diy</code></li>
        <li>Menggunakan ID: <code>/api/berita/5</code></li>
    </ul>

    <h4>Contoh Respon Sukses (200 OK)</h4>
    <pre>{
  "data": {
    "id": 5,
    "judul": "SMK Muhammadiyah 1 Bantul Menjuarai Lomba Coding DIY",
    "slug": "smk-muhammadiyah-1-bantul-menjuarai-lomba-coding-diy",
    "konten": "<p>Siswa RPL SMK Muhammadiyah 1 Bantul berhasil meraih juara pertama dalam ajang Lomba Coding Tingkat Provinsi...</p>",
    "ringkasan": "Siswa RPL SMK Muhammadiyah 1 Bantul berhasil meraih juara pertama dalam ajang Lomba Coding...",
    "gambar_url": "/storage/berita/lomba-coding.jpg",
    "tanggal": "2026-06-20",
    "created_at": "2026-06-20T13:00:00+07:00"
  }
}</pre>

    <h4>Contoh Respon Error (404 Not Found)</h4>
    <pre>{
  "success": false,
  "message": "Berita tidak ditemukan."
}</pre>

    <div class="page-break"></div>

    <!-- PRESTASI ENDPOINTS -->
    <h2>3. API Prestasi</h2>

    <!-- GET ALL PRESTASI -->
    <h3>3.1 Menampilkan Daftar Prestasi</h3>
    <p>Digunakan untuk mengambil semua data prestasi siswa/sekolah, diurutkan dari prestasi terbaru.</p>
    
    <p>
        <span class="badge badge-get">GET</span> 
        <code>/prestasi</code>
    </p>

    <h4>Parameter Query (Opsional)</h4>
    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Parameter</th>
                <th style="width: 15%;">Tipe</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><code>search</code></td>
                <td>String</td>
                <td>Pencarian prestasi berdasarkan <code>judul</code>, <code>deskripsi</code>, atau nama <code>peraih</code>.</td>
            </tr>
            <tr>
                <td><code>kategori</code></td>
                <td>String</td>
                <td>Penyaringan berdasarkan kategori prestasi (misal: <code>Akademik</code>, <code>Olahraga</code>, <code>Seni</code>).</td>
            </tr>
            <tr>
                <td><code>tingkat</code></td>
                <td>String</td>
                <td>Penyaringan tingkat prestasi (misal: <code>Nasional</code>, <code>Provinsi</code>, <code>Kabupaten</code>).</td>
            </tr>
            <tr>
                <td><code>limit</code></td>
                <td>Integer</td>
                <td>Jumlah data per halaman (default: <code>10</code>).</td>
            </tr>
            <tr>
                <td><code>page</code></td>
                <td>Integer</td>
                <td>Nomor halaman pagination (default: <code>1</code>).</td>
            </tr>
        </tbody>
    </table>

    <h4>Contoh Respon Sukses (200 OK)</h4>
    <pre>{
  "data": [
    {
      "id": 3,
      "judul": "Juara 1 Lomba Pencak Silat Nasional",
      "deskripsi": "Berhasil mendapatkan medali emas pada Kejuaraan Pencak Silat Pelajar Nasional.",
      "kategori": "Olahraga",
      "tingkat": "Nasional",
      "peraih": "Ahmad Fauzi (Kelas XI TKR)",
      "foto_url": "/storage/prestasi/silat-emas.jpg",
      "tanggal": "2026-06-18",
      "created_at": "2026-06-18T10:15:00+07:00"
    }
  ],
  "links": {
    "first": "{{ url('/api/prestasi?page=1') }}",
    "last": "{{ url('/api/prestasi?page=1') }}",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "{{ url('/api/prestasi') }}",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}</pre>

    <div class="page-break"></div>

    <!-- GET SINGLE PRESTASI -->
    <h3>3.2 Menampilkan Detail Prestasi</h3>
    <p>Digunakan untuk mengambil satu data prestasi secara detail berdasarkan <strong>ID</strong>.</p>
    
    <p>
        <span class="badge badge-get">GET</span> 
        <code>/prestasi/{id}</code>
    </p>

    <h4>Contoh Respon Sukses (200 OK)</h4>
    <pre>{
  "data": {
    "id": 3,
    "judul": "Juara 1 Lomba Pencak Silat Nasional",
    "deskripsi": "Berhasil mendapatkan medali emas pada Kejuaraan Pencak Silat Pelajar Nasional.",
    "kategori": "Olahraga",
    "tingkat": "Nasional",
    "peraih": "Ahmad Fauzi (Kelas XI TKR)",
    "foto_url": "/storage/prestasi/silat-emas.jpg",
    "tanggal": "2026-06-18",
    "created_at": "2026-06-18T10:15:00+07:00"
  }
}</pre>

    <h4>Contoh Respon Error (404 Not Found)</h4>
    <pre>{
  "success": false,
  "message": "Prestasi tidak ditemukan."
}</pre>

    <div class="page-break"></div>

    <!-- CLIENT CONSUMPTION EXAMPLES -->
    <h2>4. Contoh Implementasi Klien</h2>

    <h3>4.1 Menggunakan JavaScript (Fetch API)</h3>
    <p>Berikut adalah cara mengambil data berita menggunakan JavaScript modern (async/await):</p>
    <pre>const fetchBerita = async () => {
    try {
        const response = await fetch('{{ url('/api/berita?limit=5') }}');
        if (!response.ok) {
            throw new Error('Gagal mengambil data berita');
        }
        const result = await response.json();
        
        // Tampilkan data berita
        result.data.forEach(berita => {
            console.log(`Judul: ${berita.judul}`);
            console.log(`Ringkasan: ${berita.ringkasan}`);
            console.log(`Link Gambar: ${berita.gambar_url}`);
        });
    } catch (error) {
        console.error('Error:', error);
    }
};

fetchBerita();</pre>

    <h3>4.2 Menggunakan PHP (Laravel HTTP Client)</h3>
    <p>Berikut adalah cara mengambil data prestasi menggunakan class HTTP Client bawaan Laravel:</p>
    <pre>use Illuminate\Support\Facades\Http;

$response = Http::get('{{ url('/api/prestasi') }}', [
    'search' => 'Silat',
    'kategori' => 'Olahraga'
]);

if ($response->successful()) {
    $prestasiList = $response->json()['data'];
    
    foreach ($prestasiList as $prestasi) {
        echo "Juara: " . $prestasi['judul'] . "\n";
        echo "Peraih: " . $prestasi['peraih'] . "\n";
    }
} else {
    echo "Gagal memanggil API: " . $response->status();
}</pre>

</body>
</html>
