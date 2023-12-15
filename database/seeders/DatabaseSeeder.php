<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DivisionSeeder::class,
            DistrictSeeder::class,
            UserSeeder::class,
            DefaultSettingTableSeeder::class,
            MailSettingTableSeeder::class,
            PaymentSettingSeeder::class,
            SocialLoginSettingSeeder::class,
            SeoSettingSeeder::class,
            SmsSettingSeeder::class,
        ]);
    }
}
