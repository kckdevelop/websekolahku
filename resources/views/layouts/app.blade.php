<!DOCTYPE html>
<html lang="id" class="">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') - SMK Muhammadiyah 1 Bantul</title>
  <!-- Google Fonts: Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- Font Awesome untuk ikon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            dark: '#1a1a1a',
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          animation: {
            'bounce-slow': 'bounce 2s infinite',
            'pulse-slow': 'pulse 3s infinite',
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

    /* Custom styles untuk navbar */
    .navbar-gradient {
      background: linear-gradient(to right, #f97316, #ea580c);
    }

    .navbar-shadow {
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .nav-link {
      position: relative;
      transition: all 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background-color: white;
      transition: width 0.3s ease;
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .dropdown-menu {
      transform-origin: top;
      animation: dropdownOpen 0.3s ease;
    }

    @keyframes dropdownOpen {
      from {
        opacity: 0;
        transform: scaleY(0);
      }
      to {
        opacity: 1;
        transform: scaleY(1);
      }
    }

    .logo-container {
      animation: pulse-slow 3s infinite;
    }

    .mobile-menu-enter {
      animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        max-height: 0;
      }
      to {
        opacity: 1;
        max-height: 500px;
      }
    }

    .theme-toggle {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 50;
      background: linear-gradient(to right, #f97316, #ea580c);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
    }

    .theme-toggle:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .navbar-scrolled {
      background: linear-gradient(to right, #ea580c, #f97316);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .mobile-submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }

    .mobile-submenu.open {
      max-height: 500px;
    }
  </style>
  @yield('style')
</head>

<body class="font-sans bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200">

  <!-- Navbar -->
<nav id="navbar" class="navbar-gradient navbar-shadow text-white sticky top-0 z-50 transition-all duration-300">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <a href="/" class="flex items-center space-x-2 group">
        <div class="logo-container bg-white w-10 h-10 rounded-full flex items-center justify-center shadow-lg overflow-hidden transition-transform group-hover:scale-105">
          <img src="{{ asset('storage/logomusaba.png') }}" alt="Logo" class="w-8 h-8 object-contain">
        </div>
        <span class="font-bold text-lg hidden sm:block group-hover:text-white/90 transition-colors">SMK MUSABA</span>
      </a>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center space-x-6">
        <a href="/" class="nav-link hover:text-white/90 font-medium flex items-center">
          <i class="fas fa-home mr-2"></i> Home
        </a>

        <!-- Profil Dropdown -->
        <div class="relative group">
          <button class="nav-link flex items-center hover:text-white/90 font-medium focus:outline-none">
            <i class="fas fa-school mr-2"></i> Profil
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-md shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
            <a href="/profil/identitas" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-id-card mr-2 text-primary"></i> Identitas Sekolah
            </a>
            <a href="/profil/visi-misi" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-bullseye mr-2 text-primary"></i> Visi dan Misi
            </a>
            <a href="/profil/sejarah" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-history mr-2 text-primary"></i> Sejarah Singkat
            </a>
            <a href="/profil/fasilitas" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-building mr-2 text-primary"></i> Fasilitas
            </a>
            <a href="/profil/mitra" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-handshake mr-2 text-primary"></i> Mitra Industri
            </a>
          </div>
        </div>

        <!-- Program Keahlian Dropdown -->
        <div class="relative group">
          <button class="nav-link flex items-center hover:text-white/90 font-medium focus:outline-none">
            <i class="fas fa-book mr-2"></i> Program Keahlian
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-md shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
            <a href="{{ route('jurusan.show', 'tkr') }}" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-car mr-2 text-primary"></i> Teknik Kendaraan Ringan (TKR)
            </a>
            <a href="{{ route('jurusan.show', 'tbsm') }}" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-motorcycle mr-2 text-primary"></i> Teknik Bisnis Sepeda Motor (TBSM)
            </a>
            <a href="{{ route('jurusan.show', 'tpm') }}" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-cogs mr-2 text-primary"></i> Teknik Pemesinan (TPM)
            </a>
            <a href="{{ route('jurusan.show', 'tav') }}" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-tv mr-2 text-primary"></i> Teknik Audio Video (TAV)
            </a>
            <a href="{{ route('jurusan.show', 'rpl') }}" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-laptop-code mr-2 text-primary"></i> Rekayasa Perangkat Lunak (RPL)
            </a>
          </div>
        </div>

        <!-- Layanan Dropdown -->
        <div class="relative group">
          <button class="nav-link flex items-center hover:text-white/90 font-medium focus:outline-none">
            <i class="fas fa-concierge-bell mr-2"></i> Layanan
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-md shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
            <a href="#perpustakaan" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-book-open mr-2 text-primary"></i> Perpustakaan
            </a>
            <a href="#pkl" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-briefcase mr-2 text-primary"></i> PKL
            </a>
            <a href="#lms" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i> LMS
            </a>
            <a href="#bkk" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-user-tie mr-2 text-primary"></i> BKK
            </a>
          </div>
        </div>

        <!-- Galeri Dropdown -->
        <div class="relative group">
          <button class="nav-link flex items-center hover:text-white/90 font-medium focus:outline-none">
            <i class="fas fa-images mr-2"></i> Galeri
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-md shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
            <a href="/galeri/galerifoto" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-camera mr-2 text-primary"></i> Foto
            </a>
            <a href="/galeri/galerivideo" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-video mr-2 text-primary"></i> Video
            </a>
          </div>
        </div>

        <!-- Informasi Dropdown -->
        <div class="relative group">
          <button class="nav-link flex items-center hover:text-white/90 font-medium focus:outline-none">
            <i class="fas fa-info-circle mr-2"></i> Informasi
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div class="dropdown-menu absolute left-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-md shadow-xl py-2 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
            <a href="/informasi/spmb" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-clipboard-list mr-2 text-primary"></i> SPMB
            </a>
            <a href="/informasi/berita" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-newspaper mr-2 text-primary"></i> Berita
            </a>
            <a href="/informasi/prestasi" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-trophy mr-2 text-primary"></i> Prestasi
            </a>
            <a href="/informasi/kontak" class="block px-4 py-2 text-slate-800 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700 transition-colors duration-200">
              <i class="fas fa-phone-alt mr-2 text-primary"></i> Hubungi Kami
            </a>
          </div>
        </div>

        <!-- Tombol Daftar Sekarang -->
        <a href="{{ route('spmb.daftar') }}" class="bg-white text-primary dark:bg-slate-800 dark:text-white px-4 py-2 rounded-full font-bold hover:bg-orange-50 dark:hover:bg-slate-700 transition-all duration-300 shadow-md hover:shadow-lg flex items-center space-x-1 hover:scale-105 transform">
          <i class="fas fa-user-plus mr-1"></i>
          <span>Daftar</span>
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none p-2 rounded-md hover:bg-white/20 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden bg-secondary pb-4">
    <div class="px-4 pt-2 space-y-2">
      <!-- Tombol Daftar Sekarang (Mobile) -->
      <div class="pb-3 border-b border-white/20">
        <a href="{{ route('spmb.daftar') }}" class="block text-center bg-white text-primary py-2.5 rounded-full font-bold hover:bg-orange-50 transition-colors shadow-md">
          <i class="fas fa-user-plus mr-2"></i> Daftar
        </a>
      </div>
      
      <a href="#home" class="block py-2 text-white hover:text-white/90 transition-colors duration-200">
        <i class="fas fa-home mr-2"></i> Home
      </a>

      <!-- Mobile Profil -->
      <div>
        <button id="mobile-profil-btn" class="flex justify-between items-center w-full py-2 text-white hover:text-white/90 text-left font-medium transition-colors duration-200">
          <span><i class="fas fa-school mr-2"></i> Profil</span>
          <svg id="mobile-profil-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobile-profil" class="mobile-submenu pl-4 mt-1 space-y-2">
          <a href="/profil/identitas" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-id-card mr-2"></i> Identitas Sekolah
          </a>
          <a href="/profil/visi-misi" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-bullseye mr-2"></i> Visi dan Misi
          </a>
          <a href="/profil/sejarah" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-history mr-2"></i> Sejarah Singkat
          </a>
          <a href="/profil/fasilitas" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-building mr-2"></i> Fasilitas
          </a>
          <a href="/profil/mitra" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-handshake mr-2"></i> Mitra Industri
          </a>
        </div>
      </div>

      <!-- Mobile Program Keahlian -->
      <div>
        <button id="mobile-program-btn" class="flex justify-between items-center w-full py-2 text-white hover:text-white/90 text-left font-medium transition-colors duration-200">
          <span><i class="fas fa-book mr-2"></i> Program Keahlian</span>
          <svg id="mobile-program-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobile-program" class="mobile-submenu pl-4 mt-1 space-y-2">
          <a href="{{ route('jurusan.show', 'tkr') }}" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-car mr-2"></i> TKR
          </a>
          <a href="{{ route('jurusan.show', 'tbsm') }}" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-motorcycle mr-2"></i> TBSM
          </a>
          <a href="{{ route('jurusan.show', 'tpm') }}" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-cogs mr-2"></i> TPM
          </a>
          <a href="{{ route('jurusan.show', 'tav') }}" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-tv mr-2"></i> TAV
          </a>
          <a href="{{ route('jurusan.show', 'rpl') }}" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-laptop-code mr-2"></i> RPL
          </a>
        </div>
      </div>

      <!-- Mobile Layanan -->
      <div>
        <button id="mobile-layanan-btn" class="flex justify-between items-center w-full py-2 text-white hover:text-white/90 text-left font-medium transition-colors duration-200">
          <span><i class="fas fa-concierge-bell mr-2"></i> Layanan</span>
          <svg id="mobile-layanan-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobile-layanan" class="mobile-submenu pl-4 mt-1 space-y-2">
          <a href="#perpustakaan" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-book-open mr-2"></i> Perpustakaan
          </a>
          <a href="#pkl" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-briefcase mr-2"></i> PKL
          </a>
          <a href="#lms" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-chalkboard-teacher mr-2"></i> LMS
          </a>
          <a href="#bkk" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-user-tie mr-2"></i> BKK
          </a>
        </div>
      </div>

      <!-- Mobile Galeri -->
      <div>
        <button id="mobile-galeri-btn" class="flex justify-between items-center w-full py-2 text-white hover:text-white/90 text-left font-medium transition-colors duration-200">
          <span><i class="fas fa-images mr-2"></i> Galeri</span>
          <svg id="mobile-galeri-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobile-galeri" class="mobile-submenu pl-4 mt-1 space-y-2">
          <a href="/galerifoto" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-camera mr-2"></i> Foto
          </a>
          <a href="/galerivideo" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-video mr-2"></i> Video
          </a>
        </div>
      </div>

      <!-- Mobile Informasi -->
      <div>
        <button id="mobile-informasi-btn" class="flex justify-between items-center w-full py-2 text-white hover:text-white/90 text-left font-medium transition-colors duration-200">
          <span><i class="fas fa-info-circle mr-2"></i> Informasi</span>
          <svg id="mobile-informasi-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobile-informasi" class="mobile-submenu pl-4 mt-1 space-y-2">
          <a href="/informasi/spmb" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-clipboard-list mr-2"></i> SPMB
          </a>
          <a href="/informasi/berita" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-newspaper mr-2"></i> Berita
          </a>
          <a href="/informasi/prestasi" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-trophy mr-2"></i> Prestasi
          </a>
          <a href="/informasi/kontak" class="block py-2 text-white/90 hover:text-white transition-colors duration-200">
            <i class="fas fa-phone-alt mr-2"></i> Hubungi Kami
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

  @yield('content')

  <!-- Footer -->
  <footer class="bg-slate-800 text-white py-10 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-bold mb-4">SMK Muhammadiyah 1 Bantul</h3>
          <p class="text-slate-300">Jl. Parangtritis Km. 11, Bantul, Yogyakarta</p>
        </div>
        <div>
          <h4 class="font-semibold mb-3">Menu</h4>
          <ul class="space-y-2 text-slate-300">
            <li><a href="#profil" class="hover:text-primary">Profil</a></li>
            <li><a href="#program" class="hover:text-primary">Program Keahlian</a></li>
            <li><a href="#layanan" class="hover:text-primary">Layanan</a></li>
            <li><a href="#galeri" class="hover:text-primary">Galeri</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-3">Layanan</h4>
          <ul class="space-y-2 text-slate-300">
            <li><a href="#" class="hover:text-primary">Perpustakaan Digital</a></li>
            <li><a href="#" class="hover:text-primary">Sistem PKL Online</a></li>
            <li><a href="#" class="hover:text-primary">LMS SMK</a></li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold mb-3">Kontak</h4>
          <p class="text-slate-300">📞 (0274) 123456</p>
          <p class="text-slate-300">✉️ info@smkmuh1bantul.sch.id</p>
        </div>
      </div>
      <div class="border-t border-slate-700 mt-8 pt-6 text-center text-slate-400">
        <p>© 2025 SMK Muhammadiyah 1 Bantul. Dikembangkan oleh:</p>
        <div class="flex justify-center space-x-4 mt-2">
          <span>Tim IT MUSABA</span>
        </div>
      </div>
    </div>
  </footer>

  <!-- Lightbox / Image Preview Modal -->
  <div id="image-preview-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/90 backdrop-blur-md transition-opacity duration-300 opacity-0">
    <!-- Close Button (Top Right) -->
    <button id="close-preview-modal" class="absolute top-6 right-6 text-white/80 hover:text-white text-3xl md:text-4xl transition duration-200 focus:outline-none z-50 p-2" aria-label="Close preview">
      <i class="fas fa-times"></i>
    </button>

    <!-- Navigation Buttons -->
    <button id="prev-preview-image" class="absolute left-4 md:left-8 text-white/60 hover:text-white text-4xl md:text-5xl transition duration-200 focus:outline-none z-50 p-3 select-none" aria-label="Previous image">
      <i class="fas fa-chevron-left"></i>
    </button>
    <button id="next-preview-image" class="absolute right-4 md:right-8 text-white/60 hover:text-white text-4xl md:text-5xl transition duration-200 focus:outline-none z-50 p-3 select-none" aria-label="Next image">
      <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Modal Content -->
    <div class="max-w-5xl max-h-[85vh] w-full px-4 flex flex-col items-center justify-center relative">
      <div class="relative overflow-hidden rounded-xl border border-white/10 shadow-2xl bg-black/40 max-w-full">
        <img id="preview-modal-img" src="" alt="" class="max-w-full max-h-[70vh] object-contain transition-all duration-300 transform scale-95 opacity-0">
      </div>
      <p id="preview-modal-desc" class="mt-4 text-white text-center text-base md:text-lg font-medium max-w-2xl px-4 py-2 bg-black/50 backdrop-blur-sm rounded-full border border-white/5 shadow-lg"></p>
    </div>
  </div>

  <!-- Fixed Toggle Button -->
  <button id="theme-toggle-btn" class="theme-toggle" aria-label="Toggle dark mode">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="theme-icon">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>
  </button>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  @yield('script')

  <script>
    // === Mobile Menu Toggle ===
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton?.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      if (!mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('mobile-menu-enter');
      }
    });

    // === Mobile Submenu Toggle ===
    const mobileProfilBtn = document.getElementById('mobile-profil-btn');
    const mobileProfil = document.getElementById('mobile-profil');
    const mobileProfilIcon = document.getElementById('mobile-profil-icon');

    mobileProfilBtn?.addEventListener('click', () => {
      mobileProfil.classList.toggle('open');
      mobileProfilIcon.classList.toggle('rotate-180');
    });

    const mobileProgramBtn = document.getElementById('mobile-program-btn');
    const mobileProgram = document.getElementById('mobile-program');
    const mobileProgramIcon = document.getElementById('mobile-program-icon');

    mobileProgramBtn?.addEventListener('click', () => {
      mobileProgram.classList.toggle('open');
      mobileProgramIcon.classList.toggle('rotate-180');
    });

    const mobileLayananBtn = document.getElementById('mobile-layanan-btn');
    const mobileLayanan = document.getElementById('mobile-layanan');
    const mobileLayananIcon = document.getElementById('mobile-layanan-icon');

    mobileLayananBtn?.addEventListener('click', () => {
      mobileLayanan.classList.toggle('open');
      mobileLayananIcon.classList.toggle('rotate-180');
    });

    const mobileGaleriBtn = document.getElementById('mobile-galeri-btn');
    const mobileGaleri = document.getElementById('mobile-galeri');
    const mobileGaleriIcon = document.getElementById('mobile-galeri-icon');

    mobileGaleriBtn?.addEventListener('click', () => {
      mobileGaleri.classList.toggle('open');
      mobileGaleriIcon.classList.toggle('rotate-180');
    });

    const mobileInformasiBtn = document.getElementById('mobile-informasi-btn');
    const mobileInformasi = document.getElementById('mobile-informasi');
    const mobileInformasiIcon = document.getElementById('mobile-informasi-icon');

    mobileInformasiBtn?.addEventListener('click', () => {
      mobileInformasi.classList.toggle('open');
      mobileInformasiIcon.classList.toggle('rotate-180');
    });

    // === Navbar Scroll Effect ===
    window.addEventListener('scroll', () => {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('navbar-scrolled');
      } else {
        navbar.classList.remove('navbar-scrolled');
      }
    });

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

    // === Scroll Animation ===
    {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, {
        threshold: 0.1
      });

      document.querySelectorAll('.fade-in-scroll').forEach(el => observer.observe(el));
    }

    // === Image Preview Modal / Lightbox ===
    {
      const modal = document.getElementById('image-preview-modal');
      const modalImg = document.getElementById('preview-modal-img');
      const modalDesc = document.getElementById('preview-modal-desc');
      const closeBtn = document.getElementById('close-preview-modal');
      const prevBtn = document.getElementById('prev-preview-image');
      const nextBtn = document.getElementById('next-preview-image');
      
      let currentIndex = -1;
      let galleryImages = [];

      function updateModalContent() {
        if (currentIndex < 0 || currentIndex >= galleryImages.length) return;
        const currentImg = galleryImages[currentIndex];
        
        // Start animation fade-out
        modalImg.classList.remove('scale-100', 'opacity-100');
        modalImg.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
          modalImg.src = currentImg.src;
          modalImg.alt = currentImg.alt || 'Gambar Kegiatan';
          modalDesc.textContent = currentImg.getAttribute('data-desc') || currentImg.alt || '';
          
          // Animate fade-in
          modalImg.classList.remove('scale-95', 'opacity-0');
          modalImg.classList.add('scale-100', 'opacity-100');
        }, 150);
      }

      function openModal(index, images) {
        galleryImages = images;
        currentIndex = index;
        updateModalContent();
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Trigger opacity transition
        setTimeout(() => {
          modal.classList.remove('opacity-0');
          modal.classList.add('opacity-100');
        }, 10);
        
        document.body.classList.add('overflow-hidden');
      }

      function closeModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        
        // Hide after transition
        setTimeout(() => {
          modal.classList.remove('flex');
          modal.classList.add('hidden');
        }, 300);
        
        document.body.classList.remove('overflow-hidden');
      }

      function showNext() {
        if (galleryImages.length <= 1) return;
        currentIndex = (currentIndex + 1) % galleryImages.length;
        updateModalContent();
      }

      function showPrev() {
        if (galleryImages.length <= 1) return;
        currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        updateModalContent();
      }

      // Delegate click event to all previewable images
      document.addEventListener('click', (e) => {
        const target = e.target.closest('.activity-preview-img');
        if (!target) return;
        
        // Collect all previewable images in the same section / gallery context or overall page
        const images = Array.from(document.querySelectorAll('.activity-preview-img'));
        const index = images.indexOf(target);
        
        if (index !== -1) {
          openModal(index, images);
        }
      });

      closeBtn?.addEventListener('click', closeModal);
      modal?.addEventListener('click', (e) => {
        if (e.target === modal || e.target.id === 'image-preview-modal') {
          closeModal();
        }
      });

      prevBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        showPrev();
      });

      nextBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        showNext();
      });

      document.addEventListener('keydown', (e) => {
        if (modal && !modal.classList.contains('hidden')) {
          if (e.key === 'Escape') closeModal();
          if (e.key === 'ArrowRight') showNext();
          if (e.key === 'ArrowLeft') showPrev();
        }
      });
    }
  </script>

</body>
</html>