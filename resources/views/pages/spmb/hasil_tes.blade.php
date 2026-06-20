@extends('layouts.app')
@section('title', 'Hasil Tes Gaya Belajar - SPMB')

@section('style')
<style>
  @keyframes popIn {
    0%   { opacity: 0; transform: scale(0.8); }
    70%  { transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
  }
  @keyframes slideUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .pop-in   { animation: popIn 0.6s ease-out both; }
  .slide-up { animation: slideUp 0.6s ease-out 0.3s both; }

  .result-ring {
    background: conic-gradient(#6366f1 var(--pct), #e2e8f0 0%);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
  }
</style>
@endsection

@section('content')
<div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-950 min-h-[85vh] flex items-center justify-center py-12 px-4">
  <div class="w-full max-w-md">

    {{-- Result Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-700 overflow-hidden pop-in">

      {{-- Header --}}
      <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-8 py-8 text-center relative overflow-hidden">
        <div class="absolute -top-8 -right-8 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="relative">
          <div class="inline-flex w-16 h-16 bg-white/20 rounded-2xl items-center justify-center text-white text-3xl mb-4 backdrop-blur-sm">
            <i class="fas fa-brain"></i>
          </div>
          <h1 class="text-xl font-extrabold text-white">Tes Gaya Belajar Selesai!</h1>
          <p class="text-indigo-200 text-xs mt-1">SMK Muhammadiyah 1 Bantul · SPMB 2026/2027</p>
        </div>
      </div>

      <div class="p-8 space-y-6 slide-up">

        {{-- Flash --}}
        @if(session('success'))
          <div class="flex items-start gap-3 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-2xl p-4 text-sm">
            <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        {{-- Info Siswa --}}
        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-4 border border-slate-100 dark:border-slate-700">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
              <i class="fas fa-user text-indigo-600 dark:text-indigo-400 text-sm"></i>
            </div>
            <div>
              <p class="font-bold text-slate-800 dark:text-white text-sm">{{ $pendaftaran->nama_lengkap }}</p>
              <p class="text-xs text-slate-400 font-mono">{{ $pendaftaran->no_daftar }}</p>
            </div>
          </div>
        </div>

        {{-- Result Badge --}}
        @php
          $tipe = $pendaftaran->gaya_belajar_tipe ?? 'visual';
          $styleMap = [
            'visual'     => ['color' => 'blue',   'icon' => 'fa-eye',        'label' => 'Visual',     'desc' => 'Anda belajar paling efektif melalui gambar, diagram, warna, dan tampilan visual. Manfaatkan mind map, video, dan buku bergambar!'],
            'auditori'   => ['color' => 'green',  'icon' => 'fa-headphones', 'label' => 'Auditori',   'desc' => 'Anda lebih mudah memahami materi lewat mendengar, berdiskusi, dan penjelasan lisan. Podcast dan rekaman suara cocok untuk Anda!'],
            'kinestetik' => ['color' => 'purple', 'icon' => 'fa-hand-paper', 'label' => 'Kinestetik', 'desc' => 'Anda belajar terbaik dengan cara langsung praktik, bergerak, dan mencoba sendiri. Eksperimen dan proyek nyata adalah kunci Anda!'],
          ];
          $st = $styleMap[$tipe] ?? $styleMap['visual'];
          $minat = $pendaftaran->gaya_belajar_minat_bakat ?? '-';
        @endphp

        <div class="text-center">
          <div class="inline-flex flex-col items-center gap-4 p-6 rounded-3xl bg-{{ $st['color'] }}-50 dark:bg-{{ $st['color'] }}-950/20 border-2 border-{{ $st['color'] }}-200 dark:border-{{ $st['color'] }}-800 w-full">
            <div class="w-20 h-20 bg-{{ $st['color'] }}-100 dark:bg-{{ $st['color'] }}-900/40 rounded-full flex items-center justify-center text-{{ $st['color'] }}-600 dark:text-{{ $st['color'] }}-400 text-3xl shadow-inner">
              <i class="fas {{ $st['icon'] }}"></i>
            </div>
            <div>
              <p class="text-xs font-bold text-{{ $st['color'] }}-500 uppercase tracking-widest mb-1">Tipe Gaya Belajar Anda</p>
              <h2 class="text-3xl font-extrabold text-{{ $st['color'] }}-700 dark:text-{{ $st['color'] }}-300 capitalize">{{ ucfirst($tipe) }}</h2>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed text-center">{{ $st['desc'] }}</p>
          </div>
        </div>

        {{-- Minat Bakat --}}
        @if($minat && $minat !== '-')
        <div class="bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800 rounded-2xl p-4">
          <p class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wide mb-1.5 flex items-center gap-2">
            <i class="fas fa-star"></i> Minat, Bakat & Hobi
          </p>
          <p class="text-sm text-slate-700 dark:text-slate-300 leading-relaxed">{{ $minat }}</p>
        </div>
        @endif

        {{-- Info --}}
        <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900 rounded-2xl p-4">
          <p class="text-xs text-blue-700 dark:text-blue-300 leading-relaxed">
            <i class="fas fa-info-circle mr-1.5"></i>
            Hasil tes ini akan digunakan oleh pihak sekolah untuk membantu proses pembelajaran yang sesuai dengan gaya belajar Anda. <strong>Simpan screenshot ini</strong> sebagai bukti bahwa Anda sudah mengikuti tes.
          </p>
        </div>

        {{-- Action Buttons --}}
        <div class="flex flex-col gap-3 pt-1">
          <a href="{{ url('/informasi/spmb') }}"
             class="w-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-semibold py-3 px-6 rounded-xl transition-all text-sm text-center flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Info SPMB
          </a>
          <a href="{{ route('spmb.tes-gaya-belajar.login') }}"
             class="text-xs text-center text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fas fa-sign-out-alt mr-1"></i> Keluar
          </a>
        </div>

      </div>
    </div>

    <p class="text-center text-xs text-slate-400 mt-5">
      &copy; {{ date('Y') }} TIM IT MUSABA · SMK Muhammadiyah 1 Bantul
    </p>
  </div>
</div>
@endsection
