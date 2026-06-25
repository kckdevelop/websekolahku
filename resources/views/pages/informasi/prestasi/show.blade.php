@extends('layouts.app')

@section('title', $prestasi->judul . ' - SMK Muhammadiyah 1 Bantul')

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
  }
  .card-gradient:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 30px -10px rgba(249, 115, 22, 0.25);
    border-color: #f97316;
  }
  .dark .card-gradient:hover {
    border-color: #f97316;
  }
  .trophy-glow {
    filter: drop-shadow(0 0 16px rgba(249, 115, 22, 0.5));
  }
  .badge-tier-kecamatan  { background:#e0f2fe; color:#0369a1; }
  .badge-tier-kabupaten  { background:#dcfce7; color:#15803d; }
  .badge-tier-provinsi   { background:#fef9c3; color:#b45309; }
  .badge-tier-nasional   { background:#ffe4e6; color:#be123c; }
  .badge-tier-internasional { background:#f3e8ff; color:#7c3aed; }
</style>
@endsection

@section('content')
  <!-- Detail Prestasi Section -->
  <section class="py-12 bg-slate-50 dark:bg-slate-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Breadcrumb & Back Nav -->
      <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <a href="/informasi/prestasi" class="inline-flex items-center text-primary font-semibold hover:underline">
          <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Prestasi
        </a>
        <span class="text-slate-500 dark:text-slate-400 text-sm flex items-center gap-1.5">
          <i class="far fa-calendar-alt text-primary"></i> Diraih pada {{ $prestasi->tanggal->translatedFormat('d F Y') }}
        </span>
      </div>

      <!-- Main Layout -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Left: Main Content (2 cols) -->
        <div class="lg:col-span-2 space-y-6 fade-in-scroll">
          <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-10 border border-slate-100 dark:border-slate-700 shadow-xl text-center">

            <!-- Trophy Icon -->
            <div class="flex justify-center mb-6">
              <div class="relative">
                <div class="absolute inset-0 rounded-full bg-orange-100 dark:bg-orange-950/50 scale-110 blur-md"></div>
                <div class="relative w-40 h-40 rounded-full overflow-hidden border-4 border-white dark:border-slate-700 shadow-2xl ring-4 ring-primary/20">
                  <img src="{{ $prestasi->foto_src }}" alt="{{ $prestasi->peraih }}" class="w-full h-full object-cover">
                </div>
                <!-- Trophy Badge -->
                <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary rounded-full flex items-center justify-center shadow-lg trophy-glow">
                  <i class="fas fa-trophy text-white text-sm"></i>
                </div>
              </div>
            </div>

            <!-- Badges -->
            <div class="flex flex-wrap items-center justify-center gap-2 mb-4">
              <span class="inline-block bg-orange-100 dark:bg-orange-950 text-primary font-bold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider">
                {{ $prestasi->kategori }}
              </span>
              @php
                $tierClass = match(strtolower($prestasi->tingkat)) {
                  'kecamatan'      => 'badge-tier-kecamatan',
                  'kabupaten'      => 'badge-tier-kabupaten',
                  'provinsi'       => 'badge-tier-provinsi',
                  'nasional'       => 'badge-tier-nasional',
                  'internasional'  => 'badge-tier-internasional',
                  default          => 'bg-slate-100 text-slate-600',
                };
                $tierIcon = match(strtolower($prestasi->tingkat)) {
                  'kecamatan'      => 'fas fa-map-marker-alt',
                  'kabupaten'      => 'fas fa-map',
                  'provinsi'       => 'fas fa-globe-asia',
                  'nasional'       => 'fas fa-flag',
                  'internasional'  => 'fas fa-globe',
                  default          => 'fas fa-star',
                };
              @endphp
              <span class="inline-flex items-center gap-1.5 font-bold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider {{ $tierClass }}">
                <i class="{{ $tierIcon }}"></i> Tingkat {{ $prestasi->tingkat }}
              </span>
            </div>

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-bold text-slate-850 dark:text-white leading-tight mb-3">
              {{ $prestasi->judul }}
            </h1>

            <!-- Recipient -->
            <p class="text-base text-primary font-semibold mb-8">
              <i class="fas fa-user-graduate mr-1.5"></i> {{ $prestasi->peraih }}
            </p>

            <!-- Divider -->
            <div class="border-t border-orange-100 dark:border-slate-700 mb-8"></div>

            <!-- Description -->
            <div class="text-slate-700 dark:text-slate-300 text-base leading-relaxed text-left">
              <h2 class="font-bold text-slate-850 dark:text-white text-lg mb-3 flex items-center gap-2">
                <i class="fas fa-align-left text-primary"></i> Deskripsi Prestasi
              </h2>
              <p class="text-justify leading-loose">{{ $prestasi->deskripsi }}</p>
            </div>

          </div>

          <!-- Info Card -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg fade-in-scroll">
            <h3 class="font-bold text-slate-850 dark:text-white text-base mb-4 flex items-center gap-2">
              <i class="fas fa-info-circle text-primary"></i> Detail Informasi
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div class="text-center p-4 bg-orange-50 dark:bg-slate-850 rounded-xl">
                <i class="fas fa-tag text-primary text-xl mb-2 block"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-medium">Kategori</p>
                <p class="font-bold text-slate-850 dark:text-white text-sm mt-1">{{ $prestasi->kategori }}</p>
              </div>
              <div class="text-center p-4 bg-orange-50 dark:bg-slate-850 rounded-xl">
                <i class="fas fa-flag text-primary text-xl mb-2 block"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-medium">Tingkat</p>
                <p class="font-bold text-slate-850 dark:text-white text-sm mt-1">{{ $prestasi->tingkat }}</p>
              </div>
              <div class="text-center p-4 bg-orange-50 dark:bg-slate-850 rounded-xl">
                <i class="fas fa-user-graduate text-primary text-xl mb-2 block"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-medium">Peraih</p>
                <p class="font-bold text-slate-850 dark:text-white text-sm mt-1">{{ $prestasi->peraih }}</p>
              </div>
              <div class="text-center p-4 bg-orange-50 dark:bg-slate-850 rounded-xl">
                <i class="far fa-calendar-alt text-primary text-xl mb-2 block"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider font-medium">Tanggal</p>
                <p class="font-bold text-slate-850 dark:text-white text-sm mt-1">{{ $prestasi->tanggal->translatedFormat('M Y') }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Sidebar (1 col) -->
        <div class="space-y-6">

          <!-- Sidebar: Share / Back -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg fade-in-scroll">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2">
              <i class="fas fa-trophy text-primary"></i> Prestasi Sekolah
            </h4>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
              SMK Muhammadiyah 1 Bantul terus berprestasi di berbagai bidang, mulai dari tingkat kecamatan hingga internasional.
            </p>
            <a href="/informasi/prestasi" class="block w-full text-center bg-primary hover:bg-secondary text-white font-semibold py-2.5 px-4 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30 text-sm">
              <i class="fas fa-list mr-1.5"></i> Lihat Semua Prestasi
            </a>
          </div>

          <!-- Sidebar: Prestasi Lainnya -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg fade-in-scroll">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Prestasi Lainnya</h4>
            <div class="space-y-3">
              @forelse($lainnya as $item)
                <a href="/informasi/prestasi/{{ $item->id }}" class="flex items-start gap-3 pb-3 border-b border-slate-100 dark:border-slate-700 last:border-b-0 last:pb-0 group">
                  <img src="{{ $item->foto_src }}" alt="{{ $item->peraih }}" class="w-14 h-14 rounded-xl object-cover bg-slate-100 dark:bg-slate-900 flex-shrink-0 border border-slate-200 dark:border-slate-700">
                  <div class="flex-grow min-w-0">
                    <span class="text-[10px] text-primary font-bold block uppercase tracking-wider mb-0.5">{{ $item->kategori }}</span>
                    <h5 class="font-semibold text-sm text-slate-850 dark:text-white line-clamp-2 group-hover:text-primary transition-colors">
                      {{ $item->judul }}
                    </h5>
                    <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->peraih }}</p>
                  </div>
                </a>
              @empty
                <p class="text-slate-500 text-sm">Tidak ada prestasi lain saat ini.</p>
              @endforelse
            </div>
          </div>

          <!-- Filter by Category -->
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 shadow-lg fade-in-scroll">
            <h4 class="font-bold text-base text-slate-800 dark:text-white mb-3">
              <i class="fas fa-filter text-primary mr-1.5"></i> Lihat Per Kategori
            </h4>
            <div class="flex flex-wrap gap-2">
              @php
                $allKategori = \App\Models\Prestasi::distinct()->orderBy('kategori')->pluck('kategori');
              @endphp
              @foreach($allKategori as $cat)
                <a href="/informasi/prestasi?kategori={{ urlencode($cat) }}"
                   class="text-xs font-semibold px-3 py-1.5 rounded-full bg-orange-50 dark:bg-slate-850 text-primary border border-orange-100 dark:border-slate-700 hover:bg-primary hover:text-white hover:border-primary transition">
                  {{ $cat }}
                </a>
              @endforeach
            </div>
          </div>

        </div>

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
