<x-app-layout :title="'Riwayat ' . $user->name">

    <div class="mb-8 flex items-center gap-3 animate-fade-up">
        <a href="{{ route('admin.riwayat.index') }}"
            class="w-9 h-9 rounded-xl bg-white/80 backdrop-blur border border-gray-200 flex items-center justify-center hover:bg-white hover:shadow-sm hover:-translate-x-0.5 transition-all">
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman Siswa</h1>
            <p class="text-gray-500 text-sm">{{ $user->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.riwayat.siswa.pdf', $user) }}" target="_blank"
                class="btn-ripple inline-flex items-center gap-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition-all">
                📄 PDF
            </a>
            <a href="{{ route('admin.riwayat.siswa.excel', $user) }}"
                class="btn-ripple inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold px-4 py-2 rounded-xl shadow-sm transition-all">
                📊 Excel
            </a>
        </div>
    </div>

    {{-- Profil siswa --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 mb-6 flex items-center gap-4 card-hover animate-fade-up" style="animation-delay:.05s">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-extrabold text-xl shadow-md flex-shrink-0">
            {{ strtoupper(substr($user->name,0,1)) }}
        </div>
        <div class="flex-1">
            <p class="text-base font-bold text-gray-900">{{ $user->name }}</p>
            <p class="text-sm text-gray-500">NIS: {{ $user->nis }} · {{ $user->kelas ?? '-' }} · {{ $user->email }}</p>
        </div>
        {{-- Statistik mini --}}
        <div class="flex gap-4 text-center">
            <div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $stats['total'] }}</p>
                <p class="text-xs text-gray-400">Total</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-green-600">{{ $stats['selesai'] }}</p>
                <p class="text-xs text-gray-400">Selesai</p>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-yellow-500">{{ $stats['aktif'] }}</p>
                <p class="text-xs text-gray-400">Aktif</p>
            </div>
        </div>
    </div>

    {{-- Riwayat --}}
    @if($riwayats->isEmpty())
    <div class="text-center py-16 bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-scale-in">
        <p class="text-gray-400">Siswa ini belum pernah meminjam alat</p>
    </div>
    @else
    <div class="space-y-3 stagger">
        @foreach($riwayats as $p)
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 animate-fade-up group">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <p class="font-semibold text-gray-900 group-hover:text-brand-700 transition-colors">{{ $p->unit->alat->nama_alat }}</p>
                        <span class="font-mono text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-md">{{ $p->unit->kode_unit }}</span>
                    </div>
                    <div class="flex flex-wrap gap-3 text-xs text-gray-400">
                        <span>📅 Pinjam: {{ $p->waktu_pinjam->format('d M Y, H:i') }}</span>
                        @if($p->waktu_kembali)
                        <span>✅ Kembali: {{ $p->waktu_kembali->format('d M Y, H:i') }}</span>
                        @php $durasi = $p->waktu_pinjam->diffForHumans($p->waktu_kembali, true); @endphp
                        <span>⏱ Durasi: {{ $durasi }}</span>
                        @endif
                    </div>
                    @if($p->komentar_siswa)
                    <div class="mt-2 bg-blue-50 rounded-xl px-3 py-2 text-xs text-blue-700">
                        💬 {{ $p->komentar_siswa }}
                    </div>
                    @endif
                    @if($p->balasan_admin)
                    <div class="mt-1 bg-green-50 rounded-xl px-3 py-2 text-xs text-green-700">
                        🛡 {{ $p->balasan_admin }}
                    </div>
                    @endif
                </div>
                <div class="flex-shrink-0">
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
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</x-app-layout>
