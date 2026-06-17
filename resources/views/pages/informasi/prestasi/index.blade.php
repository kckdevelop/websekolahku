@extends('layouts.app')
@section('title', 'Prestasi Siswa - SMK Muhammadiyah 1 Bantul')

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
    <img src="https://picsum.photos/seed/prestasi-hero/1920/600" alt="Prestasi SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-5xl font-bold mb-2 tracking-tight">Prestasi Siswa</h1>
      <p class="text-md md:text-xl text-orange-200 font-medium">Bukti Nyata Dedikasi, Kerja Keras, dan Kualitas Pendidikan MUSABA</p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="py-12 bg-white dark:bg-slate-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Category Filter Bar -->
      <div class="mb-10 flex flex-wrap items-center justify-center gap-3 fade-in-scroll">
        <a href="/informasi/prestasi" 
           class="px-5 py-2.5 rounded-full text-sm font-semibold transition border {{ !$kategori ? 'bg-primary text-white border-primary shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-350 border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700' }}">
          Semua Kategori
        </a>
        @foreach($kategoriList as $cat)
          <a href="/informasi/prestasi?kategori={{ urlencode($cat) }}" 
             class="px-5 py-2.5 rounded-full text-sm font-semibold transition border {{ $kategori === $cat ? 'bg-primary text-white border-primary shadow-lg shadow-primary/20' : 'bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-350 border-slate-200 dark:border-slate-700 hover:bg-orange-50 dark:hover:bg-slate-700' }}">
            {{ $cat }}
          </a>
        @endforeach
      </div>

      <!-- Prestasi Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12 fade-in-scroll">
        @forelse($prestasis as $prestasi)
          <div class="card-gradient rounded-3xl p-6 text-center shadow-lg hover:shadow-xl transition-all duration-300 flex flex-col justify-between h-full">
            <div>
              <!-- Image Area -->
              <div class="flex justify-center mb-6">
                <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-primary/20 shadow-md">
                  <img src="{{ $prestasi->foto_src }}" alt="{{ $prestasi->peraih }}" class="w-full h-full object-cover">
                </div>
              </div>
              
              <!-- Badges -->
              <div class="flex items-center justify-center gap-2 mb-3">
                <span class="inline-block bg-orange-100 dark:bg-orange-950 text-primary font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                  {{ $prestasi->kategori }}
                </span>
                <span class="inline-block bg-slate-100 dark:bg-slate-850 text-slate-600 dark:text-slate-400 font-semibold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider">
                  Tingkat {{ $prestasi->tingkat }}
                </span>
              </div>

              <!-- Title & Recipient -->
              <h3 class="font-bold text-lg text-slate-850 dark:text-white mb-2 leading-snug">
                {{ $prestasi->judul }}
              </h3>
              <p class="text-sm text-primary font-semibold mb-3">
                Peraih: {{ $prestasi->peraih }}
              </p>
              
              <!-- Description -->
              <p class="text-slate-600 dark:text-slate-350 text-sm leading-relaxed mb-4 text-justify">
                {{ $prestasi->deskripsi }}
              </p>
            </div>

            <!-- Footer Details -->
            <div class="pt-4 border-t border-orange-50 dark:border-slate-850 text-center text-xs text-slate-400 dark:text-slate-500">
              <i class="far fa-calendar-alt"></i> Diraih pada {{ $prestasi->tanggal->translatedFormat('F Y') }}
            </div>
          </div>
        @empty
          <div class="col-span-3 text-center py-16">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 mb-4 shadow-sm">
              <i class="fas fa-trophy text-2xl"></i>
            </div>
            <h3 class="font-bold text-lg text-slate-700 dark:text-slate-300">Belum Ada Prestasi</h3>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Kami tidak menemukan data prestasi untuk kategori ini saat ini.</p>
            @if($kategori)
              <a href="/informasi/prestasi" class="mt-4 inline-block bg-primary hover:bg-secondary text-white text-sm font-semibold px-6 py-2.5 rounded-full transition shadow-md">Tampilkan Semua Kategori</a>
            @endif
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="fade-in-scroll">
        {{ $prestasis->links() }}
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
