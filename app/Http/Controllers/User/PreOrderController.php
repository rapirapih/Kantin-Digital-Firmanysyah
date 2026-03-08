<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PreOrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'menu_id' => ['required', 'exists:menus,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'waktu_ambil' => ['required', 'in:istirahat_1,istirahat_2'],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $user = User::query()->lockForUpdate()->findOrFail($validated['user_id']);
            $menu = Menu::query()->findOrFail($validated['menu_id']);

            if ($menu->status !== 'aktif') {
                abort(response()->json([
                    'message' => 'Menu sedang tidak aktif.',
                ], 422));
            }

            $totalHarga = (float) $menu->harga * (int) $validated['jumlah'];

            if ((float) $user->saldo < $totalHarga) {
                abort(response()->json([
                    'message' => 'Saldo tidak cukup untuk melakukan pemesanan.',
                ], 422));
            }

            $order = Order::query()->create([
                'user_id' => $user->id,
                'menu_id' => $menu->id,
                'jumlah' => $validated['jumlah'],
                'waktu_ambil' => $validated['waktu_ambil'],
                'status_pesanan' => 'menunggu',
                'total_harga' => $totalHarga,
            ]);

            $user->decrement('saldo', $totalHarga);

            return $order->load(['menu:id,nama,harga', 'user:id,name,saldo']);
        });

        return response()->json([
            'message' => 'Pre-order berhasil dibuat.',
            'order' => $order,
        ], 201);
    }

    public function history(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'status_pesanan' => ['nullable', 'in:menunggu,diproses,selesai,dibatalkan'],
            'waktu_ambil' => ['nullable', 'in:istirahat_1,istirahat_2'],
        ]);

        $orders = Order::query()
            ->with('menu:id,nama,harga,foto,status')
            ->where('user_id', $validated['user_id'])
            ->when(
                $validated['status_pesanan'] ?? null,
                fn ($query, $statusPesanan) => $query->where('status_pesanan', $statusPesanan)
            )
            ->when(
                $validated['waktu_ambil'] ?? null,
                fn ($query, $waktuAmbil) => $query->where('waktu_ambil', $waktuAmbil)
            )
            ->latest()
            ->get();

        return response()->json($orders);
    }
}
