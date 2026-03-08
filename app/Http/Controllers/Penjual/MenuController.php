<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $menus = Menu::query()
            ->where('penjual_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json($menus);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric', 'min:0'],
            'foto' => ['nullable', 'string', 'max:2048'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $menu = Menu::query()->create($validated + [
            'penjual_id' => $request->user()->id,
        ]);

        return response()->json($menu, 201);
    }

    public function show(Request $request, Menu $menu): JsonResponse
    {
        $this->ensureOwner($request, $menu);

        return response()->json($menu);
    }

    public function update(Request $request, Menu $menu): JsonResponse
    {
        $this->ensureOwner($request, $menu);

        $validated = $request->validate([
            'nama' => ['sometimes', 'string', 'max:255'],
            'harga' => ['sometimes', 'numeric', 'min:0'],
            'foto' => ['nullable', 'string', 'max:2048'],
            'status' => ['sometimes', 'in:aktif,nonaktif'],
        ]);

        $menu->update($validated);

        return response()->json($menu->refresh());
    }

    public function destroy(Request $request, Menu $menu): JsonResponse
    {
        $this->ensureOwner($request, $menu);

        $menu->delete();

        return response()->json([
            'message' => 'Menu berhasil dihapus.',
        ]);
    }

    private function ensureOwner(Request $request, Menu $menu): void
    {
        if ($menu->penjual_id !== $request->user()->id) {
            abort(403, 'Akses ditolak untuk menu ini.');
        }
    }
}
