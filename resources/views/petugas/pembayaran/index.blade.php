@extends('layouts.petugas')
@section('title', 'Pembayaran & Keuangan PPDB')
@section('subtitle', 'Catat transaksi biaya pendaftaran dan administrasi daftar ulang calon siswa baru')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

  {{-- Stats Row --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase block tracking-wider">Total Pendaftar</span>
        <span class="text-2xl font-bold text-slate-800 block mt-1">{{ $totalAll }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase block tracking-wider">Belum Melunasi</span>
        <span class="text-2xl font-bold text-amber-600 block mt-1">{{ $totalBelum }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl animate-pulse">
        <i class="fas fa-money-bill-wave"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase block tracking-wider">Sudah Melunasi (Lunas)</span>
        <span class="text-2xl font-bold text-emerald-600 block mt-1">{{ $totalLunas }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
  </div>

  {{-- Filter & Search --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div class="flex items-center gap-2">
      <a href="{{ route('petugas.pembayaran.dashboard') }}" 
         class="px-4 py-2 text-xs font-semibold rounded-xl transition {{ !request('filter') ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 hover:bg-slate-100 text-slate-600' }}">
        Semua
      </a>
      <a href="{{ route('petugas.pembayaran.dashboard') }}?filter=belum" 
         class="px-4 py-2 text-xs font-semibold rounded-xl transition {{ request('filter') === 'belum' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 hover:bg-slate-100 text-slate-600' }}">
        Belum Lunas
      </a>
      <a href="{{ route('petugas.pembayaran.dashboard') }}?filter=lunas" 
         class="px-4 py-2 text-xs font-semibold rounded-xl transition {{ request('filter') === 'lunas' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-50 hover:bg-slate-100 text-slate-600' }}">
        Lunas
      </a>
    </div>

    <form method="GET" action="{{ route('petugas.pembayaran.dashboard') }}" class="flex items-center gap-2">
      @if(request('filter'))
        <input type="hidden" name="filter" value="{{ request('filter') }}">
      @endif
      <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / No Daftar..."
               class="pl-9 pr-4 py-2 w-64 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-xs text-slate-700">
        <i class="fas fa-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
      </div>
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition">
        Cari
      </button>
    </form>
  </div>

  {{-- Table --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse text-slate-700">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 text-xxs uppercase tracking-wider font-bold">
            <th class="py-3 px-5">No Daftar</th>
            <th class="py-3 px-5">Nama Calon Siswa</th>
            <th class="py-3 px-5">Asal Sekolah</th>
            <th class="py-3 px-5">Nominal Bayar</th>
            <th class="py-3 px-5">Kasir / Penerima</th>
            <th class="py-3 px-5">Status Bayar</th>
            <th class="py-3 px-5 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50 text-xs">
          @forelse($pendaftarans as $p)
          <tr class="hover:bg-slate-50/50 transition">
            <td class="py-4 px-5 font-mono font-bold text-blue-600">{{ $p->no_daftar }}</td>
            <td class="py-4 px-5">
              <span class="font-bold text-slate-800 block">{{ $p->nama_lengkap }}</span>
              <span class="text-slate-400 text-xxs block mt-0.5">{{ $p->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
            </td>
            <td class="py-4 px-5 text-slate-600">{{ $p->asal_sekolah }}</td>
            <td class="py-4 px-5 font-bold text-slate-800">
              Rp {{ number_format($p->pembayaran_nominal, 0, ',', '.') }}
            </td>
            <td class="py-4 px-5 text-slate-500">
              {{ $p->pembayaran_petugas ?? '-' }}
            </td>
            <td class="py-4 px-5">
              @if($p->pembayaran_status === 'lunas')
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xxs font-bold bg-emerald-100 text-emerald-700">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lunas (Paid)
                </span>
              @else
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xxs font-bold bg-rose-100 text-rose-700">
                  <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Belum Lunas
                </span>
              @endif
            </td>
            <td class="py-4 px-5 text-center">
              <a href="{{ route('petugas.pembayaran.show', $p->id) }}" 
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-bold transition">
                <i class="fas fa-calculator"></i> Proses Transaksi
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data pendaftar ditemukan.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($pendaftarans->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
      {{ $pendaftarans->links() }}
    </div>
    @endif
  </div>

</div>
@endsection
