<x-app-layout>
    <div class="py-8">
        <div class="content-wrap space-y-6">
            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Top Up Saldo</h1>
                    <p class="section-subtitle">Isi saldo kamu untuk melakukan pre-order makanan</p>
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
                <div class="relative z-10">
                    <p class="text-sm font-medium text-[#FFD600]">Saldo Kamu Saat Ini</p>
                    <p class="text-2xl sm:text-4xl font-bold mt-1 whitespace-nowrap">Rp {{ number_format((float) auth()->user()->saldo, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <!-- Top Up Form -->
                <div class="lg:col-span-2 panel-section">
                    <h3 class="section-title mb-4">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                        Isi Saldo
                    </h3>
                    <form method="POST" action="{{ route('dashboard.pembeli.topup.store') }}" class="space-y-4" enctype="multipart/form-data" x-data="{ metode: '{{ old('metode', 'tunai') }}' }">
                        @csrf
                        <div>
                            <label class="field-label">Jumlah Top Up (Rp)</label>
                            <input name="jumlah" type="number" min="1000" max="1000000" step="1000" placeholder="Contoh: 50000" class="field" required value="{{ old('jumlah') }}">
                            <p class="text-xs mt-1" style="color: var(--muted);">Min. Rp 1.000 &mdash; Maks. Rp 1.000.000</p>
                        </div>
                        <div>
                            <label class="field-label">Metode Pembayaran</label>
                            <select name="metode" class="field" required x-model="metode">
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                            <p class="text-xs mt-1" style="color: var(--muted);" x-show="metode === 'tunai'">Kamu akan mendapat kode transaksi untuk ditukarkan di kasir.</p>
                            <p class="text-xs mt-1" style="color: var(--muted);" x-show="metode === 'transfer'">Upload bukti transfer untuk verifikasi admin.</p>
                        </div>
                        <div x-show="metode === 'transfer'" x-transition>
                            <label class="field-label">Bukti Transfer</label>
                            <input name="bukti_transfer" type="file" accept="image/*" class="field">
                        </div>
                        <div>
                            <label class="field-label">Catatan <span class="text-xs font-normal" style="color: var(--muted);">(opsional)</span></label>
                            <input name="catatan" type="text" class="field" placeholder="Catatan tambahan..." value="{{ old('catatan') }}">
                        </div>

                        <!-- Quick Amount Buttons -->
                        <div>
                            <label class="field-label">Nominal Cepat</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                @foreach ([5000, 10000, 20000, 50000, 75000, 100000] as $nominal)
                                    <button type="button"
                                        onclick="document.querySelector('input[name=jumlah]').value = {{ $nominal }}"
                                        class="btn-secondary text-xs !px-2 !py-2">
                                        Rp {{ number_format($nominal, 0, ',', '.') }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <button class="btn-primary w-full">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/></svg>
                            Top Up Sekarang
                        </button>
                    </form>
                </div>

                <!-- Top Up History -->
                <div class="lg:col-span-3 panel-section overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="section-title">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Riwayat Top Up
                        </h3>
                        <span class="badge-gray text-xs">{{ $topups->total() }} transaksi</span>
                    </div>

                    {{-- Desktop Table --}}
                    <div class="hidden sm:block overflow-x-auto -mx-4 sm:-mx-5 lg:-mx-6">
                        <table class="table-clean min-w-full">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Metode</th>
                                    <th>Kode / Bukti</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topups as $topup)
                                    @php
                                        $statusBadge = $topup->status === 'berhasil' ? 'badge-green' : 'badge-yellow';
                                    @endphp
                                    <tr>
                                        <td class="text-xs" style="color: var(--muted);">{{ $topup->created_at->format('d M Y, H:i') }}</td>
                                        <td class="font-semibold" style="color: var(--accent);">+ Rp {{ number_format($topup->jumlah, 0, ',', '.') }}</td>
                                        <td><span class="badge badge-gray">{{ ucfirst($topup->metode) }}</span></td>
                                        <td>
                                            @if ($topup->kode_transaksi)
                                                <span class="font-mono text-xs font-bold px-2 py-1 rounded" style="background-color: var(--brand-soft); color: var(--brand);">{{ $topup->kode_transaksi }}</span>
                                            @elseif ($topup->bukti_transfer)
                                                <a href="{{ asset('storage/' . $topup->bukti_transfer) }}" target="_blank" class="text-xs font-medium underline" style="color: var(--brand);">Lihat Bukti</a>
                                            @else
                                                <span style="color: var(--muted);">-</span>
                                            @endif
                                        </td>
                                        <td><span class="badge {{ $statusBadge }}">{{ ucfirst($topup->status) }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                                <p>Belum ada riwayat top up.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile Card List --}}
                    <div class="sm:hidden space-y-3">
                        @forelse ($topups as $topup)
                            @php
                                $statusBadge = $topup->status === 'berhasil' ? 'badge-green' : 'badge-yellow';
                            @endphp
                            <div class="rounded-xl p-4" style="background-color: var(--bg-warm); border: 1px solid var(--line-light);">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div>
                                        <p class="font-semibold" style="color: var(--accent);">+ Rp {{ number_format($topup->jumlah, 0, ',', '.') }}</p>
                                        <p class="text-xs" style="color: var(--muted);">{{ $topup->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <span class="badge {{ $statusBadge }} shrink-0">{{ ucfirst($topup->status) }}</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="badge badge-gray text-[10px]">{{ ucfirst($topup->metode) }}</span>
                                    @if ($topup->kode_transaksi)
                                        <span class="font-mono text-xs font-bold px-2 py-0.5 rounded" style="background-color: var(--brand-soft); color: var(--brand);">{{ $topup->kode_transaksi }}</span>
                                    @elseif ($topup->bukti_transfer)
                                        <a href="{{ asset('storage/' . $topup->bukti_transfer) }}" target="_blank" class="text-xs font-medium underline" style="color: var(--brand);">Lihat Bukti</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z"/></svg>
                                <p>Belum ada riwayat top up.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($topups->hasPages())
                        <div class="mt-4 px-1">
                            {{ $topups->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
