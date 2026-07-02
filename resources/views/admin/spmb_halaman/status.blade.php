@extends('layouts.admin')
@section('title', 'Status Pendaftaran SPMB')
@section('subtitle', 'Atur buka atau tutup pendaftaran siswa baru secara cepat')

@section('content')
<div class="max-w-3xl space-y-6">

  {{-- Status Card --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center justify-between">
      <h3 class="font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-toggle-on text-primary"></i> Kontrol Status Pendaftaran
      </h3>
      @if ($spmbContent->is_pendaftaran_open)
        <span class="inline-flex items-center gap-1.5 text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold">
          <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Sedang Buka
        </span>
      @else
        <span class="inline-flex items-center gap-1.5 text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full font-semibold">
          <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Sedang Ditutup
        </span>
      @endif
    </div>

    <form method="POST" action="{{ route('admin.spmb-status.update') }}" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- Alert --}}
      @if (session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
          <i class="fas fa-check-circle text-emerald-500"></i>
          {{ session('success') }}
        </div>
      @endif

      {{-- Toggle --}}
      <div class="p-5 rounded-xl border flex items-start gap-5 transition-all duration-300 {{ $spmbContent->is_pendaftaran_open ? 'bg-green-50 border-green-200' : 'bg-red-50/60 border-red-200' }}">
        <div class="flex-1">
          <h4 class="text-base font-bold text-slate-800 mb-1 flex items-center gap-2">
            <i class="fas {{ $spmbContent->is_pendaftaran_open ? 'fa-door-open text-green-600' : 'fa-door-closed text-red-500' }}"></i>
            @if ($spmbContent->is_pendaftaran_open)
              Pendaftaran Akun Baru <span class="text-green-600 font-extrabold">DIBUKA</span>
            @else
              Pendaftaran Akun Baru <span class="text-red-500 font-extrabold">DITUTUP</span>
            @endif
          </h4>
          <p class="text-sm text-slate-600 leading-relaxed">
            @if ($spmbContent->is_pendaftaran_open)
              Calon siswa baru <strong>dapat</strong> mendaftar, membuat akun baru, dan melakukan verifikasi OTP melalui WhatsApp.
              Nonaktifkan untuk menutup pendaftaran — <span class="text-red-500 font-semibold">semua gelombang akan dinonaktifkan otomatis</span>.
            @else
              Calon siswa baru <strong>tidak dapat</strong> membuat akun baru. Semua gelombang telah dinonaktifkan.
              Saat dibuka kembali, <strong>aktifkan gelombang</strong> yang sesuai secara manual.
            @endif
          </p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 mt-1">
          <input type="checkbox" name="is_pendaftaran_open" id="is_pendaftaran_open" value="1"
            class="sr-only peer" {{ $spmbContent->is_pendaftaran_open ? 'checked' : '' }}
            onchange="handleToggleChange(this)">
          <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-7 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all duration-300 peer-checked:bg-green-500"></div>
        </label>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
        <button type="submit"
          class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Simpan Status
        </button>
        <a href="{{ route('admin.gelombang.index') }}"
          class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
          Batal
        </a>
      </div>
    </form>
  </div>

  {{-- Info Card --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50">
      <h3 class="font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-info-circle text-blue-500"></i> Panduan Penggunaan
      </h3>
    </div>
    <div class="p-6 space-y-4 text-sm text-slate-600">
      <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0 mt-0.5">
          <i class="fas fa-check text-green-600 text-xs"></i>
        </div>
        <div>
          <p class="font-semibold text-slate-800">Saat Status <span class="text-green-600">Buka</span></p>
          <p>Calon siswa dapat mengakses halaman pendaftaran, membuat akun baru, dan memulai proses registrasi SPMB.</p>
        </div>
      </div>
      <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
          <i class="fas fa-times text-red-500 text-xs"></i>
        </div>
        <div>
          <p class="font-semibold text-slate-800">Saat Status <span class="text-red-500">Tutup</span></p>
          <p>Tombol "Buat Akun Baru" dinonaktifkan. Akses langsung ke <code class="bg-slate-100 px-1 rounded text-xs">/spmb/register</code> akan diarahkan kembali ke halaman pendaftaran. Siswa yang sudah mendaftar sebelumnya <strong>tetap bisa login</strong>.</p>
        </div>
      </div>
      <div class="flex items-start gap-3">
        <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0 mt-0.5">
          <i class="fas fa-layer-group text-blue-600 text-xs"></i>
        </div>
        <div>
          <p class="font-semibold text-slate-800">Hubungannya dengan Gelombang</p>
          <p>Saat pendaftaran <strong>ditutup</strong>, semua gelombang dinonaktifkan secara otomatis. Saat dibuka kembali, Anda perlu mengaktifkan gelombang yang sesuai melalui menu <a href="{{ route('admin.gelombang.index') }}" class="text-primary hover:underline font-semibold">Atur Gelombang</a>.</p>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Modal Konfirmasi Tutup Pendaftaran --}}
<div id="modal-tutup" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
  {{-- Backdrop --}}
  <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="closeTutupModal()"></div>

  {{-- Card --}}
  <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all scale-95 opacity-0 duration-200" id="modal-tutup-card">
    {{-- Header --}}
    <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-t-2xl px-6 pt-6 pb-8">
      <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
          <i class="fas fa-door-closed text-white text-xl"></i>
        </div>
        <button type="button" onclick="closeTutupModal()" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 text-white flex items-center justify-center transition-colors">
          <i class="fas fa-times text-sm"></i>
        </button>
      </div>
      <h3 class="text-lg font-bold text-white">Tutup Pendaftaran SPMB?</h3>
      <p class="text-red-100 text-sm mt-1">Konfirmasi penutupan pendaftaran siswa baru</p>
    </div>

    {{-- Body --}}
    <div class="px-6 py-5 -mt-4">
      <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 mb-4">
        <div class="space-y-3">
          <div class="flex items-start gap-2.5 text-slate-650 text-sm">
            <i class="fas fa-minus-circle text-red-500 mt-1 flex-shrink-0"></i>
            <span>Menonaktifkan tombol pendaftaran di halaman publik</span>
          </div>
          <div class="flex items-start gap-2.5 text-slate-650 text-sm">
            <i class="fas fa-layer-group text-red-500 mt-1 flex-shrink-0"></i>
            <span>Menonaktifkan <strong>SEMUA</strong> gelombang secara otomatis</span>
          </div>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
        <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5 flex-shrink-0"></i>
        <p class="text-xs text-amber-750 leading-relaxed">
          Saat pendaftaran dibuka kembali nanti, Anda harus mengaktifkan kembali gelombang pendaftaran yang diinginkan secara manual.
        </p>
      </div>
    </div>

    {{-- Footer --}}
    <div class="px-6 pb-6 flex gap-3">
      <button type="button" onclick="closeTutupModal()"
        class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-650 font-semibold text-sm hover:bg-slate-50 transition-colors">
        Batal
      </button>
      <button type="button" onclick="submitTutupForm()"
        class="flex-1 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold text-sm hover:from-red-600 hover:to-rose-700 transition-all shadow-sm shadow-red-200 flex items-center justify-center gap-2">
        <i class="fas fa-check text-xs"></i> Ya, Tutup
      </button>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
let _isClosingConfirmed = false;
let _toggleCheckbox = null;

function handleToggleChange(checkbox) {
  _toggleCheckbox = checkbox;
  const isClosing = !checkbox.checked; // unchecked = menutup pendaftaran

  if (isClosing && !_isClosingConfirmed) {
    // Tampilkan modal kustom
    checkbox.checked = true; // Biarkan toggle tetap ON secara visual hingga dikonfirmasi
    showTutupModal();
  } else {
    // Jika membuka pendaftaran, langsung submit tanpa konfirmasi modal tutup
    checkbox.form.submit();
  }
}

function showTutupModal() {
  const modal = document.getElementById('modal-tutup');
  const card  = document.getElementById('modal-tutup-card');
  modal.classList.remove('hidden');
  modal.classList.add('flex');
  requestAnimationFrame(() => {
    card.classList.remove('scale-95', 'opacity-0');
    card.classList.add('scale-100', 'opacity-100');
  });
}

function closeTutupModal() {
  const modal = document.getElementById('modal-tutup');
  const card  = document.getElementById('modal-tutup-card');
  card.classList.remove('scale-100', 'opacity-100');
  card.classList.add('scale-95', 'opacity-0');
  setTimeout(() => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    if (_toggleCheckbox) {
      _toggleCheckbox.checked = true; // Kembalikan toggle ke posisi ON karena batal
    }
  }, 200);
}

function submitTutupForm() {
  _isClosingConfirmed = true;
  if (_toggleCheckbox) {
    _toggleCheckbox.checked = false; // Set toggle ke posisi OFF
    _toggleCheckbox.form.submit();
  }
}
</script>
@endsection
