<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->query('locale', 'en');
        $settings = Setting::where('locale', $locale)->get();
        return view('admin.settings.index', compact('settings', 'locale'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'promo_banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $locale = $request->input('locale', 'en');
        // Exclude all specific bulk-handling fields from the generic update loop
        $exclude = [
            '_token', '_method', 'site_logo', 'site_favicon', 
            'social_icons', 'social_urls', 
            'promo_banner_image', 
            'feature_icons', 'feature_titles', 'feature_descs', 'locale'
        ];
        
        $data = $request->except($exclude);
        
        // 1. Handle Social Links
        if ($request->has('social_icons') && $request->has('social_urls')) {
            $socialLinks = [];
            $icons = $request->social_icons;
            $urls = $request->social_urls;

            foreach ($icons as $index => $icon) {
                if (!empty($icon) && !empty($urls[$index])) {
                    $socialLinks[] = [
                        'icon' => $icon,
                        'url' => $urls[$index]
                    ];
                }
            }
            $data['site_social_links'] = json_encode($socialLinks);
        } else {
            $data['site_social_links'] = json_encode([]);
        }

        // 2. Handle Why Choose Us Features
        if ($request->has('feature_icons')) {
            $features = [];
            $fIcons = $request->feature_icons;
            $fTitles = $request->feature_titles;
            $fDescs = $request->feature_descs;

            foreach ($fIcons as $index => $icon) {
                if (!empty($icon) || !empty($fTitles[$index])) {
                    $features[] = [
                        'icon' => $icon,
                        'title' => $fTitles[$index] ?? '',
                        'desc' => $fDescs[$index] ?? ''
                    ];
                }
            }
            $data['site_why_choose_us'] = json_encode($features);
        }

        // 3. Handle Boolean Toggles (Checkboxes)
        // Checkboxes/Switches dont send anything if unchecked. We must manually set them to 0.
        $toggles = ['payment_card_enabled', 'payment_cod_enabled', 'payment_whatsapp_enabled'];
        foreach ($toggles as $toggle) {
            $data[$toggle] = $request->has($toggle) ? '1' : '0';
        }

        // Save generic and serialized data
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key, 'locale' => $locale], ['value' => $value]);
        }

        // 3. Handle File Uploads
        $fileFields = ['site_logo', 'site_favicon', 'promo_banner_image'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('settings', 'public');
                $publicPath = 'storage/' . $path;
                Setting::updateOrCreate(['key' => $field, 'locale' => $locale], ['value' => $publicPath]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
