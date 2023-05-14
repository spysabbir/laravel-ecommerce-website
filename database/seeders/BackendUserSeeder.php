<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BackendUserSeeder extends Seeder
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
                'password' => Hash::make('123456789'),
                'role' => 'Super Admin',
            ],
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456789'),
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
    }
}
