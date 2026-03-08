<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Kantin',
                'email' => 'admin@ecanteen.test',
                'password' => Hash::make('password123'),
                'saldo' => 0,
                'role' => 'admin',
            ],
            [
                'name' => 'Penjual Kantin',
                'email' => 'penjual@ecanteen.test',
                'password' => Hash::make('password123'),
                'saldo' => 0,
                'role' => 'penjual',
            ],
            [
                'name' => 'Siswa 1',
                'email' => 'siswa1@ecanteen.test',
                'password' => Hash::make('password123'),
                'saldo' => 75000,
                'role' => 'pembeli',
            ],
            [
                'name' => 'Guru 1',
                'email' => 'guru1@ecanteen.test',
                'password' => Hash::make('password123'),
                'saldo' => 125000,
                'role' => 'pembeli',
            ],
        ];

        foreach ($users as $payload) {
            User::query()->updateOrCreate(
                ['email' => $payload['email']],
                $payload + ['email_verified_at' => now()]
            );
        }
    }
}
