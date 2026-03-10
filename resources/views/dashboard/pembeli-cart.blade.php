<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
                    <p class="section-subtitle">Review pesanan & langsung bayar</p>
                </div>
                <a href="{{ route('dashboard.pembeli') }}" class="btn-secondary !px-3 sm:!px-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span class="hidden sm:inline">Lanjut Belanja</span>
                </a>
            </div>



            @if ($cartItems->count() > 0)
                <div class="flex flex-col lg:flex-row gap-6 lg:items-start">

                    <!-- LEFT: Cart Items -->
                    <div class="flex-1 min-w-0 space-y-3">
                        @foreach ($cartItems as $item)
                            <div class="panel-section">
                                <div class="flex items-center gap-3">
                                    <!-- Menu Image / Icon -->
                                    @if ($item->menu->foto)
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden shrink-0" style="background-color: var(--bg-warm);">
                                            <img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl flex items-center justify-center shrink-0" style="background-color: var(--brand-soft);">
                                            <svg class="w-6 h-6" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                    @endif

                                    <!-- Info + Controls -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-sm sm:text-base text-stone-800 truncate">{{ $item->menu->nama }}</h4>
                                        <p class="text-xs sm:text-sm font-medium" style="color: var(--brand);">Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</p>

                                        <!-- Qty + Remove row -->
                                        <div class="flex items-center justify-between mt-2">
                                            <div class="flex items-center gap-1">
                                                {{-- Decrease --}}
                                                @if ($item->jumlah > 1)
                                                    <form method="POST" action="{{ route('dashboard.pembeli.cart.update', $item, false) }}">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="jumlah" value="{{ $item->jumlah - 1 }}">
                                                        <button class="w-8 h-8 rounded-lg flex items-center justify-center text-stone-500 hover:text-stone-700 transition-colors" style="background-color: var(--bg-warm); border: 1px solid var(--line);">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="w-8 h-8 rounded-lg flex items-center justify-center text-stone-300 cursor-not-allowed" style="background-color: var(--bg-warm); border: 1px solid var(--line);">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                                                    </button>
                                                @endif

                                                {{-- Qty display --}}
                                                <span class="w-10 text-center text-sm font-bold text-stone-800">{{ $item->jumlah }}</span>

                                                {{-- Increase --}}
                                                @if ($item->jumlah < $item->menu->stok)
                                                    <form method="POST" action="{{ route('dashboard.pembeli.cart.update', $item, false) }}">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="jumlah" value="{{ $item->jumlah + 1 }}">
                                                        <button class="w-8 h-8 rounded-lg flex items-center justify-center text-white transition-colors" style="background-color: var(--brand);">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="w-8 h-8 rounded-lg flex items-center justify-center text-stone-300 cursor-not-allowed" style="background-color: var(--bg-warm); border: 1px solid var(--line);">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                                    </button>
                                                @endif
                                            </div>

                                            {{-- Remove --}}
                                            <form method="POST" action="{{ route('dashboard.pembeli.cart.remove', $item, false) }}">
                                                @csrf @method('DELETE')
                                                <button class="p-1.5 rounded-lg text-stone-400 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Subtotal (desktop) -->
                                    <div class="hidden sm:block text-right shrink-0 pl-4" style="border-left: 1px solid var(--line-light);">
                                        <p class="text-[10px] font-medium uppercase tracking-wide" style="color: var(--muted);">Subtotal</p>
                                        <p class="text-lg font-bold" style="color: var(--brand);">Rp {{ number_format((float) $item->menu->harga * $item->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <!-- Subtotal (mobile) -->
                                <div class="sm:hidden flex items-center justify-between mt-3 pt-3" style="border-top: 1px solid var(--line-light);">
                                    <p class="text-xs" style="color: var(--muted);">Subtotal</p>
                                    <p class="font-bold" style="color: var(--brand);">Rp {{ number_format((float) $item->menu->harga * $item->jumlah, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- RIGHT: Payment Card (sticky) -->
                    <div class="w-full lg:w-96 lg:shrink-0 lg:sticky lg:top-24">
                        <div class="panel-section space-y-5">
                            <!-- Order Summary -->
                            <div>
                                <h3 class="section-title mb-3">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    Ringkasan Pesanan
                                </h3>
                                <div class="space-y-2">
                                    @foreach ($cartItems as $item)
                                        <div class="flex items-center justify-between py-1.5 text-sm" style="border-bottom: 1px solid var(--line-light);">
                                            <div class="min-w-0 flex-1 mr-3">
                                                <p class="font-medium text-stone-800 truncate">{{ $item->menu->nama }}</p>
                                                <p class="text-xs" style="color: var(--muted);">{{ $item->jumlah }} x Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                                            </div>
                                            <p class="font-semibold shrink-0" style="color: var(--brand);">Rp {{ number_format((float) $item->menu->harga * $item->jumlah, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="flex items-center justify-between mt-3 pt-3" style="border-top: 2px solid var(--line);">
                                    <p class="font-semibold text-stone-800">Total ({{ $cartItems->sum('jumlah') }} item)</p>
                                    <p class="text-lg font-bold" style="color: var(--brand);">Rp {{ number_format($total, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Saldo Info -->
                            <div class="flex items-center justify-between py-3 px-3 rounded-lg" style="background-color: var(--bg-warm);">
                                <div>
                                    <p class="text-xs font-medium text-stone-500">Saldo Kamu</p>
                                    <p class="text-sm font-bold" style="color: {{ (float) auth()->user()->saldo >= $total ? 'var(--accent)' : 'var(--err-ink)' }};">
                                        Rp {{ number_format((float) auth()->user()->saldo, 0, ',', '.') }}
                                    </p>
                                </div>
                                @if ((float) auth()->user()->saldo < $total)
                                    <a href="{{ route('dashboard.pembeli.topup') }}" class="btn-primary text-xs !py-1.5 !px-3">Top Up</a>
                                @else
                                    <span class="badge-green">Cukup</span>
                                @endif
                            </div>

                            <!-- Checkout Form -->
                            <form method="POST" action="{{ route('dashboard.pembeli.checkout.store', [], false) }}">
                                @csrf
                                <div class="space-y-3">
                                    <h3 class="section-title">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Waktu Pengambilan
                                    </h3>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="waktu_ambil" value="istirahat_1" class="peer sr-only" checked>
                                            <div class="panel p-3 text-center peer-checked:border-[#C62828] peer-checked:ring-2 peer-checked:ring-red-50 transition-all duration-150">
                                                <svg class="w-5 h-5 mx-auto mb-1" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p class="font-semibold text-xs text-stone-800">Istirahat 1</p>
                                            </div>
                                        </label>
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="waktu_ambil" value="istirahat_2" class="peer sr-only">
                                            <div class="panel p-3 text-center peer-checked:border-[#C62828] peer-checked:ring-2 peer-checked:ring-red-50 transition-all duration-150">
                                                <svg class="w-5 h-5 mx-auto mb-1" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <p class="font-semibold text-xs text-stone-800">Istirahat 2</p>
                                            </div>
                                        </label>
                                    </div>

                                    <button class="btn-primary w-full text-sm !py-2.5" {{ (float) auth()->user()->saldo < $total ? 'disabled' : '' }}>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Bayar &mdash; Rp {{ number_format($total, 0, ',', '.') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            @else
                <div class="panel-section">
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <p>Keranjang belanja kosong.</p>
                        <a href="{{ route('dashboard.pembeli') }}" class="btn-secondary btn-sm mt-3 inline-flex text-xs">
                            Lihat Menu &rarr;
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
