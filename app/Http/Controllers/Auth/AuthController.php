<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\{User, UserDocument, Zone};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Login ──────────────────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        $user = Auth::user();

        if (!$user->isActive()) {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account is not active. Please contact admin.'])->withInput();
        }

        $request->session()->regenerate();

        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'provider' => redirect()->route('provider.dashboard'),
            'handyman' => redirect()->route('provider.dashboard'),
            default    => redirect()->route('customer.dashboard'),
        };
    }

    // ── Register (Customer) ────────────────────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users',
            'phone'      => 'required|string|max:20',
            'password'   => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'role'       => 'customer',
            'status'     => 'active',
        ]);

        Auth::login($user);
        return redirect()->route('customer.dashboard')->with('success', 'Welcome! Your account has been created.');
    }

    // ── Register (Provider / Handyman) ────────────────────────
    public function showProviderRegister()
    {
        $zones = Zone::where('status', 'active')->get();
        return view('auth.provider-register', compact('zones'));
    }

    public function providerRegister(Request $request)
    {
        $request->validate([
            'username'         => 'required|string|unique:users|max:50',
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|unique:users',
            'phone'            => 'required|string|max:20',
            'password'         => ['required', 'confirmed', Password::min(8)],
            'user_type'        => 'required|in:provider,handyman',
            'zone_id'          => 'required|exists:zones,id',
            'passport'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'driving_licence'  => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'terms'            => 'accepted',
        ]);

        $user = User::create([
            'username'    => $request->username,
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'country_code'=> $request->country_code ?? '+91',
            'password'    => Hash::make($request->password),
            'role'        => $request->user_type,
            'designation' => $request->designation,
            'zone_id'     => $request->zone_id,
            'status'      => 'pending', // requires admin approval
        ]);

        // Handle documents
        $docs = ['voting_card','pan_card','passport','aadhar_card','driving_licence'];
        $docData = [];
        foreach ($docs as $doc) {
            if ($request->hasFile($doc)) {
                $docData[$doc] = $request->file($doc)->store('documents', 'public');
            }
        }

        UserDocument::create(array_merge(['user_id' => $user->id], $docData));

        return redirect()->route('login')
            ->with('success', 'Registration submitted. Your account is pending admin approval.');
    }

    // ── Logout ─────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ── Forgot / Reset Password ────────────────────────────────
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        \Illuminate\Support\Facades\Password::sendResetLink($request->only('email'));
        return back()->with('status', 'Password reset link sent to your email.');
    }
}
