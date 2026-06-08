<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Selamat datang 👋</h2>
    <p class="text-gray-500 mb-6 text-sm">Masuk ke akun TEAMS kamu</p>

    @if($errors->any())
    <div class="mb-5 bg-red-50 border border-red-200 rounded-xl px-4 py-3 text-sm text-red-600 animate-fade-up flex items-center gap-2">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ $errors->first() }}
    </div>
    @endif

    {{-- Login type toggle --}}
    <div class="mb-6 flex gap-2 p-1 bg-gray-100 rounded-lg animate-fade-up">
        <button type="button" onclick="switchLoginType('email')"
            id="btn-email-login"
            class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 bg-white text-gray-900 shadow-sm">
            📧 Email
        </button>
        <button type="button" onclick="switchLoginType('student')"
            id="btn-student-login"
            class="flex-1 px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-900">
            👤 Siswa
        </button>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5 stagger" id="login-form">
        @csrf
        <input type="hidden" name="login_type" id="login_type" value="email">
        
        {{-- Email login fields --}}
        <div id="email-fields" class="space-y-5">
            <div class="animate-fade-up">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" autofocus
                    class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            </div>
            <div class="animate-fade-up">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                <input type="password" name="password"
                    class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            </div>
        </div>
        
        {{-- Student login fields --}}
        <div id="student-fields" class="hidden space-y-5">
            <div class="animate-fade-up">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Siswa</label>
                <input type="text" name="student_name"
                    class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            </div>
            <div class="animate-fade-up">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">NIS</label>
                <input type="text" name="student_nis"
                    class="input-focus w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm transition-all">
            </div>
        </div>
        
        <div class="animate-fade-up flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600">
                <span class="text-sm text-gray-600">Ingat saya</span>
            </label>
            <div id="forgot-password-container">
                @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-brand-600 hover:text-brand-700 transition-colors">Lupa password?</a>
                @endif
            </div>
        </div>
        
        <button type="submit"
            class="btn-primary animate-fade-up w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm shadow-sm">
            Masuk
        </button>
        
        <p class="animate-fade-up text-center text-sm text-gray-500">
            Belum punya akun? Hubungi admin untuk import data Excel sehingga kamu bisa langsung login.
        </p>
    </form>

    <script>
        function switchLoginType(type) {
            const emailBtn = document.getElementById('btn-email-login');
            const studentBtn = document.getElementById('btn-student-login');
            const emailFields = document.getElementById('email-fields');
            const studentFields = document.getElementById('student-fields');
            const loginTypeInput = document.getElementById('login_type');
            const forgotPasswordContainer = document.getElementById('forgot-password-container');
            
            if (type === 'student') {
                loginTypeInput.value = 'student';
                studentBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                studentBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                emailBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                emailBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                
                emailFields.classList.add('hidden');
                studentFields.classList.remove('hidden');
                forgotPasswordContainer.classList.add('hidden');
                
                // Clear email fields
                document.querySelector('input[name="email"]').value = '';
                document.querySelector('input[name="password"]').value = '';
            } else {
                loginTypeInput.value = 'email';
                emailBtn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                emailBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                studentBtn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                studentBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                
                emailFields.classList.remove('hidden');
                studentFields.classList.add('hidden');
                forgotPasswordContainer.classList.remove('hidden');
                
                // Clear student fields
                document.querySelector('input[name="student_name"]').value = '';
                document.querySelector('input[name="student_nis"]').value = '';
            }
        }
    </script>
</x-guest-layout>
