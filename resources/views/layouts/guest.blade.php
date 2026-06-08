<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TEAMS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans','sans-serif'] },
                    colors: { brand: { 50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca' } },
                    keyframes: {
                        'fade-up':     { '0%':{ opacity:'0', transform:'translateY(24px)' }, '100%':{ opacity:'1', transform:'translateY(0)' } },
                        'fade-in':     { '0%':{ opacity:'0' }, '100%':{ opacity:'1' } },
                        'float-a':     { '0%,100%':{ transform:'translateY(0) translateX(0) rotate(0deg)' }, '33%':{ transform:'translateY(-18px) translateX(8px) rotate(3deg)' }, '66%':{ transform:'translateY(-8px) translateX(-6px) rotate(-2deg)' } },
                        'float-b':     { '0%,100%':{ transform:'translateY(0) translateX(0)' }, '50%':{ transform:'translateY(-22px) translateX(10px)' } },
                        'float-c':     { '0%,100%':{ transform:'translateY(0) scale(1)' }, '50%':{ transform:'translateY(-16px) scale(1.06)' } },
                        'orb-drift':   { '0%,100%':{ transform:'translate(0,0) scale(1)' }, '33%':{ transform:'translate(40px,-30px) scale(1.08)' }, '66%':{ transform:'translate(-25px,-50px) scale(.95)' } },
                        'spin-slow':   { '100%':{ transform:'rotate(360deg)' } },
                        'slide-right': { '0%':{ opacity:'0', transform:'translateX(-28px)' }, '100%':{ opacity:'1', transform:'translateX(0)' } },
                    },
                    animation: {
                        'fade-up':     'fade-up .55s cubic-bezier(.22,1,.36,1) both',
                        'fade-in':     'fade-in .45s ease both',
                        'float-a':     'float-a 7s ease-in-out infinite',
                        'float-b':     'float-b 9s ease-in-out infinite',
                        'float-c':     'float-c 6s ease-in-out infinite',
                        'orb-drift':   'orb-drift 12s ease-in-out infinite',
                        'spin-slow':   'spin-slow 18s linear infinite',
                        'slide-right': 'slide-right .5s cubic-bezier(.22,1,.36,1) both',
                    }
                }
            }
        }
    </script>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="TEAMS">
    <style>
        body { opacity:0; transition:opacity .35s ease; }
        body.loaded { opacity:1; }

        .input-focus { transition:border-color .2s, box-shadow .2s; }
        .input-focus:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.14); outline:none; }

        .btn-primary { position:relative; overflow:hidden; transition:transform .15s, box-shadow .2s; }
        .btn-primary:hover { transform:translateY(-1px); box-shadow:0 8px 24px -4px rgba(79,70,229,.45); }
        .btn-primary:active { transform:translateY(0); }

        .stagger > *:nth-child(1){ animation-delay:.08s }
        .stagger > *:nth-child(2){ animation-delay:.16s }
        .stagger > *:nth-child(3){ animation-delay:.24s }
        .stagger > *:nth-child(4){ animation-delay:.32s }
        .stagger > *:nth-child(5){ animation-delay:.40s }
        .stagger > *:nth-child(6){ animation-delay:.48s }
        .stagger > *:nth-child(7){ animation-delay:.56s }

        #left-canvas { position:absolute; inset:0; pointer-events:none; }
    </style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex">

    @php
        $showLeftPanel = !request()->is('/');
    @endphp

    @if($showLeftPanel)
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-brand-700 via-brand-600 to-indigo-700 flex-col justify-between p-12 relative overflow-hidden">

        {{-- Canvas particles di panel kiri --}}
        <canvas id="left-canvas"></canvas>

        {{-- Orbs --}}
        <div class="absolute top-10 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-orb-drift pointer-events-none"></div>
        <div class="absolute bottom-20 right-10 w-56 h-56 bg-indigo-400/20 rounded-full blur-2xl pointer-events-none" style="animation:orb-drift 15s ease-in-out infinite reverse"></div>
        <div class="absolute top-1/2 left-1/3 w-40 h-40 bg-brand-300/15 rounded-full blur-xl pointer-events-none" style="animation:orb-drift 10s ease-in-out infinite 3s"></div>

        {{-- Floating shapes --}}
        <div class="absolute top-[18%] right-[15%] w-10 h-10 border-2 border-white/20 rounded-xl animate-float-a pointer-events-none"></div>
        <div class="absolute top-[35%] left-[10%] w-6 h-6 bg-white/15 rounded-full animate-float-b pointer-events-none" style="animation-delay:-2s"></div>
        <div class="absolute bottom-[30%] right-[8%] w-8 h-8 border border-white/20 rounded-full animate-float-c pointer-events-none" style="animation-delay:-1s"></div>
        <div class="absolute bottom-[15%] left-[15%] w-5 h-5 bg-white/10 rounded-lg animate-float-a pointer-events-none" style="animation-delay:-3s"></div>
        <div class="absolute top-[55%] right-[25%] w-12 h-12 border border-white/15 rounded-2xl animate-spin-slow pointer-events-none"></div>
        <div class="absolute top-[12%] left-[40%] w-4 h-4 bg-white/20 rounded-full animate-float-b pointer-events-none" style="animation-delay:-.5s"></div>

        {{-- Logo --}}
        <div class="animate-slide-right flex items-center gap-2.5 relative z-10">
            <div class="w-9 h-9 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            </div>
            <span class="font-bold text-white text-xl">TEAMS</span>
        </div>

        {{-- Hero --}}
        <div class="relative z-10">
            <div class="animate-fade-up inline-flex items-center gap-2 bg-white/10 backdrop-blur text-white/80 text-xs font-medium px-3 py-1.5 rounded-full mb-6" style="animation-delay:.1s">
                <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                Sistem Aktif & Siap Digunakan
            </div>
            <h1 class="animate-fade-up text-4xl font-extrabold text-white leading-tight mb-4" style="animation-delay:.18s">
                RENTIFY
            </h1>
            <p class="animate-fade-up text-brand-200 text-lg leading-relaxed" style="animation-delay:.26s">
                Pinjam alat dengan mudah, cepat, dan terpantau.
            </p>
            <div class="animate-fade-up mt-8 flex flex-col gap-3" style="animation-delay:.34s">
                @foreach(['📦 Stok alat selalu update otomatis','🔔 Notifikasi pengembalian real-time','👥 Multi-role: Siswa, Admin, Wali Kelas'] as $f)
                <div class="flex items-center gap-3 text-white/80 text-sm">
                    <div class="w-5 h-5 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    {{ $f }}
                </div>
                @endforeach
            </div>
        </div>

        <p class="animate-fade-in text-brand-300/50 text-xs relative z-10" style="animation-delay:.6s">© {{ date('Y') }} TEAMS</p>
    </div>
    @endif

    {{-- ── RIGHT PANEL (form) ───────────────────── --}}
    <div class="{{ $showLeftPanel ? 'w-full lg:w-1/2' : 'w-full' }} flex items-center justify-center p-6 lg:p-12 bg-white relative overflow-hidden">

        {{-- Subtle dot grid --}}
        <div class="absolute inset-0 opacity-[0.025]" style="background-image:radial-gradient(circle,#6366f1 1px,transparent 1px);background-size:28px 28px;"></div>

        {{-- Floating orbs kanan --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-50 rounded-full blur-3xl opacity-60 pointer-events-none animate-orb-drift" style="animation-delay:-5s"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-50 rounded-full blur-2xl opacity-70 pointer-events-none" style="animation:orb-drift 14s ease-in-out infinite -8s"></div>

        {{-- Floating shapes kanan --}}
        <div class="absolute top-[12%] right-[8%] w-8 h-8 border border-brand-200/50 rounded-xl animate-float-a pointer-events-none"></div>
        <div class="absolute bottom-[15%] right-[12%] w-5 h-5 bg-brand-100/80 rounded-full animate-float-b pointer-events-none" style="animation-delay:-1.5s"></div>
        <div class="absolute top-[60%] left-[5%] w-6 h-6 border border-indigo-200/50 rounded-full animate-float-c pointer-events-none" style="animation-delay:-3s"></div>
        <div class="absolute top-[30%] left-[8%] w-4 h-4 bg-purple-100/80 rounded-lg animate-float-a pointer-events-none" style="animation-delay:-2s"></div>

        @php
            $compactGuestPage = request()->is('login','register','forgot-password','reset-password*','verify-email*','confirm-password');
        @endphp
        <div class="w-full {{ $compactGuestPage ? 'max-w-md' : 'max-w-full' }} relative z-10">
            {{-- Mobile logo --}}
            <div class="animate-fade-up lg:hidden flex items-center gap-2 mb-8">
                <div class="w-8 h-8 bg-brand-600 rounded-xl flex items-center justify-center shadow">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                </div>
                <span class="font-bold text-gray-900 text-lg">TEAMS</span>
            </div>

            <div class="animate-fade-up" style="animation-delay:.12s">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', () => document.body.classList.add('loaded'));

// Particle di panel kiri
(function() {
    const canvas = document.getElementById('left-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let W, H, pts = [];

    function resize() {
        const rect = canvas.parentElement.getBoundingClientRect();
        W = canvas.width  = rect.width;
        H = canvas.height = rect.height;
    }
    resize();
    window.addEventListener('resize', () => { resize(); init(); });

    function init() {
        pts = [];
        const n = Math.floor(W * H / 10000);
        for (let i = 0; i < n; i++) {
            pts.push({ x:Math.random()*W, y:Math.random()*H, vx:(Math.random()-.5)*.4, vy:(Math.random()-.5)*.4-.05, r:Math.random()*1.5+.4 });
        }
    }
    init();

    function draw() {
        ctx.clearRect(0,0,W,H);
        for (let i=0;i<pts.length;i++) {
            for (let j=i+1;j<pts.length;j++) {
                const dx=pts[i].x-pts[j].x, dy=pts[i].y-pts[j].y, d=Math.sqrt(dx*dx+dy*dy);
                if (d<100) { ctx.beginPath(); ctx.strokeStyle=`rgba(255,255,255,${.12*(1-d/100)})`; ctx.lineWidth=.7; ctx.moveTo(pts[i].x,pts[i].y); ctx.lineTo(pts[j].x,pts[j].y); ctx.stroke(); }
            }
        }
        pts.forEach(p => {
            p.x+=p.vx; p.y+=p.vy;
            if(p.x<0)p.x=W; if(p.x>W)p.x=0; if(p.y<0)p.y=H; if(p.y>H)p.y=0;
            ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2); ctx.fillStyle='rgba(255,255,255,.35)'; ctx.fill();
        });
        requestAnimationFrame(draw);
    }
    draw();
})();
</script>
</body>
</html>
