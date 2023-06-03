<?php

namespace Database\Seeders;

use App\Models\Mail_setting;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mail_setting::create([
            'mailer' => 'smtp',
            'host' => 'sandbox.smtp.mailtrap.io',
            'port' => '2525',
            'username' => '071aa50653a80d',
            'password' => '8dd8b67f9819e0',
            'encryption' => 'tls',
            'from_address' => 'info@gmail.com',
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
