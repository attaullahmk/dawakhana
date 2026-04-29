<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pages in English and Urdu (up to 5 pages per locale)
        $pages_en = [
            ['slug' => 'shipping-policy', 'system_key' => 'shipping', 'title' => 'Shipping Policy', 'content' => '<h2>Fast & Reliable Shipping</h2><p>We ensure safe delivery across Pakistan.</p>'],
            ['slug' => 'returns-exchanges', 'system_key' => 'returns', 'title' => 'Returns & Exchanges', 'content' => '<h2>Hassle-Free Returns</h2><p>Return items within 30 days where applicable.</p>'],
            ['slug' => 'faq', 'system_key' => 'faq', 'title' => 'Frequently Asked Questions', 'content' => '<h2>How can we help?</h2><p>Common questions answered for buyers.</p>'],
            ['slug' => 'terms-of-service', 'system_key' => 'terms', 'title' => 'Terms of Service', 'content' => '<h2>Terms & Conditions</h2><p>Use of site constitutes acceptance of terms.</p>'],
        ];

        $pages_ur = [
            ['slug' => 'shipping-policy-ur', 'system_key' => 'shipping', 'title' => 'شپنگ پالیسی', 'content' => '<h2>تیز اور قابل اعتماد شپنگ</h2><p>ہم پاکستان میں محفوظ ترسیل کو یقینی بناتے ہیں۔</p>'],
            ['slug' => 'returns-exchanges-ur', 'system_key' => 'returns', 'title' => 'واپسی اور تبادلے', 'content' => '<h2>آسان واپسی</h2><p>آئٹمز 30 دن کے اندر واپس کی جا سکتی ہیں۔</p>'],
            ['slug' => 'faq-ur', 'system_key' => 'faq', 'title' => 'اکثر پوچھے گئے سوالات', 'content' => '<h2>ہم کیسے مدد کر سکتے ہیں؟</h2><p>عام سوالات کے جوابات دستیاب ہیں۔</p>'],
            ['slug' => 'terms-of-service-ur', 'system_key' => 'terms', 'title' => 'استعمال کی شرائط', 'content' => '<h2>شرائط و ضوابط</h2><p>سائٹ کے استعمال کا مطلب شرائط کی قبولیت ہے۔</p>'],
        ];

        foreach ($pages_en as $page) {
            \App\Models\Page::updateOrCreate(['slug' => $page['slug'], 'locale' => 'en'], array_merge($page, ['locale' => 'en']));
        }
        foreach ($pages_ur as $page) {
            \App\Models\Page::updateOrCreate(['slug' => $page['slug'], 'locale' => 'ur'], array_merge($page, ['locale' => 'ur']));
        }
    }
}
