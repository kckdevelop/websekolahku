@extends('layouts.app')
@section('title', 'Pendaftaran SPMB - SMK Muhammadiyah 1 Bantul')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50/30 to-blue-50/40 dark:from-slate-900 dark:via-blue-950 dark:to-orange-950 relative overflow-hidden transition-colors duration-300">

  {{-- Background decorations --}}
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-orange-500/15 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-3xl"></div>
  </div>

  <div class="relative z-10 max-w-6xl mx-auto px-4 py-16 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="text-center mb-14">
      <div class="inline-flex items-center gap-2 bg-slate-800/5 dark:bg-white/10 backdrop-blur-sm border border-slate-200 dark:border-white/20 rounded-full px-4 py-2 text-slate-700 dark:text-white/80 text-sm font-medium mb-6">
        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
        Pendaftaran Siswa Baru Tahun Ajaran 2025/2026
      </div>
      <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight mb-4">
        Seleksi Penerimaan<br>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500 dark:from-orange-400 dark:to-amber-300">Murid Baru (SPMB)</span>
      </h1>
      <p class="text-slate-600 dark:text-slate-300 text-lg max-w-xl mx-auto">
        SMK Muhammadiyah 1 Bantul — Mendaftar mudah, cepat, dan aman melalui verifikasi WhatsApp.
      </p>
    </div>

    {{-- Alert --}}
    @if (session('success'))
      <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-400/30 text-emerald-800 dark:text-emerald-200 px-5 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif
    @if (session('info'))
      <div class="mb-6 bg-blue-50 dark:bg-blue-500/20 border border-blue-200 dark:border-blue-400/30 text-blue-800 dark:text-blue-200 px-5 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-info-circle text-blue-500 dark:text-blue-400 text-lg"></i>
        <span>{{ session('info') }}</span>
      </div>
    @endif

    {{-- Alur Pendaftaran --}}
    <div class="bg-white dark:bg-white/5 backdrop-blur-sm border border-slate-200 dark:border-white/10 rounded-3xl p-6 sm:p-8 mb-10 shadow-lg dark:shadow-none transition-all duration-300">
      <h2 class="text-slate-900 dark:text-white font-bold text-lg mb-6 text-center"><i class="fas fa-list-ol mr-2 text-primary"></i> Alur Pendaftaran Online</h2>
      <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        @php
          $steps = [
            ['icon' => 'fa-user-plus', 'label' => 'Buat Akun', 'desc' => 'Daftar dengan No. WA'],
            ['icon' => 'fa-comment-dots', 'label' => 'Verifikasi OTP', 'desc' => 'Konfirmasi via WhatsApp'],
            ['icon' => 'fa-sign-in-alt', 'label' => 'Login', 'desc' => 'Masuk ke sistem'],
            ['icon' => 'fa-wpforms', 'label' => 'Isi Formulir', 'desc' => '5 langkah mudah'],
            ['icon' => 'fa-print', 'label' => 'Cetak Bukti', 'desc' => 'Bawa saat seleksi'],
          ];
        @endphp
        @foreach($steps as $i => $s)
        <div class="flex flex-col items-center text-center group">
          <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-orange-600 flex items-center justify-center text-white text-xl shadow-lg shadow-primary/30 mb-3 group-hover:scale-110 transition-transform">
            <i class="fas {{ $s['icon'] }}"></i>
          </div>
          <div class="text-xs font-bold text-slate-800 dark:text-white mb-1">{{ $i + 1 }}. {{ $s['label'] }}</div>
          <div class="text-xs text-slate-500 dark:text-slate-400">{{ $s['desc'] }}</div>
          @if($i < 4)
            <div class="hidden sm:block absolute mt-7 ml-28 text-slate-300 dark:text-white/30 text-xl"><i class="fas fa-chevron-right"></i></div>
          @endif
        </div>
        @endforeach
      </div>
    </div>

    {{-- CTA Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto">
      {{-- Buat Akun Baru --}}
      <a href="{{ route('spmb.register') }}" id="btn-buat-akun"
         class="group bg-gradient-to-br from-primary to-blue-700 rounded-3xl p-8 text-white shadow-2xl shadow-primary/30 hover:scale-105 transition-all duration-300 text-center block">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 group-hover:bg-white/30 transition-colors">
          <i class="fas fa-user-plus"></i>
        </div>
        <h3 class="text-xl font-extrabold mb-2">Buat Akun Baru</h3>
        <p class="text-blue-100 text-sm leading-relaxed">Belum punya akun? Daftar sekarang menggunakan nomor WhatsApp Anda.</p>
        <div class="mt-5 bg-white/20 rounded-xl py-2.5 px-4 text-sm font-bold inline-flex items-center gap-2 group-hover:bg-white/30 transition-colors">
          Mulai Daftar <i class="fas fa-arrow-right"></i>
        </div>
      </a>

      {{-- Sudah Punya Akun --}}
      <a href="{{ route('spmb.login') }}" id="btn-login-siswa"
         class="group bg-white dark:bg-white/10 backdrop-blur-sm border border-slate-200 dark:border-white/20 rounded-3xl p-8 text-slate-800 dark:text-white hover:bg-slate-50 dark:hover:bg-white/20 transition-all duration-300 text-center block shadow-lg dark:shadow-none">
        <div class="w-16 h-16 bg-slate-100 dark:bg-white/10 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 text-slate-700 dark:text-white group-hover:bg-slate-200 dark:group-hover:bg-white/20 transition-colors">
          <i class="fas fa-sign-in-alt"></i>
        </div>
        <h3 class="text-xl font-extrabold mb-2 text-slate-900 dark:text-white">Sudah Punya Akun?</h3>
        <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">Masuk dengan nomor WhatsApp dan password yang telah Anda buat.</p>
        <div class="mt-5 bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/20 rounded-xl py-2.5 px-4 text-sm font-bold inline-flex items-center gap-2 text-slate-700 dark:text-white group-hover:bg-slate-200 dark:group-hover:bg-white/20 transition-colors">
          Login Sekarang <i class="fas fa-arrow-right"></i>
        </div>
      </a>
    </div>

    {{-- Tes Gaya Belajar Mandiri --}}
    <div class="mt-10 max-w-2xl mx-auto bg-white dark:bg-white/5 backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-3xl overflow-hidden shadow-xl dark:shadow-2xl transition-all duration-300">
      <div class="flex flex-col md:flex-row items-stretch">

        {{-- Left: Icon & Info --}}
        <div class="bg-gradient-to-br from-indigo-600/90 to-purple-700/90 p-8 md:w-2/5 flex flex-col items-center justify-center text-center relative overflow-hidden">
          <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
          <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full pointer-events-none"></div>
          <div class="relative z-10">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-white text-3xl mb-4 mx-auto backdrop-blur-sm shadow-lg">
              <i class="fas fa-brain"></i>
            </div>
            <h2 class="text-xl font-extrabold text-white mb-2">Tes Gaya Belajar</h2>
            <p class="text-indigo-200 text-xs leading-relaxed">
              Khusus untuk calon siswa yang berkasnya <strong class="text-white font-semibold">sudah diverifikasi</strong> oleh petugas.
            </p>
            {{-- VAK Badges --}}
            <div class="flex gap-2 justify-center mt-5 flex-wrap">
              <span class="bg-blue-400/30 text-blue-100 text-xxs font-bold px-3 py-1 rounded-full border border-blue-300/40">
                <i class="fas fa-eye mr-1"></i> Visual
              </span>
              <span class="bg-green-400/30 text-green-100 text-xxs font-bold px-3 py-1 rounded-full border border-green-300/40">
                <i class="fas fa-headphones mr-1"></i> Auditori
              </span>
              <span class="bg-purple-400/30 text-purple-100 text-xxs font-bold px-3 py-1 rounded-full border border-purple-300/40">
                <i class="fas fa-hand-paper mr-1"></i> Kinestetik
              </span>
            </div>
          </div>
        </div>

        {{-- Right: How to & CTA --}}
        <div class="p-8 md:w-3/5 flex flex-col justify-center space-y-5">
          <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Sudah Diverifikasi?</h3>
            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-light">
              Ikuti Tes Gaya Belajar Mandiri (VAK) untuk membantu sekolah memahami cara belajar terbaik Anda. Tes ini wajib diselesaikan setelah berkas pendaftaran terverifikasi.
            </p>
          </div>

          {{-- Cara Login --}}
          <div class="space-y-2.5">
            <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Cara masuk ke tes:</p>
            <div class="flex items-start gap-3">
              <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-orange-600 dark:text-orange-400 text-xs font-bold flex-shrink-0 mt-0.5">1</div>
              <p class="text-sm text-slate-600 dark:text-slate-300">Klik tombol <strong class="text-slate-800 dark:text-white">"Mulai Tes Gaya Belajar"</strong> di bawah ini</p>
            </div>
            <div class="flex items-start gap-3">
              <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-orange-600 dark:text-orange-400 text-xs font-bold flex-shrink-0 mt-0.5">2</div>
              <p class="text-sm text-slate-600 dark:text-slate-300">Masukkan <strong class="text-slate-800 dark:text-white">Nomor Pendaftaran</strong> dan <strong class="text-slate-800 dark:text-white">Tanggal Lahir</strong></p>
            </div>
            <div class="flex items-start gap-3">
              <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-orange-600 dark:text-orange-400 text-xs font-bold flex-shrink-0 mt-0.5">3</div>
              <p class="text-sm text-slate-600 dark:text-slate-300">Jawab 6 pertanyaan dan isi minat bakat, lalu kirim hasilnya</p>
            </div>
          </div>

          {{-- CTA Button --}}
          <a href="{{ route('spmb.tes-gaya-belajar.login') }}"
             class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 text-sm">
            <i class="fas fa-brain text-xs"></i>
            Mulai Tes Gaya Belajar
            <i class="fas fa-arrow-right text-xs opacity-70"></i>
          </a>
          <p class="text-xxs text-slate-500 dark:text-slate-400">
            <i class="fas fa-shield-alt mr-1"></i>
            Hanya bisa diakses jika berkas Anda sudah diverifikasi petugas.
          </p>
        </div>

      </div>
    </div>

    {{-- Info Box --}}
    <div class="mt-10 bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-400/30 rounded-2xl p-5 max-w-2xl mx-auto transition-all duration-300">
      <div class="flex items-start gap-3">
        <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 text-lg mt-0.5"></i>
        <div class="text-sm text-amber-900 dark:text-amber-200">
          <p class="font-bold mb-1 text-amber-950 dark:text-amber-200">Informasi Penting:</p>
          <ul class="space-y-1 text-amber-800 dark:text-amber-200/80 list-disc pl-4">
            <li>Setiap nomor WhatsApp hanya dapat digunakan untuk <strong>satu pendaftaran</strong> per tahun ajaran.</li>
            <li>Nomor WhatsApp yang didaftarkan harus <strong>aktif</strong> untuk menerima kode verifikasi OTP.</li>
            <li>Setelah mendaftar, simpan nomor pendaftaran dan cetak bukti untuk dibawa saat seleksi.</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
