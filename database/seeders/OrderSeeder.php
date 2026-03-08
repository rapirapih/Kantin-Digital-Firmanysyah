<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswa = User::query()->where('email', 'siswa1@ecanteen.test')->first();
        $guru = User::query()->where('email', 'guru1@ecanteen.test')->first();

        if (! $siswa || ! $guru) {
            return;
        }

        $nasiGoreng = Menu::query()->where('nama', 'Nasi Goreng')->first();
        $mieAyam = Menu::query()->where('nama', 'Mie Ayam')->first();
        $esTeh = Menu::query()->where('nama', 'Es Teh')->first();

        if (! $nasiGoreng || ! $mieAyam || ! $esTeh) {
            return;
        }

        $orders = [
            [
                'user' => $siswa,
                'menu' => $nasiGoreng,
                'jumlah' => 1,
                'waktu_ambil' => 'istirahat_1',
                'status_pesanan' => 'menunggu',
            ],
            [
                'user' => $siswa,
                'menu' => $esTeh,
                'jumlah' => 2,
                'waktu_ambil' => 'istirahat_2',
                'status_pesanan' => 'diproses',
            ],
            [
                'user' => $guru,
                'menu' => $mieAyam,
                'jumlah' => 2,
                'waktu_ambil' => 'istirahat_1',
                'status_pesanan' => 'selesai',
            ],
        ];

        DB::transaction(function () use ($orders): void {
            foreach ($orders as $row) {
                $totalHarga = (float) $row['menu']->harga * $row['jumlah'];

                $order = Order::query()->where([
                    'user_id' => $row['user']->id,
                    'menu_id' => $row['menu']->id,
                    'jumlah' => $row['jumlah'],
                    'waktu_ambil' => $row['waktu_ambil'],
                    'status_pesanan' => $row['status_pesanan'],
                ])->first();

                if (! $order) {
                    Order::query()->create([
                        'user_id' => $row['user']->id,
                        'menu_id' => $row['menu']->id,
                        'jumlah' => $row['jumlah'],
                        'waktu_ambil' => $row['waktu_ambil'],
                        'status_pesanan' => $row['status_pesanan'],
                        'total_harga' => $totalHarga,
                    ]);

                    $row['user']->decrement('saldo', $totalHarga);
                }
            }
        });
    }
}
