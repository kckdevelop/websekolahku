@extends('layouts.petugas')
@section('title', 'Laporan Pendaftaran & Berkas')
@section('subtitle', 'Laporan kelengkapan berkas, foto webcam, dan verifikasi pendaftaran calon siswa')

@section('content')
<div class="space-y-6">

  {{-- Stats Cards (Hidden on print) --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 no-print">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Total Pendaftar</span>
        <span class="text-xl font-bold text-slate-800 mt-1 block">{{ $totalAll }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Sudah Foto</span>
        <span class="text-xl font-bold text-emerald-600 mt-1 block">{{ $totalFoto }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
        <i class="fas fa-camera"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Belum Foto</span>
        <span class="text-xl font-bold text-amber-600 mt-1 block">{{ $totalBelumFoto }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
        <i class="fas fa-video-slash"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Sudah Verifikasi</span>
        <span class="text-xl font-bold text-indigo-600 mt-1 block">{{ $totalVerif }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
        <i class="fas fa-check-double"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Belum Verifikasi</span>
        <span class="text-xl font-bold text-rose-600 mt-1 block">{{ $totalBelumVerif }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
        <i class="fas fa-file-excel"></i>
      </div>
    </div>
  </div>

  {{-- Filters Form (Hidden on print) --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 no-print">
    <form method="GET" action="{{ route('petugas.laporan') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
      <div>
        <select name="gelombang" class="text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100 bg-white text-slate-600">
          <option value="">-- Semua Gelombang --</option>
          @foreach($gelombangs as $gel)
            <option value="{{ $gel->nama_gelombang }}" {{ request('gelombang') === $gel->nama_gelombang ? 'selected' : '' }}>
              {{ $gel->nama_gelombang }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <select name="status_foto" class="text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100 bg-white text-slate-600">
          <option value="">-- Status Foto --</option>
          <option value="sudah" {{ request('status_foto') === 'sudah' ? 'selected' : '' }}>Sudah Foto</option>
          <option value="belum" {{ request('status_foto') === 'belum' ? 'selected' : '' }}>Belum Foto</option>
        </select>
      </div>

      <div>
        <select name="status_verifikasi" class="text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100 bg-white text-slate-600">
          <option value="">-- Status Verifikasi --</option>
          <option value="sudah" {{ request('status_verifikasi') === 'sudah' ? 'selected' : '' }}>Sudah Verifikasi</option>
          <option value="belum" {{ request('status_verifikasi') === 'belum' ? 'selected' : '' }}>Belum Verifikasi</option>
        </select>
      </div>

      <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no daftar..."
               class="pl-8 pr-4 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-100 w-52 bg-white text-slate-700">
        <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
      </div>

      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
        Filter
      </button>

      @if(request('gelombang') || request('status_foto') || request('status_verifikasi') || request('search'))
        <a href="{{ route('petugas.laporan') }}" class="text-xs text-rose-500 hover:text-rose-700 font-semibold">
          Reset
        </a>
      @endif
    </form>

    <div>
      <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md shadow-blue-600/10">
        <i class="fas fa-print"></i> Cetak Laporan
      </button>
    </div>
  </div>

  {{-- Print Header (Only visible on print) --}}
  <div class="print-only mb-6" style="display: none;">
    <div class="text-center space-y-1 pb-4 border-b-2 border-slate-800">
      <h2 class="text-lg font-bold uppercase tracking-wider text-slate-900">Laporan Kelengkapan Berkas &amp; Foto Siswa</h2>
      <h3 class="text-md font-bold text-slate-700">SMK MUHAMMADIYAH 1 BANTUL</h3>
      <p class="text-xs text-slate-500">
        @if(request('gelombang')) {{ request('gelombang') }} @else Semua Gelombang @endif
        | Filter Foto: @if(request('status_foto')) {{ ucfirst(request('status_foto')) }} @else Semua @endif
        | Filter Berkas: @if(request('status_verifikasi')) {{ ucfirst(request('status_verifikasi')) }} @else Semua @endif
        | Cetak: {{ now()->translatedFormat('d F Y H:i') }}
      </p>
    </div>
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden print-w-full">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse border-slate-200 text-slate-800 print-table text-xs">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xxs uppercase tracking-wider font-bold print-bg-gray">
            <th class="py-3 px-4 border-b">No Daftar</th>
            <th class="py-3 px-4 border-b">Nama Calon Siswa</th>
            <th class="py-3 px-4 border-b">Asal Sekolah</th>
            <th class="py-3 px-4 border-b">Gelombang</th>
            <th class="py-3 px-4 border-b text-center">Foto</th>
            <th class="py-3 px-4 border-b">Berkas Diserahkan</th>
            <th class="py-3 px-4 border-b text-center">Status Berkas</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($pendaftarans as $p)
          <tr class="hover:bg-slate-50/50 transition">
            <td class="py-4 px-4 font-mono font-bold text-blue-600 border-b">{{ $p->no_daftar }}</td>
            <td class="py-4 px-4 border-b">
              <span class="font-bold text-slate-800 block">{{ $p->nama_lengkap }}</span>
              <span class="text-slate-400 text-xxs block mt-0.5">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
            </td>
            <td class="py-4 px-4 border-b text-slate-600">{{ $p->asal_sekolah }}</td>
            <td class="py-4 px-4 border-b font-medium text-slate-700">{{ $p->gelombang }}</td>
            <td class="py-4 px-4 border-b text-center">
              @if($p->foto_siswa)
                <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold">
                  <i class="fas fa-check-circle"></i> Sudah
                </span>
              @else
                <span class="inline-flex items-center gap-1 text-slate-400 italic">
                  <i class="fas fa-times-circle"></i> Belum
                </span>
              @endif
            </td>
            <td class="py-4 px-4 border-b">
              @if($p->berkas_lengkap && count($p->berkas_lengkap) > 0)
                <div class="text-xxs text-slate-600 space-y-0.5">
                  @foreach($p->berkas_lengkap as $item)
                    <span class="inline-block bg-slate-100 text-slate-700 px-1.5 py-0.5 rounded mr-1 mb-1 capitalize">
                      {{ str_replace('_', ' ', $item) }}
                    </span>
                  @endforeach
                </div>
              @else
                <span class="text-slate-400 italic text-xxs">Belum ada berkas</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b text-center font-bold">
              @if($p->verified_at)
                <span class="text-emerald-600"><i class="fas fa-check-double mr-1"></i> Verified</span>
              @else
                <span class="text-amber-600"><i class="fas fa-clock mr-1"></i> Belum Verif</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data pendaftaran ditemukan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Print Footer / Signatures --}}
  <div class="print-only mt-8" style="display: none;">
    <div class="flex justify-between text-xs text-slate-700">
      <div>
        <p>Mengetahui,</p>
        <p class="font-bold mt-12">Ketua Panitia PPDB</p>
        <p class="text-xxs text-slate-400 mt-1">SMK Muhammadiyah 1 Bantul</p>
      </div>
      <div class="text-right">
        <p>Bantul, {{ now()->translatedFormat('d F Y') }}</p>
        <p class="font-bold mt-12">Petugas Pendaftaran</p>
        <p class="text-xxs text-slate-400 mt-1">( {{ auth()->user()->name }} )</p>
      </div>
    </div>
  </div>

</div>
@endsection

@push('styles')
<style>
  @media print {
    /* Hide non-print elements */
    aside, header, .no-print, .flash-message, nav, topbar {
      display: none !important;
    }
    
    /* Reset layout structures for print */
    body, html {
      background: white !important;
      color: black !important;
      padding: 0 !important;
      margin: 0 !important;
      width: 100% !important;
      height: auto !important;
    }
    
    /* Reset flex/grid container layout */
    div[style*="display:flex"], 
    div[style*="display: flex"],
    div[style*="margin-left"] {
      display: block !important;
      margin-left: 0 !important;
      padding: 0 !important;
      width: 100% !important;
      min-height: auto !important;
      box-shadow: none !important;
    }
    
    main {
      padding: 0 !important;
      margin: 0 !important;
      width: 100% !important;
    }
    
    .print-only {
      display: block !important;
    }
    
    .print-table {
      width: 100% !important;
      border: 1px solid #000 !important;
      border-collapse: collapse !important;
      margin-top: 15px;
    }
    
    .print-table th, .print-table td {
      border: 1px solid #000 !important;
      padding: 6px 8px !important;
      color: #000 !important;
      font-size: 10px !important;
    }
    
    .print-bg-gray {
      background-color: #f1f5f9 !important;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    
    .print-w-full {
      width: 100% !important;
      border-radius: 0 !important;
      box-shadow: none !important;
      border: none !important;
      padding: 0 !important;
    }
  }
</style>
@endpush
