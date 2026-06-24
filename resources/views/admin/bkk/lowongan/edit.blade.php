@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.bkk.lowongan.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Ubah Lowongan Kerja</span>
</span>
@endsection
@section('subtitle', 'Ubah informasi lowongan pekerjaan dari mitra industri')

@section('content')
<div class="max-w-4xl">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="{{ route('admin.bkk.lowongan.update', $lowongan) }}" enctype="multipart/form-data" class="p-6 space-y-8">
      @csrf
      @method('PUT')

      {{-- Section 1: Informasi Perusahaan --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-building mr-1 text-primary"></i> 1. Informasi Perusahaan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="nama_perusahaan" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Perusahaan <span class="text-red-500">*</span></label>
            <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $lowongan->nama_perusahaan) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Contoh: PT Astra Honda Motor">
            @error('nama_perusahaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="logo_perusahaan" class="block text-sm font-medium text-slate-700 mb-1.5">Logo Perusahaan</label>
            @if($lowongan->logo_perusahaan)
              <div class="flex items-center gap-3 mb-2">
                <img src="{{ $lowongan->logo_src }}" class="w-12 h-12 rounded-xl object-cover border border-slate-100 bg-slate-50">
                <span class="text-xs text-slate-500">Logo saat ini</span>
              </div>
            @endif
            <input type="file" id="logo_perusahaan" name="logo_perusahaan" accept="image/*"
              class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100 transition">
            <p class="text-xxs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah logo. Maks: 2MB.</p>
            @error('logo_perusahaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="md:col-span-2">
            <label for="lokasi" class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi Perusahaan / Penempatan <span class="text-red-500">*</span></label>
            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Contoh: Cikarang, Bekasi atau Yogyakarta">
            @error('lokasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Section 2: Detail Pekerjaan --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-briefcase mr-1 text-primary"></i> 2. Detail Pekerjaan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="posisi" class="block text-sm font-medium text-slate-700 mb-1.5">Posisi Pekerjaan <span class="text-red-500">*</span></label>
            <input type="text" id="posisi" name="posisi" value="{{ old('posisi', $lowongan->posisi) }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Contoh: Operator Produksi, Mekanik, Programmer">
            @error('posisi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="tipe_pekerjaan" class="block text-sm font-medium text-slate-700 mb-1.5">Tipe Pekerjaan <span class="text-red-500">*</span></label>
            <select id="tipe_pekerjaan" name="tipe_pekerjaan" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="Full Time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
              <option value="Part Time" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Part Time' ? 'selected' : '' }}>Part Time</option>
              <option value="Magang" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Magang' ? 'selected' : '' }}>Magang (Internship)</option>
              <option value="Kontrak" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
            </select>
            @error('tipe_pekerjaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="jurusan_relevan" class="block text-sm font-medium text-slate-700 mb-1.5">Jurusan Relevan</label>
            <input type="text" id="jurusan_relevan" name="jurusan_relevan" value="{{ old('jurusan_relevan', $lowongan->jurusan_relevan) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Contoh: RPL, TKR, TBSM atau Semua Jurusan">
            @error('jurusan_relevan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="batas_lamaran" class="block text-sm font-medium text-slate-700 mb-1.5">Batas Akhir Lamaran <span class="text-red-500">*</span></label>
            <input type="date" id="batas_lamaran" name="batas_lamaran" value="{{ old('batas_lamaran', $lowongan->batas_lamaran ? $lowongan->batas_lamaran->format('Y-m-d') : '') }}" required
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('batas_lamaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Section 3: Deskripsi & Persyaratan --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-file-alt mr-1 text-primary"></i> 3. Deskripsi & Persyaratan
        </h3>
        <div class="space-y-6">
          <div>
            <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Pekerjaan / Informasi Tambahan</label>
            <textarea id="deskripsi" name="deskripsi" rows="5"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-y"
              placeholder="Jelaskan mengenai tugas pekerjaan, tunjangan, jam kerja, atau hal penting lainnya...">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="brosur" class="block text-sm font-medium text-slate-700 mb-1.5">Brosur Lowongan (Flyer / Poster)</label>
            @if($lowongan->brosur)
              <div class="flex items-center gap-3 mb-2">
                <img src="{{ $lowongan->brosur_src }}" class="w-16 h-20 rounded-xl object-cover border border-slate-100 bg-slate-50">
                <span class="text-xs text-slate-500">Brosur saat ini</span>
              </div>
            @endif
            <input type="file" id="brosur" name="brosur" accept="image/*"
              class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-primary hover:file:bg-orange-100 transition">
            <p class="text-xxs text-slate-400 mt-1">Biarkan kosong jika tidak ingin mengubah brosur. Maks: 4MB.</p>
            @error('brosur') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <div class="flex items-center justify-between mb-2">
              <label class="block text-sm font-medium text-slate-700">Daftar Persyaratan Lamaran</label>
              <button type="button" onclick="addPersyaratan()" class="inline-flex items-center gap-1 text-xs text-primary hover:text-secondary font-semibold">
                <i class="fas fa-plus-circle"></i> Tambah Baris
              </button>
            </div>
            <div id="persyaratan-container" class="space-y-2">
              @php $oldPersyaratan = old('persyaratan', $lowongan->persyaratan ?? ['']); @endphp
              @if(empty($oldPersyaratan))
                @php $oldPersyaratan = ['']; @endphp
              @endif
              @foreach($oldPersyaratan as $req)
                <div class="flex items-center gap-2 persyaratan-row">
                  <input type="text" name="persyaratan[]" value="{{ $req }}" required
                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
                    placeholder="Contoh: Laki-laki, usia maksimal 22 tahun...">
                  <button type="button" onclick="removePersyaratan(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </div>
              @endforeach
            </div>
            @error('persyaratan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      {{-- Section 4: Kontak & Publikasi --}}
      <div>
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100 mb-4">
          <i class="fas fa-paper-plane mr-1 text-primary"></i> 4. Kontak & Publikasi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="kontak_lamaran" class="block text-sm font-medium text-slate-700 mb-1.5">Kontak Pengiriman Lamaran</label>
            <input type="text" id="kontak_lamaran" name="kontak_lamaran" value="{{ old('kontak_lamaran', $lowongan->kontak_lamaran) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Contoh: recruitment@perusahaan.com atau Link pendaftaran / Nomor WA">
            @error('kontak_lamaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="urutan" class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampilan</label>
            <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $lowongan->urutan) }}"
              class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
            @error('urutan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="md:col-span-2">
            <label class="inline-flex items-center gap-2 cursor-pointer mt-2">
              <input type="checkbox" name="aktif" value="1" {{ old('aktif', $lowongan->aktif) ? 'checked' : '' }}
                class="rounded border-slate-300 text-primary focus:ring-primary/30">
              <span class="text-sm font-medium text-slate-700">Tampilkan lowongan ini di halaman publik</span>
            </label>
          </div>
        </div>
      </div>

      <div class="flex gap-3 pt-4 border-t border-slate-100">
        <button type="submit" class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Perbarui Lowongan
        </button>
        <a href="{{ route('admin.bkk.lowongan.index') }}" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function addPersyaratan() {
    const container = document.getElementById('persyaratan-container');
    const newRow = document.createElement('div');
    newRow.className = 'flex items-center gap-2 persyaratan-row';
    newRow.innerHTML = `
      <input type="text" name="persyaratan[]" value="" required
        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
        placeholder="Contoh: Laki-laki, usia maksimal 22 tahun...">
      <button type="button" onclick="removePersyaratan(this)" class="p-2.5 text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
        <i class="fas fa-trash-alt"></i>
      </button>
    `;
    container.appendChild(newRow);
  }

  function removePersyaratan(button) {
    const row = button.closest('.persyaratan-row');
    const container = document.getElementById('persyaratan-container');
    if (container.querySelectorAll('.persyaratan-row').length > 1) {
      row.remove();
    } else {
      row.querySelector('input').value = '';
    }
  }
</script>
@endsection
