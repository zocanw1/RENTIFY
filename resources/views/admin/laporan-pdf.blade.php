<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Peminjaman — TEAMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #fff; }

        @media print {
            .no-print { display: none !important; }
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="bg-white text-gray-900 text-sm">

    {{-- Toolbar (tidak ikut di print) --}}
    <div class="no-print bg-gray-900 text-white px-6 py-3 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.statistik') }}" class="text-gray-300 hover:text-white transition-colors text-sm">← Kembali</a>
            <span class="text-gray-600">|</span>
            <span class="text-sm font-medium">Laporan Peminjaman — {{ $judulPeriode }}</span>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.laporan.pdf') }}?filter={{ $filter }}&bulan={{ $bulan }}&tahun={{ $tahun }}"
                class="text-xs bg-gray-700 hover:bg-gray-600 px-3 py-1.5 rounded-lg transition-colors">
                🔄 Refresh
            </a>
            <button onclick="window.print()"
                class="text-xs bg-brand-600 hover:bg-brand-700 px-4 py-1.5 rounded-lg font-semibold transition-colors" style="background:#4f46e5">
                🖨 Print / Save PDF
            </button>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-8 py-8">

        {{-- Header laporan --}}
        <div class="flex items-start justify-between mb-8 pb-6 border-b-2 border-gray-900">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    </div>
                    <span class="text-xl font-extrabold text-gray-900">TEAMS</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Peminjaman Alat</h1>
                <p class="text-gray-500 mt-1">Periode: <strong>{{ $judulPeriode }}</strong></p>
            </div>
            <div class="text-right text-xs text-gray-400">
                <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
                <p class="mt-1">Sistem TEAMS SMK</p>
            </div>
        </div>

        {{-- Ringkasan statistik --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            @php
            $statCards = [
                ['label'=>'Total Transaksi', 'val'=>$stats['total'],   'color'=>'#4f46e5'],
                ['label'=>'Selesai',          'val'=>$stats['selesai'], 'color'=>'#10b981'],
                ['label'=>'Masih Dipinjam',   'val'=>$stats['aktif'],   'color'=>'#f59e0b'],
                ['label'=>'Menunggu Konfirmasi','val'=>$stats['menunggu'],'color'=>'#f97316'],
            ];
            @endphp
            @foreach($statCards as $s)
            <div class="rounded-xl p-4 text-center border-2" style="border-color:{{ $s['color'] }}20;background:{{ $s['color'] }}08">
                <p class="text-2xl font-extrabold" style="color:{{ $s['color'] }}">{{ $s['val'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Tabel peminjaman --}}
        @if($peminjaman->isEmpty())
            <div class="text-center py-16 bg-gray-50 rounded-2xl">
                <p class="text-gray-400 font-medium">Tidak ada data peminjaman untuk periode ini</p>
            </div>
        @else
            <h2 class="text-base font-bold text-gray-900 mb-3">Detail Peminjaman</h2>
            <table class="w-full border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-900 text-white">
                        <th class="text-left px-4 py-3 rounded-tl-lg font-semibold">No</th>
                        <th class="text-left px-4 py-3 font-semibold">Nama Siswa</th>
                        <th class="text-left px-4 py-3 font-semibold">Kelas</th>
                        <th class="text-left px-4 py-3 font-semibold">NIS</th>
                        <th class="text-left px-4 py-3 font-semibold">Alat</th>
                        <th class="text-left px-4 py-3 font-semibold">Kode Unit</th>
                        <th class="text-left px-4 py-3 font-semibold">Waktu Pinjam</th>
                        <th class="text-left px-4 py-3 font-semibold">Waktu Kembali</th>
                        <th class="text-left px-4 py-3 rounded-tr-lg font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $i => $p)
                    <tr class="{{ $i%2===0 ? 'bg-white' : 'bg-gray-50' }} border-b border-gray-100">
                        <td class="px-4 py-2.5 text-gray-400">{{ $i+1 }}</td>
                        <td class="px-4 py-2.5 font-medium text-gray-900">{{ $p->user->name }}</td>
                        <td class="px-4 py-2.5 text-gray-600">{{ $p->user->kelas ?? '-' }}</td>
                        <td class="px-4 py-2.5 font-mono text-gray-600">{{ $p->user->nis }}</td>
                        <td class="px-4 py-2.5 text-gray-800">{{ $p->unit->alat->nama_alat }}</td>
                        <td class="px-4 py-2.5 font-mono text-gray-600">{{ $p->unit->kode_unit }}</td>
                        <td class="px-4 py-2.5 text-gray-600">{{ $p->waktu_pinjam->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2.5 text-gray-600">{{ $p->waktu_kembali ? $p->waktu_kembali->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-2.5">
                            @if($p->status_pengajuan === 'selesai')
                                <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">Selesai</span>
                            @elseif($p->status_pengajuan === 'menunggu_konfirmasi')
                                <span class="bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-medium">Menunggu</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full font-medium">Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Footer tanda tangan --}}
            <div class="mt-12 flex justify-end">
                <div class="text-center text-xs text-gray-600">
                    <p>Mengetahui,</p>
                    <p class="mt-1">Admin TEAMS</p>
                    <div class="mt-16 border-t border-gray-400 w-40">
                        <p class="mt-1">( _________________ )</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-8 pt-4 border-t border-gray-200 text-center text-xs text-gray-400">
            Digenerate oleh Sistem TEAMS — {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

</body>
</html>
