<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $locale = request('locale', 'all');
        $query = BlogCategory::withCount('posts')->latest();
        if ($locale !== 'all') {
            $query->where('locale', $locale);
        }
        $categories = $query->get();
        return view('admin.blog.categories.index', compact('categories', 'locale'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name',
            'locale' => 'required|in:en,ur',
        ]);

        BlogCategory::create([
            'locale' => $request->locale,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->back()->with('success', 'Blog category created successfully!');
    }

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.blog.categories.edit', compact('category', 'locales'));
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $id,
            'locale' => 'required|in:en,ur',
        ]);

        $category->update([
            'locale' => $request->locale,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category updated successfully!');
    }

    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        
        if ($category->posts()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with associated blog posts.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Blog category deleted successfully!');
    }
}
