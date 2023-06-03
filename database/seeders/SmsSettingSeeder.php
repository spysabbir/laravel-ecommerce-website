<?php

namespace Database\Seeders;

use App\Models\SmsSetting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SmsSetting::create([
            'api_key' => 'VjkIEblFGYFP7yH5NyOk',
            'sender_id' => '8809601004416',
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
