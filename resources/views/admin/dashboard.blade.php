@extends('layouts.admin')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan data dan statistik website sekolah')

@section('content')
@if(auth()->user()->role === 'admin')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
  {{-- Card Berita --}}
  <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-newspaper text-blue-600 text-xl"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $stats['berita'] }}</p>
      <p class="text-sm text-slate-500">Total Berita</p>
    </div>
  </div>

  {{-- Card Prestasi --}}
  <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-trophy text-yellow-600 text-xl"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $stats['prestasi'] }}</p>
      <p class="text-sm text-slate-500">Total Prestasi</p>
    </div>
  </div>

  {{-- Card Galeri Video --}}
  <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-video text-red-600 text-xl"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $stats['galeri_video'] }}</p>
      <p class="text-sm text-slate-500">Total Galeri Video</p>
    </div>
  </div>

  {{-- Card Testimoni --}}
  <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-comment-alt text-emerald-600 text-xl"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $stats['testimoni'] }}</p>
      <p class="text-sm text-slate-500">Total Testimoni</p>
    </div>
  </div>
</div>

{{-- Quick Access Admin --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
  <h2 class="text-base font-semibold text-slate-800 mb-4">Akses Cepat</h2>
  <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
    @php
      $shortcutsAdmin = [
        ['Berita', 'admin.berita.create', 'fas fa-plus', 'bg-blue-50 text-blue-600'],
        ['Prestasi', 'admin.prestasi.create', 'fas fa-plus', 'bg-yellow-50 text-yellow-600'],
        ['Galeri Foto', 'admin.galeri_foto.index', 'fas fa-cog', 'bg-purple-50 text-purple-600'],
        ['Galeri Video', 'admin.galeri_video.create', 'fas fa-plus', 'bg-red-50 text-red-600'],
        ['Testimoni', 'admin.testimoni.create', 'fas fa-plus', 'bg-green-50 text-green-600'],
        ['Hero Slide', 'admin.hero.index', 'fas fa-images', 'bg-indigo-50 text-indigo-600'],
        ['Hal. Jurusan', 'admin.jurusan.index', 'fas fa-graduation-cap', 'bg-pink-50 text-pink-600'],
        ['Mitra Industri', 'admin.mitra.index', 'fas fa-building', 'bg-slate-55 text-slate-650'],
      ];
    @endphp
    @foreach($shortcutsAdmin as [$label, $route, $icon, $color])
    <a href="{{ route($route) }}"
       class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-100 hover:border-primary/30 hover:shadow-md transition-all duration-200 group">
      <div class="w-10 h-10 {{ $color }} rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
        <i class="{{ $icon }}"></i>
      </div>
      <span class="text-xs text-slate-600 font-medium text-center">{{ $label }}</span>
    </a>
    @endforeach
  </div>
</div>
@endif

@if(auth()->user()->role === 'admin_pendaftaran')

{{-- Quick Access Admin Pendaftaran --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
  <h2 class="text-base font-semibold text-slate-800 mb-4">Akses Cepat</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
    @php
      $shortcutsPendaftaran = [
        ['Pendaftaran', 'admin.pendaftaran.index', 'fas fa-list', 'bg-orange-50 text-orange-600'],
        ['Atur Gelombang', 'admin.gelombang.index', 'fas fa-layer-group', 'bg-blue-50 text-blue-600'],
        ['Status Pendaftaran', 'admin.spmb-status.edit', 'fas fa-toggle-on', 'bg-green-50 text-green-600'],
        ['Laporan PPDB', 'admin.pendaftaran.laporan', 'fas fa-file-invoice', 'bg-purple-50 text-purple-600'],
        ['Download Excel', 'admin.download.pendaftaran', 'fas fa-file-excel', 'bg-emerald-50 text-emerald-600'],
        ['Reset PPDB', 'admin.reset.index', 'fas fa-undo', 'bg-red-50 text-red-600'],
      ];
    @endphp
    @foreach($shortcutsPendaftaran as [$label, $route, $icon, $color])
    <a href="{{ route($route) }}"
       class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-100 hover:border-primary/30 hover:shadow-md transition-all duration-200 group">
      <div class="w-10 h-10 {{ $color }} rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
        <i class="{{ $icon }}"></i>
      </div>
      <span class="text-xs text-slate-600 font-medium text-center">{{ $label }}</span>
    </a>
    @endforeach
  </div>
</div>

{{-- Statistik PPDB --}}
<div class="mt-8">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <h2 class="text-base font-bold text-slate-800 dark:text-white">Statistik Penerimaan Peserta Didik Baru (PPDB)</h2>
      <p class="text-xs text-slate-555 dark:text-slate-400">Ringkasan pendaftaran siswa berdasarkan jurusan dan gelombang</p>
    </div>
  </div>
@endif

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Card 1: Statistik Pendaftar --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">
      <div class="bg-slate-500 dark:bg-slate-700 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-white text-sm tracking-wide">Statistik Pendaftar</h3>
        <span class="text-xs bg-slate-600 dark:bg-slate-800 text-slate-200 px-2.5 py-1 rounded-full font-semibold">Total: {{ $totalPendaftar['total'] }}</span>
      </div>
      <div class="p-4 overflow-x-auto flex-grow">
        <table class="w-full text-xs text-left border-collapse border border-slate-200 dark:border-slate-700">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
              <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">Jurusan</th>
              @foreach($gelMap as $gelKey => $gelNama)
                <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">{{ $gelNama }}</th>
              @endforeach
              <th class="py-2.5 px-2 font-semibold text-slate-800 dark:text-slate-200 text-center">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($jurusans as $jur)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center border-r border-slate-200 dark:border-slate-700">{{ $jur === 'TKR' ? 'TKRO' : $jur }}</td>
                @foreach($gelMap as $gelKey => $gelNama)
                  <td class="py-2.5 px-2 text-slate-600 dark:text-slate-400 text-center font-medium border-r border-slate-200 dark:border-slate-700">{{ $dataPendaftar[$jur][$gelKey] ?? 0 }}</td>
                @endforeach
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center bg-slate-50/50 dark:bg-slate-900/50">{{ $dataPendaftar[$jur]['total'] }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/70 font-bold">
              <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700 text-xs">Total Pendaftar</td>
              @foreach($gelMap as $gelKey => $gelNama)
                <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700">{{ $totalPendaftar[$gelKey] ?? 0 }}</td>
              @endforeach
              <td class="py-2.5 px-2 text-primary dark:text-orange-400 text-center bg-slate-100/80 dark:bg-slate-900 font-extrabold">{{ $totalPendaftar['total'] }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- Card 2: Statistik Data Calon Siswa --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">
      <div class="bg-slate-500 dark:bg-slate-700 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-white text-sm tracking-wide">Statistik Data Calon Siswa</h3>
        <span class="text-xs bg-slate-600 dark:bg-slate-800 text-slate-200 px-2.5 py-1 rounded-full font-semibold">Total: {{ $totalCalon['total'] }}</span>
      </div>
      <div class="p-4 overflow-x-auto flex-grow">
        <table class="w-full text-xs text-left border-collapse border border-slate-200 dark:border-slate-700">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
              <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">Jurusan</th>
              @foreach($gelMap as $gelKey => $gelNama)
                <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">{{ $gelNama }}</th>
              @endforeach
              <th class="py-2.5 px-2 font-semibold text-slate-800 dark:text-slate-200 text-center">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($jurusans as $jur)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center border-r border-slate-200 dark:border-slate-700">{{ $jur === 'TKR' ? 'TKRO' : $jur }}</td>
                @foreach($gelMap as $gelKey => $gelNama)
                  <td class="py-2.5 px-2 text-slate-600 dark:text-slate-400 text-center font-medium border-r border-slate-200 dark:border-slate-700">{{ $dataCalon[$jur][$gelKey] ?? 0 }}</td>
                @endforeach
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center bg-slate-50/50 dark:bg-slate-900/50">{{ $dataCalon[$jur]['total'] }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/70 font-bold">
              <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700 text-xs">Total Pencasis</td>
              @foreach($gelMap as $gelKey => $gelNama)
                <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700">{{ $totalCalon[$gelKey] ?? 0 }}</td>
              @endforeach
              <td class="py-2.5 px-2 text-primary dark:text-orange-400 text-center bg-slate-100/80 dark:bg-slate-900 font-extrabold">{{ $totalCalon['total'] }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- Card 3: Statistik Siswa Diterima --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">
      <div class="bg-slate-500 dark:bg-slate-700 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-white text-sm tracking-wide">Statistik Siswa Diterima</h3>
        <span class="text-xs bg-slate-600 dark:bg-slate-800 text-slate-200 px-2.5 py-1 rounded-full font-semibold">Total: {{ $totalDiterima['total'] }}</span>
      </div>
      <div class="p-4 overflow-x-auto flex-grow">
        <table class="w-full text-xs text-left border-collapse border border-slate-200 dark:border-slate-700">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
              <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">Jurusan</th>
              @foreach($gelMap as $gelKey => $gelNama)
                <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">{{ $gelNama }}</th>
              @endforeach
              <th class="py-2.5 px-2 font-semibold text-slate-800 dark:text-slate-200 text-center">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($jurusans as $jur)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center border-r border-slate-200 dark:border-slate-700">{{ $jur === 'TKR' ? 'TKRO' : $jur }}</td>
                @foreach($gelMap as $gelKey => $gelNama)
                  <td class="py-2.5 px-2 text-slate-600 dark:text-slate-400 text-center font-medium border-r border-slate-200 dark:border-slate-700">{{ $dataDiterima[$jur][$gelKey] ?? 0 }}</td>
                @endforeach
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center bg-slate-50/50 dark:bg-slate-900/50">{{ $dataDiterima[$jur]['total'] }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/70 font-bold">
              <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700 text-xs">Total Penerima</td>
              @foreach($gelMap as $gelKey => $gelNama)
                <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700">{{ $totalDiterima[$gelKey] ?? 0 }}</td>
              @endforeach
              <td class="py-2.5 px-2 text-primary dark:text-orange-400 text-center bg-slate-100/80 dark:bg-slate-900 font-extrabold">{{ $totalDiterima['total'] }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>


{{-- Chart Statistik Titip Bayar --}}
@php
  $totalDiterimaAll = $totalPembayaranBelum + $totalPembayaranCicilan + $totalPembayaranLunas;
  $sudahBayarAll    = $totalPembayaranCicilan + $totalPembayaranLunas;
  $pctSudahBayar    = $totalDiterimaAll > 0 ? round($sudahBayarAll / $totalDiterimaAll * 100) : 0;
  $pctBelum         = $totalDiterimaAll > 0 ? round($totalPembayaranBelum / $totalDiterimaAll * 100) : 0;
  $pctCicilan       = $totalDiterimaAll > 0 ? round($totalPembayaranCicilan / $totalDiterimaAll * 100) : 0;
  $pctLunas         = $totalDiterimaAll > 0 ? round($totalPembayaranLunas / $totalDiterimaAll * 100) : 0;
  $pctNominal       = $totalNominalTagihan > 0 ? round($totalNominalTerkumpul / $totalNominalTagihan * 100) : 0;
@endphp
<div class="mt-8 mb-4">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <h2 class="text-base font-bold text-slate-800 dark:text-white">Statistik Titip Bayar Siswa Diterima</h2>
      <p class="text-xs text-slate-500 dark:text-slate-400">Visualisasi status pembayaran siswa yang telah diterima (belum bayar, cicilan/titip bayar, lunas)</p>
    </div>
    <span class="inline-flex items-center gap-2 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 px-4 py-2 rounded-full text-xs font-semibold border border-amber-200 dark:border-amber-700">
      <i class="fas fa-coins"></i> Sudah Bayar: {{ $sudahBayarAll }} / {{ $totalDiterimaAll }}
    </span>
  </div>

  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#6366f1,#818cf8)">
        <i class="fas fa-user-check text-white text-lg"></i>
      </div>
      <div>
        <p class="text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalDiterimaAll }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Total Siswa Diterima</p>
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f87171,#ef4444)">
        <i class="fas fa-clock text-white text-lg"></i>
      </div>
      <div>
        <p class="text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalPembayaranBelum }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Belum Bayar</p>
        @if($totalDiterimaAll > 0)<p class="text-xs font-semibold text-red-500">{{ $pctBelum }}% dari total</p>@endif
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#f59e0b,#fbbf24)">
        <i class="fas fa-hand-holding-usd text-white text-lg"></i>
      </div>
      <div>
        <p class="text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalPembayaranCicilan }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Titip Bayar / Cicilan</p>
        @if($totalDiterimaAll > 0)<p class="text-xs font-semibold text-amber-500">{{ $pctCicilan }}% dari total</p>@endif
      </div>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-sm border border-slate-100 dark:border-slate-700 flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#10b981,#34d399)">
        <i class="fas fa-check-circle text-white text-lg"></i>
      </div>
      <div>
        <p class="text-2xl font-extrabold text-slate-800 dark:text-white">{{ $totalPembayaranLunas }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">Lunas</p>
        @if($totalDiterimaAll > 0)<p class="text-xs font-semibold text-emerald-500">{{ $pctLunas }}% dari total</p>@endif
      </div>
    </div>
  </div>

  {{-- Nominal Progress Bar --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
      <div>
        <p class="text-sm font-bold text-slate-700 dark:text-slate-200">Total Nominal Terkumpul</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">dari seluruh siswa yang telah diterima</p>
      </div>
      <div class="text-right">
        <p class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($totalNominalTerkumpul, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-500 dark:text-slate-400">dari Rp {{ number_format($totalNominalTagihan, 0, ',', '.') }} tagihan</p>
      </div>
    </div>
    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-4 overflow-hidden">
      <div class="h-4 rounded-full transition-all duration-1000 flex items-center justify-end pr-2"
           style="background:linear-gradient(90deg,#10b981,#34d399); width:{{ $pctNominal }}%; min-width:{{ $pctNominal > 0 ? '2rem' : '0' }}">
        @if($pctNominal > 5)<span class="text-white font-bold" style="font-size:10px;">{{ $pctNominal }}%</span>@endif
      </div>
    </div>
    <div class="flex justify-between mt-1.5">
      <span class="text-slate-400" style="font-size:10px;">0%</span>
      <span class="font-semibold text-emerald-600 dark:text-emerald-400" style="font-size:10px;">{{ $pctNominal }}% terkumpul</span>
      <span class="text-slate-400" style="font-size:10px;">100%</span>
    </div>
  </div>

  {{-- Stacked Bar Chart: Per Jurusan --}}
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
    <div class="px-6 py-4 flex items-center justify-between" style="background:linear-gradient(135deg,#0ea5e9,#0284c7)">
      <h3 class="font-bold text-white text-sm tracking-wide">Grafik Status Pembayaran per Jurusan</h3>
      <span class="text-xs bg-white/20 text-white px-2.5 py-1 rounded-full font-semibold">Belum Bayar · Titip Bayar · Lunas</span>
    </div>
    <div class="p-6">
      <canvas id="chartPembayaranBar" style="max-height:300px;"></canvas>
    </div>
  </div>

  {{-- Tabel Rekapitulasi Per Jurusan --}}
  @php
    $jurLabelsPbyr = ['TKR'=>'TKRO','TPM'=>'TPM','TAV'=>'TAV','TBSM'=>'TBSM','RPL'=>'RPL'];
    $totalTblBelum = 0; $totalTblCicilan = 0; $totalTblLunas = 0; $totalTblAll = 0;
  @endphp
  <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mt-6">
    <div class="px-6 py-4 flex items-center justify-between border-b border-slate-100 dark:border-slate-700" style="background:linear-gradient(135deg,#f59e0b,#d97706)">
      <h3 class="font-bold text-white text-sm tracking-wide">Rekapitulasi Pembayaran per Jurusan</h3>
      <span class="text-xs bg-white/20 text-white px-2.5 py-1 rounded-full font-semibold">Total Siswa Diterima: {{ $totalDiterimaAll }}</span>
    </div>
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
            <th class="py-3 px-4 text-left font-semibold text-slate-600 dark:text-slate-300 w-10">#</th>
            <th class="py-3 px-4 text-left font-semibold text-slate-600 dark:text-slate-300">Jurusan</th>
            <th class="py-3 px-4 text-center font-semibold text-red-500">Belum Bayar</th>
            <th class="py-3 px-4 text-center font-semibold text-amber-500">Titip Bayar</th>
            <th class="py-3 px-4 text-center font-semibold text-emerald-500">Lunas</th>
            <th class="py-3 px-4 text-center font-semibold text-slate-700 dark:text-slate-200">Total</th>
            <th class="py-3 px-4 text-center font-semibold text-slate-600 dark:text-slate-300">Progress</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
          @foreach($jurusans as $idx => $jur)
          @php
            $pb       = $pembayaranByJurusan[$jur];
            $pbt      = $pb['total'];
            $pctL     = $pbt > 0 ? round($pb['lunas']/$pbt*100)       : 0;
            $pctC     = $pbt > 0 ? round($pb['cicilan']/$pbt*100)     : 0;
            $pctB     = $pbt > 0 ? round($pb['belum_bayar']/$pbt*100) : 0;
            $totalTblBelum   += $pb['belum_bayar'];
            $totalTblCicilan += $pb['cicilan'];
            $totalTblLunas   += $pb['lunas'];
            $totalTblAll     += $pbt;
          @endphp
          <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition-colors">
            <td class="py-3 px-4 text-xs text-slate-400 dark:text-slate-500 font-medium">{{ $idx + 1 }}</td>
            <td class="py-3 px-4">
              <span class="inline-flex items-center gap-2">
                <span class="font-bold text-slate-700 dark:text-slate-200 text-sm">{{ $jurLabelsPbyr[$jur] }}</span>
              </span>
            </td>
            <td class="py-3 px-4 text-center">
              <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pb['belum_bayar'] > 0 ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' : 'text-slate-400' }}">{{ $pb['belum_bayar'] }}</span>
            </td>
            <td class="py-3 px-4 text-center">
              <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pb['cicilan'] > 0 ? 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' : 'text-slate-400' }}">{{ $pb['cicilan'] }}</span>
            </td>
            <td class="py-3 px-4 text-center">
              <span class="inline-flex items-center justify-center min-w-[2rem] px-2.5 py-0.5 rounded-full text-xs font-bold {{ $pb['lunas'] > 0 ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-slate-400' }}">{{ $pb['lunas'] }}</span>
            </td>
            <td class="py-3 px-4 text-center">
              <span class="font-extrabold text-slate-800 dark:text-white text-sm">{{ $pbt }}</span>
            </td>
            <td class="py-3 px-4">
              @if($pbt > 0)
              <div class="flex items-center gap-2">
                <div class="flex-1 flex h-2.5 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-700">
                  <div class="h-full bg-red-400 transition-all duration-700" style="width:{{ $pctB }}%" title="Belum: {{ $pctB }}%"></div>
                  <div class="h-full bg-amber-400 transition-all duration-700" style="width:{{ $pctC }}%" title="Titip: {{ $pctC }}%"></div>
                  <div class="h-full bg-emerald-400 transition-all duration-700" style="width:{{ $pctL }}%" title="Lunas: {{ $pctL }}%"></div>
                </div>
                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 w-10 text-right">{{ $pctL }}%</span>
              </div>
              @else
              <span class="text-xs text-slate-400 italic">-</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="bg-slate-50 dark:bg-slate-900 border-t-2 border-slate-200 dark:border-slate-600 font-bold">
            <td class="py-3 px-4"></td>
            <td class="py-3 px-4 text-sm font-bold text-slate-700 dark:text-slate-200">Total Keseluruhan</td>
            <td class="py-3 px-4 text-center"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">{{ $totalTblBelum }}</span></td>
            <td class="py-3 px-4 text-center"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">{{ $totalTblCicilan }}</span></td>
            <td class="py-3 px-4 text-center"><span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">{{ $totalTblLunas }}</span></td>
            <td class="py-3 px-4 text-center"><span class="font-extrabold text-slate-800 dark:text-white text-sm">{{ $totalTblAll }}</span></td>
            <td class="py-3 px-4">
              @if($totalTblAll > 0)
              <div class="flex items-center gap-2">
                <div class="flex-1 flex h-2.5 rounded-full overflow-hidden bg-slate-100 dark:bg-slate-700">
                  <div class="h-full bg-red-400" style="width:{{ round($totalTblBelum/$totalTblAll*100) }}%"></div>
                  <div class="h-full bg-amber-400" style="width:{{ round($totalTblCicilan/$totalTblAll*100) }}%"></div>
                  <div class="h-full bg-emerald-400" style="width:{{ round($totalTblLunas/$totalTblAll*100) }}%"></div>
                </div>
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 w-10 text-right">{{ round($totalTblLunas/$totalTblAll*100) }}%</span>
              </div>
              @endif
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>


<script>
(function () {
  // === Data Pembayaran dari PHP ===
  const jurusansPbyr   = @json(array_map(fn($j) => $j === 'TKR' ? 'TKRO' : $j, $jurusans));
  const jurusanKeysPbyr= @json($jurusans);
  const pbyrData       = @json($pembayaranByJurusan);

  // --- Stacked Bar: Per Jurusan ---

  const barPbyrCtx = document.getElementById('chartPembayaranBar');
  if (barPbyrCtx) {
    const belumData   = jurusanKeysPbyr.map(k => pbyrData[k] ? pbyrData[k]['belum_bayar'] : 0);
    const cicilanData = jurusanKeysPbyr.map(k => pbyrData[k] ? pbyrData[k]['cicilan']     : 0);
    const lunasData   = jurusanKeysPbyr.map(k => pbyrData[k] ? pbyrData[k]['lunas']       : 0);

    new Chart(barPbyrCtx, {
      type: 'bar',
      data: {
        labels: jurusansPbyr,
        datasets: [
          {
            label: 'Belum Bayar',
            data: belumData,
            backgroundColor: 'rgba(239,68,68,0.82)',
            borderColor: '#dc2626',
            borderWidth: 1.5,
            borderRadius: { topLeft: 0, topRight: 0, bottomLeft: 6, bottomRight: 6 },
            borderSkipped: false,
          },
          {
            label: 'Titip Bayar',
            data: cicilanData,
            backgroundColor: 'rgba(245,158,11,0.85)',
            borderColor: '#d97706',
            borderWidth: 1.5,
            borderRadius: 0,
            borderSkipped: false,
          },
          {
            label: 'Lunas',
            data: lunasData,
            backgroundColor: 'rgba(16,185,129,0.85)',
            borderColor: '#059669',
            borderWidth: 1.5,
            borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 0, bottomRight: 0 },
            borderSkipped: false,
          },
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              pointStyle: 'rectRounded',
              font: { size: 11, weight: '600' },
              color: '#64748b',
              padding: 14,
            }
          },
          tooltip: {
            callbacks: {
              label: function(ctx) {
                return ` ${ctx.dataset.label}: ${ctx.parsed.y} siswa`;
              }
            }
          }
        },
        scales: {
          x: {
            stacked: true,
            grid: { display: false },
            ticks: { font: { size: 11, weight: '600' }, color: '#475569' }
          },
          y: {
            stacked: true,
            beginAtZero: true,
            ticks: { stepSize: 1, precision: 0, font: { size: 11 }, color: '#94a3b8' },
            grid: { color: 'rgba(148,163,184,0.15)' }
          }
        },
        animation: { duration: 900, easing: 'easeOutQuart' }
      }
    });
  }
})();
</script>
@endsection
