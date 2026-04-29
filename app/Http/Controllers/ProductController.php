<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Page;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with(['category', 'images', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Fetch Shipping & Returns pages for the current locale
        $shippingPage = Page::forLocale()->active()->where('system_key', 'shipping')->first();
        $returnsPage = Page::forLocale()->active()->where('system_key', 'returns')->first();

        // Fallback to English if not found
        if (!$shippingPage && app()->getLocale() !== 'en') {
            $shippingPage = Page::where('system_key', 'shipping')->where('locale', 'en')->active()->first();
        }
        if (!$returnsPage && app()->getLocale() !== 'en') {
            $returnsPage = Page::where('system_key', 'returns')->where('locale', 'en')->active()->first();
        }

        return view('pages.shop.show', compact('product', 'relatedProducts', 'shippingPage', 'returnsPage'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'body' => 'required|string'
        ]);

        $product = Product::findOrFail($id);
        
        $alreadyReviewed = Review::where('user_id', auth()->id())
                                 ->where('product_id', $product->id)
                                 ->exists();
        
        if ($alreadyReviewed) {
            return redirect()->back()->with('error', 'You have already submitted a review for this product.');
        }

        Review::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'title' => $request->title,
            'body' => $request->body,
            'is_approved' => false
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted and is pending approval.');
    }
}
