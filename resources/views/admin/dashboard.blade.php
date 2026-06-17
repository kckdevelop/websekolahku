@extends('layouts.admin')
@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan data dan statistik website sekolah')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
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

  {{-- Card Pendaftaran Pending --}}
  <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-clipboard-list text-orange-600 text-xl"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $stats['pendaftaran_pending'] }}</p>
      <p class="text-sm text-slate-500">Pendaftaran Pending</p>
    </div>
  </div>
</div>

{{-- Quick Access --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
  <h2 class="text-base font-semibold text-slate-800 mb-4">Akses Cepat</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-8 gap-4">
    @php
      $shortcuts = [
        ['Berita', 'admin.berita.create', 'fas fa-plus', 'bg-blue-50 text-blue-600'],
        ['Prestasi', 'admin.prestasi.create', 'fas fa-plus', 'bg-yellow-50 text-yellow-600'],
        ['Galeri Foto', 'admin.galeri_foto.index', 'fas fa-cog', 'bg-purple-50 text-purple-600'],
        ['Galeri Video', 'admin.galeri_video.create', 'fas fa-plus', 'bg-red-50 text-red-600'],
        ['Testimoni', 'admin.testimoni.create', 'fas fa-plus', 'bg-green-50 text-green-600'],
        ['Pendaftaran', 'admin.pendaftaran.index', 'fas fa-list', 'bg-orange-50 text-orange-600'],
        ['Hero Slide', 'admin.hero.index', 'fas fa-images', 'bg-indigo-50 text-indigo-600'],
        ['Hal. Jurusan', 'admin.jurusan.index', 'fas fa-graduation-cap', 'bg-pink-50 text-pink-600'],
      ];
    @endphp
    @foreach($shortcuts as [$label, $route, $icon, $color])
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
@endsection
