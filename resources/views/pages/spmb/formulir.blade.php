@extends('layouts.app')
@section('title', 'Formulir Pendaftaran SPMB - Langkah ' . $step)

@section('content')
@php
  $jurusanList = [
    'TKR'  => 'Teknik Kendaraan Ringan (Otomotif)',
    'TPM'  => 'Teknik Permesinan',
    'TAV'  => 'Teknik Audio Video (Elektronika)',
    'TBSM' => 'Teknik Bisnis Sepeda Motor',
    'RPL'  => 'Rekayasa Perangkat Lunak (Komputer)',
  ];
  $steps = [
    1 => ['label' => 'Data Siswa',    'icon' => 'fa-user'],
    2 => ['label' => 'Data Orang Tua','icon' => 'fa-users'],
    3 => ['label' => 'Alamat',        'icon' => 'fa-map-marker-alt'],
    4 => ['label' => 'Jurusan',       'icon' => 'fa-graduation-cap'],
    5 => ['label' => 'Review',        'icon' => 'fa-check-circle'],
  ];
  $fd = $formData; // shorthand
@endphp

<div class="bg-slate-50 dark:bg-slate-900 min-h-screen py-10">
  <div class="max-w-3xl mx-auto px-4 sm:px-6">

    {{-- Header --}}
    <div class="text-center mb-8">
      <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white">Formulir Pendaftaran SPMB</h1>
      <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
        Login sebagai: <span class="font-bold text-primary">{{ $siswa->no_wa }}</span>
        &nbsp;|&nbsp;
        <form action="{{ route('spmb.logout') }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="text-red-400 hover:text-red-600 text-sm underline">Logout</button>
        </form>
      </p>
    </div>

    {{-- Progress Steps --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5 mb-6">
      <div class="flex items-center justify-between">
        @foreach($steps as $n => $s)
          <div class="flex flex-col items-center flex-1">
            <div class="relative flex items-center justify-center">
              {{-- Line before --}}
              @if($n > 1)
                <div class="absolute right-full w-full h-0.5 {{ $n <= $step ? 'bg-primary' : 'bg-slate-200 dark:bg-slate-600' }}"></div>
              @endif
              <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold z-10 transition-all
                {{ $n < $step ? 'bg-emerald-500 text-white' : ($n === $step ? 'bg-primary text-white ring-4 ring-primary/30' : 'bg-slate-100 dark:bg-slate-700 text-slate-400') }}">
                @if($n < $step)
                  <i class="fas fa-check text-xs"></i>
                @else
                  {{ $n }}
                @endif
              </div>
            </div>
            <span class="text-xs mt-1.5 font-medium hidden sm:block {{ $n === $step ? 'text-primary' : ($n < $step ? 'text-emerald-500' : 'text-slate-400') }}">{{ $s['label'] }}</span>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Alerts --}}
    @if ($errors->any())
      <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 p-4 rounded-xl mb-5">
        <div class="flex items-center gap-2 font-bold mb-2"><i class="fas fa-exclamation-triangle"></i> Mohon perbaiki:</div>
        <ul class="list-disc pl-5 text-sm space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- FORM STEP CONTENT --}}
    <form action="{{ route('spmb.formulir.simpan', $step) }}" method="POST" enctype="multipart/form-data">
      @csrf

      @if($step === 1)
      {{-- ════════════════════════════════════════ STEP 1: DATA SISWA ════════════════════════════════════════ --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8 space-y-5">
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
          <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
            <i class="fas fa-user text-sm"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800 dark:text-white">Data Calon Siswa</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="md:col-span-2">
            <label class="form-label">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama_lengkap" value="{{ $fd['nama_lengkap'] ?? old('nama_lengkap') }}" required
              class="form-input" placeholder="Sesuai Ijazah/Akte Kelahiran...">
          </div>

          <div>
            <label class="form-label">Tempat Lahir <span class="text-red-500">*</span></label>
            <input type="text" name="tempat_lahir" value="{{ $fd['tempat_lahir'] ?? old('tempat_lahir') }}" required
              class="form-input" placeholder="Kota/Kabupaten tempat lahir...">
          </div>

          <div>
            <label class="form-label">Tanggal Lahir <span class="text-red-500">*</span></label>
            <div class="grid grid-cols-3 gap-2">
              <select name="tgl" required class="form-select">
                <option value="">Tgl</option>
                @for($i = 1; $i <= 31; $i++)
                  <option value="{{ $i }}" {{ ($fd['tgl'] ?? old('tgl')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
              </select>
              <select name="bulan" required class="form-select">
                <option value="">Bulan</option>
                @foreach(['01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $k=>$v)
                  <option value="{{ $k }}" {{ ($fd['bulan'] ?? old('bulan')) == $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
              </select>
              <select name="tahun" required class="form-select">
                <option value="">Tahun</option>
                @for($y = 2000; $y <= 2020; $y++)
                  <option value="{{ $y }}" {{ ($fd['tahun'] ?? old('tahun')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
              </select>
            </div>
          </div>

          <div>
            <label class="form-label">Jenis Kelamin <span class="text-red-500">*</span></label>
            <select name="jenkel" required class="form-select w-full">
              <option value="">-- Pilih --</option>
              <option value="L" {{ ($fd['jenkel'] ?? old('jenkel')) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
              <option value="P" {{ ($fd['jenkel'] ?? old('jenkel')) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
          </div>

          <div>
            <label class="form-label">Agama <span class="text-red-500">*</span></label>
            <select name="agama" required class="form-select w-full">
              @foreach(['islam'=>'Islam','kristen'=>'Kristen','katolik'=>'Katolik','hindu'=>'Hindu','budha'=>'Budha'] as $k=>$v)
                <option value="{{ $k }}" {{ ($fd['agama'] ?? old('agama','islam')) == $k ? 'selected' : '' }}>{{ $v }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="form-label">No. HP / WhatsApp Siswa</label>
            <input type="text" class="form-input bg-slate-100 dark:bg-slate-700/50 cursor-not-allowed text-slate-400"
              value="{{ $siswa->no_wa }}" readonly disabled>
            <p class="text-xs text-slate-400 mt-1"><i class="fas fa-lock mr-1"></i>Diambil otomatis dari akun Anda</p>
          </div>

          <div>
            <label class="form-label">Asal Sekolah (SMP/MTs) <span class="text-red-500">*</span></label>
            <input type="text" name="asal_sekolah" value="{{ $fd['asal_sekolah'] ?? old('asal_sekolah') }}" required
              class="form-input" placeholder="Nama SMP/MTs asal...">
          </div>

          <div class="md:col-span-2">
            <label class="form-label">Alamat Sekolah Asal</label>
            <textarea name="alamat_sekolah" rows="2" class="form-input resize-none" placeholder="Alamat SMP/MTs asal...">{{ $fd['alamat_sekolah'] ?? old('alamat_sekolah') }}</textarea>
          </div>

          <div class="md:col-span-2">
            <label class="form-label">Prestasi yang Pernah Diraih</label>
            <textarea name="prestasi" rows="2" class="form-input resize-none" placeholder="Prestasi akademik/non-akademik (opsional)...">{{ $fd['prestasi'] ?? old('prestasi') }}</textarea>
          </div>
        </div>
      </div>

      @elseif($step === 2)
      {{-- ════════════════════════════════════════ STEP 2: DATA ORANG TUA ════════════════════════════════════════ --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8 space-y-5">
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
          <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
            <i class="fas fa-users text-sm"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800 dark:text-white">Data Orang Tua / Wali</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
          <div class="md:col-span-2">
            <label class="form-label">Nama Orang Tua / Wali <span class="text-red-500">*</span></label>
            <input type="text" name="nama_ortu" value="{{ $fd['nama_ortu'] ?? old('nama_ortu') }}" required
              class="form-input" placeholder="Nama Ayah / Ibu / Wali...">
          </div>
          <div>
            <label class="form-label">Pekerjaan Orang Tua <span class="text-red-500">*</span></label>
            <input type="text" name="pekerjaan_ortu" value="{{ $fd['pekerjaan_ortu'] ?? old('pekerjaan_ortu') }}" required
              class="form-input" placeholder="Pekerjaan...">
          </div>
          <div>
            <label class="form-label">No. HP / WhatsApp Orang Tua <span class="text-red-500">*</span></label>
            <input type="text" name="no_hp_ortu" value="{{ $fd['no_hp_ortu'] ?? old('no_hp_ortu') }}" required
              class="form-input" placeholder="No. Telepon aktif...">
          </div>
        </div>
      </div>

      @elseif($step === 3)
      {{-- ════════════════════════════════════════ STEP 3: ALAMAT ════════════════════════════════════════ --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8 space-y-6">
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
          <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
            <i class="fas fa-map-marker-alt text-sm"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800 dark:text-white">Alamat Asal & Tinggal</h2>
        </div>

        {{-- Alamat Asal --}}
        <div>
          <h3 class="text-xs font-bold text-primary uppercase tracking-wider mb-3">
            <i class="fas fa-home mr-1"></i>Alamat Asal (Sesuai Kartu Keluarga)
          </h3>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="col-span-2">
              <label class="form-label-sm">Nama Jalan</label>
              <input type="text" name="jalan_asal" id="jalan_asal" value="{{ $fd['jalan_asal'] ?? '' }}" class="form-input-sm" placeholder="Jl. ...">
            </div>
            <div>
              <label class="form-label-sm">Dusun/Pedukuhan</label>
              <input type="text" name="dusun_asal" id="dusun_asal" value="{{ $fd['dusun_asal'] ?? '' }}" class="form-input-sm" placeholder="Dusun...">
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="form-label-sm">RT <span class="text-red-500">*</span></label>
                <input type="text" name="rt_asal" id="rt_asal" value="{{ $fd['rt_asal'] ?? '' }}" required class="form-input-sm" placeholder="00">
              </div>
              <div>
                <label class="form-label-sm">RW</label>
                <input type="text" name="rw_asal" id="rw_asal" value="{{ $fd['rw_asal'] ?? '' }}" class="form-input-sm" placeholder="00">
              </div>
            </div>
            <div>
              <label class="form-label-sm">Desa/Kelurahan <span class="text-red-500">*</span></label>
              <input type="text" name="desa_asal" id="desa_asal" value="{{ $fd['desa_asal'] ?? '' }}" required class="form-input-sm" placeholder="Desa...">
            </div>
            <div>
              <label class="form-label-sm">Kecamatan <span class="text-red-500">*</span></label>
              <input type="text" name="kecamatan_asal" id="kecamatan_asal" value="{{ $fd['kecamatan_asal'] ?? '' }}" required class="form-input-sm" placeholder="Kecamatan...">
            </div>
            <div>
              <label class="form-label-sm">Kabupaten <span class="text-red-500">*</span></label>
              <input type="text" name="kabupaten_asal" id="kabupaten_asal" value="{{ $fd['kabupaten_asal'] ?? '' }}" required class="form-input-sm" placeholder="Kabupaten...">
            </div>
            <div>
              <label class="form-label-sm">Provinsi <span class="text-red-500">*</span></label>
              <input type="text" name="provinsi_asal" id="provinsi_asal" value="{{ $fd['provinsi_asal'] ?? 'DI Yogyakarta' }}" required class="form-input-sm" placeholder="Provinsi...">
            </div>
          </div>
        </div>

        {{-- Copy checkbox --}}
        <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-700/30 p-4 rounded-xl border border-slate-200 dark:border-slate-600">
          <input type="checkbox" id="copy_address" onclick="copyAddr()" class="h-4 w-4 text-primary rounded focus:ring-primary">
          <label for="copy_address" class="text-sm font-semibold text-slate-700 dark:text-slate-300 cursor-pointer">
            Alamat tinggal sama dengan alamat asal (Centang untuk menyalin)
          </label>
        </div>

        {{-- Alamat Tinggal --}}
        <div>
          <h3 class="text-xs font-bold text-primary uppercase tracking-wider mb-3">
            <i class="fas fa-map-pin mr-1"></i>Alamat Tempat Tinggal Sekarang
          </h3>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <div class="col-span-2">
              <label class="form-label-sm">Nama Jalan</label>
              <input type="text" name="jalan_tinggal" id="jalan_tinggal" value="{{ $fd['jalan_tinggal'] ?? '' }}" class="form-input-sm" placeholder="Jl. ...">
            </div>
            <div>
              <label class="form-label-sm">Dusun/Pedukuhan</label>
              <input type="text" name="dusun_tinggal" id="dusun_tinggal" value="{{ $fd['dusun_tinggal'] ?? '' }}" class="form-input-sm" placeholder="Dusun...">
            </div>
            <div class="grid grid-cols-2 gap-2">
              <div>
                <label class="form-label-sm">RT <span class="text-red-500">*</span></label>
                <input type="text" name="rt_tinggal" id="rt_tinggal" value="{{ $fd['rt_tinggal'] ?? '' }}" required class="form-input-sm" placeholder="00">
              </div>
              <div>
                <label class="form-label-sm">RW</label>
                <input type="text" name="rw_tinggal" id="rw_tinggal" value="{{ $fd['rw_tinggal'] ?? '' }}" class="form-input-sm" placeholder="00">
              </div>
            </div>
            <div>
              <label class="form-label-sm">Desa/Kelurahan <span class="text-red-500">*</span></label>
              <input type="text" name="desa_tinggal" id="desa_tinggal" value="{{ $fd['desa_tinggal'] ?? '' }}" required class="form-input-sm" placeholder="Desa...">
            </div>
            <div>
              <label class="form-label-sm">Kecamatan <span class="text-red-500">*</span></label>
              <input type="text" name="kecamatan_tinggal" id="kecamatan_tinggal" value="{{ $fd['kecamatan_tinggal'] ?? '' }}" required class="form-input-sm" placeholder="Kecamatan...">
            </div>
            <div>
              <label class="form-label-sm">Kabupaten <span class="text-red-500">*</span></label>
              <input type="text" name="kabupaten_tinggal" id="kabupaten_tinggal" value="{{ $fd['kabupaten_tinggal'] ?? '' }}" required class="form-input-sm" placeholder="Kabupaten...">
            </div>
            <div>
              <label class="form-label-sm">Provinsi <span class="text-red-500">*</span></label>
              <input type="text" name="provinsi_tinggal" id="provinsi_tinggal" value="{{ $fd['provinsi_tinggal'] ?? '' }}" required class="form-input-sm" placeholder="Provinsi...">
            </div>
          </div>
        </div>
      </div>

      @elseif($step === 4)
      {{-- ════════════════════════════════════════ STEP 4: JURUSAN & BERKAS ════════════════════════════════════════ --}}
      <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6 sm:p-8 space-y-6">
        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-700 pb-4">
          <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
            <i class="fas fa-graduation-cap text-sm"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800 dark:text-white">Pilihan Jurusan & Berkas</h2>
        </div>
        <div class="mb-5">
          <label class="form-label">Gelombang Pendaftaran <span class="text-red-500">*</span></label>
          <select name="gelombang_id" required class="form-select w-full">
            <option value="">-- Pilih Gelombang --</option>
            @foreach($gelombangs as $g)
              <option value="{{ $g->id }}" {{ ($fd['gelombang_id'] ?? '') == $g->id || ($g->is_aktif && !isset($fd['gelombang_id'])) ? 'selected' : '' }} {{ !$g->is_aktif ? 'disabled' : '' }}>
                {{ $g->nama_gelombang }} ({{ $g->tahun_ajaran }}) {{ $g->is_aktif ? '— Aktif' : '— Tidak Aktif' }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <div>
            <label class="form-label">Jurusan Pilihan I <span class="text-red-500">*</span></label>
            <select name="pil1" id="pil1" required onchange="validateJur()" class="form-select w-full">
              <option value="">-- Pilihan I --</option>
              @foreach($jurusanList as $k => $v)
                <option value="{{ $k }}" {{ ($fd['pil1'] ?? '') == $k ? 'selected' : '' }}>{{ $v }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="form-label">Jurusan Pilihan II <span class="text-red-500">*</span></label>
            <select name="pil2" id="pil2" required onchange="validateJur()" class="form-select w-full" disabled>
              <option value="">-- Pilihan II --</option>
              @foreach($jurusanList as $k => $v)
                <option value="{{ $k }}" {{ ($fd['pil2'] ?? '') == $k ? 'selected' : '' }}>{{ $v }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="form-label">Jurusan Pilihan III <span class="text-red-500">*</span></label>
            <select name="pil3" id="pil3" required onchange="validateJur()" class="form-select w-full" disabled>
              <option value="">-- Pilihan III --</option>
              @foreach($jurusanList as $k => $v)
                <option value="{{ $k }}" {{ ($fd['pil3'] ?? '') == $k ? 'selected' : '' }}>{{ $v }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <p class="text-xs text-slate-400"><i class="fas fa-info-circle mr-1"></i>Pilihan jurusan I, II, III tidak boleh sama.</p>
        <p id="jur-err" class="hidden text-xs text-red-500"><i class="fas fa-exclamation-circle mr-1"></i>Pilihan jurusan tidak boleh ada yang sama!</p>

        {{-- Upload --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
          <div>
            <label class="form-label">Foto/Scan Akta Kelahiran <span class="text-slate-400">(Opsional)</span></label>
            <input type="file" name="foto_akta" accept="image/*,application/pdf"
              class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
            <span class="text-xs text-slate-400 mt-1 block">JPG, PNG, PDF (maks. 2MB)</span>
          </div>
          <div>
            <label class="form-label">Foto/Scan Kartu Keluarga (KK) <span class="text-slate-400">(Opsional)</span></label>
            <input type="file" name="foto_kk" accept="image/*,application/pdf"
              class="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
            <span class="text-xs text-slate-400 mt-1 block">JPG, PNG, PDF (maks. 2MB)</span>
          </div>
        </div>
      </div>

      @elseif($step === 5)
      {{-- ════════════════════════════════════════ STEP 5: REVIEW & SUBMIT ════════════════════════════════════════ --}}
      <div class="space-y-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-6">
          <h2 class="text-base font-bold text-slate-800 dark:text-white mb-4 flex items-center gap-2">
            <i class="fas fa-eye text-primary"></i> Review Data Pendaftaran
          </h2>

          {{-- Data Siswa --}}
          <div class="mb-4">
            <h3 class="text-xs font-bold text-primary uppercase mb-2">1. Data Siswa</h3>
            <div class="grid grid-cols-2 gap-2 text-sm">
              <div><span class="text-slate-400">Nama:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ strtoupper($fd['nama_lengkap'] ?? '-') }}</span></div>
              <div><span class="text-slate-400">TTL:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ $fd['tempat_lahir'] ?? '-' }}, {{ ($fd['tgl'] ?? '') }}/{{ ($fd['bulan'] ?? '') }}/{{ ($fd['tahun'] ?? '') }}</span></div>
              <div><span class="text-slate-400">Jenis Kelamin:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ ($fd['jenkel'] ?? '') == 'L' ? 'Laki-Laki' : 'Perempuan' }}</span></div>
              <div><span class="text-slate-400">Agama:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ ucfirst($fd['agama'] ?? '-') }}</span></div>
              <div><span class="text-slate-400">No. WA:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ $siswa->no_wa }}</span></div>
              <div><span class="text-slate-400">Asal Sekolah:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ strtoupper($fd['asal_sekolah'] ?? '-') }}</span></div>
            </div>
          </div>

          <hr class="border-slate-100 dark:border-slate-700 my-3">

          {{-- Data Ortu --}}
          <div class="mb-4">
            <h3 class="text-xs font-bold text-primary uppercase mb-2">2. Data Orang Tua</h3>
            <div class="grid grid-cols-2 gap-2 text-sm">
              <div><span class="text-slate-400">Nama:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ strtoupper($fd['nama_ortu'] ?? '-') }}</span></div>
              <div><span class="text-slate-400">Pekerjaan:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ $fd['pekerjaan_ortu'] ?? '-' }}</span></div>
              <div><span class="text-slate-400">No. HP:</span> <span class="font-semibold text-slate-800 dark:text-white">{{ $fd['no_hp_ortu'] ?? '-' }}</span></div>
            </div>
          </div>

          <hr class="border-slate-100 dark:border-slate-700 my-3">

          {{-- Pilihan Jurusan --}}
          <div class="mb-4">
            <h3 class="text-xs font-bold text-primary uppercase mb-2">3. Pilihan Jurusan</h3>
            <div class="grid grid-cols-3 gap-2 text-sm">
              <div class="bg-primary/10 rounded-lg p-2 text-center"><span class="text-xs text-slate-400 block">Pilihan I</span><span class="font-bold text-primary text-sm">{{ $fd['pil1'] ?? '-' }}</span></div>
              <div class="bg-slate-100 dark:bg-slate-700 rounded-lg p-2 text-center"><span class="text-xs text-slate-400 block">Pilihan II</span><span class="font-bold text-slate-700 dark:text-slate-200 text-sm">{{ $fd['pil2'] ?? '-' }}</span></div>
              <div class="bg-slate-100 dark:bg-slate-700 rounded-lg p-2 text-center"><span class="text-xs text-slate-400 block">Pilihan III</span><span class="font-bold text-slate-700 dark:text-slate-200 text-sm">{{ $fd['pil3'] ?? '-' }}</span></div>
            </div>
          </div>
        </div>

        {{-- Berkas yang harus dibawa --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-5 text-sm">
          <div class="font-bold text-slate-800 dark:text-white mb-2"><i class="fas fa-clipboard-list text-primary mr-1"></i>Berkas Fisik saat Daftar Ulang:</div>
          <ol class="list-decimal pl-5 space-y-1 text-xs text-slate-600 dark:text-slate-400">
            <li>Fotokopi Rapor SMP/MTs Semester V (1 Lembar)</li>
            <li>Fotokopi Akta Kelahiran & Kartu Keluarga (masing-masing 1 Lembar)</li>
            <li>Fotokopi KIP / KPS / KKS jika memiliki (1 Lembar)</li>
            <li>Pas Foto ukuran 3x4 berwarna (2 Lembar)</li>
          </ol>
        </div>

        {{-- Persetujuan --}}
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 p-5">
          <div class="flex items-start gap-3">
            <input type="checkbox" name="setuju" id="setuju" value="1" required
              class="mt-1 h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary">
            <label for="setuju" class="text-sm text-slate-600 dark:text-slate-400 cursor-pointer">
              <span class="font-bold text-slate-800 dark:text-white">Saya menyatakan:</span><br>
              Semua data yang saya isikan di atas adalah benar dan dapat dipertanggungjawabkan. Apabila terdapat data yang tidak sesuai, panitia berhak mendiskualifikasi pendaftaran saya.
            </label>
          </div>
        </div>
      </div>
      @endif

      {{-- Navigation Buttons --}}
      <div class="flex items-center justify-between mt-6 gap-3">
        @if($step > 1)
          <a href="{{ route('spmb.formulir', $step - 1) }}"
            class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-semibold py-3 px-6 rounded-xl text-sm transition-all inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Sebelumnya
          </a>
        @else
          <div></div>
        @endif

        <button type="submit" id="btn-next"
          class="bg-primary hover:bg-secondary text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md hover:shadow-lg hover:shadow-primary/30 inline-flex items-center gap-2">
          @if($step < 5)
            Lanjut <i class="fas fa-arrow-right"></i>
          @else
            <i class="fas fa-paper-plane"></i> Kirim Pendaftaran
          @endif
        </button>
      </div>

    </form>

  </div>
</div>
@endsection

@section('style')
<style>
  .form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #334155;
    margin-bottom: 0.375rem;
  }
  .dark .form-label {
    color: #cbd5e1;
  }
  .form-label-sm {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 0.25rem;
  }
  .dark .form-label-sm {
    color: #94a3b8;
  }
  .form-input {
    width: 100%;
    padding: 0.625rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background-color: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.15s ease-in-out;
    font-size: 0.875rem;
  }
  .dark .form-input {
    border-color: #475569;
    background-color: #334155;
    color: #ffffff;
  }
  .form-input:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.3);
  }
  .form-input-sm {
    width: 100%;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    background-color: #f8fafc;
    color: #1e293b;
    outline: none;
    font-size: 0.875rem;
  }
  .dark .form-input-sm {
    border-color: #475569;
    background-color: #334155;
    color: #ffffff;
  }
  .form-input-sm:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.3);
  }
  .form-select {
    width: 100%;
    padding: 0.625rem 2.25rem 0.625rem 0.75rem;
    border-radius: 0.75rem;
    border: 1px solid #e2e8f0;
    background-color: #ffffff;
    color: #1e293b;
    outline: none;
    font-size: 0.875rem;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
    background-position: right 0.75rem center;
    background-size: 1.25rem 1.25rem;
    background-repeat: no-repeat;
  }
  .dark .form-select {
    border-color: #475569;
    background-color: #334155;
    color: #ffffff;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
  }
  .form-select:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.3);
  }
</style>
@endsection

@section('script')
<script>
  // Copy address fields
  function copyAddr() {
    const checked = document.getElementById('copy_address').checked;
    const fields = ['jalan','dusun','rt','rw','desa','kecamatan','kabupaten','provinsi'];
    fields.forEach(f => {
      const src = document.getElementById(f + '_asal');
      const dst = document.getElementById(f + '_tinggal');
      if (!src || !dst) return;
      if (checked) {
        dst.value = src.value;
        dst.setAttribute('readonly', true);
        dst.classList.add('opacity-60', 'cursor-not-allowed');
      } else {
        dst.removeAttribute('readonly');
        dst.classList.remove('opacity-60', 'cursor-not-allowed');
      }
    });
    // Keep in sync when asal changes
    if (checked) {
      fields.forEach(f => {
        const src = document.getElementById(f + '_asal');
        const dst = document.getElementById(f + '_tinggal');
        if (src && dst) src.addEventListener('input', () => { dst.value = src.value; });
      });
    }
  }

  // Jurusan validation
  const disClass = ['opacity-50','cursor-not-allowed'];
  function setEnabled(sel, on) {
    sel.disabled = !on;
    if (on) { sel.classList.remove(...disClass); }
    else { sel.classList.add(...disClass); sel.value = ''; }
  }
  function validateJur() {
    const p1 = document.getElementById('pil1');
    const p2 = document.getElementById('pil2');
    const p3 = document.getElementById('pil3');
    if (!p1) return;
    setEnabled(p2, p1.value !== '');
    setEnabled(p3, p1.value !== '' && p2 && p2.value !== '');

    // Hide duplicate options
    [p1,p2,p3].forEach((sel, idx) => {
      if (!sel) return;
      const others = [p1,p2,p3].filter((_,i)=>i!==idx).map(s=>s?s.value:'').filter(v=>v);
      Array.from(sel.options).forEach(opt => {
        if (!opt.value) return;
        opt.disabled = others.includes(opt.value);
      });
    });

    const err = document.getElementById('jur-err');
    if (err) {
      const vals = [p1,p2,p3].map(s=>s&&s.value).filter(v=>v);
      const hasDup = vals.length !== new Set(vals).size;
      err.classList.toggle('hidden', !hasDup);
    }
  }
  document.addEventListener('DOMContentLoaded', validateJur);

  // Submit loading
  document.querySelector('form').addEventListener('submit', function() {
    const btn = document.getElementById('btn-next');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
  });
</script>
@endsection
