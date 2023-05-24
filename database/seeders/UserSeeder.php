<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            // Super Admin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Super Admin',
            ],
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Admin',
            ],
            // Warehouse
            [
                'name' => 'Warehouse',
                'email' => 'dhakawarehouse@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Warehouse',
            ],
        ]);

        DB::table('users')->insert([
            // Customer
            [
                'name' => 'Customer 1',
                'email' => 'customer1@gmail.com',
                'password' => Hash::make('12345678'),
                'last_active' => Carbon::now(),
            ]
        ]);
    }
}
