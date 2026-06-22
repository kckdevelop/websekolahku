@extends('layouts.admin')
@section('title')
<span class="inline-flex items-center gap-2">
  <a href="{{ route('admin.pendaftaran.show', $pendaftaran) }}" class="text-slate-400 hover:text-slate-600 transition-colors mr-1">
    <i class="fas fa-arrow-left text-base"></i>
  </a>
  <span>Ubah Data Pendaftar ({{ $pendaftaran->no_daftar }})</span>
  <span class="ml-2 text-xs font-semibold text-slate-400 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md">Tahun: {{ $pendaftaran->tahun_aktif }}</span>
</span>
@endsection
@section('subtitle', 'Sunting data pendaftaran siswa baru')

@section('content')
<div class="max-w-4xl">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    


    {{-- Form --}}
    <form method="POST" action="{{ route('admin.pendaftaran.update', $pendaftaran) }}" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
      @csrf
      @method('PUT')

      @php
        $tglLahir = $pendaftaran->tanggal_lahir;
        $selTgl = $tglLahir ? $tglLahir->day : null;
        $selBulan = $tglLahir ? $tglLahir->format('m') : null;
        $selTahun = $tglLahir ? $tglLahir->year : null;
      @endphp

      {{-- Section 1: Data Calon Siswa --}}
      <div class="space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100"><i class="fas fa-user mr-1.5 text-primary"></i> Data Calon Siswa</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          {{-- Nama Lengkap --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pendaftaran->nama_lengkap) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('nama_lengkap') border-red-400 @enderror"
              placeholder="Nama lengkap pendaftar...">
            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Tempat Lahir --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $pendaftaran->tempat_lahir) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Tempat lahir...">
          </div>

          {{-- Tanggal Lahir --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-3 gap-2">
              <select name="tgl" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                <option value="">Tgl</option>
                @for($i = 1; $i <= 31; $i++)
                  <option value="{{ $i }}" {{ old('tgl', $selTgl) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
              </select>
              <select name="bulan" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                <option value="">Bulan</option>
                @foreach(['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $key => $name)
                  <option value="{{ $key }}" {{ old('bulan', $selBulan) == $key ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
              </select>
              <select name="tahun" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
                <option value="">Tahun</option>
                @for($y = 2000; $y <= 2020; $y++)
                  <option value="{{ $y }}" {{ old('tahun', $selTahun) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
              </select>
            </div>
          </div>

          {{-- Jenis Kelamin --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
            <select name="jenkel" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="">-- Pilih Jenis Kelamin --</option>
              <option value="L" {{ old('jenkel', $pendaftaran->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
              <option value="P" {{ old('jenkel', $pendaftaran->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
          </div>

          {{-- Agama --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Agama <span class="text-red-500">*</span></label>
            <select name="agama" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="islam" {{ old('agama', $pendaftaran->agama) == 'islam' ? 'selected' : '' }}>Islam</option>
              <option value="kristen" {{ old('agama', $pendaftaran->agama) == 'kristen' ? 'selected' : '' }}>Kristen</option>
              <option value="katolik" {{ old('agama', $pendaftaran->agama) == 'katolik' ? 'selected' : '' }}>Katolik</option>
              <option value="hindu" {{ old('agama', $pendaftaran->agama) == 'hindu' ? 'selected' : '' }}>Hindu</option>
              <option value="budha" {{ old('agama', $pendaftaran->agama) == 'budha' ? 'selected' : '' }}>Budha</option>
            </select>
          </div>

          {{-- No HP Siswa --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP Siswa <span class="text-red-500">*</span></label>
            <input type="text" name="no_hp_siswa" value="{{ old('no_hp_siswa', $pendaftaran->no_hp_siswa) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="No. Telp aktif siswa...">
          </div>

          {{-- Asal Sekolah --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Asal Sekolah <span class="text-red-500">*</span></label>
            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $pendaftaran->asal_sekolah) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Nama SMP/MTs Asal...">
          </div>

          {{-- Alamat Sekolah --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Sekolah Asal</label>
            <textarea name="alamat_sekolah" rows="2"
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none"
              placeholder="Alamat lengkap SMP/MTs asal...">{{ old('alamat_sekolah', $pendaftaran->alamat_sekolah) }}</textarea>
          </div>

          {{-- Prestasi --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Prestasi yang Pernah Diraih</label>
            <textarea name="prestasi" rows="2"
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none"
              placeholder="Prestasi yang pernah diraih...">{{ old('prestasi', $pendaftaran->prestasi) }}</textarea>
          </div>
        </div>
      </div>

      {{-- Section 2: Data Orang Tua --}}
      <div class="space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100"><i class="fas fa-users mr-1.5 text-primary"></i> Data Orang Tua / Wali</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Orang Tua <span class="text-red-500">*</span></label>
            <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $pendaftaran->nama_ortu) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Nama orang tua/wali...">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pekerjaan Orang Tua <span class="text-red-500">*</span></label>
            <input type="text" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu', $pendaftaran->pekerjaan_ortu) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="Pekerjaan orang tua...">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">No. HP Orang Tua <span class="text-red-500">*</span></label>
            <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $pendaftaran->no_hp_ortu) }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
              placeholder="No. Telp aktif orang tua...">
          </div>
        </div>
      </div>

      {{-- Section 3: Alamat --}}
      <div class="space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100"><i class="fas fa-map-marked-alt mr-1.5 text-primary"></i> Alamat Lengkap</h3>
        
        {{-- Alamat Asal --}}
        <div>
          <h4 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Alamat Asal (Sesuai KK)</h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
              <label class="block text-xs font-semibold text-slate-500 mb-1">Jalan</label>
              <input type="text" name="jalan_asal" id="jalan_asal" value="{{ old('jalan_asal', $pendaftaran->jalan_asal) }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Nama Jalan...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Dusun</label>
              <input type="text" name="dusun_asal" id="dusun_asal" value="{{ old('dusun_asal', $pendaftaran->dusun_asal) }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Dusun...">
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">RT <span class="text-red-500">*</span></label>
                <input type="text" name="rt_asal" id="rt_asal" value="{{ old('rt_asal', $pendaftaran->rt_asal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">RW</label>
                <input type="text" name="rw_asal" id="rw_asal" value="{{ old('rw_asal', $pendaftaran->rw_asal) }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
              </div>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Desa <span class="text-red-500">*</span></label>
              <input type="text" name="desa_asal" id="desa_asal" value="{{ old('desa_asal', $pendaftaran->desa_asal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Desa...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan <span class="text-red-500">*</span></label>
              <input type="text" name="kecamatan_asal" id="kecamatan_asal" value="{{ old('kecamatan_asal', $pendaftaran->kecamatan_asal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Kecamatan...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Kabupaten <span class="text-red-500">*</span></label>
              <input type="text" name="kabupaten_asal" id="kabupaten_asal" value="{{ old('kabupaten_asal', $pendaftaran->kabupaten_asal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Kabupaten...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi <span class="text-red-500">*</span></label>
              <input type="text" name="provinsi_asal" id="provinsi_asal" value="{{ old('provinsi_asal', $pendaftaran->provinsi_asal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Provinsi...">
            </div>
          </div>
        </div>

        <div class="flex items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
          <input type="checkbox" id="copy_address" onclick="copyAddressFields()" class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary">
          <label for="copy_address" class="ml-3 text-sm font-semibold text-slate-700 cursor-pointer">
            Centang jika Alamat Tinggal Sekarang sama dengan Alamat Asal
          </label>
        </div>

        {{-- Alamat Tinggal --}}
        <div>
          <h4 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Alamat Tinggal Sekarang</h4>
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
              <label class="block text-xs font-semibold text-slate-500 mb-1">Jalan</label>
              <input type="text" name="jalan_tinggal" id="jalan_tinggal" value="{{ old('jalan_tinggal', $pendaftaran->jalan_tinggal) }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Nama Jalan...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Dusun</label>
              <input type="text" name="dusun_tinggal" id="dusun_tinggal" value="{{ old('dusun_tinggal', $pendaftaran->dusun_tinggal) }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Dusun...">
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">RT <span class="text-red-500">*</span></label>
                <input type="text" name="rt_tinggal" id="rt_tinggal" value="{{ old('rt_tinggal', $pendaftaran->rt_tinggal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
              </div>
              <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">RW</label>
                <input type="text" name="rw_tinggal" id="rw_tinggal" value="{{ old('rw_tinggal', $pendaftaran->rw_tinggal) }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
              </div>
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Desa <span class="text-red-500">*</span></label>
              <input type="text" name="desa_tinggal" id="desa_tinggal" value="{{ old('desa_tinggal', $pendaftaran->desa_tinggal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Desa...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan <span class="text-red-500">*</span></label>
              <input type="text" name="kecamatan_tinggal" id="kecamatan_tinggal" value="{{ old('kecamatan_tinggal', $pendaftaran->kecamatan_tinggal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Kecamatan...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Kabupaten <span class="text-red-500">*</span></label>
              <input type="text" name="kabupaten_tinggal" id="kabupaten_tinggal" value="{{ old('kabupaten_tinggal', $pendaftaran->kabupaten_tinggal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Kabupaten...">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi <span class="text-red-500">*</span></label>
              <input type="text" name="provinsi_tinggal" id="provinsi_tinggal" value="{{ old('provinsi_tinggal', $pendaftaran->provinsi_tinggal) }}" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="Provinsi...">
            </div>
          </div>
        </div>
      </div>

      {{-- Section 4: Pilihan Jurusan --}}
      <div class="space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100"><i class="fas fa-graduation-cap mr-1.5 text-primary"></i> Pilihan Kompetensi Keahlian (Jurusan)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @php
            $jurusans = [
              'TKR' => 'Teknik Kendaraan Ringan (Otomotif)',
              'TPM' => 'Teknik Permesinan',
              'TAV' => 'Teknik Audio Video (Elektronika)',
              'TBSM' => 'Teknik Bisnis Sepeda Motor',
              'RPL' => 'Rekayasa Perangkat Lunak (Komputer)'
            ];
          @endphp
          
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilihan I <span class="text-red-500">*</span></label>
            <select name="pil1" id="pil1" required onchange="validateJurusan()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="">-- Pilihan Jurusan I --</option>
              @foreach($jurusans as $code => $name)
                <option value="{{ $code }}" {{ $pendaftaran->pil1 == $code ? 'selected' : '' }}>{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilihan II <span class="text-red-500">*</span></label>
            <select name="pil2" id="pil2" required onchange="validateJurusan()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="">-- Pilihan Jurusan II --</option>
              @foreach($jurusans as $code => $name)
                <option value="{{ $code }}" {{ $pendaftaran->pil2 == $code ? 'selected' : '' }}>{{ $name }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Pilihan III <span class="text-red-500">*</span></label>
            <select name="pil3" id="pil3" required onchange="validateJurusan()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="">-- Pilihan Jurusan III --</option>
              @foreach($jurusans as $code => $name)
                <option value="{{ $code }}" {{ $pendaftaran->pil3 == $code ? 'selected' : '' }}>{{ $name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <p id="jurusan-error" class="hidden text-xs text-red-500 font-medium"><i class="fas fa-exclamation-circle mr-1"></i> Pilihan jurusan tidak boleh ada yang sama!</p>
      </div>

      {{-- Section 5: Status & Berkas --}}
      <div class="space-y-6">
        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider pb-2 border-b border-slate-100"><i class="fas fa-file-upload mr-1.5 text-primary"></i> Berkas & Status</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {{-- Gelombang --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Gelombang Pendaftaran <span class="text-red-500">*</span></label>
            <select name="gelombang_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              @foreach($gelombangs as $g)
                <option value="{{ $g->id }}" {{ $pendaftaran->gelombang == $g->nama_gelombang ? 'selected' : ($g->is_aktif && !$pendaftaran->gelombang ? 'selected' : '') }}>
                  {{ $g->nama_gelombang }} ({{ $g->tahun_ajaran }}) {{ $g->is_aktif ? '— Aktif' : '' }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Status --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Pendaftaran <span class="text-red-500">*</span></label>
            <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
              <option value="pending" {{ $pendaftaran->status == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="verifikasi" {{ $pendaftaran->status == 'verifikasi' ? 'selected' : '' }}>Verifikasi</option>
              <option value="diterima" {{ $pendaftaran->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
              <option value="ditolak" {{ $pendaftaran->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
          </div>

          {{-- Akta --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Akta Kelahiran (Optional)</label>
            <input type="file" name="foto_akta" accept="image/*,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer mb-2">
            @if($pendaftaran->foto_akta)
              <p class="text-xs text-emerald-600 font-medium"><i class="fas fa-check"></i> File Akta Terupload: <a href="{{ asset('storage/' . $pendaftaran->foto_akta) }}" target="_blank" class="text-primary hover:underline font-bold">Lihat File</a></p>
            @endif
          </div>

          {{-- KK --}}
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kartu Keluarga [KK] (Optional)</label>
            <input type="file" name="foto_kk" accept="image/*,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer mb-2">
            @if($pendaftaran->foto_kk)
              <p class="text-xs text-emerald-600 font-medium"><i class="fas fa-check"></i> File KK Terupload: <a href="{{ asset('storage/' . $pendaftaran->foto_kk) }}" target="_blank" class="text-primary hover:underline font-bold">Lihat File</a></p>
            @endif
          </div>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
        <button type="submit" id="submit-btn" class="bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30 inline-flex items-center gap-2">
          <i class="fas fa-save"></i> Perbarui Data
        </button>
        <a href="{{ route('admin.pendaftaran.show', $pendaftaran) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
          Batal
        </a>
      </div>

    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  function copyAddressFields() {
    const isChecked = document.getElementById('copy_address').checked;
    const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
    
    fields.forEach(field => {
      const sourceVal = document.getElementById(field + '_asal').value;
      const targetInput = document.getElementById(field + '_tinggal');
      if (isChecked) {
        targetInput.value = sourceVal;
        targetInput.setAttribute('readonly', 'readonly');
        targetInput.classList.add('bg-slate-50', 'cursor-not-allowed');
      } else {
        targetInput.removeAttribute('readonly');
        targetInput.classList.remove('bg-slate-50', 'cursor-not-allowed');
      }
    });
  }

  const disabledClass = ['bg-slate-100', 'text-slate-400', 'cursor-not-allowed'];
  const enabledClass  = ['bg-white', 'text-slate-800'];

  function setSelectEnabled(select, enabled) {
    if (enabled) {
      select.disabled = false;
      select.classList.remove(...disabledClass);
      select.classList.add(...enabledClass);
    } else {
      select.disabled = true;
      select.value = '';
      select.classList.remove(...enabledClass);
      select.classList.add(...disabledClass);
    }
  }

  function validateJurusan() {
    const pil1 = document.getElementById('pil1');
    const pil2 = document.getElementById('pil2');
    const pil3 = document.getElementById('pil3');

    const pil1Val = pil1.value;
    const pil2Val = pil2.value;

    // Sequential enable/disable
    setSelectEnabled(pil2, pil1Val !== '');
    setSelectEnabled(pil3, pil1Val !== '' && pil2Val !== '');

    // Cascade reset
    if (pil1Val === '') { pil2.value = ''; pil3.value = ''; }
    if (pil2.value === '') { pil3.value = ''; }

    // Hide duplicate options
    const selects = [pil1, pil2, pil3];
    selects.forEach((select, index) => {
      const otherVals = selects
        .filter((_, idx) => idx !== index)
        .map(s => s.value)
        .filter(v => v !== '');

      Array.from(select.options).forEach(option => {
        if (option.value === '') return;
        if (otherVals.includes(option.value)) {
          option.disabled = true;
          option.classList.add('hidden');
        } else {
          option.disabled = false;
          option.classList.remove('hidden');
        }
      });
    });
  }

  // Initial sync on page load
  document.addEventListener('DOMContentLoaded', validateJurusan);
</script>
@endsection
