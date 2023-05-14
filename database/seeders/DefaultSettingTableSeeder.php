<?php

namespace Database\Seeders;

use App\Models\Default_setting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Default_setting::create([
            'app_name' => 'Laravel',
            'app_url' => 'http://127.0.0.1:8000',
            'time_zone' => 'UTC',
            'created_by' => 1,
        ]);
    }
}
