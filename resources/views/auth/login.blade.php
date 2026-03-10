<x-guest-layout>
    <div style="text-align: center; margin-bottom: 1.75rem;">
        <h2 style="font-size: 1.375rem; font-weight: 700; color: #111827;">Selamat Datang</h2>
        <p style="font-size: 0.8125rem; color: #6b7280; margin-top: 0.375rem;">Masuk ke akun E-MPU Store kamu</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1.125rem;">
        @csrf

        <div>
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="auth-input" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="auth-input" placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between;">
            <label for="remember_me" style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input id="remember_me" type="checkbox" name="remember" style="width: 1rem; height: 1rem; accent-color: #C62828; border-radius: 4px;">
                <span style="font-size: 0.8125rem; color: #6b7280;">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 0.8125rem; font-weight: 500; color: #C62828; text-decoration: none;">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit" class="auth-btn" style="margin-top: 0.25rem;">Masuk</button>

        <p style="text-align: center; font-size: 0.8125rem; color: #6b7280;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="font-weight: 600; color: #C62828; text-decoration: none;">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
