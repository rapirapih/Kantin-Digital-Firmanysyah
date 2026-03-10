<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-MPU Store') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="page-shell">
            @include('layouts.navigation')

            {{-- Global Toast Notification --}}
            @if (session('status') || $errors->any())
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, {{ $errors->any() ? 5000 : 3000 }})"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-3"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-3"
                     class="toast-container"
                     x-cloak>
                    @if (session('status'))
                        <div class="toast toast-success" @click="show = false">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span class="flex-1 text-sm">{{ session('status') }}</span>
                            <svg class="w-4 h-4 shrink-0 opacity-50 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="toast toast-error" @click="show = false">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span class="flex-1 text-sm">{{ $errors->first() }}</span>
                            <svg class="w-4 h-4 shrink-0 opacity-50 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Page Content -->
            <main class="pb-20 sm:pb-12">
                {{ $slot }}
            </main>

            {{-- Global Confirm Modal --}}
            <div x-data="confirmModal()" x-cloak
                 @confirm-action.window="open($event.detail)"
                 x-show="showing"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-[999] flex items-center justify-center p-4"
                 style="background-color: rgba(0,0,0,0.4); backdrop-filter: blur(4px);">
                <div x-show="showing"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     @click.away="cancel()"
                     class="w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden"
                     style="background: var(--panel);">
                    <div class="px-6 pt-6 pb-4 text-center">
                        <div class="mx-auto w-12 h-12 rounded-full flex items-center justify-center mb-3" :style="iconBg">
                            <svg x-show="type === 'danger'" class="w-6 h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <svg x-show="type === 'warning'" class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <svg x-show="type === 'confirm'" class="w-6 h-6" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-base font-bold mb-1" x-text="title" style="color: var(--ink);"></h3>
                        <p class="text-sm" x-text="message" style="color: var(--muted);"></p>
                    </div>
                    <div class="px-6 pb-5 flex gap-3">
                        <button @click="cancel()" class="btn-secondary flex-1 !py-2.5 justify-center">Batal</button>
                        <button @click="proceed()" class="flex-1 !py-2.5 rounded-xl text-sm font-semibold text-white transition-all justify-center inline-flex items-center gap-2" :style="btnStyle" x-text="confirmText"></button>
                    </div>
                </div>
            </div>

            <script>
                function confirmModal() {
                    return {
                        showing: false,
                        title: '',
                        message: '',
                        type: 'confirm',
                        confirmText: 'Ya, Lanjutkan',
                        formEl: null,
                        iconBg: '',
                        btnStyle: '',
                        open(detail) {
                            this.title = detail.title || 'Konfirmasi';
                            this.message = detail.message || 'Apakah kamu yakin?';
                            this.type = detail.type || 'confirm';
                            this.confirmText = detail.confirmText || 'Ya, Lanjutkan';
                            this.formEl = detail.form || null;
                            if (this.type === 'danger') {
                                this.iconBg = 'background-color: #fef2f2';
                                this.btnStyle = 'background-color: #dc2626';
                            } else if (this.type === 'warning') {
                                this.iconBg = 'background-color: #fffbeb';
                                this.btnStyle = 'background-color: #d97706';
                            } else {
                                this.iconBg = 'background-color: var(--brand-soft)';
                                this.btnStyle = 'background-color: var(--brand)';
                            }
                            this.showing = true;
                        },
                        cancel() { this.showing = false; this.formEl = null; },
                        proceed() {
                            this.showing = false;
                            if (this.formEl) this.formEl.submit();
                        }
                    }
                }

                function confirmSubmit(form, opts) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        window.dispatchEvent(new CustomEvent('confirm-action', {
                            detail: { ...opts, form: form }
                        }));
                    });
                    return true;
                }
            </script>

            <!-- Mobile Bottom Navigation (Pembeli) -->
            @auth
                @if (Auth::user()->role === 'pembeli')
                    <div class="mobile-bottom-nav">
                        <div class="nav-items">
                            <a href="{{ route('dashboard.pembeli') }}" class="{{ request()->routeIs('dashboard.pembeli') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                                Menu
                            </a>
                            <a href="{{ route('dashboard.pembeli.cart') }}" class="{{ request()->routeIs('dashboard.pembeli.cart') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Keranjang
                            </a>
                            <a href="{{ route('dashboard.pembeli.topup') }}" class="{{ request()->routeIs('dashboard.pembeli.topup') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Top Up
                            </a>
                            <a href="{{ route('dashboard.pembeli.riwayat') }}" class="{{ request()->routeIs('dashboard.pembeli.riwayat') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Riwayat
                            </a>
                        </div>
                    </div>
                @elseif (Auth::user()->role === 'penjual')
                    <div class="mobile-bottom-nav">
                        <div class="nav-items">
                            <a href="{{ route('dashboard.penjual') }}" class="{{ request()->routeIs('dashboard.penjual') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                Pesanan
                            </a>
                            <a href="{{ route('dashboard.penjual.menu') }}" class="{{ request()->routeIs('dashboard.penjual.menu') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                Menu
                            </a>
                            <a href="{{ route('dashboard.penjual.statistik') }}" class="{{ request()->routeIs('dashboard.penjual.statistik') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Statistik
                            </a>
                            <a href="{{ route('dashboard.penjual.tarik-tunai') }}" class="{{ request()->routeIs('dashboard.penjual.tarik-tunai') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Tarik Tunai
                            </a>
                        </div>
                    </div>
                @elseif (Auth::user()->role === 'admin')
                    <div class="mobile-bottom-nav">
                        <div class="nav-items">
                            <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2z"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('dashboard.admin.penukaran') }}" class="{{ request()->routeIs('dashboard.admin.penukaran') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                Penukaran
                            </a>
                            <a href="{{ route('dashboard.admin.kategori') }}" class="{{ request()->routeIs('dashboard.admin.kategori') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                Kategori
                            </a>
                            <a href="{{ route('dashboard.admin.laporan') }}" class="{{ request()->routeIs('dashboard.admin.laporan') ? 'active' : '' }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                Laporan
                            </a>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Footer -->
            <footer class="content-wrap py-6 border-t" style="border-color: var(--line);">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs" style="color: var(--muted);">
                    <span>&copy; {{ date('Y') }} E-MPU Store &mdash; SMK Negeri 40 Jakarta</span>
                    <span>Sistem pre-order makanan sekolah</span>
                </div>
            </footer>
        </div>
    </body>
</html>
