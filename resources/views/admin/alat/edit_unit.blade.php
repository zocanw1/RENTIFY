<x-app-layout :title="'Edit Unit ' . $unit->kode_unit">

    <div class="mb-6 flex items-center gap-2 text-sm text-gray-400 animate-fade-up">
        <a href="{{ route('admin.alat.index') }}" class="hover:text-brand-600 transition-colors">Kelola Alat</a>
        <span>/</span>
        <a href="{{ route('admin.alat.show', $unit->alat) }}" class="hover:text-brand-600 transition-colors">{{ $unit->alat->nama_alat }}</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">Edit {{ $unit->kode_unit }}</span>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 animate-fade-up">
        @foreach($errors->all() as $error)
            <p class="text-sm text-red-600">⚠ {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="max-w-xl animate-fade-up" style="animation-delay:.08s">
        <form action="{{ route('admin.unit.update', $unit) }}" method="POST" enctype="multipart/form-data"
            class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 space-y-6 card-hover">
            @csrf @method('PUT')

            {{-- Kode Unit --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Unit</label>
                <input type="text" name="kode_unit" value="{{ old('kode_unit', $unit->kode_unit) }}" required
                    class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono transition-all">
                <p class="text-xs text-gray-400 mt-1">Contoh: ap-1, sw-3</p>
            </div>

            {{-- Foto Unit --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto Unit</label>

                @if($unit->foto)
                <div class="mb-3 overflow-hidden rounded-xl border border-gray-100 group cursor-pointer" onclick="document.getElementById('foto').click()">
                    <img id="preview-current" src="{{ asset('storage/' . $unit->foto) }}" alt="{{ $unit->kode_unit }}"
                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="p-2 text-center bg-gray-50">
                        <p class="text-xs text-gray-400 group-hover:text-brand-500 transition-colors">Klik untuk ganti foto</p>
                    </div>
                </div>
                @endif

                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-brand-400 hover:bg-brand-50/30 transition-all duration-300 cursor-pointer group"
                    onclick="document.getElementById('foto').click()">
                    <img id="preview-new" src="" class="hidden w-full h-48 object-cover rounded-xl mx-auto mb-3">
                    <div id="upload-placeholder">
                        <div class="w-10 h-10 bg-gray-100 group-hover:bg-brand-100 rounded-xl flex items-center justify-center mx-auto mb-2 transition-colors duration-200">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm text-gray-500 group-hover:text-brand-600 transition-colors">{{ $unit->foto ? 'Upload foto baru' : 'Klik untuk upload foto' }}</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, max 2MB</p>
                    </div>
                    <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                </div>

                @if($unit->foto)
                <label class="flex items-center gap-2 mt-3 cursor-pointer group">
                    <input type="checkbox" name="hapus_foto" value="1" class="rounded border-gray-300 text-red-500">
                    <span class="text-sm text-red-500 group-hover:text-red-600 transition-colors">Hapus foto unit ini</span>
                </label>
                @endif
            </div>

            {{-- Info status --}}
            <div class="bg-gray-50 rounded-xl px-4 py-3">
                <p class="text-xs text-gray-500">
                    Status unit saat ini:
                    <span class="font-semibold {{ $unit->status==='Tersedia' ? 'text-green-600' : ($unit->status==='Dipinjam' ? 'text-yellow-600' : ($unit->status==='Diperbaiki' ? 'text-orange-600' : 'text-red-600')) }}">
                        {{ $unit->status }}
                    </span>
                    — ubah status lewat tombol di halaman Detail Unit.
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="btn-ripple flex-1 bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm hover:shadow-brand-200/50 hover:shadow-md text-sm">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.alat.show', $unit->alat) }}"
                    class="flex-1 text-center border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-2.5 rounded-xl transition-all text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
    function previewFoto(input) {
        const preview = document.getElementById('preview-new');
        const ph = document.getElementById('upload-placeholder');
        const current = document.getElementById('preview-current');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                ph.classList.add('hidden');
                if (current) current.parentElement.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>

</x-app-layout>
