<x-app-layout title="Daftar Siswa">
    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                @if($user->isKetuaTjkt()) Siswa Jurusan TJKT
                @elseif($user->isKetuaSija()) Siswa Jurusan SIJA
                @elseif($user->isWaliKelas()) Siswa Kelas {{ $user->kelas ?? '-' }}
                @endif
            </h1>
            <p class="text-gray-500 text-sm mt-1" id="jumlah-label">{{ $siswas->total() }} siswa</p>
        </div>
        <a href="{{ route('staff.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl hover:-translate-x-0.5 transition-all">← Dashboard</a>
    </div>

    {{-- Filter + Search --}}
    <form method="GET" action="{{ route('staff.siswas') }}" id="form-filter"
          class="flex flex-col sm:flex-row gap-3 mb-6 animate-fade-up" style="animation-delay:.06s">
        <div class="relative flex-1">
            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
            <input type="text" name="cari" id="search-siswa"
                   value="{{ request('cari') }}"
                   placeholder="Cari nama, NIS, atau kelas..."
                   class="input-focus w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white/80 backdrop-blur shadow-sm transition-all">
        </div>
        @if(count($kelasList) > 1)
        <select name="kelas" id="filter-kelas" onchange="document.getElementById('form-filter').submit()"
            class="input-focus px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white/80 backdrop-blur shadow-sm">
            <option value="">Semua Kelas</option>
            @foreach($kelasList as $k)
            <option value="{{ $k }}" @selected(request('kelas') === $k)>{{ $k }}</option>
            @endforeach
        </select>
        @endif
    </form>

    @if($siswas->isEmpty())
    <div class="text-center py-20 bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-scale-in">
        @if($user->isWaliKelas() && empty($user->kelas))
            <p class="text-gray-400 font-medium">Data kelas Anda belum dikonfigurasi. Hubungi admin.</p>
        @else
            <p class="text-gray-400 font-medium">Belum ada siswa terdaftar</p>
        @endif
    </div>
    @else
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.1s">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Siswa</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">NIS</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Kelas</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Pinjam</th>
                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                </tr>
            </thead>
            <tbody id="tbody-siswa" class="divide-y divide-gray-50">
                @foreach($siswas as $siswa)
                <tr class="hover:bg-brand-50/30 transition-colors group siswa-row">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $siswa->fotoUrl() }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0 group-hover:scale-110 transition-transform shadow-sm">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $siswa->name }}</p>
                                <p class="text-xs text-gray-400">{{ $siswa->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="font-mono text-sm text-gray-600">{{ $siswa->nis }}</span></td>
                    <td class="px-6 py-4"><span class="text-sm text-gray-600">{{ $siswa->kelas ?? '-' }}</span></td>
                    <td class="px-6 py-4 text-center"><span class="text-sm font-semibold text-gray-700">{{ $siswa->peminjaman_count }}</span></td>
                    <td class="px-6 py-4 text-center">
                        @if($siswa->peminjaman_aktif > 0)
                        <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-ping-slow"></span>Pinjam Aktif
                        </span>
                        @else
                        <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="bg-slate-50 border-t border-gray-100">
            {{ $siswas->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif

    <script>
    // Debounced server-side search saat mengetik
    let searchTimer;
    document.getElementById('search-siswa')?.addEventListener('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            document.getElementById('form-filter').submit();
        }, 400);
    });
    </script>
</x-app-layout>
