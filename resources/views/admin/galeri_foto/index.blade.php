@extends('layouts.admin')
@section('title', 'Galeri Foto')
@section('subtitle', 'Kelola tautan Google Drive dan pratinjau album foto kegiatan sekolah')

@section('styles')
<style>
  .card-gradient {
    background: linear-gradient(135deg, #fff9f0 0%, #ffffff 100%);
    border: 2px solid #fde6d0;
    box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.15);
    transition: all 0.3s ease;
  }

  .card-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 25px -10px rgba(249, 115, 22, 0.25);
    border-color: #f97316;
  }
</style>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  
  {{-- Form Edit --}}
  <div class="lg:col-span-1">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center text-primary"><i class="fab fa-google-drive"></i></div>
        <h2 class="font-semibold text-slate-800">Pengaturan Album</h2>
      </div>
      
      <form method="POST" action="{{ route('admin.galeri_foto.update', $galeriFoto) }}" class="p-6 space-y-5">
        @csrf
        @method('PUT')

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Judul Album <span class="text-red-500">*</span></label>
          <input type="text" name="judul" value="{{ old('judul', $galeriFoto->judul) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm">
          @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Link / ID Folder Google Drive <span class="text-red-500">*</span></label>
          <input type="text" name="folder_id" value="{{ old('folder_id', $galeriFoto->folder_id) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm"
            placeholder="Masukkan link sharing atau ID folder...">
          <p class="text-xs text-slate-400 mt-1.5"><i class="fas fa-info-circle mr-0.5"></i> Anda dapat menempelkan link Google Drive lengkap, kami akan mengekstrak ID-nya otomatis.</p>
          @error('folder_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi Album</label>
          <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm resize-none" placeholder="Tulis deskripsi singkat...">{{ old('deskripsi', $galeriFoto->deskripsi) }}</textarea>
          @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-primary hover:bg-secondary text-white font-semibold py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Simpan Pengaturan
        </button>
      </form>
    </div>
  </div>

  {{-- Preview Tampilan --}}
  <div class="lg:col-span-2">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-6">
      
      <!-- Pratinjau Header -->
      <div class="flex items-center justify-between pb-4 border-b border-slate-100">
        <div>
          <h3 class="font-bold text-lg text-slate-800">Pratinjau Tampilan</h3>
          <p class="text-xs text-slate-400">Tampilan galeri foto di halaman publik website sekolah</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
          <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Preview Mode
        </span>
      </div>

      <!-- Google Drive Folder Section (Copy from public template) -->
      <div class="space-y-6">
        
        <!-- Header & Toolbar -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <!-- Judul Section -->
          <div class="text-center md:text-left">
            <h2 class="text-2xl font-bold text-slate-800 mb-1" id="preview-judul">{{ $galeriFoto->judul }}</h2>
            <div class="w-20 h-1 bg-primary rounded-full md:mx-0 mx-auto"></div>
          </div>

          <!-- Tombol Fungsi -->
          <div class="flex items-center space-x-3">
            <!-- Toggle View (Grid / List) -->
            <div class="flex bg-slate-100 rounded-lg p-1 border border-slate-200" role="group">
              <button id="btn-grid" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all bg-primary text-white shadow-sm focus:outline-none">
                <i class="fas fa-th-large mr-1"></i> Grid
              </button>
              <button id="btn-list" class="px-3 py-1.5 rounded-md text-xs font-medium transition-all text-slate-600 hover:bg-slate-200 focus:outline-none">
                <i class="fas fa-list mr-1"></i> List
              </button>
            </div>

            <!-- Tombol Share -->
            <button id="btn-share" class="px-3 py-1.5 bg-slate-600 hover:bg-slate-700 text-white rounded-lg text-xs font-medium transition-all shadow-sm focus:outline-none flex items-center">
              <i class="fas fa-share-alt mr-1.5"></i> Share
            </button>
          </div>
        </div>

        <!-- Iframe Container -->
        <div class="card-gradient rounded-2xl p-2 overflow-hidden">
          <div class="relative w-full h-[50vh] rounded-xl overflow-hidden bg-slate-100">
            <iframe 
              id="gdrive-frame"
              src="https://drive.google.com/embeddedfolderview?id={{ $galeriFoto->folder_id }}#grid" 
              width="100%" 
              height="100%" 
              frameborder="0"
              class="absolute inset-0 w-full h-full border-0"
              allowfullscreen
            >
              Browser Anda tidak mendukung iframe.
            </iframe>
          </div>
        </div>

        <!-- Info Tambahan -->
        <div class="text-center">
          <p class="text-xs text-slate-400">
            <i class="fas fa-info-circle mr-1"></i> 
            Pastikan akses folder Google Drive diatur ke "Siapa saja yang memiliki link" agar dapat ditampilkan.
          </p>
        </div>

      </div>

    </div>
  </div>

</div>
@endsection

@section('scripts')
<script>
  const folderId = '{{ $galeriFoto->folder_id }}';
  const iframe = document.getElementById('gdrive-frame');
  const btnGrid = document.getElementById('btn-grid');
  const btnList = document.getElementById('btn-list');
  const btnShare = document.getElementById('btn-share');

  function setActiveView(activeBtn, inactiveBtn) {
    activeBtn.classList.add('bg-primary', 'text-white', 'shadow-sm');
    activeBtn.classList.remove('text-slate-600', 'hover:bg-slate-200');
    
    inactiveBtn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
    inactiveBtn.classList.add('text-slate-600', 'hover:bg-slate-200');
  }

  btnGrid?.addEventListener('click', () => {
    if (iframe) {
      iframe.src = `https://drive.google.com/embeddedfolderview?id=${folderId}#grid`;
      setActiveView(btnGrid, btnList);
    }
  });

  btnList?.addEventListener('click', () => {
    if (iframe) {
      iframe.src = `https://drive.google.com/embeddedfolderview?id=${folderId}#list`;
      setActiveView(btnList, btnGrid);
    }
  });

  btnShare?.addEventListener('click', () => {
    const shareLink = `https://drive.google.com/drive/folders/${folderId}?usp=sharing`;
    if (navigator.clipboard) {
      navigator.clipboard.writeText(shareLink).then(() => {
        const originalText = btnShare.innerHTML;
        btnShare.innerHTML = '<i class="fas fa-check mr-1.5"></i> Disalin!';
        btnShare.classList.add('bg-green-600');
        setTimeout(() => {
          btnShare.innerHTML = originalText;
          btnShare.classList.remove('bg-green-600');
        }, 2000);
      }).catch(err => {
        alert('Gagal menyalin link: ' + shareLink);
      });
    } else {
      prompt("Salin link ini (Ctrl+C):", shareLink);
    }
  });
</script>
@endsection
