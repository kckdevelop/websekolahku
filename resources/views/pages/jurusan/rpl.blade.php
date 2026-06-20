@extends('layouts.app')
@section('title', $content->nama_jurusan)
@section('style')
    <style>
    html { scroll-behavior: smooth; }
    .fade-in-scroll { opacity: 0; transform: translateY(30px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
    .fade-in-scroll.visible { opacity: 1; transform: translateY(0); }
    .card-gradient { background: linear-gradient(135deg, #fff9f0 0%, #ffffff 100%); border: 2px solid #fde6d0; box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.15); }
    .dark .card-gradient { background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-color: #334155; }
    .gallery-img { transition: transform 0.3s ease; border-radius: 12px; }
    .gallery-img:hover { transform: scale(1.03); }
    .jurusan-tab { transition: all 0.2s ease; }
    .jurusan-tab.active { background: #f97316; color: white; }
  </style>
@endsection
@section('content')

  <!-- Hero Section -->
  <section class="relative h-[40vh] overflow-hidden">
    @auth
        <div class="absolute top-6 right-6 z-[999]">
            <a href="{{ route('admin.jurusan.edit', $content) }}" class="bg-primary hover:bg-secondary text-white text-sm font-semibold px-5 py-3 rounded-full shadow-lg flex items-center gap-2 transition transform hover:scale-105">
                <i class="fas fa-edit"></i> Edit Halaman Jurusan
            </a>
        </div>
    @endauth
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    @if($content->hero_gambar)
      <img src="{{ asset('storage/' . $content->hero_gambar) }}" alt="Jurusan {{ $content->nama_jurusan }}" class="w-full h-full object-cover">
    @else
      <img src="https://picsum.photos/seed/rpl-hero/1920/600" alt="Jurusan {{ $content->nama_jurusan }}" class="w-full h-full object-cover">
    @endif
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $content->hero_judul }}</h1>
      @if($content->hero_subjudul)
        <p class="text-lg md:text-xl">{{ $content->hero_subjudul }}</p>
      @endif
    </div>
  </section>

  <!-- Tab Jurusan Lainnya -->
  <section class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-16 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex overflow-x-auto gap-1 py-2 scrollbar-hide">
        <a href="/jurusan/tkr"  class="jurusan-tab whitespace-nowrap px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700 transition"><i class="fas fa-car mr-1"></i> TKR</a>
        <a href="/jurusan/tbsm" class="jurusan-tab whitespace-nowrap px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700 transition"><i class="fas fa-motorcycle mr-1"></i> TBSM</a>
        <a href="/jurusan/tpm"  class="jurusan-tab whitespace-nowrap px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700 transition"><i class="fas fa-cogs mr-1"></i> TPM</a>
        <a href="/jurusan/tav"  class="jurusan-tab whitespace-nowrap px-4 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-orange-50 dark:hover:bg-slate-700 transition"><i class="fas fa-tv mr-1"></i> TAV</a>
        <a href="/jurusan/rpl"  class="jurusan-tab active whitespace-nowrap px-4 py-2 rounded-lg text-sm font-medium transition"><i class="fas fa-laptop-code mr-1"></i> RPL</a>
      </div>
    </div>
  </section>

  <!-- Profil Jurusan -->
  <section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div>
          <h2 class="text-2xl font-bold text-primary mb-4">Tentang Jurusan {{ $content->nama_jurusan }}</h2>
          <div class="text-slate-700 dark:text-slate-300 space-y-4 mb-6">
            <p class="leading-relaxed">{{ $content->deskripsi_1 }}</p>
            @if($content->deskripsi_2)
              <p class="leading-relaxed">{{ $content->deskripsi_2 }}</p>
            @endif
          </div>
          @if(is_array($content->poin_unggulan) && count($content->poin_unggulan) > 0)
            <ul class="list-disc pl-5 space-y-2 text-slate-700 dark:text-slate-300">
              @foreach($content->poin_unggulan as $point)
                <li>{{ $point }}</li>
              @endforeach
            </ul>
          @endif
        </div>
        <div class="grid grid-cols-2 gap-4">
          <img src="https://picsum.photos/seed/rpl1/300/200" alt="Praktikum RPL 1" class="gallery-img w-full h-40 object-cover shadow-md activity-preview-img cursor-pointer">
          <img src="https://picsum.photos/seed/rpl2/300/200" alt="Praktikum RPL 2" class="gallery-img w-full h-40 object-cover shadow-md activity-preview-img cursor-pointer">
          <img src="https://picsum.photos/seed/rpl3/300/200" alt="Praktikum RPL 3" class="gallery-img w-full h-40 object-cover shadow-md activity-preview-img cursor-pointer">
          <img src="https://picsum.photos/seed/rpl4/300/200" alt="Praktikum RPL 4" class="gallery-img w-full h-40 object-cover shadow-md activity-preview-img cursor-pointer">
        </div>
      </div>
    </div>
  </section>

  <!-- Galeri Foto -->
  <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-primary mb-10">Galeri Kegiatan {{ $content->nama_jurusan }}</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($content->foto_kegiatan ?? [] as $foto)
          <div class="card-gradient rounded-xl overflow-hidden shadow-md">
            @if(!empty($foto['gambar']))
              <img src="{{ Str::startsWith($foto['gambar'], 'http') ? $foto['gambar'] : asset('storage/' . $foto['gambar']) }}" alt="{{ $foto['deskripsi'] ?? '' }}" data-desc="{{ $foto['deskripsi'] ?? '' }}" class="w-full h-48 object-cover cursor-pointer hover:scale-105 transition-transform duration-300 activity-preview-img">
            @else
              <img src="https://picsum.photos/seed/kegiatan/400/300" alt="{{ $foto['deskripsi'] ?? '' }}" data-desc="{{ $foto['deskripsi'] ?? '' }}" class="w-full h-48 object-cover cursor-pointer hover:scale-105 transition-transform duration-300 activity-preview-img">
            @endif
            <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2 pb-3">{{ $foto['deskripsi'] ?? '' }}</p>
          </div>
        @empty
          <div class="col-span-full py-12 text-center text-slate-400">
            <i class="fas fa-images text-4xl mb-3 block"></i>
            <p class="text-sm">Belum ada foto kegiatan.</p>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-12 bg-gradient-to-r from-primary to-secondary text-white fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 text-center">
      <h2 class="text-2xl md:text-3xl font-bold mb-4">Tertarik Masuk Jurusan {{ $content->nama_jurusan }}?</h2>
      <p class="mb-6 text-lg opacity-90">Daftar sekarang dan wujudkan karier impianmu bersama kami!</p>
      <a href="{{ route('spmb.daftar') }}" class="inline-block bg-white text-primary font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-slate-100 transition-all duration-300">
        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
      </a>
    </div>
  </section>

@endsection
@section('script')
<script>
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));
</script>
@endsection
