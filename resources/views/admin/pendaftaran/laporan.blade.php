@extends('layouts.admin')
@section('title', 'Laporan Pendaftaran')
@section('subtitle', 'Laporan lengkap seluruh pendaftaran, verifikasi, tes kesehatan, wawancara, dan status pembayaran')

@section('content')
<div class="space-y-6">

  {{-- Stats Cards (Hidden on print) --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 no-print">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Total Pendaftaran</span>
        <span class="text-xl font-bold text-slate-800 mt-1 block">{{ $totalAll }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Pending</span>
        <span class="text-xl font-bold text-amber-600 mt-1 block">{{ $totalPending }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
        <i class="fas fa-hourglass-half"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Verifikasi</span>
        <span class="text-xl font-bold text-indigo-600 mt-1 block">{{ $totalVerified }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Diterima</span>
        <span class="text-xl font-bold text-emerald-600 mt-1 block">{{ $totalDiterima }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
        <i class="fas fa-user-check"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block">Ditolak</span>
        <span class="text-xl font-bold text-rose-600 mt-1 block">{{ $totalDitolak }}</span>
      </div>
      <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
        <i class="fas fa-user-times"></i>
      </div>
    </div>
  </div>

  {{-- Filters Form (Hidden on print) --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 no-print">
    <form method="GET" action="{{ route('admin.pendaftaran.laporan') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
      <div>
        <select name="gelombang" class="text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/20 bg-white text-slate-600">
          <option value="">-- Semua Gelombang --</option>
          @foreach($gelombangs as $gel)
            <option value="{{ $gel->nama_gelombang }}" {{ request('gelombang') === $gel->nama_gelombang ? 'selected' : '' }}>
              {{ $gel->nama_gelombang }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <select name="status" class="text-xs border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/20 bg-white text-slate-600">
          <option value="">-- Semua Status --</option>
          <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="verifikasi" {{ request('status') === 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
          <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Diterima</option>
          <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>

      <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no daftar / sekolah..."
               class="pl-8 pr-4 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 w-52 bg-white text-slate-700">
        <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
      </div>

      <button type="submit" class="bg-primary hover:bg-secondary text-white text-xs font-bold px-4 py-2 rounded-xl transition">
        Filter
      </button>

      @if(request('gelombang') || request('status') || request('search'))
        <a href="{{ route('admin.pendaftaran.laporan') }}" class="text-xs text-rose-500 hover:text-rose-700 font-semibold">
          Reset
        </a>
      @endif
    </form>

    <div class="flex items-center gap-2">
      <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition flex items-center gap-2 shadow-md shadow-indigo-600/10">
        <i class="fas fa-print"></i> Cetak Laporan
      </button>
    </div>
  </div>

  {{-- Print Header (Only visible on print) --}}
  <div class="print-only mb-6" style="display: none;">
    <div class="text-center space-y-1 pb-4 border-b-2 border-slate-800">
      <h2 class="text-lg font-bold uppercase tracking-wider text-slate-900">Laporan Hasil Pendaftaran Siswa Baru (PPDB)</h2>
      <h3 class="text-md font-bold text-slate-700">SMK MUHAMMADIYAH 1 BANTUL</h3>
      <p class="text-xs text-slate-500">
        @if(request('gelombang')) {{ request('gelombang') }} @else Semua Gelombang @endif
        | Status: @if(request('status')) {{ ucfirst(request('status')) }} @else Semua Status @endif
        | Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }}
      </p>
    </div>
  </div>

  {{-- Table Container --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden print-w-full">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse border-slate-200 text-slate-800 print-table text-xs">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xxs uppercase tracking-wider font-bold print-bg-gray">
            <th class="py-3 px-4 border-b">No Daftar</th>
            <th class="py-3 px-4 border-b">Biodata Calon Siswa</th>
            <th class="py-3 px-4 border-b">Pilihan Jurusan</th>
            <th class="py-3 px-4 border-b">Hasil UKS</th>
            <th class="py-3 px-4 border-b">Hasil Wawancara</th>
            <th class="py-3 px-4 border-b">Pembayaran</th>
            <th class="py-3 px-4 border-b text-center">Status</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($pendaftarans as $p)
          <tr class="hover:bg-slate-50/50 transition">
            <td class="py-4 px-4 font-mono font-bold text-primary border-b">{{ $p->no_daftar }}</td>
            <td class="py-4 px-4 border-b">
              <span class="font-bold text-slate-800 block">{{ $p->nama_lengkap }}</span>
              <span class="text-slate-400 text-xxs block mt-0.5">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }} | {{ $p->asal_sekolah }}</span>
            </td>
            <td class="py-4 px-4 border-b">
              <span class="font-semibold text-slate-800 block">1. {{ $p->pil1 }}</span>
              <span class="text-slate-500 text-xxs block mt-0.5">2. {{ $p->pil2 }} | 3. {{ $p->pil3 }}</span>
            </td>
            <td class="py-4 px-4 border-b">
              @if($p->kesehatan_verified_at)
                <span class="font-medium text-slate-800 block">TB: {{ $p->kesehatan_tinggi_badan }} | BB: {{ $p->kesehatan_berat_badan }} | Gol: {{ $p->kesehatan_golongan_darah }}</span>
                <span class="text-slate-500 text-xxs block mt-0.5">Buta Warna: {{ $p->kesehatan_buta_warna == 'ya' ? 'Ya' : 'Tidak' }} | Tato: {{ $p->kesehatan_tato_tindik == 'tidak' ? 'Tidak' : 'Ada' }}</span>
              @else
                <span class="text-slate-400 italic text-xxs">Belum Cek UKS</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b">
              @if($p->wawancara_verified_at || $p->gaya_belajar_verified_at)
                <span class="font-medium text-slate-800 block">Gaya: {{ ucfirst($p->gaya_belajar_tipe ?? '-') }}</span>
                <span class="text-slate-500 text-xxs block mt-0.5">BTQ: {{ $p->wawancara_baca_tulis_alquran ?? '-' }} | Sholat: {{ $p->wawancara_solat_fardhu ?? '-' }}</span>
              @else
                <span class="text-slate-400 italic text-xxs">Belum Wawancara</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b">
              @if($p->pembayaran_status === 'lunas')
                <span class="font-bold text-emerald-600 block">Rp {{ number_format($p->pembayaran_nominal, 0, ',', '.') }}</span>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xxs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 mt-1">Lunas</span>
              @else
                <span class="text-slate-400 block">Rp {{ number_format($p->pembayaran_nominal ?? 0, 0, ',', '.') }}</span>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xxs font-bold bg-rose-50 text-rose-600 border border-rose-100 mt-1">Belum Lunas</span>
              @endif
            </td>
            <td class="py-4 px-4 border-b text-center">
              @if($p->status === 'diterima')
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-700">Diterima</span>
              @elseif($p->status === 'ditolak')
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xxs font-bold bg-rose-100 text-rose-700">Ditolak</span>
              @elseif($p->status === 'verifikasi')
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xxs font-bold bg-indigo-100 text-indigo-700">Verifikasi</span>
              @else
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xxs font-bold bg-amber-100 text-amber-700">Pending</span>
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

@section('styles')
<style>
  @media print {
    /* Hide layout sections */
    aside, header, .no-print, .flash-message {
      display: none !important;
    }
    /* Main body spacing adjust */
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
    /* Print visible sections */
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
