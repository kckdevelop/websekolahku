@extends('layouts.petugas')
@section('title', 'Transaksi Pembayaran: ' . $pendaftaran->no_daftar)
@section('subtitle', 'Catat data pembayaran biaya pendaftaran calon siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  
  <div class="flex items-center gap-3 mb-4">
    <a href="{{ route('petugas.pembayaran.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1 text-sm font-semibold">
      <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Detail Siswa --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
      <div class="text-center pb-4 border-b border-slate-50">
        @if($pendaftaran->foto_siswa)
          <img src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}" class="w-28 h-36 object-cover mx-auto rounded-xl border-4 border-slate-100 shadow-sm">
        @else
          <div class="w-28 h-36 bg-slate-100 mx-auto rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
            <i class="fas fa-user text-slate-300 text-3xl mb-1"></i>
            <span class="text-xxs text-slate-400">Belum difoto</span>
          </div>
        @endif
        <h3 class="font-bold text-slate-800 text-sm mt-3">{{ $pendaftaran->nama_lengkap }}</h3>
        <p class="text-slate-400 text-xxs font-mono mt-1">{{ $pendaftaran->no_daftar }}</p>
      </div>

      <div class="space-y-2.5 text-xs">
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Asal Sekolah</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->asal_sekolah }}</span>
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Jenis Kelamin</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Pilihan Jurusan I</span>
          <span class="text-blue-700 font-bold mt-0.5 block">{{ $pendaftaran->pil1 }}</span>
        </div>
      </div>
    </div>

    {{-- Form Pembayaran --}}
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-calculator text-emerald-600"></i>
        <h4 class="font-bold text-slate-850 text-sm">Formulir Pembayaran PPDB</h4>
      </div>

      <form method="POST" action="{{ route('petugas.pembayaran.update', $pendaftaran->id) }}" class="p-6 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Nominal Pembayaran (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="pembayaran_nominal" required value="{{ old('pembayaran_nominal', $pendaftaran->pembayaran_nominal) }}" placeholder="Contoh: 150000"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-105 focus:border-emerald-500 outline-none text-sm text-slate-800 font-mono font-bold">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Pembayaran <span class="text-red-500">*</span></label>
            <select name="pembayaran_status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-emerald-105 focus:border-emerald-500 outline-none text-sm text-slate-800">
              <option value="belum_bayar" {{ old('pembayaran_status', $pendaftaran->pembayaran_status) === 'belum_bayar' ? 'selected' : '' }}>Belum Lunas</option>
              <option value="lunas" {{ old('pembayaran_status', $pendaftaran->pembayaran_status) === 'lunas' ? 'selected' : '' }}>Lunas (Lunas / Paid)</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Keterangan / Catatan Transaksi</label>
          <textarea name="pembayaran_keterangan" rows="4" placeholder="Contoh: Lunas biaya pendaftaran gelombang I + Seragam sekolah, dll..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-105 focus:border-emerald-500 outline-none text-sm text-slate-800 resize-none">{{ old('pembayaran_keterangan', $pendaftaran->pembayaran_keterangan) }}</textarea>
        </div>

        <button type="submit" class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-lg shadow-emerald-200">
          Simpan Transaksi Keuangan
        </button>
      </form>
    </div>

  </div>

</div>
@endsection
