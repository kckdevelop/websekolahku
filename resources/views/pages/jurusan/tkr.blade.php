@extends('layouts.app')
@section('title', 'Teknik Kendaraan Ringan')
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
    }
    .dark .card-gradient {
      background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
      border-color: #334155;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }
    .gallery-img {
      transition: transform 0.3s ease;
      border-radius: 12px;
    }
    .gallery-img:hover {
      transform: scale(1.03);
    }
  </style>

@endsection
@section('content')
    <!-- Hero Section -->
  <section class="relative h-[40vh] overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/tkr-hero/1920/600" alt="Jurusan Teknik Kendaraan Ringan" class="w-full h-full object-cover">
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-2">Teknik Kendaraan Ringan (TKR)</h1>
      <p class="text-lg md:text-xl">Mencetak Teknisi Otomotif Profesional dan Siap Kerja</p>
    </div>
  </section>

  <!-- Profil Jurusan -->
  <section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div>
          <h2 class="text-2xl font-bold text-primary mb-4">Tentang Jurusan TKR</h2>
          <p class="mb-4">
            Program Keahlian Teknik Kendaraan Ringan (TKR) di SMK Muhammadiyah 1 Bantul dirancang untuk membekali siswa dengan kompetensi dalam perawatan, perbaikan, dan pemeliharaan kendaraan ringan seperti mobil dan minibus.
          </p>
          <p class="mb-4">
            Kurikulum kami mengacu pada standar industri otomotif nasional dan internasional, dengan praktik langsung di bengkel sekolah yang dilengkapi peralatan modern.
          </p>
          <ul class="list-disc pl-5 space-y-2 text-slate-700 dark:text-slate-300">
            <li>Praktik langsung di bengkel sekolah</li>
            <li>Kerja sama dengan bengkel mitra industri</li>
            <li>Sertifikasi kompetensi (BNSP, Astra, dll.)</li>
            <li>Penempatan kerja lulusan 98%</li>
          </ul>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <img src="https://picsum.photos/seed/tkr1/300/200" alt="Praktikum TKR 1" class="gallery-img w-full h-40 object-cover shadow-md">
          <img src="https://picsum.photos/seed/tkr2/300/200" alt="Praktikum TKR 2" class="gallery-img w-full h-40 object-cover shadow-md">
          <img src="https://picsum.photos/seed/tkr3/300/200" alt="Praktikum TKR 3" class="gallery-img w-full h-40 object-cover shadow-md">
          <img src="https://picsum.photos/seed/tkr4/300/200" alt="Praktikum TKR 4" class="gallery-img w-full h-40 object-cover shadow-md">
        </div>
      </div>
    </div>
  </section>

  <!-- Galeri Foto -->
<section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-center text-primary mb-10">Galeri Kegiatan TKR</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <!-- Item 1 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-a/400/300" alt="Perbaikan Mesin" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Perbaikan mesin mobil di bengkel sekolah</p>
      </div>
      <!-- Item 2 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-b/400/300" alt="Kalibrasi ECU" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Kalibrasi sistem ECU menggunakan alat modern</p>
      </div>
      <!-- Item 3 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-c/400/300" alt="Servis Berkala" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Servis berkala kendaraan ringan</p>
      </div>
      <!-- Item 4 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-d/400/300" alt="Kompetisi Otomotif" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Tim TKR dalam kompetisi otomotif tingkat DIY</p>
      </div>
      <!-- Item 5 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-e/400/300" alt="Pelatihan Mitra Industri" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Pelatihan teknis bersama mitra industri Astra</p>
      </div>
      <!-- Item 6 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-f/400/300" alt="Uji Kompetensi" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Uji kompetensi keahlian oleh asesor BNSP</p>
      </div>
      <!-- Item 7 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-g/400/300" alt="Bengkel Sekolah" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Bengkel praktik TKR yang lengkap dan representatif</p>
      </div>
      <!-- Item 8 -->
      <div class="card-gradient rounded-xl overflow-hidden shadow-md">
        <img src="https://picsum.photos/seed/tkr-h/400/300" alt="Siswa TKR" class="w-full h-48 object-cover">
        <p class="mt-2 text-center text-sm text-slate-700 dark:text-slate-300 px-2">Siswa TKR sedang praktik perawatan kendaraan</p>
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
