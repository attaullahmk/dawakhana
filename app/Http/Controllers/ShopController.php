<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::forLocale()->with('category')->where('is_active', true);

        // Search filtering
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Category filtering (handles both single slug and array of slugs)
        if ($request->filled('category')) {
            $catInput = $request->category;
            if (is_array($catInput)) {
                $query->whereHas('category', function($q) use ($catInput) {
                    $q->whereIn('slug', $catInput);
                });
            } else {
                $query->whereHas('category', function($q) use ($catInput) {
                    $q->where('slug', $catInput);
                });
            }
        }

        // Price Range filtering
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock status filtering
        if ($request->filled('stock')) {
            if ($request->stock === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        // Sale filter
        if ($request->filled('sale') && $request->sale == 'true') {
            $query->whereNotNull('sale_price')->where('sale_price', '>', 0);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::forLocale()->where('is_active', true)->withCount(['products' => function($q) {
            $q->where('is_active', true);
        }])->get();
        
        if ($request->ajax()) {
            return view('pages.shop.partials.product-list', compact('products', 'categories'))->render();
        }
        
        return view('pages.shop.index', compact('products', 'categories'));
    }
}
