<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Coupon;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $totals = CartService::getTotals();
        return view('pages.cart', $totals);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $quantity = $request->quantity ?? 1;
        $product = Product::findOrFail($request->product_id);
        
        if ($product->stock_quantity < $quantity) {
            return response()->json(['error' => 'Not enough stock available'], 400);
        }

        $cartItem = CartService::getCartQuery()->where('product_id', $product->id)->first();

        if ($cartItem) {
            if (($cartItem->quantity + $quantity) > $product->stock_quantity) {
                return response()->json(['error' => 'Stock limit reached'], 400);
            }
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'session_id' => session()->getId(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        $count = CartService::getCartQuery()->count();
        return response()->json(['success' => 'Added to cart', 'count' => $count]);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:cart,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartService::getCartQuery()->where('id', $request->cart_id)->firstOrFail();
        
        if ($cartItem->product && $request->quantity > $cartItem->product->stock_quantity) {
            return response()->json(['error' => 'Stock limit reached'], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(array_merge(['success' => 'Cart updated'], CartService::getTotals()));
    }

    public function remove(Request $request)
    {
        $request->validate(['cart_id' => 'required|exists:cart,id']);
        $cartItem = CartService::getCartQuery()->where('id', $request->cart_id)->firstOrFail();
        $cartItem->delete();

        $count = CartService::getCartQuery()->count();
        $totals = CartService::getTotals();
        $totals['count'] = $count;
        $totals['success'] = 'Item removed';
        return response()->json($totals);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        
        $coupon = Coupon::where('code', $request->code)->where('is_active', true)->first();
        
        if (!$coupon) {
            return response()->json(['error' => 'Invalid or inactive coupon code.'], 400);
        }

        if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
            return response()->json(['error' => 'This coupon has expired.'], 400);
        }

        $totals = CartService::getTotals();
        
        if ($totals['subtotal'] < $coupon->min_order) {
            return response()->json(['error' => 'Your subtotal must be at least $' . number_format($coupon->min_order, 2) . ' to use this coupon.'], 400);
        }

        session()->put('coupon_id', $coupon->id);
        
        return response()->json(array_merge(['success' => 'Coupon applied!'], CartService::getTotals()));
    }

    public function removeCoupon()
    {
        session()->forget('coupon_id');
        return response()->json(array_merge(['success' => 'Coupon removed!'], CartService::getTotals()));
    }
}
