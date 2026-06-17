@extends('layouts.admin')
@section('title', 'Ubah Sambutan Kepala Sekolah')
@section('subtitle', 'Ubah data profil dan teks sambutan kepala sekolah di halaman beranda')

@section('content')
<div class="max-w-4xl">
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="{{ route('admin.sambutan.update') }}" enctype="multipart/form-data" class="p-6 space-y-6">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nama Kepala Sekolah --}}
        <div>
          <label for="nama_kepala" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kepala Sekolah <span class="text-red-500">*</span></label>
          <input type="text" id="nama_kepala" name="nama_kepala" value="{{ old('nama_kepala', $sambutan->nama_kepala) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('nama_kepala') border-red-400 @enderror"
            placeholder="Contoh: Harimawan, S.Pd., M.Si.">
          @error('nama_kepala') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Gelar / Jabatan --}}
        <div>
          <label for="gelar_kepala" class="block text-sm font-medium text-slate-700 mb-1.5">Jabatan / Gelar <span class="text-red-500">*</span></label>
          <input type="text" id="gelar_kepala" name="gelar_kepala" value="{{ old('gelar_kepala', $sambutan->gelar_kepala) }}" required
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-sm @error('gelar_kepala') border-red-400 @enderror"
            placeholder="Contoh: Kepala Sekolah SMK Muhammadiyah 1 Bantul">
          @error('gelar_kepala') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      {{-- Foto Kepala Sekolah --}}
      <div>
        <label for="foto_kepala" class="block text-sm font-medium text-slate-700 mb-1.5">Foto Kepala Sekolah</label>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
          <div id="preview-container" class="w-32 h-40 rounded-xl overflow-hidden border border-slate-200 bg-slate-50 flex-shrink-0 flex items-center justify-center">
            <img id="image-preview" src="{{ $sambutan->foto_src }}" alt="Foto Kepala Sekolah" class="w-full h-full object-cover">
          </div>
          <div class="space-y-2">
            <label class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 hover:border-primary hover:bg-orange-50 transition-all text-sm text-slate-600 hover:text-primary font-medium">
              <i class="fas fa-cloud-upload-alt text-base"></i>
              <span id="file-label">Ganti Foto</span>
              <input type="file" id="foto_kepala" name="foto_kepala" accept="image/*" class="hidden" data-aspect-ratio="3/4" onchange="previewImage(this)">
            </label>
            <p class="text-slate-400 text-xs">Rekomendasi rasio foto 3:4. Format: JPG, PNG, JPEG (maks. 2MB)</p>
          </div>
        </div>
        @error('foto_kepala') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Isi Sambutan --}}
      <div>
        <label for="isi_sambutan" class="block text-sm font-medium text-slate-700 mb-1.5">Isi Sambutan <span class="text-red-500">*</span></label>
        <textarea id="isi_sambutan" name="isi_sambutan" class="w-full">{{ old('isi_sambutan', $sambutan->isi_sambutan) }}</textarea>
        <p class="text-slate-400 text-xs mt-1.5"><i class="fas fa-info-circle mr-1"></i> Format teks sambutan menggunakan editor di atas.</p>
        @error('isi_sambutan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
        <button type="submit"
          class="inline-flex items-center gap-2 bg-primary hover:bg-secondary text-white font-semibold px-6 py-3 rounded-xl transition-all hover:shadow-lg hover:shadow-primary/30">
          <i class="fas fa-save"></i> Simpan Perubahan
        </button>
        <a href="{{ route('admin.dashboard') }}"
          class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-6 py-3 rounded-xl transition-all">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
{{-- CKEditor 5 CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#isi_sambutan'), {
      toolbar: {
        items: [
          'heading', '|',
          'bold', 'italic', 'underline', 'strikethrough', '|',
          'fontSize', 'fontColor', 'fontBackgroundColor', '|',
          'alignment', '|',
          'bulletedList', 'numberedList', 'todoList', '|',
          'outdent', 'indent', '|',
          'link', 'blockQuote', 'insertTable', '|',
          'undo', 'redo'
        ]
      },
      language: 'id',
      heading: {
        options: [
          { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
          { model: 'heading1', view: 'h1', title: 'Judul 1', class: 'ck-heading_heading1' },
          { model: 'heading2', view: 'h2', title: 'Judul 2', class: 'ck-heading_heading2' },
          { model: 'heading3', view: 'h3', title: 'Judul 3', class: 'ck-heading_heading3' },
        ]
      },
    })
    .then(editor => {
      editor.model.document.on('change:data', () => {
        document.querySelector('#isi_sambutan').value = editor.getData();
      });
    })
    .catch(error => console.error(error));

  function previewImage(input) {
    const file = input.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        document.getElementById('image-preview').src = e.target.result;
        document.getElementById('file-label').textContent = file.name;
      };
      reader.readAsDataURL(file);
    }
  }
</script>
@endsection
