<x-app-layout title="Riwayat Semua Peminjaman">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Semua Peminjaman</h1>
            <p class="text-gray-500 text-sm mt-1">Semua transaksi peminjaman dari seluruh siswa</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.laporan.pdf') }}" target="_blank"
                class="btn-ripple inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition-all">
                📄 PDF
            </a>
            <a href="{{ route('admin.riwayat.excel') }}" 
                class="btn-ripple inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition-all">
                📊 Excel
            </a>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl transition-all">
                ← Dashboard
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-4 mb-6 animate-fade-up" style="animation-delay:.06s">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Cari Siswa</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                    <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Nama atau NIS..."
                        class="input-focus w-full pl-9 pr-4 py-2 rounded-xl border border-gray-200 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Status</label>
                <select name="status" class="input-focus px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white">
                    <option value="">Semua</option>
                    <option value="aktif" {{ request('status')==='aktif'?'selected':'' }}>Aktif</option>
                    <option value="menunggu_konfirmasi" {{ request('status')==='menunggu_konfirmasi'?'selected':'' }}>Menunggu</option>
                    <option value="selesai" {{ request('status')==='selesai'?'selected':'' }}>Selesai</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Kelas</label>
                <select name="kelas" class="input-focus px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                    <option value="{{ $k }}" {{ request('kelas')===$k?'selected':'' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Bulan</label>
                <input type="month" name="bulan" value="{{ request('bulan') }}"
                    class="input-focus px-3 py-2 rounded-xl border border-gray-200 text-sm">
            </div>
            <button type="submit" class="btn-ripple px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">
                Filter
            </button>
            @if(request()->hasAny(['cari','status','kelas','bulan']))
            <a href="{{ route('admin.riwayat.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-red-500 border border-gray-200 rounded-xl transition-all">Reset</a>
            @endif
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.1s">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <span class="text-sm font-semibold text-gray-700">{{ $riwayats->total() }} total transaksi</span>
            <span class="text-xs text-gray-400">Halaman {{ $riwayats->currentPage() }} dari {{ $riwayats->lastPage() }}</span>
        </div>

        @if($riwayats->isEmpty())
        <div class="text-center py-16">
            <p class="text-gray-400">Tidak ada data yang cocok</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50 bg-gray-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Siswa</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Alat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Pinjam</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Kembali</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($riwayats as $p)
                    <tr class="hover:bg-brand-50/20 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0 group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($p->user->name,0,1)) }}
                                </div>
                                <div>
                                    <a href="{{ route('admin.riwayat.siswa', $p->user) }}"
                                        class="text-sm font-medium text-gray-900 hover:text-brand-600 transition-colors">
                                        {{ $p->user->name }}
                                    </a>
                                    <p class="text-xs text-gray-400">{{ $p->user->kelas ?? 'NIS: '.$p->user->nis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $p->unit->alat->nama_alat }}</p>
                            <span class="text-xs font-mono text-gray-400">{{ $p->unit->kode_unit }}</span>
                        </td>
                        <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ $p->waktu_pinjam->format('d M Y') }}</p>
                                <span class="text-xs text-gray-400">{{ $p->waktu_pinjam->format('H:i') }}</span>
                                @if($p->isTerlambat() && $p->status_pengajuan !== 'selesai')
                                <br><span class="text-xs font-bold text-red-600">⚠️ Terlambat</span>
                                @endif
                            </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $p->waktu_kembali ? $p->waktu_kembali->format('d M Y') : '—' }}
                            @if($p->waktu_kembali)<br><span class="text-xs text-gray-400">{{ $p->waktu_kembali->format('H:i') }}</span>@endif
                        </td>
                        <td class="px-6 py-4">
                            @if($p->status_pengajuan === 'selesai')
                                <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700">✓ Selesai</span>
                            @elseif($p->status_pengajuan === 'menunggu_konfirmasi')
                                <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-orange-50 text-orange-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>Menunggu
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-ping-slow"></span>Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-2">
                                @if($p->status_pengajuan === 'menunggu_konfirmasi')
                                <div x-data="{ open: false }" class="relative">
                                    <button onclick="toggleKonfirmasi({{ $p->id }})"
                                        class="btn-ripple text-xs font-semibold bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg transition-all whitespace-nowrap">
                                        ✓ Konfirmasi
                                    </button>
                                </div>
                                @endif
                                <a href="{{ route('admin.riwayat.siswa', $p->user) }}"
                                    class="text-xs text-brand-600 hover:text-brand-700 font-medium transition-colors whitespace-nowrap">
                                    Riwayat siswa →
                                </a>
                                @if($p->status_pengajuan === 'selesai')
                                <form action="{{ route('admin.riwayat.hapus', $p->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus data riwayat ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="text-xs font-medium text-red-400 hover:text-red-600 border border-red-100 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-all whitespace-nowrap">
                                        🗑 Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($riwayats->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $riwayats->links() }}
        </div>
        @endif
        @endif
    </div>


    {{-- Modal konfirmasi per item di riwayat --}}
    @foreach($riwayats as $p)
    @if($p->status_pengajuan === 'menunggu_konfirmasi')
    <div id="modal-konfirmasi-{{ $p->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 animate-scale-in">
            <h3 class="text-lg font-bold text-gray-900 mb-1">Konfirmasi Pengembalian</h3>
            <p class="text-sm text-gray-500 mb-4">
                <span class="font-semibold text-gray-700">{{ $p->user->name }}</span> mengembalikan
                <span class="font-semibold text-gray-700">{{ $p->unit->alat->nama_alat }}</span>
                <span class="font-mono text-gray-400">({{ $p->unit->kode_unit }})</span>
            </p>
            @if($p->komentar_siswa)
            <div class="mb-4 bg-blue-50 rounded-xl px-4 py-3 text-xs text-blue-800">
                💬 <span class="font-semibold">Komentar siswa:</span> {{ $p->komentar_siswa }}
            </div>
            @endif
            <form action="{{ route('admin.konfirmasi.kembali', $p->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Balasan Admin <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="balasan_admin" rows="2" placeholder="Contoh: Alat sudah diterima dengan baik..."
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm resize-none transition-all"></textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit"
                        class="btn-ripple flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 rounded-xl transition-all text-sm shadow-sm">
                        ✓ Konfirmasi Pengembalian
                    </button>
                    <button type="button" onclick="tutupKonfirmasi({{ $p->id }})"
                        class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-2.5 rounded-xl transition-all text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @endforeach

    <script>
    function toggleKonfirmasi(id) {
        const m = document.getElementById('modal-konfirmasi-' + id);
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function tutupKonfirmasi(id) {
        const m = document.getElementById('modal-konfirmasi-' + id);
        m.style.opacity = '0';
        m.style.transition = 'opacity .2s';
        setTimeout(() => { m.classList.add('hidden'); m.style.opacity = ''; m.style.transition = ''; }, 200);
        document.body.style.overflow = '';
    }
    document.querySelectorAll('[id^="modal-konfirmasi-"]').forEach(m => {
        m.addEventListener('click', e => {
            if (e.target === m) tutupKonfirmasi(m.id.replace('modal-konfirmasi-',''));
        });
    });
    </script>

</x-app-layout>
