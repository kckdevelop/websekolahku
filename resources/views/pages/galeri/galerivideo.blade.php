@extends('layouts.app')
@section('title','Galeri Video')
@section('style')
<script>
    // Inisialisasi tema: default light
    if (localStorage.theme === 'dark') {
      document.documentElement.classList.add('dark');
    } else {
      document.documentElement.classList.remove('dark');
    }

    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#f97316',
            secondary: '#ea580c',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    /* Smooth scroll */
    html {
      scroll-behavior: smooth;
    }

    /* Animasi scroll masuk */
    .fade-in-scroll {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }

    .fade-in-scroll.visible {
      opacity: 1;
      transform: translateY(0);
    }

    /* Card styling */
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

    /* Video Gallery styling */
    .video-item {
      overflow: hidden;
      position: relative;
      cursor: pointer;
      transition: all 0.3s ease;
      border-radius: 12px;
    }

    .video-item:hover .video-overlay {
      opacity: 1;
    }

    .video-item:hover img {
      transform: scale(1.05);
    }

    .video-overlay {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.7);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .play-button {
      width: 70px;
      height: 70px;
      background: rgba(249, 115, 22, 0.9);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }

    .play-button:hover {
      background: #f97316;
      transform: scale(1.1);
    }

    .play-button i {
      color: white;
      font-size: 24px;
      margin-left: 3px;
    }

    /* Video Modal styling */
    .video-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.95);
      z-index: 1000;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .video-modal.active {
      opacity: 1;
      visibility: visible;
    }

    .video-container {
      position: relative;
      max-width: 90%;
      max-height: 90vh;
      width: 900px;
      transform: scale(0.8);
      transition: transform 0.3s ease;
    }

    .video-modal.active .video-container {
      transform: scale(1);
    }

    .video-player {
      width: 100%;
      height: 500px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
      background: #000;
      position: relative;
    }

    .video-player iframe {
      width: 100%;
      height: 100%;
      border: none;
      border-radius: 12px;
    }

    .video-info {
      background: rgba(0, 0, 0, 0.8);
      padding: 20px;
      border-radius: 0 0 12px 12px;
      margin-top: -4px;
    }

    .video-title {
      color: white;
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .video-description {
      color: #e5e7eb;
      font-size: 16px;
      line-height: 1.5;
      margin-bottom: 12px;
    }

    .video-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: 12px;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .video-category {
      display: inline-block;
      background: #f97316;
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
    }

    .video-date {
      color: #9ca3af;
      font-size: 14px;
    }

    .video-stats {
      display: flex;
      gap: 20px;
      color: #9ca3af;
      font-size: 14px;
    }

    .video-stat {
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .modal-close {
      position: absolute;
      top: 20px;
      right: 40px;
      color: white;
      font-size: 30px;
      cursor: pointer;
      z-index: 1001;
      background: rgba(0, 0, 0, 0.5);
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease;
    }

    .modal-close:hover {
      background: rgba(0, 0, 0, 0.8);
    }

    .modal-nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      color: white;
      font-size: 30px;
      cursor: pointer;
      z-index: 1001;
      padding: 10px;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 50%;
      transition: background 0.3s ease;
    }

    .modal-nav:hover {
      background: rgba(0, 0, 0, 0.8);
    }

    .modal-prev {
      left: 20px;
    }

    .modal-next {
      right: 20px;
    }

    /* Filter button styling */
    .filter-btn {
      padding: 8px 16px;
      margin: 5px;
      border-radius: 20px;
      background: #f3f4f6;
      color: #4b5563;
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .dark .filter-btn {
      background: #374151;
      color: #d1d5db;
    }

    .filter-btn:hover {
      background: #e5e7eb;
    }

    .dark .filter-btn:hover {
      background: #4b5563;
    }

    .filter-btn.active {
      background: #f97316;
      color: white;
      border-color: #ea580c;
    }

    /* Video thumbnail styling */
    .video-thumbnail {
      position: relative;
      width: 100%;
      height: 200px;
      overflow: hidden;
    }

    .video-thumbnail img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }

    .video-duration {
      position: absolute;
      bottom: 8px;
      right: 8px;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
    }

    /* Fixed toggle button */
    #theme-toggle-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background-color: #f97316;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      cursor: pointer;
      transition: transform 0.2s, background-color 0.2s;
    }

    #theme-toggle-btn:hover {
      transform: scale(1.1);
      background-color: #ea580c;
    }

    /* Loading animation */
    .video-loading {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 20px;
      z-index: 10;
    }

    /* Error message */
    .video-error {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      text-align: center;
      z-index: 10;
    }

    /* Responsive video player */
    @media (max-width: 768px) {
      .video-player {
        height: 250px;
      }
      
      .video-container {
        width: 95%;
      }
    }

    @media (max-width: 640px) {
      .video-player {
        height: 200px;
      }
    }
  </style>

@endsection
@section('content')
  <!-- Hero Section -->
  <section class="relative h-[40vh] overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/video-hero/1920/600.jpg" alt="Galeri Video SMK Muhammadiyah 1 Bantul" class="w-full h-full object-cover">
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-4">Galeri Video</h1>
      <p class="text-lg md:text-xl">Dokumentasi video kegiatan, prestasi, dan profil SMK Muhammadiyah 1 Bantul</p>
    </div>
  </section>

  <!-- Filter Section -->
  <section class="py-8 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-wrap justify-center">
        <button class="filter-btn active" data-filter="all">Semua</button>
        <button class="filter-btn" data-filter="profil">Profil Sekolah</button>
        <button class="filter-btn" data-filter="kegiatan">Kegiatan</button>
        <button class="filter-btn" data-filter="prestasi">Prestasi</button>
        <button class="filter-btn" data-filter="pembelajaran">Pembelajaran</button>
        <button class="filter-btn" data-filter="ekstrakurikuler">Ekstrakurikuler</button>
      </div>
    </div>
  </section>

  <!-- Video Gallery Section -->
  <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="video-gallery">
        <!-- Video Item 1 - Using real working YouTube video -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="profil" 
             data-video-id="LXb3EKWsInQ"
             data-title="Profil SMK Muhammadiyah 1 Bantul"
             data-description="Video profil lengkap SMK Muhammadiyah 1 Bantul yang menampilkan fasilitas, program keahlian, dan berbagai kegiatan unggulan sekolah."
             data-date="15 Mei 2024"
             data-views="1.2K">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/LXb3EKWsInQ/hqdefault.jpg" alt="Profil SMK Muhammadiyah 1 Bantul">
            <span class="video-duration">5:42</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Profil SMK Muhammadiyah 1 Bantul</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>1.2K views</span>
              <span class="mx-2">•</span>
              <span>15 Mei 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 2 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="prestasi" 
             data-video-id="9bZkp7q19f0"
             data-title="Juara 1 Lomba Robotik Nasional 2024"
             data-description="Dokumentasi perjalanan tim robotik SMK Muhammadiyah 1 Bantul meraih juara 1 dalam kompetisi robotik tingkat nasional."
             data-date="10 Mei 2024"
             data-views="3.5K">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/9bZkp7q19f0/hqdefault.jpg" alt="Juara 1 Lomba Robotik">
            <span class="video-duration">8:15</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Juara 1 Lomba Robotik Nasional 2024</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>3.5K views</span>
              <span class="mx-2">•</span>
              <span>10 Mei 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 3 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="pembelajaran" 
             data-video-id="hT_nvWreIhg"
             data-title="Praktikum Bengkel TKR"
             data-description="Siswa jurusan TKR sedang melakukan praktikum perbaikan mesin di bengkel sekolah dengan bimbingan guru profesional."
             data-date="5 Mei 2024"
             data-views="856">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/hT_nvWreIhg/hqdefault.jpg" alt="Praktikum Bengkel TKR">
            <span class="video-duration">6:30</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Praktikum Bengkel TKR</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>856 views</span>
              <span class="mx-2">•</span>
              <span>5 Mei 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 4 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="kegiatan" 
             data-video-id="ScMzIvxBSi4"
             data-title="Peringatan Hari Pendidikan Nasional"
             data-description="Rangkaian kegiatan dalam memperingati Hari Pendidikan Nasional 2024 di SMK Muhammadiyah 1 Bantul."
             data-date="2 Mei 2024"
             data-views="1.8K">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg" alt="Hardiknas 2024">
            <span class="video-duration">4:20</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Peringatan Hari Pendidikan Nasional</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>1.8K views</span>
              <span class="mx-2">•</span>
              <span>2 Mei 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 5 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="ekstrakurikuler" 
             data-video-id="kJQP7kiw5Fk"
             data-title="Pentas Seni Ekstrakurikuler"
             data-description="Penampilan memukau dari berbagai ekstrakurikuler seni dalam acara pentas seni tahunan SMK Muhammadiyah 1 Bantul."
             data-date="25 April 2024"
             data-views="2.3K">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/kJQP7kiw5Fk/hqdefault.jpg" alt="Pentas Seni">
            <span class="video-duration">12:45</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Pentas Seni Ekstrakurikuler</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>2.3K views</span>
              <span class="mx-2">•</span>
              <span>25 April 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 6 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="pembelajaran" 
             data-video-id="PG08dXR642w"
             data-title="Coding Class Jurusan RPL"
             data-description="Siswa jurusan Rekayasa Perangkat Lunak sedang belajar pemrograman web dengan framework modern."
             data-date="20 April 2024"
             data-views="1.5K">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/YQHsXMglC9A/hqdefault.jpg" alt="Coding Class">
            <span class="video-duration">7:15</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Coding Class Jurusan RPL</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>1.5K views</span>
              <span class="mx-2">•</span>
              <span>20 April 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 7 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="kegiatan" 
             data-video-id="jNQXAC9IVRw"
             data-title="Wisuda Angkatan 2024"
             data-description="Prosesi wisuda dan pelepasan siswa angkatan 2024 SMK Muhammadiyah 1 Bantul."
             data-date="15 April 2024"
             data-views="4.2K">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/jNQXAC9IVRw/hqdefault.jpg" alt="Wisuda 2024">
            <span class="video-duration">15:30</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Wisuda Angkatan 2024</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>4.2K views</span>
              <span class="mx-2">•</span>
              <span>15 April 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>

        <!-- Video Item 8 -->
        <div class="video-item card-gradient rounded-lg overflow-hidden shadow-lg" 
             data-category="prestasi" 
             data-video-id="dQw4w9WgXcQ"
             data-title="Debat Bahasa Inggris Juara 2"
             data-description="Tim debat bahasa Inggris SMK Muhammadiyah 1 Bantul berhasil meraih juara 2 tingkat provinsi DIY."
             data-date="10 April 2024"
             data-views="980">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="Debat Competition">
            <span class="video-duration">9:45</span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-2 line-clamp-2">Debat Bahasa Inggris Juara 2</h3>
            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
              <i class="fas fa-eye mr-2"></i>
              <span>980 views</span>
              <span class="mx-2">•</span>
              <span>10 April 2024</span>
            </div>
          </div>
          <div class="video-overlay">
            <div class="play-button">
              <i class="fas fa-play"></i>
            </div>
            <p class="text-white text-center mt-3">Putar Video</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Video Modal -->
  <div class="video-modal" id="video-modal">
    <span class="modal-close">&times;</span>
    <div class="video-container">
      <div class="video-player" id="video-player">
        <div class="video-loading" id="video-loading">
          <i class="fas fa-spinner fa-spin"></i>
        </div>
      </div>
      <div class="video-info">
        <h3 class="video-title" id="video-title"></h3>
        <p class="video-description" id="video-description"></p>
        <div class="video-meta">
          <span class="video-category" id="video-category"></span>
          <span class="video-date" id="video-date"></span>
        </div>
        <div class="video-stats">
          <div class="video-stat">
            <i class="fas fa-eye"></i>
            <span id="video-views"></span>
          </div>
          <div class="video-stat">
            <i class="fas fa-thumbs-up"></i>
            <span>Like</span>
          </div>
          <div class="video-stat">
            <i class="fas fa-share"></i>
            <span>Share</span>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-nav modal-prev">
      <i class="fas fa-chevron-left"></i>
    </div>
    <div class="modal-nav modal-next">
      <i class="fas fa-chevron-right"></i>
    </div>
  </div>
@endsection

 
@section('script')
   <script>
    // Mobile Menu
    document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Mobile Dropdown
    const btn = document.getElementById('mobile-dropdown-btn');
    if (btn) {
      btn.addEventListener('click', () => {
        const dropdown = document.getElementById('mobile-dropdown');
        const icon = document.getElementById('mobile-dropdown-icon');
        const isHidden = dropdown.classList.contains('hidden');
        dropdown.classList.toggle('hidden', !isHidden);
        icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
      });
    }

    // Scroll Animation
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));

    // === Dark Mode Toggle ===
    const themeToggleBtn = document.getElementById('theme-toggle-btn');
    const themeIcon = document.getElementById('theme-icon');

    function updateThemeIcon() {
      if (document.documentElement.classList.contains('dark')) {
        themeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        `;
      } else {
        themeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        `;
      }
    }

    updateThemeIcon();

    themeToggleBtn?.addEventListener('click', () => {
      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
      }
      updateThemeIcon();
    });

    // Video Gallery Filter
    const filterButtons = document.querySelectorAll('.filter-btn');
    const videoItems = document.querySelectorAll('.video-item');

    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Filter video items
        const filter = button.getAttribute('data-filter');
        videoItems.forEach(item => {
          if (filter === 'all' || item.getAttribute('data-category') === filter) {
            item.style.display = 'block';
            // Re-trigger animation
            item.classList.remove('fade-in-scroll', 'visible');
            void item.offsetWidth; // Trigger reflow
            item.classList.add('fade-in-scroll');
            setTimeout(() => item.classList.add('visible'), 10);
          } else {
            item.style.display = 'none';
          }
        });
      });
    });

    // Video Modal
    const videoModal = document.getElementById('video-modal');
    const videoPlayer = document.getElementById('video-player');
    const videoTitle = document.getElementById('video-title');
    const videoDescription = document.getElementById('video-description');
    const videoCategory = document.getElementById('video-category');
    const videoDate = document.getElementById('video-date');
    const videoViews = document.getElementById('video-views');
    const videoLoading = document.getElementById('video-loading');
    const modalClose = document.querySelector('.modal-close');
    const modalPrev = document.querySelector('.modal-prev');
    const modalNext = document.querySelector('.modal-next');
    let currentVideoIndex = 0;
    const visibleVideos = [];
    let currentIframe = null;

    function getCategoryName(category) {
      const categoryNames = {
        'profil': 'Profil Sekolah',
        'kegiatan': 'Kegiatan',
        'prestasi': 'Prestasi',
        'pembelajaran': 'Pembelajaran',
        'ekstrakurikuler': 'Ekstrakurikuler'
      };
      return categoryNames[category] || category;
    }

    function updateVisibleVideos() {
      visibleVideos.length = 0;
      videoItems.forEach(item => {
        if (item.style.display !== 'none') {
          visibleVideos.push(item);
        }
      });
    }

    function loadVideo(videoId) {
      // Show loading
      videoLoading.style.display = 'block';
      
      // Remove existing iframe if any
      if (currentIframe) {
        currentIframe.remove();
        currentIframe = null;
      }
      
      // Clear player
      videoPlayer.innerHTML = '<div class="video-loading"><i class="fas fa-spinner fa-spin"></i></div>';
      
      // Create new iframe
      const iframe = document.createElement('iframe');
      iframe.width = '100%';
      iframe.height = '100%';
      iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1&showinfo=0`;
      iframe.frameBorder = '0';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.allowFullscreen = true;
      iframe.style.borderRadius = '12px';
      
      // Handle iframe load
      iframe.onload = function() {
        videoLoading.style.display = 'none';
        currentIframe = iframe;
      };
      
      // Handle iframe error
      iframe.onerror = function() {
        videoLoading.style.display = 'none';
        videoPlayer.innerHTML = `
          <div class="video-error">
            <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
            <p>Video tidak dapat dimuat</p>
            <button onclick="location.reload()" class="mt-4 px-4 py-2 bg-primary text-white rounded hover:bg-secondary">
              Coba Lagi
            </button>
          </div>
        `;
      };
      
      // Add iframe to player
      videoPlayer.appendChild(iframe);
      
      // Fallback timeout
      setTimeout(() => {
        if (videoLoading.style.display !== 'none') {
          videoLoading.style.display = 'none';
          if (!currentIframe) {
            videoPlayer.innerHTML = `
              <div class="video-error">
                <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                <p>Memuat video...</p>
                <p class="text-sm mt-2">Jika video tidak muncul, silakan refresh halaman</p>
              </div>
            `;
          }
        }
      }, 5000);
    }

    function openVideoModal(videoElement) {
      updateVisibleVideos();
      const videoId = videoElement.getAttribute('data-video-id');
      const title = videoElement.getAttribute('data-title');
      const description = videoElement.getAttribute('data-description');
      const category = videoElement.getAttribute('data-category');
      const date = videoElement.getAttribute('data-date');
      const views = videoElement.getAttribute('data-views');
      
      currentVideoIndex = visibleVideos.indexOf(videoElement);
      
      videoTitle.textContent = title;
      videoDescription.textContent = description;
      videoCategory.textContent = getCategoryName(category);
      videoDate.textContent = date;
      videoViews.textContent = views + ' views';
      
      loadVideo(videoId);
      
      videoModal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeVideoModal() {
      videoModal.classList.remove('active');
      document.body.style.overflow = 'auto';
      
      // Stop video by removing iframe
      if (currentIframe) {
        currentIframe.remove();
        currentIframe = null;
      }
      
      // Clear player
      videoPlayer.innerHTML = '<div class="video-loading"><i class="fas fa-spinner fa-spin"></i></div>';
    }

    function showPrevVideo() {
      if (visibleVideos.length === 0) return;
      
      currentVideoIndex = (currentVideoIndex - 1 + visibleVideos.length) % visibleVideos.length;
      const video = visibleVideos[currentVideoIndex];
      const videoId = video.getAttribute('data-video-id');
      const title = video.getAttribute('data-title');
      const description = video.getAttribute('data-description');
      const category = video.getAttribute('data-category');
      const date = video.getAttribute('data-date');
      
      videoTitle.textContent = title;
      videoDescription.textContent = description;
      videoCategory.textContent = getCategoryName(category);
      videoDate.textContent = date;
      videoViews.textContent = views + ' views';
      
      loadVideo(videoId);
    }

    function showNextVideo() {
      if (visibleVideos.length === 0) return;
      
      currentVideoIndex = (currentVideoIndex + 1) % visibleVideos.length;
      const video = visibleVideos[currentVideoIndex];
      const videoId = video.getAttribute('data-video-id');
      const title = video.getAttribute('data-title');
      const description = video.getAttribute('data-description');
      const category = video.getAttribute('data-category');
      const date = video.getAttribute('data-date');
      const views = video.getAttribute('data-views');
      
      videoTitle.textContent = title;
      videoDescription.textContent = description;
      videoCategory.textContent = getCategoryName(category);
      videoDate.textContent = date;
      videoViews.textContent = views + ' views';
      
      loadVideo(videoId);
    }

    // Add click event to video items
    videoItems.forEach(item => {
      item.addEventListener('click', () => openVideoModal(item));
    });

    // Close modal
    modalClose.addEventListener('click', closeVideoModal);
    videoModal.addEventListener('click', (e) => {
      if (e.target === videoModal) {
        closeVideoModal();
      }
    });

    // Navigation
    modalPrev.addEventListener('click', showPrevVideo);
    modalNext.addEventListener('click', showNextVideo);

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (videoModal.classList.contains('active')) {
        if (e.key === 'Escape') closeVideoModal();
        if (e.key === 'ArrowLeft') showPrevVideo();
        if (e.key === 'ArrowRight') showNextVideo();
      }
    });

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    videoModal.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    });

    videoModal.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    });

    function handleSwipe() {
      if (touchEndX < touchStartX - 50) showNextVideo();
      if (touchEndX > touchStartX + 50) showPrevVideo();
    }

    // Initial setup
    updateVisibleVideos();
  </script>
@endsection
