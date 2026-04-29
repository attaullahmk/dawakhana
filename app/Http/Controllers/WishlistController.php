<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlists()->with('product')->latest()->get();
        return view('pages.wishlist', compact('wishlistItems'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $user = auth()->user();
        
        $wishlist = $user->wishlists()->where('product_id', $request->product_id)->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        } else {
            $user->wishlists()->create([
                'product_id' => $request->product_id
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
