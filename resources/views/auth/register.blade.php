<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-stone-800">Buat akun baru</h2>
        <p class="text-sm mt-1" style="color: var(--muted);">Bergabung dengan Kantin Digital</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="field-label">Nama Lengkap</label>
            <x-text-input id="name" class="field" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="field-label">Email</label>
            <x-text-input id="email" class="field" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="field-label">Password</label>
            <x-text-input id="password" class="field" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="field-label">Konfirmasi Password</label>
            <x-text-input id="password_confirmation" class="field" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full">
            Daftar
        </button>

        <p class="text-center text-sm" style="color: var(--muted);">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color: var(--brand);">Masuk</a>
        </p>
    </form>
</x-guest-layout>
