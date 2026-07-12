@extends('layouts.admin')
@section('title', 'Produk Teaching Factory')
@section('subtitle', 'Daftar produk dan jasa yang dihasilkan oleh Tefa SMK Muhammadiyah 1 Bantul')

@section('content')
<div>

  @if(session('success'))
    <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-5 py-3">
      <i class="fas fa-check-circle"></i>
      <span class="text-sm font-medium">{{ session('success') }}</span>
    </div>
  @endif

  {{-- Header Actions --}}
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 flex-1 max-w-2xl">
      <div class="relative flex-1">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama produk..."
          class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
      </div>
      <div class="w-full sm:w-48">
        <select name="jurusan_id" onchange="this.form.submit()"
          class="w-full px-3 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm bg-white">
          <option value="">-- Semua Jurusan --</option>
          @foreach($jurusans as $j)
            <option value="{{ $j->id }}" {{ isset($jurusanId) && $jurusanId == $j->id ? 'selected' : '' }}>
              {{ $j->nama_jurusan }}
            </option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-200 transition">Filter</button>
    </form>
    <div class="flex items-center gap-2">
      <a href="{{ route('admin.tefa.setting') }}" class="px-4 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-50 transition flex items-center gap-2">
        <i class="fas fa-cog"></i> Pengaturan
      </a>
      <a href="{{ route('admin.tefa.products.create') }}" class="px-4 py-2.5 bg-primary text-white rounded-xl text-sm font-semibold hover:bg-orange-600 transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Tambah Produk
      </a>
    </div>
  </div>

  {{-- Products Table --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="bg-slate-50 border-b border-slate-100">
            <th class="py-3 px-4 text-left font-semibold text-slate-600 w-12">#</th>
            <th class="py-3 px-4 text-left font-semibold text-slate-600 w-20">Gambar</th>
            <th class="py-3 px-4 text-left font-semibold text-slate-600">Nama Produk</th>
            <th class="py-3 px-4 text-left font-semibold text-slate-600">Program Keahlian</th>
            <th class="py-3 px-4 text-left font-semibold text-slate-600">Harga</th>
            <th class="py-3 px-4 text-center font-semibold text-slate-600">Status</th>
            <th class="py-3 px-4 text-center font-semibold text-slate-600">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($products as $idx => $product)
          <tr class="hover:bg-slate-50/50 transition-colors">
            <td class="py-3 px-4 text-slate-400 text-xs">{{ $products->firstItem() + $idx }}</td>
            <td class="py-3 px-4">
              <div class="w-14 h-14 rounded-lg overflow-hidden border border-slate-100 bg-slate-50">
                @if($product->gambar)
                  <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-full object-cover">
                @else
                  <div class="w-full h-full flex items-center justify-center text-slate-300">
                    <i class="fas fa-box text-xl"></i>
                  </div>
                @endif
              </div>
            </td>
            <td class="py-3 px-4">
              <p class="font-semibold text-slate-800">{{ $product->nama }}</p>
              @if($product->deskripsi)
                <p class="text-xs text-slate-400 mt-0.5 line-clamp-2">{{ Str::limit($product->deskripsi, 80) }}</p>
              @endif
            </td>
            <td class="py-3 px-4">
              @if($product->jurusanContent)
                <span class="px-2 py-1 rounded bg-slate-100 text-slate-800 text-xs font-semibold">
                  {{ $product->jurusanContent->nama_jurusan }}
                </span>
              @else
                <span class="text-slate-400 italic text-xs">Umum</span>
              @endif
            </td>
            <td class="py-3 px-4">
              @if($product->harga)
                <span class="font-semibold text-slate-700">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
              @else
                <span class="text-slate-400 italic text-xs">Hubungi kami</span>
              @endif
            </td>
            <td class="py-3 px-4 text-center">
              @if($product->aktif)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                  <i class="fas fa-check-circle text-xs"></i> Aktif
                </span>
              @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                  <i class="fas fa-eye-slash text-xs"></i> Nonaktif
                </span>
              @endif
            </td>
            <td class="py-3 px-4">
              <div class="flex items-center justify-center gap-2">
                <a href="{{ route('admin.tefa.products.edit', $product) }}"
                  class="p-2 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 transition" title="Edit">
                  <i class="fas fa-edit text-xs"></i>
                </a>
                <form method="POST" action="{{ route('admin.tefa.products.destroy', $product) }}"
                  onsubmit="return confirm('Hapus produk ini?')" class="inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition" title="Hapus">
                    <i class="fas fa-trash text-xs"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="py-12 text-center text-slate-400">
              <i class="fas fa-box-open text-3xl mb-2 block"></i>
              <p>Belum ada produk Tefa. <a href="{{ route('admin.tefa.products.create') }}" class="text-primary underline">Tambah sekarang</a></p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($products->hasPages())
      <div class="px-6 py-4 border-t border-slate-100">
        {{ $products->links() }}
      </div>
    @endif
  </div>

</div>
@endsection

