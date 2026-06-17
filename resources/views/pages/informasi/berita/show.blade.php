@extends('layouts.app')
@section('title', $berita->judul . ' - SMK Muhammadiyah 1 Bantul')

@section('style')
<style>
  html { scroll-behavior: smooth; }
  .fade-in-scroll {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
  }
  .fade-in-scroll.visible {
    opacity: 1;
    transform: translateY(0);
  }
  .article-content p {
    margin-bottom: 1.25rem;
    line-height: 1.8;
    text-align: justify;
  }
  .article-content p:last-child {
    margin-bottom: 0;
  }
</style>
@endsection

@section('content')
  <!-- Detail Artikel Section -->
  <section class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Back Navigation & Date -->
      <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <a href="/informasi/berita" class="inline-flex items-center text-primary font-semibold hover:underline">
          <i class="fas fa-arrow-left mr-2"></i> Kembali ke Semua Berita
        </a>
        <span class="text-slate-500 dark:text-slate-400 text-sm flex items-center gap-1.5">
          <i class="far fa-calendar-alt text-primary"></i> Dipublikasikan pada {{ $berita->tanggal->translatedFormat('d F Y') }}
        </span>
      </div>

      <!-- Main Layout -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: News Content (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
          <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 border border-slate-100 dark:border-slate-700 shadow-xl">
            <!-- Title -->
            <h1 class="text-2xl md:text-4xl font-bold text-slate-850 dark:text-white leading-tight mb-6">
              {{ $berita->judul }}
            </h1>

            <!-- Image Banner -->
            <div class="rounded-2xl overflow-hidden mb-8 shadow-md">
              <img src="{{ $berita->gambar_src }}" alt="{{ $berita->judul }}" class="w-full h-auto max-h-[500px] object-cover">
            </div>

            <!-- Content Body -->
            <div class="article-content text-slate-700 dark:text-slate-300 text-base md:text-lg leading-relaxed">
              {!! $berita->konten !!}
            </div>
          </div>
        </div>

        <!-- Right: Sidebar (1 col) -->
        <div class="space-y-6">
          
          <!-- Sidebar Search -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Cari Warta</h4>
            <form action="/informasi/berita" method="GET" class="flex">
              <input type="text" name="search" placeholder="Kata kunci..." 
                     class="w-full px-3 py-2 rounded-l-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent text-sm">
              <button type="submit" class="bg-primary hover:bg-secondary text-white px-4 rounded-r-xl transition flex items-center justify-center">
                <i class="fas fa-search text-sm"></i>
              </button>
            </form>
          </div>

          <!-- Sidebar: Berita Lainnya -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Berita Lainnya</h4>
            <div class="space-y-4">
              @forelse($lainnya as $item)
                <div class="flex items-start gap-3 pb-3 border-b border-slate-100 dark:border-slate-700 last:border-b-0 last:pb-0">
                  <img src="{{ $item->gambar_src }}" alt="{{ $item->judul }}" class="w-16 h-16 rounded-lg object-cover bg-slate-100 dark:bg-slate-900 flex-shrink-0">
                  <div class="flex-grow min-w-0">
                    <span class="text-[10px] text-orange-600 dark:text-orange-400 font-semibold block uppercase">
                      {{ $item->tanggal->translatedFormat('d F Y') }}
                    </span>
                    <h5 class="font-bold text-sm text-slate-850 dark:text-white line-clamp-2 hover:text-primary transition">
                      <a href="/informasi/berita/{{ $item->slug }}">{{ $item->judul }}</a>
                    </h5>
                  </div>
                </div>
              @empty
                <p class="text-slate-500 text-sm">Tidak ada berita lain saat ini.</p>
              @endforelse
            </div>
          </div>

        </div>

      </div>

    </div>
  </section>
@endsection
