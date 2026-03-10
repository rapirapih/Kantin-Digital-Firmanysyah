<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Topup;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        return redirect()->route($this->dashboardRouteName($request->user()->role));
    }

    public function adminDashboard(Request $request): View
    {
        $today = now()->toDateString();

        return view('dashboard.admin', [
            'role' => 'admin',
            'today' => $today,
            'stats' => [
                'total_users' => User::query()->count(),
                'total_penjual' => User::query()->where('role', 'penjual')->count(),
                'total_pembeli' => User::query()->where('role', 'pembeli')->count(),
                'total_pesanan_hari_ini' => Order::query()->whereDate('created_at', $today)->count(),
                'omzet_hari_ini' => Order::query()->whereDate('created_at', $today)->sum('total_harga'),
                'potongan_withdrawal_total' => Withdrawal::query()->sum('potongan'),
            ],
            'users' => User::query()->select(['id', 'name', 'email', 'role', 'saldo'])->orderBy('name')->get(),
            'pendingTransfers' => Topup::query()
                ->where('status', 'pending')
                ->where('metode', 'transfer')
                ->count(),
            'pendingTunaiCount' => Topup::query()
                ->where('status', 'pending')
                ->where('metode', 'tunai')
                ->count(),
            'pendingWithdrawals' => Withdrawal::query()
                ->where('status', 'pending')
                ->count(),
        ]);
    }

    public function penjualDashboard(Request $request): View
    {
        $penjualId = $request->user()->id;
        $today = now()->toDateString();
        $waktuAmbil = $request->string('waktu_ambil')->toString();
        if (! in_array($waktuAmbil, ['istirahat_1', 'istirahat_2'], true)) {
            $waktuAmbil = 'istirahat_1';
        }

        $search = $request->string('search')->toString();

        $queueQuery = Order::query()
            ->with(['user:id,name', 'menu:id,nama'])
            ->whereHas('menu', fn ($query) => $query->where('penjual_id', $penjualId))
            ->whereDate('created_at', $today)
            ->where('waktu_ambil', $waktuAmbil);

        if ($search !== '') {
            $queueQuery->whereHas('user', fn ($q) => $q->where('name', 'like', '%' . $search . '%'));
        }

        return view('dashboard.penjual', [
            'role' => 'penjual',
            'today' => $today,
            'selected_waktu_ambil' => $waktuAmbil,
            'search' => $search,
            'queue' => $queueQuery->orderBy('created_at')->get(),
            'saldo' => (float) $request->user()->saldo,
            'newOrdersCount' => Order::query()
                ->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))
                ->whereDate('created_at', $today)
                ->where('status_pesanan', 'menunggu')
                ->count(),
        ]);
    }

    public function penjualStatistik(Request $request): View
    {
        $penjualId = $request->user()->id;
        $today = now()->toDateString();

        return view('dashboard.penjual-statistik', [
            'role' => 'penjual',
            'today' => $today,
            'stats' => [
                'total_menu_saya' => Menu::query()->where('penjual_id', $penjualId)->count(),
                'menunggu' => Order::query()->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))->whereDate('created_at', $today)->where('status_pesanan', 'menunggu')->count(),
                'diproses' => Order::query()->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))->whereDate('created_at', $today)->where('status_pesanan', 'diproses')->count(),
                'siap_diambil' => Order::query()->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))->whereDate('created_at', $today)->where('status_pesanan', 'siap_diambil')->count(),
                'selesai' => Order::query()->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))->whereDate('created_at', $today)->where('status_pesanan', 'selesai')->count(),
                'omzet_hari_ini' => Order::query()->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))->whereDate('created_at', $today)->whereNotIn('status_pesanan', ['dibatalkan'])->sum('total_harga'),
                'total_pesanan_hari_ini' => Order::query()->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjualId))->whereDate('created_at', $today)->count(),
            ],
        ]);
    }

    public function penjualMenu(Request $request): View
    {
        $penjualId = $request->user()->id;

        return view('dashboard.penjual-menu', [
            'role' => 'penjual',
            'menus' => Menu::query()
                ->where('penjual_id', $penjualId)
                ->latest()
                ->get(),
            'kategoris' => Kategori::query()->orderBy('nama')->pluck('nama'),
        ]);
    }

    public function penjualTarikTunai(Request $request): View
    {
        $penjualId = $request->user()->id;

        return view('dashboard.penjual-tarik-tunai', [
            'role' => 'penjual',
            'saldo' => (float) $request->user()->saldo,
            'withdrawals' => Withdrawal::query()
                ->where('user_id', $penjualId)
                ->latest()
                ->limit(20)
                ->get(),
        ]);
    }

    public function pembeliDashboard(Request $request): View
    {
        return view('dashboard.pembeli', [
            'role' => 'pembeli',
            'today' => now()->toDateString(),
            'menus' => Menu::query()->with('penjual:id,name')->where('status', 'aktif')->orderByRaw('stok > 0 DESC')->orderBy('nama')->get(),
            'cartCount' => Cart::query()->where('user_id', $request->user()->id)->sum('jumlah'),
            'kategoris' => Kategori::query()->orderBy('nama')->pluck('nama'),
        ]);
    }

    public function storeMenu(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'exists:kategoris,nama'],
            'harga' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $data = [
            'penjual_id' => $request->user()->id,
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'status' => 'aktif',
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        Menu::query()->create($data);

        return redirect()->route('dashboard.penjual.menu')->with('status', 'Menu berhasil ditambahkan.');
    }

    public function updateMenu(Request $request, Menu $menu): RedirectResponse
    {
        if ($menu->penjual_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'exists:kategoris,nama'],
            'harga' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $data = [
            'nama' => $validated['nama'],
            'kategori' => $validated['kategori'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
        ];

        if ($request->hasFile('foto')) {
            if ($menu->foto) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('dashboard.penjual.menu')->with('status', 'Menu berhasil diperbarui.');
    }

    public function deleteMenu(Menu $menu): RedirectResponse
    {
        if ($menu->penjual_id !== request()->user()->id) {
            abort(403);
        }

        if ($menu->foto) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()->route('dashboard.penjual.menu')->with('status', 'Menu berhasil dihapus.');
    }

    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,penjual,pembeli'],
        ]);

        $user->update(['role' => $validated['role']]);

        return redirect()->route('dashboard.admin')->with('status', 'Role user berhasil diubah.');
    }

    public function storePenjual(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'name' => $validated['name'],
            'nama_lengkap' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'penjual',
            'profile_completed' => false,
        ]);

        return redirect()->route('dashboard.admin')->with('status', 'Akun penjual berhasil dibuat.');
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        if ($order->menu?->penjual_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status_pesanan' => ['required', 'in:diproses,siap_diambil,selesai,dibatalkan'],
        ]);

        $order->update(['status_pesanan' => $validated['status_pesanan']]);

        return redirect()->route('dashboard.penjual', ['waktu_ambil' => $order->waktu_ambil])->with('status', 'Status pesanan diperbarui.');
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'exists:menus,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $menu = Menu::query()->findOrFail($validated['menu_id']);

        if ($menu->stok <= 0) {
            return redirect()->back()->withErrors(['menu_id' => 'Stok menu habis.']);
        }

        $cart = Cart::query()->where('user_id', $request->user()->id)
            ->where('menu_id', $validated['menu_id'])
            ->first();

        $currentQty = $cart ? $cart->jumlah : 0;
        $newTotal = $currentQty + (int) $validated['jumlah'];

        if ($newTotal > $menu->stok) {
            return redirect()->back()->withErrors(['menu_id' => "Jumlah melebihi stok tersedia ({$menu->stok})."]);
        }

        if ($cart) {
            $cart->increment('jumlah', (int) $validated['jumlah']);
        } else {
            Cart::query()->create([
                'user_id' => $request->user()->id,
                'menu_id' => $validated['menu_id'],
                'jumlah' => $validated['jumlah'],
            ]);
        }

        return redirect()->route('dashboard.pembeli')->with('status', 'Menu berhasil ditambahkan ke keranjang!');
    }

    public function cartPage(Request $request): View
    {
        $cartItems = Cart::query()
            ->with('menu:id,nama,harga,stok')
            ->where('user_id', $request->user()->id)
            ->get();

        $total = $cartItems->sum(fn (Cart $item) => (float) $item->menu->harga * $item->jumlah);

        return view('dashboard.pembeli-cart', [
            'role' => 'pembeli',
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    public function updateCart(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $menu = $cart->menu;

        if ((int) $validated['jumlah'] > $menu->stok) {
            return redirect()->back()->withErrors(['jumlah' => "Jumlah melebihi stok tersedia ({$menu->stok})." ]);
        }

        $cart->update(['jumlah' => $validated['jumlah']]);

        return redirect()->route('dashboard.pembeli.cart')->with('status', 'Jumlah diperbarui.');
    }

    public function removeCart(Request $request, Cart $cart): RedirectResponse
    {
        if ($cart->user_id !== $request->user()->id) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('dashboard.pembeli.cart')->with('status', 'Item dihapus dari keranjang.');
    }

    public function checkoutPage(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard.pembeli.cart');
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'waktu_ambil' => ['required', 'in:istirahat_1,istirahat_2'],
        ]);

        $authUser = $request->user();

        DB::transaction(function () use ($validated, $authUser): void {
            $user = User::query()->lockForUpdate()->findOrFail($authUser->id);

            $cartItems = Cart::query()
                ->with('menu')
                ->where('user_id', $user->id)
                ->get();

            if ($cartItems->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => ['Keranjang kosong.'],
                ]);
            }

            $totalSemua = 0;

            foreach ($cartItems as $item) {
                if ($item->menu->stok < $item->jumlah) {
                    throw ValidationException::withMessages([
                        'cart' => ["Stok menu '{$item->menu->nama}' tidak cukup (tersisa {$item->menu->stok})."],
                    ]);
                }

                $totalHarga = (float) $item->menu->harga * $item->jumlah;
                $totalSemua += $totalHarga;
            }

            if ((float) $user->saldo < $totalSemua) {
                throw ValidationException::withMessages([
                    'saldo' => ['Saldo tidak cukup. Butuh Rp ' . number_format($totalSemua, 0, ',', '.') . ', saldo kamu Rp ' . number_format((float) $user->saldo, 0, ',', '.') . '.'],
                ]);
            }

            foreach ($cartItems as $item) {
                $totalHarga = (float) $item->menu->harga * $item->jumlah;

                Order::query()->create([
                    'user_id' => $user->id,
                    'menu_id' => $item->menu_id,
                    'jumlah' => $item->jumlah,
                    'waktu_ambil' => $validated['waktu_ambil'],
                    'status_pesanan' => 'menunggu',
                    'total_harga' => $totalHarga,
                ]);

                $item->menu->decrement('stok', $item->jumlah);

                // Transfer saldo ke penjual
                $penjual = User::query()->lockForUpdate()->findOrFail($item->menu->penjual_id);
                $penjual->increment('saldo', $totalHarga);
            }

            $user->decrement('saldo', $totalSemua);

            Cart::query()->where('user_id', $user->id)->delete();
        });

        return redirect()->route('dashboard.pembeli.riwayat')->with('status', 'Pesanan berhasil dibuat!');
    }

    public function pembeliRiwayat(Request $request): View
    {
        return view('dashboard.pembeli-riwayat', [
            'role' => 'pembeli',
            'myOrders' => Order::query()
                ->with('menu:id,nama,harga')
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(15),
        ]);
    }

    public function pembeliTopup(Request $request): View
    {
        return view('dashboard.pembeli-topup', [
            'role' => 'pembeli',
            'topups' => Topup::query()
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(15),
        ]);
    }

    public function storeTopup(Request $request): RedirectResponse
    {
        $rules = [
            'jumlah' => ['required', 'numeric', 'min:1000', 'max:1000000'],
            'metode' => ['required', 'in:tunai,transfer'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ];

        if ($request->input('metode') === 'transfer') {
            $rules['bukti_transfer'] = ['required', 'image', 'max:2048'];
        }

        $validated = $request->validate($rules);

        $data = [
            'user_id' => $request->user()->id,
            'jumlah' => $validated['jumlah'],
            'metode' => $validated['metode'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
        ];

        if ($validated['metode'] === 'tunai') {
            $data['kode_transaksi'] = strtoupper(bin2hex(random_bytes(4)));
        }

        if ($request->hasFile('bukti_transfer')) {
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        Topup::query()->create($data);

        $msg = $validated['metode'] === 'tunai'
            ? 'Top up berhasil dibuat! Tunjukkan kode transaksi ke kasir untuk penukaran.'
            : 'Top up berhasil dibuat! Menunggu konfirmasi admin.';

        return redirect()->route('dashboard.pembeli.topup')->with('status', $msg);
    }

    public function lookupTopupTunai(Request $request): \Illuminate\Http\JsonResponse
    {
        $kode = strtoupper(trim($request->query('kode', '')));

        if (strlen($kode) < 4) {
            return response()->json(['found' => false]);
        }

        $topup = Topup::query()
            ->where('kode_transaksi', $kode)
            ->where('metode', 'tunai')
            ->where('status', 'pending')
            ->first();

        if (! $topup) {
            return response()->json(['found' => false]);
        }

        return response()->json([
            'found' => true,
            'jumlah' => (float) $topup->jumlah,
            'user' => $topup->user->name,
        ]);
    }

    public function confirmTopupTunai(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_transaksi' => ['required', 'string'],
            'uang_diterima' => ['required', 'numeric', 'min:0'],
        ]);

        $topup = Topup::query()
            ->where('kode_transaksi', strtoupper($validated['kode_transaksi']))
            ->where('metode', 'tunai')
            ->where('status', 'pending')
            ->first();

        if (! $topup) {
            return redirect()->route('dashboard.admin.penukaran')->withErrors(['kode_transaksi' => 'Kode transaksi tidak ditemukan atau sudah digunakan.']);
        }

        if ((float) $validated['uang_diterima'] < (float) $topup->jumlah) {
            return redirect()->route('dashboard.admin.penukaran')->withErrors(['uang_diterima' => 'Uang diterima (Rp ' . number_format((float) $validated['uang_diterima'], 0, ',', '.') . ') kurang dari jumlah top up (Rp ' . number_format((float) $topup->jumlah, 0, ',', '.') . ').']);
        }

        $kembalian = (float) $validated['uang_diterima'] - (float) $topup->jumlah;

        DB::transaction(function () use ($topup): void {
            $user = User::query()->lockForUpdate()->findOrFail($topup->user_id);
            $topup->update(['status' => 'berhasil']);
            $user->increment('saldo', (float) $topup->jumlah);
        });

        $msg = 'Top up tunai Rp ' . number_format((float) $topup->jumlah, 0, ',', '.') . ' untuk ' . $topup->user->name . ' berhasil.';
        if ($kembalian > 0) {
            $msg .= ' Kembalian: Rp ' . number_format($kembalian, 0, ',', '.') . '.';
        }

        return redirect()->route('dashboard.admin.penukaran')->with('status', $msg);
    }

    public function confirmTopupTransfer(Request $request, Topup $topup): RedirectResponse
    {
        if ($topup->status === 'berhasil') {
            return redirect()->route('dashboard.admin.penukaran')->with('status', 'Top up sudah dikonfirmasi sebelumnya.');
        }

        if ($topup->metode !== 'transfer') {
            abort(403);
        }

        DB::transaction(function () use ($topup): void {
            $user = User::query()->lockForUpdate()->findOrFail($topup->user_id);
            $topup->update(['status' => 'berhasil']);
            $user->increment('saldo', (float) $topup->jumlah);
        });

        return redirect()->route('dashboard.admin.penukaran')->with('status', 'Top up transfer berhasil dikonfirmasi. Saldo pembeli telah ditambahkan.');
    }

    public function requestWithdrawal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'jumlah' => ['required', 'numeric', 'min:1000'],
        ]);

        $authUser = $request->user();

        $withdrawal = DB::transaction(function () use ($validated, $authUser) {
            $user = User::query()->lockForUpdate()->findOrFail($authUser->id);

            if ((float) $user->saldo < (float) $validated['jumlah']) {
                throw ValidationException::withMessages([
                    'jumlah' => ['Saldo tidak cukup. Saldo kamu Rp ' . number_format((float) $user->saldo, 0, ',', '.') . '.'],
                ]);
            }

            $jumlah = (float) $validated['jumlah'];
            $potongan = round($jumlah * 0.10, 2);

            $user->decrement('saldo', $jumlah);

            return Withdrawal::query()->create([
                'user_id' => $user->id,
                'jumlah' => $jumlah,
                'potongan' => $potongan,
                'kode_penukaran' => strtoupper(bin2hex(random_bytes(4))),
                'status' => 'pending',
            ]);
        });

        return redirect()->route('dashboard.penjual.tarik-tunai')
            ->with('withdrawal_kode', $withdrawal->kode_penukaran)
            ->with('withdrawal_jumlah', (float) $withdrawal->jumlah)
            ->with('withdrawal_potongan', (float) $withdrawal->potongan)
            ->with('withdrawal_diterima', (float) $withdrawal->jumlah - (float) $withdrawal->potongan);
    }

    public function lookupWithdrawal(Request $request): \Illuminate\Http\JsonResponse
    {
        $kode = strtoupper(trim($request->query('kode', '')));

        if (strlen($kode) < 4) {
            return response()->json(['found' => false]);
        }

        $withdrawal = Withdrawal::query()
            ->where('kode_penukaran', $kode)
            ->where('status', 'pending')
            ->first();

        if (! $withdrawal) {
            return response()->json(['found' => false]);
        }

        $jumlah = (float) $withdrawal->jumlah;
        $potongan = (float) $withdrawal->potongan;

        // Recalculate potongan for old records that have 0
        if ($potongan <= 0 && $jumlah > 0) {
            $potongan = round($jumlah * 0.10, 2);
        }

        return response()->json([
            'found' => true,
            'jumlah' => $jumlah,
            'potongan' => $potongan,
            'diterima' => $jumlah - $potongan,
            'user' => $withdrawal->user->name,
        ]);
    }

    public function confirmWithdrawal(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_penukaran' => ['required', 'string'],
        ]);

        $withdrawal = Withdrawal::query()
            ->where('kode_penukaran', strtoupper($validated['kode_penukaran']))
            ->where('status', 'pending')
            ->first();

        if (! $withdrawal) {
            return redirect()->route('dashboard.admin.penukaran')->withErrors(['kode_penukaran' => 'Kode penukaran tidak ditemukan atau sudah digunakan.']);
        }

        // Recalculate potongan for old records that have 0
        $potongan = (float) $withdrawal->potongan;
        if ($potongan <= 0 && (float) $withdrawal->jumlah > 0) {
            $potongan = round((float) $withdrawal->jumlah * 0.10, 2);
            $withdrawal->update(['status' => 'berhasil', 'potongan' => $potongan]);
        } else {
            $withdrawal->update(['status' => 'berhasil']);
        }

        $diterima = (float) $withdrawal->jumlah - $potongan;

        return redirect()->route('dashboard.admin.penukaran')->with('status', 'Penukaran saldo berhasil dikonfirmasi. Serahkan uang tunai Rp ' . number_format($diterima, 0, ',', '.') . ' kepada ' . $withdrawal->user->name . ' (potongan 10%: Rp ' . number_format($potongan, 0, ',', '.') . ').');
    }

    // ── Admin: Penukaran (separate page) ──

    public function adminPenukaran(Request $request): View
    {
        return view('dashboard.admin-penukaran', [
            'role' => 'admin',
            'pendingTransfers' => Topup::query()
                ->with('user:id,name')
                ->where('status', 'pending')
                ->where('metode', 'transfer')
                ->latest()
                ->get(),
            'pendingTunaiCount' => Topup::query()
                ->where('status', 'pending')
                ->where('metode', 'tunai')
                ->count(),
            'pendingWithdrawals' => Withdrawal::query()
                ->where('status', 'pending')
                ->count(),
            'withdrawalHistory' => Withdrawal::query()
                ->with('user:id,name')
                ->latest()
                ->limit(20)
                ->get(),
        ]);
    }

    // ── Admin: Kategori CRUD ──

    public function adminKategori(): View
    {
        return view('dashboard.admin-kategori', [
            'role' => 'admin',
            'kategoris' => Kategori::query()->withCount([
                'menus',
            ])->orderBy('nama')->get(),
        ]);
    }

    public function storeKategori(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategoris,nama'],
        ]);

        Kategori::query()->create(['nama' => strtolower($validated['nama'])]);

        return redirect()->route('dashboard.admin.kategori')->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategoris,nama,' . $kategori->id],
        ]);

        $oldName = $kategori->nama;
        $newName = strtolower($validated['nama']);

        $kategori->update(['nama' => $newName]);

        // Sync menus that used the old name
        Menu::query()->where('kategori', $oldName)->update(['kategori' => $newName]);

        return redirect()->route('dashboard.admin.kategori')->with('status', 'Kategori berhasil diperbarui.');
    }

    public function deleteKategori(Kategori $kategori): RedirectResponse
    {
        $menuCount = Menu::query()->where('kategori', $kategori->nama)->count();

        if ($menuCount > 0) {
            return redirect()->route('dashboard.admin.kategori')->withErrors(['nama' => "Kategori '{$kategori->nama}' masih digunakan oleh {$menuCount} menu. Ubah kategori menu tersebut terlebih dahulu."]);
        }

        $kategori->delete();

        return redirect()->route('dashboard.admin.kategori')->with('status', 'Kategori berhasil dihapus.');
    }

    // ── Admin: Laporan ──

    public function adminLaporan(Request $request): View
    {
        $penjuals = User::query()
            ->where('role', 'penjual')
            ->withCount(['menus'])
            ->get()
            ->map(function (User $penjual) {
                $penjual->total_pesanan = Order::query()
                    ->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjual->id))
                    ->count();
                $penjual->total_omzet = (float) Order::query()
                    ->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjual->id))
                    ->sum('total_harga');
                $penjual->pesanan_hari_ini = Order::query()
                    ->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjual->id))
                    ->whereDate('created_at', now()->toDateString())
                    ->count();
                $penjual->omzet_hari_ini = (float) Order::query()
                    ->whereHas('menu', fn ($q) => $q->where('penjual_id', $penjual->id))
                    ->whereDate('created_at', now()->toDateString())
                    ->sum('total_harga');
                return $penjual;
            });

        $selectedId = $request->query('penjual_id');
        $detailPenjual = null;
        $detailOrders = collect();
        $detailMenus = collect();

        if ($selectedId) {
            $detailPenjual = User::query()->where('role', 'penjual')->findOrFail($selectedId);
            $detailOrders = Order::query()
                ->with(['user:id,name', 'menu:id,nama,harga'])
                ->whereHas('menu', fn ($q) => $q->where('penjual_id', $selectedId))
                ->latest()
                ->limit(50)
                ->get();
            $detailMenus = Menu::query()
                ->where('penjual_id', $selectedId)
                ->withCount(['orders'])
                ->withSum('orders', 'total_harga')
                ->get();
        }

        return view('dashboard.admin-laporan', [
            'role' => 'admin',
            'penjuals' => $penjuals,
            'detailPenjual' => $detailPenjual,
            'detailOrders' => $detailOrders,
            'detailMenus' => $detailMenus,
        ]);
    }

    private function dashboardRouteName(string $role): string
    {
        return match ($role) {
            'admin' => 'dashboard.admin',
            'penjual' => 'dashboard.penjual',
            default => 'dashboard.pembeli',
        };
    }
}
