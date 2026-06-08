<x-app-layout :title="'Laporan ' . $alat->nama_alat">
    <div class="mb-6 flex items-center gap-3 animate-fade-up">
        <a href="{{ route('admin.alat.show', $alat) }}" class="w-9 h-9 rounded-xl bg-white/80 backdrop-blur border border-gray-200 flex items-center justify-center hover:bg-white hover:-translate-x-0.5 transition-all">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Alat</h1>
            <p class="text-gray-500 text-sm">{{ $alat->nama_alat }}</p>
        </div>
    </div>

    {{-- Info alat + statistik --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 mb-6 flex items-center gap-5 flex-wrap card-hover animate-fade-up" style="animation-delay:.05s">
        @if($alat->foto)
        <img src="{{ asset('storage/'.$alat->foto) }}" class="w-20 h-20 object-cover rounded-2xl border border-gray-100 flex-shrink-0">
        @endif
        <div class="flex-1">
            <h2 class="text-lg font-bold text-gray-900">{{ $alat->nama_alat }}</h2>
            <p class="text-sm text-gray-500">{{ $alat->units->count() }} unit terdaftar</p>
        </div>
        <div class="flex gap-5 text-center">
            <div><p class="text-2xl font-extrabold text-brand-600 counter" data-target="{{ $stats['total'] }}">0</p><p class="text-xs text-gray-400">Total Pinjam</p></div>
            <div><p class="text-2xl font-extrabold text-green-600 counter" data-target="{{ $stats['selesai'] }}">0</p><p class="text-xs text-gray-400">Selesai</p></div>
            <div><p class="text-2xl font-extrabold text-yellow-500 counter" data-target="{{ $stats['aktif'] }}">0</p><p class="text-xs text-gray-400">Aktif</p></div>
            <div><p class="text-2xl font-extrabold text-purple-600 counter" data-target="{{ $stats['peminjam'] }}">0</p><p class="text-xs text-gray-400">Peminjam Unik</p></div>
        </div>
    </div>

    {{-- Riwayat peminjaman alat --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.1s">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900">Riwayat Peminjaman</h2>
            <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">{{ $peminjaman->count() }} transaksi</span>
        </div>
        @if($peminjaman->isEmpty())
        <div class="text-center py-12"><p class="text-gray-400 text-sm">Belum ada yang pernah meminjam alat ini</p></div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50 bg-gray-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Siswa</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Unit</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Pinjam</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Kembali</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($peminjaman as $p)
                    <tr class="hover:bg-brand-50/20 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $p->user->fotoUrl() }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0 group-hover:scale-110 transition-transform">
                                <div>
                                    <a href="{{ route('admin.riwayat.siswa', $p->user) }}" class="text-sm font-medium text-gray-900 hover:text-brand-600 transition-colors">{{ $p->user->name }}</a>
                                    <p class="text-xs text-gray-400">{{ $p->user->kelas ?? $p->user->nis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4"><span class="font-mono text-sm text-gray-600">{{ $p->unit->kode_unit }}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->waktu_pinjam->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $p->waktu_kembali?->format('d M Y, H:i') ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($p->status_pengajuan==='selesai') <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700">Selesai</span>
                            @elseif($p->status_pengajuan==='menunggu_konfirmasi') <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-orange-50 text-orange-700">Menunggu</span>
                            @else <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700">Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>
