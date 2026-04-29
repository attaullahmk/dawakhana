<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {
            $otp = rand(100000, 999999);

            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'customer',
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10),
            ]);

            Mail::to($user->email)->send(new OTPMail($otp));

            return redirect()->route('register.verify.show')->with(['email' => $user->email, 'success' => 'Account created! Please verify your email with the OTP sent.']);
        } catch (\Exception $e) {
            return back()->withErrors(['system_error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }

    public function showOtpVerification()
    {
        if (!session('email')) {
            return redirect()->route('register');
        }
        return view('pages.auth.otp-verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|array|size:6',
        ]);

        $otpCode = implode('', $request->otp);
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->otp_code !== $otpCode || Carbon::now()->gt($user->otp_expires_at)) {
            return back()->with(['email' => $request->email, 'error' => 'Invalid or expired OTP. Please try again.']);
        }

        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->email_verified_at = Carbon::now();
        $user->save();

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Email verified! Welcome to Atta_Furniture.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = rand(100000, 999999);
            $user->otp_code = $otp;
            $user->otp_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            Mail::to($user->email)->send(new OTPMail($otp));

            return back()->with(['email' => $request->email, 'success' => 'A new OTP has been sent to your email.']);
        }

        return back()->with('error', 'User not found.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();
            
            if (!$user->email_verified_at) {
                // If not verified, logout and redirect to verify
                Auth::logout();
                
                // Regenerate OTP for security
                $otp = rand(100000, 999999);
                $user->otp_code = $otp;
                $user->otp_expires_at = Carbon::now()->addMinutes(10);
                $user->save();
                
                Mail::to($user->email)->send(new OTPMail($otp));
                
                return redirect()->route('register.verify.show')->with(['email' => $user->email, 'error' => 'Your email is not verified. A new OTP has been sent.']);
            }

            $request->session()->regenerate();
            
            if ($user->isAdmin() || $user->isSuperAdmin()) {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
