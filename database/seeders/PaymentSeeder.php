<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [];

        for($i = 1 ; $i <= 2 ; $i++)
        {
            $payments[] = [
                'user_id' => $i,
                'total' => 300000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        DB::table('payments')->insert($payments);
    }
}
