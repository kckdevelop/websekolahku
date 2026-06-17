@extends('layouts.petugas')
@section('title', 'Laporan Pemeriksaan Kesehatan (UKS)')
@section('subtitle', 'Laporan hasil pemeriksaan tinggi badan, berat badan, golongan darah, mata minus, buta warna, dan tato/tindik')

@section('content')
<div class="space-y-6">

  {{-- Stats Cards (Hidden on print) --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 no-print">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Total Pendaftar</span>
        <span class="text-2xl font-bold text-slate-800 mt-1 block">{{ $totalAll }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Belum Diperiksa</span>
        <span class="text-2xl font-bold text-amber-600 mt-1 block">{{ $totalBelum }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
        <i class="fas fa-heartbeat animate-pulse"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Sudah Diperiksa</span>
        <span class="text-2xl font-bold text-emerald-600 mt-1 block">{{ $totalSudah }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
  </div>

  {{-- Filters Form (Hidden on print) --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
    <form method="GET" action="{{ route('petugas.kesehatan.laporan') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
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
        <select name="status" class="text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-100 bg-white text-slate-600">
          <option value="">-- Status Periksa --</option>
          <option value="sudah" {{ request('status') === 'sudah' ? 'selected' : '' }}>Sudah Diperiksa</option>
          <option value="belum" {{ request('status') === 'belum' ? 'selected' : '' }}>Belum Diperiksa</option>
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

      @if(request('gelombang') || request('status') || request('search'))
        <a href="{{ route('petugas.kesehatan.laporan') }}" class="text-xs text-rose-500 hover:text-rose-700 font-semibold">
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
      <h2 class="text-lg font-bold uppercase tracking-wider text-slate-900">Laporan Pemeriksaan Kesehatan Siswa Baru (UKS)</h2>
      <h3 class="text-md font-bold text-slate-700">SMK MUHAMMADIYAH 1 BANTUL</h3>
      <p class="text-xs text-slate-500">
        @if(request('gelombang')) {{ request('gelombang') }} @else Semua Gelombang @endif
        | Filter: @if(request('status')) {{ request('status') === 'sudah' ? 'Sudah Diperiksa' : 'Belum Diperiksa' }} @else Semua @endif
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
            <th class="py-3 px-4 border-b">Nama Siswa</th>
            <th class="py-3 px-4 border-b">Asal Sekolah</th>
            <th class="py-3 px-4 border-b text-center">Fisik (TB/BB/Gol)</th>
            <th class="py-3 px-4 border-b text-center">Mata / Buta Warna</th>
            <th class="py-3 px-4 border-b text-center">Tato / Tindik</th>
            <th class="py-3 px-4 border-b">Riwayat Penyakit &amp; Catatan</th>
            <th class="py-3 px-4 border-b">Petugas UKS</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($pendaftarans as $p)
          <tr class="hover:bg-slate-50/50 transition">
            <td class="py-4 px-4 font-mono font-bold text-blue-600 border-b">{{ $p->no_daftar }}</td>
            <td class="py-4 px-4 border-b">
              <span class="font-bold text-slate-800 block">{{ $p->nama_lengkap }}</span>
              <span class="text-slate-400 text-xxs block mt-0.5">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }} | {{ $p->gelombang }}</span>
            </td>
            <td class="py-4 px-4 border-b text-slate-600">{{ $p->asal_sekolah }}</td>
            <td class="py-4 px-4 border-b text-center">
              @if($p->kesehatan_verified_at)
                <span class="font-semibold block text-slate-800">TB: {{ $p->kesehatan_tinggi_badan }} cm</span>
                <span class="font-semibold block text-slate-800">BB: {{ $p->kesehatan_berat_badan }} kg</span>
                <span class="text-slate-500 text-xxs block mt-0.5">Gol. Darah: {{ $p->kesehatan_golongan_darah ?? '-' }}</span>
              @else
                <span class="text-slate-400 italic">Belum Cek</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b text-center">
              @if($p->kesehatan_verified_at)
                <span class="font-semibold block {{ $p->kesehatan_buta_warna === 'ya' ? 'text-rose-600 font-bold' : 'text-slate-800' }}">
                  Buta Warna: {{ $p->kesehatan_buta_warna === 'ya' ? 'Ya' : 'Tidak' }}
                </span>
                <span class="text-slate-500 text-xxs block mt-0.5">Mata Minus: {{ $p->kesehatan_mata_minus ?? 'Tidak' }}</span>
              @else
                <span class="text-slate-400 italic">Belum Cek</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b text-center">
              @if($p->kesehatan_verified_at)
                @if($p->kesehatan_tato_tindik === 'tidak')
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xxs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">Bersih</span>
                @else
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xxs font-bold bg-rose-50 text-rose-600 border border-rose-100 capitalize">
                    {{ str_replace('_', ' & ', $p->kesehatan_tato_tindik) }}
                  </span>
                @endif
              @else
                <span class="text-slate-400 italic">Belum Cek</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b">
              @if($p->kesehatan_verified_at)
                <p class="text-xxs font-semibold text-slate-800">Penyakit: <span class="font-normal text-slate-600">{{ $p->kesehatan_riwayat_penyakit ?? 'Tidak ada' }}</span></p>
                <p class="text-xxs font-semibold text-slate-850 mt-0.5">Catatan: <span class="font-normal text-slate-600">{{ $p->kesehatan_catatan ?? '-' }}</span></p>
              @else
                <span class="text-slate-400 italic text-xxs">Belum Cek</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b text-slate-600">
              @if($p->kesehatan_verified_at)
                <span class="font-bold block text-slate-700">{{ $p->kesehatan_petugas }}</span>
                <span class="text-slate-400 text-xxs block mt-0.5">{{ $p->kesehatan_verified_at->translatedFormat('d M Y') }}</span>
              @else
                <span class="text-slate-400 italic">-</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="py-8 text-center text-slate-400">Tidak ada data pendaftaran ditemukan.</td>
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
        <p class="font-bold mt-12">Petugas UKS &amp; Kesehatan</p>
        <p class="text-xxs text-slate-400 mt-1">( {{ auth()->user()->name }} )</p>
      </div>
    </div>
  </div>

</div>
@endsection

@section('styles')
<style>
  @media print {
    aside, header, .no-print, .flash-message {
      display: none !important;
    }
    body {
      background: white !important;
      color: black !important;
      padding: 0 !important;
      margin: 0 !important;
    }
    main {
      padding: 0 !important;
      margin: 0 !important;
    }
    div[style*="margin-left"] {
      margin-left: 0 !important;
    }
    .print-only {
      display: block !important;
    }
    .print-table {
      width: 100% !important;
      border: 1px solid #cbd5e1 !important;
    }
    .print-table th, .print-table td {
      border: 1px solid #cbd5e1 !important;
      padding: 8px !important;
      color: black !important;
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
    }
  }
</style>
@endsection
