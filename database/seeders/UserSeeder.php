<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'levinagunawan29102002@gmail.com',
            'password' => Hash::make('vina29102002')
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'gracegunawan2007@gmail.com',
            'password' => Hash::make('gracegunawan31')
        ]);
    }
}
