<x-app-layout title="Konfirmasi Pinjam">
    <div class="max-w-sm mx-auto">

        {{-- Header --}}
        <div class="text-center mb-6 animate-fade-up">
            <div class="w-14 h-14 bg-brand-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-gray-900">Konfirmasi Peminjaman</h1>
            <p class="text-gray-500 text-sm mt-1">QR berhasil discan! Cek detail unit di bawah</p>
        </div>

        {{-- Card unit --}}
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden mb-5 animate-fade-up" style="animation-delay:.08s">

            {{-- Foto alat --}}
            @if($unit->foto)
                <div class="overflow-hidden">
                    <img src="{{ asset('storage/' . $unit->foto) }}" class="w-full h-44 object-cover">
                </div>
            @elseif($unit->alat->foto)
                <div class="overflow-hidden">
                    <img src="{{ asset('storage/' . $unit->alat->foto) }}" class="w-full h-44 object-cover">
                </div>
            @else
                <div class="w-full h-36 bg-gradient-to-br from-brand-50 to-indigo-100 flex items-center justify-center">
                    <svg class="w-14 h-14 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>
            @endif

            <div class="p-5">
                <h2 class="text-lg font-bold text-gray-900 mb-1">{{ $unit->alat->nama_alat }}</h2>

                {{-- Kode unit --}}
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-xs text-gray-500">Kode unit:</span>
                    <span class="font-mono text-sm font-semibold text-gray-800 bg-gray-100 px-2.5 py-0.5 rounded-lg">
                        {{ $unit->kode_unit }}
                    </span>
                </div>

                {{-- Status badge --}}
                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-full bg-green-50 text-green-700">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-ping-slow"></span>
                    Tersedia — Siap dipinjam
                </span>
            </div>
        </div>

        {{-- Info siswa --}}
        <div class="bg-brand-50/80 backdrop-blur rounded-xl border border-brand-100 px-4 py-3 mb-5 flex items-center gap-3 animate-fade-up" style="animation-delay:.12s">
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-brand-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-brand-500">NIS: {{ auth()->user()->nis }} · {{ auth()->user()->kelas ?? '-' }}</p>
            </div>
            <svg class="w-4 h-4 text-brand-400 ml-auto flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>

        {{-- Form submit pinjam --}}
        <form action="{{ route('pinjam.proses', $unit->id) }}" method="POST" class="animate-fade-up" style="animation-delay:.16s" id="form-pinjam">
            @csrf
            <button type="submit" id="btn-submit"
                class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md hover:shadow-brand-200/60 hover:shadow-lg text-base">
                ✅ Pinjam Sekarang
            </button>
        </form>

        <a href="{{ route('dashboard') }}"
            class="block w-full text-center text-sm text-gray-400 hover:text-gray-600 py-3 mt-1 transition-colors animate-fade-up" style="animation-delay:.2s">
            Batal
        </a>

    </div>

    <script>
    // Cegah double submit
    document.getElementById('form-pinjam')?.addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit');
        btn.disabled = true;
        btn.textContent = '⏳ Memproses...';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });
    </script>

</x-app-layout>
