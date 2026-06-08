<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Riwayat {{ $user->name }} — TEAMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family:'Plus Jakarta Sans',sans-serif; background:#fff; }
        @media print {
            .no-print { display:none !important; }
            body { print-color-adjust:exact; -webkit-print-color-adjust:exact; }
        }
    </style>
</head>
<body class="bg-white text-gray-900 text-sm">

    <div class="no-print bg-gray-900 text-white px-6 py-3 flex items-center justify-between sticky top-0 z-50">
        <a href="{{ route('admin.riwayat.siswa', $user) }}" class="text-gray-300 hover:text-white text-sm">← Kembali</a>
        <button onclick="window.print()" class="text-xs font-semibold px-4 py-1.5 rounded-lg" style="background:#4f46e5">🖨 Print / Save PDF</button>
    </div>

    <div class="max-w-4xl mx-auto px-8 py-8">
        {{-- Header --}}
        <div class="flex items-start justify-between mb-8 pb-6 border-b-2 border-gray-900">
            <div>
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#4f46e5">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                    </div>
                    <span class="text-xl font-extrabold">TEAMS</span>
                </div>
                <h1 class="text-2xl font-bold">Riwayat Peminjaman Siswa</h1>
                <p class="text-gray-500 mt-1">{{ $user->name }} · {{ $user->kelas ?? '-' }} · NIS: {{ $user->nis }}</p>
            </div>
            <div class="text-right text-xs text-gray-400">
                <p>Dicetak: {{ now()->translatedFormat('d F Y, H:i') }}</p>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            @php
            $statCards = [
                ['label'=>'Total Pinjam','val'=>$stats['total'],'color'=>'#4f46e5'],
                ['label'=>'Selesai',     'val'=>$stats['selesai'],'color'=>'#059669'],
                ['label'=>'Aktif',       'val'=>$stats['aktif'],'color'=>'#d97706'],
                ['label'=>'Terlambat',   'val'=>$stats['terlambat'],'color'=>'#dc2626'],
            ];
            @endphp
            @foreach($statCards as $s)
            <div class="rounded-xl p-4 text-center border-2" style="border-color:{{ $s['color'] }}20;background:{{ $s['color'] }}08">
                <p class="text-2xl font-extrabold" style="color:{{ $s['color'] }}">{{ $s['val'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $s['label'] }}</p>
            </div>
            @endforeach
        </div>

        {{-- Tabel --}}
        @if($riwayats->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-xl"><p class="text-gray-400">Belum ada riwayat peminjaman</p></div>
        @else
        <table class="w-full border-collapse text-xs">
            <thead>
                <tr style="background:#111827;color:white">
                    <th class="text-left px-4 py-3 rounded-tl-lg font-semibold">No</th>
                    <th class="text-left px-4 py-3 font-semibold">Alat</th>
                    <th class="text-left px-4 py-3 font-semibold">Kode Unit</th>
                    <th class="text-left px-4 py-3 font-semibold">Waktu Pinjam</th>
                    <th class="text-left px-4 py-3 font-semibold">Waktu Kembali</th>
                    <th class="text-left px-4 py-3 rounded-tr-lg font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayats as $i => $p)
                <tr class="{{ $i%2===0?'bg-white':'bg-gray-50' }} border-b border-gray-100">
                    <td class="px-4 py-2.5 text-gray-400">{{ $i+1 }}</td>
                    <td class="px-4 py-2.5 font-medium text-gray-900">{{ $p->unit->alat->nama_alat }}</td>
                    <td class="px-4 py-2.5 font-mono text-gray-600">{{ $p->unit->kode_unit }}</td>
                    <td class="px-4 py-2.5 text-gray-600">{{ $p->waktu_pinjam->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-2.5 text-gray-600">{{ $p->waktu_kembali?->format('d/m/Y H:i') ?? '—' }}</td>
                    <td class="px-4 py-2.5">
                        @if($p->status_pengajuan==='selesai')
                            <span style="background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:999px;font-weight:600">Selesai</span>
                        @elseif($p->isTerlambat())
                            <span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:999px;font-weight:600">⚠️ Terlambat</span>
                        @elseif($p->status_pengajuan==='menunggu_konfirmasi')
                            <span style="background:#ffedd5;color:#9a3412;padding:2px 8px;border-radius:999px;font-weight:600">Menunggu</span>
                        @else
                            <span style="background:#fef9c3;color:#854d0e;padding:2px 8px;border-radius:999px;font-weight:600">Aktif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <div class="mt-8 pt-4 border-t border-gray-200 text-center text-xs text-gray-400">
            Digenerate oleh Sistem TEAMS — {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>
</body>
</html>
