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
        <div class="swiper mySwiperHero w-full h-full">
            <div class="swiper-wrapper">
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
            </div>
            <div class="swiper-pagination !bottom-6 !top-auto !z-20"></div>
        </div>
    </section>

    <!-- Sambutan Kepala Sekolah -->
    <section id="profil" class="py-16 bg-white dark:bg-slate-800 fade-in-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-primary">Sambutan Kepala Sekolah</h2>
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-1/3 flex justify-center">
                    <img src="https://picsum.photos/id/1072/300/400" alt="Kepala Sekolah"
                        class="rounded-xl shadow-xl border-4 border-white dark:border-slate-700">
                </div>
                <div
                    class="md:w-2/3 bg-gradient-to-br from-orange-50 to-white dark:from-slate-800 dark:to-slate-900 p-6 rounded-2xl shadow-lg card-orange">
                    <p class="text-lg leading-relaxed text-justify">Assalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                    <p class="mt-4 text-justify">Puji syukur ke hadirat Allah SWT atas segala limpahan rahmat dan
                        karunia-Nya, sehingga website resmi SMK Muhammadiyah 1 Bantul dapat hadir sebagai sarana informasi
                        dan komunikasi yang transparan bagi seluruh pemangku kepentingan.</p>
                    <p class="mt-4 text-justify">Sebagai lembaga pendidikan vokasional di bawah naungan Muhammadiyah, kami
                        berkomitmen untuk mencetak lulusan yang tidak hanya unggul dalam kompetensi kejuruan, tetapi juga
                        berakhlak mulia, berjiwa wirausaha, dan siap bersaing di dunia kerja maupun industri 4.0.</p>
                    <p class="mt-4 text-justify">Melalui kolaborasi erat dengan mitra industri, kurikulum berbasis KKNI,
                        serta pembelajaran berbasis proyek, kami memastikan setiap siswa memperoleh pengalaman belajar yang
                        relevan dan aplikatif. Kami juga menanamkan nilai-nilai Al-Islam dan Kemuhammadiyahan sebagai
                        fondasi karakter.</p>
                    <p class="mt-4 text-justify">Website ini kami hadirkan sebagai wujud keterbukaan informasi—mulai dari
                        profil sekolah, program keahlian, kegiatan, prestasi, hingga layanan digital seperti PPDB online,
                        LMS, dan sistem PKL. Kami terbuka terhadap masukan dan kerja sama dari berbagai pihak untuk terus
                        meningkatkan kualitas pendidikan.</p>
                    <p class="mt-6 font-semibold">Wassalamu’alaikum Warahmatullahi Wabarakatuh.</p>
                    <p class="mt-4 font-bold">— Harimawan, S.Pd., M.Si.</p>
                    <p>Kepala Sekolah SMK Muhammadiyah 1 Bantul</p>
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
                <a href="#informasi" class="text-primary font-medium hover:underline">Lihat Semua</a>
            </div>
            <div class="swiper mySwiperBerita">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div
                            class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="https://picsum.photos/id/1035/400/200" alt="Berita 1"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">12 Mei 2025</span>
                                <h3 class="font-bold mt-2 text-lg">Siswa SMK Juara Lomba Robotik Nasional</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">Tim robotik SMK Muhammadiyah 1
                                    Bantul meraih juara 1 dalam ajang bergengsi tingkat nasional.</p>
                            </div>
                            <div class="px-5 pb-5">
                                <a href="#informasi"
                                    class="inline-block text-primary font-semibold text-sm hover:underline">Selengkapnya
                                    →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="https://picsum.photos/id/1038/400/200" alt="Berita 2"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">10 Mei 2025</span>
                                <h3 class="font-bold mt-2 text-lg">Workshop Industri 4.0</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">Kerja sama dengan PT XYZ untuk
                                    pelatihan IoT dan smart manufacturing bagi siswa kelas XII.</p>
                            </div>
                            <div class="px-5 pb-5">
                                <a href="#informasi"
                                    class="inline-block text-primary font-semibold text-sm hover:underline">Selengkapnya
                                    →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="https://picsum.photos/id/1039/400/200" alt="Berita 3"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">8 Mei 2025</span>
                                <h3 class="font-bold mt-2 text-lg">PPDB 2025 Dibuka!</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">Pendaftaran siswa baru tahun
                                    ajaran 2025/2026 telah resmi dibuka. Daftar sekarang!</p>
                            </div>
                            <div class="px-5 pb-5">
                                <a href="#informasi"
                                    class="inline-block text-primary font-semibold text-sm hover:underline">Selengkapnya
                                    →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="https://picsum.photos/id/1038/400/200" alt="Berita 4"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">5 Mei 2025</span>
                                <h3 class="font-bold mt-2 text-lg">Pelatihan Guru Produktif</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">Guru-guru kejuruan mengikuti
                                    pelatihan peningkatan kompetensi dari Dinas Pendidikan DIY.</p>
                            </div>
                            <div class="px-5 pb-5">
                                <a href="#informasi"
                                    class="inline-block text-primary font-semibold text-sm hover:underline">Selengkapnya
                                    →</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div
                            class="card-gradient rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition h-full flex flex-col">
                            <img src="https://picsum.photos/id/1072/400/200" alt="Berita 5"
                                class="w-full h-48 object-cover">
                            <div class="p-5 flex-grow">
                                <span class="text-sm text-orange-600 font-medium">2 Mei 2025</span>
                                <h3 class="font-bold mt-2 text-lg">Kunjungan Industri ke PT Astra</h3>
                                <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">Siswa jurusan TPM dan TKR
                                    mengikuti kunjungan industri ke pabrik PT Astra International.</p>
                            </div>
                            <div class="px-5 pb-5">
                                <a href="#informasi"
                                    class="inline-block text-primary font-semibold text-sm hover:underline">Selengkapnya
                                    →</a>
                            </div>
                        </div>
                    </div>
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
            <a href="#informasi" class="text-primary font-medium hover:underline flex items-center gap-1">
                Lihat Semua
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <div class="swiper mySwiperPrestasi">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <!-- Kotak foto di tengah -->
                        <div class="flex justify-center mb-5">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-primary/20 shadow-md">
                                <img 
                                    src="https://via.placeholder.com/150x150?text=Siswa+1" 
                                    alt="Siswa Juara 1 Robotik" 
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="text-primary font-bold text-lg">Juara 1</div>
                        <p class="font-semibold mt-2">Lomba Robotik Nasional 2025</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Tim SMK Muhammadiyah 1 Bantul</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-center mb-5">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-secondary/20 shadow-md">
                                <img 
                                    src="https://via.placeholder.com/150x150?text=Siswa+2" 
                                    alt="Siswa Juara 2 Olimpiade" 
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="text-primary font-bold text-lg">Juara 2</div>
                        <p class="font-semibold mt-2">Olimpiade Teknologi DIY</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Bidang Rekayasa Perangkat Lunak</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-center mb-5">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-orange-400/20 shadow-md">
                                <img 
                                    src="https://via.placeholder.com/150x150?text=Inovator" 
                                    alt="Siswa Inovasi Otomotif" 
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="text-primary font-bold text-lg">Terbaik</div>
                        <p class="font-semibold mt-2">Inovasi Otomotif 2025</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Kategori Mobil Listrik Hemat</p>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="swiper-slide">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <div class="flex justify-center mb-5">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-green-500/20 shadow-md">
                                <img 
                                    src="https://via.placeholder.com/150x150?text=Tim+Lulusan" 
                                    alt="Tim Lulusan Terserap" 
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>
                        <div class="text-primary font-bold text-lg">100%</div>
                        <p class="font-semibold mt-2">Penyerapan Lulusan</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Tahun Ajaran 2024/2025</p>
                    </div>
                </div>
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
            <h2 class="text-3xl font-bold text-center mb-12 text-primary">Testimoni Alumni</h2>
            <div class="swiper mySwiperTestimoni">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl p-6 shadow-lg text-center">
                            <img src="https://picsum.photos/id/1005/100/100" alt="Alumni 1"
                                class="w-16 h-16 rounded-full mx-auto mb-4 border-2 border-orange-200 dark:border-slate-600">
                            <p class="italic text-slate-700 dark:text-slate-300 mb-4">"Ilmu dan keterampilan yang saya
                                dapat di SMK Muhammadiyah 1 Bantul langsung saya terapkan di tempat kerja. Alhamdulillah,
                                sekarang saya jadi teknisi senior di bengkel ternama."</p>
                            <h4 class="font-bold text-primary">— Dwi Prasetyo</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Alumni TKR 2020 • Teknisi di Auto2000</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl p-6 shadow-lg text-center">
                            <img src="https://picsum.photos/id/1011/100/100" alt="Alumni 2"
                                class="w-16 h-16 rounded-full mx-auto mb-4 border-2 border-orange-200 dark:border-slate-600">
                            <p class="italic text-slate-700 dark:text-slate-300 mb-4">"Jurusan RPL membuka jalan karier
                                saya di dunia IT. Guru-gurunya sangat mendukung, dan fasilitas lab-nya lengkap. Sekarang
                                saya kerja remote sebagai web developer!"</p>
                            <h4 class="font-bold text-primary">— Siti Rahayu</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Alumni RPL 2021 • Web Developer di
                                Startup Yogyakarta</p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl p-6 shadow-lg text-center">
                            <img src="https://picsum.photos/id/1020/100/100" alt="Alumni 3"
                                class="w-16 h-16 rounded-full mx-auto mb-4 border-2 border-orange-200 dark:border-slate-600">
                            <p class="italic text-slate-700 dark:text-slate-300 mb-4">"PKL di industri mitra benar-benar
                                membekali saya. Setelah lulus, langsung direkrut! Terima kasih SMK Muhammadiyah 1 Bantul."
                            </p>
                            <h4 class="font-bold text-primary">— Budi Santoso</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Alumni TPM 2022 • Operator CNC di PT XYZ
                            </p>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="card-gradient rounded-2xl p-6 shadow-lg text-center">
                            <img src="https://picsum.photos/id/1030/100/100" alt="Alumni 4"
                                class="w-16 h-16 rounded-full mx-auto mb-4 border-2 border-orange-200 dark:border-slate-600">
                            <p class="italic text-slate-700 dark:text-slate-300 mb-4">"Nilai Islami yang ditanamkan di
                                sekolah membuat saya tetap istiqomah meski kerja di lingkungan yang menantang. Sangat
                                bersyukur pernah sekolah di sini."</p>
                            <h4 class="font-bold text-primary">— Anisa Fitriani</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Alumni TAV 2019 • Teknisi Audio di Studio
                                Rekaman</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination !bottom-0"></div>
            </div>
        </div>
    </section>

    <!-- Logo Mitra Industri - Marquee -->
<section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-8 text-primary">Mitra Industri</h2>
        <div class="relative">
            <div class="flex whitespace-nowrap animate-marquee">
                <!-- Ulangi logo 2x untuk efek seamless loop -->
                @php
                    $logos = [
                        'https://upload.wikimedia.org/wikipedia/commons/9/96/Logo_Telkom_Indonesia.svg',
                        'https://upload.wikimedia.org/wikipedia/commons/e/e4/Honda_logo.svg',
                        'https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_Garuda_Indonesia.svg',
                        'https://upload.wikimedia.org/wikipedia/commons/2/2f/Logo_PT_Astra_International_Tbk.svg',
                        'https://upload.wikimedia.org/wikipedia/commons/6/69/Gojek_logo_2019.svg',
                        'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f2/Xi%27an_Jiaotong-Liverpool_University_Logo.svg/800px-Xi%27an_Jiaotong-Liverpool_University_Logo.svg.png',
                        'https://upload.wikimedia.org/wikipedia/commons/d/d4/Microsoft_logo.svg',
                    ];
                @endphp

                @foreach(array_merge($logos, $logos) as $logo)
                    <div class="flex items-center mx-6">
                        <img src="{{ $logo }}" alt="Mitra" class="h-10 md:h-12 grayscale hover:grayscale-0 transition-all duration-300">
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
