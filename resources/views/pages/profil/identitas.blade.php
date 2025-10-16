@extends('layouts.app')
@section('title', 'Profil Sekolah - SMK Muhammadiyah 1 Bantul')

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
</style>
@endsection

@section('content')
  <!-- Hero Section -->
  <section class="relative h-[40vh] overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/profil-hero/1920/600" alt="Profil Sekolah SMK Muhammadiyah 1 Bantul" class="w-full h-full object-cover">
    <div class="absolute top-1/2 left-8 md:left-16 transform -translate-y-1/2 text-white z-20">
      <h1 class="text-3xl md:text-5xl font-bold mb-2">Profil Sekolah</h1>
      <p class="text-lg md:text-xl">Identitas dan Gambaran Umum SMK Muhammadiyah 1 Bantul</p>
    </div>
  </section>

  <!-- Identitas Sekolah -->
  <section class="py-12 bg-white dark:bg-slate-800 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-6 text-center">Identitas Sekolah</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="space-y-4">
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Nama Sekolah</span>
            <span>: SMK Muhammadiyah 1 Bantul</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">NPSN</span>
            <span>: 20404001</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Status</span>
            <span>: Swasta (Muhammadiyah)</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Akreditasi</span>
            <span>: A (Unggul)</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Kurikulum</span>
            <span>: Kurikulum Merdeka & KKNI</span>
          </div>
        </div>
        <div class="space-y-4">
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Alamat</span>
            <span>: Jl. Parangtritis Km. 11, Bantul, Yogyakarta</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Telepon</span>
            <span>: (0274) 123456</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Email</span>
            <span>: info@smkmuh1bantul.sch.id</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Website</span>
            <span>: www.smkmuh1bantul.sch.id</span>
          </div>
          <div class="flex">
            <span class="font-semibold w-48 text-slate-700 dark:text-slate-300">Tahun Berdiri</span>
            <span>: 1995</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gambaran Umum -->
  <section class="py-12 bg-slate-100 dark:bg-slate-800/50 fade-in-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-2xl font-bold text-primary mb-6 text-center">Gambaran Umum</h2>

      <div class="card-gradient rounded-2xl p-6">
        <h3 class="text-xl font-bold text-primary mb-3">Tentang SMK Muhammadiyah 1 Bantul</h3>
        <p class="text-slate-700 dark:text-slate-300 mb-4">
          SMK Muhammadiyah 1 Bantul merupakan lembaga pendidikan kejuruan yang berada di bawah naungan Persyarikatan Muhammadiyah. Sejak berdiri pada tahun 1995, sekolah ini konsisten mencetak lulusan yang tidak hanya unggul dalam keterampilan teknis, tetapi juga memiliki akhlak mulia dan jiwa kepemimpinan.
        </p>
        <p class="text-slate-700 dark:text-slate-300 mb-4">
          Dengan fasilitas lengkap seperti bengkel otomotif, laboratorium komputer, studio audio-video, dan ruang praktik mesin, kami menjamin pembelajaran yang relevan dengan kebutuhan industri. Lebih dari 95% lulusan terserap di dunia kerja atau melanjutkan ke perguruan tinggi.
        </p>
        <p class="text-slate-700 dark:text-slate-300">
          Sekolah ini juga aktif dalam berbagai lomba tingkat kabupaten, provinsi, hingga nasional, dan telah meraih berbagai prestasi di bidang teknologi, otomotif, dan seni.
        </p>
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