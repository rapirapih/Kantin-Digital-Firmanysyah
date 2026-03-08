<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Riwayat Pesanan</h1>
                    <p class="section-subtitle">Semua pesanan yang pernah kamu buat</p>
                </div>
                <a href="{{ route('dashboard.pembeli') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>

            @if (session('status'))
                <div class="status-banner">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Orders Table -->
            <div class="panel-section overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="section-title">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Daftar Pesanan
                    </h3>
                    <span class="badge-gray text-xs">{{ $myOrders->total() }} pesanan</span>
                </div>

                <div class="overflow-x-auto -mx-5 sm:-mx-6">
                    <table class="table-clean min-w-full">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Menu</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Waktu Ambil</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($myOrders as $order)
                                @php
                                    $statusBadge = match($order->status_pesanan) {
                                        'menunggu' => 'badge-yellow',
                                        'diproses' => 'badge-blue',
                                        'selesai' => 'badge-green',
                                        'dibatalkan' => 'badge-red',
                                        default => 'badge-gray',
                                    };
                                    $waktuLabel = match($order->waktu_ambil) {
                                        'istirahat_1' => 'Istirahat 1',
                                        'istirahat_2' => 'Istirahat 2',
                                        default => $order->waktu_ambil,
                                    };
                                @endphp
                                <tr>
                                    <td class="text-xs" style="color: var(--muted);">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="font-medium text-stone-800">{{ $order->menu->nama }}</td>
                                    <td>{{ $order->jumlah }}</td>
                                    <td class="font-semibold" style="color: var(--brand);">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td><span class="badge badge-gray">{{ $waktuLabel }}</span></td>
                                    <td><span class="badge {{ $statusBadge }}">{{ $order->status_pesanan }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                            <p>Belum ada pesanan. Pesan makanan favoritmu!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($myOrders->hasPages())
                    <div class="mt-4 px-1">
                        {{ $myOrders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
