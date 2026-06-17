@extends('layouts.app')
@section('title', 'Mitra Industri - SMK Muhammadiyah 1 Bantul')

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
    transform: translateY(-8px);
    box-shadow: 0 20px 30px -10px rgba(249, 115, 22, 0.3);
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
  <section class="relative h-[45vh] overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/mitra-hero/1920/600" alt="Mitra Industri SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">Mitra Industri</h1>
      <p class="text-lg md:text-2xl text-orange-200 font-medium">Sinergi Dunia Pendidikan dan Dunia Industri (DUDI) untuk Sukses Masa Depan Lulusan</p>
    </div>
  </section>

  <!-- Program Kerjasama Unggul -->
  <section class="py-16 bg-white dark:bg-slate-900 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <span class="inline-block bg-orange-100 dark:bg-orange-950 text-primary font-semibold text-sm px-4 py-1.5 rounded-full mb-3">Link & Match</span>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Program Kerja Sama Unggulan</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Kolaborasi nyata menjamin lulusan berkualitas tinggi dan tersalurkan dengan cepat</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Program 1: Pintar Bersama Daihatsu -->
        <div class="card-gradient rounded-2xl p-8 flex flex-col h-full">
          <div class="w-14 h-14 rounded-full bg-orange-100 dark:bg-orange-900/50 text-primary flex items-center justify-center mb-6 shadow-sm">
            <i class="fas fa-tools text-2xl"></i>
          </div>
          <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3">Pintar Bersama Daihatsu (PBD)</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify mb-4">
            Program sinkronisasi kurikulum budaya industri dengan standardisasi Daihatsu Motor. Siswa diajarkan etos kerja industri (5S/5R), perawatan kendaraan modern, didukung donasi mesin dan unit praktik dari industri untuk bengkel sekolah.
          </p>
        </div>

        <!-- Program 2: BKK Musaba Karya -->
        <div class="card-gradient rounded-2xl p-8 flex flex-col h-full">
          <div class="w-14 h-14 rounded-full bg-orange-100 dark:bg-orange-900/50 text-primary flex items-center justify-center mb-6 shadow-sm">
            <i class="fas fa-briefcase text-2xl"></i>
          </div>
          <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3">BKK Musaba Karya</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify mb-4">
            Bursa Kerja Khusus (BKK) sebagai unit resmi penyalur tenaga kerja lulusan. Menyelenggarakan info lowongan berkala, pelatihan kesiapan kerja, simulasi psikotes, hingga memfasilitasi rekrutmen langsung dari perusahaan mitra terkemuka di lingkungan sekolah.
          </p>
        </div>

        <!-- Program 3: Magang Internasional Jepang -->
        <div class="card-gradient rounded-2xl p-8 flex flex-col h-full">
          <div class="w-14 h-14 rounded-full bg-orange-100 dark:bg-orange-900/50 text-primary flex items-center justify-center mb-6 shadow-sm">
            <i class="fas fa-plane-departure text-2xl"></i>
          </div>
          <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3">Magang Kerja ke Jepang</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify mb-4">
            Kerja sama strategis dengan LPK terakreditasi nasional untuk memfasilitasi siswa berprestasi magang kerja di Jepang. Program mencakup pembekalan intensif bahasa Jepang, budaya, dan kesiapan fisik selama 6 bulan sebelum keberangkatan.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Daftar Mitra Logogrid -->
  <section class="py-16 bg-slate-50 dark:bg-slate-800/40 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <span class="inline-block bg-orange-100 dark:bg-orange-950 text-primary font-semibold text-sm px-4 py-1.5 rounded-full mb-3">Industrial Partners</span>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Daftar Partner Industri Aktif</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Bekerja sama erat dalam penyediaan prakerin (PKL), penyerapan tenaga kerja, dan transfer teknologi</p>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        @forelse($mitras as $mitra)
          <div class="bg-white dark:bg-slate-850 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-md flex items-center justify-center h-32 hover:shadow-lg transition-all duration-300 group">
            @if($mitra->link && $mitra->link !== '#')
              <a href="{{ $mitra->link }}" target="_blank" class="block w-full h-full flex items-center justify-center">
                <img src="{{ $mitra->logo_src }}" alt="{{ $mitra->nama }}" class="max-h-16 max-w-full object-contain grayscale group-hover:grayscale-0 transition duration-300">
              </a>
            @else
              <img src="{{ $mitra->logo_src }}" alt="{{ $mitra->nama }}" class="max-h-16 max-w-full object-contain grayscale group-hover:grayscale-0 transition duration-300">
            @endif
          </div>
        @empty
          <!-- Fallback default logos if mitras is empty in DB -->
          @php
            $defaultLogos = [
              ['src' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Logo_Telkom_Indonesia.svg', 'nama' => 'Telkom Indonesia'],
              ['src' => 'https://upload.wikimedia.org/wikipedia/commons/e/e4/Honda_logo.svg', 'nama' => 'Honda'],
              ['src' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_Garuda_Indonesia.svg', 'nama' => 'Garuda Indonesia'],
              ['src' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_PT_Astra_International_Tbk.svg', 'nama' => 'Astra International'],
              ['src' => 'https://upload.wikimedia.org/wikipedia/commons/6/69/Gojek_logo_2019.svg', 'nama' => 'Gojek'],
              ['src' => 'https://upload.wikimedia.org/wikipedia/commons/d/d4/Microsoft_logo.svg', 'nama' => 'Microsoft'],
            ];
          @endphp
          @foreach($defaultLogos as $logo)
            <div class="bg-white dark:bg-slate-850 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-md flex items-center justify-center h-32 hover:shadow-lg transition-all duration-300 group">
              <img src="{{ $logo['src'] }}" alt="{{ $logo['nama'] }}" class="max-h-16 max-w-full object-contain grayscale group-hover:grayscale-0 transition duration-300">
            </div>
          @endforeach
        @endforelse
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
