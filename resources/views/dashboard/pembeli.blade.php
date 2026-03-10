<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div>
                <h1 class="text-2xl font-bold">Halo, {{ auth()->user()->name }}!</h1>
                <p class="section-subtitle">Pesan makanan kantin favorit kamu</p>
            </div>



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
            <div x-data="{
                search: '',
                kategori: 'semua',
                get filteredMenus() {
                    return Array.from(this.$refs.menuGrid?.children ?? []).forEach(el => {
                        const nama = (el.dataset.nama || '').toLowerCase();
                        const kat = el.dataset.kategori || '';
                        const matchSearch = !this.search || nama.includes(this.search.toLowerCase());
                        const matchKat = this.kategori === 'semua' || kat === this.kategori;
                        el.style.display = (matchSearch && matchKat) ? '' : 'none';
                    });
                }
            }" x-effect="filteredMenus">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Menu Kantin
                    </h3>
                    <span class="badge-green text-xs">{{ $menus->count() }} menu</span>
                </div>

                <!-- Search & Filter -->
                <div class="flex flex-col sm:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2" style="color: var(--muted);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" x-model="search" placeholder="Cari menu..." class="field !pl-10">
                    </div>
                    <div class="flex gap-1.5 overflow-x-auto pb-1 sm:pb-0 no-scrollbar">
                        @php
                            $kategoriList = ['semua', 'makanan', 'minuman', 'snack'];
                            $kategoriIcons = [
                                'semua' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>',
                                'makanan' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>',
                                'minuman' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                                'snack' => '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
                            ];
                        @endphp
                        @foreach ($kategoriList as $kat)
                            <button @click="kategori = '{{ $kat }}'"
                                    :class="kategori === '{{ $kat }}' ? 'filter-chip-active' : 'filter-chip'"
                                    class="whitespace-nowrap">
                                {!! $kategoriIcons[$kat] !!}
                                {{ ucfirst($kat) }}
                            </button>
                        @endforeach
                    </div>
                </div>

                @if ($menus->count() > 0)
                    <div x-ref="menuGrid" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-5">
                        @foreach ($menus as $menu)
                            <div class="panel rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group {{ $menu->stok <= 0 ? 'opacity-75' : '' }}"
                                 data-nama="{{ $menu->nama }}"
                                 data-kategori="{{ $menu->kategori ?? 'makanan' }}">
                                <!-- Menu Image -->
                                <div class="relative overflow-hidden {{ $menu->stok <= 0 ? 'grayscale' : '' }}">
                                    @if ($menu->foto)
                                        <div class="w-full h-32 sm:h-48 flex items-center justify-center" style="background-color: var(--bg-warm);">
                                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-105">
                                        </div>
                                    @else
                                        <div class="w-full h-32 sm:h-48 flex items-center justify-center" style="background: linear-gradient(135deg, var(--brand-soft) 0%, var(--gold-soft) 100%);">
                                            <svg class="w-10 h-10 sm:w-12 sm:h-12" style="color: var(--brand); opacity: 0.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                    @endif
                                    <!-- Sold Out Overlay -->
                                    @if ($menu->stok <= 0)
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-black/30 flex items-center justify-center">
                                            <span class="bg-[#C62828] text-white text-xs sm:text-sm font-bold px-3 sm:px-4 py-1 sm:py-1.5 rounded-full shadow-lg tracking-wide uppercase">Habis</span>
                                        </div>
                                    @endif
                                    <!-- Stock Badge Overlay -->
                                    <div class="absolute top-2 right-2 sm:top-2.5 sm:right-2.5">
                                        @if ($menu->stok <= 0)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-[#C62828] text-white shadow-sm">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Habis
                                            </span>
                                        @elseif ($menu->stok <= 5)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-amber-500 text-white shadow-sm">
                                                Sisa {{ $menu->stok }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-emerald-500 text-white shadow-sm">
                                                Stok {{ $menu->stok }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Menu Info -->
                                <div class="p-3 sm:p-4 flex-1 flex flex-col">
                                    <h4 class="font-semibold text-sm sm:text-base leading-snug mb-1 line-clamp-2" style="color: var(--ink);">{{ $menu->nama }}</h4>
                                    <!-- Seller Info -->
                                    <div class="flex items-center gap-1.5 sm:gap-2 mb-2 sm:mb-3">
                                        <div class="w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center text-white text-[7px] sm:text-[8px] font-bold shrink-0" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                                            {{ strtoupper(substr($menu->penjual->name ?? '-', 0, 1)) }}
                                        </div>
                                        <span class="text-[10px] sm:text-xs font-medium truncate" style="color: var(--muted);">{{ $menu->penjual->name ?? '-' }}</span>
                                    </div>
                                    <!-- Price -->
                                    <div class="mt-auto pt-2 sm:pt-3" style="border-top: 1px solid var(--line-light);">
                                        <p class="text-base sm:text-xl font-bold leading-none" style="color: var(--brand);">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <!-- Add to Cart -->
                                <div class="px-3 pb-3 sm:px-4 sm:pb-4">
                                    @if ($menu->stok > 0)
                                        <form method="POST" action="{{ route('dashboard.pembeli.cart.add', [], false) }}">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="hidden" name="jumlah" value="1">
                                            <button class="btn-primary w-full text-[11px] sm:text-xs !py-2 sm:!py-2.5 !rounded-xl !gap-1.5">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                                                <span class="sm:hidden">Keranjang</span>
                                                <span class="hidden sm:inline">Tambah ke Keranjang</span>
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full text-[11px] sm:text-xs py-2 sm:py-2.5 rounded-xl font-semibold bg-stone-100 text-stone-400 cursor-not-allowed inline-flex items-center justify-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            Stok Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- No results message -->
                    <div x-show="search || kategori !== 'semua'" x-cloak>
                        <template x-if="(() => { const items = Array.from($refs.menuGrid?.children ?? []); return items.length > 0 && items.every(el => el.style.display === 'none'); })()">
                            <div class="panel-section mt-5">
                                <div class="empty-state">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <p>Menu tidak ditemukan.</p>
                                    <p class="text-xs mt-1" style="color: var(--muted);">Coba ubah kata kunci atau filter kategori.</p>
                                </div>
                            </div>
                        </template>
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
