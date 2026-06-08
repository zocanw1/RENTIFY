<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Buat akun</h2>
    <p class="text-gray-500 mb-8 text-sm">Daftar untuk mulai meminjam alat</p>

    @if($errors->any())
    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600 animate-fade-up">
        @foreach($errors->all() as $err)
            <p>⚠ {{ $err }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-5 stagger">
        @csrf
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
        </div>
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">NIS</label>
            <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="Nomor Induk Siswa"
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-mono transition-all">
        </div>
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Kelas</label>
            <select name="kelas" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm bg-white transition-all">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas }}" {{ old('kelas') === $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
        </div>
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
            <input type="password" name="password" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
        </div>
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
        </div>
        <button type="submit"
            class="btn-primary animate-fade-up w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm shadow-sm">
            Daftar
        </button>
        <p class="animate-fade-up text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-brand-600 font-semibold hover:text-brand-700 transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
