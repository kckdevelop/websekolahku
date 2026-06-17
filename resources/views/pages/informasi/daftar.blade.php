@extends('layouts.app')
@section('title', 'Pendaftaran SPMB - SMK Muhammadiyah 1 Bantul')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-orange-950 relative overflow-hidden">

  {{-- Background decorations --}}
  <div class="absolute inset-0 overflow-hidden pointer-events-none">
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-primary/20 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-orange-500/15 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-500/5 rounded-full blur-3xl"></div>
  </div>

  <div class="relative z-10 max-w-6xl mx-auto px-4 py-16 sm:px-6 lg:px-8">

    {{-- Header --}}
    <div class="text-center mb-14">
      <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-4 py-2 text-white/80 text-sm font-medium mb-6">
        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
        Pendaftaran Siswa Baru Tahun Ajaran 2025/2026
      </div>
      <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight mb-4">
        Seleksi Penerimaan<br>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-300">Murid Baru (SPMB)</span>
      </h1>
      <p class="text-slate-300 text-lg max-w-xl mx-auto">
        SMK Muhammadiyah 1 Bantul — Mendaftar mudah, cepat, dan aman melalui verifikasi WhatsApp.
      </p>
    </div>

    {{-- Alert --}}
    @if (session('success'))
      <div class="mb-6 bg-emerald-500/20 border border-emerald-400/30 text-emerald-200 px-5 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-check-circle text-emerald-400 text-lg"></i>
        <span>{{ session('success') }}</span>
      </div>
    @endif
    @if (session('info'))
      <div class="mb-6 bg-blue-500/20 border border-blue-400/30 text-blue-200 px-5 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-info-circle text-blue-400 text-lg"></i>
        <span>{{ session('info') }}</span>
      </div>
    @endif

    {{-- Alur Pendaftaran --}}
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-6 sm:p-8 mb-10">
      <h2 class="text-white font-bold text-lg mb-6 text-center"><i class="fas fa-list-ol mr-2 text-primary"></i> Alur Pendaftaran Online</h2>
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
          <div class="text-xs font-bold text-white mb-1">{{ $i + 1 }}. {{ $s['label'] }}</div>
          <div class="text-xs text-slate-400">{{ $s['desc'] }}</div>
          @if($i < 4)
            <div class="hidden sm:block absolute mt-7 ml-28 text-white/30 text-xl"><i class="fas fa-chevron-right"></i></div>
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
         class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-3xl p-8 text-white hover:bg-white/20 transition-all duration-300 text-center block">
        <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 group-hover:bg-white/20 transition-colors">
          <i class="fas fa-sign-in-alt"></i>
        </div>
        <h3 class="text-xl font-extrabold mb-2">Sudah Punya Akun?</h3>
        <p class="text-slate-300 text-sm leading-relaxed">Masuk dengan nomor WhatsApp dan password yang telah Anda buat.</p>
        <div class="mt-5 bg-white/10 border border-white/20 rounded-xl py-2.5 px-4 text-sm font-bold inline-flex items-center gap-2 group-hover:bg-white/20 transition-colors">
          Login Sekarang <i class="fas fa-arrow-right"></i>
        </div>
      </a>
    </div>

    {{-- Info Box --}}
    <div class="mt-10 bg-amber-500/10 border border-amber-400/30 rounded-2xl p-5 max-w-2xl mx-auto">
      <div class="flex items-start gap-3">
        <i class="fas fa-exclamation-triangle text-amber-400 text-lg mt-0.5"></i>
        <div class="text-sm text-amber-200">
          <p class="font-bold mb-1">Informasi Penting:</p>
          <ul class="space-y-1 text-amber-200/80 list-disc pl-4">
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
