<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()
            ->select(['id', 'name', 'email', 'role', 'saldo', 'created_at'])
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,penjual,pembeli'],
        ]);

        $user->update([
            'role' => $validated['role'],
        ]);

        return response()->json([
            'message' => 'Role user berhasil diperbarui.',
            'user' => $user->only(['id', 'name', 'email', 'role']),
        ]);
    }
}
