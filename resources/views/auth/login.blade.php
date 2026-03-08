<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-stone-800">Masuk ke akun</h2>
        <p class="text-sm mt-1" style="color: var(--muted);">Selamat datang kembali di Kantin Digital</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="field-label">Email</label>
            <x-text-input id="email" class="field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="field-label">Password</label>
            <x-text-input id="password" class="field" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-orange-600 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm" style="color: var(--muted);">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium hover:underline" style="color: var(--brand);" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full">
            Masuk
        </button>

        <p class="text-center text-sm" style="color: var(--muted);">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: var(--brand);">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
