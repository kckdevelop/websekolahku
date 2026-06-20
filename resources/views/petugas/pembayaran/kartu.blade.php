<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pembayaran - {{ $pendaftaran->no_daftar }}</title>
<style type="text/css">
<!--
body {
  background: #f8fafc;
  margin: 0;
  padding: 20px;
  font-family: "Times New Roman", Times, serif;
  color: #1e293b;
}
.kop {
	font-size: 18px;
	font-weight: bold;
  line-height: 1.4;
}
* {
	font-size: 14px;
}
td {
	padding: 5px;
}

/* ========== PRINT CONTROLS ========== */
.print-controls {
  max-width: 800px;
  margin: 0 auto 20px;
  display: flex;
  gap: 12px;
  justify-content: flex-end;
}
.btn-print {
  background: #10b981; 
  color: #fff;
  border: none; 
  padding: 10px 24px; 
  border-radius: 8px;
  font-size: 13px; 
  font-weight: bold; 
  cursor: pointer;
  font-family: Arial, sans-serif;
  box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
  transition: all 0.2s;
}
.btn-print:hover {
  background: #059669;
  box-shadow: 0 4px 12px -1px rgba(16, 185, 129, 0.3);
}
.btn-back {
  background: #64748b; 
  color: #fff;
  border: none; 
  padding: 10px 20px; 
  border-radius: 8px;
  font-size: 13px; 
  font-weight: bold; 
  cursor: pointer; 
  text-decoration: none;
  display: inline-flex; 
  align-items: center; 
  gap: 6px;
  font-family: Arial, sans-serif;
  transition: all 0.2s;
}
.btn-back:hover { 
  background: #475569; 
}

.kartu-container {
  max-width: 800px;
  margin: 0 auto;
  background: #fff;
  padding: 35px 40px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
  border-radius: 12px;
}

.table-divider {
  border-top: 2px solid #0f172a;
  margin: 15px 0;
}

.section-title {
  font-size: 15px;
  font-weight: bold;
  text-decoration: underline;
  margin-top: 20px;
  margin-bottom: 10px;
}

.rincian-table {
  border-collapse: collapse;
  width: 100%;
}
.rincian-table th, .rincian-table td {
  border: 1px solid #334155;
  padding: 8px 10px;
  text-align: left;
}
.rincian-table th {
  background-color: #f1f5f9;
  font-weight: bold;
}

@media print {
  body {
    background: #fff !important;
    padding: 0 !important;
  }
  .print-controls { display: none !important; }
  .kartu-container {
    border: none !important;
    padding: 0 !important;
    max-width: 100% !important;
    box-shadow: none !important;
  }
}
-->
</style>
</head>

<body>

<div class="print-controls">
  <a href="{{ route('petugas.pembayaran.show', $pendaftaran->id) }}" class="btn-back">
    ← Kembali
  </a>
  <button class="btn-print" onclick="window.print()">
    🖨️ Cetak Kartu
  </button>
</div>

<div class="kartu-container">
  @php
    $nomorPembayaran = $pendaftaran->nomor_pembayaran;
    if (!$nomorPembayaran) {
      $noDaftarLast3 = substr($pendaftaran->no_daftar, -3);
      $tgl = $pendaftaran->wawancara_verified_at ?: ($pendaftaran->created_at ?: now());
      $nomorPembayaran = $tgl->format('Ymd') . $noDaftarLast3;
    }
  @endphp

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="15%" align="left" valign="middle">
        <img src="{{ asset('storage/logomusaba.png') }}" width="90" height="90" style="filter: grayscale(100%);" onerror="this.src='https://upload.wikimedia.org/wikipedia/commons/e/e6/Muhammadiyah_Logo.svg'" />
      </td>
      <td width="85%" align="center" valign="middle" class="kop">
        KARTU INVESTASI PENDIDIKAN SISWA BARU<br />
        SMK MUHAMMADIYAH 1 BANTUL
      </td>
    </tr>
  </table>
  
  <div class="table-divider"></div>
  
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="28%" style="font-weight: bold;">NAMA</td>
      <td width="2%">:</td>
      <td width="70%" style="font-weight: bold;">{{ strtoupper($pendaftaran->nama_lengkap) }}</td>
    </tr>
    <tr>
      <td style="font-weight: bold;">NOMOR PENDAFTARAN</td>
      <td>:</td>
      <td style="font-family: monospace; font-size: 15px; font-weight: bold;">{{ $pendaftaran->no_daftar }}</td>
    </tr>
    <tr>
      <td style="font-weight: bold;">NOMOR PEMBAYARAN</td>
      <td>:</td>
      <td style="font-family: monospace; font-size: 15px; font-weight: bold;">{{ $nomorPembayaran }}</td>
    </tr>
    <tr>
      <td style="font-weight: bold;">JURUSAN</td>
      <td>:</td>
      <td style="font-weight: bold;">{{ $pendaftaran->diterima_di_jurusan ?? $pendaftaran->pil1 }}</td>
    </tr>
  </table>

  <div class="section-title">BIAYA PENDIDIKAN :</div>
  <table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td width="5%">1.</td>
      <td width="55%">KEBUTUHAN POKOK PENDIDIKAN ( 1 Tahun )</td>
      <td width="2%">:</td>
      <td width="38%">Rp {{ number_format($pendaftaran->biaya_dana_awal_tahun, 0, ',', '.') }},00</td>
    </tr>
    <tr>
      <td>2.</td>
      <td>PENGEMBANGAN PENDIDIKAN</td>
      <td>:</td>
      <td>Rp {{ number_format($pendaftaran->biaya_infaq, 0, ',', '.') }},00</td>
    </tr>
    <tr>
      <td>3.</td>
      <td>BEASISWA / SUBSIDI POTONGAN</td>
      <td>:</td>
      <td>Rp {{ number_format($pendaftaran->biaya_potongan, 0, ',', '.') }},00</td>
    </tr>
    <tr style="font-weight: bold;">
      <td>4.</td>
      <td>TOTAL BIAYA</td>
      <td>:</td>
      <td>Rp {{ number_format($pendaftaran->total_tagihan, 0, ',', '.') }},00</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr style="font-weight: bold;">
      <td colspan="2">* CATATAN KESANGGUPAN SPP /BULAN</td>
      <td>:</td>
      <td>Rp {{ number_format($pendaftaran->biaya_spp, 0, ',', '.') }},00</td>
    </tr>
  </table>

  <br />
  <div class="table-divider"></div>
  
  <h3 align="center" style="font-size: 16px; font-weight: bold; margin: 15px 0;">RINCIAN PEMBAYARAN</h3>
  
  <table class="rincian-table" width="100%">
    <thead>
      <tr>
        <th width="8%" style="text-align: center;">No</th>
        <th width="25%">Tanggal</th>
        <th width="17%" style="text-align: center;">Jam</th>
        <th width="25%" style="text-align: right;">Jumlah Bayar</th>
        <th width="25%">Petugas</th>
      </tr>
    </thead>
    <tbody>
      @forelse($riwayat as $i => $r)
        <tr>
          <td align="center">{{ $i + 1 }}</td>
          <td>{{ $r->created_at->format('Y-m-d') }}</td>
          <td align="center">{{ $r->created_at->format('H:i:s') }}</td>
          <td align="right" style="font-family: monospace; font-weight: bold;">Rp {{ number_format($r->nominal, 0, ',', '.') }},00</td>
          <td>{{ $r->petugas }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="5" align="center" style="color: #64748b; font-style: italic;">Belum ada riwayat pembayaran</td>
        </tr>
      @endforelse

      <tr style="font-weight: bold; background-color: #f8fafc;">
        <td colspan="3" align="right" style="padding-right: 15px;">Total Bayar</td>
        <td align="right" style="font-family: monospace;">Rp {{ number_format($pendaftaran->total_terbayar, 0, ',', '.') }},00</td>
        <td>&nbsp;</td>
      </tr>
      <tr style="font-weight: bold; background-color: #f1f5f9;">
        <td colspan="3" align="right" style="padding-right: 15px;">Sisa Kekurangan</td>
        <td align="right" style="font-family: monospace; color: #b91c1c;">Rp {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }},00</td>
        <td>&nbsp;</td>
      </tr>
    </tbody>
  </table>
  
  <br />
  <br />
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="65%" valign="top" style="padding-right: 20px;">
        <p style="font-weight: bold; margin-bottom: 5px;">Catatan Dari Panitia :</p>
        <div style="border: 1px dashed #cbd5e1; padding: 12px; border-radius: 6px; min-height: 80px; font-style: italic; color: #475569; background-color: #fafafa; line-height: 1.5;">
          {{ $pendaftaran->wawancara_catatan ?? ($pendaftaran->kesehatan_catatan ?? 'Tidak ada catatan tambahan.') }}
        </div>
      </td>
      <td width="35%" align="center" valign="top">
        <p>Bantul, {{ now()->translatedFormat('d-m-Y') }}</p>
        <p style="margin-top: 5px; margin-bottom: 45px;">Panitia Pendataan Calon Siswa Baru</p>
        <p style="font-weight: bold; text-decoration: underline;">( {{ auth()->user()->name }} )</p>
      </td>
    </tr>
  </table>
</div>

</body>
</html>
