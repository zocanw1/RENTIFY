<x-app-layout title="Dashboard">

    <div class="mb-8 animate-fade-up">
        <h1 class="text-2xl font-bold text-gray-900">
            @if($user->isKetuaTjkt()) Dashboard Ketua Jurusan TJKT
            @elseif($user->isKetuaSija()) Dashboard Ketua Jurusan SIJA
            @elseif($user->isWaliKelas()) Dashboard Wali Kelas {{ $user->kelas }}
            @endif
        </h1>
        <p class="text-gray-500 text-sm mt-1">Siswa yang sedang meminjam alat</p>
    </div>

    <div class="mb-5 flex items-center justify-between animate-fade-up" style="animation-delay:.06s">
        <div class="flex items-center gap-2">
            @if($siswaSedangPinjam->count() > 0)
            <span class="relative flex h-3 w-3">
                <span class="animate-ping-slow absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
            </span>
            @endif
            <span class="text-sm text-gray-500 font-medium">{{ $siswaSedangPinjam->count() }} siswa sedang pinjam</span>
        </div>
        <a href="{{ route('staff.siswas') }}"
            class="btn-ripple inline-flex items-center gap-2 text-sm text-brand-600 font-medium border border-brand-200 hover:bg-brand-50 px-4 py-2 rounded-xl transition-all">
            Lihat Semua Siswa →
        </a>
    </div>

    @if($siswaSedangPinjam->isEmpty())
        <div class="text-center py-20 bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-scale-in">
            <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada siswa yang sedang meminjam</p>
        </div>
    @else
        <div class="space-y-4 stagger">
            @foreach($siswaSedangPinjam as $siswa)
            <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 animate-fade-up group">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 group-hover:scale-110 transition-transform duration-200 shadow-sm">
                        {{ strtoupper(substr($siswa->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">{{ $siswa->name }}</p>
                        <p class="text-xs text-gray-400">NIS: {{ $siswa->nis }} · {{ $siswa->kelas }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-yellow-50 text-yellow-700 flex-shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-ping-slow"></span>
                        Sedang Pinjam
                    </span>
                </div>
                <div class="space-y-2">
                    @foreach($siswa->peminjaman as $p)
                    <div class="flex items-center gap-3 bg-gray-50 hover:bg-brand-50/50 rounded-xl px-4 py-2.5 transition-colors group/item">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 group-hover/item:text-brand-700 transition-colors">{{ $p->unit->alat->nama_alat }}</p>
                            <p class="text-xs text-gray-400 font-mono">{{ $p->unit->kode_unit }} · Dipinjam {{ $p->waktu_pinjam->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    @endif

</x-app-layout>
