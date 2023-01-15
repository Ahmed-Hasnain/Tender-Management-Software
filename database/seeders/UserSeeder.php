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
        //creating users using seeder
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '12345678',
                'user_type' => 'admin',
                'phone' => '03225555205',
                'dob' => 'December 20, 2001',
                'about' => 'lorum ipsum',
                'status' => 'active',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => '12345678',
                'user_type' => 'manager',
                'phone' => '03225555205',
                'dob' => 'December 20, 2001',
                'about' => 'lorum ipsum',
                'status' => 'active'
            ],
            [
                'name' => 'Ahmed',
                'email' => 'ahmed@gmail.com',
                'password' => '12345678',
                'user_type' => 'manager',
                'phone' => '03225555205',
                'dob' => 'December 20, 2001',
                'about' => 'lorum ipsum',
                'status' => 'active'
            ],
            [
                'name' => 'Ali',
                'email' => 'ali@gmail.com',
                'password' => '12345678',
                'user_type' => 'manager',
                'phone' => '03225555205',
                'dob' => 'December 20, 2001',
                'about' => 'lorum ipsum',
                'status' => 'active'
            ],
            [
                'name' => 'Usman',
                'email' => 'usman@gmail.com',
                'password' => '12345678',
                'user_type' => 'manager',
                'phone' => '03225555205',
                'dob' => 'December 20, 2001',
                'about' => 'lorum ipsum',
                'status' => 'active'
            ]
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
