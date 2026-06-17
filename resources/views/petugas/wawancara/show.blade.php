@extends('layouts.petugas')
@section('title', 'Wawancara & Tes: ' . $pendaftaran->no_daftar)
@section('subtitle', 'Uji keagamaan, kepribadian, gaya belajar, dan minat bakat calon siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  
  <div class="flex items-center gap-3 mb-4">
    <a href="{{ route('petugas.wawancara.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1 text-sm font-semibold">
      <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Detail Siswa --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 space-y-4">
      <div class="text-center pb-4 border-b border-slate-50">
        @if($pendaftaran->foto_siswa)
          <img src="{{ asset('storage/' . $pendaftaran->foto_siswa) }}" class="w-28 h-36 object-cover mx-auto rounded-xl border-4 border-slate-100 shadow-sm">
        @else
          <div class="w-28 h-36 bg-slate-100 mx-auto rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center">
            <i class="fas fa-user text-slate-300 text-3xl mb-1"></i>
            <span class="text-xxs text-slate-400">Belum difoto</span>
          </div>
        @endif
        <h3 class="font-bold text-slate-800 text-sm mt-3">{{ $pendaftaran->nama_lengkap }}</h3>
        <p class="text-slate-400 text-xxs font-mono mt-1">{{ $pendaftaran->no_daftar }}</p>
      </div>

      <div class="space-y-2.5 text-xs">
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Asal Sekolah</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->asal_sekolah }}</span>
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Jenis Kelamin</span>
          <span class="text-slate-800 font-bold mt-0.5 block">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span>
        </div>
        <div>
          <span class="text-slate-400 block font-semibold uppercase text-xxs">Pilihan Jurusan I</span>
          <span class="text-blue-700 font-bold mt-0.5 block">{{ $pendaftaran->pil1 }}</span>
        </div>
      </div>
    </div>

    {{-- Form Wawancara --}}
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-comments text-purple-600"></i>
        <h4 class="font-bold text-slate-850 text-sm">Formulir Wawancara &amp; Pemetaan Gaya Belajar</h4>
      </div>

      <form method="POST" action="{{ route('petugas.wawancara.update', $pendaftaran->id) }}" class="p-6 space-y-6">
        @csrf @method('PUT')

        {{-- Section: Gaya Belajar --}}
        <div class="space-y-4">
          <h5 class="text-xs font-bold text-purple-700 uppercase tracking-wider pb-1.5 border-b border-slate-100">
            I. Gaya Belajar &amp; Pemetaan Jurusan
          </h5>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="sm:col-span-1">
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Tipe Gaya Belajar <span class="text-red-500">*</span></label>
              <select name="gaya_belajar_tipe" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
                <option value="">-- Pilih Tipe --</option>
                <option value="visual" {{ old('gaya_belajar_tipe', $pendaftaran->gaya_belajar_tipe) === 'visual' ? 'selected' : '' }}>Visual</option>
                <option value="auditori" {{ old('gaya_belajar_tipe', $pendaftaran->gaya_belajar_tipe) === 'auditori' ? 'selected' : '' }}>Auditori</option>
                <option value="kinestetik" {{ old('gaya_belajar_tipe', $pendaftaran->gaya_belajar_tipe) === 'kinestetik' ? 'selected' : '' }}>Kinestetik</option>
              </select>
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Minat Bakat / Hobi <span class="text-red-500">*</span></label>
              <input type="text" name="gaya_belajar_minat_bakat" required value="{{ old('gaya_belajar_minat_bakat', $pendaftaran->gaya_belajar_minat_bakat) }}" placeholder="Contoh: Bongkar pasang mesin, Programming, Desain Grafis"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Gaya Belajar &amp; Minat</label>
            <textarea name="gaya_belajar_catatan" rows="2" placeholder="Catatan kelebihan/kekurangan belajar siswa..."
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 resize-none">{{ old('gaya_belajar_catatan', $pendaftaran->gaya_belajar_catatan) }}</textarea>
          </div>
        </div>

        {{-- Section: Wawancara --}}
        <div class="space-y-4">
          <h5 class="text-xs font-bold text-purple-700 uppercase tracking-wider pb-1.5 border-b border-slate-100">
            II. Wawancara Keagamaan &amp; Kepribadian
          </h5>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Kemampuan Baca Tulis Al-Qur'an <span class="text-red-500">*</span></label>
              <input type="text" name="wawancara_baca_tulis_alquran" required value="{{ old('wawancara_baca_tulis_alquran', $pendaftaran->wawancara_baca_tulis_alquran) }}" placeholder="Contoh: Lancar / Iqra / Belum bisa"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Kedisiplinan Sholat 5 Waktu <span class="text-red-500">*</span></label>
              <input type="text" name="wawancara_solat_fardhu" required value="{{ old('wawancara_solat_fardhu', $pendaftaran->wawancara_solat_fardhu) }}" placeholder="Contoh: Rajin / Kadang-kadang / Jarang"
                     class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
            </div>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Hasil Pengamatan Kepribadian / Sikap <span class="text-red-500">*</span></label>
            <input type="text" name="wawancara_kepribadian" required value="{{ old('wawancara_kepribadian', $pendaftaran->wawancara_kepribadian) }}" placeholder="Contoh: Sopan, Santun, Percaya diri, Pemalu"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Wawancara Khusus</label>
            <textarea name="wawancara_catatan" rows="3" placeholder="Catatan khusus kesepakatan orang tua, komitmen kepatuhan tata tertib sekolah, dll..."
                      class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-purple-100 focus:border-purple-500 outline-none text-sm text-slate-800 resize-none">{{ old('wawancara_catatan', $pendaftaran->wawancara_catatan) }}</textarea>
          </div>
        </div>

        <button type="submit" class="w-full py-3 bg-purple-650 hover:bg-purple-700 text-white font-bold rounded-xl text-sm transition">
          Simpan Hasil Wawancara &amp; Tes
        </button>
      </form>
    </div>

  </div>

</div>
@endsection
