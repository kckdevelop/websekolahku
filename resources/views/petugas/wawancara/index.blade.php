@extends('layouts.petugas')
@section('title', 'Wawancara & Gaya Belajar')
@section('subtitle', 'Uji keagamaan, kepribadian, gaya belajar (Visual, Auditori, Kinestetik), serta minat bakat calon siswa')

@section('content')
<div class="space-y-6">

  {{-- Stats Row --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase block tracking-wider">Total Pendaftar</span>
        <span class="text-2xl font-bold text-slate-800 block mt-1">{{ $totalAll }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase block tracking-wider">Belum Uji / Wawancara</span>
        <span class="text-2xl font-bold text-amber-600 block mt-1">{{ $totalBelum }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl animate-pulse">
        <i class="fas fa-comments animate-bounce"></i>
      </div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex items-center justify-between">
      <div>
        <span class="text-xxs font-bold text-slate-400 uppercase block tracking-wider">Sudah Uji / Wawancara</span>
        <span class="text-2xl font-bold text-emerald-600 block mt-1">{{ $totalSudah }}</span>
      </div>
      <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
        <i class="fas fa-check-circle"></i>
      </div>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Filter & Search Bar --}}
    <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
      <div class="flex items-center gap-2">
        <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
          <i class="fas fa-comments text-purple-650"></i> Data Wawancara & Gaya Belajar
        </h2>
      </div>
      <div class="flex gap-2 flex-wrap items-center">
        {{-- Filter Status --}}
        <select id="ajax-filter" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-slate-600">
          <option value="">Semua Status</option>
          <option value="belum" {{ request('filter') === 'belum' ? 'selected' : '' }}>Belum Wawancara</option>
          <option value="sudah" {{ request('filter') === 'sudah' ? 'selected' : '' }}>Sudah Wawancara</option>
        </select>
        {{-- Search --}}
        <div class="relative">
          <input type="text" id="ajax-search" value="{{ request('search') }}" placeholder="Cari Nama / No Daftar..."
                 class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 w-52">
          <i class="fas fa-search absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
        </div>
        {{-- Per Page --}}
        <select id="ajax-per-page" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-slate-600">
          <option value="10"  {{ request('per_page', 20) == 10  ? 'selected' : '' }}>10 data</option>
          <option value="20"  {{ request('per_page', 20) == 20  ? 'selected' : '' }}>20 data</option>
          <option value="50"  {{ request('per_page', 20) == 50  ? 'selected' : '' }}>50 data</option>
          <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100 data</option>
        </select>
        <button id="ajax-reset" class="px-4 py-2 bg-slate-100 text-slate-600 text-sm rounded-xl hover:bg-slate-200 transition font-medium hidden">
          Reset
        </button>
      </div>
    </div>

    {{-- Table Wrapper (AJAX target) --}}
    <div id="table-wrapper">
      @include('petugas.wawancara.table')
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput  = document.getElementById('ajax-search');
    const filterSelect = document.getElementById('ajax-filter');
    const perPageSelect = document.getElementById('ajax-per-page');
    const resetBtn     = document.getElementById('ajax-reset');
    const tableWrapper = document.getElementById('table-wrapper');

    let debounceTimer;

    function checkResetBtn() {
      if (searchInput.value || filterSelect.value || perPageSelect.value != 20) {
        resetBtn.classList.remove('hidden');
      } else {
        resetBtn.classList.add('hidden');
      }
    }

    function fetchTable(url = "{{ route('petugas.wawancara.dashboard') }}") {
      const search  = searchInput.value;
      const filter  = filterSelect.value;
      const perPage = perPageSelect.value;

      const requestUrl = new URL(url);
      if (search)  requestUrl.searchParams.set('search', search);
      if (filter)  requestUrl.searchParams.set('filter', filter);
      if (perPage) requestUrl.searchParams.set('per_page', perPage);

      tableWrapper.style.opacity = '0.5';

      fetch(requestUrl, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(r => r.text())
      .then(html => {
        tableWrapper.innerHTML = html;
        tableWrapper.style.opacity = '1';
        checkResetBtn();
        bindPagination();
      })
      .catch(() => { tableWrapper.style.opacity = '1'; });
    }

    function bindPagination() {
      const links = tableWrapper.querySelectorAll('.pagination-container a, .pagination a');
      links.forEach(link => {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          fetchTable(this.href);
        });
      });
    }

    // Events
    searchInput.addEventListener('input', function () {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => fetchTable(), 300);
    });
    filterSelect.addEventListener('change',  () => fetchTable());
    perPageSelect.addEventListener('change', () => fetchTable());
    resetBtn.addEventListener('click', function () {
      searchInput.value    = '';
      filterSelect.value   = '';
      perPageSelect.value  = '20';
      fetchTable();
    });

    // Init
    bindPagination();
    checkResetBtn();
  });
</script>
@endpush
