<?php

namespace Database\Seeders;

use App\Models\Seo_setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seo_setting::create([
            'title' => 'Ecommerce Website',
            'keywords' => 'Ecommerce, Market, Online Market',
            'description' => 'Ecommerce Website',
            'seo_image' => 'Seo-Image.jpg',
            'created_by' => 1,
        ]);
    }
}
