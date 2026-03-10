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

            <!-- Page Content -->
            <main class="pb-20 sm:pb-12">
                {{ $slot }}
            </main>

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
