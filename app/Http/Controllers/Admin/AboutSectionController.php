<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AboutSectionController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->get('locale', 'en');
        $about = AboutSection::where('locale', $locale)->first();

        // Standard categories for stats if not exists
        if (!$about) {
            $defaultStats = [
                ['number' => '15+', 'label' => 'Years Experience', 'desc' => 'Mastering the art of luxury furniture since our founding.'],
                ['number' => '50k', 'label' => 'Happy Homes', 'desc' => 'Delivering elevated comfort and joy to homes worldwide.'],
                ['number' => '120', 'label' => 'Design Awards', 'desc' => 'Recognized globally for outstanding luxury aesthetics.']
            ];
            
            $about = new AboutSection();
            $about->locale = $locale;
            $about->stats = $defaultStats;
        }

        return view('admin.about-section.index', compact('about', 'locale'));
    }

    public function update(Request $request)
    {
        $locale = $request->input('locale', 'en');
        $about = AboutSection::firstOrCreate(['locale' => $locale]);

        $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'vision_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'founder_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only([
            'hero_title', 'hero_subtitle', 
            'vision_title', 'vision_heading', 'vision_description_1', 'vision_description_2',
            'founder_name', 'founder_title'
        ]);

        // Handle Image Uploads
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $this->uploadImage($request->file('hero_image'), 'hero');
        }
        if ($request->hasFile('vision_image')) {
            $data['vision_image'] = $this->uploadImage($request->file('vision_image'), 'vision');
        }
        if ($request->hasFile('founder_image')) {
            $data['founder_image'] = $this->uploadImage($request->file('founder_image'), 'founder');
        }

        // Handle Stats
        $stats = [];
        if ($request->has('stats_numbers')) {
            foreach ($request->stats_numbers as $index => $number) {
                $stats[] = [
                    'number' => $number,
                    'label' => $request->stats_labels[$index] ?? '',
                    'desc' => $request->stats_descs[$index] ?? ''
                ];
            }
        }
        $data['stats'] = $stats;

        $about->update($data);

        return redirect()->back()->with('success', __('About section updated successfully for ') . strtoupper($locale));
    }

    private function uploadImage($file, $prefix)
    {
        $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/about/' . $filename;
        $file->move(public_path('uploads/about'), $filename);
        return $path;
    }
}
