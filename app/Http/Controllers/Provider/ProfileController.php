<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Storage};

class ProfileController extends Controller
{
    public function index()
    {
        return view('provider.profile.index', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'phone'         => 'nullable|string',
            'designation'   => 'nullable|string',
            'address'       => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('profile_image')) {
            Storage::disk('public')->delete($user->profile_image);
            $data['profile_image'] = $request->file('profile_image')->store('profiles','public');
        }
        if ($request->filled('new_password')) {
            $request->validate(['current_password'=>'required','new_password'=>'required|min:8|confirmed']);
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password'=>'Incorrect current password.']);
            }
            $data['password'] = Hash::make($request->new_password);
        }
        $user->update($data);
        return back()->with('success','Profile updated.');
    }

    public function info()
    {
        return view('provider.profile.info', ['user' => auth()->user()]);
    }

    public function billing()
    {
        return view('provider.profile.billing', ['user' => auth()->user()]);
    }

    public function settings()
    {
        return view('provider.profile.settings', ['user' => auth()->user()]);
    }
}
