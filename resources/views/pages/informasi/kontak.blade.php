@extends('layouts.app')
@section('title', 'Hubungi Kami - SMK Muhammadiyah 1 Bantul')

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
  <section class="relative h-[35vh] overflow-hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent z-10"></div>
    <img src="https://picsum.photos/seed/kontak-hero/1920/600" alt="Hubungi Kami SMK Muhammadiyah 1 Bantul" class="absolute inset-0 w-full h-full object-cover">
    <div class="relative text-center text-white px-4 z-20 max-w-4xl">
      <h1 class="text-4xl md:text-5xl font-bold mb-2 tracking-tight">Hubungi Kami</h1>
      <p class="text-md md:text-xl text-orange-200 font-medium">Kami Siap Melayani Pertanyaan, Saran, dan Kemitraan Anda</p>
    </div>
  </section>

  <!-- Main Section -->
  <section class="py-16 bg-white dark:bg-slate-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        
        <!-- Left: Contact Form -->
        <div class="bg-gradient-to-br from-orange-50 to-white dark:from-slate-800 dark:to-slate-900 p-8 rounded-3xl border border-orange-100 dark:border-slate-700 shadow-xl fade-in-scroll">
          <h2 class="text-2xl font-bold text-slate-850 dark:text-white mb-2 flex items-center gap-2">
            <i class="far fa-paper-plane text-primary"></i> Kirim Pesan Anda
          </h2>
          <p class="text-slate-500 dark:text-slate-400 text-sm mb-6">Silakan lengkapi formulir di bawah ini, tim humas kami akan merespons secepatnya.</p>
          
          <form id="contactForm" class="space-y-5">
            @csrf
            <!-- Nama -->
            <div>
              <label for="nama" class="block text-sm font-semibold text-slate-700 dark:text-slate-350 mb-1.5">Nama Lengkap</label>
              <input type="text" name="nama" id="nama" required placeholder="Contoh: Ahmad Hidayat"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-855 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm">
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-350 mb-1.5">Alamat Email</label>
              <input type="email" name="email" id="email" required placeholder="Contoh: ahmad@gmail.com"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-855 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm">
            </div>

            <!-- Subjek -->
            <div>
              <label for="subjek" class="block text-sm font-semibold text-slate-700 dark:text-slate-350 mb-1.5">Subjek</label>
              <select name="subjek" id="subjek" required
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-855 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm">
                <option value="">-- Pilih Subjek Pesan --</option>
                <option value="Pertanyaan PPDB">Pertanyaan PPDB (Penerimaan Siswa Baru)</option>
                <option value="Kerja Sama Industri">Kerja Sama / Kemitraan Industri</option>
                <option value="Kritik & Saran">Kritik, Saran, & Pengaduan</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>

            <!-- Pesan -->
            <div>
              <label for="pesan" class="block text-sm font-semibold text-slate-700 dark:text-slate-350 mb-1.5">Pesan Anda</label>
              <textarea name="pesan" id="pesan" rows="5" required placeholder="Tuliskan isi pesan Anda di sini secara lengkap..."
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-855 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition text-sm resize-none"></textarea>
            </div>

            <!-- Button Submit -->
            <button type="submit" id="btnSubmit" 
                    class="w-full bg-primary hover:bg-secondary text-white font-bold py-3 px-6 rounded-xl transition transform active:scale-95 shadow-md shadow-primary/20 flex items-center justify-center gap-2">
              <span>Kirim Pesan</span> <i class="fas fa-paper-plane text-sm"></i>
            </button>
          </form>

          <!-- Form Success Alert Mockup -->
          <div id="successAlert" class="hidden mt-4 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-400 p-4 rounded-xl flex items-start gap-3">
            <i class="fas fa-check-circle text-lg mt-0.5"></i>
            <div>
              <h5 class="font-bold">Pesan Terkirim!</h5>
              <p class="text-xs mt-0.5">Terima kasih telah menghubungi kami. Tim kami akan segera menindaklanjuti pesan Anda.</p>
            </div>
          </div>
        </div>

        <!-- Right: Contact info & Map -->
        <div class="space-y-8 fade-in-scroll">
          
          <!-- Contact Detail Info -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Alamat -->
            <div class="card-gradient rounded-2xl p-5 shadow-md flex gap-4">
              <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-950 text-primary flex items-center justify-center flex-shrink-0">
                <i class="fas fa-map-marker-alt"></i>
              </div>
              <div>
                <h4 class="font-bold text-sm text-slate-850 dark:text-white mb-1">Alamat Sekolah</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                  Jl. Parangtritis Km. 11, Manding, Trirenggo, Bantul, Yogyakarta
                </p>
              </div>
            </div>

            <!-- Telepon -->
            <div class="card-gradient rounded-2xl p-5 shadow-md flex gap-4">
              <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-950 text-primary flex items-center justify-center flex-shrink-0">
                <i class="fas fa-phone-alt"></i>
              </div>
              <div>
                <h4 class="font-bold text-sm text-slate-850 dark:text-white mb-1">Kontak Telepon</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                  (0274) 123456
                </p>
              </div>
            </div>

            <!-- Email -->
            <div class="card-gradient rounded-2xl p-5 shadow-md flex gap-4">
              <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-950 text-primary flex items-center justify-center flex-shrink-0">
                <i class="fas fa-envelope"></i>
              </div>
              <div>
                <h4 class="font-bold text-sm text-slate-850 dark:text-white mb-1">Email Resmi</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed truncate">
                  info@smkmuh1bantul.sch.id
                </p>
              </div>
            </div>

            <!-- Jam Layanan -->
            <div class="card-gradient rounded-2xl p-5 shadow-md flex gap-4">
              <div class="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-950 text-primary flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock"></i>
              </div>
              <div>
                <h4 class="font-bold text-sm text-slate-850 dark:text-white mb-1">Jam Operasional</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                  Senin - Jumat: 07:00 - 15:30<br>
                  Sabtu: 07:00 - 12:00
                </p>
              </div>
            </div>
          </div>

          <!-- Google Map Embed -->
          <div class="rounded-3xl overflow-hidden shadow-xl border border-slate-100 dark:border-slate-700">
            <iframe class="w-full h-80" 
                    src="https://maps.google.com/maps?q=SMK%20Muhammadiyah%201%20Bantul&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                    frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>

        </div>

      </div>

    </div>
  </section>
@endsection

@section('script')
<script>
  // Form submission handler
  const contactForm = document.getElementById('contactForm');
  const successAlert = document.getElementById('successAlert');
  const btnSubmit = document.getElementById('btnSubmit');

  contactForm?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Disable form submission & show sending indicator
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = `<span>Mengirim...</span> <i class="fas fa-spinner animate-spin"></i>`;
    
    const formData = new FormData(contactForm);
    
    fetch('{{ route('kontak.store') }}', {
      method: 'POST',
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Terjadi kesalahan saat mengirim pesan.');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        contactForm.reset();
        contactForm.classList.add('hidden');
        successAlert.classList.remove('hidden');
      } else {
        alert(data.message || 'Gagal mengirim pesan.');
        btnSubmit.disabled = false;
        btnSubmit.innerHTML = `<span>Kirim Pesan</span> <i class="fas fa-paper-plane text-sm"></i>`;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Gagal mengirim pesan. Pastikan semua field diisi dengan benar.');
      btnSubmit.disabled = false;
      btnSubmit.innerHTML = `<span>Kirim Pesan</span> <i class="fas fa-paper-plane text-sm"></i>`;
    });
  });

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
