<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'first_name' => 'admin',
            'last_name' => 'up',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'address' => 'phnom penh',
            'phone_number' => '+855882051005'
        ]);
    }
}
