<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            ['id' => '1', 'name' => 'Chattagram'],
            ['id' => '2', 'name' => 'Rajshahi'],
            ['id' => '3', 'name' => 'Khulna'],
            ['id' => '4', 'name' => 'Barisal'],
            ['id' => '5', 'name' => 'Sylhet'],
            ['id' => '6', 'name' => 'Dhaka'],
            ['id' => '7', 'name' => 'Rangpur'],
            ['id' => '8', 'name' => 'Mymensingh'],
        ];

        DB::table('divisions')->insert($divisions);

    }
}
