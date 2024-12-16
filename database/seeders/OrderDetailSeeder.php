<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('order_details')->insert([
            [
                'order_id' => rand(1, 5), // Random ID order dari 1-5
                'product_id' => rand(1, 5), // Random ID produk dari 1-5
                'quantity' => rand(1, 10), // Random jumlah antara 1-10
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 5),
                'product_id' => rand(1, 5),
                'quantity' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 5),
                'product_id' => rand(1, 5),
                'quantity' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 5),
                'product_id' => rand(1, 5),
                'quantity' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => rand(1, 5),
                'product_id' => rand(1, 5),
                'quantity' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
