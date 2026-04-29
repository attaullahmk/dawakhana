<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::forLocale()->with(['category', 'author'])->where('is_published', true);

        // Filter by Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // Filter by Category
        if ($request->has('category') && !empty($request->category)) {
            $categorySlug = $request->category;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }
        
        $posts = $query->latest('published_at')->paginate(10)->withQueryString();
        
        $categories = BlogCategory::forLocale()->withCount(['posts' => function($q) {
            $q->where('is_published', true);
        }])->get();

        $recentPosts = BlogPost::forLocale()->where('is_published', true)->latest('published_at')->take(5)->get();

        return view('pages.blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    public function show($slug)
    {
        $post = BlogPost::with(['category', 'author'])->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $post->increment('views');

        $relatedPosts = BlogPost::forLocale()->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->take(3)
            ->get();
            
        return view('pages.blog.show', compact('post', 'relatedPosts'));
    }
}
