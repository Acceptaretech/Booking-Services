<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Handyman;
use Illuminate\Support\Facades\Storage;

class HandymanController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'handyman')
            ->with('provider');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $handymen = $query->latest()->paginate(10)->withQueryString();

        return view('admin.handymen.index', compact('handymen'));
    }

    public function create()
    {
        $providers = User::where('role', 'provider')
            ->latest()
            ->get();
    
        return view('admin.handymen.create', compact('providers'));
    }

    public function edit(User $user)
    {
        $providers = User::where('role', 'provider')->latest()->get();

        $user->load('handyman');
    
        return view('admin.handymen.edit', compact('user', 'providers'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:30',
            'password' => 'nullable|min:6',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    
            'provider_id' => 'nullable|exists:users,id',
            'commission' => 'nullable|numeric|min:0',
            'commission_type' => 'required|in:percent,fixed',
    
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,pending',
        ]);
    
        $profileImage = $user->profile_image;
    
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }
    
            $profileImage = $request->file('profile_image')->store('handyman', 'public');
        }
    
        DB::transaction(function () use ($data, $user, $profileImage) {
            $user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'status' => $data['status'],
                'profile_image' => $profileImage,
            ]);
    
            if (!empty($data['password'])) {
                $user->update([
                    'password' => Hash::make($data['password']),
                ]);
            }
    
            Handyman::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'provider_id' => $data['provider_id'] ?? null,
                    'commission' => $data['commission'] ?? 0,
                    'commission_type' => $data['commission_type'],
                    'address' => $data['address'] ?? null,
                    'country' => $data['country'] ?? null,
                    'state' => $data['state'] ?? null,
                    'city' => $data['city'] ?? null,
                    'status' => $data['status'],
                ]
            );
        });
    
        return redirect()
            ->route('admin.handymen.index')
            ->with('success', 'Handyman updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Handyman deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        if (empty($request->ids)) {
        return back()->with('error', 'Please select at least one handyman.');
    }
        $request->validate([
            'action' => 'required',
        ]);

        if ($request->action === 'delete') {
            User::whereIn('id', $request->ids)->delete();
        }

        if ($request->action === 'active') {
            User::whereIn('id', $request->ids)->update(['status' => 'active']);
        }

        if ($request->action === 'inactive') {
            User::whereIn('id', $request->ids)->update(['status' => 'inactive']);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
        public function store(Request $request)
        {
            $profileImage = null;

            if ($request->hasFile('profile_image')) {
                    $profileImage = $request->file('profile_image')->store('handyman', 'public');
            }
            $data = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'phone' => 'required|string|max:30',

                'provider_id' => 'nullable|exists:users,id',
                'commission' => 'nullable|numeric|min:0',
                'commission_type' => 'required|in:percent,fixed',

                'address' => 'nullable|string',
                'country' => 'nullable|string|max:255',
                'state' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive,pending',
            ]);

            DB::transaction(function () use ($data, $profileImage) {
                $user = User::create([
                    'username' => $data['username'],
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'role' => 'handyman',
                    'status' => $data['status'],
                    'profile_image' => $profileImage,
                    'wallet_amount' => 0,
                ]);

                Handyman::create([
                    'user_id' => $user->id,
                    'provider_id' => $data['provider_id'] ?? null,
                    'commission' => $data['commission'] ?? 0,
                    'commission_type' => $data['commission_type'],
                    'address' => $data['address'] ?? null,
                    'country' => $data['country'] ?? null,
                    'state' => $data['state'] ?? null,
                    'city' => $data['city'] ?? null,
                    'status' => $data['status'],
                ]);
            });

            return redirect()
                ->route('admin.handymen.index')
                ->with('success', 'Handyman created successfully.');
        }
}