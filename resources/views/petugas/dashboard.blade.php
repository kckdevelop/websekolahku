@extends('layouts.petugas')
@section('title', 'Dashboard Petugas')
@section('subtitle', 'Daftar pendaftaran siswa untuk diverifikasi')

@section('content')
{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-users text-blue-600 text-lg"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $totalAll }}</p>
      <p class="text-xs text-slate-500">Total Pendaftar</p>
    </div>
  </div>
  <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-11 h-11 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-camera text-green-600 text-lg"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $totalFoto }}</p>
      <p class="text-xs text-slate-500">Sudah Difoto</p>
    </div>
  </div>
  <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-11 h-11 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-clock text-orange-600 text-lg"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $totalBelum }}</p>
      <p class="text-xs text-slate-500">Belum Diverifikasi</p>
    </div>
  </div>
  <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100 flex items-center gap-4">
    <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
      <i class="fas fa-check-double text-emerald-600 text-lg"></i>
    </div>
    <div>
      <p class="text-2xl font-bold text-slate-800">{{ $totalVerif }}</p>
      <p class="text-xs text-slate-500">Sudah Diverifikasi</p>
    </div>
  </div>
</div>

{{-- Statistik PPDB --}}
<div class="mb-8">
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
    <div>
      <h2 class="text-base font-bold text-slate-800 dark:text-white">Statistik Penerimaan Peserta Didik Baru (PPDB)</h2>
      <p class="text-xs text-slate-500 dark:text-slate-400">Ringkasan pendaftaran siswa berdasarkan jurusan dan gelombang</p>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    {{-- Card 1: Statistik Pendaftar --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">
      <div class="bg-slate-500 dark:bg-slate-700 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-white text-sm tracking-wide">Statistik Pendaftar</h3>
        <span class="text-xs bg-slate-600 dark:bg-slate-800 text-slate-200 px-2.5 py-1 rounded-full font-semibold">Total: {{ $totalPendaftar['total'] }}</span>
      </div>
      <div class="p-4 overflow-x-auto flex-grow">
        <table class="w-full text-xs text-left border-collapse border border-slate-200 dark:border-slate-700">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
              <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">Jurusan</th>
              @foreach($gelMap as $gelKey => $gelNama)
                <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">{{ $gelNama }}</th>
              @endforeach
              <th class="py-2.5 px-2 font-semibold text-slate-800 dark:text-slate-200 text-center">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($jurusans as $jur)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center border-r border-slate-200 dark:border-slate-700">{{ $jur === 'TKR' ? 'TKRO' : $jur }}</td>
                @foreach($gelMap as $gelKey => $gelNama)
                  <td class="py-2.5 px-2 text-slate-600 dark:text-slate-400 text-center font-medium border-r border-slate-200 dark:border-slate-700">{{ $dataPendaftar[$jur][$gelKey] ?? 0 }}</td>
                @endforeach
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center bg-slate-50/50 dark:bg-slate-900/50">{{ $dataPendaftar[$jur]['total'] }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/70 font-bold">
              <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700 text-xs">Total Pendaftar</td>
              @foreach($gelMap as $gelKey => $gelNama)
                <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700">{{ $totalPendaftar[$gelKey] ?? 0 }}</td>
              @endforeach
              <td class="py-2.5 px-2 text-primary dark:text-orange-400 text-center bg-slate-100/80 dark:bg-slate-900 font-extrabold">{{ $totalPendaftar['total'] }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- Card 2: Statistik Data Calon Siswa --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">
      <div class="bg-slate-500 dark:bg-slate-700 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-white text-sm tracking-wide">Statistik Data Calon Siswa</h3>
        <span class="text-xs bg-slate-600 dark:bg-slate-800 text-slate-200 px-2.5 py-1 rounded-full font-semibold">Total: {{ $totalCalon['total'] }}</span>
      </div>
      <div class="p-4 overflow-x-auto flex-grow">
        <table class="w-full text-xs text-left border-collapse border border-slate-200 dark:border-slate-700">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
              <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">Jurusan</th>
              @foreach($gelMap as $gelKey => $gelNama)
                <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">{{ $gelNama }}</th>
              @endforeach
              <th class="py-2.5 px-2 font-semibold text-slate-800 dark:text-slate-200 text-center">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($jurusans as $jur)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center border-r border-slate-200 dark:border-slate-700">{{ $jur === 'TKR' ? 'TKRO' : $jur }}</td>
                @foreach($gelMap as $gelKey => $gelNama)
                  <td class="py-2.5 px-2 text-slate-600 dark:text-slate-400 text-center font-medium border-r border-slate-200 dark:border-slate-700">{{ $dataCalon[$jur][$gelKey] ?? 0 }}</td>
                @endforeach
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center bg-slate-50/50 dark:bg-slate-900/50">{{ $dataCalon[$jur]['total'] }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/70 font-bold">
              <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700 text-xs">Total Pencasis</td>
              @foreach($gelMap as $gelKey => $gelNama)
                <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700">{{ $totalCalon[$gelKey] ?? 0 }}</td>
              @endforeach
              <td class="py-2.5 px-2 text-primary dark:text-orange-400 text-center bg-slate-100/80 dark:bg-slate-900 font-extrabold">{{ $totalCalon['total'] }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

    {{-- Card 3: Statistik Siswa Diterima --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col">
      <div class="bg-slate-500 dark:bg-slate-700 px-6 py-4 flex items-center justify-between">
        <h3 class="font-bold text-white text-sm tracking-wide">Statistik Siswa Diterima</h3>
        <span class="text-xs bg-slate-600 dark:bg-slate-800 text-slate-200 px-2.5 py-1 rounded-full font-semibold">Total: {{ $totalDiterima['total'] }}</span>
      </div>
      <div class="p-4 overflow-x-auto flex-grow">
        <table class="w-full text-xs text-left border-collapse border border-slate-200 dark:border-slate-700">
          <thead>
            <tr class="bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-700">
              <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">Jurusan</th>
              @foreach($gelMap as $gelKey => $gelNama)
                <th class="py-2.5 px-2 font-semibold text-slate-700 dark:text-slate-300 text-center border-r border-slate-200 dark:border-slate-700">{{ $gelNama }}</th>
              @endforeach
              <th class="py-2.5 px-2 font-semibold text-slate-800 dark:text-slate-200 text-center">Total</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @foreach($jurusans as $jur)
              <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center border-r border-slate-200 dark:border-slate-700">{{ $jur === 'TKR' ? 'TKRO' : $jur }}</td>
                @foreach($gelMap as $gelKey => $gelNama)
                  <td class="py-2.5 px-2 text-slate-600 dark:text-slate-400 text-center font-medium border-r border-slate-200 dark:border-slate-700">{{ $dataDiterima[$jur][$gelKey] ?? 0 }}</td>
                @endforeach
                <td class="py-2.5 px-2 font-bold text-slate-800 dark:text-slate-200 text-center bg-slate-50/50 dark:bg-slate-900/50">{{ $dataDiterima[$jur]['total'] }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr class="border-t border-slate-200 dark:border-slate-700 bg-slate-50/70 dark:bg-slate-900/70 font-bold">
              <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700 text-xs">Total Penerima</td>
              @foreach($gelMap as $gelKey => $gelNama)
                <td class="py-2.5 px-2 text-slate-850 dark:text-slate-100 text-center border-r border-slate-200 dark:border-slate-700">{{ $totalDiterima[$gelKey] ?? 0 }}</td>
              @endforeach
              <td class="py-2.5 px-2 text-primary dark:text-orange-400 text-center bg-slate-100/80 dark:bg-slate-900 font-extrabold">{{ $totalDiterima['total'] }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Filter + Search --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6">
  <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
      <i class="fas fa-list text-blue-500"></i> Data Pendaftaran
    </h2>
    <form method="GET" action="{{ route('petugas.dashboard') }}" class="flex gap-2 flex-wrap">
      {{-- Search --}}
      <div class="relative">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / no daftar..."
          class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 w-52">
        <i class="fas fa-search absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
      </div>
      {{-- Filter --}}
      <select name="filter" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <option value="">Semua Status</option>
        <option value="no_foto"     {{ request('filter') === 'no_foto'     ? 'selected' : '' }}>Belum Difoto</option>
        <option value="has_foto"    {{ request('filter') === 'has_foto'    ? 'selected' : '' }}>Sudah Difoto</option>
        <option value="belum_verif" {{ request('filter') === 'belum_verif' ? 'selected' : '' }}>Belum Verifikasi</option>
        <option value="sudah_verif" {{ request('filter') === 'sudah_verif' ? 'selected' : '' }}>Sudah Verifikasi</option>
      </select>
      {{-- Paging size --}}
      <select name="per_page" onchange="this.form.submit()" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-slate-600">
        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10 data</option>
        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 data</option>
        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50 data</option>
        <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100 data</option>
      </select>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition font-medium">
        Cari
      </button>
      @if(request('search') || request('filter') || request('per_page'))
      <a href="{{ route('petugas.dashboard') }}" class="px-4 py-2 bg-slate-100 text-slate-600 text-sm rounded-xl hover:bg-slate-200 transition font-medium">
        Reset
      </a>
      @endif
    </form>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 border-b border-slate-100">
        <tr>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">#</th>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">No. Daftar</th>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">Nama Lengkap</th>
          <th class="text-left py-3 px-4 font-semibold text-slate-600 text-xs">Gelombang</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Foto</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Berkas</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Verifikasi</th>
          <th class="text-center py-3 px-4 font-semibold text-slate-600 text-xs">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-50">
        @forelse($pendaftarans as $p)
        <tr class="hover:bg-slate-50/50 transition-colors">
          <td class="py-3 px-4 text-slate-400 text-xs">{{ $pendaftarans->firstItem() + $loop->index }}</td>
          <td class="py-3 px-4">
            <span class="font-mono font-bold text-blue-700 text-xs bg-blue-50 px-2 py-0.5 rounded">
              {{ $p->no_daftar }}
            </span>
          </td>
          <td class="py-3 px-4">
            <p class="font-semibold text-slate-800 text-sm">{{ $p->nama_lengkap }}</p>
            <p class="text-xs text-slate-400">{{ $p->asal_sekolah }}</p>
          </td>
          <td class="py-3 px-4 text-xs text-slate-500">{{ $p->gelombang ?? '-' }}</td>
          <td class="py-3 px-4 text-center">
            @if($p->foto_siswa)
              <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-full">
                <i class="fas fa-check text-[10px]"></i> Ada
              </span>
            @else
              <span class="inline-flex items-center gap-1 text-xs font-medium text-red-600 bg-red-50 px-2 py-0.5 rounded-full">
                <i class="fas fa-times text-[10px]"></i> Belum
              </span>
            @endif
          </td>
          <td class="py-3 px-4 text-center">
            @php $berkas = $p->berkas_lengkap ?? []; @endphp
            @if(count($berkas) >= 4)
              <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-full">Lengkap</span>
            @elseif(count($berkas) > 0)
              <span class="text-xs font-medium text-orange-700 bg-orange-50 px-2 py-0.5 rounded-full">Sebagian</span>
            @else
              <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-0.5 rounded-full">Belum</span>
            @endif
          </td>
          <td class="py-3 px-4 text-center">
            @if($p->verified_at)
              <span class="text-xs font-medium text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">
                <i class="fas fa-check-circle text-[10px]"></i> {{ $p->verified_at->format('d/m') }}
              </span>
            @else
              <span class="text-xs font-medium text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">Pending</span>
            @endif
          </td>
          <td class="py-3 px-4 text-center">
            <div class="flex items-center justify-center gap-1">
              <a href="{{ route('petugas.show', $p) }}"
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700 transition font-medium">
                <i class="fas fa-edit text-[10px]"></i> Proses
              </a>
              <a href="{{ route('petugas.kartu', $p) }}" target="_blank"
                 class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-700 text-white text-xs rounded-lg hover:bg-slate-800 transition font-medium">
                <i class="fas fa-print text-[10px]"></i> Kartu
              </a>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="py-12 text-center text-slate-400">
            <i class="fas fa-inbox text-3xl mb-2 block"></i>
            Tidak ada data pendaftaran yang ditemukan.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($pendaftarans->hasPages())
  <div class="px-4 py-3 border-t border-slate-100">
    {{ $pendaftarans->links() }}
  </div>
  @endif
</div>
@endsection
