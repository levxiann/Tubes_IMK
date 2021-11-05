<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stocks = [];
        $faker = Factory::create();

        for($i = 0 ; $i < 10 ; $i++)
        {
            $stocks[] = [
                'name' => $faker->firstName(),
                'description' => $faker->text(rand(100, 200)),
                'price' => 10000,
                'wholesale_price' => 8000,
                'wholesale_quantity' => 5,
                'stock' => rand(50, 200),
                'image' => 'nophoto.png',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('stocks')->insert($stocks);
    }
}
