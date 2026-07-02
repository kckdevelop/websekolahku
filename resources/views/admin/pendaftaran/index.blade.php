@extends('layouts.admin')
@section('title', 'Data Pendaftaran')
@section('subtitle', 'Kelola dan pantau pendaftaran siswa baru')

@section('content')
{{-- Filter, Search & Action --}}
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
  <div class="flex gap-2 flex-wrap">
    @foreach(['semua' => 'Semua', 'pending' => 'Pending', 'verifikasi' => 'Verifikasi', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'] as $val => $label)
    <a href="{{ route('admin.pendaftaran.index', ['status' => $val === 'semua' ? null : $val, 'search' => request('search')]) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors
       {{ request('status', 'semua') === $val
          ? 'bg-primary text-white shadow-sm shadow-primary/20'
          : 'bg-white text-slate-600 border border-slate-200 hover:border-primary hover:text-primary' }}">
      {{ $label }}
      @if($val === 'pending')
        @php $count = \App\Models\Pendaftaran::where('status','pending')->count(); @endphp
        @if($count > 0)<span class="ml-1 bg-red-500 text-white text-xxs font-bold rounded-full px-1.5 py-0.5">{{ $count }}</span>@endif
      @endif
    </a>
    @endforeach
  </div>

  <div class="flex items-center gap-2 flex-wrap">
    {{-- Search & Limit --}}
    <form method="GET" action="{{ route('admin.pendaftaran.index') }}" class="flex items-center gap-2">
      @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
      <div class="relative">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama / no daftar..."
          class="pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary w-56">
      </div>
      <button type="submit" class="px-3 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-lg text-sm transition-colors">Cari</button>
      
      <select name="per_page" onchange="this.form.submit()" class="text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white text-slate-600">
        <option value="10" {{ request('per_page', 25) == 10 ? 'selected' : '' }}>10 data</option>
        <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25 data</option>
        <option value="50" {{ request('per_page', 25) == 50 ? 'selected' : '' }}>50 data</option>
        <option value="100" {{ request('per_page', 25) == 100 ? 'selected' : '' }}>100 data</option>
      </select>

      @if(($search ?? false) || request('per_page'))
        <a href="{{ route('admin.pendaftaran.index', request()->only('status')) }}" class="px-3 py-2 text-sm text-red-500 hover:text-red-700 transition-colors" title="Reset pencarian & limit"><i class="fas fa-times"></i></a>
      @endif
    </form>
  </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
  <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
    <div class="flex items-center gap-4">
      <h2 class="font-semibold text-slate-800">Daftar Pendaftar</h2>
      <a href="{{ route('admin.pendaftaran.create') }}" class="bg-primary hover:bg-secondary text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1">
        <i class="fas fa-plus"></i> Tambah Pendaftar Baru
      </a>
    </div>
    <span class="text-sm text-slate-500">Total: {{ $pendaftaran->total() }} pendaftar</span>
  </div>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-100 table-auto" style="font-family:'Inter',system-ui,sans-serif;">
      <thead class="bg-slate-50">
        <tr class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide text-left">
          <th class="px-3 py-2.5">No</th>
          <th class="px-3 py-2.5">No Daftar</th>
          <th class="px-3 py-2.5">Tgl Daftar</th>
          <th class="px-3 py-2.5">Nama Lengkap</th>
          <th class="px-3 py-2.5">Nama Ortu</th>
          <th class="px-3 py-2.5 text-center">JK</th>
          <th class="px-3 py-2.5">Agama</th>
          <th class="px-3 py-2.5">Asal Sekolah</th>
          <th class="px-3 py-2.5">Telp Siswa</th>
          <th class="px-3 py-2.5">Telp Ortu</th>
          <th class="px-2 py-2.5 text-center">Pil 1</th>
          <th class="px-2 py-2.5 text-center">Pil 2</th>
          <th class="px-2 py-2.5 text-center">Pil 3</th>
          <th class="px-3 py-2.5">Status</th>
          <th class="px-3 py-2.5 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-slate-100 text-xs" style="font-size:12px;font-family:'Inter',system-ui,sans-serif;">
        @forelse($pendaftaran as $index => $item)
        <tr class="hover:bg-blue-50/30 transition-colors" data-row-id="{{ $item->id }}">
          <td class="px-3 py-2.5 text-slate-400 text-center">{{ $pendaftaran->firstItem() + $index }}</td>
          <td class="px-3 py-2.5 cell-no-daftar">
            <div class="no-daftar-text font-semibold text-slate-700" style="font-size:12px;letter-spacing:0.02em;">{{ $item->no_daftar }}</div>
            @if($item->gelombang)
              <span class="gelombang-badge inline-block font-normal text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded mt-0.5" style="font-size:10px;">{{ $item->gelombang }}</span>
            @else
              <span class="gelombang-badge inline-block font-normal text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded mt-0.5 hidden" style="font-size:10px;"></span>
            @endif
          </td>
          <td class="px-3 py-2.5 text-slate-400 whitespace-nowrap" style="font-size:11px;">{{ $item->created_at->format('d/m/Y') }}</td>
          <td class="px-3 py-2.5 font-medium text-slate-700 max-w-[140px] truncate cell-nama" title="{{ $item->nama_lengkap }}" style="font-size:12px;">{{ $item->nama_lengkap }}</td>
          <td class="px-3 py-2.5 text-slate-500 max-w-[120px] truncate cell-ortu" title="{{ $item->nama_ortu }}" style="font-size:12px;">{{ $item->nama_ortu }}</td>
          <td class="px-3 py-2.5 text-center text-slate-600 font-medium cell-jk" style="font-size:12px;">{{ $item->jenis_kelamin }}</td>
          <td class="px-3 py-2.5 text-slate-500 capitalize cell-agama" style="font-size:12px;">{{ $item->agama }}</td>
          <td class="px-3 py-2.5 text-slate-500 max-w-[120px] truncate cell-asal" title="{{ $item->asal_sekolah }}" style="font-size:12px;">{{ $item->asal_sekolah }}</td>
          <td class="px-3 py-2.5 text-slate-500 whitespace-nowrap cell-telp-siswa" style="font-size:11.5px;letter-spacing:0.01em;">{{ $item->no_hp_siswa }}</td>
          <td class="px-3 py-2.5 text-slate-500 whitespace-nowrap cell-telp-ortu" style="font-size:11.5px;letter-spacing:0.01em;">{{ $item->no_hp_ortu }}</td>
          <td class="px-2 py-2.5 text-center font-semibold cell-pil1"><span class="bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded" style="font-size:11px;">{{ $item->pil1 }}</span></td>
          <td class="px-2 py-2.5 text-center font-medium cell-pil2"><span class="bg-slate-50 text-slate-500 px-1.5 py-0.5 rounded" style="font-size:11px;">{{ $item->pil2 }}</span></td>
          <td class="px-2 py-2.5 text-center font-medium cell-pil3"><span class="bg-slate-50 text-slate-500 px-1.5 py-0.5 rounded" style="font-size:11px;">{{ $item->pil3 }}</span></td>
          <td class="px-3 py-2.5 cell-status">
            @php
              $badge = ['pending' => 'bg-amber-50 text-amber-600 border border-amber-200', 'verifikasi' => 'bg-blue-50 text-blue-600 border border-blue-200', 'diterima' => 'bg-emerald-50 text-emerald-600 border border-emerald-200', 'ditolak' => 'bg-red-50 text-red-500 border border-red-200'];
            @endphp
            <span class="status-badge inline-flex items-center px-2 py-0.5 rounded-full font-medium {{ $badge[$item->status] ?? 'bg-slate-100 text-slate-500 border border-slate-200' }}" style="font-size:10.5px;">
              {{ ucfirst($item->status) }}
            </span>
          </td>
          <td class="px-3 py-2.5 text-right">
            <div class="flex items-center justify-end gap-1">
              {{-- Cetak --}}
              <a href="{{ route('admin.pendaftaran.cetak', $item) }}" target="_blank" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-primary hover:bg-orange-50 transition-colors" title="Cetak Bukti" style="font-size:12px;">
                <i class="fas fa-print"></i>
              </a>
              {{-- Detail --}}
              <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors btn-detail" data-id="{{ $item->id }}" title="Detail Info" style="font-size:12px;">
                <i class="fas fa-eye"></i>
              </button>
              {{-- Verifikasi Berkas --}}
              <a href="{{ route('admin.pendaftaran.show', $item) }}" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-colors" title="Verifikasi Berkas" style="font-size:12px;">
                <i class="fas fa-check-double"></i>
              </a>
              {{-- Edit --}}
              <button type="button" class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-amber-500 hover:bg-amber-50 transition-colors btn-edit" data-id="{{ $item->id }}" title="Edit Data" style="font-size:12px;">
                <i class="fas fa-edit"></i>
              </button>
              {{-- Hapus --}}
              <button type="button"
                class="inline-flex items-center justify-center w-7 h-7 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors btn-delete"
                data-nama="{{ $item->nama_lengkap }}"
                data-no="{{ $item->no_daftar }}"
                data-url="{{ route('admin.pendaftaran.destroy', $item) }}"
                title="Hapus Data" style="font-size:12px;">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="15" class="px-4 py-12 text-center text-slate-400">
            <i class="fas fa-clipboard-list text-4xl mb-3 block"></i>
            <p>Belum ada data pendaftaran</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="px-6 py-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <p class="text-xs text-slate-400">
      Menampilkan {{ $pendaftaran->firstItem() ?? 0 }}–{{ $pendaftaran->lastItem() ?? 0 }} dari {{ $pendaftaran->total() }} pendaftar
      @if($search ?? false)<span class="ml-1 text-primary font-medium">untuk pencarian "{{ $search }}"</span>@endif
    </p>
    @if($pendaftaran->hasPages())
      {{ $pendaftaran->links() }}
    @endif
  </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="delete-modal" class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
  <div id="delete-modal-box" class="bg-white rounded-2xl max-w-sm w-full shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300">
    <div class="p-6 text-center">
      <div class="mx-auto w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
        <i class="fas fa-trash-alt text-2xl text-red-500"></i>
      </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Data Pendaftar?</h3>
      <p class="text-sm text-slate-500 mb-1">Anda akan menghapus data:</p>
      <p id="delete-modal-nama" class="text-sm font-bold text-slate-800 mb-1"></p>
      <p id="delete-modal-no" class="text-xs text-slate-500 mb-4"></p>
      <p class="text-xs text-red-500 bg-red-50 border border-red-100 rounded-xl px-3 py-2 mb-6">
        <i class="fas fa-exclamation-triangle mr-1"></i>
        Tindakan ini akan menghapus <strong>seluruh data terkait</strong> (Kesehatan, Wawancara, Pembayaran, Berkas/Foto) secara <strong>permanen</strong> dan tidak dapat dibatalkan.
      </p>
      <div class="flex gap-3">
        <button type="button" id="delete-modal-cancel"
          class="flex-1 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition-colors">
          Batal
        </button>
        <button type="button" id="delete-modal-confirm"
          class="flex-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl text-sm transition-colors flex items-center justify-center gap-2">
          <i class="fas fa-trash-alt"></i> Ya, Hapus
        </button>
      </div>
    </div>
  </div>
</div>

{{-- Dynamic Modal for Detail & Edit --}}
<div id="pendaftaran-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 overflow-y-auto">
  <div class="bg-white rounded-3xl max-w-5xl w-full shadow-2xl overflow-hidden flex flex-col my-8 max-h-[90vh] transform scale-95 opacity-0 transition-all duration-300" id="modal-content">
    
    {{-- Modal Header --}}
    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
          <i id="modal-title-icon" class="fas fa-eye text-lg"></i>
        </div>
        <div>
          <h3 id="modal-title" class="font-bold text-slate-800 text-base sm:text-lg">Detail Calon Siswa</h3>
          <p id="modal-subtitle" class="text-xs text-slate-400"></p>
        </div>
      </div>
      <div class="flex items-center gap-3">
        {{-- View / Edit Mode Switcher --}}
        <button type="button" id="modal-mode-toggle" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5">
          <i class="fas fa-edit"></i> <span id="modal-mode-text">Ubah Data</span>
        </button>
        <button type="button" onclick="closePendaftaranModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-bold leading-none p-1">&times;</button>
      </div>
    </div>
    
    {{-- Modal Body (Scrollable) --}}
    <div class="flex-grow overflow-y-auto custom-scrollbar">
      
      {{-- Loading Spinner State --}}
      <div id="modal-loading-state" class="py-20 flex flex-col items-center justify-center text-slate-400">
        <i class="fas fa-spinner fa-spin text-4xl text-primary mb-3"></i>
        <p class="text-sm font-medium">Memuat data pendaftar...</p>
      </div>
      
      {{-- Detail View Content --}}
      <div id="modal-detail-view" class="p-6 md:p-8 space-y-8 hidden">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          {{-- Left Side: Photo & Status --}}
          <div class="md:col-span-1 flex flex-col items-center text-center space-y-4 border-b md:border-b-0 md:border-r border-slate-100 pb-6 md:pb-0 md:pr-6">
            <div class="w-36 h-48 rounded-xl bg-slate-50 border border-slate-200 shadow-inner overflow-hidden flex items-center justify-center relative group">
              <img id="detail-foto-siswa" src="" class="w-full h-full object-cover hidden">
              <div id="detail-foto-placeholder" class="text-slate-300 flex flex-col items-center justify-center">
                <i class="fas fa-user-circle text-7xl"></i>
                <span class="text-xxs mt-2 text-slate-400">Belum ada foto</span>
              </div>
            </div>
            
            <div class="w-full">
              <div id="detail-status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize"></div>
            </div>
            
            <div class="w-full space-y-2 pt-2">
              <a id="detail-link-cetak" href="#" target="_blank" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-1.5 border border-slate-200 shadow-sm">
                <i class="fas fa-print"></i> Cetak Kartu Pendaftaran
              </a>
            </div>
          </div>
          
          {{-- Right Side: Fields Grid --}}
          <div class="md:col-span-3 space-y-8">
            {{-- Data Diri --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-user"></i> Data Diri Calon Siswa
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Nama Lengkap</span>
                  <span id="d-nama" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Tempat, Tgl Lahir</span>
                  <span id="d-ttl" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Jenis Kelamin</span>
                  <span id="d-jk" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Agama</span>
                  <span id="d-agama" class="text-sm font-semibold text-slate-800 block mt-1 capitalize"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">No. HP Siswa</span>
                  <span id="d-hp-siswa" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Asal Sekolah</span>
                  <span id="d-asal-sekolah" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div class="sm:col-span-2 md:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Alamat Sekolah Asal</span>
                  <span id="d-alamat-sekolah" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div class="sm:col-span-2 md:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Prestasi</span>
                  <span id="d-prestasi" class="text-sm font-semibold text-slate-800 block mt-1 italic"></span>
                </div>
              </div>
            </div>
            
            {{-- Data Orang Tua --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-users"></i> Orang Tua / Wali
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Nama Orang Tua</span>
                  <span id="d-nama-ortu" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Pekerjaan Orang Tua</span>
                  <span id="d-pekerjaan-ortu" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">No. HP Orang Tua</span>
                  <span id="d-hp-ortu" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
              </div>
            </div>
            
            {{-- Alamat --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-map-marked-alt"></i> Informasi Alamat
              </h4>
              <div class="space-y-4">
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Alamat Asal (Sesuai KK)</span>
                  <p id="d-alamat-asal" class="text-sm font-semibold text-slate-800 mt-1.5 bg-slate-50 p-4 rounded-2xl border border-slate-100 leading-relaxed"></p>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Alamat Tempat Tinggal Sekarang</span>
                  <p id="d-alamat-tinggal" class="text-sm font-semibold text-slate-800 mt-1.5 bg-slate-50 p-4 rounded-2xl border border-slate-100 leading-relaxed"></p>
                </div>
              </div>
            </div>
            
            {{-- Pilihan Jurusan --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-graduation-cap"></i> Pilihan Jurusan (Pilihan Kompetensi Keahlian)
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4">
                  <span class="text-xxs font-bold text-blue-500 uppercase block">Jurusan Ke-I</span>
                  <span id="d-pil1" class="text-sm font-bold text-blue-800 block mt-1"></span>
                </div>
                <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Jurusan Ke-II</span>
                  <span id="d-pil2" class="text-sm font-semibold text-slate-700 block mt-1"></span>
                </div>
                <div class="bg-slate-50 border border-slate-150 rounded-2xl p-4">
                  <span class="text-xxs font-bold text-slate-400 uppercase block">Jurusan Ke-III</span>
                  <span id="d-pil3" class="text-sm font-semibold text-slate-700 block mt-1"></span>
                </div>
              </div>
            </div>
            
            {{-- Berkas Unggahan --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Berkas Unggahan
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="border border-slate-200 rounded-2xl p-4 flex items-center justify-between bg-white">
                  <div>
                    <span class="text-xs font-bold text-slate-700 block">Akta Kelahiran</span>
                    <span id="d-akta-status" class="text-xxs block mt-1"></span>
                  </div>
                  <a id="d-akta-link" href="#" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Lihat File
                  </a>
                </div>
                <div class="border border-slate-200 rounded-2xl p-4 flex items-center justify-between bg-white">
                  <div>
                    <span class="text-xs font-bold text-slate-700 block">Kartu Keluarga [KK]</span>
                    <span id="d-kk-status" class="text-xxs block mt-1"></span>
                  </div>
                  <a id="d-kk-link" href="#" target="_blank" class="bg-primary/10 text-primary hover:bg-primary/20 text-xs font-bold px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1">
                    <i class="fas fa-external-link-alt"></i> Lihat File
                  </a>
                </div>
              </div>
            </div>
            
            {{-- Hasil Pemeriksaan Kesehatan (UKS) --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-heartbeat text-emerald-500"></i> Pemeriksaan Kesehatan (UKS)
              </h4>
              <div id="d-uks-empty" class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center text-xs text-slate-500 italic hidden">
                <i class="fas fa-info-circle mr-1"></i> Belum ada data pemeriksaan kesehatan dari petugas UKS.
              </div>
              <div id="d-uks-content" class="grid grid-cols-1 sm:grid-cols-3 gap-5 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Tinggi / Berat Badan</span>
                  <span id="d-kesehatan-tinggi-berat" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Golongan Darah</span>
                  <span id="d-kesehatan-golongan-darah" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Mata Minus (Kanan/Kiri)</span>
                  <span id="d-kesehatan-mata-minus" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Buta Warna</span>
                  <span id="d-kesehatan-buta-warna" class="text-sm font-semibold block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Tato & Tindik</span>
                  <span id="d-kesehatan-tato-tindik" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Riwayat Penyakit</span>
                  <span id="d-kesehatan-riwayat" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Petugas / Waktu Periksa</span>
                  <span id="d-kesehatan-petugas-info" class="text-xs font-semibold text-slate-550 block mt-1 leading-tight"></span>
                </div>
                <div class="sm:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Catatan Kesehatan</span>
                  <p id="d-kesehatan-catatan" class="text-sm font-semibold text-slate-800 mt-1 bg-white p-3 rounded-xl border border-slate-100 italic"></p>
                </div>
              </div>
            </div>

            {{-- Wawancara & Gaya Belajar --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-comments text-purple-500"></i> Wawancara, Minat Bakat &amp; Gaya Belajar
              </h4>
              <div id="d-wawancara-empty" class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-center text-xs text-slate-500 italic hidden">
                <i class="fas fa-info-circle mr-1"></i> Belum ada data wawancara dan tes gaya belajar.
              </div>
              <div id="d-wawancara-content" class="grid grid-cols-1 sm:grid-cols-3 gap-5 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Tipe Gaya Belajar</span>
                  <span id="d-gaya-tipe" class="text-sm font-bold text-purple-800 block mt-1 capitalize"></span>
                </div>
                <div class="sm:col-span-2">
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Minat Bakat / Hobi</span>
                  <span id="d-gaya-minat" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Baca Tulis Al-Qur'an</span>
                  <span id="d-wawancara-alquran" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Sholat 5 Waktu</span>
                  <span id="d-wawancara-sholat" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Kepribadian / Sikap</span>
                  <span id="d-wawancara-kepribadian" class="text-sm font-semibold text-slate-800 block mt-1"></span>
                </div>
                <div class="sm:col-span-2">
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Catatan Gaya Belajar</span>
                  <span id="d-gaya-catatan" class="text-sm font-semibold text-slate-800 block mt-1 italic"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Petugas / Waktu Wawancara</span>
                  <span id="d-wawancara-petugas-info" class="text-xs font-semibold text-slate-550 block mt-1 leading-tight"></span>
                </div>
                <div class="sm:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Catatan Wawancara</span>
                  <p id="d-wawancara-catatan" class="text-sm font-semibold text-slate-800 mt-1 bg-white p-3 rounded-xl border border-slate-100 italic"></p>
                </div>
              </div>
            </div>

            {{-- Pembayaran --}}
            <div>
              <h4 class="text-xs font-bold text-primary uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fas fa-coins text-yellow-500"></i> Pembayaran Pendaftaran (Keuangan)
              </h4>
              <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 bg-slate-50/50 p-5 rounded-2xl border border-slate-100">
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Status Pembayaran</span>
                  <span id="d-pembayaran-status" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold mt-1.5"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Nominal Transaksi</span>
                  <span id="d-pembayaran-nominal" class="text-sm font-bold text-slate-850 block mt-1 font-mono"></span>
                </div>
                <div>
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Petugas / Waktu Transaksi</span>
                  <span id="d-pembayaran-petugas-info" class="text-xs font-semibold text-slate-550 block mt-1 leading-tight"></span>
                </div>
                <div class="sm:col-span-3">
                  <span class="text-xxs font-bold text-slate-400 block uppercase">Catatan Pembayaran</span>
                  <p id="d-pembayaran-catatan" class="text-sm font-semibold text-slate-800 mt-1 bg-white p-3 rounded-xl border border-slate-100 italic"></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      {{-- Edit Form Content --}}
      <div id="modal-edit-view" class="p-6 md:p-8 hidden">
        <form id="modal-edit-form" class="space-y-8" novalidate>
          <input type="hidden" name="_method" value="PUT">
          
          {{-- Section 1: Data Calon Siswa --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-user"></i> Data Calon Siswa
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama_lengkap" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tempat Lahir <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Lahir <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-3 gap-2">
                  <select name="tgl" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
                    <option value="">Tgl</option>
                    @for($i = 1; $i <= 31; $i++)
                      <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                  <select name="bulan" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
                    <option value="">Bulan</option>
                    @foreach(['01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember'] as $key => $name)
                      <option value="{{ $key }}">{{ $name }}</option>
                    @endforeach
                  </select>
                  <select name="tahun" required class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-sm">
                    <option value="">Tahun</option>
                    @for($y = 2000; $y <= 2020; $y++)
                      <option value="{{ $y }}">{{ $y }}</option>
                    @endfor
                  </select>
                </div>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenkel" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilih Jenis Kelamin --</option>
                  <option value="L">Laki-Laki</option>
                  <option value="P">Perempuan</option>
                </select>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Agama <span class="text-red-500">*</span></label>
                <select name="agama" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="islam">Islam</option>
                  <option value="kristen">Kristen</option>
                  <option value="katolik">Katolik</option>
                  <option value="hindu">Hindu</option>
                  <option value="budha">Budha</option>
                </select>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP Siswa <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp_siswa" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Asal Sekolah <span class="text-red-500">*</span></label>
                <input type="text" name="asal_sekolah" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Sekolah Asal</label>
                <textarea name="alamat_sekolah" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm resize-none"></textarea>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Prestasi yang Pernah Diraih</label>
                <textarea name="prestasi" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm resize-none"></textarea>
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
            </div>
          </div>
          
          {{-- Section 2: Data Orang Tua --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-users"></i> Data Orang Tua / Wali
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Orang Tua <span class="text-red-500">*</span></label>
                <input type="text" name="nama_ortu" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pekerjaan Orang Tua <span class="text-red-500">*</span></label>
                <input type="text" name="pekerjaan_ortu" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">No. HP Orang Tua <span class="text-red-500">*</span></label>
                <input type="text" name="no_hp_ortu" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                <span class="error-msg text-red-500 text-xs mt-1 block hidden"></span>
              </div>
            </div>
          </div>
          
          {{-- Section 3: Alamat --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-map-marked-alt"></i> Alamat Lengkap
            </h4>
            
            {{-- Alamat Asal --}}
            <div>
              <h5 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Alamat Asal (Sesuai KK)</h5>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Jalan</label>
                  <input type="text" name="jalan_asal" id="m_jalan_asal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Dusun</label>
                  <input type="text" name="dusun_asal" id="m_dusun_asal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RT <span class="text-red-500">*</span></label>
                    <input type="text" name="rt_asal" id="m_rt_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RW</label>
                    <input type="text" name="rw_asal" id="m_rw_asal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Desa <span class="text-red-500">*</span></label>
                  <input type="text" name="desa_asal" id="m_desa_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                  <input type="text" name="kecamatan_asal" id="m_kecamatan_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kabupaten <span class="text-red-500">*</span></label>
                  <input type="text" name="kabupaten_asal" id="m_kabupaten_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi <span class="text-red-500">*</span></label>
                  <input type="text" name="provinsi_asal" id="m_provinsi_asal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
              </div>
            </div>
            
            <div class="flex items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
              <input type="checkbox" id="m_copy_address" class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary cursor-pointer">
              <label for="m_copy_address" class="ml-3 text-sm font-semibold text-slate-700 cursor-pointer">
                Centang jika Alamat Tinggal Sekarang sama dengan Alamat Asal
              </label>
            </div>
            
            {{-- Alamat Tinggal --}}
            <div>
              <h5 class="text-xs font-bold text-slate-600 mb-3 uppercase tracking-wide">Alamat Tinggal Sekarang</h5>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Jalan</label>
                  <input type="text" name="jalan_tinggal" id="m_jalan_tinggal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Dusun</label>
                  <input type="text" name="dusun_tinggal" id="m_dusun_tinggal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RT <span class="text-red-500">*</span></label>
                    <input type="text" name="rt_tinggal" id="m_rt_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                  <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">RW</label>
                    <input type="text" name="rw_tinggal" id="m_rw_tinggal" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none" placeholder="00">
                  </div>
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Desa <span class="text-red-500">*</span></label>
                  <input type="text" name="desa_tinggal" id="m_desa_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kecamatan <span class="text-red-500">*</span></label>
                  <input type="text" name="kecamatan_tinggal" id="m_kecamatan_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Kabupaten <span class="text-red-500">*</span></label>
                  <input type="text" name="kabupaten_tinggal" id="m_kabupaten_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
                <div>
                  <label class="block text-xs font-semibold text-slate-500 mb-1">Provinsi <span class="text-red-500">*</span></label>
                  <input type="text" name="provinsi_tinggal" id="m_provinsi_tinggal" required class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-1 focus:ring-primary focus:border-primary outline-none">
                </div>
              </div>
            </div>
          </div>
          
          {{-- Section 4: Pilihan Jurusan --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-graduation-cap"></i> Pilihan Kompetensi Keahlian (Jurusan)
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
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
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan I <span class="text-red-500">*</span></label>
                <select name="pil1" id="m_pil1" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilihan Jurusan I --</option>
                  @foreach($jurusans as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan II <span class="text-red-500">*</span></label>
                <select name="pil2" id="m_pil2" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilihan Jurusan II --</option>
                  @foreach($jurusans as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pilihan III <span class="text-red-500">*</span></label>
                <select name="pil3" id="m_pil3" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="">-- Pilihan Jurusan III --</option>
                  @foreach($jurusans as $code => $name)
                    <option value="{{ $code }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <p id="m_jurusan-error" class="hidden text-xs text-red-500 font-medium"><i class="fas fa-exclamation-circle mr-1"></i> Pilihan jurusan tidak boleh ada yang sama!</p>
          </div>
          
          {{-- Section 5: Status & Berkas --}}
          <div class="space-y-5">
            <h4 class="text-xs font-bold text-primary uppercase tracking-wider pb-2 border-b border-slate-100 flex items-center gap-2">
              <i class="fas fa-file-upload"></i> Berkas & Status
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5">
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Gelombang Pendaftaran <span class="text-red-500">*</span></label>
                <select name="gelombang_id" id="m_gelombang_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  {{-- populated dynamically --}}
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Pendaftaran <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition text-sm">
                  <option value="pending">Pending</option>
                  <option value="verifikasi">Verifikasi</option>
                  <option value="diterima">Diterima</option>
                  <option value="ditolak">Ditolak</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Akta Kelahiran</label>
                <input type="file" name="foto_akta" accept="image/*,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer mb-2">
                <span id="m_akta_helper" class="text-xs text-emerald-600 font-medium block"></span>
              </div>
              <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kartu Keluarga [KK]</label>
                <input type="file" name="foto_kk" accept="image/*,application/pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer mb-2">
                <span id="m_kk_helper" class="text-xs text-emerald-600 font-medium block"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      
    </div>
    
    {{-- Modal Footer --}}
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex items-center justify-end gap-3 flex-shrink-0">
      <button type="button" id="modal-cancel-btn" onclick="closePendaftaranModal()" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-xl text-sm transition">Tutup</button>
      <button type="button" id="modal-save-btn" class="px-5 py-2.5 bg-primary hover:bg-secondary text-white font-semibold rounded-xl text-sm transition shadow-lg shadow-primary/20 flex items-center gap-2 hidden">
        <i class="fas fa-save"></i> Simpan Perubahan
      </button>
    </div>
    
  </div>
</div>

@endsection

@section('styles')
<style>
  .custom-scrollbar::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }
  .custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
  }
  .custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  .custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
</style>
@endsection

@section('scripts')
<script>
  let currentPendaftaranId = null;
  let modalMode = 'detail'; // 'detail' or 'edit'
  let originalData = null; // store current fetched data
  let originalGelombangs = []; // store current fetched gelombangs

  function openPendaftaranModal(id, mode = 'detail') {
    currentPendaftaranId = id;
    modalMode = mode;
    
    const modal = document.getElementById('pendaftaran-modal');
    const modalContent = document.getElementById('modal-content');
    
    // Reset UI states
    document.getElementById('modal-loading-state').classList.remove('hidden');
    document.getElementById('modal-detail-view').classList.add('hidden');
    document.getElementById('modal-edit-view').classList.add('hidden');
    document.getElementById('modal-save-btn').classList.add('hidden');
    document.getElementById('modal-cancel-btn').textContent = 'Tutup';
    
    // Open modal container
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
      modalContent.classList.remove('scale-95', 'opacity-0');
      modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Fetch details
    fetch(`/admin/pendaftaran/${id}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(res => {
      if (res.success) {
        originalData = res.data;
        originalGelombangs = res.gelombangs;
        
        // Populate Detail View
        populateDetailView(res.data);
        
        // Populate Edit View
        populateEditView(res.data, res.gelombangs);
        
        // Toggle to correct mode
        setModalMode(modalMode);
      } else {
        alert('Gagal mengambil data pendaftar.');
        closePendaftaranModal();
      }
    })
    .catch(err => {
      console.error(err);
      alert('Terjadi kesalahan koneksi.');
      closePendaftaranModal();
    });
  }

  function populateDetailView(data) {
    document.getElementById('modal-subtitle').textContent = `No. Daftar: ${data.no_daftar} • Tahun: ${data.tahun_aktif}`;
    
    // Foto Siswa
    const fotoImg = document.getElementById('detail-foto-siswa');
    const fotoPl = document.getElementById('detail-foto-placeholder');
    if (data.foto_siswa) {
      fotoImg.src = `/storage/${data.foto_siswa}`;
      fotoImg.classList.remove('hidden');
      fotoPl.classList.add('hidden');
    } else {
      fotoImg.src = '';
      fotoImg.classList.add('hidden');
      fotoPl.classList.remove('hidden');
    }
    
    // Status Badge
    const statusBadge = document.getElementById('detail-status-badge');
    statusBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize ';
    if (data.status === 'pending') {
      statusBadge.classList.add('bg-yellow-100', 'text-yellow-700');
    } else if (data.status === 'verifikasi') {
      statusBadge.classList.add('bg-blue-100', 'text-blue-700');
    } else if (data.status === 'diterima') {
      statusBadge.classList.add('bg-green-100', 'text-green-700');
    } else if (data.status === 'ditolak') {
      statusBadge.classList.add('bg-red-100', 'text-red-700');
    }
    statusBadge.textContent = data.status;
    
    // Cetak Link
    document.getElementById('detail-link-cetak').href = `/admin/pendaftaran/${data.id}/cetak`;
    
    // Data Diri
    document.getElementById('d-nama').textContent = data.nama_lengkap || '-';
    
    // TTL
    const options = { day: 'numeric', month: 'short', year: 'numeric' };
    const birthDate = data.tanggal_lahir ? new Date(data.tanggal_lahir).toLocaleDateString('id-ID', options) : '-';
    document.getElementById('d-ttl').textContent = `${data.tempat_lahir || ''}, ${birthDate}`;
    
    document.getElementById('d-jk').textContent = data.jenis_kelamin === 'L' ? 'Laki-Laki' : (data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
    document.getElementById('d-agama').textContent = data.agama || '-';
    document.getElementById('d-hp-siswa').textContent = data.no_hp_siswa || '-';
    document.getElementById('d-asal-sekolah').textContent = data.asal_sekolah || '-';
    document.getElementById('d-alamat-sekolah').textContent = data.alamat_sekolah || '-';
    document.getElementById('d-prestasi').textContent = data.prestasi || '-';
    
    // Ortu
    document.getElementById('d-nama-ortu').textContent = data.nama_ortu || '-';
    document.getElementById('d-pekerjaan-ortu').textContent = data.pekerjaan_ortu || '-';
    document.getElementById('d-hp-ortu').textContent = data.no_hp_ortu || '-';
    
    // Alamat
    const formatAddress = (jalan, dusun, rt, rw, desa, kec, kab, prov) => {
      let parts = [];
      if (jalan) parts.push(jalan);
      if (dusun) parts.push('Dsn. ' + dusun);
      if (rt) {
        let rtrw = 'RT ' + rt;
        if (rw) rtrw += ' / RW ' + rw;
        parts.push(rtrw);
      }
      if (desa) parts.push('Kel. ' + desa);
      if (kec) parts.push('Kec. ' + kec);
      if (kab) parts.push('Kab. ' + kab);
      if (prov) parts.push('Prov. ' + prov);
      return parts.join(', ') || '-';
    };
    
    document.getElementById('d-alamat-asal').textContent = formatAddress(
      data.jalan_asal, data.dusun_asal, data.rt_asal, data.rw_asal, data.desa_asal, data.kecamatan_asal, data.kabupaten_asal, data.provinsi_asal
    );
    document.getElementById('d-alamat-tinggal').textContent = formatAddress(
      data.jalan_tinggal, data.dusun_tinggal, data.rt_tinggal, data.rw_tinggal, data.desa_tinggal, data.kecamatan_tinggal, data.kabupaten_tinggal, data.provinsi_tinggal
    );
    
    // Jurusan
    const jurusansMap = {
      'TKR': 'Teknik Kendaraan Ringan (Otomotif)',
      'TPM': 'Teknik Permesinan',
      'TAV': 'Teknik Audio Video (Elektronika)',
      'TBSM': 'Teknik Bisnis Sepeda Motor',
      'RPL': 'Rekayasa Perangkat Lunak (Komputer)'
    };
    document.getElementById('d-pil1').textContent = jurusansMap[data.pil1] || data.pil1 || '-';
    document.getElementById('d-pil2').textContent = jurusansMap[data.pil2] || data.pil2 || '-';
    document.getElementById('d-pil3').textContent = jurusansMap[data.pil3] || data.pil3 || '-';
    
    // Berkas Status & Link
    const setBerkasLink = (linkId, statusId, path) => {
      const link = document.getElementById(linkId);
      const status = document.getElementById(statusId);
      if (path) {
        link.href = `/storage/${path}`;
        link.classList.remove('hidden');
        status.className = 'text-xxs text-emerald-600 font-semibold mt-0.5';
        status.innerHTML = '<i class="fas fa-check-circle"></i> Berkas Terlampir';
      } else {
        link.href = '#';
        link.classList.add('hidden');
        status.className = 'text-xxs text-slate-400 font-semibold mt-0.5';
        status.textContent = 'Belum diupload';
      }
    };
    setBerkasLink('d-akta-link', 'd-akta-status', data.foto_akta);
    setBerkasLink('d-kk-link', 'd-kk-status', data.foto_kk);

    // UKS / Kesehatan
    if (data.kesehatan_verified_at) {
      document.getElementById('d-uks-empty').classList.add('hidden');
      document.getElementById('d-uks-content').classList.remove('hidden');
      
      document.getElementById('d-kesehatan-tinggi-berat').textContent = `${data.kesehatan_tinggi_badan || '-'} cm / ${data.kesehatan_berat_badan || '-'} kg`;
      document.getElementById('d-kesehatan-golongan-darah').textContent = data.kesehatan_golongan_darah || '-';
      document.getElementById('d-kesehatan-mata-minus').textContent = data.kesehatan_mata_minus || '-';
      
      const butaWarnaEl = document.getElementById('d-kesehatan-buta-warna');
      butaWarnaEl.className = 'text-sm font-semibold block mt-1 ' + (data.kesehatan_buta_warna === 'ya' ? 'text-rose-600' : 'text-emerald-600');
      butaWarnaEl.textContent = data.kesehatan_buta_warna === 'ya' ? 'Ya (Buta Warna)' : 'Tidak (Normal)';
      
      let tatoTindikText = '-';
      if (data.kesehatan_tato_tindik === 'tidak') tatoTindikText = 'Tidak bertato/tindik';
      else if (data.kesehatan_tato_tindik === 'tato') tatoTindikText = 'Ada Tato';
      else if (data.kesehatan_tato_tindik === 'tindik') tatoTindikText = 'Ada Tindik';
      else if (data.kesehatan_tato_tindik === 'tato_tindik') tatoTindikText = 'Tato & Tindik';
      document.getElementById('d-kesehatan-tato-tindik').textContent = tatoTindikText;
      
      document.getElementById('d-kesehatan-riwayat').textContent = data.kesehatan_riwayat_penyakit || 'Tidak ada';
      
      const periksaDate = data.kesehatan_verified_at ? new Date(data.kesehatan_verified_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
      document.getElementById('d-kesehatan-petugas-info').innerHTML = `${data.kesehatan_petugas || '-'}<br><span class="text-xxs text-slate-400 font-normal">${periksaDate}</span>`;
      
      document.getElementById('d-kesehatan-catatan').textContent = data.kesehatan_catatan || '-';
    } else {
      document.getElementById('d-uks-empty').classList.remove('hidden');
      document.getElementById('d-uks-content').classList.add('hidden');
    }

    // Wawancara & Gaya Belajar
    if (data.wawancara_verified_at || data.gaya_belajar_verified_at) {
      document.getElementById('d-wawancara-empty').classList.add('hidden');
      document.getElementById('d-wawancara-content').classList.remove('hidden');
      
      document.getElementById('d-gaya-tipe').textContent = data.gaya_belajar_tipe || '-';
      document.getElementById('d-gaya-minat').textContent = data.gaya_belajar_minat_bakat || '-';
      document.getElementById('d-wawancara-alquran').textContent = data.wawancara_baca_tulis_alquran || '-';
      document.getElementById('d-wawancara-sholat').textContent = data.wawancara_solat_fardhu || '-';
      document.getElementById('d-wawancara-kepribadian').textContent = data.wawancara_kepribadian || '-';
      document.getElementById('d-gaya-catatan').textContent = data.gaya_belajar_catatan || '-';
      
      const wawancaraDate = data.wawancara_verified_at 
        ? new Date(data.wawancara_verified_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
        : (data.gaya_belajar_verified_at ? new Date(data.gaya_belajar_verified_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '');
      const petugasWawancara = data.wawancara_petugas || data.gaya_belajar_petugas || '-';
      document.getElementById('d-wawancara-petugas-info').innerHTML = `${petugasWawancara}<br><span class="text-xxs text-slate-400 font-normal">${wawancaraDate}</span>`;
      
      document.getElementById('d-wawancara-catatan').textContent = data.wawancara_catatan || '-';
    } else {
      document.getElementById('d-wawancara-empty').classList.remove('hidden');
      document.getElementById('d-wawancara-content').classList.add('hidden');
    }

    // Pembayaran
    const statusPembayaranEl = document.getElementById('d-pembayaran-status');
    statusPembayaranEl.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold mt-1.5 ';
    if (data.pembayaran_status === 'lunas') {
      statusPembayaranEl.classList.add('bg-emerald-100', 'text-emerald-800');
      statusPembayaranEl.innerHTML = '<i class="fas fa-check-circle"></i> LUNAS';
    } else {
      statusPembayaranEl.classList.add('bg-red-100', 'text-red-800');
      statusPembayaranEl.innerHTML = '<i class="fas fa-times-circle"></i> BELUM BAYAR';
    }
    
    const nominal = data.pembayaran_nominal ? new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(data.pembayaran_nominal) : 'Rp 0';
    document.getElementById('d-pembayaran-nominal').textContent = nominal;
    
    const bayarDate = data.pembayaran_verified_at ? new Date(data.pembayaran_verified_at).toLocaleString('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : '';
    document.getElementById('d-pembayaran-petugas-info').innerHTML = `${data.pembayaran_petugas || '-'}<br><span class="text-xxs text-slate-400 font-normal">${bayarDate}</span>`;
    
    document.getElementById('d-pembayaran-catatan').textContent = data.pembayaran_keterangan || '-';
  }

  function populateEditView(data, gelombangs) {
    const form = document.getElementById('modal-edit-form');
    clearErrors();
    
    form.nama_lengkap.value = data.nama_lengkap || '';
    form.tempat_lahir.value = data.tempat_lahir || '';
    
    // Tanggal Lahir
    if (data.tanggal_lahir) {
      // split birthday format YYYY-MM-DD
      const dateParts = data.tanggal_lahir.split('-');
      if (dateParts.length === 3) {
        form.tgl.value = parseInt(dateParts[2]);
        form.bulan.value = dateParts[1];
        form.tahun.value = dateParts[0];
      }
    } else {
      form.tgl.value = '';
      form.bulan.value = '';
      form.tahun.value = '';
    }
    
    form.jenkel.value = data.jenis_kelamin || '';
    form.agama.value = data.agama || 'islam';
    form.no_hp_siswa.value = data.no_hp_siswa || '';
    form.asal_sekolah.value = data.asal_sekolah || '';
    form.alamat_sekolah.value = data.alamat_sekolah || '';
    form.prestasi.value = data.prestasi || '';
    
    form.nama_ortu.value = data.nama_ortu || '';
    form.pekerjaan_ortu.value = data.pekerjaan_ortu || '';
    form.no_hp_ortu.value = data.no_hp_ortu || '';
    
    // Alamat
    form.jalan_asal.value = data.jalan_asal || '';
    form.dusun_asal.value = data.dusun_asal || '';
    form.rt_asal.value = data.rt_asal || '';
    form.rw_asal.value = data.rw_asal || '';
    form.desa_asal.value = data.desa_asal || '';
    form.kecamatan_asal.value = data.kecamatan_asal || '';
    form.kabupaten_asal.value = data.kabupaten_asal || '';
    form.provinsi_asal.value = data.provinsi_asal || '';
    
    // Check if alamat tinggal is identical to asal
    const isIdentical = (
      data.jalan_asal === data.jalan_tinggal &&
      data.dusun_asal === data.dusun_tinggal &&
      data.rt_asal === data.rt_tinggal &&
      data.rw_asal === data.rw_tinggal &&
      data.desa_asal === data.desa_tinggal &&
      data.kecamatan_asal === data.kecamatan_tinggal &&
      data.kabupaten_asal === data.kabupaten_tinggal &&
      data.provinsi_asal === data.provinsi_tinggal
    );
    
    document.getElementById('m_copy_address').checked = isIdentical;
    
    form.jalan_tinggal.value = data.jalan_tinggal || '';
    form.dusun_tinggal.value = data.dusun_tinggal || '';
    form.rt_tinggal.value = data.rt_tinggal || '';
    form.rw_tinggal.value = data.rw_tinggal || '';
    form.desa_tinggal.value = data.desa_tinggal || '';
    form.kecamatan_tinggal.value = data.kecamatan_tinggal || '';
    form.kabupaten_tinggal.value = data.kabupaten_tinggal || '';
    form.provinsi_tinggal.value = data.provinsi_tinggal || '';
    
    if (isIdentical) {
      const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
      fields.forEach(f => {
        const el = document.getElementById('m_' + f + '_tinggal');
        if (el) {
          el.setAttribute('readonly', 'readonly');
          el.classList.add('bg-slate-50', 'cursor-not-allowed');
        }
      });
    } else {
      const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
      fields.forEach(f => {
        const el = document.getElementById('m_' + f + '_tinggal');
        if (el) {
          el.removeAttribute('readonly');
          el.classList.remove('bg-slate-50', 'cursor-not-allowed');
        }
      });
    }
    
    // Jurusan
    form.pil1.value = data.pil1 || '';
    form.pil2.value = data.pil2 || '';
    form.pil3.value = data.pil3 || '';
    m_validateJurusan();
    
    // Gelombang
    const gelSelect = document.getElementById('m_gelombang_id');
    gelSelect.innerHTML = '';
    gelombangs.forEach(g => {
      const opt = document.createElement('option');
      opt.value = g.id;
      opt.textContent = `${g.nama_gelombang} (${g.tahun_ajaran})${g.is_aktif ? ' — Aktif' : ''}`;
      if (data.gelombang === g.nama_gelombang) {
        opt.selected = true;
      } else if (!data.gelombang && g.is_aktif) {
        opt.selected = true;
      }
      gelSelect.appendChild(opt);
    });
    
    // Status
    form.status.value = data.status || 'pending';
    
    // Clear file input values
    form.foto_akta.value = '';
    form.foto_kk.value = '';
    
    // Show file upload helpers
    const aktaHelper = document.getElementById('m_akta_helper');
    const kkHelper = document.getElementById('m_kk_helper');
    if (data.foto_akta) {
      aktaHelper.innerHTML = `<i class="fas fa-check"></i> File Akta Terupload: <a href="/storage/${data.foto_akta}" target="_blank" class="text-primary hover:underline font-bold">Lihat File</a>`;
    } else {
      aktaHelper.textContent = '';
    }
    if (data.foto_kk) {
      kkHelper.innerHTML = `<i class="fas fa-check"></i> File KK Terupload: <a href="/storage/${data.foto_kk}" target="_blank" class="text-primary hover:underline font-bold">Lihat File</a>`;
    } else {
      kkHelper.textContent = '';
    }
  }

  function setModalMode(mode) {
    modalMode = mode;
    document.getElementById('modal-loading-state').classList.add('hidden');
    
    const detailView = document.getElementById('modal-detail-view');
    const editView = document.getElementById('modal-edit-view');
    const toggleBtn = document.getElementById('modal-mode-toggle');
    const toggleText = document.getElementById('modal-mode-text');
    const toggleIcon = toggleBtn.querySelector('i');
    
    const saveBtn = document.getElementById('modal-save-btn');
    const cancelBtn = document.getElementById('modal-cancel-btn');
    const title = document.getElementById('modal-title');
    const titleIcon = document.getElementById('modal-title-icon');
    
    if (mode === 'detail') {
      detailView.classList.remove('hidden');
      editView.classList.add('hidden');
      saveBtn.classList.add('hidden');
      cancelBtn.textContent = 'Tutup';
      
      title.textContent = 'Detail Calon Siswa';
      titleIcon.className = 'fas fa-eye text-lg';
      
      toggleText.textContent = 'Ubah Data';
      toggleIcon.className = 'fas fa-edit';
      toggleBtn.classList.remove('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
      toggleBtn.classList.add('bg-primary/10', 'text-primary', 'hover:bg-primary/20');
    } else {
      detailView.classList.add('hidden');
      editView.classList.remove('hidden');
      saveBtn.classList.remove('hidden');
      cancelBtn.textContent = 'Batal';
      
      title.textContent = 'Ubah Data Pendaftar';
      titleIcon.className = 'fas fa-edit text-lg';
      
      toggleText.textContent = 'Detail Siswa';
      toggleIcon.className = 'fas fa-eye';
      toggleBtn.classList.remove('bg-primary/10', 'text-primary', 'hover:bg-primary/20');
      toggleBtn.classList.add('bg-slate-100', 'text-slate-700', 'hover:bg-slate-200');
    }
  }

  function closePendaftaranModal() {
    const modal = document.getElementById('pendaftaran-modal');
    const modalContent = document.getElementById('modal-content');
    
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      currentPendaftaranId = null;
    }, 150);
  }

  function clearErrors() {
    document.querySelectorAll('#modal-edit-form .error-msg').forEach(el => {
      el.textContent = '';
      el.classList.add('hidden');
    });
    document.querySelectorAll('#modal-edit-form input, #modal-edit-form select, #modal-edit-form textarea').forEach(el => {
      el.classList.remove('border-red-400');
    });
  }

  function m_copyAddressFields() {
    const isChecked = document.getElementById('m_copy_address').checked;
    const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
    
    fields.forEach(field => {
      const sourceInput = document.getElementById('m_' + field + '_asal');
      const targetInput = document.getElementById('m_' + field + '_tinggal');
      if (sourceInput && targetInput) {
        if (isChecked) {
          targetInput.value = sourceInput.value;
          targetInput.setAttribute('readonly', 'readonly');
          targetInput.classList.add('bg-slate-50', 'cursor-not-allowed');
        } else {
          targetInput.removeAttribute('readonly');
          targetInput.classList.remove('bg-slate-50', 'cursor-not-allowed');
        }
      }
    });
  }

  function m_validateJurusan() {
    const pil1 = document.getElementById('m_pil1');
    const pil2 = document.getElementById('m_pil2');
    const pil3 = document.getElementById('m_pil3');
    if (!pil1 || !pil2 || !pil3) return;

    const pil1Val = pil1.value;
    const pil2Val = pil2.value;
    const pil3Val = pil3.value;

    function setSelectEnabled(select, enabled) {
      const disabledClass = ['bg-slate-100', 'text-slate-400', 'cursor-not-allowed'];
      const enabledClass  = ['bg-white', 'text-slate-800'];
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
    
    // Show error if there's duplicate
    const errorMsg = document.getElementById('m_jurusan-error');
    if ((pil1Val && pil2Val && pil1Val === pil2Val) || (pil1Val && pil3Val && pil1Val === pil3Val) || (pil2Val && pil3Val && pil2Val === pil3Val)) {
      errorMsg.classList.remove('hidden');
    } else {
      errorMsg.classList.add('hidden');
    }
  }

  function updateTableRow(id, data) {
    const row = document.querySelector(`tr[data-row-id="${id}"]`);
    if (!row) return;
    
    // Name
    const cellNama = row.querySelector('.cell-nama');
    if (cellNama) {
      cellNama.textContent = data.nama_lengkap;
      cellNama.title = data.nama_lengkap;
    }
    
    // Ortu
    const cellOrtu = row.querySelector('.cell-ortu');
    if (cellOrtu) {
      cellOrtu.textContent = data.nama_ortu;
      cellOrtu.title = data.nama_ortu;
    }
    
    // JK
    const cellJk = row.querySelector('.cell-jk');
    if (cellJk) cellJk.textContent = data.jenis_kelamin;
    
    // Agama
    const cellAgama = row.querySelector('.cell-agama');
    if (cellAgama) cellAgama.textContent = data.agama.toUpperCase();
    
    // Asal Sekolah
    const cellAsal = row.querySelector('.cell-asal');
    if (cellAsal) {
      cellAsal.textContent = data.asal_sekolah;
      cellAsal.title = data.asal_sekolah;
    }
    
    // Telp
    const cellTelpSiswa = row.querySelector('.cell-telp-siswa');
    if (cellTelpSiswa) cellTelpSiswa.textContent = data.no_hp_siswa;
    const cellTelpOrtu = row.querySelector('.cell-telp-ortu');
    if (cellTelpOrtu) cellTelpOrtu.textContent = data.no_hp_ortu;
    
    // Jurusan Choice
    const cellPil1 = row.querySelector('.cell-pil1 span');
    if (cellPil1) cellPil1.textContent = data.pil1;
    const cellPil2 = row.querySelector('.cell-pil2 span');
    if (cellPil2) cellPil2.textContent = data.pil2;
    const cellPil3 = row.querySelector('.cell-pil3 span');
    if (cellPil3) cellPil3.textContent = data.pil3;
    
    // Status Badge
    const cellStatus = row.querySelector('.cell-status');
    if (cellStatus) {
      const badgeSpan = cellStatus.querySelector('.status-badge');
      if (badgeSpan) {
        badgeSpan.className = 'status-badge inline-flex items-center px-2 py-0.5 rounded-full text-xxs font-medium ';
        
        const badgeClasses = {
          'pending': 'bg-yellow-100 text-yellow-700',
          'verifikasi': 'bg-blue-100 text-blue-700',
          'diterima': 'bg-green-100 text-green-700',
          'ditolak': 'bg-red-100 text-red-700'
        };
        
        badgeSpan.classList.add(...(badgeClasses[data.status] || 'bg-slate-100 text-slate-600').split(' '));
        badgeSpan.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
      }
    }
    
    // No Daftar & Gelombang
    const cellNoDaftar = row.querySelector('.cell-no-daftar');
    if (cellNoDaftar) {
      const textDiv = cellNoDaftar.querySelector('.no-daftar-text');
      if (textDiv) textDiv.textContent = data.no_daftar;
      
      const gelBadge = cellNoDaftar.querySelector('.gelombang-badge');
      if (gelBadge) {
        if (data.gelombang) {
          gelBadge.textContent = data.gelombang;
          gelBadge.classList.remove('hidden');
        } else {
          gelBadge.textContent = '';
          gelBadge.classList.add('hidden');
        }
      }
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Intercept eye/detail button click
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.btn-detail');
      if (btn) {
        e.preventDefault();
        const id = btn.getAttribute('data-id');
        openPendaftaranModal(id, 'detail');
      }
    });
    
    // Intercept edit button click
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.btn-edit');
      if (btn) {
        e.preventDefault();
        const id = btn.getAttribute('data-id');
        openPendaftaranModal(id, 'edit');
      }
    });
    
    // ── Delete confirmation modal ──
    let pendingDeleteUrl = null;
    let pendingDeleteRow = null;

    function openDeleteModal(btn) {
      pendingDeleteUrl = btn.getAttribute('data-url');
      pendingDeleteRow = btn.closest('tr');
      document.getElementById('delete-modal-nama').textContent = btn.getAttribute('data-nama');
      document.getElementById('delete-modal-no').textContent   = btn.getAttribute('data-no');

      const modal    = document.getElementById('delete-modal');
      const modalBox = document.getElementById('delete-modal-box');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      requestAnimationFrame(() => {
        modalBox.classList.remove('scale-95', 'opacity-0');
        modalBox.classList.add('scale-100', 'opacity-100');
      });
    }

    function closeDeleteModal() {
      const modal    = document.getElementById('delete-modal');
      const modalBox = document.getElementById('delete-modal-box');
      modalBox.classList.remove('scale-100', 'opacity-100');
      modalBox.classList.add('scale-95', 'opacity-0');
      setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        pendingDeleteUrl = null;
        pendingDeleteRow = null;
      }, 250);
    }

    document.getElementById('delete-modal-cancel').addEventListener('click', closeDeleteModal);
    document.getElementById('delete-modal').addEventListener('click', (e) => {
      if (e.target === document.getElementById('delete-modal')) closeDeleteModal();
    });

    document.getElementById('delete-modal-confirm').addEventListener('click', () => {
      if (!pendingDeleteUrl) return;

      const confirmBtn = document.getElementById('delete-modal-confirm');
      confirmBtn.disabled  = true;
      confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

      fetch(pendingDeleteUrl, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept':       'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(async res => {
        if (res.ok || res.status === 302) {
          // Remove the row from the table
          if (pendingDeleteRow) {
            pendingDeleteRow.style.transition = 'opacity 0.3s';
            pendingDeleteRow.style.opacity    = '0';
            setTimeout(() => pendingDeleteRow.remove(), 300);
          }
          closeDeleteModal();
          // Show a short success toast
          showDeleteToast('Data pendaftar berhasil dihapus.');
        } else {
          // Fallback: jika server return redirect (non-JSON), reload page
          const text = await res.text();
          if (res.status === 419) {
            alert('Sesi CSRF kedaluwarsa. Silakan refresh halaman dan coba lagi.');
          } else {
            // Likely a redirect response – just reload
            window.location.reload();
          }
        }
      })
      .catch(() => {
        // Network error – try form submit as fallback
        window.location.reload();
      })
      .finally(() => {
        confirmBtn.disabled  = false;
        confirmBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Ya, Hapus';
      });
    });

    // Intercept delete button click
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.btn-delete');
      if (btn) {
        e.preventDefault();
        openDeleteModal(btn);
      }
    });

    // Toast helper
    function showDeleteToast(msg) {
      const toast = document.createElement('div');
      toast.className = 'fixed bottom-6 right-6 z-[70] flex items-center gap-3 bg-green-600 text-white text-sm font-semibold px-5 py-3.5 rounded-2xl shadow-xl transition-all duration-500 translate-y-4 opacity-0';
      toast.innerHTML = '<i class="fas fa-check-circle text-base"></i> ' + msg;
      document.body.appendChild(toast);
      requestAnimationFrame(() => {
        toast.classList.remove('translate-y-4', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
      });
      setTimeout(() => {
        toast.classList.add('translate-y-4', 'opacity-0');
        setTimeout(() => toast.remove(), 500);
      }, 3000);
    }
    
    // Modal toggle mode click handler
    document.getElementById('modal-mode-toggle').addEventListener('click', () => {
      if (modalMode === 'detail') {
        setModalMode('edit');
      } else {
        populateEditView(originalData, originalGelombangs);
        setModalMode('detail');
      }
      // Reset scroll to top when switching modes
      const modalBody = document.querySelector('#pendaftaran-modal .overflow-y-auto');
      if (modalBody) modalBody.scrollTop = 0;
    });
    
    // Copy address sync checkboxes
    const copyCheck = document.getElementById('m_copy_address');
    if (copyCheck) {
      copyCheck.addEventListener('change', m_copyAddressFields);
    }
    
    const fields = ['jalan', 'dusun', 'rt', 'rw', 'desa', 'kecamatan', 'kabupaten', 'provinsi'];
    fields.forEach(field => {
      const sourceInput = document.getElementById('m_' + field + '_asal');
      if (sourceInput) {
        sourceInput.addEventListener('input', () => {
          if (document.getElementById('m_copy_address').checked) {
            const targetInput = document.getElementById('m_' + field + '_tinggal');
            if (targetInput) targetInput.value = sourceInput.value;
          }
        });
      }
    });
    
    // Validate jurusan choices inside modal
    ['m_pil1', 'm_pil2', 'm_pil3'].forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        el.addEventListener('change', m_validateJurusan);
      }
    });
    
    // Modal save button AJAX submission
    document.getElementById('modal-save-btn').addEventListener('click', () => {
      const form = document.getElementById('modal-edit-form');
      const saveBtn = document.getElementById('modal-save-btn');
      
      const originalSaveHtml = saveBtn.innerHTML;
      saveBtn.disabled = true;
      saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
      
      clearErrors();
      
      const formData = new FormData(form);
      
      fetch(`/admin/pendaftaran/${currentPendaftaranId}`, {
        method: 'POST', // POST with _method=PUT is required for file uploads in PHP/Laravel via AJAX FormData
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        }
      })
      .then(async res => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalSaveHtml;
        
        if (res.ok) {
          const result = await res.json();
          originalData = result.data;
          
          updateTableRow(currentPendaftaranId, result.data);
          
          alert(result.message || 'Data berhasil disimpan.');
          populateDetailView(result.data);
          setModalMode('detail');
        } else if (res.status === 422) {
          const errs = await res.json();
          
          Object.keys(errs.errors).forEach(field => {
            let input = form.querySelector(`[name="${field}"]`);
            if (!input && (field === 'tgl' || field === 'bulan' || field === 'tahun')) {
              input = form.querySelector('[name="tgl"]');
            }
            if (input) {
              input.classList.add('border-red-400');
              const errorSpan = input.closest('div').querySelector('.error-msg');
              if (errorSpan) {
                errorSpan.textContent = errs.errors[field][0];
                errorSpan.classList.remove('hidden');
              }
            }
          });
          
          const firstError = form.querySelector('.border-red-400');
          if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        } else {
          const text = await res.text();
          console.error(text);
          alert('Gagal memperbarui data. Silakan periksa format file atau log server.');
        }
      })
      .catch(err => {
        console.error(err);
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalSaveHtml;
        alert('Terjadi kesalahan koneksi.');
      });
    });
  });
</script>
@endsection

