<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $provider = auth()->user();

        return view('provider.profile.index', compact('provider'));
    }

    public function update(Request $request)
    {
        $provider = auth()->user();

        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'username'      => 'required|string|max:255|unique:users,username,' . $provider->id,
            'email'         => 'required|email|max:255|unique:users,email,' . $provider->id,
            'phone'         => 'nullable|string|max:255',
            'designation'   => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'state'         => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'status'        => 'nullable|in:active,inactive,pending,rejected',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {

            if ($provider->profile_image && Storage::disk('public')->exists($provider->profile_image)) {
                Storage::disk('public')->delete($provider->profile_image);
            }

            $data['profile_image'] = $request->file('profile_image')
                ->store('profile_images', 'public');
        }

        $provider->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $provider = auth()->user();

        if (!Hash::check($request->current_password, $provider->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.'
            ]);
        }

        $provider->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    

    public function billing()
    {
        $provider = auth()->user();

        return view('provider.profile.billing', compact('provider'));
    }

    public function settings()
    {
        $provider = auth()->user();

        return view('provider.profile.settings', compact('provider'));
    }
    public function changePassword()
    {
        $provider = auth()->user();

        return view('provider.profile.change-password', compact('provider'));
    }

    public function info(Request $request)
    {
        $provider = auth()->user();
        $tab = $request->get('tab', 'overview');
    
        $bookings = \App\Models\Booking::where('provider_id', $provider->id)
            ->latest()
            ->get();
    
        $totalBooking = $bookings->count();
        $completed = $bookings->where('status', 'completed')->count();
        $pending = $bookings->where('status', 'pending')->count();
        $cancelled = $bookings->where('status', 'cancelled')->count();
    
        $zone = \App\Models\Zone::find($provider->zone_id);
    
        return view('provider.profile.info', compact(
            'provider',
            'tab',
            'bookings',
            'totalBooking',
            'completed',
            'pending',
            'cancelled',
            'zone'
        ));
    }
}