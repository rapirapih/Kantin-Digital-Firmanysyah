<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'profile.completed'])
    ->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'profile.completed', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::patch('/users/{user}/role', [DashboardController::class, 'updateUserRole'])->name('dashboard.admin.users.role');
    Route::post('/penjual', [DashboardController::class, 'storePenjual'])->name('dashboard.admin.penjual.store');

    // Penukaran (separate page)
    Route::get('/penukaran', [DashboardController::class, 'adminPenukaran'])->name('dashboard.admin.penukaran');
    Route::post('/topups/tunai', [DashboardController::class, 'confirmTopupTunai'])->name('dashboard.admin.topups.tunai');
    Route::patch('/topups/{topup}/confirm', [DashboardController::class, 'confirmTopupTransfer'])->name('dashboard.admin.topups.confirm');
    Route::get('/topups/lookup', [DashboardController::class, 'lookupTopupTunai'])->name('dashboard.admin.topups.lookup');
    Route::get('/withdrawals/lookup', [DashboardController::class, 'lookupWithdrawal'])->name('dashboard.admin.withdrawals.lookup');
    Route::post('/withdrawals/confirm', [DashboardController::class, 'confirmWithdrawal'])->name('dashboard.admin.withdrawals.confirm');

    // Kategori CRUD
    Route::get('/kategori', [DashboardController::class, 'adminKategori'])->name('dashboard.admin.kategori');
    Route::post('/kategori', [DashboardController::class, 'storeKategori'])->name('dashboard.admin.kategori.store');
    Route::patch('/kategori/{kategori}', [DashboardController::class, 'updateKategori'])->name('dashboard.admin.kategori.update');
    Route::delete('/kategori/{kategori}', [DashboardController::class, 'deleteKategori'])->name('dashboard.admin.kategori.delete');

    // Laporan
    Route::get('/laporan', [DashboardController::class, 'adminLaporan'])->name('dashboard.admin.laporan');
});

Route::prefix('penjual')->middleware(['auth', 'profile.completed', 'role:penjual'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'penjualDashboard'])->name('dashboard.penjual');
    Route::get('/statistik', [DashboardController::class, 'penjualStatistik'])->name('dashboard.penjual.statistik');
    Route::get('/menu', [DashboardController::class, 'penjualMenu'])->name('dashboard.penjual.menu');
    Route::get('/tarik-tunai', [DashboardController::class, 'penjualTarikTunai'])->name('dashboard.penjual.tarik-tunai');
    Route::post('/menus', [DashboardController::class, 'storeMenu'])->name('dashboard.penjual.menus.store');
    Route::patch('/menus/{menu}', [DashboardController::class, 'updateMenu'])->name('dashboard.penjual.menus.update');
    Route::delete('/menus/{menu}', [DashboardController::class, 'deleteMenu'])->name('dashboard.penjual.menus.delete');
    Route::patch('/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('dashboard.penjual.orders.status');
    Route::post('/withdrawal', [DashboardController::class, 'requestWithdrawal'])->name('dashboard.penjual.withdrawal.store');
});

Route::prefix('pembeli')->middleware(['auth', 'profile.completed', 'role:pembeli'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pembeliDashboard'])->name('dashboard.pembeli');
    Route::post('/cart', [DashboardController::class, 'addToCart'])->name('dashboard.pembeli.cart.add');
    Route::get('/cart', [DashboardController::class, 'cartPage'])->name('dashboard.pembeli.cart');
    Route::patch('/cart/{cart}', [DashboardController::class, 'updateCart'])->name('dashboard.pembeli.cart.update');
    Route::delete('/cart/{cart}', [DashboardController::class, 'removeCart'])->name('dashboard.pembeli.cart.remove');
    Route::get('/checkout', [DashboardController::class, 'checkoutPage'])->name('dashboard.pembeli.checkout');
    Route::post('/checkout', [DashboardController::class, 'checkout'])->name('dashboard.pembeli.checkout.store');
    Route::get('/riwayat', [DashboardController::class, 'pembeliRiwayat'])->name('dashboard.pembeli.riwayat');
    Route::get('/topup', [DashboardController::class, 'pembeliTopup'])->name('dashboard.pembeli.topup');
    Route::post('/topup', [DashboardController::class, 'storeTopup'])->name('dashboard.pembeli.topup.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
