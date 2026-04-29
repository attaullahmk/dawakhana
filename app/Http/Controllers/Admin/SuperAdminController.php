<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Show both admins and super admins
        $staff = User::whereIn('role', ['admin', 'super_admin'])->get();
        return view('admin.super-admins.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.super-admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // New staff added via UI are always 'admin'
            'email_verified_at' => now(), // Admins created by admins are pre-verified
        ]);

        return redirect()->route('admin.super-admins.index')->with('success', 'Admin staff account created successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting any Super Admin
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin accounts cannot be deleted for security reasons.');
        }
        
        $user->delete();

        return back()->with('success', 'Staff account removed successfully!');
    }
}
