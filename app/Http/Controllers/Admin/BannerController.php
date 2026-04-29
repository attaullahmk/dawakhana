<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $locale = request('locale', 'all');
        $query = Banner::orderBy('sort_order');
        if ($locale !== 'all') {
            $query->where('locale', $locale);
        }
        $banners = $query->get();
        return view('admin.banners.index', compact('banners', 'locale'));
    }

    public function create()
    {
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.banners.form', compact('locales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'locale' => 'required|in:en,ur',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.banners.form', compact('banner', 'locales'));
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'locale' => 'required|in:en,ur',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image && Storage::disk('public')->exists(str_replace('storage/', '', $banner->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $banner->image));
            }

            $path = $request->file('image')->store('banners', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        if ($banner->image && Storage::disk('public')->exists(str_replace('storage/', '', $banner->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $banner->image));
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }
}
