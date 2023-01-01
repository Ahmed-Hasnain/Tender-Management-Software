<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
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
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'user_type' => 'admin',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('12345678'),
                'user_type' => 'manager',
            ],
            [
                'name' => 'Ahmed',
                'email' => 'ahmed@gmail.com',
                'password' => Hash::make('12345678'),
                'user_type' => 'manager',
            ],
            [
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'password' => Hash::make('12345678'),
                'user_type' => 'manager',
            ],
            [
                'name' => 'Usman',
                'email' => 'usman@gmail.com',
                'password' => Hash::make('12345678'),
                'user_type' => 'manager',
            ]
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
