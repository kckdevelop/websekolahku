@extends('layouts.app')
@section('title', 'Buat Akun Pendaftaran SPMB')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center py-12 relative overflow-hidden">
  <div class="absolute -top-32 -right-32 w-80 h-80 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="relative z-10 w-full max-w-md mx-auto px-4">

    {{-- Back Link --}}
    <div class="mb-6">
      <a href="{{ route('spmb.daftar') }}" class="text-slate-400 hover:text-white text-sm inline-flex items-center gap-2 transition-colors">
        <i class="fas fa-arrow-left"></i> Kembali ke Halaman SPMB
      </a>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">

      {{-- Header --}}
      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-primary to-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-4 shadow-lg shadow-primary/40">
          <i class="fas fa-user-plus"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-white">Buat Akun Pendaftaran</h1>
        <p class="text-slate-400 text-sm mt-1">Gunakan nomor WhatsApp aktif untuk verifikasi</p>
      </div>

      {{-- Errors --}}
      @if ($errors->any())
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 p-4 rounded-2xl mb-6 text-sm">
          <div class="flex items-center gap-2 font-bold mb-2"><i class="fas fa-exclamation-circle"></i> Terdapat kesalahan:</div>
          <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('warning'))
        <div class="bg-amber-500/20 border border-amber-400/30 text-amber-200 p-4 rounded-2xl mb-6 text-sm">
          <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
        </div>
      @endif

      <form action="{{ route('spmb.register.post') }}" method="POST" class="space-y-5" id="form-register">
        @csrf

        {{-- No WA --}}
        <div>
          <label class="block text-sm font-semibold text-slate-300 mb-2">
            <i class="fab fa-whatsapp text-green-400 mr-1"></i> Nomor WhatsApp <span class="text-red-400">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">+62</span>
            <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" required
              class="w-full pl-14 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition text-sm @error('no_wa') border-red-400 @enderror"
              placeholder="8123456789"
              autocomplete="tel">
          </div>
          <p class="text-xs text-slate-500 mt-1"><i class="fas fa-info-circle mr-1"></i>Contoh: 08123456789 atau 628123456789</p>
          @error('no_wa')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Password --}}
        <div>
          <label class="block text-sm font-semibold text-slate-300 mb-2">
            <i class="fas fa-lock mr-1 text-slate-400"></i> Password <span class="text-red-400">*</span>
          </label>
          <div class="relative">
            <input type="password" name="password" id="password" required
              class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition text-sm pr-12 @error('password') border-red-400 @enderror"
              placeholder="Minimal 8 karakter">
            <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
          <label class="block text-sm font-semibold text-slate-300 mb-2">
            <i class="fas fa-lock mr-1 text-slate-400"></i> Konfirmasi Password <span class="text-red-400">*</span>
          </label>
          <div class="relative">
            <input type="password" name="password_confirmation" id="password_confirmation" required
              class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition text-sm pr-12"
              placeholder="Ulangi password">
            <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div id="pw-match-info" class="text-xs mt-1 hidden"></div>
        </div>

        {{-- Syarat --}}
        <div class="bg-blue-500/10 border border-blue-400/20 rounded-xl p-4 text-xs text-slate-400">
          <i class="fas fa-shield-alt text-blue-400 mr-1"></i>
          Dengan mendaftar, Anda menyetujui bahwa nomor WhatsApp akan digunakan untuk keperluan verifikasi SPMB SMK Muhammadiyah 1 Bantul.
        </div>

        {{-- Submit --}}
        <button type="submit" id="btn-submit-register"
          class="w-full bg-gradient-to-r from-primary to-blue-600 hover:from-blue-600 hover:to-primary text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-primary/30 hover:shadow-primary/50 flex items-center justify-center gap-2">
          <i class="fab fa-whatsapp"></i> Kirim Kode OTP ke WhatsApp
        </button>

        <p class="text-center text-sm text-slate-400">
          Sudah punya akun?
          <a href="{{ route('spmb.login') }}" class="text-primary hover:text-orange-400 font-semibold transition-colors">Login di sini</a>
        </p>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.innerHTML = isText ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
  }

  // Real-time password match check
  const pw = document.getElementById('password');
  const pwc = document.getElementById('password_confirmation');
  const info = document.getElementById('pw-match-info');

  function checkMatch() {
    if (!pwc.value) { info.classList.add('hidden'); return; }
    info.classList.remove('hidden');
    if (pw.value === pwc.value) {
      info.className = 'text-xs mt-1 text-emerald-400';
      info.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Password cocok';
    } else {
      info.className = 'text-xs mt-1 text-red-400';
      info.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Password tidak cocok';
    }
  }
  pw.addEventListener('input', checkMatch);
  pwc.addEventListener('input', checkMatch);

  // Format nomor WA
  document.getElementById('no_wa').addEventListener('input', function() {
    let val = this.value.replace(/\D/g, '');
    if (val.startsWith('62')) val = val.substring(2);
    if (val.startsWith('0')) val = val.substring(1);
    this.value = val;
  });

  // Button loading
  document.getElementById('form-register').addEventListener('submit', function() {
    const btn = document.getElementById('btn-submit-register');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim OTP...';
  });
</script>
@endsection
