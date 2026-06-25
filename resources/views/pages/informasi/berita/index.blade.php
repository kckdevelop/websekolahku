@extends('layouts.app')
@section('title', 'Berita & Kegiatan - SMK Muhammadiyah 1 Bantul')

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
  .card-gradient {
    background: linear-gradient(135deg, #fff9f0 0%, #ffffff 100%);
    border: 2px solid #fde6d0;
    box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.15);
    transition: all 0.3s ease;
  }
  .dark .card-gradient {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-color: #334155;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
  }
  .card-gradient:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 30px -10px rgba(249, 115, 22, 0.25);
    border-color: #f97316;
  }
  .dark .card-gradient:hover {
    box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.7);
    border-color: #f97316;
  }
</style>
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="relative h-[35vh] overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/berita-hero/1920/600" alt="Berita dan Kegiatan SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-5xl font-bold mb-2 tracking-tight">Berita & Kegiatan</h1>
      <p class="text-md md:text-xl text-orange-200 font-medium">Informasi Terbaru Mengenai Kegiatan, Prestasi, dan Agenda Sekolah</p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="py-12 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Search & Filter Bar -->
      <div class="mb-10 flex flex-col md:flex-row justify-between items-center gap-4 fade-in-scroll">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
          @if($search)
            Hasil Pencarian: "{{ $search }}"
          @else
            Warta Sekolah Terbaru
          @endif
        </h2>

        <!-- Search Form -->
        <form action="/informasi/berita" method="GET" class="w-full md:w-96 flex">
          <input type="text" name="search" value="{{ $search }}" placeholder="Cari berita..." 
                 class="w-full px-4 py-2.5 rounded-l-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
          <button type="submit" class="bg-primary hover:bg-secondary text-white px-6 rounded-r-xl transition flex items-center justify-center">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>

      <!-- Berita Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12 fade-in-scroll">
        @forelse($beritas as $berita)
          <div class="card-gradient rounded-2xl overflow-hidden shadow-lg flex flex-col h-full">
            <div class="h-52 relative overflow-hidden bg-slate-100 dark:bg-slate-850">
              <a href="/informasi/berita/{{ $berita->slug }}" class="block w-full h-full">
                <img src="{{ $berita->gambar_src }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
              </a>
            </div>
            <div class="p-6 flex-grow flex flex-col justify-between">
              <div>
                <span class="text-xs text-orange-600 dark:text-orange-400 font-semibold uppercase tracking-wider flex items-center gap-1.5 mb-2">
                  <i class="far fa-calendar-alt"></i> {{ $berita->tanggal->translatedFormat('d F Y') }}
                </span>
                <h3 class="font-bold text-lg text-slate-850 dark:text-white mb-3 line-clamp-2 hover:text-primary transition duration-200">
                  <a href="/informasi/berita/{{ $berita->slug }}">{{ $berita->judul }}</a>
                </h3>
                <p class="text-slate-600 dark:text-slate-350 text-sm leading-relaxed mb-4 line-clamp-3">
                  {{ $berita->ringkasan }}
                </p>
              </div>
              <div class="pt-4 border-t border-orange-50 dark:border-slate-800 flex justify-between items-center">
                <a href="/informasi/berita/{{ $berita->slug }}" class="text-primary font-bold text-sm hover:underline flex items-center gap-1">
                  Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                </a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-span-3 text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mb-4 shadow-sm">
              <i class="far fa-newspaper text-2xl"></i>
            </div>
            <h3 class="font-bold text-lg text-slate-700 dark:text-slate-300">Belum Ada Berita</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Kami tidak menemukan berita atau artikel yang sesuai dengan kueri Anda.</p>
            @if($search)
              <a href="/informasi/berita" class="mt-4 inline-block bg-primary hover:bg-secondary text-white text-sm font-semibold px-6 py-2.5 rounded-full transition shadow-md">Kembali ke Daftar Berita</a>
            @endif
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="fade-in-scroll">
        {{ $beritas->links() }}
      </div>

    </div>
  </section>
@endsection

@section('script')
<script>
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.1 });
  document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));
</script>
@endsection
