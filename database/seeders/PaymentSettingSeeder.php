<?php

namespace Database\Seeders;

use App\Models\Payment_setting;
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
            'store_id' => 'spyit63536b5a2eac1',
            'store_password' => 'spyit63536b5a2eac1@ssl',
            'created_by' => 1,
        ]);
    }
}
