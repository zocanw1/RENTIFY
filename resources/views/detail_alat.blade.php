<x-app-layout title="Detail {{ $alat->nama_alat }}">

    <div class="mb-6 animate-fade-up">
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-3 py-2 rounded-xl hover:border-brand-200 hover:-translate-x-0.5 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    {{-- Info alat --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 mb-6 flex items-center gap-5 card-hover animate-fade-up" style="animation-delay:.05s">
        @if($alat->foto)
        <img src="{{ Storage::url($alat->foto) }}" alt="{{ $alat->nama_alat }}"
            class="w-24 h-24 object-cover rounded-2xl border border-gray-100 flex-shrink-0 shadow-sm hover:scale-105 transition-transform duration-300">
        @else
        <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center flex-shrink-0">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
        </div>
        @endif
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $alat->nama_alat }}</h1>
            <div class="flex items-center gap-3 mt-2 flex-wrap">
                <span class="text-sm text-gray-500">{{ $alat->units->count() }} unit total</span>
                <span class="text-xs text-green-600 bg-green-50 px-2.5 py-1 rounded-full font-medium inline-flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping-slow"></span>
                    {{ $alat->units->where('status','Tersedia')->count() }} tersedia
                </span>
                @if($alat->units->where('status','Dipinjam')->count() > 0)
                <span class="text-xs text-yellow-600 bg-yellow-50 px-2.5 py-1 rounded-full font-medium">{{ $alat->units->where('status','Dipinjam')->count() }} dipinjam</span>
                @endif
                @if($alat->units->where('status','Diperbaiki')->count() > 0)
                <span class="text-xs text-orange-600 bg-orange-50 px-2.5 py-1 rounded-full font-medium">{{ $alat->units->where('status','Diperbaiki')->count() }} diperbaiki</span>
                @endif
                @if($alat->units->where('status','Rusak')->count() > 0)
                <span class="text-xs text-red-600 bg-red-50 px-2.5 py-1 rounded-full font-medium">{{ $alat->units->where('status','Rusak')->count() }} rusak</span>
                @endif
            </div>
        </div>
    </div>

    <h2 class="text-base font-bold text-gray-900 mb-4 animate-fade-up" style="animation-delay:.08s">Detail Unit Alat</h2>

    @if($alat->units->isEmpty())
        <div class="text-center py-16 bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-scale-in">
            <p class="text-gray-400 text-sm">Belum ada unit untuk alat ini.</p>
        </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 stagger">
        @foreach($alat->units as $unit)
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden group animate-fade-up">

            {{-- Foto unit --}}
            @if($unit->foto)
            <div class="overflow-hidden">
                <img src="{{ Storage::url($unit->foto) }}" alt="{{ $unit->kode_unit }}"
                    class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
            @else
            <div class="w-full h-32 bg-gradient-to-br from-gray-50 to-gray-100 group-hover:from-brand-50 group-hover:to-indigo-50 flex flex-col items-center justify-center gap-1 transition-all duration-300">
                <svg class="w-8 h-8 text-gray-200 group-hover:text-brand-200 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif

            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-base font-bold text-gray-900 font-mono group-hover:text-brand-700 transition-colors">{{ $unit->kode_unit }}</p>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full
                        {{ $unit->status==='Tersedia' ? 'bg-green-50 text-green-700' : ($unit->status==='Dipinjam' ? 'bg-yellow-50 text-yellow-700' : ($unit->status==='Diperbaiki' ? 'bg-orange-50 text-orange-700' : 'bg-red-50 text-red-700')) }}">
                        {{ $unit->status }}
                    </span>
                </div>

                @if($unit->status === 'Tersedia')
                    <form action="{{ route('pinjam.proses', $unit->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Pinjam unit {{ $unit->kode_unit }}?')"
                            class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-all shadow-sm hover:shadow-brand-200/50 hover:shadow-md">
                            Pinjam Unit Ini
                        </button>
                    </form>
                @elseif($unit->status === 'Dipinjam')
                    <p class="text-xs text-yellow-600 text-center py-2 bg-yellow-50 rounded-xl flex items-center justify-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>Sedang dipinjam
                    </p>
                @elseif($unit->status === 'Diperbaiki')
                    <p class="text-xs text-orange-600 text-center py-2 bg-orange-50 rounded-xl">🔧 Sedang diperbaiki</p>
                @else
                    <p class="text-xs text-red-500 text-center py-2 bg-red-50 rounded-xl">Tidak tersedia (Rusak)</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

</x-app-layout>
