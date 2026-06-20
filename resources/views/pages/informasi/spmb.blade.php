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
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/spmb-hero/1920/600" alt="SPMB SMK Muhammadiyah 1 Bantul" class="w-full h-full object-cover">
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-2">SPMB 2026/2027</h1>
      <p class="text-lg md:text-xl">Seleksi Penerimaan Peserta Didik Baru</p>
    </div>
  </section>

  <!-- Tes Gaya Belajar Mandiri -->
  <section class="py-14 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-950 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-indigo-100 dark:border-slate-700 overflow-hidden">
        <div class="flex flex-col md:flex-row items-stretch">

          {{-- Left: Icon & Info --}}
          <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-8 md:w-2/5 flex flex-col items-center justify-center text-center relative overflow-hidden">
            <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full pointer-events-none"></div>
            <div class="relative">
              <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center text-white text-4xl mb-5 mx-auto backdrop-blur-sm shadow-lg">
                <i class="fas fa-brain"></i>
              </div>
              <h2 class="text-xl font-extrabold text-white mb-2">Tes Gaya Belajar</h2>
              <p class="text-indigo-200 text-xs leading-relaxed">
                Khusus untuk calon siswa yang berkasnya <strong class="text-white">sudah diverifikasi</strong> oleh petugas.
              </p>
              {{-- VAK Badges --}}
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
              <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Sudah Diverifikasi?</h3>
              <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                Ikuti Tes Gaya Belajar Mandiri (VAK) untuk membantu sekolah memahami cara belajar terbaik Anda. Tes ini wajib diselesaikan setelah berkas pendaftaran terverifikasi.
              </p>
            </div>

            {{-- Cara Login --}}
            <div class="space-y-2.5">
              <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Cara masuk ke tes:</p>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                <p class="text-sm text-slate-600 dark:text-slate-400">Klik tombol <strong class="text-slate-700 dark:text-slate-300">"Mulai Tes Gaya Belajar"</strong> di bawah ini</p>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                <p class="text-sm text-slate-600 dark:text-slate-400">Masukkan <strong class="text-slate-700 dark:text-slate-300">Nomor Pendaftaran</strong> dan <strong class="text-slate-700 dark:text-slate-300">Tanggal Lahir</strong></p>
              </div>
              <div class="flex items-start gap-3">
                <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400 text-xs font-bold flex-shrink-0 mt-0.5">3</div>
                <p class="text-sm text-slate-600 dark:text-slate-400">Jawab 6 pertanyaan dan isi minat bakat, lalu kirim hasilnya</p>
              </div>
            </div>

            {{-- CTA Button --}}
            <a href="{{ route('spmb.tes-gaya-belajar.login') }}"
               class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 text-sm">
              <i class="fas fa-brain"></i>
              Mulai Tes Gaya Belajar
              <i class="fas fa-arrow-right text-xs opacity-70"></i>
            </a>
            <p class="text-xxs text-slate-400 dark:text-slate-500">
              <i class="fas fa-shield-alt mr-1"></i>
              Hanya bisa diakses jika berkas Anda sudah diverifikasi petugas.
            </p>
          </div>

        </div>
      </div>
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
        <p class="text-2xl font-extrabold mt-2 text-slate-800">5 Kelas</p>
      </div>

      <!-- TBSM -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);">
        <h3 class="font-bold text-primary">TBSM</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">3 Kelas</p>
      </div>

      <!-- TPM -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);">
        <h3 class="font-bold text-primary">TPM</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">3 Kelas</p>
      </div>

      <!-- TAV -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #d7bde2 0%, #f5b7b1 100%);">
        <h3 class="font-bold text-primary">TAV</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">2 Kelas</p>
      </div>

      <!-- RPL -->
      <div class="kuota-card rounded-xl p-5 text-center transition-all duration-300 hover:scale-105 hover:shadow-xl"
           style="background: linear-gradient(135deg, #c3cfe2 0%, #a29bfe 100%);">
        <h3 class="font-bold text-primary">RPL</h3>
        <p class="text-2xl font-extrabold mt-2 text-slate-800">3 Kelas</p>
      </div>
    </div>
  </div>
</section>

  <!-- Alur Pendaftaran -->
  <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-8 text-center">Alur Pendaftaran</h2>
      <div class="space-y-6">
        <div class="step-card">
          <div class="step-number">1</div>
          <div>
            <h3 class="font-bold text-lg">Daftar Online</h3>
            <p class="text-slate-600 dark:text-slate-400">Kunjungi portal PPDB resmi dan lengkapi formulir pendaftaran.</p>
          </div>
        </div>
        <div class="step-card">
          <div class="step-number">2</div>
          <div>
            <h3 class="font-bold text-lg">Upload Berkas</h3>
            <p class="text-slate-600 dark:text-slate-400">Unggah scan rapor kelas VII–IX, akta kelahiran, dan KK.</p>
          </div>
        </div>
        <div class="step-card">
          <div class="step-number">3</div>
          <div>
            <h3 class="font-bold text-lg">Verifikasi Berkas</h3>
            <p class="text-slate-600 dark:text-slate-400">Tunggu proses verifikasi dan validasi berkas oleh petugas admin sekolah.</p>
          </div>
        </div>
        <div class="step-card">
          <div class="step-number">4</div>
          <div>
            <h3 class="font-bold text-lg">Seleksi & Pengumuman</h3>
            <p class="text-slate-600 dark:text-slate-400">Hasil seleksi diumumkan melalui website dan SMS.</p>
          </div>
        </div>
        <div class="step-card">
          <div class="step-number">5</div>
          <div>
            <h3 class="font-bold text-lg">Daftar Ulang</h3>
            <p class="text-slate-600 dark:text-slate-400">Lakukan daftar ulang dengan membawa berkas asli.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Persyaratan -->
  <section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-6 text-center">Persyaratan Pendaftaran</h2>
      <ul class="list-disc pl-6 space-y-2 text-slate-700 dark:text-slate-300">
        <li>Lulus SMP/MTs atau sederajat (tahun 2023–2025)</li>
        <li>Usia maksimal 21 tahun pada 1 Juli 2025</li>
        <li>Rapor kelas VII–IX (semester 1–5)</li>
        <li>Akta kelahiran</li>
        <li>Kartu Keluarga (KK)</li>
        <li>Foto berwarna 3x4 (2 lembar)</li>
        <li>Tidak buta warna (khusus TKRO, TBSM, TPM)</li>
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
        <img src="https://picsum.photos/seed/spmb1/400/300" alt="Pendaftaran SPMB" class="gallery-img w-full h-48 object-cover shadow-md">
        <img src="https://picsum.photos/seed/spmb2/400/300" alt="Verifikasi Berkas" class="gallery-img w-full h-48 object-cover shadow-md">
        <img src="https://picsum.photos/seed/spmb3/400/300" alt="Sosialisasi Jurusan" class="gallery-img w-full h-48 object-cover shadow-md">
        <img src="https://picsum.photos/seed/spmb4/400/300" alt="Pengumuman Kelulusan" class="gallery-img w-full h-48 object-cover shadow-md">
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-12 bg-gradient-to-r from-primary to-secondary text-white fade-in-scroll">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h2 class="text-2xl md:text-3xl font-bold mb-4">Siap Bergabung?</h2>
      <p class="mb-6 text-lg opacity-90">Daftar sekarang dan dapatkan bonus eksklusif untuk pendaftar awal!</p>
      <a 
        href="{{ route('spmb.daftar') }}" 
        class="inline-block bg-white text-primary font-bold py-3 px-8 rounded-full text-lg shadow-lg hover:bg-slate-100 transition-all duration-300"
      >
        <i class="fas fa-user-plus mr-2"></i> Daftar Sekarang
      </a>
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