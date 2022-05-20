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
       $user = [
            [
               'first_name'=>'Admin',
               'last_name'=>'Up',
               'email'=>'admin@phone.com',
                'is_admin'=>'1',
                'address' => 'Phnom Penh',
               'password'=> bcrypt('12345678'),
            ],
            [
               'first_name'=>'User',
               'last_name'=>'Normal',
               'email'=>'user@phone.com',
                'is_admin'=>'0',
                'address' => 'Prey Veng',
               'password'=> bcrypt('12345678'),
            ],
        ];
  
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
