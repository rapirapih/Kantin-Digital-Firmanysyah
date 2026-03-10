<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'E-MPU Store') }} &mdash; Sistem Pre-Order Kantin Sekolah</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .highlight-underline { position: relative; display: inline-block; }
            .highlight-underline::after {
                content: ''; position: absolute; bottom: 2px; left: 0; width: 100%; height: 0.3em;
                background: #FFD600; opacity: 0.4; border-radius: 2px; z-index: -1;
            }
        </style>
    </head>
    <body class="antialiased bg-white text-gray-900">

        {{-- ═══════════════════════════════════════
             HEADER
        ═══════════════════════════════════════ --}}
        <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100" x-data="{ mobileOpen: false }">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    {{-- Logo --}}
                    <a href="/" class="flex items-center gap-2.5">
                        <img src="{{ asset('images/Logo_SMK_Negeri_40_Jakarta.png') }}" alt="Logo" class="w-9 h-9 rounded-lg object-contain">
                        <span class="text-xl font-bold tracking-tight">E-MPU Store</span>
                    </a>

                    {{-- Desktop Nav --}}
                    <nav class="hidden lg:flex items-center gap-8">
                        <a href="#layanan" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Layanan</a>
                        <a href="#cara-kerja" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Cara Kerja</a>
                        <a href="#portofolio" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Portofolio</a>
                    </nav>

                    {{-- Right buttons --}}
                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-[#C62828] text-white text-sm font-semibold rounded-full hover:bg-[#8E0000] transition-colors">
                                    Dashboard
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-[#C62828] text-white text-sm font-semibold rounded-full hover:bg-[#8E0000] transition-colors">
                                        Daftar
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                @endif
                            @endauth
                        @endif
                        {{-- Mobile hamburger --}}
                        <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition" aria-label="Menu">
                            <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                                <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            {{-- Mobile dropdown --}}
            <div x-show="mobileOpen" x-cloak class="lg:hidden border-t border-gray-100 bg-white">
                <div class="px-6 py-4 space-y-3">
                    <a href="#layanan" @click="mobileOpen = false" class="block text-base font-medium text-gray-700 py-2">Layanan</a>
                    <a href="#cara-kerja" @click="mobileOpen = false" class="block text-base font-medium text-gray-700 py-2">Cara Kerja</a>
                    <a href="#portofolio" @click="mobileOpen = false" class="block text-base font-medium text-gray-700 py-2">Portofolio</a>
                    @guest
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block w-full text-center px-5 py-2.5 bg-[#C62828] text-white text-sm font-semibold rounded-full mt-2">Daftar Sekarang</a>
                        @endif
                    @endguest
                </div>
            </div>
        </header>

        {{-- ═══════════════════════════════════════
             HERO — Split layout
        ═══════════════════════════════════════ --}}
        <section class="bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16 sm:py-20 lg:py-28">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    {{-- Left — Text --}}
                    <div class="max-w-xl">
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#FFF8E1] text-sm font-medium text-gray-700 mb-6 border border-[#FFD600]/30">
                            <span class="w-2 h-2 rounded-full bg-[#F9A825]"></span>
                            Sistem Kantin Digital
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-[1.08] tracking-tight text-gray-900">
                            Pesan makanan kantin
                            <span class="highlight-underline">tanpa antre</span>,
                            cukup dari <span class="highlight-underline">HP kamu</span>
                        </h1>

                        <p class="mt-6 text-lg leading-relaxed text-gray-500">
                            E-MPU Store memudahkan siswa dan guru untuk pre-order makanan kantin,
                            pilih sesi istirahat, dan ambil pesanan tanpa harus mengantre panjang.
                        </p>

                        <div class="mt-8 flex flex-wrap items-center gap-4">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-[#C62828] text-white text-sm font-semibold rounded-full hover:bg-[#8E0000] transition-colors shadow-lg shadow-red-500/20">
                                    Mulai Sekarang
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-7 py-3.5 text-gray-700 text-sm font-semibold rounded-full border border-gray-200 hover:border-gray-300 hover:bg-gray-50 transition-colors">
                                    Sudah punya akun?
                                </a>
                            @endif
                        </div>

                        {{-- Stats row --}}
                        <div class="mt-12 pt-8 border-t border-gray-100 grid grid-cols-3 gap-6">
                            <div>
                                <div class="text-2xl font-extrabold text-gray-900">3</div>
                                <div class="text-xs text-gray-400 mt-0.5 font-medium">Role Pengguna</div>
                            </div>
                            <div>
                                <div class="text-2xl font-extrabold text-gray-900">2</div>
                                <div class="text-xs text-gray-400 mt-0.5 font-medium">Sesi Istirahat</div>
                            </div>
                            <div>
                                <div class="text-2xl font-extrabold text-gray-900">&infin;</div>
                                <div class="text-xs text-gray-400 mt-0.5 font-medium">Menu Variatif</div>
                            </div>
                        </div>
                    </div>

                    {{-- Right — Sketch Illustration --}}
                    <div class="hidden lg:flex items-center justify-center">
                        <svg viewBox="0 0 500 480" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto max-w-lg">
                            {{-- Monitor --}}
                            <rect x="100" y="60" width="300" height="220" rx="16" stroke="#C62828" stroke-width="2.5"/>
                            <rect x="120" y="80" width="260" height="175" rx="4" stroke="#C62828" stroke-width="1.5" fill="#FFF8E1" fill-opacity="0.4"/>
                            <path d="M200 290 L170 340 L330 340 L300 290" stroke="#C62828" stroke-width="2.5"/>
                            <line x1="155" y1="340" x2="345" y2="340" stroke="#C62828" stroke-width="2.5"/>
                            {{-- Screen content --}}
                            <rect x="140" y="100" width="80" height="10" rx="3" fill="#C62828" fill-opacity="0.25"/>
                            <rect x="140" y="120" width="120" height="6" rx="2" fill="#FFD600" fill-opacity="0.5"/>
                            <rect x="140" y="135" width="100" height="6" rx="2" fill="#C62828" fill-opacity="0.12"/>
                            <rect x="140" y="150" width="110" height="6" rx="2" fill="#C62828" fill-opacity="0.12"/>
                            {{-- Image placeholder --}}
                            <rect x="290" y="100" width="70" height="55" rx="6" stroke="#C62828" stroke-width="1.5" fill="#FFD600" fill-opacity="0.18"/>
                            <circle cx="310" cy="118" r="8" stroke="#C62828" stroke-width="1.2"/>
                            <path d="M295 145 L310 128 L325 140 L340 130 L355 148" stroke="#C62828" stroke-width="1.2" fill="none"/>
                            {{-- Buttons on screen --}}
                            <rect x="140" y="175" width="60" height="22" rx="6" fill="#C62828" fill-opacity="0.85"/>
                            <rect x="210" y="175" width="60" height="22" rx="6" stroke="#C62828" stroke-width="1.2" fill="none"/>
                            {{-- Grid blocks --}}
                            <rect x="140" y="210" width="55" height="32" rx="4" stroke="#C62828" stroke-width="1" fill="#FFD600" fill-opacity="0.12"/>
                            <rect x="205" y="210" width="55" height="32" rx="4" stroke="#C62828" stroke-width="1" fill="#C62828" fill-opacity="0.06"/>
                            <rect x="270" y="210" width="55" height="32" rx="4" stroke="#C62828" stroke-width="1" fill="#FFD600" fill-opacity="0.12"/>
                            {{-- Floating shapes --}}
                            <circle cx="80" cy="120" r="22" stroke="#C62828" stroke-width="2" stroke-dasharray="4 4"/>
                            <circle cx="80" cy="120" r="8" fill="#FFD600" fill-opacity="0.6"/>
                            <rect x="400" y="100" width="50" height="50" rx="8" stroke="#C62828" stroke-width="2" stroke-dasharray="4 4" transform="rotate(12, 425, 125)"/>
                            {{-- Stars --}}
                            <path d="M420 200 L425 190 L430 200 L440 205 L430 210 L425 220 L420 210 L410 205 Z" fill="#FFD600" fill-opacity="0.7" stroke="#C62828" stroke-width="1"/>
                            <path d="M70 220 L73 213 L76 220 L83 223 L76 226 L73 233 L70 226 L63 223 Z" fill="#FFD600" fill-opacity="0.5" stroke="#C62828" stroke-width="0.8"/>
                            {{-- Cursor --}}
                            <path d="M360 170 L360 195 L370 188 L380 200" stroke="#C62828" stroke-width="2"/>
                            {{-- Coffee --}}
                            <rect x="55" y="300" width="40" height="35" rx="4" stroke="#C62828" stroke-width="2"/>
                            <path d="M95 310 Q110 310 110 325 Q110 335 95 335" stroke="#C62828" stroke-width="1.8" fill="none"/>
                            <path d="M62 300 Q65 290 70 300" stroke="#C62828" stroke-width="1.2" fill="none"/>
                            <path d="M75 298 Q78 286 81 298" stroke="#C62828" stroke-width="1.2" fill="none"/>
                            {{-- Plant --}}
                            <rect x="390" y="310" width="35" height="40" rx="3" stroke="#C62828" stroke-width="2" fill="#FFD600" fill-opacity="0.12"/>
                            <path d="M400 310 Q395 285 408 275" stroke="#C62828" stroke-width="1.8" fill="none"/>
                            <path d="M412 310 Q420 280 410 268" stroke="#C62828" stroke-width="1.8" fill="none"/>
                            <path d="M407 310 Q400 290 415 278" stroke="#C62828" stroke-width="1.8" fill="none"/>
                            {{-- Pencil --}}
                            <line x1="140" y1="380" x2="220" y2="360" stroke="#C62828" stroke-width="2.5"/>
                            <path d="M220 360 L228 357 L225 365 Z" fill="#FFD600" stroke="#C62828" stroke-width="1"/>
                            {{-- Gear --}}
                            <circle cx="350" cy="390" r="18" stroke="#C62828" stroke-width="2" fill="none"/>
                            <circle cx="350" cy="390" r="8" stroke="#C62828" stroke-width="1.5" fill="#FFD600" fill-opacity="0.3"/>
                            <line x1="350" y1="368" x2="350" y2="374" stroke="#C62828" stroke-width="2.5"/>
                            <line x1="350" y1="406" x2="350" y2="412" stroke="#C62828" stroke-width="2.5"/>
                            <line x1="328" y1="390" x2="334" y2="390" stroke="#C62828" stroke-width="2.5"/>
                            <line x1="366" y1="390" x2="372" y2="390" stroke="#C62828" stroke-width="2.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════
             LOGO BAR — monochrome on white
        ═══════════════════════════════════════ --}}
        <section class="bg-white border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
                <p class="text-center text-xs font-semibold uppercase tracking-widest text-gray-400 mb-8">Dipercaya oleh sekolah & kantin</p>
                <div class="grid grid-cols-3 sm:grid-cols-6 gap-8 items-center justify-items-center">
                    @foreach (['SMK 40', 'Kantin A', 'Kantin B', 'Koperasi', 'OSIS', 'BK'] as $logo)
                        <div class="flex items-center gap-2 opacity-40 hover:opacity-70 transition-opacity">
                            <svg class="w-6 h-6 text-gray-900" viewBox="0 0 24 24" fill="none">
                                <rect x="3" y="3" width="18" height="18" rx="4" stroke="currentColor" stroke-width="1.5"/>
                                <circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            <span class="text-sm font-bold text-gray-900 tracking-tight hidden sm:block">{{ $logo }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════
             SERVICES GRID — 2×2 alternating light/dark
        ═══════════════════════════════════════ --}}
        <section id="layanan" class="bg-[#FAFAFA] py-20 sm:py-28">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                {{-- Section heading --}}
                <div class="max-w-2xl mb-14">
                    <p class="text-sm font-semibold uppercase tracking-widest text-[#C62828] mb-3">Layanan Kami</p>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900">
                        Fitur yang <span class="highlight-underline">memudahkan</span> semua pihak
                    </h2>
                    <p class="mt-4 text-lg text-gray-500 leading-relaxed">
                        Solusi lengkap dari pemesanan hingga pengambilan, dirancang untuk admin, penjual, dan pembeli.
                    </p>
                </div>

                {{-- 2×2 grid --}}
                <div class="grid sm:grid-cols-2 gap-5">
                    {{-- Card 1 — Light --}}
                    <div class="group relative rounded-3xl p-8 sm:p-10 bg-white border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <span class="absolute top-6 right-8 text-7xl font-black leading-none select-none text-gray-900/[0.04]">01</span>
                        <div class="mb-6 w-16 h-16 rounded-2xl flex items-center justify-center bg-[#FFF8E1]">
                            <svg viewBox="0 0 64 64" fill="none" class="w-10 h-10">
                                <circle cx="32" cy="32" r="26" stroke="#C62828" stroke-width="2"/>
                                <circle cx="32" cy="32" r="4" fill="#C62828" fill-opacity="0.3" stroke="#C62828" stroke-width="1.5"/>
                                <line x1="32" y1="10" x2="32" y2="22" stroke="#C62828" stroke-width="1.5"/>
                                <line x1="32" y1="42" x2="32" y2="54" stroke="#C62828" stroke-width="1.5"/>
                                <line x1="10" y1="32" x2="22" y2="32" stroke="#C62828" stroke-width="1.5"/>
                                <line x1="42" y1="32" x2="54" y2="32" stroke="#C62828" stroke-width="1.5"/>
                                <path d="M28 20 L36 20" stroke="#FFD600" stroke-width="2"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900">Manajemen Admin</h3>
                        <p class="text-sm leading-relaxed text-gray-500">Kelola seluruh pengguna, pantau statistik penjualan harian, atur role, dan monitoring semua pesanan dalam satu dashboard.</p>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#C62828]">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>

                    {{-- Card 2 — Dark (Red) --}}
                    <div class="group relative rounded-3xl p-8 sm:p-10 bg-[#C62828] text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <span class="absolute top-6 right-8 text-7xl font-black leading-none select-none text-white/[0.06]">02</span>
                        <div class="mb-6 w-16 h-16 rounded-2xl flex items-center justify-center bg-white/10">
                            <svg viewBox="0 0 64 64" fill="none" class="w-10 h-10">
                                <rect x="12" y="8" width="40" height="48" rx="4" stroke="white" stroke-width="2"/>
                                <line x1="12" y1="18" x2="52" y2="18" stroke="white" stroke-width="1.5"/>
                                <circle cx="18" cy="13" r="2" fill="white" fill-opacity="0.4"/>
                                <circle cx="24" cy="13" r="2" fill="#FFD600" fill-opacity="0.6"/>
                                <circle cx="30" cy="13" r="2" fill="white" fill-opacity="0.2"/>
                                <rect x="18" y="24" width="28" height="16" rx="2" stroke="white" stroke-width="1.2" fill="#FFD600" fill-opacity="0.1"/>
                                <rect x="18" y="44" width="12" height="6" rx="2" fill="white" fill-opacity="0.15"/>
                                <rect x="34" y="44" width="12" height="6" rx="2" stroke="white" stroke-width="1"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Kelola Menu Jualan</h3>
                        <p class="text-sm leading-relaxed text-red-100">Penjual bisa CRUD menu, atur stok & harga, terima pesanan masuk, dan update status per sesi istirahat secara realtime.</p>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#FFD600]">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>

                    {{-- Card 3 — Dark (Red) --}}
                    <div class="group relative rounded-3xl p-8 sm:p-10 bg-[#C62828] text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <span class="absolute top-6 right-8 text-7xl font-black leading-none select-none text-white/[0.06]">03</span>
                        <div class="mb-6 w-16 h-16 rounded-2xl flex items-center justify-center bg-white/10">
                            <svg viewBox="0 0 64 64" fill="none" class="w-10 h-10">
                                <rect x="6" y="12" width="52" height="36" rx="4" stroke="white" stroke-width="2"/>
                                <path d="M22 24 L14 32 L22 40" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M42 24 L50 32 L42 40" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="28" y1="40" x2="36" y2="24" stroke="#FFD600" stroke-width="2" stroke-linecap="round"/>
                                <line x1="24" y1="52" x2="40" y2="52" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Pre-Order Mudah</h3>
                        <p class="text-sm leading-relaxed text-red-100">Pembeli bisa jelajahi daftar menu, tambah ke keranjang, pilih sesi pengambilan, dan bayar langsung dari saldo digital.</p>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#FFD600]">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>

                    {{-- Card 4 — Light --}}
                    <div class="group relative rounded-3xl p-8 sm:p-10 bg-white border border-gray-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <span class="absolute top-6 right-8 text-7xl font-black leading-none select-none text-gray-900/[0.04]">04</span>
                        <div class="mb-6 w-16 h-16 rounded-2xl flex items-center justify-center bg-[#FFF8E1]">
                            <svg viewBox="0 0 64 64" fill="none" class="w-10 h-10">
                                <path d="M12 48 L12 28" stroke="#C62828" stroke-width="2" stroke-linecap="round"/>
                                <path d="M22 48 L22 22" stroke="#FFD600" stroke-width="3" stroke-linecap="round"/>
                                <path d="M32 48 L32 32" stroke="#C62828" stroke-width="2" stroke-linecap="round"/>
                                <path d="M42 48 L42 18" stroke="#C62828" stroke-width="2" stroke-linecap="round"/>
                                <path d="M52 48 L52 12" stroke="#C62828" stroke-width="2" stroke-linecap="round"/>
                                <circle cx="52" cy="12" r="4" fill="#FFD600" fill-opacity="0.6" stroke="#C62828" stroke-width="1.2"/>
                                <line x1="8" y1="48" x2="56" y2="48" stroke="#C62828" stroke-width="1.5"/>
                                <path d="M12 28 Q22 20 32 32 Q42 16 52 12" stroke="#C62828" stroke-width="1.2" stroke-dasharray="3 3" fill="none"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-900">Saldo & Top Up</h3>
                        <p class="text-sm leading-relaxed text-gray-500">Sistem saldo digital dengan top-up tunai atau transfer. Admin bisa approve permintaan top-up, riwayat tercatat rapi.</p>
                        <div class="mt-6">
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#C62828]">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════
             CTA BANNER — Red bg with rocket sketch
        ═══════════════════════════════════════ --}}
        <section class="bg-white">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 sm:py-28">
                <div class="relative bg-[#C62828] rounded-[2rem] overflow-hidden">
                    {{-- Decorative blobs --}}
                    <div class="absolute top-0 right-0 w-72 h-72 rounded-full opacity-10" style="background: radial-gradient(circle, #FFD600, transparent 70%); transform: translate(30%, -40%);"></div>
                    <div class="absolute bottom-0 left-0 w-56 h-56 rounded-full opacity-10" style="background: radial-gradient(circle, #FFD600, transparent 70%); transform: translate(-30%, 40%);"></div>

                    <div class="relative z-10 grid lg:grid-cols-2 gap-10 items-center p-8 sm:p-12 lg:p-16">
                        {{-- Text --}}
                        <div>
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight tracking-tight">
                                Siap bergabung?<br>
                                <span class="text-[#FFD600]">Daftar sekarang!</span>
                            </h2>
                            <p class="mt-4 text-red-100 text-lg leading-relaxed max-w-md">
                                Rasakan kemudahan memesan makanan kantin sekolah tanpa harus mengantre.
                            </p>
                            <div class="mt-8 flex flex-wrap gap-3">
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-[#C62828] text-sm font-bold rounded-full hover:bg-[#FFD600] hover:text-gray-900 transition-colors shadow-lg">
                                        Daftar Sekarang
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                @endif
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-7 py-3.5 text-white text-sm font-semibold rounded-full border border-white/25 hover:bg-white/10 transition-colors">
                                        Masuk ke Akun
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{-- Rocket illustration --}}
                        <div class="hidden lg:flex items-center justify-center">
                            <svg viewBox="0 0 400 350" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto max-w-sm">
                                <ellipse cx="200" cy="160" rx="35" ry="70" stroke="white" stroke-width="2.5" fill="white" fill-opacity="0.1"/>
                                <path d="M165 160 Q155 190 175 210" stroke="white" stroke-width="2" fill="#FFD600" fill-opacity="0.3"/>
                                <path d="M235 160 Q245 190 225 210" stroke="white" stroke-width="2" fill="#FFD600" fill-opacity="0.3"/>
                                <circle cx="200" cy="140" r="10" stroke="white" stroke-width="1.8" fill="white" fill-opacity="0.12"/>
                                <path d="M185 210 L192 240 L200 225 L208 240 L215 210" stroke="white" stroke-width="2" fill="#FFD600" fill-opacity="0.5"/>
                                <path d="M192 240 Q188 260 196 270 Q192 280 200 290" stroke="white" stroke-width="1.5" fill="none"/>
                                <path d="M208 240 Q212 260 204 270 Q208 280 200 290" stroke="white" stroke-width="1.5" fill="none"/>
                                <path d="M200 245 Q200 265 200 285" stroke="#FFD600" stroke-width="2" stroke-dasharray="3 4"/>
                                {{-- Stars --}}
                                <path d="M120 100 L124 88 L128 100 L140 104 L128 108 L124 120 L120 108 L108 104 Z" fill="#FFD600" fill-opacity="0.8" stroke="white" stroke-width="0.8"/>
                                <path d="M280 80 L283 72 L286 80 L294 83 L286 86 L283 94 L280 86 L272 83 Z" fill="#FFD600" fill-opacity="0.6" stroke="white" stroke-width="0.8"/>
                                <path d="M300 180 L302 174 L304 180 L310 182 L304 184 L302 190 L300 184 L294 182 Z" fill="#FFD600" fill-opacity="0.5" stroke="white" stroke-width="0.8"/>
                                <path d="M90 180 L92 174 L94 180 L100 182 L94 184 L92 190 L90 184 L84 182 Z" fill="#FFD600" fill-opacity="0.5" stroke="white" stroke-width="0.8"/>
                                {{-- Clouds --}}
                                <ellipse cx="130" cy="200" rx="30" ry="12" stroke="white" stroke-width="1.2" fill="white" fill-opacity="0.1"/>
                                <ellipse cx="145" cy="193" rx="18" ry="10" stroke="white" stroke-width="1.2" fill="white" fill-opacity="0.1"/>
                                <ellipse cx="280" cy="160" rx="25" ry="10" stroke="white" stroke-width="1.2" fill="white" fill-opacity="0.1"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════
             CASE STUDIES / CARA KERJA — 3 cards dark bg
        ═══════════════════════════════════════ --}}
        <section id="cara-kerja" class="bg-gray-950 py-20 sm:py-28">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                {{-- Heading --}}
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-14">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-widest text-[#FFD600] mb-3">Cara Kerja</p>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white">
                            Tiga langkah <span class="text-[#FFD600]">mudah</span>
                        </h2>
                    </div>
                </div>

                {{-- 3 Cards --}}
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    {{-- Card 1 --}}
                    <div class="group relative rounded-3xl overflow-hidden bg-gray-900 border border-gray-800 hover:border-gray-700 transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg, #1A0000 0%, #4A0000 100%);">
                            <div class="absolute inset-0 flex items-center justify-center opacity-20 group-hover:opacity-30 transition-opacity">
                                <svg viewBox="0 0 200 150" class="w-32 h-24" fill="none">
                                    <rect x="20" y="15" width="160" height="110" rx="8" stroke="#FFD600" stroke-width="1.5" stroke-dasharray="6 4"/>
                                    <circle cx="100" cy="70" r="25" stroke="#FFD600" stroke-width="1.5"/>
                                    <path d="M88 70 L97 79 L115 61" stroke="#FFD600" stroke-width="2" fill="none"/>
                                </svg>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-sm text-white border border-white/10">Langkah 1</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-white leading-snug group-hover:text-[#FFD600] transition-colors">Pilih menu dari daftar kantin</h3>
                            <p class="mt-2 text-sm text-gray-400">Lihat semua menu yang dijual penjual kantin. Filter berdasarkan ketersediaan stok.</p>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="group relative rounded-3xl overflow-hidden bg-gray-900 border border-gray-800 hover:border-gray-700 transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg, #0A0A0A 0%, #2A2A2A 100%);">
                            <div class="absolute inset-0 flex items-center justify-center opacity-20 group-hover:opacity-30 transition-opacity">
                                <svg viewBox="0 0 200 150" class="w-32 h-24" fill="none">
                                    <rect x="50" y="20" width="100" height="110" rx="8" stroke="#FFD600" stroke-width="1.5" stroke-dasharray="6 4"/>
                                    <circle cx="100" cy="55" r="15" stroke="#FFD600" stroke-width="1.2"/>
                                    <rect x="70" y="80" width="60" height="8" rx="4" stroke="#FFD600" stroke-width="1"/>
                                    <rect x="80" y="95" width="40" height="8" rx="4" stroke="#FFD600" stroke-width="1"/>
                                    <rect x="75" y="112" width="50" height="12" rx="6" stroke="#FFD600" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-sm text-white border border-white/10">Langkah 2</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-white leading-snug group-hover:text-[#FFD600] transition-colors">Buat pre-order & pilih sesi</h3>
                            <p class="mt-2 text-sm text-gray-400">Masukkan ke keranjang, pilih waktu pengambilan istirahat 1 atau 2, lalu bayar dari saldo.</p>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="group relative rounded-3xl overflow-hidden bg-gray-900 border border-gray-800 hover:border-gray-700 transition-all duration-300 hover:-translate-y-1">
                        <div class="aspect-[4/3] relative overflow-hidden" style="background: linear-gradient(135deg, #1A0000 0%, #3D0000 100%);">
                            <div class="absolute inset-0 flex items-center justify-center opacity-20 group-hover:opacity-30 transition-opacity">
                                <svg viewBox="0 0 200 150" class="w-32 h-24" fill="none">
                                    <path d="M60 110 L100 40 L140 110 Z" stroke="#FFD600" stroke-width="1.5" fill="none" stroke-dasharray="6 4"/>
                                    <circle cx="100" cy="75" r="12" stroke="#FFD600" stroke-width="1.5"/>
                                    <path d="M95 75 L99 79 L107 71" stroke="#FFD600" stroke-width="2" fill="none"/>
                                    <path d="M100 95 L100 105" stroke="#FFD600" stroke-width="1.5" stroke-dasharray="2 3"/>
                                </svg>
                            </div>
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-white/10 backdrop-blur-sm text-white border border-white/10">Langkah 3</span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-white leading-snug group-hover:text-[#FFD600] transition-colors">Ambil pesanan saat istirahat</h3>
                            <p class="mt-2 text-sm text-gray-400">Saat jam istirahat tiba, langsung ambil pesananmu yang sudah siap. Tanpa antre!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════════════════
             FOOTER
        ═══════════════════════════════════════ --}}
        <footer class="bg-gray-950 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-14">
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
                    {{-- Brand --}}
                    <div class="sm:col-span-2 lg:col-span-1">
                        <div class="flex items-center gap-2.5 mb-4">
                            <img src="{{ asset('images/Logo_SMK_Negeri_40_Jakarta.png') }}" alt="Logo" class="w-8 h-8 rounded-lg object-contain">
                            <span class="text-lg font-bold text-white">E-MPU Store</span>
                        </div>
                        <p class="text-sm text-gray-400 leading-relaxed max-w-xs">
                            Sistem pre-order kantin digital untuk SMK Negeri 40 Jakarta. Pesan, bayar, ambil — semudah itu.
                        </p>
                    </div>
                    {{-- Links --}}
                    <div>
                        <p class="text-sm font-semibold text-white mb-4">Menu</p>
                        <ul class="space-y-2.5">
                            <li><a href="#layanan" class="text-sm text-gray-400 hover:text-[#FFD600] transition-colors">Layanan</a></li>
                            <li><a href="#cara-kerja" class="text-sm text-gray-400 hover:text-[#FFD600] transition-colors">Cara Kerja</a></li>
                            <li><a href="#portofolio" class="text-sm text-gray-400 hover:text-[#FFD600] transition-colors">Portofolio</a></li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white mb-4">Peran</p>
                        <ul class="space-y-2.5">
                            <li><span class="text-sm text-gray-400">Admin</span></li>
                            <li><span class="text-sm text-gray-400">Penjual</span></li>
                            <li><span class="text-sm text-gray-400">Pembeli</span></li>
                        </ul>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white mb-4">Akun</p>
                        <ul class="space-y-2.5">
                            @if (Route::has('login'))
                                <li><a href="{{ route('login') }}" class="text-sm text-gray-400 hover:text-[#FFD600] transition-colors">Masuk</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li><a href="{{ route('register') }}" class="text-sm text-gray-400 hover:text-[#FFD600] transition-colors">Daftar</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-gray-500">&copy; {{ date('Y') }} E-MPU Store — SMK Negeri 40 Jakarta</p>
                    <p class="text-xs text-gray-500">Sistem pre-order kantin sekolah</p>
                </div>
            </div>
        </footer>

    </body>
</html>
