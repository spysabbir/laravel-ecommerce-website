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
                'email' => 'superadmin@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'Super Admin',
                'created_at' => Carbon::now(),
            ],
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'Admin',
                'created_at' => Carbon::now(),
            ],
            // Warehouse Manager
            [
                'name' => 'Warehouse Manager',
                'email' => 'dhakawarehouse@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'Manager',
                'created_at' => Carbon::now(),
            ],
        ]);

        DB::table('users')->insert([
            // Customer
            [
                'name' => 'Customer 1',
                'email' => 'customer1@email.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now(),
                'last_active' => Carbon::now(),
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
