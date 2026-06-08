<x-app-layout title="Statistik">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Statistik & Laporan</h1>
            <p class="text-gray-500 text-sm mt-1">Analisis data peminjaman alat</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.laporan.pdf') }}" target="_blank"
                class="btn-ripple inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all">
                📄 Export PDF
            </a>
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl transition-all">
                ← Dashboard
            </a>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 stagger">
        @php
        $cards = [
            ['label'=>'Total Peminjaman',  'val'=>$ringkasan['total_peminjaman'],  'icon'=>'📦', 'bg'=>'from-brand-500 to-brand-600'],
            ['label'=>'Bulan Ini',         'val'=>$ringkasan['bulan_ini'],         'icon'=>'📅', 'bg'=>'from-indigo-500 to-indigo-600'],
            ['label'=>'Siswa Aktif Pinjam','val'=>$ringkasan['total_siswa_aktif'], 'icon'=>'👤', 'bg'=>'from-yellow-400 to-orange-500'],
            ['label'=>'Rata Durasi (Jam)', 'val'=>$ringkasan['rata_durasi'],       'icon'=>'⏱', 'bg'=>'from-green-500 to-green-600'],
        ];
        @endphp
        @foreach($cards as $c)
        <div class="card-hover bg-gradient-to-br {{ $c['bg'] }} rounded-2xl p-5 text-white animate-fade-up">
            <p class="text-2xl mb-1">{{ $c['icon'] }}</p>
            <p class="text-3xl font-extrabold counter" data-target="{{ $c['val'] }}">0</p>
            <p class="text-sm text-white/80 mt-1">{{ $c['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Grafik per bulan + donut status --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        <div class="lg:col-span-2 card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up" style="animation-delay:.1s">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-base font-bold text-gray-900">📈 Peminjaman per Bulan</h2>
                <span class="text-xs text-gray-400 bg-gray-50 px-3 py-1 rounded-full">12 bulan terakhir</span>
            </div>
            {{-- Wrapper penting: position relative + z-index tinggi --}}
            <div style="position:relative;z-index:10;background:transparent">
                <canvas id="chartBulanan" height="100"></canvas>
            </div>
        </div>

        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up" style="animation-delay:.15s">
            <h2 class="text-base font-bold text-gray-900 mb-5">🔵 Status Unit</h2>
            <div style="position:relative;z-index:10;background:transparent">
                <canvas id="chartStatus" height="180"></canvas>
            </div>
            <div class="mt-4 space-y-2">
                @php
                $warnaStatus = ['Tersedia'=>'bg-green-500','Dipinjam'=>'bg-yellow-500','Diperbaiki'=>'bg-orange-500','Rusak'=>'bg-red-500'];
                $totalUnit   = array_sum($statusUnit);
                @endphp
                @foreach($statusUnit as $label => $val)
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $warnaStatus[$label] }}"></span>
                        <span class="text-gray-600">{{ $label }}</span>
                    </div>
                    <span class="font-semibold text-gray-800">
                        {{ $val }}
                        <span class="text-gray-400 font-normal">({{ $totalUnit > 0 ? round($val/$totalUnit*100) : 0 }}%)</span>
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bar alat + bar kelas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up" style="animation-delay:.2s">
            <h2 class="text-base font-bold text-gray-900 mb-5">🏆 Top 10 Alat Terpopuler</h2>
            @if($topAlat->isEmpty())
                <div class="flex items-center justify-center h-40">
                    <p class="text-gray-400 text-sm">Belum ada data peminjaman</p>
                </div>
            @else
            <div style="position:relative;z-index:10;background:transparent">
                <canvas id="chartAlat" height="200"></canvas>
            </div>
            @endif
        </div>

        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up" style="animation-delay:.25s">
            <h2 class="text-base font-bold text-gray-900 mb-5">🎓 Peminjaman per Kelas</h2>
            @if($perKelas->isEmpty())
                <div class="flex items-center justify-center h-40">
                    <p class="text-gray-400 text-sm">Belum ada data kelas</p>
                </div>
            @else
            <div style="position:relative;z-index:10;background:transparent">
                <canvas id="chartKelas" height="200"></canvas>
            </div>
            @endif
        </div>
    </div>

    {{-- Tabel top siswa --}}
    <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-fade-up mb-6" style="animation-delay:.3s">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-base font-bold text-gray-900">👑 Top 10 Siswa Paling Sering Pinjam</h2>
        </div>
        @if($topSiswa->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-400 text-sm">Belum ada data peminjaman</p>
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50 bg-gray-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Rank</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Siswa</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Kelas</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Pinjam</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($topSiswa as $i => $siswa)
                    <tr class="hover:bg-brand-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center text-xs font-bold
                                {{ $i===0?'bg-yellow-100 text-yellow-700':($i===1?'bg-gray-100 text-gray-600':($i===2?'bg-orange-100 text-orange-600':'bg-gray-50 text-gray-400')) }}">
                                {{ $i+1 }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $siswa->fotoUrl() }}" class="w-8 h-8 rounded-full object-cover flex-shrink-0 group-hover:scale-110 transition-transform shadow-sm">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $siswa->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $siswa->nis }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $siswa->kelas ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-extrabold text-brand-600">{{ $siswa->peminjaman_count }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php $max = $topSiswa->first()->peminjaman_count ?: 1; $pct = round($siswa->peminjaman_count/$max*100); @endphp
                            <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-brand-400 rounded-full" style="width:{{ $pct }}%"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Export panel --}}
    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 animate-fade-up" style="animation-delay:.35s">
        <h2 class="text-base font-bold text-gray-900 mb-4">📄 Export Laporan</h2>
        <div class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Filter</label>
                <select id="filterPdf" onchange="updateExportLink()"
                    class="input-focus px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white">
                    <option value="bulan">Per Bulan</option>
                    <option value="tahun">Per Tahun</option>
                    <option value="semua">Semua Data</option>
                </select>
            </div>
            <div id="inputBulan">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Bulan</label>
                <input type="month" id="pdfBulan" value="{{ now()->format('Y-m') }}" onchange="updateExportLink()"
                    class="input-focus px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
            </div>
            <div id="inputTahun" class="hidden">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Tahun</label>
                <input type="number" id="pdfTahun" value="{{ now()->year }}" min="2020" max="2099" onchange="updateExportLink()"
                    class="input-focus px-4 py-2.5 rounded-xl border border-gray-200 text-sm w-28">
            </div>
            <div class="flex gap-2">
                <a id="linkPdf" href="{{ route('admin.laporan.pdf') }}" target="_blank"
                    class="btn-ripple inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all text-sm">
                    📄 PDF
                </a>
                <a id="linkExcel" href="{{ route('admin.riwayat.excel') }}"
                    class="btn-ripple inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all text-sm">
                    📊 Excel
                </a>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    window.addEventListener('load', function() {
        const colors = ['#4f46e5','#06b6d4','#10b981','#f59e0b','#ef4444','#8b5cf6','#ec4899','#f97316','#14b8a6','#84cc16'];

        // Chart bulanan
        const elBulanan = document.getElementById('chartBulanan');
        if (elBulanan) {
            new Chart(elBulanan, {
                type: 'line',
                data: {
                    labels: @json($labelBulan),
                    datasets: [{ label:'Peminjaman', data: @json($dataPinjam), borderColor:'#4f46e5', backgroundColor:'rgba(79,70,229,.08)', borderWidth:2.5, pointBackgroundColor:'#4f46e5', pointRadius:4, pointHoverRadius:6, tension:.4, fill:true }]
                },
                options: { responsive:true, plugins:{ legend:{display:false} }, scales:{ x:{grid:{display:false}}, y:{beginAtZero:true, ticks:{stepSize:1}} } }
            });
        }

        // Chart donut status
        const elStatus = document.getElementById('chartStatus');
        if (elStatus) {
            new Chart(elStatus, {
                type: 'doughnut',
                data: {
                    labels: ['Tersedia','Dipinjam','Diperbaiki','Rusak'],
                    datasets: [{ data: @json(array_values($statusUnit)), backgroundColor:['#10b981','#f59e0b','#f97316','#ef4444'], borderWidth:0, hoverOffset:6 }]
                },
                options: { responsive:true, cutout:'70%', plugins:{ legend:{display:false} } }
            });
        }

        // Chart alat
        const elAlat = document.getElementById('chartAlat');
        if (elAlat) {
            new Chart(elAlat, {
                type: 'bar',
                data: {
                    labels: @json($topAlat->pluck('nama_alat')),
                    datasets: [{ label:'Peminjaman', data: @json($topAlat->pluck('peminjaman_count')), backgroundColor:colors, borderRadius:8, borderSkipped:false }]
                },
                options: { responsive:true, indexAxis:'y', plugins:{legend:{display:false}}, scales:{ x:{beginAtZero:true, ticks:{stepSize:1}}, y:{grid:{display:false}} } }
            });
        }

        // Chart kelas
        const elKelas = document.getElementById('chartKelas');
        if (elKelas) {
            new Chart(elKelas, {
                type: 'bar',
                data: {
                    labels: @json($perKelas->pluck('kelas')),
                    datasets: [{ label:'Peminjaman', data: @json($perKelas->pluck('total')), backgroundColor:colors, borderRadius:8, borderSkipped:false }]
                },
                options: { responsive:true, plugins:{legend:{display:false}}, scales:{ x:{grid:{display:false}}, y:{beginAtZero:true, ticks:{stepSize:1}} } }
            });
        }

        // Counter angka (nama variabel unik supaya tidak bentrok)
        document.querySelectorAll('.counter').forEach(function(el) {
            const tgt = +el.dataset.target;
            if (!tgt) { el.textContent = 0; return; }
            let t0 = null;
            (function tick(ts) {
                if (!t0) t0 = ts;
                const p = Math.min((ts-t0)/900, 1);
                el.textContent = Math.floor(p * tgt);
                if (p < 1) requestAnimationFrame(tick);
                else el.textContent = tgt;
            })(performance.now());
        });
    });

    function updateExportLink() {
        const filter = document.getElementById('filterPdf').value;
        const bulan  = document.getElementById('pdfBulan').value;
        const tahun  = document.getElementById('pdfTahun').value;
        document.getElementById('inputBulan').classList.toggle('hidden', filter !== 'bulan');
        document.getElementById('inputTahun').classList.toggle('hidden', filter !== 'tahun');
        let params = '?filter=' + filter;
        if (filter === 'bulan')  params += '&bulan=' + bulan;
        if (filter === 'tahun')  params += '&tahun=' + tahun;
        document.getElementById('linkPdf').href   = '{{ route("admin.laporan.pdf") }}' + params;
        document.getElementById('linkExcel').href = '{{ route("admin.riwayat.excel") }}' + params;
    }
    </script>

</x-app-layout>
