@extends('layouts.app')
@section('title', 'Beranda')

@section('style')
    @parent
    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
            width: 200%;
            display: flex;
            justify-content: space-around;
        }

        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>

    <style>
        /* Hero teks animasi */
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.8s forwards;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.4s;
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

        .card-orange {
            background: linear-gradient(135deg, #fff5eb 0%, #fffcf8 100%);
            border-left: 4px solid #f97316;
        }

        .dark .card-orange {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-left: 4px solid #f97316;
        }

        .card-orange p {
            margin-top: 1rem;
            text-align: justify;
        }

        .card-orange p:first-child {
            margin-top: 0;
        }

        /* Swiper */
        .swiper-button-next,
        .swiper-button-prev {
            color: white !important;
        }

        .dark .swiper-button-next,
        .dark .swiper-button-prev {
            color: #f97316 !important;
        }

        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5) !important;
        }

        .swiper-pagination-bullet-active {
            background: white !important;
        }

        .dark .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.3) !important;
        }

        .dark .swiper-pagination-bullet-active {
            background: #f97316 !important;
        }

        /* Fixed toggle button */
        #theme-toggle-btn {
            position: fixed;
            bottom: 20px;
            right: 0%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: #f97316;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s, background-color 0.2s;
        }

        #theme-toggle-btn:hover {
            transform: translateX(-50%) scale(1.1);
            background-color: #ea580c;
        }
    </style>
@endsection
@section('content')
    <!-- Hero Carousel -->
    <section id="home" class="relative h-[80vh] overflow-hidden">
        @auth
            <div class="absolute top-6 right-6 z-[999]">
                <a href="{{ route('admin.hero.index') }}" class="bg-primary hover:bg-secondary text-white text-sm font-semibold px-5 py-3 rounded-full shadow-lg flex items-center gap-2 transition transform hover:scale-105">
                    <i class="fas fa-edit"></i> Edit Slideshow Hero
                </a>
            </div>
        @endauth

        <div class="swiper mySwiperHero w-full h-full">
            <div class="swiper-wrapper">
                @forelse($heroes as $item)
                    <div class="swiper-slide relative">
                        <img src="{{ $item->gambar_src }}" alt="{{ $item->judul }}"
                            class="w-full h-full object-cover brightness-75">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
                        <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white max-w-2xl">
                            <h1 class="text-3xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6 animate-fade-in-up">{{ $item->judul }}</h1>
                            @if($item->deskripsi)
                                <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6 animate-fade-in-up delay-200">{{ $item->deskripsi }}</p>
                            @endif
                            @if($item->label_tombol)
                                <a href="{{ $item->link_tombol }}"
                                    class="inline-block bg-white text-primary hover:bg-slate-100 font-bold py-3 px-8 rounded-full transition transform hover:scale-105 opacity-0 translate-y-6 animate-fade-in-up delay-300">{{ $item->label_tombol }}</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide relative">
                        <img src="https://picsum.photos/id/1031/1920/1080" alt="Siswa Praktik Otomotif"
                            class="w-full h-full object-cover brightness-75">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
                        <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white max-w-2xl">
                            <h1 class="text-3xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6 animate-fade-in-up">Belajar
                                dengan Praktik Nyata</h1>
                            <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6 animate-fade-in-up delay-200">Siswa SMK
                                Muhammadiyah 1 Bantul mengasah keterampilan di bengkel otomotif industri.</p>
                            <a href="#informasi"
                                class="inline-block bg-white text-primary hover:bg-slate-100 font-bold py-3 px-8 rounded-full transition transform hover:scale-105 opacity-0 translate-y-6 animate-fade-in-up delay-300">Daftar
                                Sekarang</a>
                        </div>
                    </div>
                    <div class="swiper-slide relative">
                        <img src="https://picsum.photos/id/1032/1920/1080" alt="Siswa Kelas IT"
                            class="w-full h-full object-cover brightness-75">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
                        <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white max-w-2xl">
                            <h1 class="text-3xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6 animate-fade-in-up">Siap
                                Kerja di Era Digital</h1>
                            <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6 animate-fade-in-up delay-200">Program
                                Keahlian Rekayasa Perangkat Lunak mencetak developer handal.</p>
                            <a href="#rpl"
                                class="inline-block bg-white text-primary hover:bg-slate-100 font-bold py-3 px-8 rounded-full transition transform hover:scale-105 opacity-0 translate-y-6 animate-fade-in-up delay-300">Lihat
                                Jurusan</a>
                        </div>
                    </div>
                    <div class="swiper-slide relative">
                        <img src="https://picsum.photos/id/1033/1920/1080" alt="Siswa Juara Lomba"
                            class="w-full h-full object-cover brightness-75">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
                        <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white max-w-2xl">
                            <h1 class="text-3xl md:text-5xl font-bold mb-4 opacity-0 translate-y-6 animate-fade-in-up">Prestasi
                                yang Menginspirasi</h1>
                            <p class="text-lg md:text-xl mb-6 opacity-0 translate-y-6 animate-fade-in-up delay-200">Juara 1
                                Lomba Robotik Nasional 2025 oleh siswa SMK Muhammadiyah 1 Bantul.</p>
                            <a href="#informasi"
                                class="inline-block bg-white text-primary hover:bg-slate-100 font-bold py-3 px-8 rounded-full transition transform hover:scale-105 opacity-0 translate-y-6 animate-fade-in-up delay-300">Lihat
                                Prestasi</a>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination !bottom-6 !top-auto !z-20"></div>
        </div>
    </section>

    <!-- Sambutan Kepala Sekolah -->
    <section id="profil" class="py-16 bg-white dark:bg-slate-800 fade-in-scroll relative">
        @auth
            <div class="absolute top-6 right-6 z-10">
                <a href="{{ route('admin.sambutan.edit') }}" class="bg-primary hover:bg-secondary text-white text-xs font-semibold px-4 py-2.5 rounded-full shadow-md flex items-center gap-2 transition transform hover:scale-105">
                    <i class="fas fa-edit"></i> Edit Sambutan
                </a>
            </div>
        @endauth
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-primary">Sambutan Kepala Sekolah</h2>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/3 flex justify-center">
                    <img src="{{ $sambutan->foto_src }}" alt="Kepala Sekolah"
                        class="rounded-xl shadow-xl border-4 border-white dark:border-slate-700 w-full max-w-[280px] h-auto object-cover aspect-[3/4]">
                </div>
                <div
                    class="md:w-2/3 bg-gradient-to-br from-orange-50 to-white dark:from-slate-800 dark:to-slate-900 p-6 rounded-2xl shadow-lg card-orange">
                    {!! $sambutan->isi_sambutan !!}
                    <div class="mt-6 border-t border-orange-100/50 dark:border-slate-700 pt-4">
                        <p class="font-bold">— {{ $sambutan->nama_kepala }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $sambutan->gelar_kepala }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profil Sekolah -->
    <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-primary">Profil Sekolah</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card-gradient rounded-2xl p-6 shadow-lg">
                    <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-primary mb-3">Visi</h3>
                    <p class="text-slate-700 dark:text-slate-300">Menjadi SMK unggul berbasis teknologi dan berakhlak mulia.
                    </p>
                </div>
                <div class="card-gradient rounded-2xl p-6 shadow-lg">
                    <div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-primary mb-3">Misi</h3>
                    <ul class="list-disc pl-5 space-y-1 text-slate-700 dark:text-slate-300">
                        <li>Mengembangkan kompetensi kejuruan</li>
                        <li>Menanamkan nilai Islami</li>
                        <li>Menjalin kemitraan industri</li>
                    </ul>
                </div>
                <div class="card-gradient rounded-2xl p-6 shadow-lg">
                    <div class="w-12 h-12 rounded-full bg-orange-400 flex items-center justify-center text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-primary mb-3">Fasilitas</h3>
                    <p class="text-slate-700 dark:text-slate-300">Laboratorium, Bengkel, Perpustakaan Digital, dan Ruang
                        Kelas Ber-AC.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Berita Terbaru -->
    <section class="py-16 bg-white dark:bg-slate-800 fade-in-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-primary">Berita Terbaru</h2>
                @auth
                    <a href="{{ route('admin.berita.index') }}" class="text-primary font-medium hover:underline flex items-center gap-1"><i class="fas fa-edit text-xs"></i> Kelola Berita</a>
                @else
                    <a href="/informasi/berita" class="text-primary font-medium hover:underline">Lihat Semua</a>
                @endauth
            </div>
            <div class="swiper mySwiperBerita">
                <div class="swiper-wrapper">
                    @forelse($beritas as $berita)
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="{{ $berita->gambar_src }}" alt="{{ $berita->judul }}"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">{{ $berita->tanggal->translatedFormat('d F Y') }}</span>
                                <h3 class="font-bold mt-2 text-lg">{{ $berita->judul }}</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">{{ $berita->ringkasan }}</p>
                            </div>
                            <div class="px-5 pb-5">
                                <a href="/informasi/berita/{{ $berita->slug }}" class="inline-block text-primary font-semibold text-sm hover:underline">Selengkapnya →</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="https://picsum.photos/id/1035/400/200" alt="Berita"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">Belum ada berita</span>
                                <h3 class="font-bold mt-2 text-lg">Tambahkan Berita Pertama</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">Belum ada berita yang dipublikasikan. Silakan tambahkan melalui panel admin.</p>
                            </div>
                            <div class="px-5 pb-5">
                                @auth
                                    <a href="{{ route('admin.berita.create') }}" class="inline-block text-primary font-semibold text-sm hover:underline">+ Tambah Berita</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Prestasi Terbaru -->
<section class="py-16 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-bold text-primary">Prestasi Terbaru</h2>
            @auth
                <a href="{{ route('admin.prestasi.index') }}" class="text-primary font-medium hover:underline flex items-center gap-1"><i class="fas fa-edit text-xs"></i> Kelola Prestasi</a>
            @else
                <a href="/informasi/prestasi" class="text-primary font-medium hover:underline flex items-center gap-1">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @endauth
        </div>

        <div class="swiper mySwiperPrestasi">
            <div class="swiper-wrapper">
                @forelse($prestasis as $prestasi)
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-center mb-5">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-primary/20 shadow-md">
                                <img
                                    src="{{ $prestasi->foto_src }}"
                                    alt="{{ $prestasi->peraih }}"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="text-primary font-bold text-lg">{{ $prestasi->kategori }}</div>
                        <p class="font-semibold mt-2">{{ $prestasi->judul }}</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ $prestasi->peraih }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $prestasi->tingkat }}</p>
                    </div>
                </div>
                @empty
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg">
                        <div class="flex justify-center mb-5">
                            <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center border-4 border-primary/20">
                                <i class="fas fa-trophy text-3xl text-slate-300"></i>
                            </div>
                        </div>
                        <div class="text-slate-400 font-bold text-lg">Belum ada prestasi</div>
                        <p class="text-sm text-slate-500 mt-2">Tambahkan data prestasi melalui panel admin</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="swiper-pagination !mt-8"></div>
        </div>
    </div>
</section>

    <!-- Video Profil Sekolah -->
    <section class="py-16 bg-white dark:bg-slate-800 fade-in-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-primary">Video Profil Sekolah</h2>
            <div class="flex justify-center">
                <div class="relative w-full max-w-4xl">


                    <iframe class="w-full h-64 md:h-96 rounded-2xl shadow-xl"
                        src="https://www.youtube.com/embed/9c0dJnFd8RY" title="PROFIL SMK MUHAMMADIYAH 1 BANTUL"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>


                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-2xl pointer-events-none">
                    </div>
                </div>
            </div>
            <p class="text-center mt-6 text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                Simak perjalanan, fasilitas, kegiatan, dan prestasi kami dalam video profil resmi SMK Muhammadiyah 1 Bantul.
            </p>
        </div>
    </section>

    <!-- Testimoni Alumni -->
    <section class="py-16 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-primary">Testimoni Alumni</h2>
                @auth
                    <a href="{{ route('admin.testimoni.index') }}" class="text-primary font-medium hover:underline flex items-center gap-1"><i class="fas fa-edit text-xs"></i> Kelola Testimoni</a>
                @endauth
            </div>
            <div class="swiper mySwiperTestimoni">
                <div class="swiper-wrapper">
                    @forelse($testimonis as $testimoni)
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl p-6 shadow-lg text-center">
                            <img src="{{ $testimoni->foto_src }}" alt="{{ $testimoni->nama }}"
                                class="w-16 h-16 rounded-full mx-auto mb-4 border-2 border-orange-200 dark:border-slate-600 object-cover">
                            <p class="italic text-slate-700 dark:text-slate-300 mb-4">"{{ $testimoni->kutipan }}"</p>
                            <h4 class="font-bold text-primary">— {{ $testimoni->nama }}</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Alumni {{ $testimoni->alumni_tahun }} • {{ $testimoni->pekerjaan }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl p-6 shadow-lg text-center">
                            <div class="w-16 h-16 rounded-full mx-auto mb-4 bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                                <i class="fas fa-user text-2xl text-slate-300"></i>
                            </div>
                            <p class="italic text-slate-500 mb-4">"Belum ada testimoni alumni."</p>
                            <h4 class="font-bold text-slate-400">— Alumni</h4>
                            @auth
                                <a href="{{ route('admin.testimoni.create') }}" class="text-sm text-primary hover:underline mt-2 block">+ Tambah Testimoni</a>
                            @endauth
                        </div>
                    </div>
                    @endforelse
                </div>
                <div class="swiper-pagination !bottom-0"></div>
            </div>
        </div>
    </section>

    <!-- Logo Mitra Industri - Marquee -->
<section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll overflow-hidden relative">
    @auth
        <div class="absolute top-4 right-6 z-10">
            <a href="{{ route('admin.mitra.index') }}" class="bg-primary hover:bg-secondary text-white text-xs font-semibold px-4 py-2.5 rounded-full shadow-md flex items-center gap-2 transition transform hover:scale-105">
                <i class="fas fa-edit"></i> Edit Mitra
            </a>
        </div>
    @endauth
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-8 text-primary">Mitra Industri</h2>
        <div class="relative">
            <div class="flex whitespace-nowrap animate-marquee">
                <!-- Ulangi logo 2x untuk efek seamless loop -->
                @php
                    $logos = [];
                    if ($mitras->isNotEmpty()) {
                        foreach ($mitras as $mitra) {
                            $logos[] = [
                                'src' => $mitra->logo_src,
                                'nama' => $mitra->nama,
                                'link' => $mitra->link
                            ];
                        }
                    } else {
                        $logos = [
                            ['src' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Logo_Telkom_Indonesia.svg', 'nama' => 'Telkom Indonesia', 'link' => '#'],
                            ['src' => 'https://upload.wikimedia.org/wikipedia/commons/e/e4/Honda_logo.svg', 'nama' => 'Honda', 'link' => '#'],
                            ['src' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_Garuda_Indonesia.svg', 'nama' => 'Garuda Indonesia', 'link' => '#'],
                            ['src' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_PT_Astra_International_Tbk.svg', 'nama' => 'Astra International', 'link' => '#'],
                            ['src' => 'https://upload.wikimedia.org/wikipedia/commons/6/69/Gojek_logo_2019.svg', 'nama' => 'Gojek', 'link' => '#'],
                            ['src' => 'https://upload.wikimedia.org/wikipedia/commons/d/d4/Microsoft_logo.svg', 'nama' => 'Microsoft', 'link' => '#'],
                        ];
                    }
                    $displayLogos = array_merge($logos, $logos);
                @endphp

                @foreach($displayLogos as $logo)
                    <div class="flex items-center mx-6">
                        @if($logo['link'] && $logo['link'] !== '#')
                            <a href="{{ $logo['link'] }}" target="_blank" title="{{ $logo['nama'] }}" class="block">
                                <img src="{{ $logo['src'] }}" alt="{{ $logo['nama'] }}" class="h-10 md:h-12 grayscale hover:grayscale-0 transition-all duration-300">
                            </a>
                        @else
                            <img src="{{ $logo['src'] }}" alt="{{ $logo['nama'] }}" title="{{ $logo['nama'] }}" class="h-10 md:h-12 grayscale hover:grayscale-0 transition-all duration-300">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script>
        // Hero Carousel
        const heroSwiper = new Swiper('.mySwiperHero', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            on: {
                init: () => triggerAnimations(),
                slideChange: () => triggerAnimations()
            }
        });

        function triggerAnimations() {
            document.querySelectorAll('.animate-fade-in-up').forEach(el => {
                el.style.animation = 'none';
                void el.offsetWidth;
                el.style.animation = null;
            });
        }

        // Berita & Prestasi Carousel
        new Swiper('.mySwiperBerita', {
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                640: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });

        new Swiper('.mySwiperTestimoni', {
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            breakpoints: {
                640: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });

        new Swiper('.mySwiperPrestasi', {
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                640: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 4
                }
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            }
        });

        // Toggle mobile main menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Toggle dropdowns di mobile
        const dropdowns = [{
                btn: 'mobile-profil-btn',
                content: 'mobile-profil',
                icon: 'mobile-profil-icon'
            },
            {
                btn: 'mobile-program-btn',
                content: 'mobile-program',
                icon: 'mobile-program-icon'
            },
            {
                btn: 'mobile-layanan-btn',
                content: 'mobile-layanan',
                icon: 'mobile-layanan-icon'
            },
            {
                btn: 'mobile-galeri-btn',
                content: 'mobile-galeri',
                icon: 'mobile-galeri-icon'
            },
            {
                btn: 'mobile-informasi-btn',
                content: 'mobile-informasi',
                icon: 'mobile-informasi-icon'
            }
        ];

        dropdowns.forEach(({
            btn,
            content,
            icon
        }) => {
            document.getElementById(btn).addEventListener('click', function() {
                const contentEl = document.getElementById(content);
                const iconEl = document.getElementById(icon);
                contentEl.classList.toggle('hidden');
                iconEl.classList.toggle('rotate-180');
            });
        });

        // Scroll Animation
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
    </script>
@endsection
