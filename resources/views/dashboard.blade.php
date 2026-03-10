<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Dashboard {{ ucfirst($role) }}
        </h2>
    </x-slot>

    <div class="py-10 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">


            @if ($role === 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-6 gap-4">
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Total User</p><p class="text-2xl font-bold">{{ $stats['total_users'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Total Penjual</p><p class="text-2xl font-bold">{{ $stats['total_penjual'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Total Pembeli</p><p class="text-2xl font-bold">{{ $stats['total_pembeli'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Total Menu</p><p class="text-2xl font-bold">{{ $stats['total_menu'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Pesanan Hari Ini</p><p class="text-2xl font-bold">{{ $stats['total_pesanan_hari_ini'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Omzet Hari Ini</p><p class="text-2xl font-bold">Rp {{ number_format($stats['omzet_hari_ini'], 0, ',', '.') }}</p></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="rounded-xl bg-white p-5 shadow border border-slate-200">
                        <h3 class="font-semibold text-slate-800 mb-3">Tambah Menu</h3>
                        <form method="POST" action="{{ route('dashboard.admin.menus.store') }}" class="space-y-3">
                            @csrf
                            <input name="nama" placeholder="Nama menu" class="w-full rounded-lg border-slate-300" required>
                            <input name="harga" type="number" min="0" placeholder="Harga" class="w-full rounded-lg border-slate-300" required>
                            <input name="foto" placeholder="Path foto (opsional)" class="w-full rounded-lg border-slate-300">
                            <select name="status" class="w-full rounded-lg border-slate-300" required>
                                <option value="aktif">aktif</option>
                                <option value="nonaktif">nonaktif</option>
                            </select>
                            <button class="px-4 py-2 rounded-lg bg-slate-900 text-white">Simpan Menu</button>
                        </form>
                    </div>

                    <div class="rounded-xl bg-white p-5 shadow border border-slate-200 overflow-auto">
                        <h3 class="font-semibold text-slate-800 mb-3">Manajemen Role User</h3>
                        <table class="w-full text-sm">
                            <thead><tr class="text-left border-b"><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $item->name }}</td>
                                        <td class="py-2">{{ $item->email }}</td>
                                        <td class="py-2">{{ $item->role }}</td>
                                        <td class="py-2">
                                            <form method="POST" action="{{ route('dashboard.admin.users.role', $item) }}" class="flex gap-2">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" class="rounded border-slate-300 text-xs">
                                                    <option value="admin" @selected($item->role === 'admin')>admin</option>
                                                    <option value="penjual" @selected($item->role === 'penjual')>penjual</option>
                                                    <option value="pembeli" @selected($item->role === 'pembeli')>pembeli</option>
                                                </select>
                                                <button class="px-2 py-1 rounded bg-slate-800 text-white text-xs">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-xl bg-white p-5 shadow border border-slate-200 overflow-auto">
                    <h3 class="font-semibold text-slate-800 mb-3">Daftar Menu</h3>
                    <table class="w-full text-sm">
                        <thead><tr class="text-left border-b"><th>Nama</th><th>Harga</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr class="border-b">
                                    <td class="py-2">{{ $menu->nama }}</td>
                                    <td class="py-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td class="py-2">{{ $menu->status }}</td>
                                    <td class="py-2">
                                        <form method="POST" action="{{ route('dashboard.admin.menus.delete', $menu) }}" x-data x-on:submit.prevent="$dispatch('confirm-action', { title: 'Hapus Menu', message: 'Yakin ingin menghapus menu ini?', type: 'danger', confirmText: 'Ya, Hapus', form: $el })">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-2 py-1 rounded bg-rose-600 text-white text-xs">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($role === 'penjual')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Menunggu</p><p class="text-2xl font-bold">{{ $stats['menunggu'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Diproses</p><p class="text-2xl font-bold">{{ $stats['diproses'] }}</p></div>
                    <div class="rounded-xl bg-white p-4 shadow border border-slate-200"><p class="text-xs text-slate-500">Selesai</p><p class="text-2xl font-bold">{{ $stats['selesai'] }}</p></div>
                </div>

                <div class="rounded-xl bg-white p-5 shadow border border-slate-200">
                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4 flex items-end gap-3">
                        <div>
                            <label class="text-sm text-slate-600">Waktu Ambil</label>
                            <select name="waktu_ambil" class="rounded-lg border-slate-300">
                                <option value="istirahat_1" @selected($selected_waktu_ambil === 'istirahat_1')>Istirahat 1</option>
                                <option value="istirahat_2" @selected($selected_waktu_ambil === 'istirahat_2')>Istirahat 2</option>
                            </select>
                        </div>
                        <button class="px-4 py-2 rounded-lg bg-slate-900 text-white">Filter</button>
                    </form>

                    <table class="w-full text-sm">
                        <thead><tr class="text-left border-b"><th>Pembeli</th><th>Menu</th><th>Jumlah</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse ($queue as $order)
                                <tr class="border-b">
                                    <td class="py-2">{{ $order->user->name }}</td>
                                    <td class="py-2">{{ $order->menu->nama }}</td>
                                    <td class="py-2">{{ $order->jumlah }}</td>
                                    <td class="py-2">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</td>
                                    <td class="py-2">
                                        <form method="POST" action="{{ route('dashboard.penjual.orders.status', $order) }}" class="flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status_pesanan" class="rounded border-slate-300 text-xs">
                                                <option value="diproses" @selected($order->status_pesanan === 'diproses')>diproses</option>
                                                <option value="selesai" @selected($order->status_pesanan === 'selesai')>selesai</option>
                                                <option value="dibatalkan" @selected($order->status_pesanan === 'dibatalkan')>dibatalkan</option>
                                            </select>
                                            <button class="px-2 py-1 rounded bg-slate-800 text-white text-xs">Simpan</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td class="py-4 text-slate-500" colspan="5">Belum ada antrean.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            @if ($role === 'pembeli')
                <div class="rounded-xl bg-white p-5 shadow border border-slate-200">
                    <p class="text-slate-600">Saldo Anda</p>
                    <p class="text-3xl font-bold text-slate-900">Rp {{ number_format((float) auth()->user()->saldo, 0, ',', '.') }}</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="rounded-xl bg-white p-5 shadow border border-slate-200">
                        <h3 class="font-semibold text-slate-800 mb-3">Buat Pre-Order</h3>
                        <form method="POST" action="{{ route('dashboard.pembeli.orders.store') }}" class="space-y-3">
                            @csrf
                            <select name="menu_id" class="w-full rounded-lg border-slate-300" required>
                                <option value="">Pilih menu aktif</option>
                                @foreach ($menus as $menu)
                                    <option value="{{ $menu->id }}">{{ $menu->nama }} - Rp {{ number_format($menu->harga, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                            <input name="jumlah" type="number" min="1" value="1" class="w-full rounded-lg border-slate-300" required>
                            <select name="waktu_ambil" class="w-full rounded-lg border-slate-300" required>
                                <option value="istirahat_1">Istirahat 1</option>
                                <option value="istirahat_2">Istirahat 2</option>
                            </select>
                            <button class="px-4 py-2 rounded-lg bg-slate-900 text-white">Pesan Sekarang</button>
                        </form>
                    </div>

                    <div class="rounded-xl bg-white p-5 shadow border border-slate-200 overflow-auto">
                        <h3 class="font-semibold text-slate-800 mb-3">Riwayat Pesanan</h3>
                        <table class="w-full text-sm">
                            <thead><tr class="text-left border-b"><th>Menu</th><th>Jumlah</th><th>Total</th><th>Status</th></tr></thead>
                            <tbody>
                                @forelse ($myOrders as $order)
                                    <tr class="border-b">
                                        <td class="py-2">{{ $order->menu->nama }}</td>
                                        <td class="py-2">{{ $order->jumlah }}</td>
                                        <td class="py-2">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td class="py-2">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</td>
                                    </tr>
                                @empty
                                    <tr><td class="py-4 text-slate-500" colspan="4">Belum ada pesanan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if (! in_array($role, ['admin', 'penjual', 'pembeli'], true))
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-amber-900">
                    Role akun Anda belum dikenali. Hubungi admin untuk penyesuaian role.
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
