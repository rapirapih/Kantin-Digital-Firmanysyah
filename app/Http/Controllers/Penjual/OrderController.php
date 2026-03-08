<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function queue(Request $request): JsonResponse
    {
        $penjualId = $request->user()->id;

        $validated = $request->validate([
            'waktu_ambil' => ['required', 'in:istirahat_1,istirahat_2'],
            'tanggal' => ['nullable', 'date'],
        ]);

        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        $orders = Order::query()
            ->with(['user:id,name', 'menu:id,nama,harga'])
            ->whereHas('menu', fn ($query) => $query->where('penjual_id', $penjualId))
            ->whereDate('created_at', $tanggal)
            ->where('waktu_ambil', $validated['waktu_ambil'])
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'tanggal' => $tanggal,
            'waktu_ambil' => $validated['waktu_ambil'],
            'total_antrean' => $orders->count(),
            'data' => $orders,
        ]);
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        if ($order->menu?->penjual_id !== $request->user()->id) {
            abort(403, 'Akses ditolak untuk pesanan ini.');
        }

        $validated = $request->validate([
            'status_pesanan' => ['required', 'in:diproses,selesai,dibatalkan'],
        ]);

        $order->update([
            'status_pesanan' => $validated['status_pesanan'],
        ]);

        return response()->json([
            'message' => 'Status pesanan berhasil diperbarui.',
            'order' => $order->fresh(['user:id,name', 'menu:id,nama']),
        ]);
    }
}
