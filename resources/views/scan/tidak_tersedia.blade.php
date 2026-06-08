<x-app-layout title="Unit Tidak Tersedia">
    <div class="max-w-sm mx-auto text-center py-8">

        <div class="animate-fade-up">
            <div class="w-16 h-16 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">Unit Tidak Tersedia</h2>
            <p class="text-gray-500 text-sm mb-6">Unit ini sedang tidak bisa dipinjam</p>
        </div>

        {{-- Info unit --}}
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 mb-6 text-left animate-fade-up" style="animation-delay:.08s">
            @if($unit->alat->foto)
            <img src="{{ asset('storage/' . $unit->alat->foto) }}" class="w-full h-32 object-cover rounded-xl mb-4">
            @endif
            <p class="font-bold text-gray-900">{{ $unit->alat->nama_alat }}</p>
            <p class="text-sm text-gray-500 mt-1 font-mono">{{ $unit->kode_unit }}</p>
            <div class="mt-3">
                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full
                    {{ $unit->status === 'Dipinjam' ? 'bg-yellow-50 text-yellow-700' :
                       ($unit->status === 'Diperbaiki' ? 'bg-orange-50 text-orange-700' : 'bg-red-50 text-red-700') }}">
                    <span class="w-1.5 h-1.5 rounded-full
                        {{ $unit->status === 'Dipinjam' ? 'bg-yellow-500' :
                           ($unit->status === 'Diperbaiki' ? 'bg-orange-500' : 'bg-red-500') }} animate-pulse"></span>
                    {{ $unit->status }}
                    @if($unit->status === 'Dipinjam') — Sedang dipakai siswa lain
                    @elseif($unit->status === 'Diperbaiki') — Sedang diperbaiki
                    @else — Tidak bisa digunakan
                    @endif
                </span>
            </div>

            @if($unit->status === 'Dipinjam')
            <div class="mt-3 bg-blue-50 rounded-xl px-3 py-2.5 text-xs text-blue-700">
                💡 Coba scan unit lain dari alat yang sama, atau cek dashboard untuk unit yang tersedia.
            </div>
            @endif
        </div>

        <div class="flex flex-col gap-2 animate-fade-up" style="animation-delay:.16s">
            <a href="{{ route('pinjam.detail', $unit->alat_id) }}"
                class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition-all shadow-sm text-sm">
                Lihat Unit Lain dari Alat Ini
            </a>
            <a href="{{ route('dashboard') }}"
                class="block w-full text-center text-sm text-gray-400 hover:text-gray-600 py-2.5 transition-colors">
                Kembali ke Dashboard
            </a>
        </div>

    </div>
</x-app-layout>
