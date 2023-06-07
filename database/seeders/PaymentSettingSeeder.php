<?php

namespace Database\Seeders;

use App\Models\Payment_setting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment_setting::create([
            'store_id' => 'store_id',
            'store_password' => 'store_password',
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
