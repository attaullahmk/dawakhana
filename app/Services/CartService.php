<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Setting;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;

class CartService
{
    public static function getCartQuery()
    {
        if (auth()->check()) {
            return Cart::where('user_id', auth()->id());
        }
        return Cart::where('session_id', Session::getId());
    }

    public static function getTotals()
    {
        $cartItems = self::getCartQuery()->with('product')->get();
        
        $subtotal = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $price = $item->product->sale_price ?: $item->product->price;
                $subtotal += $price * $item->quantity;
            }
        }
        
        $shipping = (float) (Setting::where('key', 'shipping_estimate')->value('value') ?? 50.00);
        $tax = (float) (Setting::where('key', 'estimated_tax')->value('value') ?? 25.00);
        
        $discount = 0;
        $coupon = null;
        if (Session::has('coupon_id')) {
            $coupon = Coupon::find(Session::get('coupon_id'));
            if ($coupon && $coupon->is_active && $subtotal >= ($coupon->min_order ?? 0)) {
                if ($coupon->type === 'percent') {
                    $discount = $subtotal * ($coupon->value / 100);
                } else {
                    $discount = $coupon->value;
                }
                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }
            } else {
                Session::forget('coupon_id');
                $coupon = null;
            }
        }

        $total = ($subtotal - $discount) + $shipping + $tax;

        return [
            'cartItems' => $cartItems,
            'subtotal' => (float)$subtotal,
            'shipping' => (float)$shipping,
            'tax' => (float)$tax,
            'discount' => (float)$discount,
            'total' => (float)$total,
            'coupon' => $coupon
        ];
    }

    public static function clear()
    {
        self::getCartQuery()->delete();
        Session::forget('coupon_id');
    }
}
