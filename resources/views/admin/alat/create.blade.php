<x-app-layout title="Tambah Alat">

    <div class="mb-8 flex items-center gap-3 animate-fade-up">
        <a href="{{ route('admin.alat.index') }}"
            class="w-9 h-9 rounded-xl bg-white/80 backdrop-blur border border-gray-200 flex items-center justify-center hover:bg-white hover:shadow-sm hover:-translate-x-0.5 transition-all duration-200">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Alat Baru</h1>
            <p class="text-gray-500 text-sm">Isi informasi alat dan jumlah unit</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" class="lg:col-span-2 space-y-5 stagger">
            @csrf

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-2xl p-4 animate-fade-up">
                @foreach($errors->all() as $error)
                    <p class="text-sm text-red-600 flex items-center gap-2">⚠ {{ $error }}</p>
                @endforeach
            </div>
            @endif

            {{-- Nama alat --}}
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs">1</span>
                    Informasi Alat
                </h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Alat</label>
                    <input type="text" name="nama_alat" value="{{ old('nama_alat') }}"
                        placeholder="Contoh: Access Point, Switch 24 Port"
                        class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm"
                        oninput="updatePrefix(this.value)">
                    <p class="text-xs text-gray-400 mt-1">Nama jenis alat, bukan mereknya</p>
                </div>
            </div>

            {{-- Foto --}}
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs">2</span>
                    Foto Alat
                </h3>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-brand-400 hover:bg-brand-50/30 transition-all duration-300 cursor-pointer group"
                    onclick="document.getElementById('foto').click()">
                    <img id="preview" src="" class="hidden w-40 h-40 object-cover rounded-xl mx-auto mb-3 shadow-sm">
                    <div id="upload-placeholder">
                        <div class="w-12 h-12 bg-gray-100 group-hover:bg-brand-100 rounded-xl flex items-center justify-center mx-auto mb-3 transition-colors duration-200">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-600 group-hover:text-brand-600 transition-colors">Klik untuk pilih foto</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG — maks. 2MB</p>
                    </div>
                    <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                </div>
            </div>

            {{-- Unit --}}
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs">3</span>
                    Pengaturan Unit
                </h3>
                <p class="text-xs text-gray-400 mb-4 ml-8">Unit = barang fisiknya. 3 Access Point → prefix "ap" → ap-1, ap-2, ap-3</p>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Unit</label>
                        <input type="number" name="jumlah_unit" value="{{ old('jumlah_unit', 1) }}" min="1" max="100"
                            class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm"
                            oninput="updatePreview()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Prefix Kode</label>
                        <input type="text" name="prefix_unit" id="prefix_unit" value="{{ old('prefix_unit') }}" placeholder="ap, sw, lpt"
                            class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono"
                            oninput="updatePreview()">
                    </div>
                </div>
                {{-- Preview unit --}}
                <div id="preview-unit" class="mt-2 p-4 bg-gray-50 rounded-xl hidden animate-fade-in">
                    <p class="text-xs font-medium text-gray-500 mb-2">Preview unit yang akan dibuat:</p>
                    <div id="preview-unit-list" class="flex flex-wrap gap-2"></div>
                </div>
            </div>

            <button type="submit"
                class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition-all shadow-sm hover:shadow-brand-200/50 hover:shadow-lg animate-fade-up">
                Simpan Alat & Buat Unit
            </button>
        </form>

        {{-- Sidebar tips --}}
        <div class="space-y-4 stagger">
            <div class="bg-brand-50/80 backdrop-blur rounded-2xl border border-brand-100 p-5 animate-fade-up card-hover">
                <h4 class="text-sm font-semibold text-brand-700 mb-3">💡 Tips pengisian</h4>
                <ul class="space-y-2 text-xs text-brand-600">
                    <li>• <strong>Nama alat</strong>: nama jenis. Contoh: "Access Point"</li>
                    <li>• <strong>Prefix</strong>: singkatan pendek tanpa spasi. Contoh: ap, sw, lpt</li>
                    <li>• <strong>Jumlah unit</strong>: berapa banyak fisik yang kamu punya</li>
                    <li>• Kode unit otomatis: prefix-1, prefix-2, dst</li>
                </ul>
            </div>
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 animate-fade-up card-hover">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Contoh</h4>
                <div class="space-y-2 text-xs text-gray-500">
                    <div class="flex justify-between"><span>Nama alat</span><span class="font-mono text-gray-700">Access Point</span></div>
                    <div class="flex justify-between"><span>Prefix</span><span class="font-mono text-gray-700">ap</span></div>
                    <div class="flex justify-between"><span>Jumlah</span><span class="font-mono text-gray-700">3</span></div>
                    <div class="border-t border-gray-100 pt-2 mt-2">
                        <p class="text-gray-400 mb-2">Unit yang dibuat:</p>
                        <div class="flex gap-1 flex-wrap">
                            @foreach(['ap-1','ap-2','ap-3'] as $k)
                            <span class="bg-gray-100 px-2 py-0.5 rounded-lg font-mono text-gray-600">{{ $k }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            const preview = document.getElementById('preview');
            const ph = document.getElementById('upload-placeholder');
            preview.src = URL.createObjectURL(input.files[0]);
            preview.classList.remove('hidden');
            ph.classList.add('hidden');
        }
    }
    function updatePrefix(val) {
        const prefix = document.getElementById('prefix_unit');
        if (!prefix.value) {
            prefix.value = val.trim().split(' ').map(w => w[0]||'').join('').toLowerCase();
            updatePreview();
        }
    }
    function updatePreview() {
        const jumlah = parseInt(document.querySelector('[name="jumlah_unit"]').value)||0;
        const prefix = document.getElementById('prefix_unit').value.trim();
        const container = document.getElementById('preview-unit');
        const list = document.getElementById('preview-unit-list');
        if (!prefix||jumlah<1) { container.classList.add('hidden'); return; }
        container.classList.remove('hidden');
        const max = Math.min(jumlah,8);
        let html = '';
        for (let i=1;i<=max;i++) html += `<span class="bg-white border border-gray-200 px-2.5 py-1 rounded-lg font-mono text-xs text-gray-700 hover:border-brand-300 hover:text-brand-700 transition-colors">${prefix}-${i}</span>`;
        if (jumlah>8) html += `<span class="text-xs text-gray-400 self-center">+${jumlah-8} lainnya</span>`;
        list.innerHTML = html;
    }
    </script>

</x-app-layout>
