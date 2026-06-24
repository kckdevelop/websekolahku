@extends('layouts.app')

@section('title', $bkk->hero_title)

@section('content')
<!-- Hero Section -->
<section id="bkk-hero" class="relative min-h-[50vh] md:min-h-[60vh] flex items-center justify-center bg-slate-900 text-white overflow-hidden py-16">
  {{-- Hero Background Image with Overlay --}}
  <div class="absolute inset-0 z-0">
    <img src="{{ $bkk->hero_gambar_src }}" alt="BKK Hero" class="w-full h-full object-cover opacity-35">
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/80 to-slate-950/40"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-orange-500/10 text-orange-400 border border-orange-500/20 mb-4 animate-pulse">
      <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
      Pusat Karir & Penempatan Kerja Alumni
    </span>
    <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6">
      {!! e($bkk->hero_title) !!}
    </h1>
    <p class="text-base md:text-xl text-slate-300 max-w-3xl mx-auto mb-8 font-light">
      {{ $bkk->hero_subtitle }}
    </p>
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
      <a href="#bkk-jobs" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-semibold px-8 py-3.5 rounded-full shadow-lg shadow-orange-500/20 hover:shadow-orange-500/30 transition-all hover:scale-105 duration-200">
        <i class="fas fa-search-plus"></i> Cari Lowongan Kerja
      </a>
      <a href="#bkk-about" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-white/20 text-white border border-white/20 font-semibold px-8 py-3.5 rounded-full backdrop-blur-sm transition-all duration-200">
        Tentang BKK <i class="fas fa-arrow-down text-xs"></i>
      </a>
    </div>
  </div>
</section>

<!-- Tentang BKK & Statistik -->
<section id="bkk-about" class="py-20 bg-white dark:bg-slate-900 transition-colors">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
      {{-- Column Left: Info --}}
      <div class="lg:col-span-5 space-y-6">
        <h2 class="text-xs font-semibold text-orange-500 uppercase tracking-widest">{{ $bkk->tentang_judul }}</h2>
        <h3 class="text-2xl md:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
          Menyiapkan Lulusan Siap Kerja, Cerdas & Kompetitif
        </h3>
        <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
          {{ $bkk->tentang_deskripsi }}
        </p>
        <div class="pt-2">
          <a href="#bkk-cta" class="text-orange-500 hover:text-orange-600 font-semibold inline-flex items-center gap-2 group transition-all">
            Hubungi Koordinator BKK <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
          </a>
        </div>
      </div>

      {{-- Column Right: Stats Grid --}}
      <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
        @foreach($bkk->statistik ?? [] as $stat)
          <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 transition-all hover:shadow-md group">
            <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-500/10 text-orange-500 dark:text-orange-400 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <i class="fas {{ $stat['ikon'] ?? 'fa-chart-bar' }} text-lg"></i>
            </div>
            <p class="text-3xl font-extrabold text-slate-950 dark:text-white">{{ $stat['nilai'] ?? '0' }}</p>
            <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 mt-1">{{ $stat['label'] ?? '' }}</p>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- Layanan BKK -->
<section id="bkk-services" class="py-20 bg-slate-50 dark:bg-slate-800/40 border-y border-slate-100 dark:border-slate-800/80 transition-colors">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <h2 class="text-xs font-semibold text-orange-500 uppercase tracking-widest mb-3">Layanan Kami</h2>
      <h3 class="text-3xl font-bold text-slate-950 dark:text-white">Apa Saja yang BKK Lakukan?</h3>
      <p class="text-slate-500 dark:text-slate-400 mt-3">Kami berdedikasi mendampingi setiap siswa dan alumni dari persiapan karir hingga mendapatkan penempatan kerja terbaik.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($bkk->layanan ?? [] as $lay)
        <div class="p-6 bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-800/50 transition-all hover:-translate-y-1 hover:shadow-md duration-200">
          <div class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-500/5 text-orange-500 flex items-center justify-center mb-5">
            <i class="fas {{ $lay['ikon'] ?? 'fa-check' }} text-xl"></i>
          </div>
          <h4 class="font-bold text-slate-900 dark:text-white text-lg mb-2">{{ $lay['judul'] ?? '' }}</h4>
          <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $lay['deskripsi'] ?? '' }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Job Listings Section -->
<section id="bkk-jobs" class="py-20 bg-white dark:bg-slate-900 transition-colors">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
      <h2 class="text-xs font-semibold text-orange-500 uppercase tracking-widest mb-3">Bursa Kerja</h2>
      <h3 class="text-3xl font-bold text-slate-950 dark:text-white">Peluang Karir Terkini</h3>
      <p class="text-slate-500 dark:text-slate-400 mt-2">Daftar lowongan pekerjaan terbaru yang aktif dan terbuka untuk alumni SMK Muhammadiyah 1 Bantul.</p>
    </div>

    {{-- Filter & Search Panel --}}
    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 mb-8 flex flex-col md:flex-row gap-4 items-center justify-between shadow-sm">
      {{-- Search Input --}}
      <div class="relative w-full md:max-w-xs">
        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
        <input type="text" id="job-search" placeholder="Cari posisi atau perusahaan..."
          class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-sm transition-all"
          onkeyup="filterJobs()">
      </div>

      {{-- Filters Grid --}}
      <div class="w-full md:w-auto flex flex-wrap gap-2 justify-end">
        {{-- Job Type Filter --}}
        <select id="filter-type" onchange="filterJobs()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-xs font-semibold">
          <option value="All">Semua Tipe Pekerjaan</option>
          <option value="Full Time">Full Time</option>
          <option value="Part Time">Part Time</option>
          <option value="Magang">Magang</option>
          <option value="Kontrak">Kontrak</option>
        </select>

        {{-- Major Filter --}}
        <select id="filter-major" onchange="filterJobs()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 text-xs font-semibold">
          <option value="All">Semua Jurusan</option>
          <option value="RPL">RPL</option>
          <option value="TKR">TKR</option>
          <option value="TBSM">TBSM</option>
          <option value="TPM">TPM</option>
          <option value="TAV">TAV</option>
        </select>
      </div>
    </div>

    {{-- Job Grid --}}
    <div id="jobs-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($lowongans as $item)
        <div class="job-card bg-white dark:bg-slate-800 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden hover:shadow-md hover:border-orange-500/20 dark:hover:border-orange-500/30 transition-all duration-300 flex flex-col justify-between group"
          data-search="{{ strtolower($item->nama_perusahaan . ' ' . $item->posisi . ' ' . $item->lokasi) }}"
          data-type="{{ $item->tipe_pekerjaan }}"
          data-jurusan="{{ $item->jurusan_relevan ?? 'Semua Jurusan' }}">
          
          <div class="p-6">
            {{-- Header --}}
            <div class="flex items-start gap-4">
              <img src="{{ $item->logo_src }}" alt="{{ $item->nama_perusahaan }}" class="w-12 h-12 rounded-xl object-cover border border-slate-100 dark:border-slate-700 bg-slate-50 flex-shrink-0">
              <div class="min-w-0">
                <h4 class="font-bold text-slate-900 dark:text-white text-base truncate group-hover:text-orange-500 transition-colors">{{ $item->posisi }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold truncate">{{ $item->nama_perusahaan }}</p>
                <p class="text-xxs text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1">
                  <i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}
                </p>
              </div>
            </div>

            {{-- Badges --}}
            <div class="flex flex-wrap gap-1.5 mt-5">
              <span class="px-2.5 py-0.5 bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 rounded-full text-[10px] font-bold">
                {{ $item->tipe_pekerjaan }}
              </span>
              <span class="px-2.5 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-full text-[10px] font-bold">
                {{ $item->jurusan_relevan ?? 'Semua Jurusan' }}
              </span>
            </div>

            {{-- Brief Desc --}}
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-4 line-clamp-2 leading-relaxed">
              {{ $item->deskripsi ?? 'Silakan klik tombol detail di bawah untuk melihat persyaratan dan deskripsi pekerjaan secara lengkap.' }}
            </p>
          </div>

          {{-- Footer --}}
          <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between text-xs mt-auto">
            <span class="text-slate-400 dark:text-slate-500 font-semibold">
              <i class="far fa-calendar-alt mr-1"></i> Batas: {{ $item->batas_lamaran->format('d M Y') }}
            </span>
            <button type="button"
              data-perusahaan="{{ $item->nama_perusahaan }}"
              data-logo="{{ $item->logo_src }}"
              data-posisi="{{ $item->posisi }}"
              data-lokasi="{{ $item->lokasi }}"
              data-tipe="{{ $item->tipe_pekerjaan }}"
              data-jurusan="{{ $item->jurusan_relevan ?? 'Semua Jurusan' }}"
              data-batas="{{ $item->batas_lamaran->format('d M Y') }}"
              data-deskripsi="{{ $item->deskripsi }}"
              data-brosur="{{ $item->brosur_src }}"
              data-persyaratan='@json($item->persyaratan ?? [])'
              data-kontak="{{ $item->kontak_lamaran }}"
              onclick="openJobModal(this)"
              class="text-orange-500 hover:text-orange-600 font-bold inline-flex items-center gap-1">
              Lihat Detail <i class="fas fa-chevron-right text-[10px]"></i>
            </button>
          </div>
        </div>
      @empty
        <div class="col-span-full py-16 text-center text-slate-400">
          <i class="fas fa-briefcase text-5xl mb-4 text-slate-300 block"></i>
          <p class="font-semibold text-slate-600 dark:text-slate-400">Belum ada lowongan pekerjaan aktif</p>
          <p class="text-xs text-slate-500 mt-1">Silakan kunjungi beberapa waktu ke depan untuk lowongan terbaru.</p>
        </div>
      @endforelse
    </div>

    {{-- Fallback empty view after search --}}
    <div id="no-jobs-found" class="hidden py-16 text-center text-slate-400">
      <i class="fas fa-search text-5xl mb-4 text-slate-300 block"></i>
      <p class="font-semibold text-slate-600 dark:text-slate-400">Tidak ada lowongan yang sesuai kriteria pencarian</p>
      <p class="text-xs text-slate-500 mt-1">Coba ubah kata kunci pencarian atau bersihkan filter yang aktif.</p>
    </div>
  </div>
</section>

<!-- Mitra Perusahaan -->
<section id="bkk-partners" class="py-20 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 transition-colors">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-12">
      <h2 class="text-xs font-semibold text-orange-500 uppercase tracking-widest mb-3">Kolaborator</h2>
      <h3 class="text-3xl font-bold text-slate-950 dark:text-white">Mitra Perusahaan Kami</h3>
      <p class="text-slate-500 dark:text-slate-400 mt-2">Bekerja sama erat dengan industri terkemuka untuk mempercepat penyerapan lulusan.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 items-center">
      @forelse($bkk->mitra_perusahaan ?? [] as $m)
        <div class="p-6 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl flex flex-col items-center justify-center text-center shadow-xs hover:shadow-sm transition-all duration-300 group h-32">
          @if(!empty($m['logo']))
            <img src="{{ asset('storage/' . $m['logo']) }}" alt="{{ $m['nama'] }}" class="max-h-12 max-w-full object-contain grayscale group-hover:grayscale-0 transition duration-300">
          @else
            <div class="w-12 h-12 rounded-full bg-orange-50 dark:bg-orange-500/10 text-orange-500 flex items-center justify-center font-bold text-lg mb-2">
              {{ strtoupper(substr($m['nama'] ?? 'M', 0, 1)) }}
            </div>
          @endif
          <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-2 truncate max-w-full">{{ $m['nama'] ?? '' }}</span>
        </div>
      @empty
        <div class="col-span-full text-center text-slate-400 py-6 text-sm">Belum ada mitra perusahaan terdaftar.</div>
      @endforelse
    </div>
  </div>
</section>

<!-- CTA & Kontak -->
<section id="bkk-cta" class="py-20 bg-gradient-to-br from-orange-500 to-red-600 text-white relative overflow-hidden">
  {{-- Graphic elements --}}
  <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.12),transparent_40%)]"></div>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div class="space-y-6 text-left">
        <h2 class="text-3xl md:text-4xl font-extrabold leading-tight">{{ $bkk->cta_title }}</h2>
        <p class="text-orange-50/95 font-light text-base leading-relaxed">
          {{ $bkk->cta_subtitle }}
        </p>
        <div class="flex flex-wrap gap-4 pt-2">
          @if($bkk->kontak_telepon)
            <a href="tel:{{ $bkk->kontak_telepon }}" class="inline-flex items-center gap-2 bg-white text-orange-600 hover:bg-orange-50 font-bold px-6 py-3 rounded-full shadow-lg transition hover:scale-105 duration-200">
              <i class="fas fa-phone-alt"></i> Hubungi BKK
            </a>
          @endif
          @if($bkk->kontak_email)
            <a href="mailto:{{ $bkk->kontak_email }}" class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white border border-orange-400/30 font-bold px-6 py-3 rounded-full transition hover:scale-105 duration-200">
              <i class="fas fa-envelope"></i> Kirim Email
            </a>
          @endif
        </div>
      </div>

      {{-- Kontak Details Cards --}}
      <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 border border-white/10 space-y-6">
        <h3 class="text-xl font-bold border-b border-white/10 pb-4"><i class="fas fa-address-card mr-2"></i>Informasi Kontak Resmi</h3>
        
        <div class="space-y-4 text-sm font-medium text-orange-50">
          @if($bkk->kontak_nama)
            <div class="flex items-start gap-3">
              <i class="fas fa-user-circle text-lg text-orange-200 mt-0.5 flex-shrink-0"></i>
              <div>
                <p class="text-xs text-orange-200/70 font-semibold">Penanggung Jawab</p>
                <p class="text-white">{{ $bkk->kontak_nama }}</p>
              </div>
            </div>
          @endif

          @if($bkk->kontak_jam_operasional)
            <div class="flex items-start gap-3">
              <i class="fas fa-clock text-lg text-orange-200 mt-0.5 flex-shrink-0"></i>
              <div>
                <p class="text-xs text-orange-200/70 font-semibold">Jam Pelayanan</p>
                <p class="text-white">{{ $bkk->kontak_jam_operasional }}</p>
              </div>
            </div>
          @endif

          @if($bkk->kontak_lokasi)
            <div class="flex items-start gap-3">
              <i class="fas fa-map-marked-alt text-lg text-orange-200 mt-0.5 flex-shrink-0"></i>
              <div>
                <p class="text-xs text-orange-200/70 font-semibold">Lokasi Kantor</p>
                <p class="text-white leading-relaxed">{{ $bkk->kontak_lokasi }}</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Job Details Modal (Popup Drawer) -->
<div id="job-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/60 backdrop-blur-xs transition-opacity duration-300 p-4">
  <div class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-3xl overflow-hidden shadow-2xl border border-slate-100 dark:border-slate-800/80 transform scale-95 opacity-0 transition-all duration-300 max-h-[90vh] flex flex-col" id="job-modal-content">
    {{-- Modal Header --}}
    <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 flex items-start justify-between gap-4">
      <div class="flex gap-4">
        <img id="modal-company-logo" src="" alt="Company Logo" class="w-14 h-14 rounded-2xl object-cover border border-slate-100 dark:border-slate-700 bg-slate-50 flex-shrink-0">
        <div>
          <h3 id="modal-job-posisi" class="text-lg md:text-xl font-extrabold text-slate-950 dark:text-white leading-tight"></h3>
          <p id="modal-company-nama" class="text-sm text-slate-500 dark:text-slate-400 font-semibold mt-0.5"></p>
          <p id="modal-job-lokasi" class="text-xs text-slate-400 dark:text-slate-500 mt-1 flex items-center gap-1">
            <i class="fas fa-map-marker-alt text-orange-500"></i> <span></span>
          </p>
        </div>
      </div>
      <button type="button" onclick="closeJobModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-500 dark:text-slate-400 flex items-center justify-center transition-colors">
        <i class="fas fa-times"></i>
      </button>
    </div>

    {{-- Modal Body (Scrollable) --}}
    <div class="p-6 overflow-y-auto space-y-6 flex-1 text-slate-800 dark:text-slate-200">
      {{-- Meta Info row --}}
      <div class="grid grid-cols-3 gap-3 text-center">
        <div class="p-3 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-100 dark:border-slate-800/50">
          <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Tipe Kerja</p>
          <p id="modal-job-tipe" class="text-xs font-extrabold text-slate-800 dark:text-slate-200 mt-1"></p>
        </div>
        <div class="p-3 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-100 dark:border-slate-800/50">
          <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Kualifikasi Jurusan</p>
          <p id="modal-job-jurusan" class="text-xs font-extrabold text-slate-800 dark:text-slate-200 mt-1"></p>
        </div>
        <div class="p-3 bg-slate-50 dark:bg-slate-800/40 rounded-2xl border border-slate-100 dark:border-slate-800/50">
          <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Batas Waktu</p>
          <p id="modal-job-batas" class="text-xs font-extrabold text-slate-800 dark:text-slate-200 mt-1"></p>
        </div>
      </div>

      {{-- Deskripsi --}}
      <div id="modal-desc-section">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-l-4 border-orange-500 pl-2 mb-2">Deskripsi Pekerjaan</h4>
        <p id="modal-job-desc" class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-line"></p>
      </div>

      {{-- Persyaratan --}}
      <div id="modal-req-section">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-l-4 border-orange-500 pl-2 mb-3">Persyaratan Khusus</h4>
        <ul id="modal-job-reqs" class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
          {{-- dynamic list items --}}
        </ul>
      </div>

      {{-- Brosur --}}
      <div id="modal-brosur-section" class="hidden">
        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-l-4 border-orange-500 pl-2 mb-3">Brosur Lowongan</h4>
        <div class="relative overflow-hidden rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 flex justify-center p-2 group max-w-sm mx-auto shadow-sm">
          <img id="modal-job-brosur" src="" alt="Brosur Lowongan" class="activity-preview-img max-h-64 object-contain rounded-xl cursor-pointer hover:scale-102 transition-transform duration-200" data-desc="Brosur Lowongan Kerja">
          <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center pointer-events-none transition-opacity duration-200">
            <span class="bg-white/95 text-slate-900 text-xs font-bold px-3.5 py-1.5 rounded-full shadow flex items-center gap-1.5">
              <i class="fas fa-search-plus text-orange-500"></i> Klik untuk Perbesar
            </span>
          </div>
        </div>
      </div>
    </div>

    {{-- Modal Footer --}}
    <div class="p-6 bg-slate-50 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold">Tertarik melamar posisi ini?</p>
        <p class="text-sm text-slate-700 dark:text-slate-300 font-bold mt-0.5" id="modal-job-contact-info"></p>
      </div>
      <a href="" id="modal-apply-btn" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-semibold px-6 py-2.5 rounded-full text-sm transition hover:scale-105 duration-200 shadow-md">
        <i class="fas fa-paper-plane text-xs"></i> Kirim Lamaran
      </a>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  // Filter Jobs based on Search & Select dropdowns
  function filterJobs() {
    const searchVal = document.getElementById('job-search').value.toLowerCase();
    const typeVal = document.getElementById('filter-type').value;
    const majorVal = document.getElementById('filter-major').value;

    const cards = document.querySelectorAll('.job-card');
    let visibleCount = 0;

    cards.forEach(card => {
      const searchAttr = card.getAttribute('data-search');
      const typeAttr = card.getAttribute('data-type');
      const majorAttr = card.getAttribute('data-jurusan');

      // Search match
      const matchesSearch = searchAttr.includes(searchVal);
      // Type match
      const matchesType = (typeVal === 'All' || typeAttr === typeVal);
      // Major match
      let matchesMajor = false;
      if (majorVal === 'All') {
        matchesMajor = true;
      } else {
        // checks if card major tag matches the selected dropdown, or contains 'semua' or 'all'
        const normalizedMajor = majorAttr.toLowerCase();
        matchesMajor = normalizedMajor.includes(majorVal.toLowerCase()) || 
                       normalizedMajor.includes('semua') || 
                       normalizedMajor.includes('all');
      }

      if (matchesSearch && matchesType && matchesMajor) {
        card.classList.remove('hidden');
        card.classList.add('flex');
        visibleCount++;
      } else {
        card.classList.remove('flex');
        card.classList.add('hidden');
      }
    });

    const noJobsAlert = document.getElementById('no-jobs-found');
    if (visibleCount === 0) {
      noJobsAlert.classList.remove('hidden');
    } else {
      noJobsAlert.classList.add('hidden');
    }
  }

  // Open Details Modal
  function openJobModal(button) {
    const perusahaan = button.getAttribute('data-perusahaan');
    const logo = button.getAttribute('data-logo');
    const posisi = button.getAttribute('data-posisi');
    const lokasi = button.getAttribute('data-lokasi');
    const tipe = button.getAttribute('data-tipe');
    const jurusan = button.getAttribute('data-jurusan');
    const batas = button.getAttribute('data-batas');
    const deskripsi = button.getAttribute('data-deskripsi');
    const brosur = button.getAttribute('data-brosur');
    const kontak = button.getAttribute('data-kontak') || '-';

    let persyaratan = [];
    try {
      persyaratan = JSON.parse(button.getAttribute('data-persyaratan'));
    } catch(e) {
      persyaratan = [];
    }

    // Set Text Content
    document.getElementById('modal-company-logo').src = logo;
    document.getElementById('modal-company-logo').alt = perusahaan;
    document.getElementById('modal-job-posisi').textContent = posisi;
    document.getElementById('modal-company-nama').textContent = perusahaan;
    document.querySelector('#modal-job-lokasi span').textContent = lokasi;
    document.getElementById('modal-job-tipe').textContent = tipe;
    document.getElementById('modal-job-jurusan').textContent = jurusan;
    document.getElementById('modal-job-batas').textContent = batas;
    
    // Handle Deskripsi Section
    const descText = document.getElementById('modal-job-desc');
    if (deskripsi && deskripsi.trim() !== '') {
      descText.textContent = deskripsi;
      document.getElementById('modal-desc-section').style.display = 'block';
    } else {
      document.getElementById('modal-desc-section').style.display = 'none';
    }

    // Handle Brosur Section
    const brosurSec = document.getElementById('modal-brosur-section');
    const brosurImg = document.getElementById('modal-job-brosur');
    if (brosur && brosur.trim() !== '') {
      brosurImg.src = brosur;
      brosurSec.classList.remove('hidden');
    } else {
      brosurImg.src = '';
      brosurSec.classList.add('hidden');
    }

    // Handle Requirements list
    const reqsList = document.getElementById('modal-job-reqs');
    reqsList.innerHTML = '';
    if (persyaratan && persyaratan.length > 0) {
      persyaratan.forEach(req => {
        const li = document.createElement('li');
        li.className = 'flex items-start gap-2.5';
        li.innerHTML = `
          <i class="fas fa-check-circle text-orange-500 mt-1 flex-shrink-0 text-xs"></i>
          <span>${req}</span>
        `;
        reqsList.appendChild(li);
      });
      document.getElementById('modal-req-section').style.display = 'block';
    } else {
      document.getElementById('modal-req-section').style.display = 'none';
    }

    // Handle Apply / Kontak info
    const contactInfoEl = document.getElementById('modal-job-contact-info');
    const applyBtn = document.getElementById('modal-apply-btn');
    contactInfoEl.textContent = kontak;

    if (kontak.startsWith('http') || kontak.startsWith('www')) {
      applyBtn.href = kontak.startsWith('http') ? kontak : 'https://' + kontak;
      applyBtn.target = '_blank';
      applyBtn.style.display = 'inline-flex';
    } else if (kontak.includes('@')) {
      applyBtn.href = 'mailto:' + kontak + '?subject=Lamaran Pekerjaan: ' + encodeURIComponent(posisi);
      applyBtn.style.display = 'inline-flex';
    } else if (/^\+?[0-9\s-]{8,18}$/.test(kontak.replace(/[^0-9+]/g, ''))) {
      let waNum = kontak.replace(/[^0-9]/g, '');
      if (waNum.startsWith('0')) waNum = '62' + waNum.slice(1);
      applyBtn.href = 'https://wa.me/' + waNum + '?text=' + encodeURIComponent('Halo BKK MUSABA, saya tertarik melamar lowongan ' + posisi + ' di ' + perusahaan);
      applyBtn.target = '_blank';
      applyBtn.style.display = 'inline-flex';
    } else {
      applyBtn.style.display = 'none';
    }

    // Open animations
    const modal = document.getElementById('job-modal');
    const content = document.getElementById('job-modal-content');

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');

    setTimeout(() => {
      modal.classList.remove('opacity-0');
      modal.classList.add('opacity-100');
      content.classList.remove('scale-95', 'opacity-0');
      content.classList.add('scale-100', 'opacity-100');
    }, 20);
  }

  // Close Details Modal
  function closeJobModal() {
    const modal = document.getElementById('job-modal');
    const content = document.getElementById('job-modal-content');

    modal.classList.remove('opacity-100');
    modal.classList.add('opacity-0');
    content.classList.remove('scale-100', 'opacity-100');
    content.classList.add('scale-95', 'opacity-0');

    setTimeout(() => {
      modal.classList.remove('flex');
      modal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
    }, 300);
  }

  // Close on Escape or click outside
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeJobModal();
  });
  document.getElementById('job-modal').addEventListener('click', (e) => {
    if (e.target.id === 'job-modal') closeJobModal();
  });
</script>
@endsection
