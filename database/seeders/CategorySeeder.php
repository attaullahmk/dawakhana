<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create medicine categories per locale (en + ur)
        $categories_en = ['Herbal Medicine', 'Daily Supplements', 'First Aid', 'Skincare', 'General Health'];
        $categories_ur = ['ہربل میڈیسن', 'روزانہ سپلیمنٹس', 'فرسٹ ایڈ', 'جلد کی دیکھ بھال', 'عام صحت'];

        $locales = ['en' => $categories_en, 'ur' => $categories_ur];

        foreach ($locales as $locale => $cats) {
            foreach ($cats as $cat) {
                Category::updateOrCreate([
                    'slug' => Str::slug($cat),
                    'locale' => $locale,
                ], [
                    'name' => $cat,
                    'slug' => Str::slug($cat),
                    'image' => 'https://picsum.photos/seed/' . Str::slug($cat) . '/600/400',
                    'description' => ($locale === 'en' ? 'Premium ' . $cat . ' products for your health and well-being.' : 'آپ کی صحت اور بہتری کے لیے بہترین ' . $cat . ' مصنوعات۔'),
                    'is_active' => true,
                ]);
            }
        }
    }
}
