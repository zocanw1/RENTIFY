<x-app-layout title="Kelola Alat">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Alat</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $alats->count() }} jenis alat terdaftar</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white px-4 py-2.5 rounded-xl transition-all hover:border-brand-200">
                ← Dashboard
            </a>
            <a href="{{ route('admin.alat.create') }}"
                class="btn-ripple inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all">
                + Tambah Alat
            </a>
        </div>
    </div>

    @if($alats->isEmpty())
        <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 animate-fade-up">
            <p class="text-gray-500 font-medium mb-3">Belum ada alat terdaftar.</p>
            <a href="{{ route('admin.alat.create') }}" class="text-sm text-brand-600 font-medium hover:text-brand-700">+ Tambah alat sekarang</a>
        </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 stagger">
        @foreach($alats as $alat)
        <div class="card-hover bg-white rounded-2xl border border-gray-100 overflow-hidden group animate-fade-up">
            {{-- Foto --}}
            <a href="{{ route('admin.alat.show', $alat) }}" class="block">
                <div class="aspect-video bg-gray-50 overflow-hidden relative">
                    @if($alat->foto)
                        <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center gap-2">
                            <svg class="w-12 h-12 text-gray-200 group-hover:text-brand-200 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end pb-3 pl-3">
                        <span class="text-white text-xs font-semibold">Lihat Detail Unit →</span>
                    </div>
                </div>
            </a>

            <div class="p-4">
                <a href="{{ route('admin.alat.show', $alat) }}">
                    <h3 class="font-bold text-gray-900 text-base group-hover:text-brand-600 transition-colors duration-200 mb-2">{{ $alat->nama_alat }}</h3>
                </a>

                <div class="flex flex-wrap gap-1.5 mb-4">
                    <span class="text-xs px-2 py-0.5 rounded-full bg-green-50 text-green-700 font-medium">{{ $alat->stok_tersedia }} tersedia</span>
                    @if($alat->stok_dipinjam > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full bg-yellow-50 text-yellow-700 font-medium">{{ $alat->stok_dipinjam }} dipinjam</span>
                    @endif
                    @if($alat->stok_rusak > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full bg-red-50 text-red-700 font-medium">{{ $alat->stok_rusak }} rusak</span>
                    @endif
                    @if($alat->stok_diperbaiki > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full bg-orange-50 text-orange-700 font-medium">{{ $alat->stok_diperbaiki }} diperbaiki</span>
                    @endif
                    <span class="text-xs px-2 py-0.5 rounded-full bg-gray-50 text-gray-500">{{ $alat->units_count }} total</span>
                </div>

                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('admin.alat.show', $alat) }}"
                        class="btn-ripple flex-1 text-center text-xs font-semibold bg-brand-600 hover:bg-brand-700 text-white py-2 rounded-xl transition-all shadow-sm">
                        Detail Unit
                    </a>
                    <a href="{{ route('admin.alat.qr', $alat) }}"
                        class="text-xs font-medium border border-brand-200 text-brand-600 hover:bg-brand-50 px-3 py-2 rounded-xl transition-all">
                        Cetak QR
                    </a>
                    <a href="{{ route('admin.alat.edit', $alat) }}"
                        class="text-xs font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 px-3 py-2 rounded-xl transition-all">
                        Edit
                    </a>
                    <form action="{{ route('admin.alat.destroy', $alat) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Hapus alat {{ $alat->nama_alat }}?')"
                            class="text-xs font-medium border border-red-100 text-red-400 hover:bg-red-50 hover:border-red-200 px-3 py-2 rounded-xl transition-all">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</x-app-layout>
