<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $locale = request('locale', 'all');
        $query = BlogPost::with(['category', 'author'])->latest();
        if ($locale !== 'all') {
            $query->where('locale', $locale);
        }
        $posts = $query->get();
        return view('admin.blog.index', compact('posts', 'locale'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.blog.create', compact('categories', 'locales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'locale' => 'required|in:en,ur',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'is_published' => 'required|in:0,1',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $slug = Str::slug($request->title);
        // Ensure unique slug
        $originalSlug = $slug;
        $count = 1;
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $data = [
            'locale' => $request->locale,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'is_published' => $request->is_published,
            'published_at' => $request->is_published ? now() : null,
            'views' => 0,
        ];

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = 'storage/' . $path;
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully!');
    }

    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::all();
        $locales = ['en' => 'English', 'ur' => 'Urdu (اردو)'];
        return view('admin.blog.edit', compact('post', 'categories', 'locales'));
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'locale' => 'required|in:en,ur',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'category_id' => 'nullable|exists:blog_categories,id',
            'is_published' => 'required|in:0,1',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (BlogPost::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $data = [
            'locale' => $request->locale,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'is_published' => $request->is_published,
        ];

        // Set published_at when first published
        if ($request->is_published && !$post->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        if ($request->hasFile('featured_image')) {
            // Delete old image if it's a local file
            if ($post->featured_image && str_starts_with($post->featured_image, 'storage/')) {
                $oldPath = str_replace('storage/', '', $post->featured_image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('featured_image')->store('blogs', 'public');
            $data['featured_image'] = 'storage/' . $path;
        }

        $post->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // Delete featured image if it's a local file
        if ($post->featured_image && str_starts_with($post->featured_image, 'storage/')) {
            $oldPath = str_replace('storage/', '', $post->featured_image);
            Storage::disk('public')->delete($oldPath);
        }

        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully!');
    }
}
