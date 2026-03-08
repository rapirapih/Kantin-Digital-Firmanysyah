<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Keranjang Belanja</h1>
                    <p class="section-subtitle">Review pesanan sebelum checkout</p>
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
                @php
                    $grandTotal = $cartItems->sum(fn ($item) => (float) $item->menu->harga * $item->jumlah);
                @endphp

                <!-- Cart Items -->
                <div class="space-y-3">
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
                                <div class="flex items-center gap-3">
                                    <form method="POST" action="{{ route('dashboard.pembeli.cart.update', $item) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label class="text-xs font-medium sr-only">Jumlah</label>
                                        <input name="jumlah" type="number" min="1" value="{{ $item->jumlah }}" class="field !w-20 text-center !py-1.5 text-sm">
                                        <button class="btn-secondary btn-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Update
                                        </button>
                                    </form>

                                    <form method="POST" action="{{ route('dashboard.pembeli.cart.remove', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger btn-sm">
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

                <!-- Total & Checkout -->
                <div class="panel-section">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-sm" style="color: var(--muted);">Total ({{ $cartItems->sum('jumlah') }} item)</p>
                            <p class="text-2xl font-bold" style="color: var(--brand);">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                        </div>
                        <a href="{{ route('dashboard.pembeli.checkout') }}" class="btn-primary text-base !px-8 !py-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            Checkout
                        </a>
                    </div>
                </div>
            @else
                <div class="panel-section">
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <p>Keranjang belanja kosong.</p>
                        <a href="{{ route('dashboard.pembeli') }}" class="btn-primary mt-4 inline-flex">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Lihat Menu
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
