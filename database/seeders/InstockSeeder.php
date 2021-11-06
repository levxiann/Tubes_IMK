<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instocks = [];

        for($i = 1 ; $i <= 10 ; $i++)
        {
            $instocks[] = [
                'stock_id' => $i,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('instocks')->insert($instocks);
    }
}
