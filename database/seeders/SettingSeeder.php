<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Dwakhana',
            'site_email' => 'contact@dwakhana.com',
            'site_phone' => '+92-300-1234567',
            'site_address' => 'Main Herbal Plaza, Lahore, Pakistan',
            'currency_symbol' => 'Rs.',
            'social_facebook' => 'https://facebook.com/dwakhana',
            'social_instagram' => 'https://instagram.com/dwakhana',
            'social_pinterest' => 'https://pinterest.com/dwakhana',
        ];

        foreach ($settings as $key => $value) {
            Setting::create(['key' => $key, 'value' => $value]);
        }
    }
}
