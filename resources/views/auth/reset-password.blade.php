<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Reset Password 🔒</h2>
    <p class="text-gray-500 mb-6 text-sm">Buat password baru untuk akunmu</p>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password Baru</label>
            <input type="password" name="password" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            @error('password') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="animate-fade-up">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
        </div>

        <button type="submit" class="btn-primary animate-fade-up w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm shadow-sm">
            Reset Password
        </button>
    </form>
</x-guest-layout>
