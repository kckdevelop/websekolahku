@extends('layouts.app')
@section('title', 'Dashboard Pendaftaran')

@section('content')
<div class="bg-slate-50 dark:bg-slate-900 py-16 min-h-[70vh] flex items-center">
  <div class="max-w-md mx-auto px-4 w-full">
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-700 p-8 text-center space-y-6">
      
      {{-- Success Icon --}}
      <div class="inline-flex w-20 h-20 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-500 rounded-full items-center justify-center text-4xl animate-bounce-slow">
        <i class="fas fa-check-circle"></i>
      </div>

      {{-- Session Alerts --}}
      @if(session('success'))
        <div class="px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs flex items-center gap-2 text-left">
          <i class="fas fa-check-circle flex-shrink-0"></i> <span>{!! session('success') !!}</span>
        </div>
      @endif

      @if(session('warning'))
        <div class="px-4 py-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-xs flex items-center gap-2 text-left">
          <i class="fas fa-exclamation-triangle flex-shrink-0"></i> <span>{!! session('warning') !!}</span>
        </div>
      @endif

      @if(session('error'))
        <div class="px-4 py-3 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-2 text-left">
          <i class="fas fa-times-circle flex-shrink-0"></i> <span>{!! session('error') !!}</span>
        </div>
      @endif

      {{-- Message --}}
      <div>
        <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white">Pendaftaran Berhasil!</h1>
        <p class="text-slate-550 dark:text-slate-400 mt-2 text-xs">Data pendaftaran Anda telah tersimpan di sistem kami.</p>
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

      {{-- Status Verifikasi & Tes Gaya Belajar --}}
      @if($pendaftaran->verified_at)
        @if($pendaftaran->gaya_belajar_tipe)
          {{-- Sudah ikut tes --}}
          <div class="bg-purple-50 dark:bg-purple-950/20 border border-purple-200 dark:border-purple-900 rounded-2xl p-4 text-left space-y-2.5">
            <div class="flex items-center gap-2 text-purple-700 dark:text-purple-400 font-bold text-xs">
              <i class="fas fa-brain"></i> Hasil Gaya Belajar
            </div>
            <p class="text-xxs text-slate-500 dark:text-slate-400">Anda telah menyelesaikan Tes Gaya Belajar Mandiri.</p>
            <div class="flex items-center justify-between border-t border-purple-100 dark:border-purple-900/40 pt-2">
              <span class="text-xs text-slate-600 dark:text-slate-400">Tipe Gaya Belajar:</span>
              <span class="px-3 py-1 bg-purple-600 text-white rounded-full text-xxs font-extrabold capitalize tracking-wide shadow-sm">{{ $pendaftaran->gaya_belajar_tipe }}</span>
            </div>
            <div class="flex flex-col text-xxs">
              <span class="text-slate-400 uppercase font-bold">Minat, Bakat &amp; Hobi:</span>
              <span class="font-semibold text-slate-700 dark:text-slate-300 mt-0.5">{{ $pendaftaran->gaya_belajar_minat_bakat }}</span>
            </div>
          </div>
        @else
          {{-- Terverifikasi tapi belum tes --}}
          <div class="bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-200 dark:border-emerald-900 rounded-2xl p-4 text-left space-y-2">
            <div class="flex items-center gap-2 text-emerald-700 dark:text-emerald-400 font-bold text-xs">
              <i class="fas fa-check-circle"></i> Berkas Terverifikasi!
            </div>
            <p class="text-xxs text-slate-600 dark:text-slate-400 leading-relaxed">
              Berkas pendaftaran Anda telah diverifikasi. Silakan lakukan <strong>Tes Gaya Belajar</strong> melalui menu di halaman informasi SPMB atau tautan berikut:
            </p>
            <a href="{{ route('spmb.tes-gaya-belajar.login') }}"
               class="inline-flex items-center gap-1.5 text-xs text-emerald-700 dark:text-emerald-400 font-bold hover:underline">
              <i class="fas fa-external-link-alt text-xxs"></i> Buka Halaman Tes Gaya Belajar
            </a>
          </div>
        @endif
      @else
        {{-- Belum diverifikasi --}}
        <div class="bg-amber-50/70 dark:bg-amber-950/10 border border-amber-200/80 dark:border-amber-900/50 rounded-2xl p-4 text-left space-y-2">
          <div class="flex items-center gap-2 text-amber-700 dark:text-amber-400 font-bold text-xs">
            <i class="fas fa-hourglass-half animate-pulse"></i> Menunggu Verifikasi Berkas
          </div>
          <p class="text-xxs text-slate-550 dark:text-slate-400 leading-relaxed">
            Berkas pendaftaran Anda sedang diperiksa petugas. Setelah terverifikasi, Anda bisa mengikuti Tes Gaya Belajar melalui halaman SPMB.
          </p>
        </div>
      @endif

      {{-- Action Buttons --}}
      <div class="flex flex-col gap-3 pt-2">
        <a href="{{ route('spmb.cetak', $pendaftaran) }}" target="_blank"
           class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md hover:shadow-lg hover:shadow-primary/30 inline-flex items-center justify-center gap-2 text-sm">
          <i class="fas fa-print"></i> Cetak Bukti Pendaftaran
        </a>
        <a href="{{ url('/') }}"
           class="w-full bg-slate-150 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-650 text-slate-700 dark:text-slate-300 font-semibold py-3 px-6 rounded-xl transition-all text-xs">
          Kembali ke Beranda
        </a>
        <form action="{{ route('spmb.logout') }}" method="POST" class="w-full">
          @csrf
          <button type="submit"
                  class="w-full bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/20 dark:hover:bg-rose-950/40 text-rose-600 dark:text-rose-400 font-semibold py-2.5 px-6 rounded-xl transition-all text-xs inline-flex items-center justify-center gap-2">
            <i class="fas fa-sign-out-alt"></i> Keluar / Logout Akun
          </button>
        </form>
      </div>

      {{-- Info note --}}
      <p class="text-xxs text-slate-450 dark:text-slate-500">
        * Simpan nomor pendaftaran Anda untuk melakukan pengecekan status verifikasi di kemudian hari.
      </p>

    </div>
  </div>
</div>
@endsection
