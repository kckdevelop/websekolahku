@extends('layouts.admin')
@section('title', 'Kelola User')
@section('subtitle', 'Manajemen akun admin dan petugas pendaftaran')

@section('content')
<div class="max-w-5xl space-y-6">

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

  {{-- Tambah User --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center gap-2">
      <i class="fas fa-user-plus text-primary"></i>
      <h3 class="font-bold text-slate-800 text-sm">Tambah Akun Baru</h3>
    </div>
    <form method="POST" action="{{ route('admin.users.store') }}" class="p-6">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
          <input type="text" name="name" value="{{ old('name') }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm @error('name') border-red-400 @enderror"
            placeholder="Nama petugas / admin">
          @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Email <span class="text-red-500">*</span></label>
          <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm @error('email') border-red-400 @enderror"
            placeholder="email@sekolah.sch.id">
          @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
          <input type="password" name="password" required
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm @error('password') border-red-400 @enderror"
            placeholder="Min. 6 karakter">
          @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Role / Jabatan <span class="text-red-500">*</span></label>
          <select name="role" required
            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none text-sm">
            <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas Pendaftaran</option>
            <option value="petugas_kesehatan" {{ old('role') === 'petugas_kesehatan' ? 'selected' : '' }}>Petugas Kesehatan (UKS)</option>
            <option value="petugas_wawancara" {{ old('role') === 'petugas_wawancara' ? 'selected' : '' }}>Petugas Wawancara / Gaya Belajar</option>
            <option value="petugas_pembayaran" {{ old('role') === 'petugas_pembayaran' ? 'selected' : '' }}>Petugas Pembayaran (Keuangan)</option>
            <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin (Akses Penuh)</option>
          </select>
        </div>
      </div>
      <button type="submit"
        class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-2.5 rounded-xl transition text-sm">
        <i class="fas fa-plus"></i> Tambah Akun
      </button>
    </form>
  </div>

  {{-- Daftar User --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="border-b border-slate-100 px-6 py-4 bg-slate-50 flex items-center justify-between">
      <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2">
        <i class="fas fa-users text-primary"></i> Daftar Semua Akun
      </h3>
      <span class="text-xs text-slate-400">{{ $users->count() }} akun terdaftar</span>
    </div>

    <div class="divide-y divide-slate-50">
      @foreach($users as $user)
      <div class="p-5 hover:bg-slate-50/50 transition-colors" x-data="{ edit: false }">
        <div class="flex items-center justify-between gap-4">
          {{-- Info User --}}
          <div class="flex items-center gap-4">
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
              {{ $user->role === 'admin' ? 'bg-orange-100' : 'bg-blue-100' }}">
              <i class="fas {{ $user->role === 'admin' ? 'fa-shield-alt text-orange-600' : 'fa-clipboard-check text-blue-600' }} text-sm"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <p class="font-semibold text-slate-800 text-sm">{{ $user->name }}</p>
                @if($user->id === auth()->id())
                  <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">Anda</span>
                @endif
              </div>
              <p class="text-xs text-slate-500">{{ $user->email }}</p>
            </div>
          </div>

          {{-- Role Badge + Actions --}}
          <div class="flex items-center gap-3">
            <span class="text-xs font-semibold px-3 py-1 rounded-full
              @if($user->role === 'admin') bg-orange-100 text-orange-700
              @elseif($user->role === 'petugas_kesehatan') bg-emerald-100 text-emerald-700
              @elseif($user->role === 'petugas_wawancara') bg-purple-100 text-purple-700
              @elseif($user->role === 'petugas_pembayaran') bg-rose-100 text-rose-700
              @else bg-blue-100 text-blue-700
              @endif">
              @if($user->role === 'admin') ⭐ Admin
              @elseif($user->role === 'petugas_kesehatan') 🩺 Kesehatan (UKS)
              @elseif($user->role === 'petugas_wawancara') 🗣️ Wawancara / Gaya Belajar
              @elseif($user->role === 'petugas_pembayaran') 💰 Pembayaran
              @else 📋 Petugas
              @endif
            </span>
            <button onclick="toggleEdit({{ $user->id }})"
              class="text-xs px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition font-medium">
              <i class="fas fa-edit mr-1"></i> Edit
            </button>
            @if($user->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
              onsubmit="return confirm('Hapus akun {{ $user->name }}? Tindakan ini tidak bisa dibatalkan.')">
              @csrf @method('DELETE')
              <button type="submit"
                class="text-xs px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition font-medium">
                <i class="fas fa-trash mr-1"></i> Hapus
              </button>
            </form>
            @endif
          </div>
        </div>

        {{-- Edit Form (hidden by default) --}}
        <div id="edit-{{ $user->id }}" class="hidden mt-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
          <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
              <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}" required
                  class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
              </div>
              <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required
                  class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
              </div>
              <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Password Baru <span class="text-slate-400">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password"
                  class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30"
                  placeholder="Min. 6 karakter">
              </div>
              <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Role</label>
                <select name="role"
                  class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                  <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas Pendaftaran</option>
                  <option value="petugas_kesehatan" {{ $user->role === 'petugas_kesehatan' ? 'selected' : '' }}>Petugas Kesehatan (UKS)</option>
                  <option value="petugas_wawancara" {{ $user->role === 'petugas_wawancara' ? 'selected' : '' }}>Petugas Wawancara / Gaya Belajar</option>
                  <option value="petugas_pembayaran" {{ $user->role === 'petugas_pembayaran' ? 'selected' : '' }}>Petugas Pembayaran (Keuangan)</option>
                  <option value="admin"   {{ $user->role === 'admin'   ? 'selected' : '' }}>Admin (Akses Penuh)</option>
                </select>
              </div>
            </div>
            <div class="flex gap-2">
              <button type="submit"
                class="px-4 py-2 bg-primary text-white text-xs rounded-lg hover:bg-secondary transition font-semibold">
                <i class="fas fa-save mr-1"></i> Simpan
              </button>
              <button type="button" onclick="toggleEdit({{ $user->id }})"
                class="px-4 py-2 bg-slate-200 text-slate-700 text-xs rounded-lg hover:bg-slate-300 transition font-semibold">
                Batal
              </button>
            </div>
          </form>
        </div>
      </div>
      @endforeach
    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  function toggleEdit(id) {
    const el = document.getElementById('edit-' + id);
    el.classList.toggle('hidden');
  }
</script>
@endsection
