@extends('layouts.petugas')
@section('title', 'Pemeriksaan Kesehatan: ' . $pendaftaran->no_daftar)
@section('subtitle', 'Cek kondisi fisik calon siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
  
  <div class="flex items-center gap-3 mb-4">
    <a href="{{ route('petugas.kesehatan.dashboard') }}" class="text-slate-500 hover:text-slate-700 flex items-center gap-1 text-sm font-semibold">
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

    {{-- Form Pemeriksaan --}}
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-2">
        <i class="fas fa-heartbeat text-blue-600"></i>
        <h4 class="font-bold text-slate-850 text-sm">Formulir Pemeriksaan Kesehatan</h4>
      </div>

      <form method="POST" action="{{ route('petugas.kesehatan.update', $pendaftaran->id) }}" class="p-6 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
            <input type="text" name="kesehatan_tinggi_badan" value="{{ old('kesehatan_tinggi_badan', $pendaftaran->kesehatan_tinggi_badan) }}" required placeholder="Contoh: 165"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Berat Badan (kg) <span class="text-red-500">*</span></label>
            <input type="text" name="kesehatan_berat_badan" value="{{ old('kesehatan_berat_badan', $pendaftaran->kesehatan_berat_badan) }}" required placeholder="Contoh: 55"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Golongan Darah <span class="text-red-500">*</span></label>
            <select name="kesehatan_golongan_darah" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
              <option value="">-- Pilih --</option>
              @foreach(['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gol)
                <option value="{{ $gol }}" {{ old('kesehatan_golongan_darah', $pendaftaran->kesehatan_golongan_darah) === $gol ? 'selected' : '' }}>{{ $gol }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Terindikasi Buta Warna <span class="text-red-500">*</span></label>
            <select name="kesehatan_buta_warna" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
              <option value="tidak" {{ old('kesehatan_buta_warna', $pendaftaran->kesehatan_buta_warna) === 'tidak' ? 'selected' : '' }}>Tidak (Normal)</option>
              <option value="ya" {{ old('kesehatan_buta_warna', $pendaftaran->kesehatan_buta_warna) === 'ya' ? 'selected' : '' }}>Ya (Buta Warna)</option>
            </select>
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Mata Minus (Kanan/Kiri) <span class="text-red-500">*</span></label>
            <input type="text" name="kesehatan_mata_minus" value="{{ old('kesehatan_mata_minus', $pendaftaran->kesehatan_mata_minus) }}" required placeholder="Contoh: -1.5/-2.0 atau Tidak"
                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Kepemilikan Tato & Tindik <span class="text-red-500">*</span></label>
            <select name="kesehatan_tato_tindik" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
              <option value="tidak" {{ old('kesehatan_tato_tindik', $pendaftaran->kesehatan_tato_tindik) === 'tidak' ? 'selected' : '' }}>Tidak Bertato / Tidak Bertindik</option>
              <option value="tato" {{ old('kesehatan_tato_tindik', $pendaftaran->kesehatan_tato_tindik) === 'tato' ? 'selected' : '' }}>Ada Tato</option>
              <option value="tindik" {{ old('kesehatan_tato_tindik', $pendaftaran->kesehatan_tato_tindik) === 'tindik' ? 'selected' : '' }}>Ada Tindik (Khusus Laki-laki)</option>
              <option value="tato_tindik" {{ old('kesehatan_tato_tindik', $pendaftaran->kesehatan_tato_tindik) === 'tato_tindik' ? 'selected' : '' }}>Tato & Tindik</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Riwayat Penyakit Berat</label>
          <input type="text" name="kesehatan_riwayat_penyakit" value="{{ old('kesehatan_riwayat_penyakit', $pendaftaran->kesehatan_riwayat_penyakit) }}" placeholder="Asma, Jantung, Paru-paru, dll (kosongkan jika tidak ada)"
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Catatan Khusus Petugas UKS</label>
          <textarea name="kesehatan_catatan" rows="3" placeholder="Tambahkan catatan khusus hasil pemeriksaan fisik disini..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-100 focus:border-blue-500 outline-none text-sm text-slate-800 resize-none">{{ old('kesehatan_catatan', $pendaftaran->kesehatan_catatan) }}</textarea>
        </div>

        <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-sm transition">
          Simpan Hasil Pemeriksaan
        </button>
      </form>
    </div>

  </div>

</div>
@endsection
