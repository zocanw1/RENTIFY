<x-app-layout title="Log Aktivitas">
    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Log Aktivitas Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Semua aksi yang dilakukan admin tercatat di sini</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl transition-all">← Dashboard</a>
    </div>

    <form method="GET" class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-4 mb-6 animate-fade-up" style="animation-delay:.05s">
        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-40">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Cari</label>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Nama admin atau keterangan..."
                    class="input-focus w-full px-4 py-2 rounded-xl border border-gray-200 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Jenis Aksi</label>
                <select name="aksi" class="input-focus px-3 py-2 rounded-xl border border-gray-200 text-sm bg-white">
                    <option value="">Semua Aksi</option>
                    @foreach($aksiList as $a)
                    <option value="{{ $a }}" {{ request('aksi')===$a?'selected':'' }}>{{ str_replace('_',' ',ucfirst($a)) }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-ripple px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm">Filter</button>
            @if(request()->hasAny(['cari','aksi']))
            <a href="{{ route('admin.activity.log') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-red-500 border border-gray-200 rounded-xl transition-all">Reset</a>
            @endif
        </div>
    </form>

    <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 overflow-hidden animate-fade-up" style="animation-delay:.1s">
        @if($logs->isEmpty())
        <div class="text-center py-16"><p class="text-gray-400">Belum ada log aktivitas</p></div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Admin</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Aksi</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Keterangan</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">IP</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($logs as $log)
                    @php
                    $warna = match(true) {
                        str_contains($log->aksi,'hapus') => 'bg-red-50 text-red-700',
                        str_contains($log->aksi,'tambah') => 'bg-green-50 text-green-700',
                        str_contains($log->aksi,'edit') => 'bg-blue-50 text-blue-700',
                        str_contains($log->aksi,'konfirmasi') => 'bg-purple-50 text-purple-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                    @endphp
                    <tr class="hover:bg-brand-50/20 transition-colors group">
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <img src="{{ $log->user->fotoUrl() }}" class="w-7 h-7 rounded-full object-cover flex-shrink-0">
                                <p class="text-sm font-medium text-gray-900">{{ $log->user->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $warna }}">
                                {{ str_replace('_',' ',ucfirst($log->aksi)) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-600 max-w-xs">{{ $log->keterangan }}</td>
                        <td class="px-6 py-3 text-xs font-mono text-gray-400">{{ $log->ip }}</td>
                        <td class="px-6 py-3 text-xs text-gray-500">
                            {{ $log->created_at->format('d M Y') }}<br>
                            <span class="text-gray-400">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">{{ $logs->links() }}</div>
        @endif
        @endif
    </div>
</x-app-layout>
