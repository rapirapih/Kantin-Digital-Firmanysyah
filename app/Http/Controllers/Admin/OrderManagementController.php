<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function queue(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'waktu_ambil' => ['required', 'in:istirahat_1,istirahat_2'],
            'tanggal' => ['nullable', 'date'],
        ]);

        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        $orders = Order::query()
            ->with(['user:id,name', 'menu:id,nama,harga'])
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

    public function dailyRecap(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
        ]);

        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        $baseQuery = Order::query()->whereDate('created_at', $tanggal);

        $statusBreakdown = (clone $baseQuery)
            ->selectRaw('status_pesanan, COUNT(*) as total')
            ->groupBy('status_pesanan')
            ->pluck('total', 'status_pesanan');

        $pickupBreakdown = (clone $baseQuery)
            ->selectRaw('waktu_ambil, COUNT(*) as total, SUM(total_harga) as omzet')
            ->groupBy('waktu_ambil')
            ->get();

        return response()->json([
            'tanggal' => $tanggal,
            'total_pesanan' => (clone $baseQuery)->count(),
            'total_omzet' => (clone $baseQuery)->sum('total_harga'),
            'berdasarkan_status' => $statusBreakdown,
            'berdasarkan_waktu_ambil' => $pickupBreakdown,
        ]);
    }
}
