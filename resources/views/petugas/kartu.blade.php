<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kartu Calon Murid Baru — {{ $pendaftaran->no_daftar }}</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
      color: #000;
      background: #f5f5f5;
      padding: 20px;
    }

    /* ========== PRINT CONTROLS ========== */
    .print-controls {
      max-width: 780px;
      margin: 0 auto 15px;
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }
    .btn-print {
      background: #1d4ed8; color: #fff;
      border: none; padding: 10px 22px; border-radius: 8px;
      font-size: 13px; font-weight: bold; cursor: pointer;
    }
    .btn-back {
      background: #64748b; color: #fff;
      border: none; padding: 10px 18px; border-radius: 8px;
      font-size: 13px; font-weight: bold; cursor: pointer; text-decoration: none;
      display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-back:hover { background: #475569; }

    /* ========== KARTU ========== */
    #kartu {
      max-width: 780px;
      margin: 0 auto;
      background: #fff;
      border: 1px solid #aaa;
      padding: 0;
    }

    /* KOP */
    #kop {
      display: flex;
      align-items: center;
      padding: 8px 12px;
      border-bottom: 3px double #333;
      background: #EAF7FF;
      gap: 10px;
    }
    #kop .logo img { width: 70px; height: 70px; object-fit: contain; }
    #kop .nama-sekolah {
      flex: 1;
      text-align: center;
      font-family: Arial, Helvetica, sans-serif;
    }
    #kop .nama-sekolah h4 { font-size: 9px; font-weight: bold; margin-bottom: 2px; }
    #kop .nama-sekolah h2 { font-size: 15px; font-weight: bold; margin-bottom: 2px; }
    #kop .nama-sekolah h5 { font-size: 7.5px; font-weight: normal; margin-bottom: 2px; }
    #kop .nama-sekolah h3 { font-size: 11px; font-weight: bold; margin-bottom: 2px; }
    #kop .nama-sekolah p { font-size: 9px; }
    #kop .kode-form {
      font-size: 9px; text-align: center;
      border-left: 1px solid #aaa; padding-left: 10px;
      white-space: nowrap; color: #333;
    }

    /* Lembar + Judul */
    .lembar {
      font-style: italic; font-weight: bold; text-decoration: underline;
      padding: 4px 10px; font-size: 11px; border-bottom: 1px solid #ddd;
    }
    .judul-kartu {
      text-align: center; font-size: 16px; font-weight: bold;
      text-decoration: underline; padding: 6px;
      border-bottom: 1px solid #ddd;
    }

    /* ISI KARTU */
    .isi-kartu { padding: 0 8px 8px; }

    .main-table { width: 100%; border-collapse: collapse; margin-top: 6px; }
    .main-table td { vertical-align: top; padding: 2px 4px; font-size: 11.5px; }

    /* Kolom foto + jurusan */
    .col-foto {
      width: 170px;
      text-align: center;
      vertical-align: top;
      padding: 8px !important;
      border-right: 1px solid #ccc;
    }
    .col-foto img.foto-siswa {
      width: 130px; height: 160px; object-fit: cover;
      border: 2px solid #999; display: block; margin: 0 auto 8px;
    }
    .col-foto .no-foto {
      width: 130px; height: 160px; background: #f0f0f0;
      border: 2px dashed #aaa; margin: 0 auto 8px;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      color: #999; font-size: 10px;
    }
    .jurusan-box { text-align: left; margin-top: 6px; font-size: 10.5px; }
    .jurusan-box label { font-weight: bold; display: block; margin-bottom: 4px; }
    .jurusan-box .jur-row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .jurusan-box input[type="checkbox"] { margin-right: 2px; }

    /* Kolom data */
    .col-data { padding: 6px 10px !important; }
    .row-data td { padding: 2px 4px !important; font-size: 11px; line-height: 1.5; }
    .row-data td.lbl { width: 110px; color: #333; }
    .row-data td.sep { width: 10px; }
    .row-data td.val { font-weight: bold; }

    /* Tabel Kegiatan PPDB */
    .ppdb-table {
      width: 100%; border-collapse: collapse;
      margin-top: 6px; font-size: 10.5px;
    }
    .ppdb-table th {
      background: #000; color: #fff;
      padding: 4px 6px; text-align: center;
      font-size: 10px; border: 1px solid #333;
    }
    .ppdb-table td {
      border: 1px solid #333; padding: 4px 6px;
      height: 28px; text-align: center; font-size: 10px;
    }

    /* Kelengkapan Berkas + TTD */
    .bottom-section {
      border: 1px solid #333; margin: 8px 0 4px;
      width: 100%;
    }
    .bottom-inner {
      display: flex; width: 100%;
    }
    .berkas-col {
      flex: 1; padding: 6px 8px;
      border-right: 1px solid #333; font-size: 10.5px;
    }
    .berkas-col strong { display: block; margin-bottom: 4px; font-size: 11px; }
    .berkas-grid {
      display: grid; grid-template-columns: 1fr 1fr;
      gap: 2px 8px;
    }
    .berkas-item { display: flex; align-items: flex-start; gap: 4px; margin: 1px 0; }
    .berkas-item input[type="checkbox"] { margin-top: 1px; flex-shrink: 0; }

    .luar-daerah { margin-top: 6px; font-size: 10.5px; }
    .luar-daerah strong { display: block; margin-bottom: 2px; }

    .ttd-col {
      width: 160px; padding: 8px;
      text-align: center; font-size: 10.5px;
    }
    .ttd-space { height: 55px; }

    /* NB */
    .nb-bar {
      background: #30f546; font-size: 10px; font-weight: bold;
      padding: 5px 8px; text-align: center;
    }

    /* Footer */
    .footer-kartu {
      background: #333; color: #fff;
      text-align: center; padding: 6px 10px;
      font-style: italic; font-weight: bold; font-size: 12px;
    }

    /* ========== PRINT ========== */
    @media print {
      body { background: #fff; padding: 0; }
      .print-controls { display: none; }
      #kartu { border: 1px solid #888; }
    }
  </style>
</head>
<body>

  {{-- Print Controls --}}
  <div class="print-controls">
    <a href="{{ route('petugas.show', $pendaftaran) }}" class="btn-back">
      ← Kembali
    </a>
    <button class="btn-print" onclick="window.print()">
      🖨️ Cetak Kartu
    </button>
  </div>

  <div id="kartu">

    {{-- KOP --}}
    <div id="kop">
      <div class="logo">
        <img src="https://ppdb.smkmuh1bantul.sch.id/ppdb/gambar/musaba%20logo.png"
             alt="Logo"
             onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/e/e6/Muhammadiyah_Logo.svg'">
      </div>
      <div class="nama-sekolah">
        <h4>MAJELIS PENDIDIKAN DASAR DAN MENENGAH<br>PIMPINAN DAERAH MUHAMMADIYAH BANTUL</h4>
        <h2>SMK MUHAMMADIYAH 1 BANTUL</h2>
        <h5>TEKNIK AUDIO VIDEO, TEKNIK PERMESINAN, TEKNIK KENDARAAN RINGAN, PENGEMBANGAN PERANGKAT LUNAK DAN GIM, TEKNIK SEPEDA MOTOR</h5>
        <h3>Terakreditasi "A"</h3>
        <p>Jl. Parangtritis KM 12, Manding Trirenggo, Bantul 55714 Yogyakarta Telp. (0274) 367954</p>
      </div>
      <div class="kode-form">
        HUM/SPMB/FO-002<br>
        <hr style="margin:3px 0;">
        Rev.04 / 03 November 2025
      </div>
    </div>

    <div class="lembar">Lembar Untuk Siswa</div>
    <div class="judul-kartu">KARTU CALON MURID BARU</div>

    <div class="isi-kartu">
      <table class="main-table">
        <tr>
          {{-- KOLOM FOTO --}}
          <td class="col-foto" rowspan="8">
            @if($pendaftaran->foto_siswa)
              <img class="foto-siswa"
                   src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}"
                   alt="Foto {{ $pendaftaran->nama_lengkap }}">
            @else
              <div class="no-foto">
                <span style="font-size:24px;">👤</span>
                <span>Foto Belum<br>Tersedia</span>
              </div>
            @endif

            <div class="jurusan-box">
              <label>Diterima pada Jurusan :</label>
              <div class="jur-row">
                <span><input type="checkbox"> TKRO</span>
                <span><input type="checkbox"> TBSM</span>
                <span><input type="checkbox"> TPM</span>
              </div>
              <div class="jur-row" style="margin-top:3px;">
                <span><input type="checkbox"> TAV</span>
                <span><input type="checkbox"> RPL</span>
              </div>
            </div>
          </td>

          {{-- KOLOM DATA --}}
          <td class="col-data">
            <table class="row-data" style="width:100%;">
              <tr>
                <td class="lbl">Nomor Pendataan</td>
                <td class="sep">:</td>
                <td class="val" style="font-size:13px; letter-spacing:0.5px;">{{ $pendaftaran->no_daftar }}</td>
              </tr>
              <tr>
                <td class="lbl">Nama Lengkap</td>
                <td class="sep">:</td>
                <td class="val">{{ $pendaftaran->nama_lengkap }}</td>
              </tr>
              <tr>
                <td class="lbl">Nama Orang Tua</td>
                <td class="sep">:</td>
                <td class="val">{{ strtoupper($pendaftaran->nama_ortu) }} ({{ strtoupper($pendaftaran->pekerjaan_ortu) }})</td>
              </tr>
              <tr>
                <td class="lbl">Alamat</td>
                <td class="sep">:</td>
                <td class="val" style="font-weight:normal;">
                  @php
                    $alamat = collect([
                      $pendaftaran->dusun_asal ? 'Dsn. ' . $pendaftaran->dusun_asal : null,
                      'RT:' . $pendaftaran->rt_asal,
                      $pendaftaran->rw_asal ? 'RW:' . $pendaftaran->rw_asal : null,
                      $pendaftaran->desa_asal,
                      $pendaftaran->kecamatan_asal,
                      $pendaftaran->kabupaten_asal,
                      $pendaftaran->provinsi_asal,
                    ])->filter()->implode(', ');
                  @endphp
                  {{ strtoupper($alamat) }}
                </td>
              </tr>
              <tr>
                <td class="lbl">No HP Orang Tua</td>
                <td class="sep">:</td>
                <td class="val">{{ $pendaftaran->no_hp_ortu }}</td>
              </tr>
              <tr>
                <td class="lbl">Asal SMP / MTs</td>
                <td class="sep">:</td>
                <td class="val">{{ strtoupper($pendaftaran->asal_sekolah) }}</td>
              </tr>
            </table>

            {{-- Kegiatan PPDB --}}
            <div style="margin-top: 8px;">
              <strong style="font-size:11px;">Kegiatan PPDB</strong>
              <table class="ppdb-table" style="margin-top:4px;">
                <thead>
                  <tr>
                    <th>Pendataan</th>
                    <th>Uji Kesehatan</th>
                    <th>Uji Pengetahuan</th>
                    <th>Tes Al-Islam</th>
                    <th>Wawancara</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $pendaftaran->verified_at ? $pendaftaran->verified_at->format('Y-m-d') : ($pendaftaran->created_at ? $pendaftaran->created_at->format('Y-m-d') : '&nbsp;') }}</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </div>

          </td>
        </tr>
      </table>

      {{-- KELENGKAPAN BERKAS + TTD --}}
      <div class="bottom-section">
        <div class="bottom-inner">
          {{-- Berkas --}}
          <div class="berkas-col">
            <strong>Kelengkapan Berkas</strong>
            @php
              $berkasLengkap = $pendaftaran->berkas_lengkap ?? [];
              $berkasItems = [
                'ijazah_asli'  => 'Ijazah / SKHUN asli',
                'ijazah_copy'  => 'Fotocopy Ijazah / SKHUN',
                'formulir'     => 'Formulir Pendataan',
                'foto_3x4'     => 'Foto 3x4 (3 lembar)',
                'akta_copy'    => 'Fotocopy Akta Kelahiran',
                'kk_copy'      => 'Fotocopy Kartu Keluarga',
                'rapor_copy'   => 'Fotocopy Rapor Sem. V',
              ];
            @endphp
            <div class="berkas-grid">
              @foreach($berkasItems as $key => $label)
              <div class="berkas-item">
                <input type="checkbox" {{ in_array($key, $berkasLengkap) ? 'checked' : '' }} disabled>
                <span>{{ $label }}</span>
              </div>
              @endforeach
            </div>

            <div class="luar-daerah">
              <strong>Luar Daerah</strong>
              <div class="berkas-item"><input type="checkbox" disabled> Rekomendasi Dinas Pendidikan</div>
              <div class="berkas-item"><input type="checkbox" disabled> SKKB dari Sekolah / Kepolisian</div>
              <div class="berkas-item"><input type="checkbox" disabled> Surat Keterangan Bebas NAPZA</div>
            </div>
          </div>

          {{-- TTD Petugas --}}
          <div class="ttd-col">
            <p>Bantul, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Pendataan,</p>
            <div class="ttd-space"></div>
            <p>( ............................. )</p>
          </div>
        </div>

        {{-- NB --}}
        <div class="nb-bar">
          Pendaftaran ulang dilakukan paling lambat 1 Minggu setelah Pemantapan Jurusan
        </div>
      </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer-kartu">Selamat Datang Di Sekolah Yang Terampil dan Mulia</div>
  </div>

  <script>
    // Auto print on load
    window.addEventListener('DOMContentLoaded', () => {
      // Allow manual print instead of auto
    });
  </script>
</body>
</html>
