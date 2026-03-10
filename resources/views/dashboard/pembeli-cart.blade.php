<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
                    <p class="section-subtitle">Review pesanan & langsung bayar</p>
                </div>
                <a href="{{ route('dashboard.pembeli') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Lanjut Belanja
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
                    <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($cartItems->count() > 0)
                <div class="flex flex-col lg:flex-row gap-6 lg:items-start">

                    <!-- ══ LEFT: Cart Items ══ -->
                    <div class="flex-1 min-w-0 space-y-3">
                        @foreach ($cartItems as $item)
                            <div class="panel-section">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                                    <!-- Menu Info -->
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center shrink-0" style="background-color: var(--brand-soft);">
                                            <svg class="w-6 h-6" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="font-semibold text-stone-800 truncate">{{ $item->menu->nama }}</h4>
                                            <p class="text-sm" style="color: var(--brand);">Rp {{ number_format($item->menu->harga, 0, ',', '.') }} / item</p>
                                        </div>
                                    </div>

                                    <!-- Quantity Control -->
                                    <div class="flex items-center gap-2 w-full sm:w-auto">
                                        <form method="POST" action="{{ route('dashboard.pembeli.cart.update', $item) }}" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <label class="text-xs font-medium sr-only">Jumlah</label>
                                            <input name="jumlah" type="number" min="1" max="{{ $item->menu->stok }}" value="{{ $item->jumlah }}" class="field !w-20 text-center !py-2 text-sm">
                                            <button class="btn-secondary !py-2 !px-3 text-xs whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                Update
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('dashboard.pembeli.cart.remove', $item) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger !py-2 !px-3 text-xs whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="text-right sm:w-32">
                                        <p class="text-xs" style="color: var(--muted);">Subtotal</p>
                                        <p class="font-bold" style="color: var(--brand);">Rp {{ number_format((float) $item->menu->harga * $item->jumlah, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ══ RIGHT: Payment Card (sticky) ══ -->
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
                            <form method="POST" action="{{ route('dashboard.pembeli.checkout.store') }}">
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
                        <a href="{{ route('dashboard.pembeli') }}" class="btn-primary btn-sm mt-4 inline-flex">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Lihat Menu
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
