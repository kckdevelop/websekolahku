@extends('layouts.petugas')
@section('title', 'Data Pendaftar')
@section('subtitle', 'Kelola data calon siswa baru, berkas, dan verifikasi')

@section('content')
{{-- Filter + Search --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 mb-6">
  <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
    <div class="flex items-center gap-3">
      <h2 class="font-bold text-slate-800 text-sm flex items-center gap-2">
        <i class="fas fa-list text-blue-500"></i> Daftar Pendaftar
      </h2>
      <a href="{{ route('petugas.create') }}" class="px-3 py-1.5 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition font-semibold flex items-center gap-1">
        <i class="fas fa-plus"></i> Tambah Pendaftar
      </a>
    </div>
    <div class="flex gap-2 flex-wrap items-center">
      {{-- Search --}}
      <div class="relative">
        <input type="text" id="ajax-search" name="search" value="{{ request('search') }}" placeholder="Cari nama / no daftar..."
          class="pl-8 pr-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300 w-52">
        <i class="fas fa-search absolute left-2.5 top-2.5 text-slate-400 text-xs"></i>
      </div>
      {{-- Filter --}}
      <select id="ajax-filter" name="filter" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
        <option value="">Semua Status</option>
        <option value="no_foto"     {{ request('filter') === 'no_foto'     ? 'selected' : '' }}>Belum Difoto</option>
        <option value="has_foto"    {{ request('filter') === 'has_foto'    ? 'selected' : '' }}>Sudah Difoto</option>
        <option value="belum_verif" {{ request('filter') === 'belum_verif' ? 'selected' : '' }}>Belum Verifikasi</option>
        <option value="sudah_verif" {{ request('filter') === 'sudah_verif' ? 'selected' : '' }}>Sudah Verifikasi</option>
      </select>
      {{-- Paging size --}}
      <select id="ajax-per-page" name="per_page" class="text-sm border border-slate-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300 bg-white text-slate-600">
        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>10 data</option>
        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20 data</option>
        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>50 data</option>
        <option value="100" {{ request('per_page', 20) == 100 ? 'selected' : '' }}>100 data</option>
      </select>
      <button id="ajax-reset" class="px-4 py-2 bg-slate-100 text-slate-600 text-sm rounded-xl hover:bg-slate-200 transition font-medium hidden">
        Reset
      </button>
    </div>
  </div>

  <div id="table-wrapper" style="overflow-x: hidden;">
    @include('petugas.pendaftar.table')
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
      <p class="text-xs text-red-500 bg-red-50 border border-red-100 rounded-xl px-3 py-2 mb-6 text-left">
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
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('ajax-search');
    const filterSelect = document.getElementById('ajax-filter');
    const perPageSelect = document.getElementById('ajax-per-page');
    const resetBtn = document.getElementById('ajax-reset');
    const tableWrapper = document.getElementById('table-wrapper');

    let debounceTimer;

    function checkResetBtn() {
      if (searchInput.value || filterSelect.value || perPageSelect.value != 20) {
        resetBtn.classList.remove('hidden');
      } else {
        resetBtn.classList.add('hidden');
      }
    }

    function fetchPendaftar(url = "{{ route('petugas.pendaftar') }}") {
      const search = searchInput.value;
      const filter = filterSelect.value;
      const perPage = perPageSelect.value;

      // Build Query String
      const requestUrl = new URL(url);
      if (search) requestUrl.searchParams.set('search', search);
      if (filter) requestUrl.searchParams.set('filter', filter);
      if (perPage) requestUrl.searchParams.set('per_page', perPage);

      // Add loading state opacity
      tableWrapper.style.opacity = '0.5';

      fetch(requestUrl, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.text())
      .then(html => {
        tableWrapper.innerHTML = html;
        tableWrapper.style.opacity = '1';
        checkResetBtn();
        bindPagination();
      })
      .catch(error => {
        console.error('Error fetching pendaftar:', error);
        tableWrapper.style.opacity = '1';
      });
    }

    function bindPagination() {
      // Hijack pagination link clicks to fetch via AJAX
      const paginationLinks = tableWrapper.querySelectorAll('.pagination-container a, .pagination a');
      paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          fetchPendaftar(this.href);
        });
      });
    }

    // Input Search Debounce
    searchInput.addEventListener('input', function() {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(() => {
        fetchPendaftar();
      }, 300); // 300ms delay
    });

    // Dropdown changes
    filterSelect.addEventListener('change', () => fetchPendaftar());
    perPageSelect.addEventListener('change', () => fetchPendaftar());

    // Reset button
    resetBtn.addEventListener('click', function() {
      searchInput.value = '';
      filterSelect.value = '';
      perPageSelect.value = '20';
      fetchPendaftar();
    });

    // Initial binding
    bindPagination();
    checkResetBtn();

    // ── Delete Confirmation Modal ──
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

      const csrfMeta = document.querySelector('meta[name="csrf-token"]');
      if (!csrfMeta) {
        alert('CSRF token tidak ditemukan. Silakan refresh halaman dan coba lagi.');
        confirmBtn.disabled  = false;
        confirmBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Ya, Hapus';
        return;
      }

      fetch(pendingDeleteUrl, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfMeta.getAttribute('content'),
          'Accept':       'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(async res => {
        const contentType = res.headers.get('content-type') || '';
        const isJson = contentType.includes('application/json');

        if (isJson) {
          const data = await res.json();
          if (data.success) {
            // Animate row removal
            if (pendingDeleteRow) {
              pendingDeleteRow.style.transition = 'opacity 0.3s, transform 0.3s';
              pendingDeleteRow.style.opacity    = '0';
              pendingDeleteRow.style.transform  = 'translateX(-10px)';
              setTimeout(() => pendingDeleteRow.remove(), 300);
            }
            closeDeleteModal();
            showDeleteToast(data.message || 'Data pendaftar berhasil dihapus.');
          } else {
            alert(data.message || 'Gagal menghapus data. Silakan coba lagi.');
            closeDeleteModal();
          }
        } else if (res.status === 419) {
          alert('Sesi CSRF kedaluwarsa. Silakan refresh halaman dan coba lagi.');
          closeDeleteModal();
        } else {
          // Response bukan JSON (mungkin redirect HTML) – reload halaman
          window.location.reload();
        }
      })
      .catch(() => {
        window.location.reload();
      })
      .finally(() => {
        confirmBtn.disabled  = false;
        confirmBtn.innerHTML = '<i class="fas fa-trash-alt"></i> Ya, Hapus';
      });
    });

    // Intercept btn-delete click (including dynamically loaded table rows via AJAX)
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
  });
</script>
@endpush
