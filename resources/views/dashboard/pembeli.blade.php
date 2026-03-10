<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Halo, {{ auth()->user()->name }}!</h1>
                    <p class="section-subtitle">Pesan makanan kantin favorit kamu</p>
                </div>
                <a href="{{ route('dashboard.pembeli.cart') }}" class="btn-primary relative">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Keranjang
                    @if ($cartCount > 0)
                        <span class="absolute -top-2 -right-2 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center" style="background-color: var(--brand);">{{ $cartCount }}</span>
                    @endif
                </a>
            </div>

            @if (session('status'))
                <div class="status-banner">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="error-banner">
                    <p class="font-semibold mb-2">Validasi gagal:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Saldo Card -->
            <div class="saldo-card">
                <div class="relative z-10 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-[#FFD600]">Saldo Kamu</p>
                        <p class="text-2xl sm:text-4xl font-bold mt-1 whitespace-nowrap">Rp {{ number_format((float) auth()->user()->saldo, 0, ',', '.') }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('dashboard.pembeli.topup') }}" class="flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 text-white rounded-xl px-3 py-2.5 text-sm font-semibold transition-colors duration-150 backdrop-blur-sm whitespace-nowrap">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Top Up
                        </a>
                        <a href="{{ route('dashboard.pembeli.riwayat') }}" class="flex items-center justify-center gap-2 bg-white/20 hover:bg-white/30 text-white rounded-xl px-3 py-2.5 text-sm font-semibold transition-colors duration-150 backdrop-blur-sm whitespace-nowrap">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Riwayat
                        </a>
                    </div>
                </div>
            </div>

            <!-- Menu Catalog -->
            <div>
                <div class="flex items-center justify-between mb-5">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Menu Kantin
                    </h3>
                    <span class="badge-green text-xs">{{ $menus->count() }} menu</span>
                </div>

                @if ($menus->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach ($menus as $menu)
                            <div class="panel rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group {{ $menu->stok <= 0 ? 'opacity-75' : '' }}">
                                <!-- Menu Image -->
                                <div class="relative overflow-hidden {{ $menu->stok <= 0 ? 'grayscale' : '' }}">
                                    @if ($menu->foto)
                                        <div class="w-full h-48 flex items-center justify-center" style="background-color: var(--bg-warm);">
                                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                                        </div>
                                    @else
                                        <div class="w-full h-48 flex items-center justify-center" style="background: linear-gradient(135deg, var(--brand-soft) 0%, var(--gold-soft) 100%);">
                                            <svg class="w-12 h-12" style="color: var(--brand); opacity: 0.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                    @endif
                                    <!-- Sold Out Overlay -->
                                    @if ($menu->stok <= 0)
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/30 flex items-center justify-center">
                                            <span class="bg-[#C62828] text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg tracking-wide uppercase">Habis</span>
                                        </div>
                                    @endif
                                    <!-- Stock Badge Overlay -->
                                    <div class="absolute top-2.5 right-2.5">
                                        @if ($menu->stok <= 0)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-[#C62828] text-white shadow-sm">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Habis
                                            </span>
                                        @elseif ($menu->stok <= 5)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500 text-white shadow-sm">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                                                Sisa {{ $menu->stok }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500 text-white shadow-sm">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Stok {{ $menu->stok }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Menu Info -->
                                <div class="p-4 flex-1 flex flex-col">
                                    <h4 class="font-semibold text-base leading-snug mb-1" style="color: var(--ink);">{{ $menu->nama }}</h4>
                                    <!-- Seller Info -->
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-white text-[8px] font-bold shrink-0" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                                            {{ strtoupper(substr($menu->penjual->name ?? '-', 0, 1)) }}
                                        </div>
                                        <span class="text-xs font-medium truncate" style="color: var(--muted);">{{ $menu->penjual->name ?? '-' }}</span>
                                    </div>
                                    <!-- Price -->
                                    <div class="mt-auto pt-3" style="border-top: 1px solid var(--line-light);">
                                        <div class="flex items-end justify-between">
                                            <div>
                                                <span class="text-[10px] font-medium uppercase tracking-wider" style="color: var(--muted);">Harga</span>
                                                <p class="text-xl font-bold leading-none mt-0.5" style="color: var(--yellow);">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Add to Cart -->
                                <div class="px-4 pb-4">
                                    @if ($menu->stok > 0)
                                        <form method="POST" action="{{ route('dashboard.pembeli.cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="hidden" name="jumlah" value="1">
                                            <button class="btn-primary w-full text-xs !py-2.5 !rounded-xl">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                                Tambah ke Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full text-xs py-2.5 rounded-xl font-semibold bg-stone-100 text-stone-400 cursor-not-allowed inline-flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel-section">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <p>Belum ada menu tersedia saat ini.</p>
                            <p class="text-xs mt-1" style="color: var(--muted);">Menu akan muncul setelah penjual menambahkan menu dengan stok.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
