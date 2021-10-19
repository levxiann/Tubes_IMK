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
                'price' => rand(10000, 20000),
                'wholesale_price' => rand(5000, 10000),
                'stock' => rand(50, 200),
                'image' => 'nophoto.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('stocks')->insert($stocks);
    }
}
