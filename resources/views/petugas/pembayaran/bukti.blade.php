<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bukti Pembayaran – {{ $pendaftaran->no_daftar }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
      min-height: 100vh;
      padding: 24px 16px;
      color: #1e293b;
    }

    /* ── Controls ── */
    .controls {
      max-width: 680px;
      margin: 0 auto 16px;
      display: flex;
      gap: 8px;
      justify-content: flex-end;
    }
    .btn {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 9px 18px;
      border-radius: 9px;
      font-size: 12.5px;
      font-weight: 700;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all .2s;
    }
    .btn-print  { background: #059669; color: #fff; box-shadow: 0 4px 12px rgba(5,150,105,.3); }
    .btn-print:hover  { background: #047857; transform: translateY(-1px); }
    .btn-back   { background: #334155; color: #fff; }
    .btn-back:hover   { background: #1e293b; }

    /* ── Receipt ── */
    .receipt {
      max-width: 680px;
      margin: 0 auto;
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0,0,0,.45);
    }

    /* Header */
    .receipt-header {
      background: linear-gradient(135deg, #064e3b 0%, #059669 65%, #34d399 100%);
      padding: 20px 28px 16px;
      color: #fff;
      position: relative;
      overflow: hidden;
    }
    .receipt-header::before {
      content: '';
      position: absolute; top: -30px; right: -30px;
      width: 140px; height: 140px;
      border-radius: 50%;
      background: rgba(255,255,255,.07);
    }
    .receipt-header::after {
      content: '';
      position: absolute; bottom: -50px; left: -10px;
      width: 160px; height: 160px;
      border-radius: 50%;
      background: rgba(255,255,255,.05);
    }

    .header-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative; z-index: 1;
    }
    .school-info { display: flex; align-items: center; gap: 12px; }
    .school-logo {
      width: 46px; height: 46px;
      background: rgba(255,255,255,.15);
      border-radius: 10px;
      border: 1.5px solid rgba(255,255,255,.3);
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; overflow: hidden;
    }
    .school-logo img { width: 100%; height: 100%; object-fit: contain; }
    .school-name { font-size: 13px; font-weight: 800; }
    .school-sub  { font-size: 10px; opacity: .75; margin-top: 1px; }

    .status-badge {
      background: rgba(255,255,255,.18);
      border: 1.5px solid rgba(255,255,255,.35);
      border-radius: 999px;
      padding: 5px 14px;
      font-size: 10px;
      font-weight: 800;
      letter-spacing: .8px;
      text-transform: uppercase;
    }

    .header-mid {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-top: 14px;
      position: relative; z-index: 1;
    }
    .doc-title {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 2px;
      text-transform: uppercase;
      opacity: .8;
      margin-bottom: 4px;
    }
    .nominal-besar {
      font-size: 32px;
      font-weight: 900;
      letter-spacing: -1px;
      line-height: 1;
    }
    .nominal-tgl {
      font-size: 10px;
      opacity: .75;
      margin-top: 4px;
    }
    .no-ref-box {
      text-align: right;
      font-size: 10px;
      opacity: .85;
    }
    .no-ref-box .ref-label { opacity: .7; margin-bottom: 1px; }
    .no-ref-box .ref-val { font-weight: 700; font-family: monospace; font-size: 11.5px; letter-spacing: .4px; }

    /* Body */
    .receipt-body { padding: 18px 28px 16px; }

    /* Row 2-col */
    .row-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 10px;
    }
    .row-3 {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 10px;
      margin-bottom: 10px;
    }
    .info-box {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 9px;
      padding: 9px 12px;
    }
    .info-box.full { grid-column: 1/-1; }
    .info-box .lbl {
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .8px;
      color: #64748b;
      margin-bottom: 3px;
    }
    .info-box .val {
      font-size: 12.5px;
      font-weight: 700;
      color: #1e293b;
    }
    .info-box .val.mono { font-family: monospace; font-size: 13px; color: #2563eb; letter-spacing: .3px; }
    .info-box .val.green { color: #059669; }
    .info-box .val.sm { font-size: 11px; font-weight: 500; color: #64748b; }

    /* Divider */
    .dashed { border: none; border-top: 1.5px dashed #e2e8f0; margin: 12px 0; }

    /* Ringkasan */
    .section-title {
      font-size: 9.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #64748b;
      margin-bottom: 8px;
    }
    .section-title i { margin-right: 5px; }

    .sum-row {
      display: flex;
      justify-content: space-between;
      font-size: 11.5px;
      padding: 3px 0;
    }
    .sum-row .sl { color: #64748b; }
    .sum-row .sv { font-weight: 600; color: #1e293b; }
    .sum-row.total { border-top: 1.5px solid #e2e8f0; margin-top: 5px; padding-top: 7px; }
    .sum-row.total .sl { font-weight: 700; color: #1e293b; }
    .sum-row.total .sv { font-weight: 800; font-size: 14px; color: #059669; }
    .sum-row.paid  .sv { color: #059669; }
    .sum-row.sisa  .sv { color: #dc2626; }

    /* Progress */
    .prog-wrap { margin-top: 8px; }
    .prog-info { display: flex; justify-content: space-between; font-size: 10px; color: #64748b; margin-bottom: 4px; }
    .prog-bar  { height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden; }
    .prog-fill { height: 100%; border-radius: 999px; }

    /* Riwayat tabel kompak */
    .hist-table { width: 100%; border-collapse: collapse; font-size: 11px; }
    .hist-table thead tr { background: #f8fafc; }
    .hist-table th {
      padding: 6px 8px;
      text-align: left;
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .5px;
      color: #64748b;
      border-bottom: 1.5px solid #e2e8f0;
    }
    .hist-table td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; color: #1e293b; }
    .hist-table .cur td { background: #ecfdf5; font-weight: 700; }
    .badge-now {
      display: inline-flex; align-items: center;
      background: #059669; color: #fff;
      border-radius: 999px; padding: 1px 7px;
      font-size: 8px; font-weight: 700;
      letter-spacing: .5px; margin-left: 4px;
    }
    .hist-table tfoot td {
      background: #f8fafc;
      font-weight: 700;
      padding: 7px 8px;
      border-top: 1.5px solid #e2e8f0;
      font-size: 11.5px;
    }

    /* TTD Footer */
    .ttd-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-top: 14px;
      padding-top: 12px;
      border-top: 1.5px solid #e2e8f0;
    }
    .ttd-box {
      text-align: center;
      font-size: 10.5px;
      color: #1e293b;
    }
    .ttd-box .ttd-title { font-weight: 600; margin-bottom: 2px; color: #475569; }
    .ttd-box .ttd-date  { font-size: 10px; color: #64748b; margin-bottom: 58px; }
    .ttd-box .ttd-name  {
      border-top: 1.5px solid #1e293b;
      padding-top: 5px;
      font-weight: 800;
      font-size: 12px;
      display: inline-block;
      min-width: 160px;
    }
    .ttd-box .ttd-sub   { font-size: 10px; color: #64748b; margin-top: 2px; }

    /* Stamp placeholder */
    .stamp-area {
      width: 80px; height: 80px;
      border: 2px dashed #94a3b8;
      border-radius: 50%;
      margin: 6px auto 4px;
      display: flex; align-items: center; justify-content: center;
      color: #cbd5e1;
      font-size: 11px;
      font-weight: 600;
      text-align: center;
      line-height: 1.3;
    }

    /* Thank you strip */
    .thank-strip {
      background: linear-gradient(90deg, #064e3b, #059669);
      color: rgba(255,255,255,.9);
      text-align: center;
      padding: 8px 20px;
      font-size: 10px;
      letter-spacing: .3px;
    }
    .thank-strip strong { color: #fff; }

    /* ─── PRINT ─── */
    @media print {
      @page { size: A4; margin: 12mm 14mm; }

      body {
        background: #fff !important;
        padding: 0 !important;
        min-height: auto;
      }
      .controls { display: none !important; }
      .receipt {
        max-width: 100% !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        border: none !important;
      }
      .receipt-header { padding: 16px 22px 14px !important; }
      .nominal-besar { font-size: 26px !important; }
      .receipt-body { padding: 14px 22px 12px !important; }
      .ttd-box .ttd-date { margin-bottom: 50px !important; }
    }
  </style>
</head>
<body>

@php
  $persen      = $pendaftaran->persen_bayar;
  $statusBayar = $pendaftaran->status_bayar;
  $terbayar    = $pendaftaran->total_terbayar;
  $sisa        = $pendaftaran->sisa_tagihan;

  $statusLabel = match($statusBayar) {
      'lunas'   => 'LUNAS',
      'cicilan' => 'CICILAN',
      default   => 'BELUM BAYAR',
  };
  $progColor = match($statusBayar) {
      'lunas'   => 'background: linear-gradient(90deg,#059669,#34d399)',
      'cicilan' => 'background: linear-gradient(90deg,#2563eb,#60a5fa)',
      default   => 'background:#f87171',
  };
@endphp

{{-- Controls --}}
<div class="controls">
  <a href="{{ route('petugas.pembayaran.show', $pendaftaran->id) }}" class="btn btn-back">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <button class="btn btn-print" onclick="window.print()">
    <i class="fas fa-print"></i> Cetak Bukti
  </button>
</div>

<div class="receipt">

  {{-- ══ HEADER ══ --}}
  <div class="receipt-header">
    <div class="header-row">
      <div class="school-info">
        <div class="school-logo">
          <img src="{{ asset('storage/logomusaba.png') }}"
               onerror="this.style.display='none'; this.parentElement.textContent='🏫';" alt="Logo">
        </div>
        <div>
          <div class="school-name">SMK Muhammadiyah 1 Bantul</div>
          <div class="school-sub">Kasir PPDB — Penerimaan Siswa Baru</div>
        </div>
      </div>
      <div class="status-badge">{{ $statusLabel }}</div>
    </div>

    <div class="header-mid">
      <div>
        <div class="doc-title"><i class="fas fa-receipt"></i> &nbsp;Bukti Pembayaran</div>
        <div class="nominal-besar">Rp {{ number_format($riwayat->nominal, 0, ',', '.') }}</div>
        <div class="nominal-tgl">
          {{ $riwayat->created_at->translatedFormat('l, d F Y') }} — {{ $riwayat->created_at->format('H:i') }} WIB
        </div>
      </div>
      <div class="no-ref-box">
        <div class="ref-label">No. Pendaftaran</div>
        <div class="ref-val">{{ $pendaftaran->no_daftar }}</div>
        <div class="ref-label" style="margin-top:6px;">No. Pembayaran</div>
        <div class="ref-val">{{ $nomorPembayaran }}</div>
      </div>
    </div>
  </div>

  {{-- ══ BODY ══ --}}
  <div class="receipt-body">

    {{-- Info Siswa --}}
    <div class="row-2" style="margin-bottom:10px;">
      <div class="info-box full">
        <div class="lbl"><i class="fas fa-user" style="margin-right:3px;"></i>Nama Calon Siswa</div>
        <div class="val">{{ strtoupper($pendaftaran->nama_lengkap) }}</div>
        <div class="val sm">{{ $pendaftaran->asal_sekolah ?? '' }}</div>
      </div>
    </div>

    <div class="row-3">
      <div class="info-box">
        <div class="lbl">Jurusan Diterima</div>
        <div class="val green" style="font-size:11.5px;">{{ $pendaftaran->diterima_di_jurusan ?? $pendaftaran->pil1 ?? '-' }}</div>
      </div>
      <div class="info-box">
        <div class="lbl">Gelombang</div>
        <div class="val">{{ $pendaftaran->gelombang ?? '-' }}</div>
      </div>
      <div class="info-box">
        <div class="lbl">Keterangan Bayar</div>
        <div class="val sm" style="font-size:11.5px; color:#1e293b;">{{ $riwayat->keterangan ?: '-' }}</div>
      </div>
    </div>

    <hr class="dashed">

    {{-- Kiri: Ringkasan | Kanan: Riwayat --}}
    <div style="display:grid; grid-template-columns: 220px 1fr; gap:18px;">

      {{-- Ringkasan Keuangan --}}
      <div>
        <div class="section-title"><i class="fas fa-calculator" style="color:#059669;"></i>Ringkasan Keuangan</div>

        @if($pendaftaran->biaya_dana_awal_tahun)
        <div class="sum-row">
          <span class="sl">Kebutuhan Pokok</span>
          <span class="sv">Rp {{ number_format($pendaftaran->biaya_dana_awal_tahun, 0, ',', '.') }}</span>
        </div>
        @endif
        @if($pendaftaran->biaya_infaq)
        <div class="sum-row">
          <span class="sl">Pengembangan (Infaq)</span>
          <span class="sv">Rp {{ number_format($pendaftaran->biaya_infaq, 0, ',', '.') }}</span>
        </div>
        @endif
        @if($pendaftaran->biaya_potongan > 0)
        <div class="sum-row">
          <span class="sl">Subsidi Potongan</span>
          <span class="sv" style="color:#059669;">− Rp {{ number_format($pendaftaran->biaya_potongan, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="sum-row total">
          <span class="sl">Total Tagihan</span>
          <span class="sv">Rp {{ number_format($pendaftaran->total_tagihan ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="sum-row paid">
          <span class="sl">Total Terbayar</span>
          <span class="sv">Rp {{ number_format($terbayar, 0, ',', '.') }}</span>
        </div>
        <div class="sum-row sisa">
          <span class="sl">Sisa Kekurangan</span>
          <span class="sv">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
        </div>

        <div class="prog-wrap">
          <div class="prog-info">
            <span>Progress Lunas</span>
            <span style="font-weight:700;">{{ $persen }}%</span>
          </div>
          <div class="prog-bar">
            <div class="prog-fill" style="width:{{ $persen }}%; {{ $progColor }};"></div>
          </div>
        </div>
      </div>

      {{-- Riwayat Transaksi --}}
      <div>
        <div class="section-title"><i class="fas fa-history" style="color:#2563eb;"></i>Riwayat Pembayaran</div>
        <table class="hist-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nominal</th>
              <th>Kasir</th>
            </tr>
          </thead>
          <tbody>
            @forelse($allRiwayat as $i => $r)
            <tr class="{{ $r->id === $riwayat->id ? 'cur' : '' }}">
              <td>{{ $i + 1 }}</td>
              <td>
                {{ $r->created_at->format('d/m/Y') }}<br>
                <span style="font-size:9px; color:#94a3b8;">{{ $r->created_at->format('H:i') }}</span>
              </td>
              <td style="font-family:monospace; font-weight:700; color:#059669; white-space:nowrap;">
                Rp {{ number_format($r->nominal, 0, ',', '.') }}
                @if($r->id === $riwayat->id)<span class="badge-now">INI</span>@endif
              </td>
              <td style="font-size:10px; color:#475569;">{{ $r->petugas }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#94a3b8; padding:12px;">-</td></tr>
            @endforelse
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" style="text-align:right; color:#1e293b;">Total Terbayar:</td>
              <td style="font-family:monospace; color:#059669;" colspan="2">
                Rp {{ number_format($terbayar, 0, ',', '.') }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>

    {{-- TTD Section --}}
    <div class="ttd-section">

      {{-- Kiri: Penerima / Siswa --}}
      <div class="ttd-box">
        <div class="ttd-title">Yang Menerima,</div>
        <div class="ttd-date">Bantul, {{ now()->translatedFormat('d F Y') }}</div>
        <div class="ttd-name">( &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; )</div>
        <div class="ttd-sub">Calon Siswa / Wali</div>
      </div>

      {{-- Kanan: Petugas Kasir + Cap --}}
      <div class="ttd-box">
        <div class="ttd-title">Petugas Kasir / Bendahara,</div>
        <div class="ttd-date">Bantul, {{ now()->translatedFormat('d F Y') }}</div>
        <div class="stamp-area">CAP<br>SEKOLAH</div>
        <div class="ttd-name">( {{ auth()->user()->name }} )</div>
        <div class="ttd-sub">Panitia PPDB – Keuangan</div>
      </div>

    </div>

  </div>

  {{-- Thank you strip --}}
  <div class="thank-strip">
    <strong>Terima kasih</strong> atas kepercayaan Anda kepada SMK Muhammadiyah 1 Bantul.
    Simpan bukti ini sebagai tanda pembayaran yang sah.
  </div>

</div>

<script>
  @if(session('success'))
    window.onload = function() {
      setTimeout(() => window.print(), 700);
    };
  @endif
</script>
</body>
</html>
