@extends('layouts.app')
@section('title', 'Visi & Misi - SMK Muhammadiyah 1 Bantul')

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
    transform: translateY(-5px);
    box-shadow: 0 15px 30px -10px rgba(249, 115, 22, 0.25);
    border-color: #f97316;
  }
  .text-shadow-premium {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
  }
</style>
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="relative h-[45vh] overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/visimisi-hero/1920/600" alt="Visi Misi SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight text-shadow-premium">Visi & Misi</h1>
      <p class="text-lg md:text-2xl text-orange-200 font-medium">Arah, Tujuan, dan Komitmen SMK Muhammadiyah 1 Bantul</p>
    </div>
  </section>

  <!-- Visi Section -->
  <section class="py-16 bg-white dark:bg-slate-900 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 dark:bg-orange-900/50 text-primary mb-6 shadow-md">
        <i class="fas fa-eye text-2xl"></i>
      </div>
      <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-6">Visi Utama</h2>
      <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden text-white">
        <!-- Background decorative circles -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        
        <p class="text-xl md:text-3xl font-semibold leading-relaxed italic">
          "Membentuk tamatan yang berakhlak mulia, berprestasi, mandiri, dan berdaya saing di tingkat lokal maupun nasional."
        </p>
      </div>
    </div>
  </section>

  <!-- Misi Section -->
  <section class="py-16 bg-slate-50 dark:bg-slate-800/40 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 dark:bg-orange-900/50 text-primary mb-4 shadow-md">
          <i class="fas fa-bullseye text-2xl"></i>
        </div>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Misi Sekolah</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Langkah strategis dalam mewujudkan visi pendidikan unggulan</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Misi 1 -->
        <div class="card-gradient rounded-2xl p-8 flex flex-col h-full">
          <div class="w-12 h-12 rounded-xl bg-orange-500 text-white flex items-center justify-center font-bold text-xl mb-6 shadow-md shadow-orange-500/20">
            1
          </div>
          <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-4">Religiusitas & Disiplin</h3>
          <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
            Menerapkan kedisiplinan dan kejujuran yang dilandasi ketaqwaan kepada Allah SWT melalui keterbukaan, kemitraan, dan pelayanan prima.
          </p>
        </div>

        <!-- Misi 2 -->
        <div class="card-gradient rounded-2xl p-8 flex flex-col h-full">
          <div class="w-12 h-12 rounded-xl bg-orange-600 text-white flex items-center justify-center font-bold text-xl mb-6 shadow-md shadow-orange-600/20">
            2
          </div>
          <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-4">Kualitas Pembelajaran</h3>
          <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
            Menyelenggarakan pendidikan dan latihan yang berkualitas dengan mengedepankan keunggulan untuk berprestasi di bidang akademik dan non-akademik.
          </p>
        </div>

        <!-- Misi 3 -->
        <div class="card-gradient rounded-2xl p-8 flex flex-col h-full">
          <div class="w-12 h-12 rounded-xl bg-orange-700 text-white flex items-center justify-center font-bold text-xl mb-6 shadow-md shadow-orange-700/20">
            3
          </div>
          <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-4">Budaya Industri & Mandiri</h3>
          <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
            Melaksanakan layanan sekolah yang mengacu pada sistem manajemen mutu dan penerapan budaya industri untuk membekali siswa dengan pengetahuan, keterampilan, dan kemandirian.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Nilai-Nilai Karakter (Islami & Budaya Industri) -->
  <section class="py-16 bg-white dark:bg-slate-900 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Nilai-Nilai Utama (Karakter Musaba)</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Pilar moral dan etos kerja yang dipegang teguh oleh seluruh civitas akademika</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Islami -->
        <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 text-center hover:shadow-lg transition duration-300">
          <div class="w-14 h-14 rounded-full bg-green-100 dark:bg-green-950 text-green-600 dark:text-green-400 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-mosque text-xl"></i>
          </div>
          <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2">Islami</h4>
          <p class="text-sm text-slate-600 dark:text-slate-400">Menjunjung tinggi nilai Al-Islam dan Kemuhammadiyahan dalam perilaku sehari-hari.</p>
        </div>

        <!-- Unggul -->
        <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 text-center hover:shadow-lg transition duration-300">
          <div class="w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-trophy text-xl"></i>
          </div>
          <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2">Unggul</h4>
          <p class="text-sm text-slate-600 dark:text-slate-400">Senantiasa berusaha meraih capaian terbaik dan kompetitif di segala aspek.</p>
        </div>

        <!-- Mandiri -->
        <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 text-center hover:shadow-lg transition duration-300">
          <div class="w-14 h-14 rounded-full bg-purple-100 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-user-astronaut text-xl"></i>
          </div>
          <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2">Mandiri</h4>
          <p class="text-sm text-slate-600 dark:text-slate-400">Mampu menyelesaikan tantangan dengan bekal keterampilan yang terlatih.</p>
        </div>

        <!-- Berbudaya Industri -->
        <div class="p-6 rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 text-center hover:shadow-lg transition duration-300">
          <div class="w-14 h-14 rounded-full bg-orange-100 dark:bg-orange-950 text-orange-600 dark:text-orange-400 flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-industry text-xl"></i>
          </div>
          <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2">Budaya Industri</h4>
          <p class="text-sm text-slate-600 dark:text-slate-400">Menerapkan etos kerja industri seperti 5R (Ringkas, Rapi, Resik, Rawat, Rajin).</p>
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
