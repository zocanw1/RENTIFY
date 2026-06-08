<x-guest-layout>
    <div class="w-full max-w-5xl mx-auto px-4 lg:px-8 py-12 bg-slate-50 min-h-screen">
        <div class="relative">
            {{-- Hero Section --}}
            <div class="bg-white border border-gray-200 shadow-md rounded-2xl p-8 mb-8 animate-fade-up">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <div class="flex-1">
                        <span class="inline-flex items-center rounded-full bg-brand-50 text-brand-700 px-4 py-1.5 text-xs font-semibold tracking-wider uppercase mb-4">Selamat Datang</span>
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">RENTIFY</h1>
                        <p class="text-gray-600 text-base lg:text-lg leading-relaxed">Platform peminjaman alat sekolah yang memudahkan siswa dan staf dalam meminjam, mengelola, dan melacak alat praktikum.</p>
                    </div>
                    <div class="lg:self-start">
                        <a href="{{ url('/login') }}" class="inline-flex items-center justify-center rounded-xl bg-brand-600 px-8 py-3 text-base font-semibold text-white hover:bg-brand-700 transition-colors shadow-md whitespace-nowrap">Ayo Pinjam</a>
                    </div>
                </div>
            </div>

            {{-- About Section --}}
            <div class="bg-white border border-gray-200 shadow-md rounded-2xl p-8 mb-8 animate-fade-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tentang Website Ini</h2>
                <p class="text-gray-500 text-sm mb-6">Ringkasan tujuan dan cara penggunaan RENTIFY</p>
            
            <div class="space-y-6 mb-8">
                <p class="text-gray-600 leading-relaxed">RENTIFY dibuat untuk memudahkan proses peminjaman alat praktik di sekolah. Website ini membantu mengurangi antrean, mempercepat pencatatan, dan memastikan unit alat tersedia serta tercatat dengan rapi.</p>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-3">Mengapa Dibuat?</h3>
                        <p class="text-gray-600 leading-relaxed">Pencatatan manual sering membuat alat terlambat dikembalikan, hilang, atau sulit dilacak. Dengan RENTIFY, semua data tercatat digital dan bisa dipantau kapan saja.</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-3">Cara Penggunaan</h3>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600 text-sm">
                            <li>Masuk dengan akun sekolah Anda</li>
                            <li>Pilih alat yang ingin dipinjam</li>
                            <li>Ajukan permintaan peminjaman</li>
                            <li>Pantau status dan kelola peminjaman</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Team Section --}}
        <div class="bg-white border border-gray-200 shadow-md rounded-2xl p-8 animate-fade-up">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Tim Pengembang</h2>
            <p class="text-gray-500 text-sm mb-8">Tim yang membuat dan mengembangkan RENTIFY</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center group">
                    <div class="mb-4 w-full aspect-square rounded-xl bg-slate-50 overflow-hidden border border-gray-200 cursor-pointer photo-card" tabindex="0" role="button" title="Klik untuk pilih foto">
                        <img src="https://via.placeholder.com/200" alt="Raihan" class="w-full h-full object-cover" />
                        <input type="file" accept="image/*" class="photo-input hidden" aria-label="Pilih foto Raihan" />
                    </div>
                    <p class="font-semibold text-gray-900">Raihan</p>
                    <p class="text-xs text-gray-500 mt-1">NIS: 18434/109/065</p>
                    <p class="text-xs text-gray-500">XI SIJA 2</p>
                    <p class="mt-3 inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">Founder</p>
                </div>

                <div class="text-center group">
                    <div class="mb-4 w-full aspect-square rounded-xl bg-slate-50 overflow-hidden border border-gray-200 cursor-pointer photo-card" tabindex="0" role="button" title="Klik untuk pilih foto">
                        <img src="https://via.placeholder.com/200" alt="Nia Amel Putri" class="w-full h-full object-cover" />
                        <input type="file" accept="image/*" class="photo-input hidden" aria-label="Pilih foto Nia Amel Putri" />
                    </div>
                    <p class="font-semibold text-gray-900">Nia Amel Putri</p>
                    <p class="text-xs text-gray-500 mt-1">NIS: 18441/116/065</p>
                    <p class="text-xs text-gray-500">XI SIJA 2</p>
                    <p class="mt-3 inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">Presentation</p>
                </div>

                <div class="text-center group">
                    <div class="mb-4 w-full aspect-square rounded-xl bg-slate-50 overflow-hidden border border-gray-200 cursor-pointer photo-card" tabindex="0" role="button" title="Klik untuk pilih foto">
                        <img src="https://via.placeholder.com/200" alt="Viola Putri Ramadani" class="w-full h-full object-cover" />
                        <input type="file" accept="image/*" class="photo-input hidden" aria-label="Pilih foto Viola Putri Ramadani" />
                    </div>
                    <p class="font-semibold text-gray-900">Viola Putri Ramadani</p>
                    <p class="text-xs text-gray-500 mt-1">NIS: 18460/135/065</p>
                    <p class="text-xs text-gray-500">XI SIJA 2</p>
                    <p class="mt-3 inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">Report Documentation</p>
                </div>

                <div class="text-center group">
                    <div class="mb-4 w-full aspect-square rounded-xl bg-slate-50 overflow-hidden border border-gray-200 cursor-pointer photo-card" tabindex="0" role="button" title="Klik untuk pilih foto">
                        <img src="https://via.placeholder.com/200" alt="Zakiyah Firdausi Abdillah" class="w-full h-full object-cover" />
                        <input type="file" accept="image/*" class="photo-input hidden" aria-label="Pilih foto Zakiyah Firdausi Abdillah" />
                    </div>
                    <p class="font-semibold text-gray-900">Zakiyah Firdausi</p>
                    <p class="text-xs text-gray-500 mt-1">NIS: 18463/138/065</p>
                    <p class="text-xs text-gray-500">XI SIJA 2</p>
                    <p class="mt-3 inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">Supporter</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* 1. SPACING & BREATHING ROOM */
        .max-w-4xl {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .bg-white {
            margin-bottom: 2.5rem !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* 2. TYPOGRAPHY HIERARCHY */
        h1, h2 {
            letter-spacing: -0.5px;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1a202c;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 0.75rem;
            display: inline-block;
        }

        h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #2d3748;
        }

        p {
            line-height: 1.75;
            color: #4a5568;
        }

        .text-gray-600 {
            color: #5a6b7a !important;
            font-size: 1.0625rem;
        }

        /* 3. CARD STYLING - Subtle gradient & better borders */
        .border-gray-200 {
            border-color: #e5e7eb !important;
            border-width: 1.5px;
        }

        .rounded-2xl {
            position: relative;
            overflow: hidden;
        }

        .bg-white {
            background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
            border: 1.5px solid #e5e7eb;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 10px 15px rgba(0, 0, 0, 0.02);
        }

        .bg-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08), 0 15px 25px rgba(0, 0, 0, 0.05);
        }

        .bg-gray-50 {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 1px solid #e5e7eb;
        }

        /* Button Style */
        .bg-brand-600 {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
            font-weight: 600;
            letter-spacing: 0.25px;
        }

        .bg-brand-600:hover {
            background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
            transform: translateY(-1px);
        }

        /* Section spacing */
        .animate-fade-up {
            animation: fadeUp 0.6s ease-out forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up:nth-child(2) {
            animation-delay: 0.1s;
        }

        .animate-fade-up:nth-child(3) {
            animation-delay: 0.2s;
        }

        /* Grid & Layout */
        .grid {
            gap: 2rem !important;
        }

        .text-center {
            text-align: center;
        }

        /* Badge style */
        .inline-flex.rounded-full {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
            border: 1px solid #c7d2fe;
        }

        /* Team card images */
        .aspect-square {
            border: 2px solid #e5e7eb;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }

        /* List styling */
        ol {
            counter-reset: item;
            padding-left: 1.5rem;
        }

        ol li {
            counter-increment: item;
            margin-bottom: 0.75rem;
            color: #4a5568;
            font-weight: 500;
        }

        ol li:before {
            content: counter(item);
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 50%;
            margin-right: 0.75rem;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }
        .photo-card:hover {
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.1);
        }

        .photo-card:focus-visible {
            outline: 2px solid #4f46e5;
            outline-offset: 3px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.photo-card').forEach(function(card) {
                var input = card.querySelector('.photo-input');
                var img = card.querySelector('img');

                card.addEventListener('click', function() {
                    input.click();
                });

                card.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        input.click();
                    }
                });

                input.addEventListener('change', function(event) {
                    var file = event.target.files && event.target.files[0];
                    if (!file || !file.type.startsWith('image/')) {
                        return;
                    }
                    var objectUrl = URL.createObjectURL(file);
                    img.src = objectUrl;
                    img.onload = function() {
                        URL.revokeObjectURL(objectUrl);
                    };
                });
            });
        });
    </script>
</x-guest-layout>