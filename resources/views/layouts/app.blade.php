<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TEAMS') }} — {{ $title ?? 'Dashboard' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: { brand: { 50:'#eef2ff', 100:'#e0e7ff', 200:'#c7d2fe', 400:'#818cf8', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca' } },
                    keyframes: {
                        'fade-up':   { '0%': { opacity:'0', transform:'translateY(20px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                        'fade-in':   { '0%': { opacity:'0' }, '100%': { opacity:'1' } },
                        'scale-in':  { '0%': { opacity:'0', transform:'scale(0.93)' }, '100%': { opacity:'1', transform:'scale(1)' } },
                        'float-a':   { '0%,100%': { transform:'translateY(0px) translateX(0px) rotate(0deg)' }, '33%': { transform:'translateY(-18px) translateX(8px) rotate(3deg)' }, '66%': { transform:'translateY(-8px) translateX(-6px) rotate(-2deg)' } },
                        'float-b':   { '0%,100%': { transform:'translateY(0px) translateX(0px) rotate(0deg)' }, '33%': { transform:'translateY(14px) translateX(-10px) rotate(-3deg)' }, '66%': { transform:'translateY(-10px) translateX(12px) rotate(2deg)' } },
                        'float-c':   { '0%,100%': { transform:'translateY(0px) scale(1)' }, '50%': { transform:'translateY(-22px) scale(1.05)' } },
                        'orb-drift': { '0%,100%': { transform:'translate(0,0) scale(1)' }, '25%': { transform:'translate(40px,-30px) scale(1.08)' }, '50%': { transform:'translate(-20px,-50px) scale(.95)' }, '75%': { transform:'translate(-40px,20px) scale(1.04)' } },
                        'spin-slow': { '0%': { transform:'rotate(0deg)' }, '100%': { transform:'rotate(360deg)' } },
                        'ping-slow': { '0%': { transform:'scale(1)', opacity:'1' }, '75%,100%': { transform:'scale(1.8)', opacity:'0' } },
                        'bar':       { '0%': { width:'0%' }, '100%': { width:'var(--bar-w)' } },
                        'shimmer':   { '0%': { backgroundPosition:'-200% 0' }, '100%': { backgroundPosition:'200% 0' } },
                    },
                    animation: {
                        'fade-up':   'fade-up .45s cubic-bezier(.22,1,.36,1) both',
                        'fade-in':   'fade-in .35s ease both',
                        'scale-in':  'scale-in .35s cubic-bezier(.22,1,.36,1) both',
                        'float-a':   'float-a 7s ease-in-out infinite',
                        'float-b':   'float-b 9s ease-in-out infinite',
                        'float-c':   'float-c 6s ease-in-out infinite',
                        'orb-drift': 'orb-drift 12s ease-in-out infinite',
                        'spin-slow': 'spin-slow 20s linear infinite',
                        'ping-slow': 'ping-slow 2s cubic-bezier(0,0,.2,1) infinite',
                        'bar':       'bar .8s cubic-bezier(.22,1,.36,1) both',
                    },
                }
            }
        }
    </script>
    {{-- PWA --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#4f46e5">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="TEAMS">
    <style>

        /* ── Dark mode ── */
        :root { color-scheme: light; }
        html.dark { color-scheme: dark; }
        html.dark body { background: #0f0f1a; color: #e5e7eb; }
        html.dark nav { background: rgba(15,15,26,.85) !important; border-color: rgba(255,255,255,.06) !important; }
        html.dark .bg-white\/80, html.dark .bg-white { background: rgba(24,24,40,.85) !important; }
        html.dark .bg-white { background: rgba(24,24,40,.9) !important; }
        html.dark .border-gray-100 { border-color: rgba(255,255,255,.07) !important; }
        html.dark .border-gray-200 { border-color: rgba(255,255,255,.1) !important; }
        html.dark .text-gray-900 { color: #f1f1f5 !important; }
        html.dark .text-gray-700 { color: #d1d5db !important; }
        html.dark .text-gray-600 { color: #9ca3af !important; }
        html.dark .text-gray-500 { color: #6b7280 !important; }
        html.dark .text-gray-400 { color: #4b5563 !important; }
        html.dark .bg-gray-50, html.dark .bg-gray-100 { background: rgba(255,255,255,.04) !important; }
        html.dark .bg-gray-50\/50 { background: rgba(255,255,255,.03) !important; }
        html.dark .divide-gray-50 > * { border-color: rgba(255,255,255,.05) !important; }
        html.dark input, html.dark select, html.dark textarea {
            background: rgba(255,255,255,.05) !important;
            border-color: rgba(255,255,255,.1) !important;
            color: #f1f1f5 !important;
        }
        html.dark .card-hover:hover { box-shadow: 0 16px 32px -8px rgba(0,0,0,.5), 0 4px 12px -4px rgba(79,70,229,.2) !important; }
        html.dark #bg-canvas { opacity: .6; }

        /* ── Page load ── */
        body { opacity:0; transition:opacity .3s ease; background:#f8f8fc; }
        body.loaded { opacity:1; }

        /* ── Live background canvas ── */
        #bg-canvas { position:fixed; inset:0; pointer-events:none; z-index:0; }

        /* ── Floating shapes ── */
        .bg-shape {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 1s ease;
        }
        body.loaded .bg-shape { opacity: 1; }

        /* ── Content above bg ── */
        nav, main, #nprogress, #toast-success, #toast-error { position:relative; z-index:10; }

        /* ── Navbar glass ── */
        nav { background:rgba(255,255,255,.82); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }

        /* ── Progress bar ── */
        #nprogress { position:fixed; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#6366f1,#a78bfa,#6366f1); background-size:200%; animation:shimmer 1.5s linear infinite; z-index:9999; border-radius:0 3px 3px 0; transition:width .3s ease, opacity .4s; }

        /* ── Stagger ── */
        .stagger > * { opacity:0; animation:fade-up .45s cubic-bezier(.22,1,.36,1) both; }
        .stagger > *:nth-child(1)  { animation-delay:.04s }
        .stagger > *:nth-child(2)  { animation-delay:.08s }
        .stagger > *:nth-child(3)  { animation-delay:.12s }
        .stagger > *:nth-child(4)  { animation-delay:.16s }
        .stagger > *:nth-child(5)  { animation-delay:.20s }
        .stagger > *:nth-child(6)  { animation-delay:.24s }
        .stagger > *:nth-child(7)  { animation-delay:.28s }
        .stagger > *:nth-child(8)  { animation-delay:.32s }
        .stagger > *:nth-child(9)  { animation-delay:.36s }
        .stagger > *:nth-child(10) { animation-delay:.40s }
        .stagger > *:nth-child(11) { animation-delay:.44s }
        .stagger > *:nth-child(12) { animation-delay:.48s }

        /* ── Card hover ── */
        .card-hover { transition:transform .25s cubic-bezier(.22,1,.36,1), box-shadow .25s ease; }
        .card-hover:hover { transform:translateY(-5px); box-shadow:0 16px 32px -8px rgba(79,70,229,.16), 0 4px 12px -4px rgba(79,70,229,.08); }

        /* ── Button ── */
        .btn-ripple { position:relative; overflow:hidden; transition:transform .15s, box-shadow .2s; }
        .btn-ripple:hover { transform:translateY(-1px); }
        .btn-ripple:active { transform:translateY(0); }
        .btn-ripple::after { content:''; position:absolute; inset:0; background:white; opacity:0; border-radius:inherit; transition:opacity .3s; }
        .btn-ripple:active::after { opacity:.18; transition:none; }

        /* ── Input ── */
        .input-focus { transition:border-color .2s, box-shadow .2s; }
        .input-focus:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.14); outline:none; }

        /* ── Nav link underline ── */
        .nav-link { position:relative; }
        .nav-link::after { content:''; position:absolute; bottom:-2px; left:50%; right:50%; height:2px; background:#4f46e5; border-radius:2px; transition:left .22s ease, right .22s ease; }
        .nav-link.active::after, .nav-link:hover::after { left:0; right:0; }

        /* ── Toast ── */
        .toast { animation:fade-down .4s cubic-bezier(.22,1,.36,1) both; }
        @keyframes fade-down { 0%{opacity:0;transform:translateX(-50%) translateY(-16px)} 100%{opacity:1;transform:translateX(-50%) translateY(0)} }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">

{{-- ═══ LIVE BACKGROUND ═══ --}}
<canvas id="bg-canvas"></canvas>

{{-- Floating shapes (CSS animated, no JS needed) --}}
<div class="bg-shape w-96 h-96 bg-brand-400/[0.07] blur-3xl animate-orb-drift" style="top:-80px;left:-80px;animation-delay:0s"></div>
<div class="bg-shape w-80 h-80 bg-purple-400/[0.06] blur-3xl animate-orb-drift" style="bottom:-60px;right:-60px;animation-delay:-4s"></div>
<div class="bg-shape w-64 h-64 bg-indigo-300/[0.06] blur-2xl animate-orb-drift" style="top:40%;left:55%;animation-delay:-7s"></div>

{{-- Floating geometric shapes --}}
<div class="bg-shape w-8 h-8 border-2 border-brand-300/30 rounded-lg animate-float-a" style="top:15%;left:8%;animation-delay:0s"></div>
<div class="bg-shape w-5 h-5 bg-brand-400/20 rounded-full animate-float-b" style="top:25%;right:12%;animation-delay:-2s"></div>
<div class="bg-shape w-10 h-10 border-2 border-purple-300/25 rounded-full animate-float-c" style="top:60%;left:5%;animation-delay:-1s"></div>
<div class="bg-shape w-6 h-6 bg-indigo-300/25 rounded-lg animate-float-a" style="bottom:20%;right:8%;animation-delay:-3s"></div>
<div class="bg-shape w-4 h-4 bg-brand-300/30 rounded-full animate-float-b" style="top:45%;left:92%;animation-delay:-1.5s"></div>
<div class="bg-shape w-7 h-7 border border-brand-200/40 rounded-lg animate-spin-slow" style="bottom:35%;left:3%;"></div>
<div class="bg-shape w-3 h-3 bg-purple-400/25 rounded-full animate-float-c" style="top:70%;right:5%;animation-delay:-.5s"></div>
<div class="bg-shape w-12 h-12 border border-indigo-200/30 rounded-2xl animate-float-a" style="top:8%;right:20%;animation-delay:-4s"></div>

{{-- Progress bar --}}
<div id="nprogress" style="width:0%;opacity:0"></div>

{{-- ═══ NAVBAR ═══ --}}
<nav class="border-b border-white/60 sticky top-0 z-50 animate-fade-in">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            @php
                $homeRoute = auth()->user()->isAdmin()
                    ? route('admin.dashboard')
                    : (auth()->user()->isStaff() ? route('staff.dashboard') : route('dashboard'));
            @endphp

            <a href="{{ $homeRoute }}" class="flex items-center gap-2.5 group">
                <div class="w-8 h-8 bg-brand-600 rounded-xl flex items-center justify-center shadow-sm shadow-brand-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                </div>
                <span class="font-bold text-gray-900 text-lg tracking-tight">TEAMS</span>
            </a>

            <div class="hidden md:flex md:items-center md:gap-1 md:flex-wrap">
                @if(auth()->user()->isSiswa())
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Alat</a>
                <a href="{{ route('riwayat') }}" class="nav-link {{ request()->routeIs('riwayat') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Riwayat</a>
                <a href="{{ route('scan.kamera') }}" class="nav-link {{ request()->routeIs('scan.kamera') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">📷 Scan</a>
                @endif
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Dashboard</a>
                <a href="{{ route('admin.alat.index') }}" class="nav-link {{ request()->routeIs('admin.alat.*') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Kelola Alat</a>
                <a href="{{ route('admin.statistik') }}" class="nav-link {{ request()->routeIs('admin.statistik') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Statistik</a>
                <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Siswa</a>
                <a href="{{ route('admin.riwayat.index') }}" class="nav-link {{ request()->routeIs('admin.riwayat.*') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Riwayat</a>
                <a href="{{ route('admin.activity.log') }}" class="nav-link {{ request()->routeIs('admin.activity.*') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Log</a>
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">⚙️</a>
                @endif
                @if(auth()->user()->isStaff() && !auth()->user()->isAdmin())
                <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Dashboard</a>
                <a href="{{ route('staff.siswas') }}" class="nav-link {{ request()->routeIs('staff.siswas') ? 'active text-brand-600 font-semibold' : 'text-gray-500 hover:text-brand-600' }} text-sm px-3 py-2 rounded-lg transition-all hover:bg-white/60">Data Siswa</a>
                @endif
            </div>

            <div class="flex items-center gap-1">
                <button id="mobile-menu-toggle" class="md:hidden inline-flex items-center justify-center p-2 rounded-xl border border-gray-200 bg-white/80 hover:bg-white transition">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                @if(auth()->user()->isAdmin())
                @php $bellCount = \App\Models\Peminjaman::where('status_pengajuan','menunggu_konfirmasi')->count(); @endphp
                <a href="{{ route('admin.dashboard') }}#konfirmasi"
                    class="hidden md:inline-flex relative w-8 h-8 rounded-xl border border-gray-200 hover:border-brand-200 bg-white/60 hover:bg-brand-50 items-center justify-center transition-all duration-200 group"
                    title="Pengembalian menunggu konfirmasi">
                    <svg class="w-4 h-4 text-gray-500 group-hover:text-brand-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if($bellCount > 0)
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center animate-pulse">
                        {{ $bellCount > 9 ? '9+' : $bellCount }}
                    </span>
                    @endif
                </a>
                @endif

                <button onclick="toggleDark()" id="dark-toggle" title="Dark/Light mode"
                    class="hidden md:inline-flex w-8 h-8 rounded-xl border border-gray-200 hover:border-brand-200 bg-white/60 hover:bg-brand-50 items-center justify-center transition-all duration-200">
                    <span id="dark-icon" class="text-sm">🌙</span>
                </button>

                <button id="pwa-install-btn" onclick="installPWA()" title="Install TEAMS"
                    class="hidden md:inline-flex text-xs font-medium text-brand-600 border border-brand-200 hover:bg-brand-50 px-3 py-1.5 rounded-xl transition-all items-center gap-1.5 animate-fade-in">
                    📲 Install App
                </button>

                <div class="hidden md:block relative ml-3">
                    <button onclick="toggleDropdown()" class="flex items-center gap-2 group">
                        <img src="{{ auth()->user()->fotoUrl() }}" alt="{{ auth()->user()->name }}"
                            class="w-8 h-8 rounded-full object-cover shadow-sm group-hover:shadow-brand-300/50 group-hover:shadow-md group-hover:scale-110 transition-all duration-200 border-2 border-white">
                    </button>
                    <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl shadow-gray-200/80 border border-gray-100/80 py-1 z-50 animate-scale-in origin-top-right">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                @if(auth()->user()->isSiswa()) NIS: {{ auth()->user()->nis }}@if(auth()->user()->kelas) · {{ auth()->user()->kelas }}@endif
                                @else {{ ucfirst(str_replace('_',' ',auth()->user()->role)) }}
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil & Password
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="mobile-nav" class="hidden md:hidden border-t border-gray-200 bg-white/95">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 space-y-2">
            @if(auth()->user()->isSiswa())
            <a href="{{ route('dashboard') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Alat</a>
            <a href="{{ route('riwayat') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Riwayat</a>
            <a href="{{ route('scan.kamera') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">📷 Scan</a>
            @endif
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Dashboard</a>
            <a href="{{ route('admin.alat.index') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Kelola Alat</a>
            <a href="{{ route('admin.statistik') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Statistik</a>
            <a href="{{ route('admin.siswa.index') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Siswa</a>
            <a href="{{ route('admin.riwayat.index') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Riwayat</a>
            <a href="{{ route('admin.activity.log') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Log</a>
            <a href="{{ route('admin.settings') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">⚙️ Settings</a>
            @endif
            @if(auth()->user()->isStaff() && !auth()->user()->isAdmin())
            <a href="{{ route('staff.dashboard') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Dashboard</a>
            <a href="{{ route('staff.siswas') }}" class="block text-sm text-gray-700 px-3 py-2 rounded-xl hover:bg-gray-50 transition">Data Siswa</a>
            @endif
        </div>
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-3 border-t border-gray-100">
            <div class="flex items-center justify-between gap-2 py-3">
                <button onclick="toggleDark()" class="w-full inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white/80 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Mode Gelap/Terang</button>
                <a href="{{ route('profile.edit') }}" class="w-full inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white/80 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">Profil</a>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-600 hover:bg-red-100 transition">Keluar</button>
            </form>
        </div>
    </div>
</nav>

{{-- Toast --}}
@if(session('success'))
<div id="toast-success" class="toast fixed top-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 bg-white/95 backdrop-blur border border-green-200 text-green-700 text-sm rounded-2xl px-5 py-3 shadow-lg shadow-green-100/60 max-w-sm w-auto">
    <div class="w-7 h-7 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
    </div>
    <span>{{ session('success') }}</span>
    <button onclick="dismissToast('toast-success')" class="ml-auto text-green-400 hover:text-green-600 transition-colors">✕</button>
</div>
@endif
@if(session('error'))
<div id="toast-error" class="toast fixed top-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 bg-white/95 backdrop-blur border border-red-200 text-red-600 text-sm rounded-2xl px-5 py-3 shadow-lg shadow-red-100/60 max-w-sm w-auto">
    <div class="w-7 h-7 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </div>
    <span>{{ session('error') }}</span>
    <button onclick="dismissToast('toast-error')" class="ml-auto text-red-400 hover:text-red-600 transition-colors">✕</button>
</div>
@endif

<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{ $slot }}
</main>

<script>
// ── Page load ──────────────────────────────
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
    const bar = document.getElementById('nprogress');
    bar.style.width = '100%';
    setTimeout(() => { bar.style.opacity = '0'; }, 400);
});

// Progress on nav click
document.querySelectorAll('a[href]').forEach(a => {
    if (a.hostname === location.hostname && !a.href.includes('#') && a.target !== '_blank') {
        a.addEventListener('click', () => {
            const bar = document.getElementById('nprogress');
            bar.style.opacity = '1'; bar.style.transition = 'none'; bar.style.width = '0%';
            requestAnimationFrame(() => { bar.style.transition = 'width 8s cubic-bezier(.1,.8,.1,1)'; bar.style.width = '85%'; });
        });
    }
});

const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
const mobileNav = document.getElementById('mobile-nav');
if (mobileMenuToggle && mobileNav) {
    mobileMenuToggle.addEventListener('click', () => {
        mobileNav.classList.toggle('hidden');
    });
    mobileNav.querySelectorAll('a[href]').forEach(a => {
        a.addEventListener('click', () => mobileNav.classList.add('hidden'));
    });
}

// ── Canvas particle background ─────────────
(function() {
    const canvas = document.getElementById('bg-canvas');
    const ctx = canvas.getContext('2d');
    let W, H, particles = [], mouse = { x: -999, y: -999 };

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }
    resize();
    window.addEventListener('resize', resize);
    window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; });

    // Create particles
    function createParticles() {
        particles = [];
        const count = Math.floor(W * H / 18000); // density based on screen size
        for (let i = 0; i < count; i++) {
            particles.push({
                x: Math.random() * W,
                y: Math.random() * H,
                r: Math.random() * 2 + .5,
                vx: (Math.random() - .5) * .3,
                vy: (Math.random() - .5) * .3 - .1,
                opacity: Math.random() * .4 + .1,
            });
        }
    }
    createParticles();
    window.addEventListener('resize', createParticles);

    function draw() {
        ctx.clearRect(0, 0, W, H);

        // Draw connecting lines between nearby particles
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx*dx + dy*dy);
                if (dist < 120) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(99,102,241,${.08 * (1 - dist/120)})`;
                    ctx.lineWidth = .6;
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.stroke();
                }
            }
        }

        // Draw particles + mouse repulsion
        particles.forEach(p => {
            const mdx = p.x - mouse.x, mdy = p.y - mouse.y;
            const mdist = Math.sqrt(mdx*mdx + mdy*mdy);
            if (mdist < 100) {
                const force = (100 - mdist) / 100;
                p.vx += (mdx / mdist) * force * .4;
                p.vy += (mdy / mdist) * force * .4;
            }

            // Speed limit
            const speed = Math.sqrt(p.vx*p.vx + p.vy*p.vy);
            if (speed > 1.5) { p.vx *= 1.5/speed; p.vy *= 1.5/speed; }

            // Damping
            p.vx *= .98; p.vy *= .98;

            p.x += p.vx; p.y += p.vy;

            // Wrap around edges
            if (p.x < 0) p.x = W; if (p.x > W) p.x = 0;
            if (p.y < 0) p.y = H; if (p.y > H) p.y = 0;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(99,102,241,${p.opacity})`;
            ctx.fill();
        });

        requestAnimationFrame(draw);
    }
    draw();
})();

// ── Dropdown ───────────────────────────────
function toggleDropdown() {
    const menu = document.getElementById('dropdown-menu');
    menu.classList.toggle('hidden');
}
document.addEventListener('click', e => {
    const menu = document.getElementById('dropdown-menu');
    if (menu && !menu.contains(e.target) && !e.target.closest('[onclick="toggleDropdown()"]')) {
        menu.classList.add('hidden');
    }
});

// ── Toast ──────────────────────────────────
function dismissToast(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.style.transition = 'opacity .3s, transform .3s';
    el.style.opacity = '0'; el.style.transform = 'translateX(-50%) translateY(-16px)';
    setTimeout(() => el?.remove(), 300);
}
setTimeout(() => dismissToast('toast-success'), 4500);
setTimeout(() => dismissToast('toast-error'),   4500);

// ── Counter animasi angka ──────────────────
function animateCounter(el) {
    const target = +el.dataset.target;
    if (!target) { el.textContent = 0; return; }
    let start = null;
    const step = ts => {
        if (!start) start = ts;
        const p = Math.min((ts - start) / 900, 1);
        el.textContent = Math.floor(p * target);
        if (p < 1) requestAnimationFrame(step); else el.textContent = target;
    };
    requestAnimationFrame(step);
}
const cntObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { animateCounter(e.target); cntObs.unobserve(e.target); } });
}, { threshold:.3 });
document.querySelectorAll('.counter').forEach(el => { el.textContent = '0'; cntObs.observe(el); });
</script>

<script>

// ── Dark mode ──────────────────────────────────────
function applyDark(dark) {
    document.documentElement.classList.toggle('dark', dark);
    document.getElementById('dark-icon').textContent = dark ? '☀️' : '🌙';
}
function toggleDark() {
    const dark = !document.documentElement.classList.contains('dark');
    localStorage.setItem('teams-dark', dark);
    applyDark(dark);
}
// Restore preference
applyDark(localStorage.getItem('teams-dark') === 'true');

// ── PWA Service Worker ─────────────────────────────
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(reg => console.log('SW registered:', reg.scope))
            .catch(err => console.log('SW error:', err));
    });
}

// ── PWA Install prompt ─────────────────────────────
let deferredPrompt;
window.addEventListener('beforeinstallprompt', e => {
    e.preventDefault();
    deferredPrompt = e;
    // Tampilkan tombol install
    const btn = document.getElementById('pwa-install-btn');
    if (btn) btn.classList.remove('hidden');
});

function installPWA() {
    if (!deferredPrompt) return;
    deferredPrompt.prompt();
    deferredPrompt.userChoice.then(choice => {
        if (choice.outcome === 'accepted') {
            document.getElementById('pwa-install-btn')?.classList.add('hidden');
        }
        deferredPrompt = null;
    });
}

window.addEventListener('appinstalled', () => {
    document.getElementById('pwa-install-btn')?.classList.add('hidden');
    deferredPrompt = null;
});
</script>

</body>
</html>
