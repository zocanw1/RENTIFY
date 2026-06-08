<x-app-layout title="Scan QR Kamera">
    <div class="max-w-sm mx-auto">

        <div class="mb-6 animate-fade-up">
            <h1 class="text-xl font-bold text-gray-900 text-center">📷 Scan QR Kamera</h1>
            <p class="text-gray-500 text-sm text-center mt-1">Arahkan kamera ke QR code pada alat</p>
        </div>

        {{-- Video kamera --}}
        <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden mb-5 animate-fade-up" style="animation-delay:.06s">
            <div class="relative bg-black aspect-square">
                <video id="qr-video" class="w-full h-full object-cover" playsinline></video>
                {{-- Scanning overlay --}}
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-48 h-48 relative">
                        <div class="absolute top-0 left-0 w-8 h-8 border-t-4 border-l-4 border-brand-400 rounded-tl-lg"></div>
                        <div class="absolute top-0 right-0 w-8 h-8 border-t-4 border-r-4 border-brand-400 rounded-tr-lg"></div>
                        <div class="absolute bottom-0 left-0 w-8 h-8 border-b-4 border-l-4 border-brand-400 rounded-bl-lg"></div>
                        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-4 border-r-4 border-brand-400 rounded-br-lg"></div>
                        {{-- Scan line animasi --}}
                        <div id="scan-line" class="absolute left-0 right-0 h-0.5 bg-brand-400 shadow-lg shadow-brand-400/50" style="top:0;animation:scan-move 2s ease-in-out infinite"></div>
                    </div>
                </div>
                {{-- Status --}}
                <div id="scan-status" class="absolute bottom-3 left-0 right-0 text-center">
                    <span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-full">🔍 Mencari QR code...</span>
                </div>
            </div>
        </div>

        {{-- Result --}}
        <div id="result-box" class="hidden bg-green-50 border border-green-200 rounded-2xl p-4 mb-4 animate-scale-in">
            <p class="text-sm font-semibold text-green-700 mb-1">✅ QR Berhasil Dibaca!</p>
            <p id="result-text" class="text-xs text-green-600 font-mono break-all"></p>
            <p class="text-xs text-green-500 mt-1">Sedang mengarahkan...</p>
        </div>

        {{-- Error --}}
        <div id="error-box" class="hidden bg-red-50 border border-red-200 rounded-2xl p-4 mb-4 animate-fade-up">
            <p id="error-text" class="text-sm text-red-600"></p>
        </div>

        {{-- Tombol --}}
        <div class="flex flex-col gap-2 animate-fade-up" style="animation-delay:.1s">
            <button id="btn-start" onclick="startScan()"
                class="hidden btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition-all shadow-sm text-sm">
                🎥 Mulai Kamera
            </button>
            <button id="btn-stop" onclick="stopScan()" class="hidden w-full border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-3 rounded-xl transition-all text-sm">
                ⏹ Hentikan Kamera
            </button>
            <a href="{{ route('dashboard') }}" class="block w-full text-center text-sm text-gray-400 hover:text-gray-600 py-2 transition-colors">
                Pinjam manual via Dashboard
            </a>
        </div>

        <p class="text-xs text-gray-400 text-center mt-4">
            💡 Kalau kamera tidak jalan, scan QR pakai kamera bawaan HP tetap bisa digunakan
        </p>

    </div>

    {{-- Library jsQR --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>
    <style>
        @keyframes scan-move {
            0%   { top: 0; }
            50%  { top: calc(100% - 2px); }
            100% { top: 0; }
        }
    </style>
    <script>
    const video   = document.getElementById('qr-video');
    const status  = document.getElementById('scan-status');
    const result  = document.getElementById('result-box');
    const errBox  = document.getElementById('error-box');
    const baseUrl = "{{ url('/pinjam/scan') }}";
    let stream = null, animFrame = null, found = false;

    const canvas = document.createElement('canvas');
    const ctx    = canvas.getContext('2d', { willReadFrequently: true });

    async function startScan() {
        found = false;
        result.classList.add('hidden');
        errBox.classList.add('hidden');
        status.innerHTML = '<span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-full">🔄 Menghubungkan kamera...</span>';
        document.getElementById('btn-start').classList.add('hidden');
        document.getElementById('btn-stop').classList.remove('hidden');

        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment', width: { ideal: 640 }, height: { ideal: 640 } }
            });
            video.srcObject = stream;
            await video.play();
            scanFrame();
        } catch(e) {
            showError('Tidak bisa akses kamera: ' + (e.message || e));
            stopScan();
            document.getElementById('btn-start').classList.remove('hidden');
        }
    }

    function scanFrame() {
        if (found) return;
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.width  = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, {
                inversionAttempts: 'dontInvert',
            });
            if (code) {
                found = true;
                const url = code.data;
                document.getElementById('result-text').textContent = url;
                result.classList.remove('hidden');
                status.innerHTML = '<span class="bg-green-600/80 text-white text-xs px-3 py-1.5 rounded-full">✅ QR Ditemukan!</span>';
                stopScan(false);

                // Cek apakah URL dari domain sendiri
                if (url.includes(window.location.hostname)) {
                    setTimeout(() => window.location.href = url, 800);
                } else {
                    // QR bukan dari WePinjam — coba extract kode dari teks
                    const parts = url.split('/');
                    const kode  = parts[parts.length - 1];
                    setTimeout(() => window.location.href = baseUrl + '/' + kode, 800);
                }
                return;
            }
        }
        animFrame = requestAnimationFrame(scanFrame);
    }

    function stopScan(showBtn = true) {
        if (animFrame) cancelAnimationFrame(animFrame);
        if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
        video.srcObject = null;
        if (showBtn) {
            document.getElementById('btn-start').classList.remove('hidden');
            document.getElementById('btn-stop').classList.add('hidden');
            status.innerHTML = '<span class="bg-black/60 text-white text-xs px-3 py-1.5 rounded-full">Kamera dimatikan</span>';
        }
    }

    function showError(msg) {
        errBox.classList.remove('hidden');
        document.getElementById('error-text').textContent = msg;
    }

    // Otomatis mulai saat halaman dibuka
    document.addEventListener('DOMContentLoaded', () => {
        startScan();
    });
    </script>

</x-app-layout>
