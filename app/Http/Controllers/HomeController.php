<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::forLocale()->where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::forLocale()->where('is_active', true)->get();
        $featuredProducts = Product::forLocale()->with('category')->where('is_active', true)->where('is_featured', true)->take(8)->get();
        $newArrivals = Product::forLocale()->with('category')->where('is_active', true)->latest()->take(6)->get();
        $posts = BlogPost::forLocale()->with('category')->where('is_published', true)->latest()->take(3)->get();
        $reviews = Review::with(['user', 'product'])->where('is_approved', true)->latest()->take(5)->get();

        return view('pages.home', compact('banners', 'categories', 'featuredProducts', 'newArrivals', 'posts', 'reviews'));
    }
}
