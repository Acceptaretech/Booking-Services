<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('customer.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'address'    => ['nullable', 'string', 'max:1000'],

            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password'     => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->phone      = $request->phone;
        $user->address    = $request->address;

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $user->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'Current password is incorrect.'])
                    ->withInput();
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}