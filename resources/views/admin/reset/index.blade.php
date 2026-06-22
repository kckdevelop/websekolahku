@extends('layouts.admin')
@section('title', 'Reset Data Pendaftaran')
@section('subtitle', 'Menghapus seluruh data pendaftaran SPMB untuk mempersiapkan tahun ajaran baru')

@section('content')
<div class="max-w-3xl space-y-6">

  @if(session('success'))
  <div class="p-4 bg-green-50 border border-green-200 rounded-2xl text-green-700 text-sm flex items-center gap-3">
    <i class="fas fa-check-circle text-lg"></i>
    <div>
      <span class="font-bold">Sukses!</span> {{ session('success') }}
    </div>
  </div>
  @endif

  @if(session('error'))
  <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm flex items-center gap-3">
    <i class="fas fa-exclamation-circle text-lg"></i>
    <div>
      <span class="font-bold">Error!</span> {{ session('error') }}
    </div>
  </div>
  @endif

  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-red-50 flex items-center gap-2">
      <i class="fas fa-exclamation-triangle text-red-600"></i>
      <h3 class="font-bold text-red-800 text-sm">Peringatan Penting Hapus Data Pendaftaran</h3>
    </div>
    
    <div class="p-6 space-y-6">
      <div class="flex items-start gap-4 p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs">
        <i class="fas fa-info-circle text-lg text-amber-600 mt-0.5"></i>
        <div>
          <p class="font-bold mb-1">Tindakan ini tidak dapat dibatalkan!</p>
          <p class="leading-relaxed">
            Menekan tombol reset akan menghapus seluruh data pendaftaran siswa di bawah ini secara permanen dari database. Pastikan Anda telah mengunduh (backup) laporan pendaftaran sebelum melanjutkan.
          </p>
        </div>
      </div>

      <div class="space-y-3">
        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Data yang akan terhapus:</h4>
        <ul class="space-y-2.5 text-xs text-slate-600">
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Data Gelombang SPMB</strong> (Konfigurasi pendaftaran gelombang)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Akun Akses Siswa</strong> (Akun yang dipakai pendaftar untuk login/mengisi form)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Data Pendaftar (Biodata)</strong> (Seluruh data diri calon siswa, sekolah asal, dan orang tua)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Data Kesehatan &amp; UKS</strong> (Hasil verifikasi fisik, tinggi badan, tato/tindik, dan buta warna)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Data Tes Gaya Belajar</strong> (Hasil tes mandiri gaya belajar VARK &amp; minat bakat)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Data Wawancara Keagamaan</strong> (Hasil wawancara Quran, sholat, kepribadian, &amp; seragam)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Data Riwayat Pembayaran</strong> (Seluruh riwayat pembayaran SPB/infaq &amp; kwitansi transaksi)</span>
          </li>
          <li class="flex items-center gap-2">
            <i class="fas fa-check text-red-500 w-4 text-center"></i>
            <span><strong>Berkas Upload Siswa</strong> (File scan Akta Kelahiran, KK, dan Foto Profil yang di-upload)</span>
          </li>
        </ul>
      </div>

      <form id="reset-form" method="POST" action="{{ route('admin.reset.post') }}" class="pt-4 border-t border-slate-100 space-y-4">
        @csrf
        <div>
          <label for="konfirmasi" class="block text-xs font-semibold text-slate-700 mb-2">
            Ketik kata <span class="text-red-650 font-bold bg-red-50 px-1.5 py-0.5 rounded border border-red-200">RESET</span> di bawah ini untuk mengonfirmasi:
          </label>
          <input type="text" id="konfirmasi" name="konfirmasi" required autocomplete="off"
            class="w-full max-w-md px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-red-200 focus:border-red-500 outline-none transition text-sm font-bold text-center tracking-widest uppercase @error('konfirmasi') border-red-400 @enderror"
            placeholder="Ketik kata konfirmasi di sini"
            oninput="checkResetInput(this)">
          @error('konfirmasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3 pt-2">
          <button type="button" id="btn-submit-reset" disabled onclick="openConfirmationModal()"
            class="inline-flex items-center gap-2 bg-slate-300 text-slate-500 font-bold px-6 py-3 rounded-xl transition-all cursor-not-allowed">
            <i class="fas fa-trash-alt"></i> Bersihkan Semua Data Pendaftaran
          </button>
          <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
            Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div id="confirmation-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl transform scale-95 opacity-0 transition-all duration-300 relative overflow-hidden text-center">
      <!-- Close button -->
      <button type="button" onclick="closeConfirmationModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 text-xl font-bold transition">&times;</button>
      
      <!-- Warning Icon -->
      <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 mb-6 relative">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-100 opacity-75"></span>
        <div class="h-16 w-16 rounded-full bg-red-100 flex items-center justify-center relative z-10">
          <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
        </div>
      </div>
      
      <!-- Title & Content -->
      <h3 class="text-xl font-bold text-slate-800 mb-2">Apakah Anda Sangat Yakin?</h3>
      <p class="text-xs text-slate-500 mb-6 leading-relaxed">
        Tindakan ini <strong>tidak dapat dibatalkan!</strong> Seluruh data pendaftaran, gelombang, akun siswa, berkas fisik, hasil tes, wawancara, dan riwayat pembayaran akan dihapus secara permanen dari database.
      </p>
      
      <!-- Action Buttons -->
      <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <button type="button" onclick="closeConfirmationModal()" 
          class="w-full sm:w-1/2 px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm transition cursor-pointer text-center">
          Batal
        </button>
        <button type="button" id="btn-confirm-delete" onclick="submitResetForm()" 
          class="w-full sm:w-1/2 px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-sm transition shadow-lg shadow-red-600/20 flex items-center justify-center gap-2 cursor-pointer">
          <i class="fas fa-trash-alt"></i> Ya, Hapus Permanen
        </button>
      </div>
    </div>
  </div>

  @if(session('success'))
  <!-- Success alert handled via SweetAlert2 -->
  @endif

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
<script>
  function checkResetInput(input) {
    const btn = document.getElementById('btn-submit-reset');
    if (input.value.trim().toUpperCase() === 'RESET') {
      btn.disabled = false;
      btn.className = "inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-red-600/30 cursor-pointer";
    } else {
      btn.disabled = true;
      btn.className = "inline-flex items-center gap-2 bg-slate-300 text-slate-500 font-bold px-6 py-3 rounded-xl transition-all cursor-not-allowed";
    }
  }

  function openConfirmationModal() {
    const modal = document.getElementById('confirmation-modal');
    const card = modal.querySelector('.bg-white');
    
    modal.classList.remove('opacity-0', 'pointer-events-none');
    modal.classList.add('opacity-100', 'pointer-events-auto');
    
    card.classList.remove('scale-95', 'opacity-0');
    card.classList.add('scale-100', 'opacity-100');
  }

  function closeConfirmationModal() {
    const modal = document.getElementById('confirmation-modal');
    const card = modal.querySelector('.bg-white');
    
    modal.classList.remove('opacity-100', 'pointer-events-auto');
    modal.classList.add('opacity-0', 'pointer-events-none');
    
    card.classList.remove('scale-100', 'opacity-100');
    card.classList.add('scale-95', 'opacity-0');
  }

  function submitResetForm() {
    const btnConfirm = document.getElementById('btn-confirm-delete');
    
    // Disable button and show spinner
    btnConfirm.disabled = true;
    btnConfirm.classList.add('cursor-not-allowed', 'opacity-75');
    btnConfirm.innerHTML = `<i class="fas fa-spinner animate-spin"></i> Sedang Mereset...`;
    
    // Submit the form
    document.getElementById('reset-form').submit();
  }

  @if(session('success'))
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
      title: 'Reset Berhasil!',
      text: "{{ session('success') }}",
      icon: 'success',
      confirmButtonText: 'Selesai',
      confirmButtonColor: '#10b981',
      background: '#ffffff',
      customClass: {
        popup: 'rounded-[24px]',
        confirmButton: 'px-6 py-3 rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-500/20'
      },
      didOpen: () => {
        if (typeof confetti === 'function') {
          const duration = 2.5 * 1000;
          const animationEnd = Date.now() + duration;
          const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 110000 };

          function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
          }

          const interval = setInterval(function() {
            const timeLeft = animationEnd - Date.now();

            if (timeLeft <= 0) {
              return clearInterval(interval);
            }

            const particleCount = 50 * (timeLeft / duration);
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
          }, 250);
        }
      }
    });
  });
  @endif
</script>
@endsection
