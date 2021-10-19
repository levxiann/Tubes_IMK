<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->truncate();
        $discounts = [];

        for($i = 1 ; $i <= 10 ; $i++)
        {
            $discounts[] = [
                'stock_id' => $i,
                'percentage' => rand(10, 30),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('discounts')->insert($discounts);
    }
}
