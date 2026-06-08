<x-app-layout title="Profil">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8 animate-fade-up">
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola informasi akun dan keamanan</p>
        </div>

        {{-- Info akun + foto profil --}}
        <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 mb-5 card-hover animate-fade-up" style="animation-delay:.05s">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PATCH')

                {{-- Foto profil --}}
                <div class="flex items-center gap-5">
                    <div class="relative flex-shrink-0">
                        <img id="foto-preview" src="{{ $user->fotoUrl() }}" alt="{{ $user->name }}"
                            class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-100 shadow-sm">
                        <button type="button" onclick="document.getElementById('foto_profil').click()"
                            class="absolute -bottom-1 -right-1 w-7 h-7 bg-brand-600 rounded-lg flex items-center justify-center shadow-sm hover:bg-brand-700 transition-colors">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </button>
                        <input type="file" id="foto_profil" name="foto_profil" accept="image/*" class="hidden" onchange="previewFoto(this)">
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">
                            @if($user->isSiswa()) 🎓 Siswa · {{ $user->kelas ?? '-' }}
                            @elseif($user->isAdmin()) 🛡 Admin
                            @elseif($user->isKetuaTjkt()) 👔 Ketua Jurusan TJKT
                            @elseif($user->isKetuaSija()) 👔 Ketua Jurusan SIJA
                            @elseif($user->isWaliKelas()) 📋 Wali Kelas {{ $user->kelas }}
                            @endif
                        </p>
                        @if($user->foto_profil)
                        <label class="flex items-center gap-1.5 mt-1 cursor-pointer">
                            <input type="checkbox" name="hapus_foto" value="1" class="rounded border-gray-300 text-red-500 w-3 h-3">
                            <span class="text-xs text-red-400">Hapus foto</span>
                        </label>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name',$user->name) }}"
                            class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                        @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email',$user->email) }}"
                            class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                        @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    @if($user->isSiswa())
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">NIS</label>
                        <input type="text" name="nis" value="{{ old('nis',$user->nis) }}"
                            class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono">
                        @error('nis') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kelas</label>
                        <input type="text" value="{{ $user->kelas ?? '-' }}" disabled
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-100 bg-gray-50 text-sm text-gray-500">
                    </div>
                    @endif
                    <div class="{{ $user->isSiswa() ? 'sm:col-span-2' : '' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">No. WhatsApp <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="no_wa" value="{{ old('no_wa',$user->no_wa) }}" placeholder="628xxxxxxxxxx"
                            class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono">
                        <p class="text-xs text-gray-400 mt-1">Format: 628xxxxxxxxxx (tanpa +)</p>
                    </div>
                </div>

                <button type="submit" class="btn-ripple w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm text-sm">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        {{-- Ganti password --}}
        <div class="bg-white/80 backdrop-blur rounded-2xl border border-gray-100 p-6 mb-5 card-hover animate-fade-up" style="animation-delay:.1s">
            <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 bg-orange-100 rounded-lg flex items-center justify-center text-sm">🔒</span>
                Ganti Password
            </h2>
            <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Lama</label>
                    <input type="password" name="current_password" class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                    @error('current_password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                    @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                </div>
                <button type="submit" class="btn-ripple w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm text-sm">
                    Ganti Password
                </button>
            </form>
        </div>

        @if($user->isSiswa())
        <div class="bg-white/80 backdrop-blur rounded-2xl border border-red-100 p-6 animate-fade-up" style="animation-delay:.15s">
            <h2 class="text-base font-bold text-red-600 mb-2">⚠️ Hapus Akun</h2>
            <p class="text-sm text-gray-500 mb-4">Akun yang dihapus tidak bisa dipulihkan.</p>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus akun?')"
                    class="text-sm font-semibold text-red-500 border border-red-200 hover:bg-red-50 px-5 py-2 rounded-xl transition-all">
                    Hapus Akun Saya
                </button>
            </form>
        </div>
        @endif
    </div>

    <script>
    function previewFoto(input) {
        if (input.files && input.files[0]) {
            document.getElementById('foto-preview').src = URL.createObjectURL(input.files[0]);
        }
    }
    </script>
</x-app-layout>
