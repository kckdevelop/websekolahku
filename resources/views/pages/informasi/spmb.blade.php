@extends('layouts.app')
@section('title', 'SPMB - SMK Muhammadiyah 1 Bantul')

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
  .step-card {
    display: flex;
    gap: 16px;
    align-items: flex-start;
  }
  .step-number {
    min-width: 36px;
    height: 36px;
    background: #f97316;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    flex-shrink: 0;
  }
  .gallery-img {
    transition: transform 0.3s ease;
    border-radius: 12px;
  }
  .gallery-img:hover {
    transform: scale(1.03);
  }
</style>
<style>
  /* Optional: jika ingin menambahkan fallback untuk dark mode */
  @media (prefers-color-scheme: dark) {
    .kuota-card {
      color: white !important;
    }
    .kuota-card h3, .kuota-card p {
      color: white !important;
    }
  }
</style>
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="relative h-[40vh] overflow-hidden">
    @auth
      <div class="absolute top-6 right-6 z-[999]">
        <a href="{{ route('admin.spmb-halaman.edit') }}" class="bg-primary hover:bg-secondary text-white text-xs font-semibold px-4 py-2.5 rounded-full shadow-md flex items-center gap-2 transition transform hover:scale-105">
          <i class="fas fa-edit"></i> Edit Halaman SPMB
        </a>
      </div>
    @endauth
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    <img src="{{ $spmbContent->hero_gambar_src }}" alt="{{ $spmbContent->hero_title }}" class="w-full h-full object-cover">
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-2">{{ $spmbContent->hero_title }}</h1>
      <p class="text-lg md:text-xl">{{ $spmbContent->hero_subtitle }}</p>
    </div>
  </section>
  <!-- Kuota -->
<section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-primary mb-6 text-center">Kuota Program Keahlian</h2>
    <p class="text-center text-slate-600 dark:text-slate-400 mb-8">
      Daya tampung untuk tahun ajaran 2026/2027 berdasarkan kuota resmi sekolah:
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
      <!-- TKRO -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
        <h3 class="font-bold text-primary">TKRO</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">{{ $spmbContent->kuota_tkro }}</p>
      </div>

      <!-- TBSM -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);">
        <h3 class="font-bold text-primary">TBSM</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">{{ $spmbContent->kuota_tbsm }}</p>
      </div>

      <!-- TPM -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">
        <h3 class="font-bold text-primary">TPM</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">{{ $spmbContent->kuota_tpm }}</p>
      </div>

      <!-- TAV -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #d7bde2 0%, #f5b7b1 100%);">
        <h3 class="font-bold text-primary">TAV</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">{{ $spmbContent->kuota_tav }}</p>
      </div>

      <!-- RPL -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #c3cfe2 0%, #a29bfe 100%);">
        <h3 class="font-bold text-primary">RPL</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">{{ $spmbContent->kuota_rpl }}</p>
      </div>
    </div>
  </div>
</section>

  <!-- Alur Pendaftaran -->
  <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-8 text-center">Alur Pendaftaran</h2>
      <div class="space-y-6">
        @foreach ($spmbContent->alur_pendaftaran as $index => $step)
          <div class="step-card">
            <div class="step-number">{{ $index + 1 }}</div>
            <div>
              <h3 class="font-bold text-lg">{{ $step['judul'] }}</h3>
              <p class="text-slate-600 dark:text-slate-400">{{ $step['deskripsi'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Persyaratan -->
  <section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-6 text-center">Persyaratan Pendaftaran</h2>
      <ul class="list-disc pl-6 space-y-2 text-slate-700 dark:text-slate-300">
        @foreach ($spmbContent->persyaratan as $item)
          <li>{{ $item }}</li>
        @endforeach
      </ul>
    </div>
  </section>

  <!-- Jadwal Penting -->
  <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      @php
        $activeWave = $gelombangs->where('is_aktif', true)->first();
        $tahunAjaran = $activeWave ? $activeWave->tahun_ajaran : '2026/2027';
      @endphp
      <h2 class="text-2xl font-bold text-primary mb-6 text-center">Jadwal Penting SPMB {{ $tahunAjaran }}</h2>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="border-b border-slate-300 dark:border-slate-600">
              <th class="py-3 px-4 font-semibold text-slate-800 dark:text-slate-200">Kegiatan</th>
              <th class="py-3 px-4 font-semibold text-slate-800 dark:text-slate-200">Waktu</th>
              <th class="py-3 px-4 font-semibold text-slate-800 dark:text-slate-200 text-center">Status</th>
            </tr>
          </thead>
          <tbody class="text-slate-700 dark:text-slate-300">
            @forelse($gelombangs as $item)
              <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors {{ $item->is_aktif ? 'font-semibold text-primary dark:text-orange-400 bg-orange-55/10' : '' }}">
                <td class="py-3 px-4">
                  <div>Pendaftaran {{ $item->nama_gelombang }}</div>
                  @if($item->keterangan)
                    <span class="text-xxs font-normal text-slate-400 block mt-0.5">{{ $item->keterangan }}</span>
                  @endif
                </td>
                <td class="py-3 px-4">
                  @if($item->tanggal_mulai && $item->tanggal_selesai)
                    {{ $item->tanggal_mulai->translatedFormat('d F Y') }} – {{ $item->tanggal_selesai->translatedFormat('d F Y') }}
                  @else
                    Akan ditentukan kemudian
                  @endif
                </td>
                <td class="py-3 px-4 text-center">
                  @if($item->is_aktif)
                    <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                      <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Aktif
                    </span>
                  @else
                    <span class="text-slate-400 text-xs">Tutup</span>
                  @endif
                </td>
              </tr>
            @empty
              {{-- Fallback jika database kosong --}}
              <tr class="border-b border-slate-200 dark:border-slate-700">
                <td class="py-3 px-4">Pendaftaran Gelombang I</td>
                <td class="py-3 px-4">15 Januari – 15 Maret 2025</td>
                <td class="py-3 px-4 text-center"><span class="text-slate-400 text-xs">Tutup</span></td>
              </tr>
              <tr class="border-b border-slate-200 dark:border-slate-700">
                <td class="py-3 px-4">Pengumuman Gelombang I</td>
                <td class="py-3 px-4">20 Maret 2025</td>
                <td class="py-3 px-4 text-center"><span class="text-slate-400 text-xs">Tutup</span></td>
              </tr>
              <tr class="border-b border-slate-200 dark:border-slate-700">
                <td class="py-3 px-4">Pendaftaran Gelombang II</td>
                <td class="py-3 px-4">16 Maret – 30 Mei 2025</td>
                <td class="py-3 px-4 text-center"><span class="text-slate-400 text-xs">Tutup</span></td>
              </tr>
              <tr class="border-b border-slate-200 dark:border-slate-700">
                <td class="py-3 px-4">Pengumuman Gelombang II</td>
                <td class="py-3 px-4">5 Juni 2025</td>
                <td class="py-3 px-4 text-center"><span class="text-slate-400 text-xs">Tutup</span></td>
              </tr>
              <tr>
                <td class="py-3 px-4">Daftar Ulang</td>
                <td class="py-3 px-4">10–20 Juni 2025</td>
                <td class="py-3 px-4 text-center"><span class="text-slate-400 text-xs">Tutup</span></td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- Galeri Pelaksanaan SPMB -->
  <section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-8 text-center">Dokumentasi SPMB Tahun Lalu</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($spmbContent->foto_galeri as $index => $photo)
          @php
            $imgSrc = !empty($photo['gambar']) ? (Str::startsWith($photo['gambar'], 'http') ? $photo['gambar'] : asset('storage/' . $photo['gambar'])) : 'https://picsum.photos/seed/spmb'.($index+1).'/400/300';
          @endphp
          <img src="{{ $imgSrc }}" alt="{{ $photo['deskripsi'] ?? 'Dokumentasi SPMB' }}" title="{{ $photo['deskripsi'] ?? '' }}" class="gallery-img w-full h-48 object-cover shadow-md">
        @endforeach
      </div>
    </div>
  </section>

  <!-- Pendaftaran & Portal Siswa (Gabung Sekarang) -->
  <section id="pendaftaran" class="py-16 bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 fade-in-scroll">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white mb-4">{{ $spmbContent->cta_title }}</h2>
        <p class="text-slate-600 dark:text-slate-300 text-lg max-w-2xl mx-auto font-light font-sans">{{ $spmbContent->cta_subtitle }}</p>
      </div>

      {{-- Warning Pendaftaran Ditutup --}}
      @if (!$spmbContent->is_pendaftaran_open)
        <div class="mb-8 bg-amber-50 dark:bg-amber-55/10 border border-amber-200 dark:border-amber-500/30 text-amber-800 dark:text-amber-200 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm max-w-2xl mx-auto text-left">
          <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 text-lg mt-0.5"></i>
          <div>
            <span class="font-bold block">Pendaftaran Akun Baru Ditutup</span>
            <span class="text-sm font-sans">Mohon maaf, registrasi akun baru SPMB saat ini sedang ditutup. Calon siswa baru yang belum memiliki akun tidak dapat mendaftar. Jika Anda sudah mendaftar akun sebelumnya, silakan klik tombol <strong>"Sudah Punya Akun?"</strong> di bawah untuk masuk dan melanjutkan pengisian formulir.</span>
          </div>
        </div>
      @endif

      {{-- Alert --}}
      @if (session('success'))
        <div class="mb-6 bg-emerald-50 dark:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-400/30 text-emerald-800 dark:text-emerald-200 px-5 py-4 rounded-2xl flex items-center gap-3">
          <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 text-lg"></i>
          <span>{!! session('success') !!}</span>
        </div>
      @endif
      @if (session('warning'))
        <div class="mb-6 bg-amber-50 dark:bg-amber-500/20 border border-amber-200 dark:border-amber-400/30 text-amber-800 dark:text-amber-200 px-5 py-4 rounded-2xl flex items-center gap-3">
          <i class="fas fa-exclamation-triangle text-amber-500 dark:text-amber-400 text-lg"></i>
          <span>{!! session('warning') !!}</span>
        </div>
      @endif
      @if (session('info'))
        <div class="mb-6 bg-blue-50 dark:bg-blue-500/20 border border-blue-200 dark:border-blue-400/30 text-blue-800 dark:text-blue-200 px-5 py-4 rounded-2xl flex items-center gap-3">
          <i class="fas fa-info-circle text-blue-500 dark:text-blue-400 text-lg"></i>
          <span>{!! session('info') !!}</span>
        </div>
      @endif

      @if($siswa)
        {{-- Logged in view --}}
        <div class="max-w-2xl mx-auto bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-2xl shadow-emerald-500/30 text-center">
          <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5">
            <i class="fas fa-user-check"></i>
          </div>
          <h3 class="text-xl font-extrabold mb-2">Anda Sedang Login</h3>
          <p class="text-emerald-100 text-sm leading-relaxed mb-6 font-sans">
            Anda masuk sebagai <strong class="text-white font-bold">{{ $siswa->nama }}</strong> ({{ $siswa->no_wa }}).
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            @if($siswa->pendaftaran)
              <a href="{{ route('spmb.sukses', $siswa->pendaftaran->id) }}" class="bg-white text-emerald-700 font-bold py-3 px-6 rounded-xl text-sm hover:bg-slate-100 transition-colors inline-flex items-center gap-2 shadow-md">
                Lihat Bukti Pendaftaran <i class="fas fa-print"></i>
              </a>
            @else
              <a href="{{ route('spmb.formulir') }}" class="bg-white text-emerald-700 font-bold py-3 px-6 rounded-xl text-sm hover:bg-slate-100 transition-colors inline-flex items-center gap-2 shadow-md">
                Isi/Lanjutkan Formulir <i class="fas fa-arrow-right"></i>
              </a>
            @endif
            
            <form action="{{ route('spmb.logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl text-sm transition-colors inline-flex items-center gap-2 shadow-md">
                Keluar / Logout <i class="fas fa-sign-out-alt"></i>
              </button>
            </form>
          </div>
        </div>
      @else
        {{-- Guest view --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
          {{-- Buat Akun Baru --}}
          @if ($spmbContent->is_pendaftaran_open)
            <a href="{{ route('spmb.register') }}" id="btn-buat-akun"
               class="group bg-gradient-to-br from-primary to-orange-600 rounded-3xl p-8 text-white shadow-2xl shadow-primary/30 hover:scale-105 transition-all duration-300 text-center block">
              <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 group-hover:bg-white/30 transition-colors">
                <i class="fas fa-user-plus"></i>
              </div>
              <h3 class="text-xl font-extrabold mb-2">Buat Akun Baru</h3>
              <p class="text-orange-100 text-sm leading-relaxed font-sans">Belum punya akun? Daftar sekarang menggunakan nomor WhatsApp Anda.</p>
              <div class="mt-5 bg-white/20 rounded-xl py-2.5 px-4 text-sm font-bold inline-flex items-center gap-2 group-hover:bg-white/30 transition-colors">
                Mulai Daftar <i class="fas fa-arrow-right"></i>
              </div>
            </a>
          @else
            <div id="btn-buat-akun"
                 class="bg-slate-150 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700/60 rounded-3xl p-8 text-slate-400 dark:text-slate-500 text-center block shadow-sm relative overflow-hidden select-none">
              <div class="absolute inset-0 bg-slate-200/5 dark:bg-slate-900/5 backdrop-blur-[1px] z-10 pointer-events-none"></div>
              <div class="w-16 h-16 bg-slate-200 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 text-slate-300 dark:text-slate-600 relative z-20">
                <i class="fas fa-lock"></i>
              </div>
              <h3 class="text-xl font-extrabold mb-2 text-slate-500 dark:text-slate-400 relative z-20">Pendaftaran Ditutup</h3>
              <p class="text-slate-400 dark:text-slate-500 text-sm leading-relaxed relative z-20 font-sans">Registrasi akun baru saat ini sedang dinonaktifkan sementara.</p>
              <div class="mt-5 bg-slate-250 dark:bg-slate-800 border border-slate-300/40 dark:border-slate-700/40 rounded-xl py-2.5 px-4 text-sm font-bold inline-flex items-center gap-2 text-slate-400 dark:text-slate-500 relative z-20">
                Ditutup <i class="fas fa-ban text-xs"></i>
              </div>
            </div>
          @endif

          {{-- Sudah Punya Akun --}}
          <a href="{{ route('spmb.login') }}" id="btn-login-siswa"
             class="group bg-white dark:bg-white/10 backdrop-blur-sm border border-slate-200 dark:border-white/20 rounded-3xl p-8 text-slate-800 dark:text-white hover:bg-slate-50 dark:hover:bg-white/20 transition-all duration-300 text-center block shadow-lg dark:shadow-none">
            <div class="w-16 h-16 bg-slate-100 dark:bg-white/10 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 text-slate-700 dark:text-white group-hover:bg-slate-200 dark:group-hover:bg-white/20 transition-colors">
              <i class="fas fa-sign-in-alt"></i>
            </div>
            <h3 class="text-xl font-extrabold mb-2 text-slate-900 dark:text-white font-sans">Sudah Punya Akun?</h3>
            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed font-sans">Masuk dengan nomor WhatsApp dan password yang telah Anda buat.</p>
            <div class="mt-5 bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/20 rounded-xl py-2.5 px-4 text-sm font-bold inline-flex items-center gap-2 text-slate-700 dark:text-white group-hover:bg-slate-200 dark:group-hover:bg-white/20 transition-colors">
              Login Sekarang <i class="fas fa-arrow-right"></i>
            </div>
          </a>
        </div>
      @endif

      {{-- Tes Gaya Belajar Mandiri --}}
      <div class="mt-10 max-w-3xl mx-auto bg-white dark:bg-white/5 backdrop-blur-md border border-slate-200 dark:border-white/10 rounded-3xl overflow-hidden shadow-xl dark:shadow-2xl transition-all duration-300">
        <div class="flex flex-col md:flex-row items-stretch">
          {{-- Left: Icon & Info --}}
          <div class="bg-gradient-to-br from-indigo-600/90 to-purple-700/90 p-8 md:w-2/5 flex flex-col items-center justify-center text-center relative overflow-hidden">
            <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full pointer-events-none"></div>
            <div class="relative z-10">
              <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-white text-3xl mb-4 mx-auto backdrop-blur-sm shadow-lg">
                <i class="fas fa-brain"></i>
              </div>
              <h2 class="text-xl font-extrabold text-white mb-2">Tes Gaya Belajar</h2>
              <p class="text-indigo-200 text-xs leading-relaxed font-sans">
                Khusus untuk calon siswa yang berkasnya <strong class="text-white font-semibold">sudah diverifikasi</strong> oleh petugas.
              </p>
              <div class="flex gap-2 justify-center mt-5 flex-wrap">
                <span class="bg-blue-400/30 text-blue-100 text-xxs font-bold px-3 py-1 rounded-full border border-blue-300/40">
                  <i class="fas fa-eye mr-1"></i> Visual
                </span>
                <span class="bg-green-400/30 text-green-100 text-xxs font-bold px-3 py-1 rounded-full border border-green-300/40">
                  <i class="fas fa-headphones mr-1"></i> Auditori
                </span>
                <span class="bg-purple-400/30 text-purple-100 text-xxs font-bold px-3 py-1 rounded-full border border-purple-300/40">
                  <i class="fas fa-hand-paper mr-1"></i> Kinestetik
                </span>
              </div>
            </div>
          </div>
          {{-- Right: How to & CTA --}}
          <div class="p-8 md:w-3/5 flex flex-col justify-center space-y-5">
            <div>
              <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Sudah Diverifikasi?</h3>
              <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-light font-sans">
                Ikuti Tes Gaya Belajar Mandiri (VAK) untuk membantu sekolah memahami cara belajar terbaik Anda. Tes ini wajib diselesaikan setelah berkas pendaftaran terverifikasi.
              </p>
            </div>
            <div class="space-y-2.5">
              <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Cara masuk ke tes:</p>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-orange-600 dark:text-orange-400 text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                <p class="text-sm text-slate-600 dark:text-slate-300 font-sans">Klik tombol <strong class="text-slate-800 dark:text-white font-semibold">"Mulai Tes Gaya Belajar"</strong> di bawah ini</p>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-orange-600 dark:text-orange-400 text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                <p class="text-sm text-slate-600 dark:text-slate-300 font-sans">Masukkan <strong class="text-slate-800 dark:text-white font-semibold font-sans">Nomor Pendaftaran</strong> dan <strong class="text-slate-800 dark:text-white font-semibold font-sans">Tanggal Lahir</strong></p>
              </div>
            </div>
            <a href="{{ route('spmb.tes-gaya-belajar.login') }}"
               class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 text-sm">
              <i class="fas fa-brain text-xs"></i>
              Mulai Tes Gaya Belajar
            </a>
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