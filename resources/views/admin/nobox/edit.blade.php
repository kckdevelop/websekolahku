@extends('layouts.admin')
@section('title', 'Pengaturan Nobox (WhatsApp OTP)')
@section('subtitle', 'Konfigurasi integrasi WhatsApp gateway menggunakan API Nobox.ai')

@section('content')
<div class="max-w-4xl space-y-6">
  
  {{-- Form Pengaturan Utama --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center justify-between">
      <h3 class="font-bold text-slate-800 flex items-center gap-2">
        <i class="fas fa-sliders-h text-primary"></i> Kredensial Nobox
      </h3>
      <span class="text-xs bg-orange-100 text-primary px-2.5 py-1 rounded-full font-semibold">Active</span>
    </div>

    <form method="POST" action="{{ route('admin.nobox.update') }}" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Account ID --}}
        <div>
          <label for="account_ids" class="block text-sm font-medium text-slate-700 mb-1.5">Account ID <span class="text-red-500">*</span></label>
          <input type="text" id="account_ids" name="account_ids" value="{{ old('account_ids', $setting->account_ids) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('account_ids') border-red-400 @enderror"
            placeholder="Contoh: 812975583269637">
          <p class="text-slate-400 text-xs mt-1">Dapat ditemukan di dashboard Nobox.ai > WhatsApp.</p>
          @error('account_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- API Key / x-api-key --}}
        <div>
          <label for="api_key" class="block text-sm font-medium text-slate-700 mb-1.5">API Key (x-api-key) <span class="text-red-500">*</span></label>
          <input type="password" id="api_key" name="api_key" value="{{ old('api_key', $setting->api_key) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('api_key') border-red-400 @enderror"
            placeholder="Ketik API Key Anda">
          <p class="text-slate-400 text-xs mt-1">Token autentikasi HTTP header <code>x-api-key</code>.</p>
          @error('api_key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Channel ID --}}
        <div>
          <label for="channel_id" class="block text-sm font-medium text-slate-700 mb-1.5">Channel ID <span class="text-red-500">*</span></label>
          <input type="text" id="channel_id" name="channel_id" value="{{ old('channel_id', $setting->channel_id) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('channel_id') border-red-400 @enderror">
          <p class="text-slate-400 text-xs mt-1">Default channel ID untuk pengiriman pesan teks (biasanya 1).</p>
          @error('channel_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Gateway URL --}}
        <div>
          <label for="url" class="block text-sm font-medium text-slate-700 mb-1.5">Gateway URL <span class="text-red-500">*</span></label>
          <input type="url" id="url" name="url" value="{{ old('url', $setting->url) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('url') border-red-400 @enderror"
            placeholder="https://id.nobox.ai">
          <p class="text-slate-400 text-xs mt-1">Alamat endpoint URL Nobox (default: <code>https://id.nobox.ai</code>).</p>
          @error('url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Bypass Log Mode --}}
      <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
        <div class="pr-4">
          <h4 class="text-sm font-bold text-slate-800">Mode Development (Log OTP Bypass)</h4>
          <p class="text-xs text-slate-500 mt-0.5">Jika diaktifkan, OTP tidak dikirim ke WhatsApp tujuan melainkan hanya dicatat di sistem dan langsung ditampilkan di layar verifikasi siswa untuk mempermudah testing.</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
          <input type="checkbox" name="otp_via_log" value="1" class="sr-only peer" {{ $setting->otp_via_log ? 'checked' : '' }}>
          <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:height-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
        </label>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
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

  {{-- Card Uji Coba WhatsApp --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50">
      <h3 class="font-bold text-slate-800 flex items-center gap-2">
        <i class="fab fa-whatsapp text-green-500 text-lg"></i> Uji Coba Koneksi WhatsApp
      </h3>
      <p class="text-xs text-slate-500 mt-0.5">Kirimkan pesan uji coba untuk memvalidasi kredensial Nobox yang aktif saat ini.</p>
    </div>

    <form id="test-wa-form" class="p-6 space-y-4">
      @csrf
      <div id="test-alert" class="hidden p-4 rounded-xl border text-sm flex items-start gap-3">
        <i id="test-alert-icon" class="fas mt-0.5"></i>
        <div id="test-alert-text" class="flex-1"></div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-1">
          <label for="test_phone" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor WA Tujuan</label>
          <input type="text" id="test_phone" name="test_phone" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Contoh: 08123456789">
        </div>
        <div class="md:col-span-2">
          <label for="test_message" class="block text-sm font-medium text-slate-700 mb-1.5">Isi Pesan Uji Coba</label>
          <input type="text" id="test_message" name="test_message" value="Halo! Ini adalah pesan uji coba dari sistem SPMB SMK Muhammadiyah 1 Bantul." required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
        </div>
      </div>

      <div class="pt-2 flex justify-end">
        <button type="submit" id="test-submit-btn"
          class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-green-500/20">
          <span id="btn-icon"><i class="fab fa-whatsapp"></i></span>
          <span id="btn-text">Kirim Pesan Uji Coba</span>
        </button>
      </div>
    </form>
  </div>

</div>
@endsection

@section('scripts')
<script>
  document.getElementById('test-wa-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const submitBtn = document.getElementById('test-submit-btn');
    const btnIcon = document.getElementById('btn-icon');
    const btnText = document.getElementById('btn-text');
    const alertDiv = document.getElementById('test-alert');
    const alertIcon = document.getElementById('test-alert-icon');
    const alertText = document.getElementById('test-alert-text');

    // Reset status alert
    alertDiv.className = 'hidden p-4 rounded-xl border text-sm flex items-start gap-3';
    
    // Set loading state
    submitBtn.disabled = true;
    submitBtn.classList.remove('hover:bg-green-600');
    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
    btnIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btnText.textContent = 'Sedang mengirim...';

    const formData = new FormData(form);

    fetch("{{ route('admin.nobox.test') }}", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json"
      },
      body: formData
    })
    .then(async response => {
      const data = await response.json();
      if (response.ok) {
        // Berhasil
        alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-green-50 border-green-200 text-green-700';
        alertIcon.className = 'fas fa-check-circle text-green-500 mt-0.5';
        alertText.textContent = data.message;
      } else {
        // Error respons validasi atau API
        alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-red-50 border-red-200 text-red-700';
        alertIcon.className = 'fas fa-exclamation-circle text-red-500 mt-0.5';
        alertText.textContent = data.message || 'Gagal mengirim pesan uji coba.';
      }
    })
    .catch(error => {
      // Network/System Error
      alertDiv.className = 'p-4 rounded-xl border text-sm flex items-start gap-3 bg-red-50 border-red-200 text-red-700';
      alertIcon.className = 'fas fa-exclamation-circle text-red-500 mt-0.5';
      alertText.textContent = 'Terjadi kesalahan saat menghubungi server.';
      console.error(error);
    })
    .finally(() => {
      // Revert loading state
      submitBtn.disabled = false;
      submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
      submitBtn.classList.add('hover:bg-green-600');
      btnIcon.innerHTML = '<i class="fab fa-whatsapp"></i>';
      btnText.textContent = 'Kirim Pesan Uji Coba';
    });
  });
</script>
@endsection
