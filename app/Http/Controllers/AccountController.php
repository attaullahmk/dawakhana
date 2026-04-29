<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $ordersCount = $user->orders()->count();
        $wishlistCount = $user->wishlists()->count();
        $addressCount = $user->address ? 1 : 0;
        
        // Fetch real orders for the My Orders tab
        $orders = $user->orders()->with('items.product')->latest()->get();
        
        return view('pages.account.index', compact('user', 'ordersCount', 'wishlistCount', 'addressCount', 'orders'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', __('Current password does not match.'));
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('account.index')->with('success', __('Profile updated successfully.'))->with('active_tab', 'settings');
    }
}
