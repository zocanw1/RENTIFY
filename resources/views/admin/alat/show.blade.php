<x-app-layout :title="'Detail ' . $alat->nama_alat">

    {{-- Breadcrumb --}}
    <div class="mb-6 flex items-center gap-2 text-sm text-gray-400 animate-fade-up">
        <a href="{{ route('admin.alat.index') }}" class="hover:text-brand-600 transition-colors">Kelola Alat</a>
        <span>/</span>
        <span class="text-gray-700 font-medium">{{ $alat->nama_alat }}</span>
    </div>

    {{-- Header alat --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 mb-6 flex items-center gap-5 flex-wrap card-hover animate-fade-up" style="animation-delay:.05s">
        @if($alat->foto)
        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}"
            class="w-24 h-24 object-cover rounded-2xl border border-gray-100 flex-shrink-0 shadow-sm hover:scale-105 transition-transform duration-300">
        @else
        <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
        </div>
        @endif
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900">{{ $alat->nama_alat }}</h1>
            <div class="flex flex-wrap gap-2 mt-2">
                <span class="text-xs px-2.5 py-1 rounded-full bg-green-50 text-green-700 font-medium">{{ $alat->stok_tersedia }} tersedia</span>
                @if($alat->stok_dipinjam > 0)
                <span class="text-xs px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 font-medium">{{ $alat->stok_dipinjam }} dipinjam</span>
                @endif
                @if($alat->stok_rusak > 0)
                <span class="text-xs px-2.5 py-1 rounded-full bg-red-50 text-red-700 font-medium">{{ $alat->stok_rusak }} rusak</span>
                @endif
                @if($alat->stok_diperbaiki > 0)
                <span class="text-xs px-2.5 py-1 rounded-full bg-orange-50 text-orange-700 font-medium">{{ $alat->stok_diperbaiki }} diperbaiki</span>
                @endif
                <span class="text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-500">{{ $alat->units_count }} total</span>
            </div>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <a href="{{ route('admin.alat.edit', $alat) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium border border-gray-200 hover:bg-gray-50 hover:border-gray-300 text-gray-600 px-4 py-2 rounded-xl transition-all duration-200">
                ✏️ Edit Alat
            </a>
            <a href="{{ route('admin.alat.qr', $alat) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium border border-gray-200 hover:bg-gray-50 text-gray-600 px-4 py-2 rounded-xl transition-all duration-200">
                📱 QR
            </a>
            <a href="{{ route('admin.laporan.alat', $alat) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium border border-brand-200 hover:bg-brand-50 text-brand-600 px-4 py-2 rounded-xl transition-all duration-200">
                📊 Laporan
            </a>
        </div>
    </div>

    {{-- Daftar unit --}}
    <div class="flex items-center justify-between mb-4 animate-fade-up" style="animation-delay:.08s">
        <h2 class="text-base font-bold text-gray-900">Kode/Prat Alat</h2>
        <span class="text-xs text-gray-400 bg-white/80 backdrop-blur px-3 py-1 rounded-full border border-gray-100">{{ $alat->units->count() }} unit</span>
    </div>

    @if($alat->units->isEmpty())
        <div class="text-center py-16 bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-fade-up">
            <p class="text-gray-400 text-sm">Belum ada unit.
                <a href="{{ route('admin.alat.edit', $alat) }}" class="text-brand-600 font-medium hover:text-brand-700">Tambah unit →</a>
            </p>
        </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 stagger">
        @foreach($alat->units as $unit)
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden animate-fade-up group" id="unit-card-{{ $unit->id }}">

            {{-- Foto unit --}}
            @if($unit->foto)
            <div class="overflow-hidden">
                <img src="{{ asset('storage/' . $unit->foto) }}" alt="{{ $unit->kode_unit }}"
                    class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @else
            <div class="w-full h-32 bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col items-center justify-center gap-1 group-hover:from-brand-50 group-hover:to-indigo-50 transition-all duration-300">
                <svg class="w-8 h-8 text-gray-200 group-hover:text-brand-200 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="text-xs text-gray-300 group-hover:text-brand-300 transition-colors">Belum ada foto</span>
            </div>
            @endif

            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-base font-bold text-gray-900 font-mono">{{ $unit->kode_unit }}</p>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full transition-all unit-badge-{{ $unit->id }}
                        {{ $unit->status==='Tersedia' ? 'bg-green-50 text-green-700' : ($unit->status==='Dipinjam' ? 'bg-yellow-50 text-yellow-700' : ($unit->status==='Diperbaiki' ? 'bg-orange-50 text-orange-700' : 'bg-red-50 text-red-700')) }}">
                        {{ $unit->status }}
                    </span>
                </div>

                @if($unit->status !== 'Dipinjam')
                <div class="flex gap-2 mb-2">
                    <button onclick="updateStatusUnit({{ $unit->id }}, 'Diperbaiki')"
                        class="btn-ripple flex-1 text-xs font-medium border border-orange-200 text-orange-600 hover:bg-orange-50 py-1.5 rounded-lg transition-all {{ $unit->status==='Diperbaiki' ? 'bg-orange-50' : '' }}">
                        🔧 Diperbaiki
                    </button>
                    <button onclick="updateStatusUnit({{ $unit->id }}, 'Tersedia')"
                        class="btn-ripple flex-1 text-xs font-medium border border-green-200 text-green-600 hover:bg-green-50 py-1.5 rounded-lg transition-all {{ $unit->status==='Tersedia' ? 'bg-green-50' : '' }}">
                        ✅ Aman
                    </button>
                </div>
                <a href="{{ route('admin.unit.edit', $unit) }}"
                    class="btn-ripple block w-full text-center text-xs font-medium border border-brand-200 text-brand-600 hover:bg-brand-50 py-1.5 rounded-lg transition-all mb-2">
                    ✏️ Edit Unit (Kode & Foto)
                </a>
                <form action="{{ route('admin.unit.destroy', $unit) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Hapus unit {{ $unit->kode_unit }}?')"
                        class="w-full text-xs font-medium border border-red-100 text-red-400 hover:bg-red-50 hover:border-red-200 py-1.5 rounded-lg transition-all">
                        🗑 Hapus Unit
                    </button>
                </form>
                @else
                <p class="text-xs text-yellow-600 text-center py-2 bg-yellow-50 rounded-xl">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse mr-1"></span>
                    Sedang dipinjam
                </p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <script>
    async function updateStatusUnit(unitId, status) {
        const label = status === 'Diperbaiki' ? 'Diperbaiki' : 'Aman (Tersedia)';
        if (!confirm(`Ubah status unit menjadi ${label}?`)) return;
        try {
            const res = await fetch(`/admin/unit/${unitId}/status`, {
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
                body:JSON.stringify({status}),
            });
            const data = await res.json();
            if (data.success) {
                const badge = document.querySelector(`.unit-badge-${unitId}`);
                if (badge) {
                    badge.textContent = data.status;
                    badge.className = `text-xs font-medium px-2.5 py-1 rounded-full transition-all unit-badge-${unitId} ` +
                        (data.status==='Tersedia' ? 'bg-green-50 text-green-700' : data.status==='Diperbaiki' ? 'bg-orange-50 text-orange-700' : 'bg-red-50 text-red-700');
                }
                setTimeout(() => location.reload(), 600);
            } else { alert(data.error||'Gagal!'); }
        } catch(e) { alert('Terjadi kesalahan.'); }
    }
    </script>

</x-app-layout>
