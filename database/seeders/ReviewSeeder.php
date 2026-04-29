<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $products = \App\Models\Product::all();
        $customers = \App\Models\User::where('role', 'customer')->get();

        if ($products->isEmpty() || $customers->isEmpty()) {
            return;
        }

        // 25 realistic reviews
        for ($i = 1; $i <= 25; $i++) {
            Review::create([
                'product_id' => $products->random()->id,
                'user_id' => $customers->random()->id,
                'rating' => $faker->numberBetween(3, 5),
                'title' => $faker->sentence(4),
                'body' => $faker->paragraph(),
                'is_approved' => true,
            ]);
        }
    }
}
