<x-app-layout :title="'Edit ' . $alat->nama_alat">

    <div class="mb-8 flex items-center gap-3 animate-fade-up">
        <a href="{{ route('admin.alat.show', $alat) }}"
            class="w-9 h-9 rounded-xl bg-white/80 backdrop-blur border border-gray-200 flex items-center justify-center hover:bg-white hover:shadow-sm hover:-translate-x-0.5 transition-all duration-200">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Alat</h1>
            <p class="text-gray-500 text-sm">{{ $alat->nama_alat }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 animate-fade-up">
        @foreach($errors->all() as $error)
            <p class="text-sm text-red-600">⚠ {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <form action="{{ route('admin.alat.update', $alat) }}" method="POST"
            enctype="multipart/form-data" class="lg:col-span-2 space-y-5 stagger">
            @csrf @method('PUT')

            {{-- Nama --}}
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs font-bold">1</span>
                    Informasi Alat
                </h3>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Alat</label>
                <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                    class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
            </div>

            {{-- Foto --}}
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs font-bold">2</span>
                    Foto Alat
                </h3>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-brand-400 hover:bg-brand-50/30 transition-all duration-300 cursor-pointer group"
                    onclick="document.getElementById('foto').click()">
                    @if($alat->foto)
                        <img id="preview" src="{{ asset('storage/' . $alat->foto) }}"
                            class="w-40 h-40 object-cover rounded-xl mx-auto mb-3 shadow-sm group-hover:shadow-md transition-shadow">
                        <p class="text-xs text-gray-400 group-hover:text-brand-500 transition-colors">Klik untuk ganti foto</p>
                    @else
                        <img id="preview" src="" class="hidden w-40 h-40 object-cover rounded-xl mx-auto mb-3">
                        <div id="upload-placeholder">
                            <div class="w-12 h-12 bg-gray-100 group-hover:bg-brand-100 rounded-xl flex items-center justify-center mx-auto mb-3 transition-colors">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-brand-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-sm font-medium text-gray-600 group-hover:text-brand-600 transition-colors">Klik untuk pilih foto</p>
                        </div>
                    @endif
                    <input type="file" id="foto" name="foto" accept="image/*" class="hidden" onchange="previewFoto(this)">
                </div>
                <p class="text-xs text-gray-400 mt-2 text-center">Biarkan kosong jika tidak ingin mengganti foto</p>
            </div>

            {{-- Unit yang sudah ada --}}
            @if($alat->units->isNotEmpty())
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs font-bold">3</span>
                    Unit yang Sudah Ada
                </h3>
                <p class="text-xs text-gray-400 mb-4 ml-8">Lihat detail per unit di halaman <a href="{{ route('admin.alat.show', $alat) }}" class="text-brand-600 hover:underline">Detail Unit</a></p>
                <div class="space-y-2">
                    @foreach($alat->units as $unit)
                    <div class="flex items-center justify-between p-3 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors group">
                        <span class="text-sm font-mono font-medium text-gray-700">{{ $unit->kode_unit }}</span>
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                            {{ $unit->status==='Tersedia' ? 'bg-green-100 text-green-700' : ($unit->status==='Dipinjam' ? 'bg-yellow-100 text-yellow-700' : ($unit->status==='Diperbaiki' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $unit->status }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Tambah unit baru --}}
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up card-hover">
                <h3 class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-6 h-6 bg-brand-100 rounded-lg flex items-center justify-center text-brand-600 text-xs font-bold">{{ $alat->units->isNotEmpty() ? '4' : '3' }}</span>
                    Tambah Unit Baru
                </h3>
                <p class="text-xs text-gray-400 mb-4 ml-8">Opsional — kosongkan jika tidak ingin menambah unit</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Tambahan</label>
                        <input type="number" name="tambah_unit" value="{{ old('tambah_unit', 0) }}" min="0" max="100" placeholder="0"
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
                <div id="preview-unit" class="mt-4 p-4 bg-gray-50 rounded-xl hidden animate-fade-in">
                    <p class="text-xs font-medium text-gray-500 mb-2">Unit baru yang akan ditambahkan:</p>
                    <div id="preview-unit-list" class="flex flex-wrap gap-2"></div>
                </div>
            </div>

            <button type="submit"
                class="btn-ripple animate-fade-up w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition-all shadow-sm hover:shadow-brand-200/50 hover:shadow-lg">
                Simpan Perubahan
            </button>
        </form>

        {{-- Sidebar --}}
        <div class="space-y-4 stagger">
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 animate-fade-up card-hover">
                <h4 class="text-sm font-semibold text-gray-700 mb-4">📊 Statistik Unit</h4>
                <div class="space-y-3">
                    @php
                    $stats = [
                        ['label'=>'Total unit',  'val'=>$alat->units->count(),                     'color'=>'text-gray-900'],
                        ['label'=>'Tersedia',    'val'=>$alat->units->where('status','Tersedia')->count(),   'color'=>'text-green-600'],
                        ['label'=>'Dipinjam',    'val'=>$alat->units->where('status','Dipinjam')->count(),   'color'=>'text-yellow-600'],
                        ['label'=>'Diperbaiki',  'val'=>$alat->units->where('status','Diperbaiki')->count(), 'color'=>'text-orange-600'],
                        ['label'=>'Rusak',       'val'=>$alat->units->where('status','Rusak')->count(),      'color'=>'text-red-600'],
                    ];
                    @endphp
                    @foreach($stats as $s)
                    <div class="flex justify-between items-center group hover:bg-gray-50 px-2 py-1 rounded-lg transition-colors">
                        <span class="text-sm text-gray-500">{{ $s['label'] }}</span>
                        <span class="font-bold {{ $s['color'] }} group-hover:scale-110 transition-transform inline-block">{{ $s['val'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-brand-50/80 backdrop-blur rounded-2xl border border-brand-100 p-5 animate-fade-up card-hover">
                <h4 class="text-sm font-semibold text-brand-700 mb-3">💡 Info</h4>
                <p class="text-xs text-brand-600 leading-relaxed">Untuk mengubah status, foto, atau nama per unit, gunakan tombol <strong>Edit Unit</strong> di halaman Detail Unit.</p>
                <a href="{{ route('admin.alat.show', $alat) }}"
                    class="inline-block mt-3 text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                    → Ke halaman Detail Unit
                </a>
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
            if (ph) ph.classList.add('hidden');
        }
    }
    function updatePreview() {
        const sekarang = {{ $alat->units->count() }};
        const tambah = parseInt(document.querySelector('[name="tambah_unit"]').value)||0;
        const prefix = document.getElementById('prefix_unit').value.trim();
        const container = document.getElementById('preview-unit');
        const list = document.getElementById('preview-unit-list');
        if (!prefix||tambah<1) { container.classList.add('hidden'); return; }
        container.classList.remove('hidden');
        let html = '';
        for (let i=1;i<=Math.min(tambah,8);i++)
            html+=`<span class="bg-white border border-gray-200 px-2.5 py-1 rounded-lg font-mono text-xs text-gray-700 hover:border-brand-300 hover:text-brand-700 transition-colors">${prefix}-${sekarang+i}</span>`;
        if (tambah>8) html+=`<span class="text-xs text-gray-400 self-center">+${tambah-8} lainnya</span>`;
        list.innerHTML = html;
    }
    </script>

</x-app-layout>
