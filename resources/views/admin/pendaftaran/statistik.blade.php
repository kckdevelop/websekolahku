@extends('layouts.admin')
@section('title', 'Laporan & Statistik PPDB')
@section('subtitle', 'Rekapitulasi statistik penerimaan peserta didik baru per gelombang dan jurusan')

@section('styles')
<style>
  .stat-table { border-collapse:collapse; width:100%; font-size:12px; }
  .stat-table th,.stat-table td { border:1px solid #cbd5e1; padding:6px 10px; text-align:center; white-space:nowrap; }
  .stat-table thead th { font-weight:700; font-size:11px; }
  .stat-table tfoot td { font-weight:700; }
  .th-col-seleksi     { background:#dbeafe; color:#1d4ed8; }
  .th-col-mundur      { background:#fee2e2; color:#b91c1c; }
  .th-col-bayar       { background:#dcfce7; color:#15803d; }
  .th-col-belum-bayar { background:#fef3c7; color:#b45309; }
  .tf-seleksi     { background:#eff6ff; }
  .tf-mundur      { background:#fff1f2; }
  .tf-bayar       { background:#f0fdf4; }
  .tf-belum-bayar { background:#fffbeb; }
  .total-cell { font-weight:800; font-size:13px; }
  .stat-card { background:white; border-radius:16px; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #e2e8f0; overflow:hidden; }
  .stat-card-header { padding:14px 20px; display:flex; align-items:center; justify-content:space-between; gap:12px; }
  .stat-card-header h3 { font-size:14px; font-weight:700; color:#fff; margin:0; letter-spacing:.03em; }
  .stat-card-header .bdg { font-size:11px; font-weight:700; padding:3px 10px; border-radius:999px; background:rgba(255,255,255,.25); color:#fff; }
  .stat-card-body { padding:16px; overflow-x:auto; }
  @media print {
    aside,header,.no-print { display:none !important; }
    body { background:white !important; }
    main { padding:0 !important; }
    div[style*="margin-left"] { margin-left:0 !important; }
    .stat-card { box-shadow:none; border:1px solid #94a3b8; page-break-inside:avoid; }
    .print-show { display:block !important; }
  }
</style>
@endsection

@section('content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 no-print">
  <div>
    <h1 class="text-lg font-bold text-slate-800">Laporan &amp; Statistik PPDB</h1>
    <p class="text-xs text-slate-500 mt-0.5">Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB &bull; Oleh: {{ auth()->user()->name }}</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('admin.pendaftaran.laporan') }}"
       class="inline-flex items-center gap-2 text-sm bg-white border border-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl hover:border-primary hover:text-primary transition-colors">
      <i class="fas fa-list"></i> Laporan Detail
    </a>
    <button onclick="window.print()"
       class="inline-flex items-center gap-2 text-sm bg-primary text-white font-semibold px-4 py-2 rounded-xl hover:bg-secondary transition-colors">
      <i class="fas fa-print"></i> Cetak
    </button>
  </div>
</div>

{{-- Hero Card: Total Semua Pendaftar --}}
<div class="bg-gradient-to-r from-violet-600 to-indigo-600 rounded-2xl p-5 mb-5 flex flex-col sm:flex-row items-center gap-5 shadow-lg no-print">
  <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center flex-shrink-0">
    <i class="fas fa-users text-white text-2xl"></i>
  </div>
  <div class="flex-1 text-center sm:text-left">
    <p class="text-white/70 text-sm font-medium">Total Semua Pendaftar PPDB</p>
    <p class="text-5xl font-black text-white leading-tight">{{ $grandTotal['semua'] }}</p>
    <p class="text-white/60 text-xs mt-1">Seluruh status &bull; {{ count($gelNamas) }} gelombang &bull; {{ count($jurusans) }} jurusan</p>
  </div>
  <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-center">
    <div class="bg-white/15 rounded-xl px-4 py-2">
      <p class="text-white font-black text-lg">{{ $grandTotal['seleksi'] }}</p>
      <p class="text-white/70 text-xs">Diterima</p>
    </div>
    <div class="bg-white/15 rounded-xl px-4 py-2">
      <p class="text-white font-black text-lg">{{ $grandTotal['mundur'] }}</p>
      <p class="text-white/70 text-xs">Mundur</p>
    </div>
    <div class="bg-white/15 rounded-xl px-4 py-2">
      <p class="text-white font-black text-lg">{{ $grandTotal['bayar'] }}</p>
      <p class="text-white/70 text-xs">Sudah Bayar</p>
    </div>
    <div class="bg-white/15 rounded-xl px-4 py-2">
      <p class="text-white font-black text-lg">{{ $grandTotal['belum_bayar'] }}</p>
      <p class="text-white/70 text-xs">Belum Bayar</p>
    </div>
    <div class="bg-white/15 rounded-xl px-4 py-2 col-span-2 sm:col-span-2">
      <p class="text-white font-black text-lg">{{ $grandTotal['semua'] - $grandTotal['seleksi'] - $grandTotal['mundur'] }}</p>
      <p class="text-white/70 text-xs">Pending / Proses</p>
    </div>
  </div>
</div>

{{-- ── Tabel 1: Semua Pendaftar per Gelombang ── --}}
<p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3 mt-2">Rekapitulasi Semua Pendaftar</p>
<div class="stat-card mb-6">
  <div class="stat-card-header" style="background:linear-gradient(135deg,#7c3aed,#4f46e5)">
    <h3><i class="fas fa-users mr-2"></i>SEMUA PENDAFTAR</h3>
    <span class="bdg">Total: {{ $grandTotal['semua'] }}</span>
  </div>
  <div class="stat-card-body">
    <table class="stat-table">
      <thead>
        <tr>
          <th class="text-left" style="background:#ede9fe;color:#5b21b6;min-width:110px">Gelombang</th>
          @foreach($jurusans as $j)<th style="background:#ede9fe;color:#5b21b6">{{ $j }}</th>@endforeach
          <th style="background:#ede9fe;color:#5b21b6">TOTAL</th>
        </tr>
      </thead>
      <tbody>
        @foreach($gelNamas as $gn)
        <tr class="hover:bg-violet-50/50">
          <td class="text-left font-semibold text-slate-700" style="font-size:11px">{{ $gn }}</td>
          @foreach($jurusans as $j)<td>{{ $tblSemua[$gn][$j] ?? 0 }}</td>@endforeach
          <td class="font-bold text-violet-700">{{ $tblSemua[$gn]['total'] ?? 0 }}</td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr style="background:#f5f3ff">
          <td class="text-left" style="font-size:10px;color:#475569">TOTAL</td>
          @foreach($jurusans as $j)<td>{{ $tblSemua['__total__'][$j] ?? 0 }}</td>@endforeach
          <td class="total-cell text-violet-700">{{ $tblSemua['__total__']['total'] ?? 0 }}</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

{{-- ── Tabel 2: Rekapitulasi per Status ── --}}
<div class="stat-card mb-6">
  <div class="stat-card-header" style="background:linear-gradient(135deg,#0ea5e9,#0284c7)">
    <h3><i class="fas fa-chart-bar mr-2"></i>REKAPITULASI PER STATUS</h3>
    <span class="bdg">Total: {{ $grandTotal['semua'] }}</span>
  </div>
  <div class="stat-card-body">
    <table class="stat-table">
      <thead>
        <tr>
          <th class="text-left" style="background:#e0f2fe;color:#0369a1;min-width:130px">Status</th>
          @foreach($jurusans as $j)<th style="background:#e0f2fe;color:#0369a1">{{ $j }}</th>@endforeach
          <th style="background:#e0f2fe;color:#0369a1">TOTAL</th>
          <th style="background:#e0f2fe;color:#0369a1">%</th>
        </tr>
      </thead>
      <tbody>
        @php
          $statusColors = [
            'pending'   => ['bg'=>'#fef9c3','color'=>'#854d0e','label'=>'Pending'],
            'verified'  => ['bg'=>'#dbeafe','color'=>'#1d4ed8','label'=>'Terverifikasi'],
            'diterima'  => ['bg'=>'#dcfce7','color'=>'#15803d','label'=>'Diterima'],
            'ditolak'   => ['bg'=>'#fee2e2','color'=>'#b91c1c','label'=>'Ditolak'],
            'mundur'    => ['bg'=>'#f1f5f9','color'=>'#475569','label'=>'Mundur'],
          ];
          $totalAll = $grandTotal['semua'];
        @endphp
        @foreach($allStatuses as $st)
        @php $sc = $statusColors[$st] ?? ['bg'=>'#f8fafc','color'=>'#334155','label'=>ucfirst($st)]; @endphp
        <tr class="hover:opacity-90">
          <td class="text-left" style="font-size:11px">
            <span style="display:inline-block;padding:2px 8px;border-radius:999px;font-weight:700;font-size:10px;background:{{ $sc['bg'] }};color:{{ $sc['color'] }}">
              {{ $sc['label'] }}
            </span>
          </td>
          @foreach($jurusans as $j)<td>{{ $tblStatus[$st][$j] ?? 0 }}</td>@endforeach
          <td class="font-bold" style="color:{{ $sc['color'] }}">{{ $tblStatus[$st]['total'] ?? 0 }}</td>
          <td style="color:#94a3b8;font-size:11px">
            {{ $totalAll > 0 ? number_format(($tblStatus[$st]['total'] / $totalAll) * 100, 1) : '0.0' }}%
          </td>
        </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr style="background:#f0f9ff">
          <td class="text-left" style="font-size:10px;color:#475569">TOTAL</td>
          @foreach($jurusans as $j)<td>{{ $tblStatus['__total__'][$j] ?? 0 }}</td>@endforeach
          <td class="total-cell" style="color:#0369a1">{{ $tblStatus['__total__']['total'] ?? 0 }}</td>
          <td style="color:#94a3b8;font-size:11px">100%</td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

{{-- ── Jenis Kelamin & Pembayaran side-by-side ── --}}
<p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Statistik Siswa Diterima &amp; Pembayaran</p>
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-6">

  {{-- GENDER --}}
  <div class="stat-card">
    <div class="stat-card-header" style="background:linear-gradient(135deg,#ec4899,#db2777)">
      <h3><i class="fas fa-venus-mars mr-2"></i>JENIS KELAMIN (DITERIMA)</h3>
      <span class="bdg">Total: {{ $tblGender['__total__']['total'] ?? 0 }}</span>
    </div>
    <div class="stat-card-body">
      <table class="stat-table">
        <thead>
          <tr>
            <th class="text-left" style="background:#fce7f3;color:#9d174d;min-width:120px">Jenis Kelamin</th>
            @foreach($jurusans as $j)<th style="background:#fce7f3;color:#9d174d">{{ $j }}</th>@endforeach
            <th style="background:#fce7f3;color:#9d174d">TOTAL</th>
            <th style="background:#fce7f3;color:#9d174d">%</th>
          </tr>
        </thead>
        <tbody>
          @php $gTotal = max(1, $tblGender['__total__']['total']); @endphp
          <tr class="hover:bg-pink-50/50">
            <td class="text-left" style="font-size:11px">
              <span style="display:inline-flex;align-items:center;gap:5px;font-weight:700;color:#1d4ed8">
                <i class="fas fa-mars text-blue-500"></i> Laki-laki
              </span>
            </td>
            @foreach($jurusans as $j)<td>{{ $tblGender['L'][$j] ?? 0 }}</td>@endforeach
            <td class="font-bold text-blue-700">{{ $tblGender['L']['total'] ?? 0 }}</td>
            <td style="color:#94a3b8;font-size:11px">{{ number_format(($tblGender['L']['total'] / $gTotal)*100,1) }}%</td>
          </tr>
          <tr class="hover:bg-pink-50/50">
            <td class="text-left" style="font-size:11px">
              <span style="display:inline-flex;align-items:center;gap:5px;font-weight:700;color:#be185d">
                <i class="fas fa-venus text-pink-500"></i> Perempuan
              </span>
            </td>
            @foreach($jurusans as $j)<td>{{ $tblGender['P'][$j] ?? 0 }}</td>@endforeach
            <td class="font-bold text-pink-700">{{ $tblGender['P']['total'] ?? 0 }}</td>
            <td style="color:#94a3b8;font-size:11px">{{ number_format(($tblGender['P']['total'] / $gTotal)*100,1) }}%</td>
          </tr>
        </tbody>
        <tfoot>
          <tr style="background:#fdf4ff">
            <td class="text-left" style="font-size:10px;color:#475569">TOTAL</td>
            @foreach($jurusans as $j)<td>{{ $tblGender['__total__'][$j] ?? 0 }}</td>@endforeach
            <td class="total-cell" style="color:#9333ea">{{ $tblGender['__total__']['total'] ?? 0 }}</td>
            <td style="color:#94a3b8;font-size:11px">100%</td>
          </tr>
        </tfoot>
      </table>

      {{-- Visual bar gender --}}
      @php
        $pct_l = $gTotal > 0 ? ($tblGender['L']['total'] / $gTotal) * 100 : 0;
        $pct_p = $gTotal > 0 ? ($tblGender['P']['total'] / $gTotal) * 100 : 0;
      @endphp
      <div class="mt-4">
        <div class="flex text-xs text-slate-500 justify-between mb-1">
          <span><i class="fas fa-mars text-blue-500 mr-1"></i>L: {{ number_format($pct_l,1) }}%</span>
          <span><i class="fas fa-venus text-pink-500 mr-1"></i>P: {{ number_format($pct_p,1) }}%</span>
        </div>
        <div class="flex h-4 rounded-full overflow-hidden">
          <div class="bg-blue-500 transition-all" style="width:{{ $pct_l }}%"></div>
          <div class="bg-pink-400 transition-all" style="width:{{ $pct_p }}%"></div>
        </div>
      </div>
    </div>
  </div>

  {{-- PEMBAYARAN --}}
  <div class="stat-card">
    <div class="stat-card-header" style="background:linear-gradient(135deg,#10b981,#059669)">
      <h3><i class="fas fa-money-bill-wave mr-2"></i>DATA PEMBAYARAN PER JURUSAN</h3>
      <span class="bdg">Siswa Diterima: {{ $tblPembayaran['__total__']['total_siswa'] ?? 0 }}</span>
    </div>
    <div class="stat-card-body">
      <table class="stat-table">
        <thead>
          <tr>
            <th class="text-left" style="background:#d1fae5;color:#065f46;min-width:60px">Jurusan</th>
            <th style="background:#d1fae5;color:#065f46">Siswa</th>
            <th style="background:#dcfce7;color:#15803d">Lunas</th>
            <th style="background:#fef9c3;color:#854d0e">Cicilan</th>
            <th style="background:#fee2e2;color:#b91c1c">Belum</th>
            <th style="background:#d1fae5;color:#065f46">Terkumpul</th>
            <th style="background:#d1fae5;color:#065f46">Tagihan</th>
            <th style="background:#d1fae5;color:#065f46">%</th>
          </tr>
        </thead>
        <tbody>
          @foreach($jurusans as $jk)
          @php
            $d = $tblPembayaran[$jk];
            $tagihan = max(1, $d['tagihan']);
            $pctBayar = $d['tagihan'] > 0 ? ($d['terkumpul'] / $d['tagihan']) * 100 : 0;
          @endphp
          <tr class="hover:bg-emerald-50/50">
            <td class="text-left font-bold text-slate-700" style="font-size:11px">{{ $jk }}</td>
            <td>{{ $d['total_siswa'] }}</td>
            <td><span style="color:#15803d;font-weight:600">{{ $d['lunas'] }}</span></td>
            <td><span style="color:#854d0e;font-weight:600">{{ $d['cicilan'] }}</span></td>
            <td><span style="color:#b91c1c;font-weight:600">{{ $d['belum'] }}</span></td>
            <td style="font-size:10px;white-space:nowrap">Rp {{ number_format($d['terkumpul'],0,',','.') }}</td>
            <td style="font-size:10px;white-space:nowrap">Rp {{ number_format($d['tagihan'],0,',','.') }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:4px;">
                <div style="flex:1;height:6px;background:#e2e8f0;border-radius:99px;overflow:hidden;min-width:36px">
                  <div style="height:100%;background:#10b981;width:{{ min(100,$pctBayar) }}%;border-radius:99px"></div>
                </div>
                <span style="font-size:10px;color:#64748b;white-space:nowrap">{{ number_format($pctBayar,0) }}%</span>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          @php
            $dt = $tblPembayaran['__total__'];
            $pctTotal = $dt['tagihan'] > 0 ? ($dt['terkumpul'] / $dt['tagihan']) * 100 : 0;
          @endphp
          <tr style="background:#ecfdf5">
            <td class="text-left" style="font-size:10px;color:#475569;font-weight:700">TOTAL</td>
            <td class="font-bold text-emerald-800">{{ $dt['total_siswa'] }}</td>
            <td class="font-bold" style="color:#15803d">{{ $dt['lunas'] }}</td>
            <td class="font-bold" style="color:#854d0e">{{ $dt['cicilan'] }}</td>
            <td class="font-bold" style="color:#b91c1c">{{ $dt['belum'] }}</td>
            <td style="font-size:10px;font-weight:700;color:#065f46;white-space:nowrap">Rp {{ number_format($dt['terkumpul'],0,',','.') }}</td>
            <td style="font-size:10px;font-weight:700;color:#065f46;white-space:nowrap">Rp {{ number_format($dt['tagihan'],0,',','.') }}</td>
            <td>
              <span style="font-weight:800;font-size:12px;color:#059669">{{ number_format($pctTotal,0) }}%</span>
            </td>
          </tr>
        </tfoot>
      </table>

      {{-- Ringkasan keuangan --}}
      <div class="grid grid-cols-3 gap-3 mt-4">
        <div style="background:#f0fdf4;border-radius:10px;padding:10px;text-align:center">
          <p style="font-size:10px;color:#6b7280;font-weight:600">Total Terkumpul</p>
          <p style="font-size:13px;font-weight:800;color:#059669">Rp {{ number_format($dt['terkumpul'],0,',','.') }}</p>
        </div>
        <div style="background:#fff7ed;border-radius:10px;padding:10px;text-align:center">
          <p style="font-size:10px;color:#6b7280;font-weight:600">Sisa Tagihan</p>
          <p style="font-size:13px;font-weight:800;color:#ea580c">Rp {{ number_format(max(0,$dt['tagihan']-$dt['terkumpul']),0,',','.') }}</p>
        </div>
        <div style="background:#eff6ff;border-radius:10px;padding:10px;text-align:center">
          <p style="font-size:10px;color:#6b7280;font-weight:600">Total Tagihan</p>
          <p style="font-size:13px;font-weight:800;color:#1d4ed8">Rp {{ number_format($dt['tagihan'],0,',','.') }}</p>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ── 4 Tabel Utama ── --}}
<p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Detail Statistik per Gelombang &amp; Jurusan</p>
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

  {{-- SELEKSI --}}
  <div class="stat-card">
    <div class="stat-card-header" style="background:linear-gradient(135deg,#3b82f6,#2563eb)">
      <h3><i class="fas fa-user-check mr-2"></i>SELEKSI</h3>
      <span class="bdg">Total: {{ $grandTotal['seleksi'] }}</span>
    </div>
    <div class="stat-card-body">
      <table class="stat-table">
        <thead>
          <tr>
            <th class="th-col-seleksi text-left" style="min-width:110px">Gel</th>
            @foreach($jurusans as $j)<th class="th-col-seleksi">{{ $j }}</th>@endforeach
            <th class="th-col-seleksi">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($gelNamas as $gn)
          <tr class="hover:bg-blue-50/50">
            <td class="text-left font-semibold text-slate-700" style="font-size:11px;">{{ $gn }}</td>
            @foreach($jurusans as $j)<td>{{ $tblSeleksi[$gn][$j] ?? 0 }}</td>@endforeach
            <td class="font-bold text-blue-700">{{ $tblSeleksi[$gn]['total'] ?? 0 }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="tf-seleksi">
            <td class="text-left" style="font-size:10px;color:#475569;">TOTAL</td>
            @foreach($jurusans as $j)<td>{{ $tblSeleksi['__total__'][$j] ?? 0 }}</td>@endforeach
            <td class="total-cell text-blue-700">{{ $tblSeleksi['__total__']['total'] ?? 0 }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  {{-- MUNDUR --}}
  <div class="stat-card">
    <div class="stat-card-header" style="background:linear-gradient(135deg,#ef4444,#dc2626)">
      <h3><i class="fas fa-user-slash mr-2"></i>MUNDUR</h3>
      <span class="bdg">Total: {{ $grandTotal['mundur'] }}</span>
    </div>
    <div class="stat-card-body">
      <table class="stat-table">
        <thead>
          <tr>
            <th class="th-col-mundur text-left" style="min-width:110px">Gel</th>
            @foreach($jurusans as $j)<th class="th-col-mundur">{{ $j }}</th>@endforeach
            <th class="th-col-mundur">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($gelNamas as $gn)
          <tr class="hover:bg-red-50/50">
            <td class="text-left font-semibold text-slate-700" style="font-size:11px;">{{ $gn }}</td>
            @foreach($jurusans as $j)<td>{{ $tblMundur[$gn][$j] ?? 0 }}</td>@endforeach
            <td class="font-bold text-red-600">{{ $tblMundur[$gn]['total'] ?? 0 }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="tf-mundur">
            <td class="text-left" style="font-size:10px;color:#475569;">TOTAL</td>
            @foreach($jurusans as $j)<td>{{ $tblMundur['__total__'][$j] ?? 0 }}</td>@endforeach
            <td class="total-cell text-red-600">{{ $tblMundur['__total__']['total'] ?? 0 }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  {{-- BAYAR --}}
  <div class="stat-card">
    <div class="stat-card-header" style="background:linear-gradient(135deg,#22c55e,#16a34a)">
      <h3><i class="fas fa-coins mr-2"></i>BAYAR</h3>
      <span class="bdg">Total: {{ $grandTotal['bayar'] }}</span>
    </div>
    <div class="stat-card-body">
      <table class="stat-table">
        <thead>
          <tr>
            <th class="th-col-bayar text-left" style="min-width:110px">Gel</th>
            @foreach($jurusans as $j)<th class="th-col-bayar">{{ $j }}</th>@endforeach
            <th class="th-col-bayar">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($gelNamas as $gn)
          <tr class="hover:bg-emerald-50/50">
            <td class="text-left font-semibold text-slate-700" style="font-size:11px;">{{ $gn }}</td>
            @foreach($jurusans as $j)<td>{{ $tblBayar[$gn][$j] ?? 0 }}</td>@endforeach
            <td class="font-bold text-emerald-700">{{ $tblBayar[$gn]['total'] ?? 0 }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="tf-bayar">
            <td class="text-left" style="font-size:10px;color:#475569;">TOTAL</td>
            @foreach($jurusans as $j)<td>{{ $tblBayar['__total__'][$j] ?? 0 }}</td>@endforeach
            <td class="total-cell text-emerald-700">{{ $tblBayar['__total__']['total'] ?? 0 }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

  {{-- BELUM BAYAR --}}
  <div class="stat-card">
    <div class="stat-card-header" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
      <h3><i class="fas fa-clock mr-2"></i>BELUM BAYAR</h3>
      <span class="bdg">Total: {{ $grandTotal['belum_bayar'] }}</span>
    </div>
    <div class="stat-card-body">
      <table class="stat-table">
        <thead>
          <tr>
            <th class="th-col-belum-bayar text-left" style="min-width:110px">Gel</th>
            @foreach($jurusans as $j)<th class="th-col-belum-bayar">{{ $j }}</th>@endforeach
            <th class="th-col-belum-bayar">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          @foreach($gelNamas as $gn)
          <tr class="hover:bg-amber-50/50">
            <td class="text-left font-semibold text-slate-700" style="font-size:11px;">{{ $gn }}</td>
            @foreach($jurusans as $j)<td>{{ $tblBelumBayar[$gn][$j] ?? 0 }}</td>@endforeach
            <td class="font-bold text-amber-700">{{ $tblBelumBayar[$gn]['total'] ?? 0 }}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="tf-belum-bayar">
            <td class="text-left" style="font-size:10px;color:#475569;">TOTAL</td>
            @foreach($jurusans as $j)<td>{{ $tblBelumBayar['__total__'][$j] ?? 0 }}</td>@endforeach
            <td class="total-cell text-amber-700">{{ $tblBelumBayar['__total__']['total'] ?? 0 }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>

</div>

{{-- Print Footer --}}
<div style="display:none;" class="print-show mt-8">
  <div style="display:flex;justify-content:space-between;font-size:12px;color:#334155;">
    <div>
      <p>Mengetahui,</p>
      <p style="font-weight:700;margin-top:48px;">Ketua Panitia PPDB</p>
      <p style="font-size:10px;color:#94a3b8;">SMK Muhammadiyah 1 Bantul</p>
    </div>
    <div style="text-align:right;">
      <p>Bantul, {{ now()->translatedFormat('d F Y') }}</p>
      <p style="font-weight:700;margin-top:48px;">Petugas Pendaftaran</p>
      <p style="font-size:10px;color:#94a3b8;">( {{ auth()->user()->name }} )</p>
    </div>
  </div>
</div>

@endsection