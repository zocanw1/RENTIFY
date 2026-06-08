<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Lupa Password? 🔑</h2>
    <p class="text-gray-500 mb-2 text-sm">Masukkan emailmu, kami kirimkan link reset password.</p>

    @if(session('status'))
    <div class="mb-5 bg-green-50 border border-green-200 rounded-xl px-4 py-3 text-sm text-green-700 animate-fade-up flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5 mt-6">
        @csrf
        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary animate-fade-up w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm shadow-sm">
            Kirim Link Reset Password
        </button>

        <p class="animate-fade-up text-center text-sm text-gray-500">
            Ingat password?
            <a href="{{ route('login') }}" class="text-brand-600 font-semibold hover:text-brand-700 transition-colors">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
