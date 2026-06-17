@extends('layouts.app')
@section('title','Galeri Foto')
@section('style')
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

    /* Galeri styling */
    .gallery-item {
      overflow: hidden;
      position: relative;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
      opacity: 1;
    }

    .gallery-item:hover img {
      transform: scale(1.05);
    }

    .gallery-overlay {
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

    /* Lightbox styling */
    .lightbox {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.9);
      z-index: 1000;
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .lightbox.active {
      opacity: 1;
      visibility: visible;
    }

    .lightbox-content {
      max-width: 90%;
      max-height: 85vh;
      position: relative;
      transform: scale(0.8);
      transition: transform 0.3s ease;
      display: flex;
      flex-direction: column;
    }

    .lightbox.active .lightbox-content {
      transform: scale(1);
    }

    .lightbox-image-container {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .lightbox-image {
      max-width: 100%;
      max-height: 70vh;
      object-fit: contain;
      border-radius: 8px;
      transition: opacity 0.3s ease;
    }

    .lightbox-info {
      background: rgba(0, 0, 0, 0.8);
      padding: 20px;
      border-radius: 0 0 8px 8px;
      margin-top: -4px;
    }

    .lightbox-title {
      color: white;
      font-size: 22px;
      font-weight: bold;
      margin-bottom: 8px;
    }

    .lightbox-description {
      color: #e5e7eb;
      font-size: 16px;
      line-height: 1.5;
    }

    .lightbox-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .lightbox-category {
      display: inline-block;
      background: #f97316;
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
    }

    .lightbox-date {
      color: #9ca3af;
      font-size: 14px;
    }

    .lightbox-close {
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

    .lightbox-close:hover {
      background: rgba(0, 0, 0, 0.8);
    }

    .lightbox-nav {
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

    .lightbox-nav:hover {
      background: rgba(0, 0, 0, 0.8);
    }

    .lightbox-prev {
      left: 20px;
    }

    .lightbox-next {
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

    /* Loading animation for lightbox */
    .lightbox-loading {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 20px;
    }
  </style>
@endsection
@section('content')
  

  <!-- Hero Section -->
  <section class="relative h-[40vh] overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/gallery-hero/1920/600.jpg" alt="Galeri SMK Muhammadiyah 1 Bantul" class="w-full h-full object-cover">
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-4">Galeri</h1>
      <p class="text-lg md:text-xl">Dokumentasi kegiatan dan prestasi SMK Muhammadiyah 1 Bantul</p>
    </div>
  </section>

    <!-- Google Drive Folder Section -->
   <!-- Google Drive Folder Section -->
  <section class="py-16 bg-slate-100 dark:bg-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header & Toolbar -->
      <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 fade-in-scroll">
        
        <!-- Judul Section -->
        <div class="text-center md:text-left">
          <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $galeriFoto->judul }}</h2>
          <div class="w-24 h-1 bg-primary rounded-full md:mx-0 mx-auto"></div>
        </div>

        <!-- Tombol Fungsi -->
        <div class="flex items-center space-x-3">
          
          <!-- Toggle View (Grid / List) -->
          <div class="flex bg-white dark:bg-slate-700 rounded-lg p-1 shadow-sm border border-slate-200 dark:border-slate-600" role="group">
            <button id="btn-grid" class="px-4 py-2 rounded-md text-sm font-medium transition-all bg-primary text-white shadow-sm focus:outline-none">
              <i class="fas fa-th-large mr-1"></i> Grid
            </button>
            <button id="btn-list" class="px-4 py-2 rounded-md text-sm font-medium transition-all text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600 focus:outline-none">
              <i class="fas fa-list mr-1"></i> List
            </button>
          </div>

          <!-- Tombol Share -->
          <button id="btn-share" class="px-4 py-2 bg-slate-600 hover:bg-slate-700 dark:bg-slate-600 dark:hover:bg-slate-500 text-white rounded-lg text-sm font-medium transition-all shadow-sm focus:outline-none flex items-center">
            <i class="fas fa-share-alt mr-2"></i> Share
          </button>

        </div>
      </div>

      <!-- Iframe Container -->
      <div class="card-gradient rounded-2xl p-2 md:p-4 fade-in-scroll overflow-hidden">
        <div class="relative w-full h-[60vh] md:h-[70vh] rounded-xl overflow-hidden bg-slate-200 dark:bg-slate-700">
          
          <iframe 
            id="gdrive-frame"
            src="https://drive.google.com/embeddedfolderview?id={{ $galeriFoto->folder_id }}#grid" 
            width="100%" 
            height="100%" 
            frameborder="0"
            class="absolute inset-0 w-full h-full border-0"
            allowfullscreen
          >
            Browser Anda tidak mendukung iframe.
          </iframe>
        </div>
      </div>

      <!-- Info Tambahan -->
      <div class="text-center mt-6 fade-in-scroll">
        <p class="text-sm text-slate-500 dark:text-slate-400">
          <i class="fas fa-info-circle mr-1"></i> 
          Pastikan akses folder Google Drive diatur ke "Siapa saja yang memiliki link" agar dapat ditampilkan.
        </p>
      </div>

    </div>
  </section>

  <!-- Keterangan Fitur (Seperti Gambar) -->
  <section class="py-12 bg-slate-50 dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Card 1: Dokumentasi Lengkap -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 text-center transform hover:-translate-y-2 transition-all duration-300 fade-in-scroll border border-slate-100 dark:border-slate-700">
          <div class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-camera text-2xl text-primary"></i>
          </div>
          <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Dokumentasi Lengkap</h3>
          <p class="text-slate-600 dark:text-slate-300">Berbagai kegiatan sekolah tersimpan dengan rapi</p>
        </div>

        <!-- Card 2: Mudah Diakses -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 text-center transform hover:-translate-y-2 transition-all duration-300 fade-in-scroll border border-slate-100 dark:border-slate-700">
          <div class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-folder-open text-2xl text-primary"></i>
          </div>
          <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Mudah Diakses</h3>
          <p class="text-slate-600 dark:text-slate-300">Dapat diakses kapan saja dan dimana saja</p>
        </div>

        <!-- Card 3: Selalu Diperbarui -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8 text-center transform hover:-translate-y-2 transition-all duration-300 fade-in-scroll border border-slate-100 dark:border-slate-700">
          <div class="w-16 h-16 mx-auto bg-orange-100 dark:bg-orange-900/30 rounded-full flex items-center justify-center mb-6">
            <i class="fas fa-clock text-2xl text-primary"></i>
          </div>
          <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Selalu Diperbarui</h3>
          <p class="text-slate-600 dark:text-slate-300">Foto kegiatan terbaru ditambahkan berkala</p>
        </div>

      </div>
    </div>
  </section>

  <!-- Lightbox -->
  <div class="lightbox" id="lightbox">
    <span class="lightbox-close">&times;</span>
    <div class="lightbox-content">
      <div class="lightbox-image-container">
        <img src="" alt="" class="lightbox-image" id="lightbox-image">
        <div class="lightbox-loading" id="lightbox-loading" style="display: none;">
          <i class="fas fa-spinner fa-spin"></i>
        </div>
      </div>
      <div class="lightbox-info">
        <h3 class="lightbox-title" id="lightbox-title"></h3>
        <p class="lightbox-description" id="lightbox-description"></p>
        <div class="lightbox-meta">
          <span class="lightbox-category" id="lightbox-category"></span>
          <span class="lightbox-date" id="lightbox-date"></span>
        </div>
      </div>
    </div>
    <div class="lightbox-nav lightbox-prev">
      <i class="fas fa-chevron-left"></i>
    </div>
    <div class="lightbox-nav lightbox-next">
      <i class="fas fa-chevron-right"></i>
    </div>
  </div>

@endsection

 
@section('script')
    <script>

      //google drive
          // === Google Drive Custom Controls ===
    const folderId = '{{ $galeriFoto->folder_id }}';
    const iframe = document.getElementById('gdrive-frame');
    const btnGrid = document.getElementById('btn-grid');
    const btnList = document.getElementById('btn-list');
    const btnShare = document.getElementById('btn-share');

    // Function to set active button style
    function setActiveView(activeBtn, inactiveBtn) {
      activeBtn.classList.add('bg-primary', 'text-white', 'shadow-sm');
      activeBtn.classList.remove('text-slate-600', 'dark:text-slate-300', 'hover:bg-slate-100', 'dark:hover:bg-slate-600');
      
      inactiveBtn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
      inactiveBtn.classList.add('text-slate-600', 'dark:text-slate-300', 'hover:bg-slate-100', 'dark:hover:bg-slate-600');
    }

    // Event Listener for Grid View
    btnGrid?.addEventListener('click', () => {
      if (iframe) {
        iframe.src = `https://drive.google.com/embeddedfolderview?id=${folderId}#grid`;
        setActiveView(btnGrid, btnList);
      }
    });

    // Event Listener for List View
    btnList?.addEventListener('click', () => {
      if (iframe) {
        iframe.src = `https://drive.google.com/embeddedfolderview?id=${folderId}#list`;
        setActiveView(btnList, btnGrid);
      }
    });

    // Event Listener for Share Button
    btnShare?.addEventListener('click', () => {
      const shareLink = `https://drive.google.com/drive/folders/${folderId}?usp=sharing`;
      
      // Copy to clipboard logic
      if (navigator.clipboard) {
        navigator.clipboard.writeText(shareLink).then(() => {
          // Visual feedback
          const originalText = btnShare.innerHTML;
          btnShare.innerHTML = '<i class="fas fa-check mr-2"></i> Link Disalin!';
          btnShare.classList.add('bg-green-600');
          
          setTimeout(() => {
            btnShare.innerHTML = originalText;
            btnShare.classList.remove('bg-green-600');
          }, 2000);
        }).catch(err => {
          console.error('Gagal menyalin link: ', err);
          alert('Gagal menyalin link. Silakan salin manual: ' + shareLink);
        });
      } else {
        // Fallback for older browsers
        prompt("Salin link ini (Ctrl+C):", shareLink);
      }
    });
    
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

    // Gallery Filter
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        // Filter gallery items
        const filter = button.getAttribute('data-filter');
        galleryItems.forEach(item => {
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

    // Lightbox
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxDescription = document.getElementById('lightbox-description');
    const lightboxCategory = document.getElementById('lightbox-category');
    const lightboxDate = document.getElementById('lightbox-date');
    const lightboxClose = document.querySelector('.lightbox-close');
    const lightboxPrev = document.querySelector('.lightbox-prev');
    const lightboxNext = document.querySelector('.lightbox-next');
    const lightboxLoading = document.getElementById('lightbox-loading');
    let currentImageIndex = 0;
    const visibleImages = [];

    function getCategoryName(category) {
      const categoryNames = {
        'kegiatan': 'Kegiatan',
        'prestasi': 'Prestasi',
        'fasilitas': 'Fasilitas',
        'ekstrakurikuler': 'Ekstrakurikuler',
        'kunjungan-industri': 'Kunjungan Industri'
      };
      return categoryNames[category] || category;
    }

    function updateVisibleImages() {
      visibleImages.length = 0;
      galleryItems.forEach(item => {
        if (item.style.display !== 'none') {
          visibleImages.push(item);
        }
      });
    }

    function openLightbox(imageElement) {
      updateVisibleImages();
      const img = imageElement.querySelector('img');
      const title = imageElement.getAttribute('data-title');
      const description = imageElement.getAttribute('data-description');
      const category = imageElement.getAttribute('data-category');
      const date = imageElement.getAttribute('data-date');
      
      currentImageIndex = visibleImages.indexOf(imageElement);
      
      // Show loading
      lightboxLoading.style.display = 'block';
      lightboxImage.style.opacity = '0';
      
      // Preload image
      const tempImg = new Image();
      tempImg.onload = function() {
        lightboxImage.src = img.src;
        lightboxImage.alt = img.alt;
        lightboxTitle.textContent = title;
        lightboxDescription.textContent = description;
        lightboxCategory.textContent = getCategoryName(category);
        lightboxDate.textContent = date;
        
        lightboxLoading.style.display = 'none';
        lightboxImage.style.opacity = '1';
      };
      tempImg.src = img.src;
      
      lightbox.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      lightbox.classList.remove('active');
      document.body.style.overflow = 'auto';
    }

    function showPrevImage() {
      if (visibleImages.length === 0) return;
      
      currentImageIndex = (currentImageIndex - 1 + visibleImages.length) % visibleImages.length;
      const item = visibleImages[currentImageIndex];
      const img = item.querySelector('img');
      const title = item.getAttribute('data-title');
      const description = item.getAttribute('data-description');
      const category = item.getAttribute('data-category');
      const date = item.getAttribute('data-date');
      
      lightboxLoading.style.display = 'block';
      lightboxImage.style.opacity = '0';
      
      const tempImg = new Image();
      tempImg.onload = function() {
        lightboxImage.src = img.src;
        lightboxImage.alt = img.alt;
        lightboxTitle.textContent = title;
        lightboxDescription.textContent = description;
        lightboxCategory.textContent = getCategoryName(category);
        lightboxDate.textContent = date;
        
        lightboxLoading.style.display = 'none';
        lightboxImage.style.opacity = '1';
      };
      tempImg.src = img.src;
    }

    function showNextImage() {
      if (visibleImages.length === 0) return;
      
      currentImageIndex = (currentImageIndex + 1) % visibleImages.length;
      const item = visibleImages[currentImageIndex];
      const img = item.querySelector('img');
      const title = item.getAttribute('data-title');
      const description = item.getAttribute('data-description');
      const category = item.getAttribute('data-category');
      const date = item.getAttribute('data-date');
      
      lightboxLoading.style.display = 'block';
      lightboxImage.style.opacity = '0';
      
      const tempImg = new Image();
      tempImg.onload = function() {
        lightboxImage.src = img.src;
        lightboxImage.alt = img.alt;
        lightboxTitle.textContent = title;
        lightboxDescription.textContent = description;
        lightboxCategory.textContent = getCategoryName(category);
        lightboxDate.textContent = date;
        
        lightboxLoading.style.display = 'none';
        lightboxImage.style.opacity = '1';
      };
      tempImg.src = img.src;
    }

    // Add click event to gallery items
    galleryItems.forEach(item => {
      item.addEventListener('click', () => openLightbox(item));
    });

    // Close lightbox
    lightboxClose.addEventListener('click', closeLightbox);
    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        closeLightbox();
      }
    });

    // Navigation
    lightboxPrev.addEventListener('click', showPrevImage);
    lightboxNext.addEventListener('click', showNextImage);

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
      if (lightbox.classList.contains('active')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') showPrevImage();
        if (e.key === 'ArrowRight') showNextImage();
      }
    });

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    });

    lightbox.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    });

    function handleSwipe() {
      if (touchEndX < touchStartX - 50) showNextImage();
      if (touchEndX > touchStartX + 50) showPrevImage();
    }

    // Initial setup
    updateVisibleImages();
  </script>
@endsection