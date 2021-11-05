<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            [
                'name'    => 'admin',
                'email'   => 'admin@gmail.com',
                'password'=> bcrypt('123456789')
            ],
            [
                'name'    => 'kasir',
                'email'   => 'kasir@gmail.com',
                'password'=> bcrypt('987654321')
            ],
        ]);
    }
}
