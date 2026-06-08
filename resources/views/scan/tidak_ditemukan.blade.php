<x-app-layout title="Unit Tidak Ditemukan">
    <div class="max-w-sm mx-auto text-center py-8">

        <div class="animate-fade-up">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-1">Unit Tidak Ditemukan</h2>
            <p class="text-gray-500 text-sm mb-2">
                Kode <span class="font-mono font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded-lg">{{ $kode }}</span> tidak terdaftar
            </p>
            <p class="text-gray-400 text-xs mb-6">QR mungkin rusak, sudah tidak valid, atau belum didaftarkan oleh admin.</p>
        </div>

        <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-5 mb-6 text-left animate-fade-up" style="animation-delay:.08s">
            <p class="text-sm font-semibold text-gray-700 mb-3">Yang bisa dilakukan:</p>
            <div class="space-y-2.5 text-xs text-gray-500">
                <div class="flex items-start gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold flex-shrink-0 text-xs">1</span>
                    <p>Coba scan ulang QR dengan pencahayaan yang lebih baik</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold flex-shrink-0 text-xs">2</span>
                    <p>Pinjam manual lewat Dashboard → pilih alat → pilih unit</p>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="w-5 h-5 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold flex-shrink-0 text-xs">3</span>
                    <p>Hubungi admin untuk cetak ulang QR yang rusak</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-2 animate-fade-up" style="animation-delay:.14s">
            <a href="{{ route('dashboard') }}"
                class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3 rounded-xl transition-all shadow-sm text-sm">
                Pinjam Manual via Dashboard
            </a>
        </div>

    </div>
</x-app-layout>
