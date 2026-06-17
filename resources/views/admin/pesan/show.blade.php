@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('subtitle', 'Detail isi pesan masuk')

@section('content')
<div class="max-w-3xl space-y-6">
  
  {{-- Back Button --}}
  <div>
    <a href="{{ route('admin.pesan.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-800 transition">
      <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesan
    </a>
  </div>

  {{-- Message Detail Card --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Card Header --}}
    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-primary uppercase tracking-wider mb-2">
            {{ $pesan->subjek }}
          </span>
          <h2 class="text-xl font-bold text-slate-800 leading-tight">
            {{ $pesan->subjek }}
          </h2>
          <p class="text-xs text-slate-400 mt-1">
            Diterima pada: {{ $pesan->created_at->translatedFormat('d F Y, H:i') }} ({{ $pesan->created_at->diffForHumans() }})
          </p>
        </div>
        <div>
          <form method="POST" action="{{ route('admin.pesan.destroy', $pesan) }}"
                onsubmit="return confirm('Hapus pesan ini?')">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex items-center gap-2 text-sm text-red-650 hover:text-white bg-red-50 hover:bg-red-600 border border-red-200 px-4 py-2.5 rounded-xl transition">
              <i class="fas fa-trash"></i> Hapus Pesan
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- Sender Info --}}
    <div class="px-8 py-6 border-b border-slate-100 grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Pengirim</h4>
        <p class="text-sm font-semibold text-slate-800">{{ $pesan->nama }}</p>
      </div>
      <div>
        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Alamat Email</h4>
        <a href="mailto:{{ $pesan->email }}" class="text-sm font-semibold text-primary hover:underline flex items-center gap-1.5">
          {{ $pesan->email }} <i class="fas fa-external-link-alt text-xxs"></i>
        </a>
      </div>
    </div>

    {{-- Message Body --}}
    <div class="px-8 py-8">
      <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Isi Pesan</h4>
      <div class="bg-slate-50 dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800 text-slate-700 dark:text-slate-300 leading-relaxed text-sm whitespace-pre-line">
        {{ $pesan->pesan }}
      </div>
    </div>

    {{-- Reply Action Box --}}
    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="text-xs text-slate-400">Ingin membalas pengirim? Kirim email balasan langsung melalui tombol di samping.</p>
      <a href="mailto:{{ $pesan->email }}?subject=Balasan: {{ rawurlencode($pesan->subjek) }}" 
         class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition shadow-md shadow-primary/20">
        <i class="fas fa-reply"></i> Balas via Email
      </a>
    </div>

  </div>

</div>
@endsection
