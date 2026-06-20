@extends('layouts.app')
@section('title', 'Login Tes Gaya Belajar - SPMB')

@section('style')
<style>
  @keyframes floatUp {
    0%   { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
  }
  .card-animate { animation: floatUp 0.7s ease-out both; }

  @keyframes brainPulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(99,102,241,0.4); }
    50%       { transform: scale(1.06); box-shadow: 0 0 0 16px rgba(99,102,241,0); }
  }
  .brain-icon { animation: brainPulse 2.5s ease-in-out infinite; }

  .input-field {
    background: rgba(255,255,255,0.07);
    border: 1.5px solid rgba(255,255,255,0.15);
    color: #fff;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .input-field::placeholder { color: rgba(255,255,255,0.35); }
  .input-field:focus {
    outline: none;
    border-color: #818cf8;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.25);
  }
  .input-label { color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 600; }
  input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1) opacity(0.6);
    cursor: pointer;
  }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 flex items-center justify-center py-12 px-4 relative overflow-hidden">

  {{-- Decorative blobs --}}
  <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
  <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-600/20 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>
  <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

  <div class="relative z-10 w-full max-w-md card-animate">

    {{-- Card --}}
    <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl">

      {{-- Icon --}}
      <div class="flex flex-col items-center mb-8">
        <div class="brain-icon w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl mb-5 shadow-xl shadow-indigo-500/30">
          <i class="fas fa-brain"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-white text-center leading-tight">Tes Gaya Belajar</h1>
        <p class="text-indigo-200 text-xs mt-1.5 text-center">Temukan gaya belajar terbaikmu — Visual, Auditori, atau Kinestetik</p>
        <div class="mt-4 inline-flex items-center gap-2 bg-indigo-500/20 border border-indigo-400/30 rounded-full px-4 py-1.5">
          <i class="fas fa-school text-indigo-300 text-xs"></i>
          <span class="text-indigo-200 text-xs font-semibold">SMK Muhammadiyah 1 Bantul</span>
        </div>
      </div>

      {{-- Alerts --}}
      @if(session('error'))
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 p-3 rounded-xl mb-5 text-sm flex items-start gap-2">
          <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif
      @if(session('warning'))
        <div class="bg-amber-500/20 border border-amber-400/30 text-amber-200 p-3 rounded-xl mb-5 text-sm flex items-start gap-2">
          <i class="fas fa-exclamation-triangle mt-0.5 flex-shrink-0"></i>
          <span>{{ session('warning') }}</span>
        </div>
      @endif
      @if($errors->any())
        <div class="bg-red-500/20 border border-red-400/30 text-red-300 p-3 rounded-xl mb-5 text-sm">
          <ul class="space-y-1">
            @foreach($errors->all() as $err)
              <li class="flex items-center gap-2"><i class="fas fa-times-circle text-xs"></i> {{ $err }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Info Card --}}
      <div class="bg-indigo-500/10 border border-indigo-400/20 rounded-2xl p-4 mb-6">
        <p class="text-indigo-200 text-xs leading-relaxed">
          <i class="fas fa-info-circle mr-1.5 text-indigo-400"></i>
          Masukkan <strong class="text-white">Nomor Pendaftaran</strong> dan <strong class="text-white">Tanggal Lahir</strong> yang Anda daftarkan saat SPMB untuk mengakses tes ini.
        </p>
      </div>

      {{-- Form --}}
      <form action="{{ route('spmb.tes-gaya-belajar.login.post') }}" method="POST" id="loginTesForm" class="space-y-5" novalidate>
        @csrf

        {{-- No. Pendaftaran --}}
        <div>
          <label for="no_daftar" class="input-label block mb-2">
            <i class="fas fa-id-card mr-1.5"></i>Nomor Pendaftaran <span class="text-red-400">*</span>
          </label>
          <div class="relative">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-indigo-400 text-sm pointer-events-none">
              <i class="fas fa-hashtag"></i>
            </div>
            <input
              type="text"
              id="no_daftar"
              name="no_daftar"
              required
              placeholder="Contoh: MSB26-01-001"
              value="{{ old('no_daftar') }}"
              class="input-field w-full pl-10 pr-4 py-3 rounded-xl text-sm font-mono tracking-wider uppercase"
              autocomplete="off"
              oninput="this.value = this.value.toUpperCase()"
            >
          </div>
          @error('no_daftar')
            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Tanggal Lahir --}}
        <div>
          <label for="tanggal_lahir" class="input-label block mb-2">
            <i class="fas fa-calendar-alt mr-1.5"></i>Tanggal Lahir <span class="text-red-400">*</span>
          </label>
          <input
            type="date"
            id="tanggal_lahir"
            name="tanggal_lahir"
            required
            value="{{ old('tanggal_lahir') }}"
            class="input-field w-full px-4 py-3 rounded-xl text-sm"
            max="{{ date('Y-m-d') }}"
          >
          @error('tanggal_lahir')
            <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Submit --}}
        <button
          type="submit"
          id="btnLogin"
          class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3.5 rounded-xl transition-all shadow-lg shadow-indigo-500/30 flex items-center justify-center gap-2.5 text-sm mt-2"
        >
          <i class="fas fa-brain"></i>
          Masuk & Mulai Tes
        </button>
      </form>

      {{-- Footer links --}}
      <div class="mt-6 pt-5 border-t border-white/10 flex flex-col items-center gap-3">
        <a href="{{ url('/informasi/spmb') }}" class="text-slate-400 hover:text-white text-xs transition-colors flex items-center gap-1.5">
          <i class="fas fa-arrow-left"></i> Kembali ke Info SPMB
        </a>
        <a href="{{ route('spmb.login') }}" class="text-indigo-400 hover:text-indigo-200 text-xs transition-colors flex items-center gap-1.5">
          <i class="fas fa-user-circle"></i> Login sebagai Calon Siswa
        </a>
      </div>
    </div>

    {{-- Note --}}
    <p class="text-center text-xs text-slate-500 mt-5">
      <i class="fas fa-shield-alt mr-1"></i>
      Data Anda aman dan hanya digunakan untuk keperluan seleksi.
    </p>
  </div>
</div>
@endsection

@section('script')
<script>
  document.getElementById('loginTesForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnLogin');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memverifikasi...';
  });
</script>
@endsection
