<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create health blog categories and posts per locale
        $cats_en = ['Herbal Benefits', 'Daily Wellness', 'Medicine Safety'];
        $cats_ur = ['ہربل فوائد', 'روزانہ تندرستی', 'ادویات کی حفاظت'];

        foreach (['en' => $cats_en, 'ur' => $cats_ur] as $locale => $cats) {
            foreach ($cats as $cat) {
                $bc = BlogCategory::updateOrCreate([
                    'slug' => Str::slug($cat),
                    'locale' => $locale,
                ], [
                    'name' => $cat,
                ]);

                // Create 2 posts per category
                for ($i = 0; $i < 2; $i++) {
                    $title = ($locale === 'en') 
                        ? ucwords($faker->words(5, true)) . ' for Health' 
                        : $faker->word() . ' صحت کے لیے بہترین ہے';
                    
                    BlogPost::create([
                        'locale' => $locale,
                        'user_id' => 1,
                        'category_id' => $bc->id,
                        'title' => $title,
                        'slug' => Str::slug($title) . '-' . Str::random(4),
                        'excerpt' => ($locale === 'en') 
                            ? 'Learn more about how ' . $title . ' can improve your daily life and health.' 
                            : 'جانئے کہ ' . $title . ' آپ کی روزمرہ کی زندگی اور صحت کو کیسے بہتر بنا سکتا ہے۔',
                        'body' => $faker->paragraphs(4, true),
                        'featured_image' => 'https://picsum.photos/seed/' . Str::slug($title) . '/800/400',
                        'is_published' => true,
                        'published_at' => now()->subDays($faker->numberBetween(1, 30)),
                        'views' => $faker->numberBetween(10, 500)
                    ]);
                }
            }
        }
    }
}
