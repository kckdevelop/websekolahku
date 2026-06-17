@extends('layouts.app')
@section('title', 'Sejarah Singkat - SMK Muhammadiyah 1 Bantul')

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
  .timeline-line::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 4px;
    background: linear-gradient(to bottom, #f97316 0%, #ea580c 100%);
    transform: translateX(-50%);
  }
  @media (max-width: 768px) {
    .timeline-line::before {
      left: 20px;
    }
  }
</style>
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="relative h-[45vh] overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/sejarah-hero/1920/600" alt="Sejarah SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">Sejarah Singkat</h1>
      <p class="text-lg md:text-2xl text-orange-200 font-medium">Melintasi Waktu, Mengukir Prestasi, Mencetak Generasi Mandiri</p>
    </div>
  </section>

  <!-- Pengenalan Sejarah -->
  <section class="py-16 bg-white dark:bg-slate-900 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-gradient-to-br from-orange-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 rounded-3xl border border-orange-100 dark:border-slate-700 shadow-xl">
        <h2 class="text-2xl md:text-3xl font-bold text-primary mb-6">Sekilas Perjalanan Musaba</h2>
        <p class="text-slate-700 dark:text-slate-300 leading-relaxed mb-4 text-justify">
          SMK Muhammadiyah 1 Bantul, yang akrab dikenal dengan sebutan <strong>MUSABA</strong>, merupakan salah satu sekolah menengah kejuruan swasta terkemuka di Kabupaten Bantul, Daerah Istimewa Yogyakarta. Sejak awal pendiriannya, sekolah ini berkomitmen untuk memberikan pendidikan kejuruan yang bermutu tinggi yang diintegrasikan dengan nilai-nilai luhur keagamaan.
        </p>
        <p class="text-slate-700 dark:text-slate-300 leading-relaxed text-justify">
          Melalui perjalanan panjang puluhan tahun, MUSABA terus beradaptasi dengan perkembangan teknologi, kurikulum nasional, hingga dinamika dunia usaha dan industri (DUDI), guna melahirkan generasi yang profesional, inovatif, dan berakhlak mulia.
        </p>
      </div>
    </div>
  </section>

  <!-- Timeline Section -->
  <section class="py-16 bg-slate-50 dark:bg-slate-800/30 overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 fade-in-scroll">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Linimasa Perkembangan Sekolah</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Momen-momen penting perjalanan SMK Muhammadiyah 1 Bantul</p>
      </div>

      <div class="relative timeline-line">
        <!-- Event 1 (1970) -->
        <div class="relative flex flex-col md:flex-row items-center justify-between mb-12 fade-in-scroll">
          <div class="w-full md:w-[45%] order-2 md:order-1">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300">
              <span class="inline-block bg-primary text-white font-bold text-sm px-4 py-1.5 rounded-full mb-3 shadow-md shadow-primary/20">1 Januari 1970</span>
              <h3 class="font-bold text-xl mb-2 text-slate-800 dark:text-white">Awal Pendirian (STM Muhammadiyah Bantul)</h3>
              <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
                Didirikan dengan nama awal STM Muhammadiyah Bantul atas prakarsa Bapak Mursidi bersama rekan-rekan pendidik dan tokoh Muhammadiyah setempat. Langkah awal ini diambil demi menjawab kebutuhan mendesak akan pendidikan teknologi dan industri bagi generasi muda Bantul.
              </p>
            </div>
          </div>
          <!-- Dot -->
          <div class="absolute left-5 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-primary border-4 border-white dark:border-slate-850 shadow-md z-10 flex items-center justify-center text-white order-1 md:order-2">
            <i class="fas fa-seedling text-xs"></i>
          </div>
          <div class="w-full md:w-[45%] order-3"></div>
        </div>

        <!-- Event 2 (1995) -->
        <div class="relative flex flex-col md:flex-row items-center justify-between mb-12 fade-in-scroll">
          <div class="w-full md:w-[45%]"></div>
          <!-- Dot -->
          <div class="absolute left-5 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-orange-600 border-4 border-white dark:border-slate-850 shadow-md z-10 flex items-center justify-center text-white">
            <i class="fas fa-sync text-xs"></i>
          </div>
          <div class="w-full md:w-[45%]">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300">
              <span class="inline-block bg-orange-600 text-white font-bold text-sm px-4 py-1.5 rounded-full mb-3 shadow-md shadow-orange-600/20">Tahun 1995</span>
              <h3 class="font-bold text-xl mb-2 text-slate-800 dark:text-white">Transformasi Menjadi SMK</h3>
              <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
                Sejalan dengan kebijakan penyeragaman penamaan sekolah menengah kejuruan oleh pemerintah, nama sekolah secara resmi bertransformasi dari STM Muhammadiyah Bantul menjadi <strong>SMK Muhammadiyah 1 Bantul</strong>. Pembaharuan ini juga diikuti dengan peningkatan kualitas kurikulum dan perluasan fasilitas laboratorium sekolah.
              </p>
            </div>
          </div>
        </div>

        <!-- Event 3 (2010) -->
        <div class="relative flex flex-col md:flex-row items-center justify-between mb-12 fade-in-scroll">
          <div class="w-full md:w-[45%] order-2 md:order-1">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300">
              <span class="inline-block bg-orange-700 text-white font-bold text-sm px-4 py-1.5 rounded-full mb-3 shadow-md shadow-orange-700/20">Tahun 2010</span>
              <h3 class="font-bold text-xl mb-2 text-slate-800 dark:text-white">Pengembangan Kompetensi & Akreditasi</h3>
              <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
                Sekolah mulai memperluas sayap dengan menambah pilihan jurusan baru yang bersesuaian dengan tren global, salah satunya jurusan Rekayasa Perangkat Lunak (RPL). Upaya pembenahan mutu yang terus-menerus membuahkan hasil dengan diraihnya predikat Akreditasi A (Unggul) dari Badan Akreditasi Nasional.
              </p>
            </div>
          </div>
          <!-- Dot -->
          <div class="absolute left-5 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-orange-700 border-4 border-white dark:border-slate-850 shadow-md z-10 flex items-center justify-center text-white order-1 md:order-2">
            <i class="fas fa-chart-line text-xs"></i>
          </div>
          <div class="w-full md:w-[45%] order-3"></div>
        </div>

        <!-- Event 4 (2020) -->
        <div class="relative flex flex-col md:flex-row items-center justify-between mb-12 fade-in-scroll">
          <div class="w-full md:w-[45%]"></div>
          <!-- Dot -->
          <div class="absolute left-5 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-orange-850 border-4 border-white dark:border-slate-850 shadow-md z-10 flex items-center justify-center text-white">
            <i class="fas fa-award text-xs"></i>
          </div>
          <div class="w-full md:w-[45%]">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300">
              <span class="inline-block bg-orange-800 text-white font-bold text-sm px-4 py-1.5 rounded-full mb-3 shadow-md shadow-orange-800/20">Tahun 2020</span>
              <h3 class="font-bold text-xl mb-2 text-slate-800 dark:text-white">Revitalisasi Budaya Industri</h3>
              <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
                Sekolah melakukan terobosan revitalisasi fasilitas praktik dengan menerapkan program Budaya Industri standar Astra dan Daihatsu. Selain itu, Bursa Kerja Khusus (BKK) Musaba Karya semakin diperkuat, berhasil membina kerjasama LPK untuk meloloskan puluhan lulusan magang kerja ke Jepang secara berkala.
              </p>
            </div>
          </div>
        </div>

        <!-- Event 5 (Masa Kini) -->
        <div class="relative flex flex-col md:flex-row items-center justify-between fade-in-scroll">
          <div class="w-full md:w-[45%] order-2 md:order-1">
            <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300">
              <span class="inline-block bg-green-600 text-white font-bold text-sm px-4 py-1.5 rounded-full mb-3 shadow-md shadow-green-600/20">Masa Kini</span>
              <h3 class="font-bold text-xl mb-2 text-slate-800 dark:text-white">Sekolah Unggul Merdeka Belajar</h3>
              <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
                Kini, SMK Muhammadiyah 1 Bantul kokoh berdiri sebagai sekolah vokasi rujukan di DIY yang konsisten menerapkan Kurikulum Merdeka. Dengan dukungan sarana digital yang modern (seperti LMS dan E-Library), sekolah mendidik ribuan siswa agar siap berkompetisi global di era revolusi industri 4.0 dan masyarakat 5.0.
              </p>
            </div>
          </div>
          <!-- Dot -->
          <div class="absolute left-5 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-green-600 border-4 border-white dark:border-slate-850 shadow-md z-10 flex items-center justify-center text-white order-1 md:order-2">
            <i class="fas fa-graduation-cap text-xs"></i>
          </div>
          <div class="w-full md:w-[45%] order-3"></div>
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
