<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receipts')->truncate();
        $receipts = [];

        for($i = 1 ; $i <= 10 ; $i++)
        {
            $receipts[] = [
                'payment_id' => rand(1,2),
                'stock_id' => rand(1, 10),
                'quantity' => rand(10, 20),
                'price' => 100000,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('receipts')->insert($receipts);
    }
}
