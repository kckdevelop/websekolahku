@extends('layouts.admin')
@section('title', 'Detail Pendaftaran')
@section('subtitle', 'Informasi lengkap pendaftar siswa baru')

@section('content')
<div class="max-w-4xl space-y-6">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.pendaftaran.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
          <i class="fas fa-arrow-left"></i>
        </a>
        <div>
          <h2 class="font-semibold text-slate-800">Detail Pendaftar ({{ $pendaftaran->no_daftar }})</h2>
          <p class="text-xs text-slate-400">Daftar: {{ $pendaftaran->created_at->format('d M Y, H:i') }} • Tahun: {{ $pendaftaran->tahun_aktif }} • {{ $pendaftaran->gelombang ?? '-' }}</p>
        </div>
      </div>

      {{-- Quick Status Change --}}
      <form method="POST" action="{{ route('admin.pendaftaran.updateStatus', $pendaftaran) }}" class="flex items-center gap-2">
        @csrf @method('PATCH')
        <select name="status" class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 bg-white focus:outline-none focus:ring-2 focus:ring-primary/30">
          @foreach(['pending','verifikasi','diterima','ditolak'] as $s)
            <option value="{{ $s }}" {{ $pendaftaran->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
        <button type="submit" class="bg-primary hover:bg-secondary text-white text-sm font-semibold px-4 py-1.5 rounded-lg transition-colors">Update</button>
      </form>
    </div>

    {{-- Details Grid --}}
    <div class="p-6 sm:p-8 space-y-8">
      
      {{-- Section 1: Data Calon Siswa --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-user text-primary text-xs"></i> Data Diri Calon Siswa
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Nama Lengkap</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->nama_lengkap }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Tempat, Tanggal Lahir</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->tempat_lahir }}, {{ $pendaftaran->tanggal_lahir ? $pendaftaran->tanggal_lahir->format('d M Y') : '-' }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Jenis Kelamin</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Agama</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5 text-capitalize">{{ $pendaftaran->agama }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">No. HP Siswa</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->no_hp_siswa }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Asal Sekolah</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->asal_sekolah }}</p>
          </div>
          <div class="md:col-span-3">
            <p class="text-xxs font-bold text-slate-400 uppercase">Alamat Sekolah Asal</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->alamat_sekolah ?? '-' }}</p>
          </div>
          <div class="md:col-span-3">
            <p class="text-xxs font-bold text-slate-400 uppercase">Prestasi yang Pernah Diraih</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5 italic">{{ $pendaftaran->prestasi ?? '-' }}</p>
          </div>
        </div>
      </div>

      {{-- Section 2: Data Orang Tua --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-users text-primary text-xs"></i> Orang Tua / Wali
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Nama Orang Tua</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->nama_ortu }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Pekerjaan Orang Tua</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->pekerjaan_ortu }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">No. HP Orang Tua</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->no_hp_ortu }}</p>
          </div>
        </div>
      </div>

      {{-- Section 3: Alamat --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-map-marked-alt text-primary text-xs"></i> Informasi Alamat
        </h3>
        <div class="space-y-4">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Alamat Asal (Sesuai KK)</p>
            <p class="text-sm font-semibold text-slate-800 mt-1 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
              {{ $pendaftaran->jalan_asal ? $pendaftaran->jalan_asal . ', ' : '' }}
              {{ $pendaftaran->dusun_asal ? 'Dsn. ' . $pendaftaran->dusun_asal . ', ' : '' }}
              RT {{ $pendaftaran->rt_asal }} {{ $pendaftaran->rw_asal ? 'RW ' . $pendaftaran->rw_asal : '' }},
              Kel. {{ $pendaftaran->desa_asal }}, Kec. {{ $pendaftaran->kecamatan_asal }},
              Kab. {{ $pendaftaran->kabupaten_asal }}, Prov. {{ $pendaftaran->provinsi_asal }}
            </p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Alamat Tempat Tinggal Sekarang</p>
            <p class="text-sm font-semibold text-slate-800 mt-1 bg-slate-50 p-3.5 rounded-xl border border-slate-100">
              {{ $pendaftaran->jalan_tinggal ? $pendaftaran->jalan_tinggal . ', ' : '' }}
              {{ $pendaftaran->dusun_tinggal ? 'Dsn. ' . $pendaftaran->dusun_tinggal . ', ' : '' }}
              RT {{ $pendaftaran->rt_tinggal }} {{ $pendaftaran->rw_tinggal ? 'RW ' . $pendaftaran->rw_tinggal : '' }},
              Kel. {{ $pendaftaran->desa_tinggal }}, Kec. {{ $pendaftaran->kecamatan_tinggal }},
              Kab. {{ $pendaftaran->kabupaten_tinggal }}, Prov. {{ $pendaftaran->provinsi_tinggal }}
            </p>
          </div>
        </div>
      </div>

      {{-- Section 4: Minat Jurusan --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-graduation-cap text-primary text-xs"></i> Pilihan Kompetensi Keahlian
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @php
            $jurusans = ['TKR'=>'Teknik Kendaraan Ringan (Otomotif)', 'TPM'=>'Teknik Permesinan', 'TAV'=>'Teknik Audio Video', 'TBSM'=>'Teknik Bisnis Sepeda Motor', 'RPL'=>'Rekayasa Perangkat Lunak'];
          @endphp
          <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-4">
            <p class="text-xxs font-bold text-blue-500 uppercase">Jurusan Ke-I</p>
            <p class="text-sm font-bold text-blue-800 mt-0.5">{{ $jurusans[$pendaftaran->pil1] ?? $pendaftaran->pil1 }}</p>
          </div>
          <div class="bg-slate-50 border border-slate-150 rounded-xl p-4">
            <p class="text-xxs font-bold text-slate-400 uppercase">Jurusan Ke-II</p>
            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $jurusans[$pendaftaran->pil2] ?? $pendaftaran->pil2 }}</p>
          </div>
          <div class="bg-slate-50 border border-slate-150 rounded-xl p-4">
            <p class="text-xxs font-bold text-slate-400 uppercase">Jurusan Ke-III</p>
            <p class="text-sm font-semibold text-slate-700 mt-0.5">{{ $jurusans[$pendaftaran->pil3] ?? $pendaftaran->pil3 }}</p>
          </div>
        </div>
      </div>

      {{-- Section 5: Hasil Pemeriksaan Kesehatan (UKS) --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-heartbeat text-emerald-500 text-xs"></i> Pemeriksaan Kesehatan (UKS)
        </h3>
        @if($pendaftaran->kesehatan_verified_at)
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Tinggi / Berat Badan</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_tinggi_badan ?? '-' }} cm / {{ $pendaftaran->kesehatan_berat_badan ?? '-' }} kg</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Golongan Darah</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_golongan_darah ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Buta Warna</p>
              <p class="text-sm font-semibold mt-0.5 {{ $pendaftaran->kesehatan_buta_warna === 'ya' ? 'text-rose-600' : 'text-emerald-600' }}">
                {{ $pendaftaran->kesehatan_buta_warna === 'ya' ? 'Ya (Buta Warna)' : 'Tidak (Normal)' }}
              </p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Mata Minus (Kanan/Kiri)</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_mata_minus ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Tato & Tindik</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">
                @if($pendaftaran->kesehatan_tato_tindik === 'tidak')
                  Tidak bertato/tindik
                @elseif($pendaftaran->kesehatan_tato_tindik === 'tato')
                  Ada Tato
                @elseif($pendaftaran->kesehatan_tato_tindik === 'tindik')
                  Ada Tindik
                @elseif($pendaftaran->kesehatan_tato_tindik === 'tato_tindik')
                  Tato & Tindik
                @else
                  -
                @endif
              </p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Riwayat Penyakit</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->kesehatan_riwayat_penyakit ?? 'Tidak ada' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Petugas / Waktu Periksa</p>
              <p class="text-xs font-semibold text-slate-550 mt-0.5">
                {{ $pendaftaran->kesehatan_petugas ?? '-' }}<br>
                <span class="text-xxs text-slate-400">{{ $pendaftaran->kesehatan_verified_at ? $pendaftaran->kesehatan_verified_at->format('d M Y, H:i') : '' }}</span>
              </p>
            </div>
            <div class="md:col-span-3">
              <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Kesehatan</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 bg-white p-3 rounded-xl border border-slate-100 italic">{{ $pendaftaran->kesehatan_catatan ?? '-' }}</p>
            </div>
          </div>
        @else
          <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center text-xs text-slate-500 italic">
            <i class="fas fa-info-circle mr-1"></i> Belum ada data pemeriksaan kesehatan dari petugas UKS.
          </div>
        @endif
      </div>

      {{-- Section 6: Hasil Wawancara & Gaya Belajar --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-comments text-purple-500 text-xs"></i> Wawancara, Minat Bakat &amp; Gaya Belajar
        </h3>
        @if($pendaftaran->wawancara_verified_at || $pendaftaran->gaya_belajar_verified_at)
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Tipe Gaya Belajar</p>
              <p class="text-sm font-bold text-purple-800 mt-0.5 capitalize">{{ $pendaftaran->gaya_belajar_tipe ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-xxs font-bold text-slate-400 uppercase">Minat Bakat / Hobi</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->gaya_belajar_minat_bakat ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Baca Tulis Al-Qur'an</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->wawancara_baca_tulis_alquran ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Sholat 5 Waktu</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->wawancara_solat_fardhu ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Kepribadian / Sikap</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5">{{ $pendaftaran->wawancara_kepribadian ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
              <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Gaya Belajar</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 italic">{{ $pendaftaran->gaya_belajar_catatan ?? '-' }}</p>
            </div>
            <div>
              <p class="text-xxs font-bold text-slate-400 uppercase">Petugas / Waktu Wawancara</p>
              <p class="text-xs font-semibold text-slate-550 mt-0.5">
                {{ $pendaftaran->wawancara_petugas ?? $pendaftaran->gaya_belajar_petugas ?? '-' }}<br>
                <span class="text-xxs text-slate-400">
                  @if($pendaftaran->wawancara_verified_at)
                    {{ $pendaftaran->wawancara_verified_at->format('d M Y, H:i') }}
                  @elseif($pendaftaran->gaya_belajar_verified_at)
                    {{ $pendaftaran->gaya_belajar_verified_at->format('d M Y, H:i') }}
                  @endif
                </span>
              </p>
            </div>
            <div class="md:col-span-3">
              <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Wawancara</p>
              <p class="text-sm font-semibold text-slate-800 mt-0.5 bg-white p-3 rounded-xl border border-slate-100 italic">{{ $pendaftaran->wawancara_catatan ?? '-' }}</p>
            </div>
          </div>
        @else
          <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center text-xs text-slate-500 italic">
            <i class="fas fa-info-circle mr-1"></i> Belum ada data wawancara dan tes gaya belajar.
          </div>
        @endif
      </div>

      {{-- Section 7: Keuangan & Pembayaran --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-coins text-yellow-500 text-xs"></i> Pembayaran Pendaftaran (Keuangan)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Status Pembayaran</p>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold mt-1.5
              {{ $pendaftaran->pembayaran_status === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
              <i class="fas {{ $pendaftaran->pembayaran_status === 'lunas' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
              {{ $pendaftaran->pembayaran_status === 'lunas' ? 'LUNAS' : 'BELUM BAYAR' }}
            </span>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Nominal Transaksi</p>
            <p class="text-sm font-bold text-slate-850 mt-1 font-mono">Rp {{ number_format($pendaftaran->pembayaran_nominal ?? 0, 0, ',', '.') }}</p>
          </div>
          <div>
            <p class="text-xxs font-bold text-slate-400 uppercase">Petugas / Waktu Transaksi</p>
            <p class="text-xs font-semibold text-slate-550 mt-0.5">
              {{ $pendaftaran->pembayaran_petugas ?? '-' }}<br>
              <span class="text-xxs text-slate-400">{{ $pendaftaran->pembayaran_verified_at ? $pendaftaran->pembayaran_verified_at->format('d M Y, H:i') : '' }}</span>
            </p>
          </div>
          <div class="md:col-span-3">
            <p class="text-xxs font-bold text-slate-400 uppercase">Catatan Pembayaran</p>
            <p class="text-sm font-semibold text-slate-800 mt-0.5 bg-white p-3 rounded-xl border border-slate-100 italic">{{ $pendaftaran->pembayaran_keterangan ?? '-' }}</p>
          </div>
        </div>
      </div>

      {{-- Section 8: Berkas --}}
      <div>
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
          <i class="fas fa-file-pdf text-primary text-xs"></i> Berkas Unggahan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="border rounded-xl p-4 flex items-center justify-between bg-white shadow-xs">
            <div>
              <p class="text-xs font-bold text-slate-700">Akta Kelahiran</p>
              @if($pendaftaran->foto_akta)
                <p class="text-xxs text-emerald-600 font-semibold mt-0.5"><i class="fas fa-check-circle"></i> Berkas Terlampir</p>
              @else
                <p class="text-xxs text-slate-400 font-semibold mt-0.5">Belum diupload</p>
              @endif
            </div>
            @if($pendaftaran->foto_akta)
              <a href="{{ asset('storage/' . $pendaftaran->foto_akta) }}" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                <i class="fas fa-external-link-alt"></i> Lihat File
              </a>
            @endif
          </div>

          <div class="border rounded-xl p-4 flex items-center justify-between bg-white shadow-xs">
            <div>
              <p class="text-xs font-bold text-slate-700">Kartu Keluarga [KK]</p>
              @if($pendaftaran->foto_kk)
                <p class="text-xxs text-emerald-600 font-semibold mt-0.5"><i class="fas fa-check-circle"></i> Berkas Terlampir</p>
              @else
                <p class="text-xxs text-slate-400 font-semibold mt-0.5">Belum diupload</p>
              @endif
            </div>
            @if($pendaftaran->foto_kk)
              <a href="{{ asset('storage/' . $pendaftaran->foto_kk) }}" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                <i class="fas fa-external-link-alt"></i> Lihat File
              </a>
            @endif
          </div>
        </div>
      </div>

    </div>

    {{-- Footer Actions --}}
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex flex-wrap items-center justify-between gap-4">
      <div class="flex items-center gap-2">
        <a href="{{ route('admin.pendaftaran.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-650 hover:text-slate-800"><i class="fas fa-chevron-left text-xs"></i> Kembali ke Daftar</a>
      </div>
      <div class="flex items-center gap-2">
        {{-- Cetak --}}
        <a href="{{ route('admin.pendaftaran.cetak', $pendaftaran) }}" target="_blank" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-semibold px-4 py-2 rounded-xl transition-colors inline-flex items-center gap-1.5">
          <i class="fas fa-print"></i> Cetak Kartu
        </a>
        {{-- Edit --}}
        <a href="{{ route('admin.pendaftaran.edit', $pendaftaran) }}" class="bg-yellow-500 hover:bg-yellow-650 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors inline-flex items-center gap-1.5">
          <i class="fas fa-edit"></i> Edit Data
        </a>
        {{-- Delete --}}
        <form method="POST" action="{{ route('admin.pendaftaran.destroy', $pendaftaran) }}" id="delete-form-detail">
          @csrf @method('DELETE')
          <button type="button" id="btn-delete-detail" class="bg-red-500 hover:bg-red-650 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors inline-flex items-center gap-1.5" data-nama="{{ $pendaftaran->nama_lengkap }}" data-no="{{ $pendaftaran->no_daftar }}">
            <i class="fas fa-trash"></i> Hapus
          </button>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  document.getElementById('btn-delete-detail')?.addEventListener('click', function(e) {
    e.preventDefault();
    const nama = this.getAttribute('data-nama');
    const no = this.getAttribute('data-no');
    const form = document.getElementById('delete-form-detail');
    
    const message = `PENTING! Menghapus data ini akan menghapus secara PERMANEN seluruh data pendaftaran atas nama ${nama} (${no}), termasuk data kesehatan (UKS), wawancara, berkas/foto, dan pembayaran.\n\nTindakan ini tidak dapat dibatalkan.\n\nApakah Anda yakin ingin melanjutkan?`;
    
    if (confirm(message)) {
      form.submit();
    }
  });
</script>
@endsection
