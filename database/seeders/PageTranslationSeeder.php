<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $translations = [
            // Urdu Translations
            [
                'slug' => 'شپنگ-پالیسی',
                'system_key' => 'shipping',
                'title' => 'شپنگ پالیسی',
                'content' => '<h2>تیز اور قابل اعتماد شپنگ</h2><p>ہم آپ کے پریمیم فرنیچر کی ترسیل میں بہت احتیاط برتتے ہیں۔ ہماری ٹیم اس بات کو یقینی بناتی ہے کہ ہر ٹکڑے کو انتہائی پیشہ ورانہ معیار کے ساتھ سنبھالا جائے۔</p><h3>تخمینی ترسیل کے اوقات</h3><ul><li>مقامی ترسیل: 3-5 کاروباری دن</li><li>قومی ترسیل: 7-14 کاروباری دن</li></ul><h3>شپنگ کے نرخ</h3><p>ہم آپ کے مقام اور آپ کے آرڈر کے سائز کی بنیاد پر مسابقتی شپنگ نرخ پیش کرتے ہیں۔ 1500 ڈالر سے زائد کے آرڈرز مفت معیاری ترسیل کے اہل ہیں۔</p>',
                'locale' => 'ur',
                'is_active' => true,
            ],
            [
                'slug' => 'واپسی-اور-تبادلہ',
                'system_key' => 'returns',
                'title' => 'واپسی اور تبادلہ',
                'content' => '<h2>پریشانی سے پاک واپسی</h2><p>اگر آپ اپنی خریداری سے مکمل طور پر مطمئن نہیں ہیں، تو ہم آپ کی مدد کے لیے حاضر ہیں۔</p><h3>واپسی کی پالیسی</h3><ul><li>اشیاء کو ترسیل کے 30 دنوں کے اندر واپس کیا جانا چاہیے۔</li><li>فرنیچر اپنی اصل حالت اور پیکیجنگ میں ہونا چاہیے۔</li><li>حسب ضرورت بنائے گئے ٹکڑے عام طور پر ناقابل واپسی ہوتے ہیں سوائے اس کے کہ وہ ناقص ہوں۔</li></ul><h3>واپسی شروع کرنے کا طریقہ</h3><p>براہ کرم واپسی کا عمل شروع کرنے کے لیے رابطہ فارم یا واٹس ایپ کے ذریعے ہماری کسٹمر سروس ٹیم سے رابطہ کریں۔</p>',
                'locale' => 'ur',
                'is_active' => true,
            ],
        ];

        foreach ($translations as $trans) {
            Page::updateOrCreate(
                ['system_key' => $trans['system_key'], 'locale' => $trans['locale']],
                $trans
            );
        }
    }
}
