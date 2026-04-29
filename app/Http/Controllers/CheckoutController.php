<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $totals = CartService::getTotals();
        
        if ($totals['cartItems']->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('pages.checkout', $totals);
    }

    public function placeOrder(Request $request)
    {
        $totals = CartService::getTotals();
        
        if ($totals['cartItems']->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:10',
            'shipping_country' => 'required|string|max:255',
            'payment_method' => 'required|in:credit_card,cod,whatsapp',
            // Card details only required if payment_method is credit_card
            'card_number' => 'required_if:payment_method,credit_card|nullable|string|min:13|max:19',
            'expiry' => 'required_if:payment_method,credit_card|nullable|string',
            'cvv' => 'required_if:payment_method,credit_card|nullable|string|digits_between:3,4',
        ]);

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'status' => 'pending',
                'subtotal' => $totals['subtotal'],
                'shipping_cost' => $totals['shipping'],
                'tax' => $totals['tax'],
                'total' => $totals['total'],
                'payment_method' => $request->payment_method,
                'payment_status' => ($request->payment_method === 'credit_card' ? 'paid' : 'pending'),
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zip' => $request->shipping_zip,
                'notes' => $request->notes,
            ]);

            foreach ($totals['cartItems'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->sale_price ?: $item->product->price,
                ]);
            }

            CartService::clear();

            DB::commit();

            return redirect()->route('checkout.success', ['order_id' => $order->id])->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = null;
        if ($orderId) {
            $order = Order::with('items.product')->find($orderId);
            // Basic security check: ensure user owns the order if logged in
            if (auth()->check() && $order && $order->user_id !== auth()->id()) {
                $order = null;
            }
        }

        return view('pages.order-success', compact('order'));
    }
}
