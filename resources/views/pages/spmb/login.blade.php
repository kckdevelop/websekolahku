@extends('layouts.app')
@section('title', 'Login Akun SPMB')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center py-12 relative overflow-hidden">
  <div class="absolute -top-32 -right-32 w-80 h-80 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
  <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"></div>

  <div class="relative z-10 w-full max-w-md mx-auto px-4">

    <div class="mb-6">
      <a href="{{ route('spmb.daftar') }}" class="text-slate-400 hover:text-white text-sm inline-flex items-center gap-2 transition-colors">
        <i class="fas fa-arrow-left"></i> Kembali ke Halaman SPMB
      </a>
    </div>

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">

      <div class="text-center mb-8">
        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-primary rounded-2xl flex items-center justify-center text-white text-2xl mx-auto mb-4 shadow-lg shadow-orange-500/30">
          <i class="fas fa-sign-in-alt"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-white">Login Akun SPMB</h1>
        <p class="text-slate-400 text-sm mt-1">Masuk dengan nomor WhatsApp yang telah terdaftar</p>
      </div>

      {{-- Alerts --}}
      @if ($errors->any())
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 p-4 rounded-2xl mb-5 text-sm">
          <div class="flex items-center gap-2 font-bold mb-1"><i class="fas fa-exclamation-circle"></i> Gagal Login:</div>
          <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      @if (session('info'))
        <div class="bg-blue-500/20 border border-blue-400/30 text-blue-200 p-3 rounded-xl mb-5 text-sm">
          <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
        </div>
      @endif
      @if (session('warning'))
        <div class="bg-amber-500/20 border border-amber-400/30 text-amber-200 p-3 rounded-xl mb-5 text-sm">
          <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
        </div>
      @endif
      @if (session('success'))
        <div class="bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 p-3 rounded-xl mb-5 text-sm">
          <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
      @endif

      <form action="{{ route('spmb.login.post') }}" method="POST" class="space-y-5" id="form-login">
        @csrf

        {{-- No WA --}}
        <div>
          <label class="block text-sm font-semibold text-slate-300 mb-2">
            <i class="fab fa-whatsapp text-green-400 mr-1"></i> Nomor WhatsApp
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">+62</span>
            <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" required
              class="w-full pl-14 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition text-sm"
              placeholder="8123456789" autocomplete="tel">
          </div>
        </div>

        {{-- Password --}}
        <div>
          <label class="block text-sm font-semibold text-slate-300 mb-2">
            <i class="fas fa-lock mr-1 text-slate-400"></i> Password
          </label>
          <div class="relative">
            <input type="password" name="password" id="password" required
              class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-slate-500 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none transition text-sm pr-12"
              placeholder="Password Anda">
            <button type="button" onclick="togglePw()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
              <i class="fas fa-eye" id="pw-icon"></i>
            </button>
          </div>
        </div>

        <button type="submit" id="btn-login"
          class="w-full bg-gradient-to-r from-primary to-orange-600 hover:from-orange-600 hover:to-primary text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
          <i class="fas fa-sign-in-alt"></i> Masuk ke Formulir
        </button>

        <p class="text-center text-sm text-slate-400">
          Belum punya akun?
          <a href="{{ route('spmb.register') }}" class="text-primary hover:text-orange-400 font-semibold transition-colors">Daftar sekarang</a>
        </p>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
  function togglePw() {
    const inp = document.getElementById('password');
    const icon = document.getElementById('pw-icon');
    if (inp.type === 'password') {
      inp.type = 'text';
      icon.className = 'fas fa-eye-slash';
    } else {
      inp.type = 'password';
      icon.className = 'fas fa-eye';
    }
  }

  document.getElementById('no_wa').addEventListener('input', function() {
    let val = this.value.replace(/\D/g, '');
    if (val.startsWith('62')) val = val.substring(2);
    if (val.startsWith('0')) val = val.substring(1);
    this.value = val;
  });

  document.getElementById('form-login').addEventListener('submit', function() {
    const btn = document.getElementById('btn-login');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
  });
</script>
@endsection
