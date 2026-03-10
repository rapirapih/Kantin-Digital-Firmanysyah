<x-guest-layout>
    <div style="text-align: center; margin-bottom: 1.75rem;">
        <h2 style="font-size: 1.375rem; font-weight: 700; color: #111827;">Buat Akun Baru</h2>
        <p style="font-size: 0.8125rem; color: #6b7280; margin-top: 0.375rem;">Bergabung dengan E-MPU Store</p>
    </div>

    <form method="POST" action="{{ route('register') }}" style="display: flex; flex-direction: column; gap: 1.125rem;">
        @csrf

        <div>
            <label for="name" class="auth-label">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="auth-input" placeholder="Nama lengkap kamu" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <label for="email" class="auth-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="auth-input" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.875rem;">
            <div>
                <label for="password" class="auth-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="auth-input" placeholder="Min. 8 karakter" />
                <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
            </div>
            <div>
                <label for="password_confirmation" class="auth-label">Konfirmasi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="auth-input" placeholder="Ulangi password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
            </div>
        </div>

        <button type="submit" class="auth-btn" style="margin-top: 0.25rem;">Daftar</button>

        <p style="text-align: center; font-size: 0.8125rem; color: #6b7280;">
            Sudah punya akun?
            <a href="{{ route('login') }}" style="font-weight: 600; color: #C62828; text-decoration: none;">Masuk</a>
        </p>
    </form>
</x-guest-layout>
