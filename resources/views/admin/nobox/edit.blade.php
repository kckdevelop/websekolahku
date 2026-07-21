@extends('layouts.admin')
@section('title', 'Pengaturan WhatsApp Gateway')
@section('subtitle', 'Konfigurasi integrasi WhatsApp Gateway menggunakan Fonnte API')

@section('content')
<div class="max-w-4xl space-y-6">

  {{-- ── BANNER STATUS ── --}}
  @if($setting->isConfigured())
    <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-green-50 border border-green-200 text-green-800">
      <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
        <i class="fab fa-whatsapp text-green-600 text-lg"></i>
      </div>
      <div>
        <p class="font-semibold text-sm">Token Fonnte sudah terkonfigurasi</p>
        <p class="text-xs text-green-600 mt-0.5">Sistem siap mengirim OTP dan notifikasi WhatsApp ke calon siswa.</p>
      </div>
      <span class="ml-auto flex-shrink-0 flex items-center gap-1.5 text-xs font-bold text-green-700 bg-green-100 px-3 py-1 rounded-full">
        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse inline-block"></span> Aktif
      </span>
    </div>
  @else
    <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800">
      <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center flex-shrink-0">
        <i class="fas fa-exclamation-triangle text-amber-500 text-base"></i>
      </div>
      <div>
        <p class="font-semibold text-sm">Token Fonnte belum dikonfigurasi</p>
        <p class="text-xs text-amber-600 mt-0.5">Pengiriman OTP WhatsApp tidak akan berfungsi sampai token diisi dan disimpan.</p>
      </div>
      <span class="ml-auto flex-shrink-0 text-xs font-bold text-amber-700 bg-amber-100 px-3 py-1 rounded-full">Belum Aktif</span>
    </div>
  @endif

  {{-- ── CARA MENDAPAT TOKEN FONNTE ── --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <button type="button" onclick="toggleGuide()"
      class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-slate-50 transition-colors">
      <span class="flex items-center gap-2 font-semibold text-slate-700 text-sm">
        <i class="fas fa-book-open text-primary"></i> Cara Mendapatkan Token Fonnte
      </span>
      <i id="guide-chevron" class="fas fa-chevron-down text-slate-400 text-xs transition-transform duration-200"></i>
    </button>
    <div id="guide-panel" class="hidden border-t border-slate-100 px-6 py-5">
      <ol class="space-y-3 text-sm text-slate-600">
        <li class="flex gap-3">
          <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0 font-bold mt-0.5">1</span>
          <span>Buka <a href="https://fonnte.com" target="_blank" class="text-primary hover:underline font-semibold">fonnte.com</a> dan daftarkan akun atau login jika sudah punya akun.</span>
        </li>
        <li class="flex gap-3">
          <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0 font-bold mt-0.5">2</span>
          <span>Di dashboard Fonnte, buka menu <strong>Device</strong> lalu klik <strong>+ Add Device</strong> untuk mendaftarkan nomor WhatsApp Anda.</span>
        </li>
        <li class="flex gap-3">
          <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0 font-bold mt-0.5">3</span>
          <span>Scan QR Code yang muncul menggunakan aplikasi WhatsApp di HP Anda (Pengaturan → Perangkat Tertaut → Tautkan Perangkat).</span>
        </li>
        <li class="flex gap-3">
          <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0 font-bold mt-0.5">4</span>
          <span>Setelah terhubung, klik nama device Anda. Salin <strong>Token</strong> yang tampil di halaman detail device tersebut.</span>
        </li>
        <li class="flex gap-3">
          <span class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center flex-shrink-0 font-bold mt-0.5">5</span>
          <span>Tempel token tersebut ke field <strong>Fonnte API Token</strong> di bawah, lalu klik <strong>Simpan Pengaturan</strong>.</span>
        </li>
      </ol>
      <div class="mt-4 p-3 bg-blue-50 border border-blue-100 rounded-xl text-xs text-blue-700 flex gap-2">
        <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
        <span>Pastikan nomor WhatsApp yang didaftarkan di Fonnte selalu aktif dan terhubung ke internet. Token akan tetap valid selama perangkat tertaut.</span>
      </div>
    </div>
  </div>

  {{-- ── FORM PENGATURAN UTAMA ── --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center gap-2">
      <i class="fab fa-whatsapp text-green-500 text-lg"></i>
      <h3 class="font-bold text-slate-800">Kredensial Fonnte API</h3>
    </div>

    <form method="POST" action="{{ route('admin.nobox.update') }}" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- API Token --}}
      <div>
        <label for="api_key" class="block text-sm font-medium text-slate-700 mb-1.5">
          Fonnte API Token <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <input type="password" id="api_key" name="api_key"
            value="{{ old('api_key', $setting->api_key) }}"
            required autocomplete="off"
            class="w-full px-4 py-3 pr-12 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm font-mono @error('api_key') border-red-400 @enderror"
            placeholder="Contoh: AbCdEfGhIjKlMnOpQrStUvWxYz123456">
          <button type="button" onclick="toggleTokenVisibility()"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1">
            <i id="token-eye-icon" class="fas fa-eye text-sm"></i>
          </button>
        </div>
        <div class="flex items-center justify-between mt-1.5">
          <p class="text-slate-400 text-xs">
            <i class="fas fa-shield-alt mr-1"></i> Token disimpan terenkripsi di database.
            Dapatkan token di <a href="https://fonnte.com" target="_blank" class="text-primary hover:underline font-semibold">fonnte.com</a> → Device → Detail Device.
          </p>
          @if($setting->api_key)
            <span class="text-xs text-green-600 font-semibold flex-shrink-0 ml-4">
              <i class="fas fa-check-circle mr-0.5"></i> Tersimpan
            </span>
          @endif
        </div>
        @error('api_key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Divider --}}
      <div class="border-t border-slate-100"></div>

      {{-- Mode Dev: OTP via Log --}}
      <div class="flex items-center justify-between gap-4">
        <div class="flex-1">
          <h4 class="text-sm font-bold text-slate-800 flex items-center gap-1.5">
            <i class="fas fa-flask text-amber-500 text-xs"></i>
            Mode Development (Bypass OTP)
          </h4>
          <p class="text-xs text-slate-500 mt-1 leading-relaxed">
            Jika diaktifkan, kode OTP <strong>tidak dikirim ke WhatsApp</strong> melainkan hanya dicatat di log sistem
            dan ditampilkan langsung di layar verifikasi. Gunakan hanya saat pengujian.
          </p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
          <input type="checkbox" name="otp_via_log" value="1" class="sr-only peer"
            {{ $setting->otp_via_log ? 'checked' : '' }}>
          <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer
            peer-checked:after:translate-x-full peer-checked:after:border-white
            after:content-[''] after:absolute after:top-[2px] after:left-[2px]
            after:bg-white after:border-slate-300 after:border after:rounded-full
            after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500">
          </div>
        </label>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
        <button type="submit"
          class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Simpan Pengaturan
        </button>
        <a href="{{ route('admin.dashboard') }}"
          class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
          Batal
        </a>
      </div>
    </form>
  </div>

  {{-- ── UJI COBA PENGIRIMAN ── --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <i class="fab fa-whatsapp text-green-500 text-lg"></i>
        <div>
          <h3 class="font-bold text-slate-800">Uji Coba Pengiriman WhatsApp</h3>
          <p class="text-xs text-slate-500 mt-0.5">Kirim pesan uji untuk memvalidasi token Fonnte yang aktif.</p>
        </div>
      </div>
      @if(!$setting->isConfigured())
        <span class="text-xs text-slate-400 bg-slate-100 px-3 py-1 rounded-full">Token belum diisi</span>
      @endif
    </div>

    <form id="test-wa-form" class="p-6 space-y-4">
      @csrf

      {{-- Alert Result --}}
      <div id="test-alert" class="hidden p-4 rounded-xl border text-sm flex items-start gap-3">
        <i id="test-alert-icon" class="fas mt-0.5 flex-shrink-0"></i>
        <div id="test-alert-text" class="flex-1"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="md:col-span-2">
          <label for="test_phone" class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fab fa-whatsapp text-green-500 mr-1"></i> Nomor WA Tujuan
          </label>
          <input type="text" id="test_phone" name="test_phone"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Contoh: 08123456789" maxlength="15">
        </div>
        <div class="md:col-span-3">
          <label for="test_message" class="block text-sm font-medium text-slate-700 mb-1.5">
            <i class="fas fa-comment-dots text-slate-400 mr-1"></i> Isi Pesan Uji Coba
          </label>
          <input type="text" id="test_message" name="test_message"
            value="Halo! Ini pesan uji coba dari sistem SPMB SMK Muhammadiyah 1 Bantul. ✅"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        </div>
      </div>

      <div class="flex justify-end pt-1">
        <button type="submit" id="test-submit-btn"
          class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-green-500/20"
          {{ !$setting->isConfigured() ? 'title=Token Fonnte belum diisi' : '' }}>
          <span id="btn-icon"><i class="fab fa-whatsapp"></i></span>
          <span id="btn-text">Kirim Pesan Uji Coba</span>
        </button>
      </div>
    </form>
  </div>

  {{-- ── INFO TEKNIS ── --}}
  <div class="bg-slate-50 rounded-2xl border border-slate-200 px-6 py-5">
    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Informasi Teknis</h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
      <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
          <i class="fas fa-link text-slate-400 text-xs"></i>
        </div>
        <div>
          <p class="font-semibold text-slate-700 text-xs">Endpoint API</p>
          <p class="text-slate-500 text-xs mt-0.5 font-mono">api.fonnte.com/send</p>
        </div>
      </div>
      <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
          <i class="fas fa-key text-slate-400 text-xs"></i>
        </div>
        <div>
          <p class="font-semibold text-slate-700 text-xs">Autentikasi</p>
          <p class="text-slate-500 text-xs mt-0.5 font-mono">Header: Authorization</p>
        </div>
      </div>
      <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0">
          <i class="fas fa-clock text-slate-400 text-xs"></i>
        </div>
        <div>
          <p class="font-semibold text-slate-700 text-xs">OTP Berlaku</p>
          <p class="text-slate-500 text-xs mt-0.5">5 menit · Rate limit 60 detik</p>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  // Toggle guide accordion
  function toggleGuide() {
    const panel = document.getElementById('guide-panel');
    const chevron = document.getElementById('guide-chevron');
    panel.classList.toggle('hidden');
    chevron.classList.toggle('rotate-180');
  }

  // Toggle token visibility
  function toggleTokenVisibility() {
    const input = document.getElementById('api_key');
    const icon = document.getElementById('token-eye-icon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'fas fa-eye-slash text-sm';
    } else {
      input.type = 'password';
      icon.className = 'fas fa-eye text-sm';
    }
  }

  // Uji coba kirim WhatsApp
  document.getElementById('test-wa-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('test-submit-btn');
    const btnIcon   = document.getElementById('btn-icon');
    const btnText   = document.getElementById('btn-text');
    const alertDiv  = document.getElementById('test-alert');
    const alertIcon = document.getElementById('test-alert-icon');
    const alertText = document.getElementById('test-alert-text');

    const phone   = document.getElementById('test_phone').value.trim();
    const message = document.getElementById('test_message').value.trim();

    if (!phone || !message) {
      alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-amber-50 border-amber-200 text-amber-700';
      alertIcon.className = 'fas fa-exclamation-triangle text-amber-500 mt-0.5 flex-shrink-0';
      alertText.textContent = 'Nomor WA dan isi pesan wajib diisi.';
      return;
    }

    // Reset alert
    alertDiv.className = 'hidden p-4 rounded-xl border text-sm flex items-start gap-3';

    // Loading state
    submitBtn.disabled = true;
    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
    submitBtn.classList.remove('hover:bg-green-600');
    btnIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btnText.textContent = 'Sedang mengirim…';

    const formData = new FormData();
    formData.append('test_phone', phone);
    formData.append('test_message', message);

    fetch("{{ route('admin.nobox.test') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
      body: formData,
    })
    .then(async response => {
      const data = await response.json();
      if (response.ok && data.success) {
        alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-green-50 border-green-200 text-green-700';
        alertIcon.className = 'fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0';
        alertText.textContent = data.message;
      } else {
        alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-red-50 border-red-200 text-red-700';
        alertIcon.className = 'fas fa-times-circle text-red-500 mt-0.5 flex-shrink-0';
        alertText.textContent = data.message || 'Gagal mengirim pesan uji coba.';
      }
    })
    .catch(() => {
      alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-red-50 border-red-200 text-red-700';
      alertIcon.className = 'fas fa-times-circle text-red-500 mt-0.5 flex-shrink-0';
      alertText.textContent = 'Terjadi kesalahan saat menghubungi server. Periksa koneksi internet.';
    })
    .finally(() => {
      submitBtn.disabled = false;
      submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
      submitBtn.classList.add('hover:bg-green-600');
      btnIcon.innerHTML = '<i class="fab fa-whatsapp"></i>';
      btnText.textContent = 'Kirim Pesan Uji Coba';
    });
  });
</script>
@endsection
