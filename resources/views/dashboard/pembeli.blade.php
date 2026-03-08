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
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
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
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-orange-200 text-sm font-medium">Saldo Kamu</p>
                        <p class="text-3xl sm:text-4xl font-bold mt-1">Rp {{ number_format((float) auth()->user()->saldo, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard.pembeli.topup') }}" class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white rounded-xl px-4 py-2.5 text-sm font-semibold transition-colors duration-150 backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Top Up
                        </a>
                        <a href="{{ route('dashboard.pembeli.riwayat') }}" class="inline-flex items-center gap-2 bg-white/20 hover:bg-white/30 text-white rounded-xl px-4 py-2.5 text-sm font-semibold transition-colors duration-150 backdrop-blur-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
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
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach ($menus as $menu)
                            <div class="panel rounded-xl overflow-hidden hover:shadow-lg transition-shadow duration-200 flex flex-col">
                                <!-- Menu Image -->
                                @if ($menu->foto)
                                    <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}" class="w-full h-36 object-cover">
                                @else
                                    <div class="w-full h-36 flex items-center justify-center" style="background-color: var(--brand-soft);">
                                        <svg class="w-10 h-10" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                @endif
                                <!-- Menu Info -->
                                <div class="p-4 flex-1">
                                    <div class="min-w-0 mb-2">
                                        <h4 class="font-semibold text-stone-800 truncate">{{ $menu->nama }}</h4>
                                        <p class="text-xs truncate" style="color: var(--muted);">{{ $menu->penjual->name ?? '-' }}</p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-bold" style="color: var(--brand);">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                        <span class="text-xs font-medium" style="color: var(--muted);">Stok: {{ $menu->stok }}</span>
                                    </div>
                                </div>
                                <!-- Add to Cart -->
                                <div class="px-4 pb-4">
                                    <form method="POST" action="{{ route('dashboard.pembeli.cart.add') }}">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button class="btn-primary w-full text-xs !py-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                                            Tambah ke Keranjang
                                        </button>
                                    </form>
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
