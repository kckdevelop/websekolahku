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

      <form method="POST" action="{{ route('admin.reset.post') }}" class="pt-4 border-t border-slate-100 space-y-4" onsubmit="return confirmReset()">
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
          <button type="submit" id="btn-submit-reset" disabled
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

</div>
@endsection

@section('scripts')
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

  function confirmReset() {
    const val = document.getElementById('konfirmasi').value.trim().toUpperCase();
    if (val !== 'RESET') {
      alert('Tuliskan kata "RESET" terlebih dahulu.');
      return false;
    }
    return confirm('APAKAH ANDA SANGAT YAKIN? Semua data pendaftar dan gelombang akan hilang selamanya dan tidak dapat dikembalikan.');
  }
</script>
@endsection
