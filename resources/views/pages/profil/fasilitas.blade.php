@extends('layouts.app')
@section('title', 'Fasilitas - SMK Muhammadiyah 1 Bantul')

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
    <img src="https://picsum.photos/seed/fasilitas-hero/1920/600" alt="Fasilitas SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-tight">Fasilitas Sekolah</h1>
      <p class="text-lg md:text-2xl text-orange-200 font-medium">Sarana Prasarana Lengkap Standar Industri untuk Mendukung Pembelajaran Maksimal</p>
    </div>
  </section>

  <!-- Fasilitas Utama (Praktik Kejuruan) -->
  <section class="py-16 bg-white dark:bg-slate-900 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <span class="inline-block bg-orange-100 dark:bg-orange-950 text-primary font-semibold text-sm px-4 py-1.5 rounded-full mb-3">Pusat Belajar & Praktik</span>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Bengkel & Laboratorium Kejuruan</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Ruang praktik spesifik untuk mengasah skill teknis siap kerja</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Fasilitas 1: Bengkel Otomotif -->
        <div class="card-gradient rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-64 relative overflow-hidden">
            <img src="https://picsum.photos/seed/bengkel-oto/800/600" alt="Bengkel Otomotif Musaba" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            <div class="absolute bottom-4 left-4 bg-orange-600 text-white font-bold text-xs px-3 py-1 rounded-md">TKR & TBSM</div>
          </div>
          <div class="p-6 flex-grow">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3 flex items-center">
              <i class="fas fa-car-wrench mr-3 text-primary"></i> Bengkel Otomotif Terpadu
            </h3>
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
              Didesain dengan tata ruang dan sistem keselamatan standar industri bengkel modern (Astra dan Honda). Dilengkapi dengan car lift, engine scanner, simulator sistem kelistrikan mobil, serta peralatan servis sepeda motor injeksi terkini untuk menunjang kompetensi siswa TKR dan TBSM.
            </p>
          </div>
        </div>

        <!-- Fasilitas 2: Lab Komputer RPL -->
        <div class="card-gradient rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-64 relative overflow-hidden">
            <img src="https://picsum.photos/seed/lab-komputer/800/600" alt="Lab Komputer RPL Musaba" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            <div class="absolute bottom-4 left-4 bg-blue-600 text-white font-bold text-xs px-3 py-1 rounded-md">IT & RPL</div>
          </div>
          <div class="p-6 flex-grow">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3 flex items-center">
              <i class="fas fa-laptop-code mr-3 text-primary"></i> Laboratorium Komputer Modern
            </h3>
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
              Ruangan ber-AC yang nyaman dengan puluhan komputer berspesifikasi tinggi untuk pemrograman web, mobile app development, administrasi server, dan database. Koneksi internet fiber optic berkecepatan tinggi disediakan agar siswa lancar dalam melakukan coding dan riset online.
            </p>
          </div>
        </div>

        <!-- Fasilitas 3: Workshop Pemesinan -->
        <div class="card-gradient rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-64 relative overflow-hidden">
            <img src="https://picsum.photos/seed/bengkel-mesin/800/600" alt="Workshop Pemesinan Musaba" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            <div class="absolute bottom-4 left-4 bg-slate-700 text-white font-bold text-xs px-3 py-1 rounded-md">TPM</div>
          </div>
          <div class="p-6 flex-grow">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3 flex items-center">
              <i class="fas fa-cogs mr-3 text-primary"></i> Workshop Teknik Pemesinan
            </h3>
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
              Ruang praktik manufaktur yang dilengkapi dengan deretan mesin bubut konvensional, mesin frais (milling), mesin gerinda, alat pengelasan industri, hingga mesin CNC (Computer Numerical Control) canggih guna melatih siswa mengoperasikan alat produksi manufaktur berstandar tinggi.
            </p>
          </div>
        </div>

        <!-- Fasilitas 4: Lab Audio Video -->
        <div class="card-gradient rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-64 relative overflow-hidden">
            <img src="https://picsum.photos/seed/lab-tav/800/600" alt="Lab TAV Musaba" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            <div class="absolute bottom-4 left-4 bg-green-600 text-white font-bold text-xs px-3 py-1 rounded-md">TAV</div>
          </div>
          <div class="p-6 flex-grow">
            <h3 class="font-bold text-xl text-slate-800 dark:text-white mb-3 flex items-center">
              <i class="fas fa-tv mr-3 text-primary"></i> Lab Elektronika & Audio Video
            </h3>
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed text-justify">
              Menyediakan meja kerja lengkap dengan peralatan solder, osiloskop, generator fungsi, dan kit mikrokontroler (Arduino/Raspberry Pi) untuk memfasilitasi pembuatan layout PCB, perakitan perangkat audio-video, serta pemrograman mikroelektronika bagi siswa TAV.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Fasilitas Umum -->
  <section class="py-16 bg-slate-50 dark:bg-slate-800/40 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <span class="inline-block bg-orange-100 dark:bg-orange-950 text-primary font-semibold text-sm px-4 py-1.5 rounded-full mb-3">Pendukung Pembelajaran</span>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Sarana & Prasarana Umum</h2>
        <p class="text-slate-500 dark:text-slate-400 mt-2">Menjamin kenyamanan beraktivitas, beribadah, dan berkreasi di lingkungan sekolah</p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Ruang Kelas AC -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-md overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
          <img src="https://picsum.photos/seed/kelas-ac/400/300" alt="Ruang Kelas AC" class="h-44 w-full object-cover">
          <div class="p-5 flex-grow">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2"><i class="fas fa-snowflake mr-2 text-primary"></i> Kelas Multimedia</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
              Ruang kelas bersih, ber-AC, dilengkapi LCD Proyektor interaktif dan papan tulis modern untuk mempermudah penjelasan visual guru.
            </p>
          </div>
        </div>

        <!-- Perpustakaan Digital -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-md overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
          <img src="https://picsum.photos/seed/perpus/400/300" alt="Perpustakaan Digital" class="h-44 w-full object-cover">
          <div class="p-5 flex-grow">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2"><i class="fas fa-book-reader mr-2 text-primary"></i> E-Library (Perpustakaan)</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
              Selain buku cetak, perpustakaan menyediakan akses komputer untuk membaca e-book, koleksi video pembelajaran, dan e-journal ilmiah.
            </p>
          </div>
        </div>

        <!-- Masjid Al-Manar -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-md overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
          <img src="https://picsum.photos/seed/masjid/400/300" alt="Masjid Al Manar" class="h-44 w-full object-cover">
          <div class="p-5 flex-grow">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2"><i class="fas fa-mosque mr-2 text-primary"></i> Masjid Al-Manar</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
              Masjid representatif sebagai pusat ibadah shalat berjamaah, kajian keislaman ortom, serta pembinaan akhlak mulia siswa.
            </p>
          </div>
        </div>

        <!-- Lapangan Olahraga -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-md overflow-hidden hover:shadow-lg transition duration-300 flex flex-col">
          <img src="https://picsum.photos/seed/lapangan/400/300" alt="Lapangan Olahraga" class="h-44 w-full object-cover">
          <div class="p-5 flex-grow">
            <h4 class="font-bold text-lg text-slate-800 dark:text-white mb-2"><i class="fas fa-running mr-2 text-primary"></i> Lapangan Serbaguna</h4>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
              Lapangan outdoor yang luas untuk futsal, basket, voli, latihan tapak suci, upacara bendera, hingga apel pagi bersama.
            </p>
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
