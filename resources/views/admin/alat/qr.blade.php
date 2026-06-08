<x-app-layout title="QR Code Unit">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 no-print animate-fade-up">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.alat.show', $alat) }}"
                class="w-9 h-9 rounded-xl bg-white/80 backdrop-blur border border-gray-200 flex items-center justify-center hover:bg-white hover:shadow-sm hover:-translate-x-0.5 transition-all">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">QR Code Unit</h1>
                <p class="text-gray-500 text-sm">{{ $alat->nama_alat }} — {{ $alat->units->count() }} unit</p>
            </div>
        </div>
        <button onclick="window.print()"
            class="btn-ripple no-print inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl shadow-sm transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            🖨 Print Semua QR
        </button>
    </div>

    {{-- Instruksi --}}
    <div class="no-print mb-6 bg-brand-50/80 backdrop-blur border border-brand-100 rounded-2xl p-4 animate-fade-up" style="animation-delay:.06s">
        <p class="text-sm font-semibold text-brand-700 mb-2">📋 Cara pakai QR Code ini:</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs text-brand-600">
            <div class="flex items-start gap-2">
                <span class="w-5 h-5 rounded-full bg-brand-200 text-brand-700 flex items-center justify-center font-bold flex-shrink-0">1</span>
                <p>Print halaman ini → gunting tiap kotak QR</p>
            </div>
            <div class="flex items-start gap-2">
                <span class="w-5 h-5 rounded-full bg-brand-200 text-brand-700 flex items-center justify-center font-bold flex-shrink-0">2</span>
                <p>Tempel QR di unit fisik alat yang sesuai kodenya</p>
            </div>
            <div class="flex items-start gap-2">
                <span class="w-5 h-5 rounded-full bg-brand-200 text-brand-700 flex items-center justify-center font-bold flex-shrink-0">3</span>
                <p>Siswa scan → langsung muncul form pinjam → submit → selesai!</p>
            </div>
        </div>
    </div>

    {{-- URL info --}}
    <div class="no-print mb-4 animate-fade-up" style="animation-delay:.08s">
        <p class="text-xs text-gray-400">URL scan: <span class="font-mono text-gray-600">{{ url('/pinjam/scan') }}/{kode_unit}</span></p>
    </div>

    {{-- Grid QR --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 stagger" id="qr-grid">
        @foreach($alat->units as $unit)
        <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 text-center qr-card animate-fade-up group">

            {{-- QR Code container --}}
            <div id="qr-{{ $unit->id }}" class="flex justify-center mb-3 group-hover:scale-105 transition-transform duration-300"></div>

            {{-- Info unit --}}
            <p class="font-bold text-gray-900 text-sm">{{ $alat->nama_alat }}</p>
            <p class="font-mono text-xs text-brand-600 mt-0.5 font-semibold">{{ $unit->kode_unit }}</p>

            {{-- Status badge --}}
            <span class="inline-flex items-center gap-1 mt-2 text-xs font-medium px-2.5 py-1 rounded-full
                {{ $unit->status === 'Tersedia' ? 'bg-green-50 text-green-700' :
                   ($unit->status === 'Dipinjam' ? 'bg-yellow-50 text-yellow-700' :
                   ($unit->status === 'Diperbaiki' ? 'bg-orange-50 text-orange-700' : 'bg-red-50 text-red-700')) }}">
                <span class="w-1 h-1 rounded-full
                    {{ $unit->status === 'Tersedia' ? 'bg-green-500' :
                       ($unit->status === 'Dipinjam' ? 'bg-yellow-500' :
                       ($unit->status === 'Diperbaiki' ? 'bg-orange-500' : 'bg-red-500')) }}"></span>
                {{ $unit->status }}
            </span>

            {{-- URL --}}
            <p class="text-xs text-gray-300 mt-2 break-all font-mono" style="font-size:9px">
                {{ url('/pinjam/scan/' . $unit->kode_unit) }}
            </p>
        </div>
        @endforeach
    </div>

    {{-- Load QR library & generate --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
    const baseUrl = "{{ url('/pinjam/scan') }}";
    const units = @json($alat->units->map(fn($u) => ['id' => $u->id, 'kode' => $u->kode_unit]));

    units.forEach((unit, i) => {
        setTimeout(() => {
            new QRCode(document.getElementById("qr-" + unit.id), {
                text: baseUrl + "/" + unit.kode,
                width: 140,
                height: 140,
                colorDark: "#111827",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.M,
            });
        }, i * 80); // Stagger QR generation biar keliatan animasinya
    });
    </script>

    <style>
        @media print {
            .no-print { display: none !important; }
            nav { display: none !important; }
            #bg-canvas { display: none !important; }
            .bg-shape { display: none !important; }
            main { padding: 0 !important; }
            #qr-grid {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 12px !important;
            }
            .qr-card {
                break-inside: avoid !important;
                border: 1.5px solid #e5e7eb !important;
                border-radius: 12px !important;
                padding: 16px !important;
                background: white !important;
            }
            body { background: white !important; }
        }
    </style>

</x-app-layout>
