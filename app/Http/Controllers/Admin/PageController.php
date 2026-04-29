<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $locale = $request->get('locale', 'en');
        $pages = Page::where('locale', $locale)->latest()->get();
        return view('admin.pages.index', compact('pages', 'locale'));
    }

    public function create(Request $request)
    {
        $locale = $request->get('locale', 'en');
        $systemKey = $request->get('system_key');
        return view('admin.pages.create', compact('locale', 'systemKey'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'content' => 'required|string',
            'locale' => 'required|string|in:en,ur',
            'system_key' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        Page::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->slug),
            'system_key' => $request->system_key,
            'content' => $request->content,
            'locale' => $request->locale,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index', ['locale' => $request->locale])
            ->with('success', 'Page created successfully.');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);
        $locale = $page->locale;

        // Find related pages if it has a system_key
        $relatedVersions = [];
        if ($page->system_key) {
            $relatedVersions = Page::where('system_key', $page->system_key)
                ->get()
                ->pluck('id', 'locale')
                ->toArray();
        }

        return view('admin.pages.edit', compact('page', 'locale', 'relatedVersions'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'system_key' => 'nullable|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->slug),
            'system_key' => $request->system_key,
            'content' => $request->content,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.pages.index', ['locale' => $page->locale])
            ->with('success', 'Page updated successfully.');
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->back()->with('success', 'Page deleted successfully.');
    }
}
