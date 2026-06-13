<?php

namespace App\Services\Customer;

use App\Services\Interfaces\CustomerProfileServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CustomerProfileService implements CustomerProfileServiceInterface
{
    public function profile($user)
    {
        return $user;
    }

    public function update(Request $request, $user)
    {
        $data = $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name'  => ['nullable', 'string', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'address'    => ['nullable', 'string', 'max:1000'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->first_name = $data['first_name'] ?? $user->first_name;
        $user->last_name  = $data['last_name'] ?? $user->last_name;
        $user->phone      = $data['phone'] ?? $user->phone;
        $user->address    = $data['address'] ?? $user->address;

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $user->profile_image = $request->file('profile_image')->store('profile-images', 'public');
        }

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return [
                    'error' => true,
                    'status' => 422,
                    'message' => 'Current password is incorrect.'
                ];
            }

            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return $user->fresh();
    }
}