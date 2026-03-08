<?php

use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Pembeli\OrderController as PembeliOrderController;
use App\Http\Controllers\Penjual\MenuController as PenjualMenuController;
use App\Http\Controllers\Penjual\OrderController as PenjualOrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('orders/queue', [OrderManagementController::class, 'queue']);
    Route::get('reports/daily', [OrderManagementController::class, 'dailyRecap']);
    Route::get('users', [UserRoleController::class, 'index']);
    Route::patch('users/{user}/role', [UserRoleController::class, 'update']);
});

Route::prefix('penjual')->middleware(['auth', 'role:penjual'])->group(function () {
    Route::apiResource('menus', PenjualMenuController::class);
    Route::get('orders/queue', [PenjualOrderController::class, 'queue']);
    Route::patch('orders/{order}/status', [PenjualOrderController::class, 'updateStatus']);
});

Route::prefix('pembeli')->middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('menus', [PembeliOrderController::class, 'menus']);
    Route::post('orders/pre-order', [PembeliOrderController::class, 'store']);
    Route::get('orders/history', [PembeliOrderController::class, 'history']);
});
