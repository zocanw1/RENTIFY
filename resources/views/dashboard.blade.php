<x-app-layout title="Dashboard">

    {{-- Header --}}
    <div class="mb-8 animate-fade-up">
        <h1 class="text-2xl font-bold text-gray-900">
            Hai, <span class="text-brand-600">{{ Auth::user()->name }}</span>! 👋
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            NIS: {{ Auth::user()->nis }}
            @if(Auth::user()->kelas) &mdash; {{ Auth::user()->kelas }} @endif
            &mdash; Pilih alat yang ingin dipinjam
        </p>
    </div>

    {{-- Search + filter --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-8 animate-fade-up" style="animation-delay:.1s">
        <div class="relative flex-1">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            <input type="text" id="live-search" placeholder="Cari nama alat..."
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent text-sm bg-white transition-all duration-200 shadow-sm">
        </div>
        <div class="flex gap-2">
            <button onclick="filterAlat('')" id="btn-semua"
                class="px-4 py-2.5 rounded-xl border text-sm font-medium transition-all duration-200 bg-brand-600 text-white border-brand-600 shadow-sm">
                Semua
            </button>
            <button onclick="filterAlat('tersedia')" id="btn-tersedia"
                class="px-4 py-2.5 rounded-xl border text-sm font-medium transition-all duration-200 bg-white text-gray-600 border-gray-200 hover:border-brand-300 hover:text-brand-600">
                Tersedia
            </button>
            <button onclick="filterAlat('habis')" id="btn-habis"
                class="px-4 py-2.5 rounded-xl border text-sm font-medium transition-all duration-200 bg-white text-gray-600 border-gray-200 hover:border-brand-300 hover:text-brand-600">
                Habis
            </button>
        </div>
    </div>

    @if($alats->isEmpty())
        <div class="text-center py-20 animate-fade-up">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada alat tersedia</p>
        </div>
    @else
    <div id="grid-alat" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 stagger">
        @foreach($alats as $alat)
        @php $stok = $alat->units->where('status','Tersedia')->count(); @endphp
        <a href="{{ route('pinjam.detail', $alat->id) }}"
            class="alat-card card-hover bg-white rounded-2xl border border-gray-100 overflow-hidden block group animate-fade-up"
            data-nama="{{ strtolower($alat->nama_alat) }}"
            data-stok="{{ $stok }}">
            {{-- Foto --}}
            <div class="aspect-video bg-gray-50 overflow-hidden relative">
                @if($alat->foto)
                    <img src="{{ asset('storage/' . $alat->foto) }}" alt="{{ $alat->nama_alat }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-200 group-hover:text-brand-200 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    </div>
                @endif
                {{-- Gradient overlay on hover --}}
                <div class="absolute inset-0 bg-gradient-to-t from-brand-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 group-hover:text-brand-600 transition-colors duration-200 mb-2">{{ $alat->nama_alat }}</h3>
                <div class="flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full transition-all duration-200
                        {{ $stok > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $stok > 0 ? 'bg-green-500' : 'bg-red-500' }}
                            {{ $stok > 0 ? 'animate-ping-slow' : '' }}"></span>
                        {{ $stok > 0 ? $stok . ' tersedia' : 'Habis' }}
                    </span>
                    <span class="text-xs text-gray-400 group-hover:text-brand-500 transition-colors">Detail →</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div id="empty-search" class="hidden text-center py-20 animate-fade-up">
        <p class="text-gray-400 font-medium">Tidak ada alat yang ditemukan</p>
    </div>
    @endif

    <script>
    let filterAktif = '';

    function filterAlat(tipe) {
        filterAktif = tipe;
        ['semua','tersedia','habis'].forEach(t => {
            const b = document.getElementById('btn-' + t);
            if (!b) return;
            b.className = 'px-4 py-2.5 rounded-xl border text-sm font-medium transition-all duration-200 bg-white text-gray-600 border-gray-200 hover:border-brand-300 hover:text-brand-600';
        });
        const aktif = document.getElementById('btn-' + (tipe === '' ? 'semua' : tipe));
        if (aktif) aktif.className = 'px-4 py-2.5 rounded-xl border text-sm font-medium transition-all duration-200 bg-brand-600 text-white border-brand-600 shadow-sm';
        applyFilter();
    }

    function applyFilter() {
        const q = document.getElementById('live-search').value.toLowerCase();
        const cards = document.querySelectorAll('.alat-card');
        let vis = 0;
        cards.forEach((card, i) => {
            const show = card.dataset.nama.includes(q) &&
                (filterAktif === '' || (filterAktif === 'tersedia' && +card.dataset.stok > 0) || (filterAktif === 'habis' && +card.dataset.stok === 0));
            if (show) {
                card.style.display = '';
                card.style.animationDelay = (vis * .05) + 's';
                vis++;
            } else {
                card.style.display = 'none';
            }
        });
        document.getElementById('empty-search')?.classList.toggle('hidden', vis > 0);
    }

    document.getElementById('live-search')?.addEventListener('input', applyFilter);
    </script>

</x-app-layout>
