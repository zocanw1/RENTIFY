<x-app-layout title="Dashboard Admin">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau semua aktivitas peminjaman</p>
        </div>
        <a href="{{ route('admin.alat.index') }}"
            class="btn-ripple inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            Kelola Alat
        </a>
    </div>

    {{-- NOTIF menunggu konfirmasi --}}
    @if($menungguKonfirmasi->count() > 0)
    <div class="mb-6 bg-orange-50 border border-orange-200 rounded-2xl p-5 animate-fade-up" style="animation-delay:.05s">
        <h2 class="text-base font-bold text-orange-800 mb-3 flex items-center gap-2">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-orange-500"></span>
            </span>
            {{ $menungguKonfirmasi->count() }} Pengembalian Menunggu Konfirmasi
        </h2>
        <div class="space-y-3">
            @foreach($menungguKonfirmasi as $p)
            <div class="bg-white rounded-xl border border-orange-100 p-4 animate-fade-up card-hover" style="animation-delay:{{ $loop->index * .05 }}s">
                <div class="flex items-start justify-between gap-3 flex-wrap">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-7 h-7 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($p->user->name, 0, 1)) }}
                            </div>
                            <p class="text-sm font-semibold text-gray-900">{{ $p->user->name }}</p>
                            <span class="text-xs text-gray-400">{{ $p->user->kelas ?? '' }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-1 ml-9">
                            Mengembalikan <span class="font-medium text-gray-700">{{ $p->unit->alat->nama_alat }}</span>
                            <span class="font-mono text-gray-400">({{ $p->unit->kode_unit }})</span>
                        </p>
                        @if($p->komentar_siswa)
                        <div class="ml-9 bg-blue-50 rounded-lg px-3 py-2 text-xs text-blue-800 mt-2">
                            💬 {{ $p->komentar_siswa }}
                        </div>
                        @endif
                    </div>
                    <form action="{{ route('admin.konfirmasi.kembali', $p->id) }}" method="POST" class="flex-shrink-0 w-full sm:w-64">
                        @csrf
                        <textarea name="balasan_admin" rows="2" placeholder="Balasan (opsional)..."
                            class="w-full px-3 py-2 text-xs border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 resize-none mb-2 transition-all"></textarea>
                        <button type="submit"
                            class="btn-ripple w-full bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-sm hover:shadow-green-200/50 hover:shadow-md">
                            ✓ Konfirmasi Pengembalian
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Statistik --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 stagger">
        @php
        $cards = [
            ['label'=>'Total Alat',      'val'=>$stats['total_alat'],          'sub'=>$stats['total_unit'].' unit total',  'color'=>'brand',  'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10'],
            ['label'=>'Sedang Dipinjam', 'val'=>$stats['unit_dipinjam'],        'sub'=>$stats['menunggu_konfirmasi'].' menunggu konfirmasi','color'=>'yellow','icon'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
            ['label'=>'Unit Tersedia',   'val'=>$stats['unit_tersedia'],        'sub'=>$stats['unit_rusak'].' rusak · '.$stats['unit_diperbaiki'].' diperbaiki','color'=>'green','icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label'=>'Total Siswa',     'val'=>$stats['total_siswa'],          'sub'=>$stats['total_peminjaman'].' total pinjaman','color'=>'purple','icon'=>'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ];
        $colorMap = ['brand'=>['bg'=>'bg-brand-50','text'=>'text-brand-600','num'=>'text-brand-600'], 'yellow'=>['bg'=>'bg-yellow-50','text'=>'text-yellow-600','num'=>'text-yellow-500'], 'green'=>['bg'=>'bg-green-50','text'=>'text-green-600','num'=>'text-green-500'], 'purple'=>['bg'=>'bg-purple-50','text'=>'text-purple-600','num'=>'text-purple-500']];
        @endphp
        @foreach($cards as $c)
        @php $cl = $colorMap[$c['color']]; @endphp
        <div class="card-hover bg-white rounded-2xl border border-gray-100 p-5 animate-fade-up">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-medium text-gray-500">{{ $c['label'] }}</p>
                <div class="w-8 h-8 {{ $cl['bg'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 {{ $cl['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $c['icon'] }}"/></svg>
                </div>
            </div>
            <p class="text-3xl font-extrabold {{ $cl['num'] }} tabular-nums counter" data-target="{{ $c['val'] }}">0</p>
            <p class="text-xs text-gray-400 mt-1">{{ $c['sub'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Alat populer --}}
        <div class="card-hover bg-white rounded-2xl border border-gray-100 p-6 animate-fade-up" style="animation-delay:.2s">
            <h2 class="text-base font-bold text-gray-900 mb-5">🏆 Alat Paling Sering Dipinjam</h2>
            @if($alatPopuler->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">Belum ada data</p>
            @else
                <div class="space-y-3">
                    @foreach($alatPopuler as $i => $alat)
                    <div class="flex items-center gap-3 group">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0 transition-transform group-hover:scale-110
                            {{ $i===0?'bg-yellow-100 text-yellow-700':($i===1?'bg-gray-100 text-gray-600':($i===2?'bg-orange-100 text-orange-700':'bg-gray-50 text-gray-400')) }}">
                            {{ $i+1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $alat->nama_alat }}</p>
                                <p class="text-xs text-gray-400 flex-shrink-0 ml-2">{{ $alat->peminjaman_count }}x</p>
                            </div>
                            {{-- Progress bar animasi --}}
                            @php $max = $alatPopuler->first()->peminjaman_count ?: 1; $pct = round($alat->peminjaman_count/$max*100); @endphp
                            <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-400 rounded-full animate-on-scroll"
                                    style="--bar-w:{{ $pct }}%; animation: bar .8s cubic-bezier(.22,1,.36,1) {{ $loop->index*.1 }}s both"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Riwayat terbaru --}}
        <div class="card-hover bg-white rounded-2xl border border-gray-100 p-6 lg:col-span-2 animate-fade-up" style="animation-delay:.25s">
            <h2 class="text-base font-bold text-gray-900 mb-4">📋 Pengembalian Terbaru</h2>
            @if($riwayatTerbaru->isEmpty())
                <p class="text-gray-400 text-sm text-center py-8">Belum ada pengembalian</p>
            @else
                <div class="space-y-3">
                    @foreach($riwayatTerbaru as $p)
                    <div class="flex items-center gap-3 py-2.5 border-b border-gray-50 last:border-0 group">
                        <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-xs flex-shrink-0 group-hover:scale-110 transition-transform">
                            {{ strtoupper(substr($p->user->name,0,1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $p->user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $p->unit->alat->nama_alat }} · {{ $p->waktu_kembali?->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="text-xs text-green-600 bg-green-50 px-2.5 py-1 rounded-full font-medium flex-shrink-0">Selesai</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Tabel aktif --}}
    <div class="card-hover bg-white rounded-2xl border border-gray-100 animate-fade-up" style="animation-delay:.3s">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900">📦 Peminjaman Aktif</h2>
            <span class="text-xs text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full">{{ $peminjamanAktif->count() }} aktif</span>
        </div>
        @if($peminjamanAktif->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-400 text-sm">Tidak ada peminjaman aktif</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-50">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Siswa</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Waktu Pinjam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($peminjamanAktif as $p)
                        <tr class="hover:bg-brand-50/30 transition-colors duration-150 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 flex items-center justify-center text-brand-600 font-bold text-xs flex-shrink-0 group-hover:scale-110 transition-transform">
                                        {{ strtoupper(substr($p->user->name,0,1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $p->user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $p->user->kelas ?? 'NIS: '.$p->user->nis }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">{{ $p->unit->alat->nama_alat }}</p>
                                <span class="text-xs font-mono text-gray-400">{{ $p->unit->kode_unit }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ $p->waktu_pinjam->format('d M Y, H:i') }}</p>
                                @if($p->isTerlambat())
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-red-600 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                    Terlambat {{ $p->durasiTerlambat() }}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Counter animasi angka --}}
    <script>
    function animateCounter(el) {
        const target = +el.dataset.target;
        if (!target) { el.textContent = 0; return; }
        let start = 0;
        const duration = 800;
        const step = timestamp => {
            if (!start) start = timestamp;
            const progress = Math.min((timestamp - start) / duration, 1);
            el.textContent = Math.floor(progress * target);
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target;
        };
        requestAnimationFrame(step);
    }

    // Jalankan counter saat elemen masuk viewport
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { animateCounter(e.target); observer.unobserve(e.target); } });
    }, { threshold: .3 });
    document.querySelectorAll('.counter').forEach(el => observer.observe(el));
    </script>

</x-app-layout>
