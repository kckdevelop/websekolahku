@extends('layouts.admin')
@section('title', 'Petugas Pewawancara')
@section('subtitle', 'Manajemen daftar petugas yang bertugas sebagai pewawancara')

@section('content')
<div class="space-y-6">

  @if(session('success'))
  <div class="p-3 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center gap-2">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
  </div>
  @endif
  @if(session('error'))
  <div class="p-3 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-2">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
  </div>
  @endif

  {{-- Stats Strip --}}
  <div class="grid grid-cols-3 gap-4">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
        <i class="fas fa-users text-purple-600"></i>
      </div>
      <div>
        <div class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Total Petugas</div>
        <div class="text-2xl font-bold text-slate-800">{{ $petugasList->count() }}</div>
      </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
        <i class="fas fa-user-check text-green-600"></i>
      </div>
      <div>
        <div class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Aktif</div>
        <div class="text-2xl font-bold text-emerald-600">{{ $petugasList->where('aktif', true)->count() }}</div>
      </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
      <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center flex-shrink-0">
        <i class="fas fa-user-slash text-slate-500"></i>
      </div>
      <div>
        <div class="text-xxs font-bold text-slate-400 uppercase tracking-wider">Non-aktif</div>
        <div class="text-2xl font-bold text-slate-500">{{ $petugasList->where('aktif', false)->count() }}</div>
      </div>
    </div>
  </div>

  {{-- Main Layout: 2 Kolom --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kiri: Form Tambah --}}
    <div class="lg:col-span-1">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
        <div class="border-b border-slate-100 px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 flex items-center gap-2">
          <i class="fas fa-user-plus text-primary"></i>
          <h3 class="font-bold text-slate-800 text-sm">Tambah Petugas Pewawancara</h3>
        </div>
        <form method="POST" action="{{ route('admin.petugas-wawancara.store') }}" class="p-6 space-y-4">
          @csrf
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Nama Lengkap <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" required
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm @error('nama') border-red-400 @enderror"
              placeholder="Nama pewawancara">
            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wide">Jabatan</label>
            <input type="text" name="jabatan" value="{{ old('jabatan') }}"
              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm"
              placeholder="Contoh: Guru BK / Waka Kesiswaan">
          </div>
          <div class="flex items-center gap-3 pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none">
              <input type="checkbox" name="aktif" value="1" checked
                class="w-4 h-4 rounded accent-primary">
              <span class="text-sm text-slate-700">Aktif</span>
            </label>
          </div>
          <button type="submit"
            class="w-full inline-flex items-center justify-center gap-2 bg-primary hover:bg-secondary text-white font-bold px-6 py-3 rounded-xl transition text-sm shadow-md shadow-orange-200">
            <i class="fas fa-plus"></i> Tambah Petugas
          </button>
        </form>
      </div>
    </div>

    {{-- Kanan: Daftar Petugas --}}
    <div class="lg:col-span-2">
      <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between bg-slate-50">
          <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
            <i class="fas fa-users text-primary"></i> Daftar Petugas Pewawancara
          </h3>
          <span class="text-xs text-slate-400 bg-white border border-slate-200 px-3 py-1 rounded-full font-semibold">
            {{ $petugasList->count() }} petugas
          </span>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
          <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
              <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Nama Petugas</th>
                <th class="px-6 py-3">Jabatan</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
              @forelse($petugasList as $i => $petugas)
              <tr class="hover:bg-slate-50/60 transition-colors">
                <td class="px-6 py-4 text-slate-400 font-mono">{{ $i + 1 }}</td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0
                      {{ $petugas->aktif ? 'bg-purple-100' : 'bg-slate-100' }}">
                      <i class="fas fa-user-tie text-sm {{ $petugas->aktif ? 'text-purple-600' : 'text-slate-400' }}"></i>
                    </div>
                    <span class="font-semibold text-slate-800">{{ $petugas->nama }}</span>
                  </div>
                </td>
                <td class="px-6 py-4 text-slate-500 text-xs">{{ $petugas->jabatan ?? '-' }}</td>
                <td class="px-6 py-4 text-center">
                  @if($petugas->aktif)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                      <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                  @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                      <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Non-aktif
                    </span>
                  @endif
                </td>
                <td class="px-6 py-4 text-center">
                  <div class="flex items-center justify-center gap-2">
                    <button onclick="toggleEditPetugas({{ $petugas->id }})"
                      class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-xs font-bold transition">
                      <i class="fas fa-edit"></i> Edit
                    </button>
                    <form method="POST" action="{{ route('admin.petugas-wawancara.destroy', $petugas) }}"
                      onsubmit="return confirm('Hapus petugas {{ $petugas->nama }}?')">
                      @csrf @method('DELETE')
                      <button type="submit"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-bold transition">
                        <i class="fas fa-trash"></i> Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>

              {{-- Edit Form Row --}}
              <tr id="edit-petugas-{{ $petugas->id }}" class="hidden bg-amber-50/30">
                <td colspan="5" class="px-6 py-4">
                  <form method="POST" action="{{ route('admin.petugas-wawancara.update', $petugas) }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
                    @csrf @method('PUT')
                    <div class="md:col-span-1">
                      <label class="block text-xs font-bold text-slate-600 mb-1">Nama</label>
                      <input type="text" name="nama" value="{{ $petugas->nama }}" required
                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div class="md:col-span-1">
                      <label class="block text-xs font-bold text-slate-600 mb-1">Jabatan</label>
                      <input type="text" name="jabatan" value="{{ $petugas->jabatan }}"
                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    </div>
                    <div class="flex items-center gap-3 mt-4">
                      <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="aktif" value="1" {{ $petugas->aktif ? 'checked' : '' }}
                          class="w-4 h-4 rounded accent-primary">
                        <span class="text-xs text-slate-700 font-medium">Aktif</span>
                      </label>
                    </div>
                    <div class="flex gap-2">
                      <button type="submit"
                        class="flex-1 px-4 py-2 bg-primary text-white text-xs rounded-lg hover:bg-secondary transition font-bold">
                        <i class="fas fa-save mr-1"></i> Simpan
                      </button>
                      <button type="button" onclick="toggleEditPetugas({{ $petugas->id }})"
                        class="px-4 py-2 bg-slate-200 text-slate-700 text-xs rounded-lg hover:bg-slate-300 transition font-bold">
                        Batal
                      </button>
                    </div>
                  </form>
                </td>
              </tr>

              @empty
              <tr>
                <td colspan="5" class="py-16 text-center text-slate-400">
                  <i class="fas fa-user-slash text-4xl mb-3 block"></i>
                  <p class="text-sm font-medium">Belum ada petugas pewawancara</p>
                  <p class="text-xs mt-1">Tambahkan menggunakan form di sebelah kiri</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>

</div>
@endsection

@section('scripts')
<script>
  function toggleEditPetugas(id) {
    const el = document.getElementById('edit-petugas-' + id);
    el.classList.toggle('hidden');
  }
</script>
@endsection
