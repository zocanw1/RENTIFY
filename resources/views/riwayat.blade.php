<x-app-layout title="Riwayat Peminjaman">

    <div class="mb-8 animate-fade-up">
        <h1 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman</h1>
        <p class="text-gray-500 text-sm mt-1">Semua aktivitas pinjam kamu</p>
    </div>

    {{-- Info batas waktu --}}
    @php $batasJam = \App\Models\Setting::get('batas_jam_kembali','15:00'); @endphp
    <div class="mb-5 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 flex items-center gap-2 text-sm text-blue-700 animate-fade-up" style="animation-delay:.04s">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Batas pengembalian alat: <strong>pukul {{ $batasJam }} WIB</strong> pada hari peminjaman
    </div>

    @if($riwayats->isEmpty())
        <div class="text-center py-20 bg-white/80 backdrop-blur rounded-2xl border border-gray-100 animate-scale-in">
            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-gray-500 font-medium">Belum ada riwayat peminjaman</p>
            <a href="{{ route('dashboard') }}" class="inline-block mt-4 text-sm text-brand-600 font-medium hover:text-brand-700 transition-colors">Mulai pinjam alat →</a>
        </div>
    @else
        <div class="space-y-3 stagger">
            @foreach($riwayats as $data)
            @php $terlambat = $data->isTerlambat(); @endphp
            <div class="card-hover bg-white/80 backdrop-blur rounded-2xl border {{ $terlambat ? 'border-red-200' : 'border-gray-100' }} p-5 animate-fade-up group {{ $terlambat ? 'ring-1 ring-red-100' : '' }}">
                <div class="flex items-start justify-between gap-4 flex-wrap">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="font-semibold text-gray-900 text-sm group-hover:text-brand-700 transition-colors">{{ $data->unit->alat->nama_alat }}</p>
                            <span class="text-xs text-gray-400 font-mono bg-gray-50 px-2 py-0.5 rounded-md">{{ $data->unit->kode_unit }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-500 flex-wrap">
                            <span>📅 Dipinjam: {{ $data->waktu_pinjam->format('d M Y, H:i') }}</span>
                            @if($data->waktu_kembali)
                                <span>✅ Dikembalikan: {{ $data->waktu_kembali->format('d M Y, H:i') }}</span>
                            @endif
                        </div>

                        {{-- Badge TERLAMBAT --}}
                        @if($terlambat && $data->status_pengajuan === 'aktif')
                        <div class="mt-2 bg-red-50 border border-red-200 rounded-xl px-3 py-2 flex items-center gap-2 animate-fade-in">
                            <span class="text-lg">⚠️</span>
                            <div>
                                <p class="text-xs font-bold text-red-700">Melebihi batas waktu pengembalian!</p>
                                <p class="text-xs text-red-500">Segera kembalikan alat. Batas: pukul {{ $batasJam }} WIB · Sudah terlambat <strong>{{ $data->durasiTerlambat() }}</strong></p>
                            </div>
                        </div>
                        @elseif($terlambat && $data->status_pengajuan === 'menunggu_konfirmasi')
                        <div class="mt-2 bg-orange-50 border border-orange-200 rounded-xl px-3 py-2 flex items-center gap-2 animate-fade-in">
                            <span class="text-lg">⏳</span>
                            <p class="text-xs text-orange-700">Pengajuan pengembalian sedang menunggu konfirmasi admin (terlambat {{ $data->durasiTerlambat() }})</p>
                        </div>
                        @endif

                        @if($data->komentar_siswa)
                        <div class="mt-2 bg-blue-50 rounded-xl px-3 py-2 text-xs text-blue-800 animate-fade-in">
                            <p class="font-semibold mb-0.5">💬 Komentarmu:</p>
                            <p>{{ $data->komentar_siswa }}</p>
                        </div>
                        @endif
                        @if($data->balasan_admin)
                        <div class="mt-1 bg-green-50 rounded-xl px-3 py-2 text-xs text-green-800 animate-fade-in">
                            <p class="font-semibold mb-0.5">🛡 Balasan Admin:</p>
                            <p>{{ $data->balasan_admin }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col items-end gap-2 flex-shrink-0">
                        {{-- Status badge --}}
                        @if($data->status_pengajuan === 'selesai')
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Selesai
                            </span>
                        @elseif($data->status_pengajuan === 'menunggu_konfirmasi')
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full bg-orange-50 text-orange-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>Menunggu Konfirmasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full {{ $terlambat ? 'bg-red-50 text-red-700' : 'bg-yellow-50 text-yellow-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $terlambat ? 'bg-red-500' : 'bg-yellow-500' }} animate-ping-slow"></span>
                                {{ $terlambat ? 'Terlambat!' : 'Dipinjam' }}
                            </span>
                        @endif

                        @if($data->status_pengajuan === 'aktif')
                        <button onclick="bukaModal({{ $data->id }})"
                            class="btn-ripple text-xs font-semibold {{ $terlambat ? 'bg-red-600 hover:bg-red-700 shadow-red-200/50' : 'bg-brand-600 hover:bg-brand-700 shadow-brand-200/50' }} text-white px-4 py-2 rounded-xl transition-all shadow-sm hover:shadow-md">
                            {{ $terlambat ? '⚠️ Kembalikan Sekarang!' : 'Kembalikan' }}
                        </button>
                        @endif
                    </div>
                </div>
            </div>

            @if($data->status_pengajuan === 'aktif')
            <div id="modal-{{ $data->id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm px-4">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 animate-scale-in">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Konfirmasi Pengembalian</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Kamu akan mengembalikan <span class="font-semibold text-gray-700">{{ $data->unit->alat->nama_alat }}</span>
                        ({{ $data->unit->kode_unit }}). Admin akan konfirmasi pengembalianmu.
                    </p>
                    @if($terlambat)
                    <div class="mb-4 bg-red-50 border border-red-200 rounded-xl px-3 py-2.5 text-xs text-red-700">
                        ⚠️ Kamu terlambat mengembalikan selama <strong>{{ $data->durasiTerlambat() }}</strong>. Harap isi keterangan kondisi alat dengan jujur.
                    </div>
                    @endif
                    <form action="{{ route('pinjam.kembalikan', $data->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Komentar / Kondisi Alat <span class="text-gray-400 font-normal">({{ $terlambat ? 'wajib diisi' : 'opsional' }})</span>
                            </label>
                            <textarea name="komentar_siswa" rows="3"
                                placeholder="{{ $terlambat ? 'Jelaskan alasan terlambat dan kondisi alat...' : 'Contoh: Alat kondisi baik, sudah dibersihkan...' }}"
                                {{ $terlambat ? 'required' : '' }}
                                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm resize-none transition-all"></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit"
                                class="btn-ripple flex-1 {{ $terlambat ? 'bg-red-600 hover:bg-red-700' : 'bg-brand-600 hover:bg-brand-700' }} text-white font-semibold py-2.5 rounded-xl transition-all text-sm shadow-sm">
                                Ya, Kembalikan
                            </button>
                            <button type="button" onclick="tutupModal({{ $data->id }})"
                                class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold py-2.5 rounded-xl transition-all text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    @endif

    <script>
    function bukaModal(id) {
        const m = document.getElementById('modal-' + id);
        m.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    function tutupModal(id) {
        const m = document.getElementById('modal-' + id);
        m.style.opacity = '0'; m.style.transition = 'opacity .2s';
        setTimeout(() => { m.classList.add('hidden'); m.style.opacity = ''; m.style.transition = ''; }, 200);
        document.body.style.overflow = '';
    }
    document.querySelectorAll('[id^="modal-"]').forEach(m => {
        m.addEventListener('click', e => { if (e.target === m) tutupModal(m.id.split('-')[1]); });
    });
    </script>

</x-app-layout>
