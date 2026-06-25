@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan (404)')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center bg-slate-50 dark:bg-slate-900 py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Subtle Background Decorative Elements -->
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>

    <div class="max-w-md w-full text-center relative z-10">
        <!-- Error Illustration / Icon -->
        <div class="mb-8 flex justify-center">
            <div class="relative w-48 h-48 flex items-center justify-center">
                <!-- Outer pulsing ring -->
                <div class="absolute inset-0 rounded-full bg-orange-100 dark:bg-slate-800 animate-pulse-slow"></div>
                <!-- Middle ring -->
                <div class="absolute inset-4 rounded-full bg-orange-200/50 dark:bg-slate-700/50"></div>
                <!-- Inner circle with icon -->
                <div class="absolute inset-8 rounded-full bg-primary flex items-center justify-center shadow-lg">
                    <i class="fas fa-exclamation-triangle text-5xl text-white animate-bounce-slow"></i>
                </div>
            </div>
        </div>

        <!-- 404 Text -->
        <h1 class="text-9xl font-black text-primary tracking-tight">404</h1>
        
        <!-- Error Title -->
        <h2 class="mt-4 text-3xl font-bold text-slate-850 dark:text-white tracking-tight">
            Halaman Tidak Ditemukan
        </h2>
        
        <!-- Error Description -->
        <p class="mt-4 text-base text-slate-600 dark:text-slate-400">
            Maaf, halaman yang Anda tuju tidak dapat ditemukan atau telah dipindahkan. Pastikan alamat URL yang dimasukkan sudah benar.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="/" class="w-full sm:w-auto inline-flex items-center justify-center bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-full transition transform hover:scale-105 shadow-md hover:shadow-lg gap-2">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
            <a href="/informasi/kontak" class="w-full sm:w-auto inline-flex items-center justify-center bg-white dark:bg-slate-850 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 font-bold py-3 px-8 rounded-full transition transform hover:scale-105 hover:bg-slate-100 dark:hover:bg-slate-800 gap-2">
                <i class="fas fa-envelope"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
