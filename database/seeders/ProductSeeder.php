<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        
        $medicines = [
            'en' => [
                'Herbal Tea Blend', 'Cough Relief Syrup', 'Vitamin C Tablets', 'Organic Honey', 
                'Aloe Vera Gel', 'Pain Relieving Balm', 'Omega-3 Capsules', 'Antiseptic Liquid',
                'Digestive Enzyme', 'Sleep Aid Capsules'
            ],
            'ur' => [
                'ہربل چائے کا مرکب', 'کھانسی کا شربت', 'وٹامن سی گولیاں', 'خالص شہد',
                'ایلو ویرا جیل', 'درد کش بام', 'اومیگا 3 کیپسول', 'اینٹی سیپٹک مائع',
                'ہاضمے کے انزائم', 'نیند کے لیے کیپسول'
            ]
        ];

        foreach (['en', 'ur'] as $locale) {
            $categories = \App\Models\Category::where('locale', $locale)->get();
            
            foreach ($medicines[$locale] as $index => $name) {
                // Assign to a category cyclically
                $cat = $categories[$index % $categories->count()];
                
                $price = $faker->randomFloat(2, 5, 100);
                $hasSale = $faker->boolean(30);
                $salePrice = $hasSale ? round($price * 0.85, 2) : null;

                $product = Product::create([
                    'locale' => $locale,
                    'category_id' => $cat->id,
                    'name' => $name,
                    'slug' => Str::slug($name) . '-' . Str::random(4),
                    'description' => ($locale === 'en') 
                        ? 'This ' . $name . ' is formulated with high-quality ingredients to support your health.' 
                        : 'یہ ' . $name . ' آپ کی صحت کی بہتری کے لیے بہترین اجزاء سے تیار کیا گیا ہے۔',
                    'short_description' => ($locale === 'en') 
                        ? 'Premium quality ' . $name . ' for daily health support.' 
                        : 'روزانہ صحت کی بہتری کے لیے بہترین ' . $name . '۔',
                    'price' => $price,
                    'sale_price' => $salePrice,
                    'stock_quantity' => $faker->numberBetween(10, 100),
                    'sku' => 'DWK-' . strtoupper(Str::random(6)),
                    'main_image' => 'https://picsum.photos/seed/' . Str::slug($name) . '/600/400',
                    'is_featured' => $faker->boolean(20),
                    'is_active' => true,
                ]);

                // Add up to 2 additional images
                for ($j = 1; $j <= 2; $j++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'https://picsum.photos/seed/' . Str::slug($name) . '-' . $j . '/600/400',
                        'sort_order' => $j
                    ]);
                }
            }
        }
    }
}
