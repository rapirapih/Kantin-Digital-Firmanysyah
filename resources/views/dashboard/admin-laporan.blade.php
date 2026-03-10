<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-8">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Laporan Penjual</h1>
                    <p class="section-subtitle">Ringkasan penjualan masing-masing penjual</p>
                </div>
                <a href="{{ route('dashboard.admin') }}" class="btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>

            <!-- Penjual List -->
            <div class="panel-section overflow-hidden">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Daftar Penjual
                    </h3>
                    <span class="badge-gray text-xs">{{ $penjuals->count() }} penjual</span>
                </div>

                <div class="overflow-x-auto -mx-5 sm:-mx-6">
                    <table class="table-clean min-w-full">
                        <thead>
                            <tr>
                                <th>Penjual</th>
                                <th>Menu</th>
                                <th>Total Pesanan</th>
                                <th>Total Omzet</th>
                                <th>Pesanan Hari Ini</th>
                                <th>Omzet Hari Ini</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjuals as $penjual)
                                <tr class="{{ $detailPenjual && $detailPenjual->id === $penjual->id ? 'bg-orange-50' : '' }}">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                                                {{ strtoupper(substr($penjual->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-stone-800">{{ $penjual->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $penjual->menus_count }} menu</td>
                                    <td class="font-semibold">{{ $penjual->total_pesanan }}</td>
                                    <td class="font-semibold" style="color: var(--accent);">Rp {{ number_format($penjual->total_omzet, 0, ',', '.') }}</td>
                                    <td>{{ $penjual->pesanan_hari_ini }}</td>
                                    <td class="font-semibold" style="color: var(--brand);">Rp {{ number_format($penjual->omzet_hari_ini, 0, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.admin.laporan', ['penjual_id' => $penjual->id]) }}" class="btn-primary btn-sm">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857"/></svg>
                                            <p>Belum ada penjual terdaftar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Detail Penjual -->
            @if ($detailPenjual)
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold" style="background: linear-gradient(135deg, #C62828 0%, #8E0000 100%);">
                            {{ strtoupper(substr($detailPenjual->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-stone-800">Detail: {{ $detailPenjual->name }}</h2>
                            <p class="text-xs" style="color: var(--muted);">{{ $detailPenjual->email }}</p>
                        </div>
                    </div>

                    <!-- Menu Performance -->
                    <div class="panel-section overflow-hidden">
                        <h3 class="section-title mb-4">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Performa Menu
                        </h3>
                        <div class="overflow-x-auto -mx-5 sm:-mx-6">
                            <table class="table-clean min-w-full">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Total Pesanan</th>
                                        <th>Total Pendapatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($detailMenus as $menu)
                                        <tr>
                                            <td class="font-medium text-stone-800">{{ $menu->nama }}</td>
                                            <td><span class="badge-gray text-xs">{{ $menu->kategori }}</span></td>
                                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                            <td>{{ $menu->stok }}</td>
                                            <td class="font-semibold">{{ $menu->orders_count }}</td>
                                            <td class="font-semibold" style="color: var(--accent);">Rp {{ number_format($menu->orders_sum_total_harga ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <p>Belum ada menu.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="panel-section overflow-hidden">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="section-title">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Pesanan Terakhir
                            </h3>
                            <span class="badge-gray text-xs">{{ $detailOrders->count() }} data</span>
                        </div>
                        <div class="overflow-x-auto -mx-5 sm:-mx-6">
                            <table class="table-clean min-w-full">
                                <thead>
                                    <tr>
                                        <th>Pembeli</th>
                                        <th>Menu</th>
                                        <th>Jumlah</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($detailOrders as $order)
                                        @php
                                            $statusBadge = match($order->status_pesanan) {
                                                'menunggu' => 'badge-yellow',
                                                'diproses' => 'badge-blue',
                                                'siap_diambil' => 'badge-orange',
                                                'selesai' => 'badge-green',
                                                'dibatalkan' => 'badge-gray',
                                                default => 'badge-gray',
                                            };
                                        @endphp
                                        <tr>
                                            <td class="font-medium text-stone-700">{{ $order->user->name ?? '-' }}</td>
                                            <td>{{ $order->menu->nama ?? '-' }}</td>
                                            <td>{{ $order->jumlah }}</td>
                                            <td class="font-semibold" style="color: var(--accent);">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                            <td><span class="badge {{ $statusBadge }}">{{ str_replace('_', ' ', $order->status_pesanan) }}</span></td>
                                            <td class="text-xs" style="color: var(--muted);">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <p>Belum ada pesanan.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
