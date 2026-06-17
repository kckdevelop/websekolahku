<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bukti Pendaftaran - {{ $pendaftaran->no_daftar }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* ═══════════════════════════════════════
       SCREEN STYLES
    ═══════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; }

    :root {
      --primary:   #1e40af;
      --primary-light: #dbeafe;
      --accent:    #f97316;
      --accent-light: #fff7ed;
      --dark:      #1e293b;
      --gray:      #64748b;
      --light:     #f8fafc;
      --border:    #e2e8f0;
      --green:     #16a34a;
      --green-light: #dcfce7;
    }

    body {
      font-family: 'Inter', 'Arial', sans-serif;
      color: var(--dark);
      background: #e2e8f0;
      margin: 0;
      padding: 24px 12px 48px;
      font-size: 12px;
      line-height: 1.6;
    }

    /* ── TOOLBAR ── */
    .toolbar {
      max-width: 820px;
      margin: 0 auto 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }

    .toolbar-info {
      font-size: 12px;
      color: var(--gray);
    }

    .toolbar-info strong {
      color: var(--dark);
    }

    .btn-group {
      display: flex;
      gap: 8px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 9px 18px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      text-decoration: none;
      transition: all 0.2s;
    }

    .btn-primary {
      background: var(--primary);
      color: #fff;
      box-shadow: 0 2px 8px rgba(30,64,175,.25);
    }

    .btn-primary:hover {
      background: #1e3a8a;
      box-shadow: 0 4px 12px rgba(30,64,175,.35);
      transform: translateY(-1px);
    }

    .btn-outline {
      background: #fff;
      color: var(--gray);
      border: 1px solid var(--border);
    }

    .btn-outline:hover {
      background: var(--light);
      color: var(--dark);
    }

    /* ── PAPER ── */
    .paper {
      max-width: 820px;
      margin: 0 auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.06);
      overflow: hidden;
    }

    /* ── HEADER BANNER ── */
    .header-banner {
      background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%);
      padding: 24px 30px 20px;
      color: #fff;
      position: relative;
      overflow: hidden;
    }

    .header-banner::before {
      content: '';
      position: absolute;
      top: -40px; right: -40px;
      width: 180px; height: 180px;
      border-radius: 50%;
      background: rgba(255,255,255,.06);
    }

    .header-banner::after {
      content: '';
      position: absolute;
      bottom: -30px; left: 120px;
      width: 120px; height: 120px;
      border-radius: 50%;
      background: rgba(255,255,255,.04);
    }

    .header-inner {
      display: flex;
      align-items: center;
      gap: 20px;
      position: relative;
      z-index: 1;
    }

    .header-logo-wrap {
      flex-shrink: 0;
      width: 72px; height: 72px;
      background: #ffffff;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,.5);
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
    }

    .header-logo-wrap img {
      width: 60px; height: 60px;
      object-fit: contain;
    }

    .header-text-wrap { flex: 1; }

    .header-inst {
      font-size: 10px;
      font-weight: 500;
      opacity: .8;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 3px;
    }

    .header-school {
      font-size: 20px;
      font-weight: 800;
      letter-spacing: 0.3px;
      line-height: 1.2;
      margin-bottom: 4px;
    }

    .header-address {
      font-size: 10.5px;
      opacity: .8;
      line-height: 1.4;
    }

    .header-accred {
      flex-shrink: 0;
      background: rgba(255,255,255,.15);
      border: 1px solid rgba(255,255,255,.25);
      border-radius: 8px;
      padding: 8px 14px;
      text-align: center;
      font-size: 10px;
      font-weight: 600;
      opacity: .95;
    }

    .header-accred .grade {
      font-size: 24px;
      font-weight: 800;
      display: block;
      line-height: 1;
      margin-top: 2px;
    }

    /* ── DIVIDER LINE ── */
    .accent-bar {
      height: 4px;
      background: linear-gradient(90deg, var(--accent) 0%, #fbbf24 100%);
    }

    /* ── DOCUMENT TITLE ── */
    .doc-title-wrap {
      background: var(--light);
      border-bottom: 1px solid var(--border);
      padding: 16px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
    }

    .doc-title-left h3 {
      margin: 0 0 2px;
      font-size: 14px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--dark);
    }

    .doc-title-left p {
      margin: 0;
      font-size: 10.5px;
      color: var(--gray);
    }

    .no-daftar-badge {
      background: linear-gradient(135deg, var(--primary) 0%, #2563eb 100%);
      color: #fff;
      padding: 8px 20px;
      border-radius: 8px;
      font-size: 15px;
      font-weight: 800;
      letter-spacing: 2px;
      white-space: nowrap;
      box-shadow: 0 4px 12px rgba(30,64,175,.3);
    }

    /* ── STATUS RIBBON ── */
    .status-ribbon {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 30px;
      background: var(--primary-light);
      border-bottom: 1px solid #bfdbfe;
      font-size: 11px;
    }

    .status-ribbon .meta { color: #1e40af; font-weight: 500; }
    .status-ribbon .meta span { color: #1e3a8a; font-weight: 700; }

    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .status-pending  { background: #fef9c3; color: #854d0e; }
    .status-diterima { background: var(--green-light); color: var(--green); }
    .status-ditolak  { background: #fee2e2; color: #dc2626; }
    .status-verifikasi { background: var(--primary-light); color: var(--primary); }

    .status-dot {
      width: 7px; height: 7px;
      border-radius: 50%;
      background: currentColor;
    }

    /* ── BODY CONTENT ── */
    .doc-body { padding: 24px 30px; }

    /* ── SECTION HEADER ── */
    .section-head {
      display: flex;
      align-items: center;
      gap: 8px;
      margin: 20px 0 10px;
    }

    .section-head:first-child { margin-top: 0; }

    .section-icon {
      width: 28px; height: 28px;
      border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px;
      flex-shrink: 0;
    }

    .icon-blue { background: var(--primary-light); color: var(--primary); }
    .icon-orange { background: var(--accent-light); color: var(--accent); }
    .icon-green { background: var(--green-light); color: var(--green); }
    .icon-purple { background: #f3e8ff; color: #7c3aed; }

    .section-head h4 {
      margin: 0;
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.6px;
      color: var(--dark);
    }

    /* ── TWO-COLUMN ── */
    .two-col { display: flex; gap: 24px; }
    .col-l { flex: 1.1; }
    .col-r { flex: 1; }

    /* ── DATA TABLE ── */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 4px;
    }

    .data-table tr:not(:last-child) td { border-bottom: 1px solid #f1f5f9; }

    .data-table td {
      padding: 6px 5px;
      vertical-align: top;
      font-size: 11.5px;
    }

    .data-table td.lbl {
      width: 38%;
      color: var(--gray);
      font-weight: 500;
      white-space: nowrap;
    }

    .data-table td.sep {
      width: 4%;
      color: var(--gray);
      text-align: center;
    }

    .data-table td.val {
      width: 58%;
      color: var(--dark);
      font-weight: 600;
    }

    /* ── PILIHAN JURUSAN CARDS ── */
    .pilihan-grid { display: flex; flex-direction: column; gap: 6px; margin-bottom: 4px; }

    .pilihan-card {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 10px;
      border-radius: 8px;
      border: 1px solid var(--border);
      background: var(--light);
    }

    .pilihan-num {
      width: 22px; height: 22px;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 10px;
      font-weight: 800;
      flex-shrink: 0;
    }

    .pil-1 { background: var(--primary); color: #fff; }
    .pil-2 { background: #0284c7; color: #fff; }
    .pil-3 { background: #0891b2; color: #fff; }

    .pilihan-label { font-size: 10px; color: var(--gray); font-weight: 500; }
    .pilihan-name  { font-size: 11.5px; color: var(--dark); font-weight: 700; }

    /* ── ADDRESS ROW ── */
    .addr-row {
      display: flex;
      gap: 16px;
      margin-top: 0;
    }

    .addr-card {
      flex: 1;
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden;
    }

    .addr-card-head {
      padding: 7px 12px;
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      background: var(--light);
      border-bottom: 1px solid var(--border);
      color: var(--gray);
    }

    .addr-card-body {
      padding: 10px 12px;
      font-size: 11.5px;
      color: var(--dark);
      line-height: 1.7;
    }

    /* ── REQUIREMENTS BOX ── */
    .req-box {
      margin-top: 20px;
      border: 1.5px dashed #cbd5e1;
      border-radius: 10px;
      overflow: hidden;
    }

    .req-box-head {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      background: #fff7ed;
      border-bottom: 1px dashed #cbd5e1;
    }

    .req-box-head span {
      font-size: 11.5px;
      font-weight: 700;
      color: var(--accent);
    }

    .req-list {
      margin: 0;
      padding: 12px 16px 12px 36px;
      font-size: 11px;
      color: var(--dark);
      line-height: 1.9;
    }

    /* ── SIGNATURE SECTION ── */
    .sig-section {
      margin-top: 28px;
      display: flex;
      gap: 24px;
    }

    .sig-box {
      flex: 1;
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 14px 16px;
      text-align: center;
    }

    .sig-box .sig-role {
      font-size: 11px;
      font-weight: 600;
      color: var(--gray);
      margin-bottom: 48px;
    }

    .sig-box .sig-date {
      font-size: 10.5px;
      color: var(--gray);
      margin-bottom: 6px;
    }

    .sig-box .sig-name {
      font-size: 12px;
      font-weight: 700;
      color: var(--dark);
      border-top: 1.5px solid var(--dark);
      padding-top: 6px;
      margin-top: 2px;
    }

    /* ── FOOTER ── */
    .doc-footer {
      background: var(--light);
      border-top: 1px solid var(--border);
      padding: 12px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 10px;
      color: var(--gray);
    }

    /* ═══════════════════════════════════════
       PRINT STYLES
    ═══════════════════════════════════════ */
    @media print {
      @page {
        size: A4;
        margin: 10mm 12mm;
      }

      body {
        background: #fff;
        padding: 0;
        font-size: 11px;
      }

      .toolbar { display: none !important; }

      .paper {
        box-shadow: none;
        border-radius: 0;
        max-width: 100%;
      }

      .header-banner {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #2563eb 100%) !important;
      }

      .accent-bar {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: linear-gradient(90deg, #f97316 0%, #fbbf24 100%) !important;
      }

      .no-daftar-badge {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%) !important;
      }

      .section-icon, .pilihan-num, .status-pill,
      .req-box-head, .addr-card-head {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      .doc-body { padding: 16px 20px; }
      .doc-footer { padding: 8px 20px; }
    }
  </style>
</head>
<body>

  {{-- ── TOOLBAR ── --}}
  <div class="toolbar">
    <div class="toolbar-info">
      Bukti Pendaftaran &nbsp;›&nbsp; <strong>{{ $pendaftaran->no_daftar }}</strong>
    </div>
    <div class="btn-group">
      <button class="btn btn-outline" onclick="window.history.back()">
        ← Kembali
      </button>
      <button class="btn btn-primary" onclick="window.print()">
        🖨️ Cetak / Simpan PDF
      </button>
    </div>
  </div>

  {{-- ── PAPER ── --}}
  <div class="paper">

    {{-- HEADER BANNER --}}
    <div class="header-banner">
      <div class="header-inner">
        <div class="header-logo-wrap">
          <img src="https://ppdb.smkmuh1bantul.sch.id/ppdb/gambar/musaba%20logo.png"
               alt="Logo"
               onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/e/e6/Muhammadiyah_Logo.svg'">
        </div>
        <div class="header-text-wrap">
          <div class="header-inst">Majelis Pendidikan Dasar Menengah &amp; Pendidikan Non Formal</div>
          <div class="header-school">SMK Muhammadiyah 1 Bantul</div>
          <div class="header-address">
            Jl. Parangtritis Km 11, Manding, Sabdodadi, Bantul, DI Yogyakarta 55715<br>
            Telp: (0274) 367156 &nbsp;|&nbsp; Email: smkmuh1bantul@gmail.com
          </div>
        </div>
        <div class="header-accred">
          Terakreditasi
          <span class="grade">A</span>
        </div>
      </div>
    </div>

    {{-- ACCENT BAR --}}
    <div class="accent-bar"></div>

    {{-- DOCUMENT TITLE --}}
    <div class="doc-title-wrap">
      <div class="doc-title-left">
        <h3>Bukti Pendataan Pendaftaran Siswa Baru</h3>
        <p>Penerimaan Peserta Didik Baru (PPDB) &mdash; Gelombang: {{ $pendaftaran->gelombang }} &mdash; T.A. {{ $pendaftaran->tahun_aktif }}/{{ $pendaftaran->tahun_aktif + 1 }}</p>
      </div>
      <div class="no-daftar-badge">{{ $pendaftaran->no_daftar }}</div>
    </div>

    {{-- STATUS RIBBON --}}
    <div class="status-ribbon">
      <div class="meta">
        Terdaftar: <span>{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d F Y, H:i') : '-' }} WIB</span>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Dokumen: <span>SIS/PPBD/FO-001 Rev.03</span>
      </div>
      @php
        $statusMap = [
          'pending'    => ['label' => 'Menunggu Verifikasi', 'class' => 'status-pending'],
          'verifikasi' => ['label' => 'Sudah Diverifikasi',  'class' => 'status-verifikasi'],
          'diterima'   => ['label' => 'Diterima',            'class' => 'status-diterima'],
          'ditolak'    => ['label' => 'Tidak Diterima',      'class' => 'status-ditolak'],
        ];
        $st = $statusMap[$pendaftaran->status] ?? ['label' => ucfirst($pendaftaran->status), 'class' => 'status-pending'];
      @endphp
      <div class="status-pill {{ $st['class'] }}">
        <div class="status-dot"></div>
        {{ $st['label'] }}
      </div>
    </div>

    {{-- BODY --}}
    <div class="doc-body">

      {{-- TWO-COLUMN: Calon Siswa + (Orang Tua & Pilihan) --}}
      <div class="two-col">

        {{-- LEFT: Data Calon Siswa --}}
        <div class="col-l">
          <div class="section-head">
            <div class="section-icon icon-blue">👤</div>
            <h4>Data Calon Siswa</h4>
          </div>
          <table class="data-table">
            <tr>
              <td class="lbl">Nama Lengkap</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->nama_lengkap }}</td>
            </tr>
            <tr>
              <td class="lbl">Tempat, Tgl Lahir</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
              <td class="lbl">Jenis Kelamin</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
            </tr>
            <tr>
              <td class="lbl">Agama</td>
              <td class="sep">:</td>
              <td class="val" style="text-transform: capitalize;">{{ $pendaftaran->agama }}</td>
            </tr>
            <tr>
              <td class="lbl">Asal Sekolah</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->asal_sekolah }}</td>
            </tr>
            <tr>
              <td class="lbl">No. HP Siswa</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->no_hp_siswa }}</td>
            </tr>
            @if($pendaftaran->prestasi)
            <tr>
              <td class="lbl">Prestasi</td>
              <td class="sep">:</td>
              <td class="val" style="font-weight: 400; font-style: italic;">{{ $pendaftaran->prestasi }}</td>
            </tr>
            @endif
          </table>
        </div>

        {{-- RIGHT: Data Orang Tua & Pilihan --}}
        <div class="col-r">
          {{-- Orang Tua --}}
          <div class="section-head">
            <div class="section-icon icon-orange">👨‍👩‍👦</div>
            <h4>Data Orang Tua</h4>
          </div>
          <table class="data-table">
            <tr>
              <td class="lbl">Nama Orang Tua</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->nama_ortu }}</td>
            </tr>
            <tr>
              <td class="lbl">Pekerjaan</td>
              <td class="sep">:</td>
              <td class="val" style="font-weight: 500;">{{ $pendaftaran->pekerjaan_ortu }}</td>
            </tr>
            <tr>
              <td class="lbl">No. HP Ortu</td>
              <td class="sep">:</td>
              <td class="val">{{ $pendaftaran->no_hp_ortu }}</td>
            </tr>
          </table>

          {{-- Pilihan Jurusan --}}
          <div class="section-head" style="margin-top: 14px;">
            <div class="section-icon icon-purple">🎓</div>
            <h4>Pilihan Jurusan</h4>
          </div>
          @php
            $jurusans = [
              'TKR'  => 'Teknik Kendaraan Ringan (TKR)',
              'TPM'  => 'Teknik Permesinan (TPM)',
              'TAV'  => 'Teknik Audio Video (TAV)',
              'TBSM' => 'Teknik Bisnis Sepeda Motor (TBSM)',
              'RPL'  => 'Rekayasa Perangkat Lunak (RPL)',
            ];
          @endphp
          <div class="pilihan-grid">
            <div class="pilihan-card">
              <div class="pilihan-num pil-1">I</div>
              <div>
                <div class="pilihan-label">Pilihan Pertama</div>
                <div class="pilihan-name">{{ $jurusans[$pendaftaran->pil1] ?? $pendaftaran->pil1 }}</div>
              </div>
            </div>
            <div class="pilihan-card">
              <div class="pilihan-num pil-2">II</div>
              <div>
                <div class="pilihan-label">Pilihan Kedua</div>
                <div class="pilihan-name">{{ $jurusans[$pendaftaran->pil2] ?? $pendaftaran->pil2 }}</div>
              </div>
            </div>
            <div class="pilihan-card">
              <div class="pilihan-num pil-3">III</div>
              <div>
                <div class="pilihan-label">Pilihan Ketiga</div>
                <div class="pilihan-name">{{ $jurusans[$pendaftaran->pil3] ?? $pendaftaran->pil3 }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ADDRESS SECTION --}}
      <div class="section-head" style="margin-top: 20px;">
        <div class="section-icon icon-green">📍</div>
        <h4>Alamat Calon Siswa</h4>
      </div>
      <div class="addr-row">
        <div class="addr-card">
          <div class="addr-card-head">📋 Alamat sesuai KK</div>
          <div class="addr-card-body">
            {{ $pendaftaran->jalan_asal ? $pendaftaran->jalan_asal . ', ' : '' }}{{ $pendaftaran->dusun_asal ? 'Dsn. ' . $pendaftaran->dusun_asal . ', ' : '' }}RT {{ $pendaftaran->rt_asal }}{{ $pendaftaran->rw_asal ? ' / RW ' . $pendaftaran->rw_asal : '' }},
            Kel. {{ $pendaftaran->desa_asal }}, Kec. {{ $pendaftaran->kecamatan_asal }},
            Kab. {{ $pendaftaran->kabupaten_asal }}, Prov. {{ $pendaftaran->provinsi_asal }}
          </div>
        </div>
        <div class="addr-card">
          <div class="addr-card-head">🏠 Alamat Domisili / Tinggal</div>
          <div class="addr-card-body">
            {{ $pendaftaran->jalan_tinggal ? $pendaftaran->jalan_tinggal . ', ' : '' }}{{ $pendaftaran->dusun_tinggal ? 'Dsn. ' . $pendaftaran->dusun_tinggal . ', ' : '' }}RT {{ $pendaftaran->rt_tinggal }}{{ $pendaftaran->rw_tinggal ? ' / RW ' . $pendaftaran->rw_tinggal : '' }},
            Kel. {{ $pendaftaran->desa_tinggal }}, Kec. {{ $pendaftaran->kecamatan_tinggal }},
            Kab. {{ $pendaftaran->kabupaten_tinggal }}, Prov. {{ $pendaftaran->provinsi_tinggal }}
          </div>
        </div>
      </div>

      {{-- REQUIREMENTS --}}
      <div class="req-box">
        <div class="req-box-head">
          <span>📌 Berkas yang Harus Dilengkapi saat Daftar Ulang</span>
        </div>
        <ol class="req-list">
          <li>Fotokopi Rapor SMP/MTs Semester 1 s.d. 5 (masing-masing 1 lembar)</li>
          <li>Fotokopi Akta Kelahiran dan Kartu Keluarga (KK) (masing-masing 1 lembar)</li>
          <li>Fotokopi KIP / KPS / KKS jika memiliki (1 lembar)</li>
          <li>Pas foto berwarna ukuran 3×4 sebanyak 2 lembar (background merah)</li>
          <li>Surat keterangan lulus / SKHUN dari sekolah asal</li>
        </ol>
      </div>

      {{-- SIGNATURES --}}
      <div class="sig-section">
        <div class="sig-box">
          <div class="sig-date">Bantul, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
          <div class="sig-role">Calon Siswa,</div>
          <div class="sig-name">( {{ $pendaftaran->nama_lengkap }} )</div>
        </div>
        <div class="sig-box">
          <div class="sig-date">Bantul, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
          <div class="sig-role">Panitia PPDB,</div>
          <div class="sig-name">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</div>
        </div>
      </div>

    </div>{{-- /doc-body --}}

    {{-- FOOTER --}}
    <div class="doc-footer">
      <div>SIS/PPBD/FO-001 &nbsp;|&nbsp; Rev.03 / 02 Januari 2024</div>
      <div>Dicetak: {{ now()->format('d/m/Y H:i') }} WIB &nbsp;|&nbsp; Dokumen ini sah tanpa tanda tangan basah setelah diverifikasi panitia</div>
    </div>

  </div>{{-- /paper --}}

</body>
</html>
