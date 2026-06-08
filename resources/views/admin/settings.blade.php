<x-app-layout title="Pengaturan">

    <div class="mb-8 flex items-center justify-between flex-wrap gap-3 animate-fade-up">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">⚙️ Pengaturan Sistem</h1>
            <p class="text-gray-500 text-sm mt-1">Konfigurasi aturan peminjaman</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-brand-600 border border-gray-200 bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl transition-all">
            ← Dashboard
        </a>
    </div>

    <div class="max-w-xl">
        <form action="{{ route('admin.settings.update') }}" method="POST"
            class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 space-y-6 card-hover animate-fade-up" style="animation-delay:.06s">
            @csrf

            {{-- Batas jam kembali --}}
            <div>
                <h3 class="text-sm font-bold text-gray-900 mb-1 flex items-center gap-2">
                    <span class="w-7 h-7 bg-red-100 rounded-lg flex items-center justify-center text-sm">⏰</span>
                    Batas Waktu Pengembalian
                </h3>
                <p class="text-xs text-gray-500 mb-3 ml-9">
                    Alat yang belum dikembalikan setelah jam ini akan otomatis ditandai <strong class="text-red-600">Terlambat</strong>
                    di riwayat siswa dan dashboard admin.
                </p>
                <div class="ml-9">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Jam Batas Kembali</label>
                    <div class="flex items-center gap-3">
                        <input type="time" name="batas_jam_kembali"
                            value="{{ $settings['batas_jam_kembali']->value ?? '15:00' }}"
                            class="input-focus px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono">
                        <span class="text-sm text-gray-500">WIB</span>
                    </div>
                    @error('batas_jam_kembali') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1.5">
                        Sekarang disetel: <strong>{{ $settings['batas_jam_kembali']->value ?? '15:00' }} WIB</strong>
                        (sesuai aturan sekolah)
                    </p>
                </div>
            </div>

            {{-- Nama sekolah --}}
            <div class="border-t border-gray-100 pt-5">
                <h3 class="text-sm font-bold text-gray-900 mb-1 flex items-center gap-2">
                    <span class="w-7 h-7 bg-brand-100 rounded-lg flex items-center justify-center text-sm">🏫</span>
                    Nama Sekolah
                </h3>
                <p class="text-xs text-gray-500 mb-3 ml-9">Ditampilkan di header laporan PDF dan Excel</p>
                <div class="ml-9">
                    <input type="text" name="nama_sekolah"
                        value="{{ $settings['nama_sekolah']->value ?? 'SMK' }}"
                        placeholder="Contoh: SMK Negeri 1 Kota"
                        class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                    @error('nama_sekolah') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Info sistem --}}
            <div class="border-t border-gray-100 pt-5 bg-gray-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-gray-600 mb-3">📊 Info Sistem</p>
                <div class="space-y-1.5 text-xs text-gray-500">
                    <div class="flex justify-between">
                        <span>Versi TEAMS</span>
                        <span class="font-mono text-gray-700">1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Framework</span>
                        <span class="font-mono text-gray-700">Laravel {{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>PHP</span>
                        <span class="font-mono text-gray-700">{{ PHP_VERSION }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Waktu Server</span>
                        <span class="font-mono text-gray-700">{{ now()->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm hover:shadow-brand-200/50 hover:shadow-md text-sm">
                Simpan Pengaturan
            </button>
        </form>
    </div>

</x-app-layout>
