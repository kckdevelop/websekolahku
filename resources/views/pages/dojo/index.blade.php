@extends('layouts.app')

@section('title', 'Dojo SMK - Pusat Pelatihan Standar Industri')

@section('content')
<!-- Hero Section -->
<section class="relative bg-slate-900 text-white py-20 lg:py-28 overflow-hidden">
  <div class="absolute inset-0 z-0">
    <img src="{{ $dojoSetting->hero_gambar_src }}" alt="Dojo SMK Header" class="w-full h-full object-cover opacity-25 filter blur-sm scale-105 transform">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900/90 to-primary/30"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="max-w-3xl">
      <div class="inline-flex items-center space-x-2 bg-orange-500/20 border border-orange-500/40 backdrop-blur-md px-4 py-1.5 rounded-full text-orange-300 text-xs sm:text-sm font-semibold mb-6">
        <span class="w-2.5 h-2.5 rounded-full bg-orange-400 animate-pulse"></span>
        <span>Standardized Industrial Training Center</span>
      </div>
      
      <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight mb-6">
        {{ $dojoSetting->hero_title }}
      </h1>
      
      <p class="text-lg sm:text-xl text-slate-300 font-normal leading-relaxed mb-8">
        {{ $dojoSetting->hero_subtitle }}
      </p>

      <div class="flex flex-wrap gap-4">
        <a href="#unit-dojo" class="bg-primary hover:bg-secondary text-white font-bold px-7 py-3.5 rounded-xl shadow-lg shadow-primary/30 hover:shadow-primary/50 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center">
          <i class="fas fa-layer-group mr-2.5"></i> Jelajahi Unit Dojo
        </a>
        <a href="#galeri-dojo" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-semibold px-7 py-3.5 rounded-xl border border-white/20 hover:border-white/40 transition-all duration-300 flex items-center">
          <i class="fas fa-camera mr-2.5"></i> Foto Kegiatan
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Section Overview & 3 Fungsi Utama -->
<section class="py-16 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-16">
      <div class="lg:col-span-6">
        <div class="inline-flex items-center space-x-2 text-primary font-bold text-sm tracking-wider uppercase mb-3">
          <i class="fas fa-bookmark text-xs"></i>
          <span>Pengertian & Konsep Dojo</span>
        </div>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6">
          Mencetak Lulusan Kejuruan Berstandar Industri Dunia
        </h2>
        <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-base sm:text-lg mb-6">
          {{ $dojoSetting->deskripsi_utama }}
        </p>
        <div class="p-4 rounded-2xl bg-orange-50 dark:bg-slate-800/80 border-l-4 border-primary">
          <p class="text-sm font-medium text-slate-700 dark:text-slate-300 italic">
            <i class="fas fa-quote-left text-primary/40 text-xl mr-2"></i>
            Istilah <strong>"Dojo"</strong> berasal dari bahasa Jepang yang berarti tempat latihan fisik dan mental. Di SMK, Dojo dirancang khusus untuk mentransformasi mentalitas dan keterampilan siswa dari ruang teori menuju standar kerja pabrik yang sesungguhnya.
          </p>
        </div>
      </div>

      <div class="lg:col-span-6">
        <div class="relative rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-700 group">
          <img src="{{ $dojoSetting->hero_gambar_src }}" alt="Dojo Industrial Facility" class="w-full h-[380px] object-cover group-hover:scale-105 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex items-end p-6">
            <div class="text-white">
              <span class="bg-primary/90 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">Fasilitas Unggulan</span>
              <p class="font-bold text-lg">Lingkungan Kerja Mirip Pabrik Presisi Tinggi</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 3 Fungsi Utama Cards -->
    <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
      <div class="text-center max-w-2xl mx-auto mb-12">
        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">Fungsi Utama Dojo di SMK</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base mt-2">Tiga pilar utama dalam pengembangan karakter dan keterampilan siswa di Dojo SMK.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Fungsi 1 -->
        <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700/80 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
          <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-orange-500/30 mb-6">
            <i class="fas fa-industry"></i>
          </div>
          <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
            {{ $dojoSetting->fungsi_1_judul }}
          </h4>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
            {{ $dojoSetting->fungsi_1_deskripsi }}
          </p>
        </div>

        <!-- Fungsi 2 -->
        <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700/80 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
          <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-blue-500/30 mb-6">
            <i class="fas fa-chart-line"></i>
          </div>
          <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
            {{ $dojoSetting->fungsi_2_judul }}
          </h4>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
            {{ $dojoSetting->fungsi_2_deskripsi }}
          </p>
        </div>

        <!-- Fungsi 3 -->
        <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-8 border border-slate-200/80 dark:border-slate-700/80 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
          <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 text-white rounded-2xl flex items-center justify-center text-2xl shadow-lg shadow-emerald-500/30 mb-6">
            <i class="fas fa-award"></i>
          </div>
          <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-3">
            {{ $dojoSetting->fungsi_3_judul }}
          </h4>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
            {{ $dojoSetting->fungsi_3_deskripsi }}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section 4 Unit Pelatihan Dojo -->
<section id="unit-dojo" class="py-20 bg-slate-50 dark:bg-slate-950">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <span class="text-primary font-bold text-sm uppercase tracking-wider block mb-2">Spesialisasi Unit Pelatihan</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Jenis Unit Pelatihan dalam Dojo SMK</h2>
      <p class="text-slate-600 dark:text-slate-400 text-base mt-3">Empat modul unit pelatihan yang wajib dikuasai oleh siswa sebelum memasuki praktek lapangan dan dunia industri.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Unit 1: Dojo Safety -->
      <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200/90 dark:border-slate-800 shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col justify-between group">
        <div>
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
              <i class="fas fa-hard-hat"></i>
            </div>
            <span class="bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 font-bold text-xs px-3.5 py-1.5 rounded-full uppercase tracking-wider">Unit Wajib K3</span>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">Dojo Safety</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-6">
            {{ $dojoSetting->safety_deskripsi }}
          </p>
        </div>
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 dark:text-slate-400 font-medium">
          <i class="fas fa-check-circle text-red-500 mr-2"></i> Fokus: K3, Penggunaan APD & Simulasi Tanggap Darurat
        </div>
      </div>

      <!-- Unit 2: Dojo Welding -->
      <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200/90 dark:border-slate-800 shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col justify-between group">
        <div>
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
              <i class="fas fa-fire-burner"></i>
            </div>
            <span class="bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300 font-bold text-xs px-3.5 py-1.5 rounded-full uppercase tracking-wider">Keahlian Teknis</span>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">Dojo Welding</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-6">
            {{ $dojoSetting->welding_deskripsi }}
          </p>
        </div>
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 dark:text-slate-400 font-medium">
          <i class="fas fa-check-circle text-amber-500 mr-2"></i> Fokus: Pengelasan Presisi & Sertifikasi Pengujian Las
        </div>
      </div>

      <!-- Unit 3: Dojo Assembling -->
      <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200/90 dark:border-slate-800 shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col justify-between group">
        <div>
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
              <i class="fas fa-cogs"></i>
            </div>
            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 font-bold text-xs px-3.5 py-1.5 rounded-full uppercase tracking-wider">Perakitan & Lin Produksi</span>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">Dojo Assembling</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-6">
            {{ $dojoSetting->assembling_deskripsi }}
          </p>
        </div>
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 dark:text-slate-400 font-medium">
          <i class="fas fa-check-circle text-blue-500 mr-2"></i> Fokus: Perakitan Presisi & Efisiensi Takt Time
        </div>
      </div>

      <!-- Unit 4: Dojo Behavior -->
      <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-200/90 dark:border-slate-800 shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col justify-between group">
        <div>
          <div class="flex items-center justify-between mb-6">
            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
              <i class="fas fa-user-check"></i>
            </div>
            <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300 font-bold text-xs px-3.5 py-1.5 rounded-full uppercase tracking-wider">Karakter Professional</span>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3 group-hover:text-primary transition-colors">Dojo Behavior</h3>
          <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed mb-6">
            {{ $dojoSetting->behavior_deskripsi }}
          </p>
        </div>
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center text-xs text-slate-500 dark:text-slate-400 font-medium">
          <i class="fas fa-check-circle text-emerald-500 mr-2"></i> Fokus: Budaya 5S/5R, Etos Kerja & Kedisiplinan
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Galeri Foto Kegiatan Dojo -->
<section id="galeri-dojo" class="py-20 bg-white dark:bg-slate-900">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
      <div>
        <span class="text-primary font-bold text-sm uppercase tracking-wider block mb-2">Dokumentasi Latihan</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white">Foto Kegiatan Dojo SMK</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base mt-2">Suasana pelatihan teknis, K3, perakitan, dan pembiasaan etika kerja siswa.</p>
      </div>

      <!-- Unit Filter Tabs -->
      <div class="mt-6 md:mt-0 flex flex-wrap gap-2">
        @foreach($unitList as $unit)
          <a href="{{ route('dojo.index', ['unit' => $unit]) }}#galeri-dojo" 
             class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all duration-200 {{ $selectedUnit === $unit ? 'bg-primary text-white shadow-md shadow-primary/30' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700' }}">
            {{ $unit }}
          </a>
        @endforeach
      </div>
    </div>

    @if($photos->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($photos as $p)
          <div class="bg-slate-50 dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200/80 dark:border-slate-700/80 shadow-md hover:shadow-xl transition-all duration-300 group flex flex-col">
            <div class="relative overflow-hidden aspect-video bg-slate-900 cursor-pointer">
              <img src="{{ $p->foto_src }}" 
                   alt="{{ $p->judul }}" 
                   data-desc="{{ $p->judul }} - {{ $p->unit_dojo }} @if($p->deskripsi) ({{ $p->deskripsi }}) @endif"
                   class="activity-preview-img w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              <div class="absolute top-3 left-3">
                <span class="bg-slate-900/80 backdrop-blur-md text-white text-xs font-bold px-3 py-1 rounded-full border border-white/20">
                  {{ $p->unit_dojo }}
                </span>
              </div>
              <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <span class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md text-white flex items-center justify-center text-lg">
                  <i class="fas fa-search-plus"></i>
                </span>
              </div>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between">
              <div>
                <h4 class="font-bold text-slate-900 dark:text-white text-lg mb-2 line-clamp-2 leading-snug">
                  {{ $p->judul }}
                </h4>
                @if($p->deskripsi)
                  <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm line-clamp-3 leading-relaxed">
                    {{ $p->deskripsi }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center py-16 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700">
        <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/30 text-primary rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
          <i class="fas fa-images"></i>
        </div>
        <h4 class="font-bold text-slate-700 dark:text-slate-300 text-lg">Belum Ada Foto Kegiatan</h4>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Foto kegiatan untuk kategori <strong>{{ $selectedUnit }}</strong> akan ditampilkan di sini.</p>
      </div>
    @endif
  </div>
</section>

<!-- Section Kerjasama Industri & CTA -->
<section class="py-16 bg-gradient-to-br from-slate-900 via-slate-800 to-primary/80 text-white relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
      <div class="lg:col-span-8">
        <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-md px-3.5 py-1 rounded-full text-xs font-semibold mb-4 text-orange-300">
          <i class="fas fa-handshake"></i>
          <span>Kemitraan Industri Terkemuka</span>
        </div>
        <h2 class="text-2xl sm:text-4xl font-bold mb-4 leading-tight">
          Standar Kerja Industri Langsung dari Mitra Perusahaan
        </h2>
        <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
          {{ $dojoSetting->kerjasama_info }}
        </p>
      </div>
      <div class="lg:col-span-4 text-left lg:text-right">
        <a href="/informasi/spmb" class="inline-flex items-center bg-white text-slate-900 hover:bg-orange-50 font-extrabold px-8 py-4 rounded-2xl shadow-xl transition-all duration-300 transform hover:scale-105">
          <i class="fas fa-graduation-cap mr-2.5 text-primary text-xl"></i>
          <span>Daftar SMK Sekarang</span>
        </a>
      </div>
    </div>
  </div>
</section>
@endsection
