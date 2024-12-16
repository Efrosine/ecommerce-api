<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = ['pending', 'completed', 'cancelled'];

        DB::table('orders')->insert([
            [
                'user_id' => rand(1, 5), // Random ID dari 1-5
                'order_date' => now()->subDays(rand(1, 30)), // Random tanggal dalam 30 hari terakhir
                'status' => $statuses[array_rand($statuses)], // Random status
                'total_price' => rand(100000, 1000000), // Random total harga antara 100 ribu hingga 1 juta
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => rand(1, 5),
                'order_date' => now()->subDays(rand(1, 30)),
                'status' => $statuses[array_rand($statuses)],
                'total_price' => rand(100000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => rand(1, 5),
                'order_date' => now()->subDays(rand(1, 30)),
                'status' => $statuses[array_rand($statuses)],
                'total_price' => rand(100000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => rand(1, 5),
                'order_date' => now()->subDays(rand(1, 30)),
                'status' => $statuses[array_rand($statuses)],
                'total_price' => rand(100000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => rand(1, 5),
                'order_date' => now()->subDays(rand(1, 30)),
                'status' => $statuses[array_rand($statuses)],
                'total_price' => rand(100000, 1000000),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
