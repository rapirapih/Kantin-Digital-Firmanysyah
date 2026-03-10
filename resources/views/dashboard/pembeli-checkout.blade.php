<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-6 max-w-3xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Checkout</h1>
                    <p class="section-subtitle">Konfirmasi pesanan kamu</p>
                </div>
                <a href="{{ route('dashboard.pembeli.cart') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Keranjang
                </a>
            </div>

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
                <!-- Order Summary -->
                <div class="panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Ringkasan Pesanan
                    </h3>

                    <div class="space-y-3">
                        @foreach ($cartItems as $item)
                            <div class="flex items-center justify-between py-2" style="border-bottom: 1px solid var(--line-light);">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background-color: var(--brand-soft);">
                                        <svg class="w-4 h-4" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-stone-800">{{ $item->menu->nama }}</p>
                                        <p class="text-xs" style="color: var(--muted);">{{ $item->jumlah }} x Rp {{ number_format($item->menu->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="font-semibold" style="color: var(--brand);">Rp {{ number_format((float) $item->menu->harga * $item->jumlah, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between mt-4 pt-4" style="border-top: 2px solid var(--line);">
                        <p class="font-semibold text-stone-800">Total Pembayaran</p>
                        <p class="text-xl font-bold" style="color: var(--brand);">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Saldo Info -->
                <div class="panel-section flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-stone-800">Saldo Kamu</p>
                        <p class="text-lg font-bold" style="color: {{ (float) auth()->user()->saldo >= $total ? 'var(--accent)' : 'var(--err-ink)' }};">
                            Rp {{ number_format((float) auth()->user()->saldo, 0, ',', '.') }}
                        </p>
                    </div>
                    @if ((float) auth()->user()->saldo < $total)
                        <div class="text-right">
                            <p class="text-xs text-red-600 font-medium mb-1">Saldo tidak cukup</p>
                            <a href="{{ route('dashboard.pembeli.topup') }}" class="btn-primary text-xs !py-1.5 !px-3">Top Up Sekarang</a>
                        </div>
                    @else
                        <span class="badge-green">Saldo cukup</span>
                    @endif
                </div>

                <!-- Checkout Form -->
                <form method="POST" action="{{ route('dashboard.pembeli.checkout.store', [], false) }}">
                    @csrf
                    <div class="panel-section space-y-4">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Waktu Pengambilan
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="waktu_ambil" value="istirahat_1" class="peer sr-only" checked>
                                <div class="panel p-4 text-center peer-checked:border-red-500 peer-checked:ring-2 peer-checked:ring-red-100 transition-all duration-150">
                                    <svg class="w-6 h-6 mx-auto mb-1" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="font-semibold text-sm text-stone-800">Istirahat 1</p>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="waktu_ambil" value="istirahat_2" class="peer sr-only">
                                <div class="panel p-4 text-center peer-checked:border-red-500 peer-checked:ring-2 peer-checked:ring-red-100 transition-all duration-150">
                                    <svg class="w-6 h-6 mx-auto mb-1" style="color: var(--brand);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="font-semibold text-sm text-stone-800">Istirahat 2</p>
                                </div>
                            </label>
                        </div>

                        <button class="btn-primary w-full text-base !py-3 mt-2" {{ (float) auth()->user()->saldo < $total ? 'disabled' : '' }}>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Konfirmasi Pesanan &mdash; Rp {{ number_format($total, 0, ',', '.') }}
                        </button>
                    </div>
                </form>
            @else
                <div class="panel-section">
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        <p>Keranjang kosong. Tambahkan menu terlebih dahulu.</p>
                        <a href="{{ route('dashboard.pembeli') }}" class="btn-primary mt-4 inline-flex">Lihat Menu</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
