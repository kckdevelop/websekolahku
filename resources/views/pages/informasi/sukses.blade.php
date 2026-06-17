@extends('layouts.app')
@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class="bg-slate-50 dark:bg-slate-900 py-16 min-h-[70vh] flex items-center">
  <div class="max-w-md mx-auto px-4 w-full">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-700 p-8 text-center space-y-6">
      
      {{-- Success Icon --}}
      <div class="inline-flex w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-500 rounded-full items-center justify-center text-4xl animate-bounce-slow">
        <i class="fas fa-check-circle"></i>
      </div>

      {{-- Message --}}
      <div>
        <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white">Pendaftaran Berhasil!</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm">Data pendaftaran Anda telah tersimpan di sistem kami.</p>
      </div>

      {{-- Card Info --}}
      <div class="bg-slate-50 dark:bg-slate-750 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 text-left space-y-3">
        <div>
          <span class="text-xxs font-bold text-slate-400 uppercase block">Nomor Pendaftaran</span>
          <span class="text-lg font-bold text-primary tracking-wide">{{ $pendaftaran->no_daftar }}</span>
        </div>
        <div>
          <span class="text-xxs font-bold text-slate-400 uppercase block">Nama Lengkap</span>
          <span class="text-sm font-semibold text-slate-800 dark:text-white">{{ $pendaftaran->nama_lengkap }}</span>
        </div>
        <div>
          <span class="text-xxs font-bold text-slate-400 uppercase block">Pilihan Jurusan I</span>
          <span class="text-sm font-semibold text-slate-800 dark:text-white">
            @php
              $jurusans = ['TKR'=>'Teknik Kendaraan Ringan', 'TPM'=>'Teknik Permesinan', 'TAV'=>'Teknik Audio Video', 'TBSM'=>'Teknik Bisnis Sepeda Motor', 'RPL'=>'Rekayasa Perangkat Lunak'];
            @endphp
            {{ $jurusans[$pendaftaran->pil1] ?? $pendaftaran->pil1 }}
          </span>
        </div>
        <div>
          <span class="text-xxs font-bold text-slate-400 uppercase block">Asal Sekolah</span>
          <span class="text-sm font-semibold text-slate-800 dark:text-white">{{ $pendaftaran->asal_sekolah }}</span>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex flex-col gap-3">
        <a href="{{ route('spmb.cetak', $pendaftaran) }}" target="_blank"
           class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md hover:shadow-lg hover:shadow-primary/30 inline-flex items-center justify-center gap-2">
          <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
        </a>
        <a href="{{ url('/') }}"
           class="w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-655 text-slate-700 dark:text-slate-300 font-semibold py-3 px-6 rounded-xl transition-all text-sm">
          Kembali ke Beranda
        </a>
        <form action="{{ route('spmb.logout') }}" method="POST" class="w-full">
          @csrf
          <button type="submit"
                  class="w-full bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/20 dark:hover:bg-rose-950/40 text-rose-600 dark:text-rose-400 font-semibold py-3 px-6 rounded-xl transition-all text-sm inline-flex items-center justify-center gap-2">
            <i class="fas fa-sign-out-alt"></i> Keluar / Logout Akun
          </button>
        </form>
      </div>

      {{-- Info note --}}
      <p class="text-xxs text-slate-400">
        * Simpan nomor pendaftaran Anda untuk melakukan pengecekan status verifikasi di kemudian hari.
      </p>

    </div>
  </div>
</div>
@endsection
