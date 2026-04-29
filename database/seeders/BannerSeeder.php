<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'locale' => 'en',
                'title' => 'Your Trusted Health Partner',
                'subtitle' => 'Discover high-quality herbal medicines and daily health supplements.',
                'button_text' => 'Shop Medicines',
                'button_link' => '/shop',
                'image' => 'https://picsum.photos/seed/medbanner1/1920/800',
                'sort_order' => 1
            ],
            [
                'locale' => 'en',
                'title' => 'Natural Healing Solutions',
                'subtitle' => 'Pure and organic herbal blends for your well-being.',
                'button_text' => 'Explore Herbal',
                'button_link' => '/shop?category=herbal-medicine',
                'image' => 'https://picsum.photos/seed/medbanner2/1920/800',
                'sort_order' => 2
            ],
            [
                'locale' => 'ur',
                'title' => 'آپ کا قابل اعتماد صحت کا ساتھی',
                'subtitle' => 'اعلیٰ معیار کی ہربل ادویات اور روزانہ صحت کے سپلیمنٹس دریافت کریں۔',
                'button_text' => 'ادویات خریدیں',
                'button_link' => '/shop',
                'image' => 'https://picsum.photos/seed/medbanner3/1920/800',
                'sort_order' => 3
            ],
            [
                'locale' => 'ur',
                'title' => 'قدرتی شفا بخش حل',
                'subtitle' => 'آپ کی تندرستی کے لیے خالص اور نامیاتی ہربل مرکبات۔',
                'button_text' => 'ہربل دریافت کریں',
                'button_link' => '/shop?category=herbal-medicine',
                'image' => 'https://picsum.photos/seed/medbanner4/1920/800',
                'sort_order' => 4
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
