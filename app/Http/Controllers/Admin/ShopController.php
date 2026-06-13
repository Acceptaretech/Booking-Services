<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::with('provider')
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('city', 'like', '%' . $search . '%')
                        ->orWhere('registration_number', 'like', '%' . $search . '%');
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.shops.index', compact('shops'));
    }

    public function create()
    {
        $providers = User::where('role', 'provider')
            ->where('status', 'active')
            ->get();

        return view('admin.shops.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'country_code' => 'nullable|string|max:10',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'languages' => 'nullable|array',
            'languages.*' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['country_code'] = $data['country_code'] ?? '+91';
        $data['languages'] = $request->languages ?? ['en'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!file_exists(public_path('storage/shop'))) {
                mkdir(public_path('storage/shop'), 0777, true);
            }

            $file->move(public_path('storage/shop'), $filename);

            $data['image'] = 'shop/' . $filename;
        }

        Shop::create($data);

        return redirect()
            ->route('admin.shops.index')
            ->with('success', 'Shop created successfully.');
    }

    public function edit(Shop $shop)
    {
        $providers = User::where('role', 'provider')
            ->where('status', 'active')
            ->get();

        return view('admin.shops.edit', compact('shop', 'providers'));
    }

    public function update(Request $request, Shop $shop)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'country_code' => 'nullable|string|max:10',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'languages' => 'nullable|array',
            'languages.*' => 'nullable|string|max:50',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['country_code'] = $data['country_code'] ?? '+91';
        $data['languages'] = $request->languages ?? ['en'];

        if ($request->hasFile('image')) {
            if ($shop->image && file_exists(public_path('storage/' . $shop->image))) {
                unlink(public_path('storage/' . $shop->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            if (!file_exists(public_path('storage/shop'))) {
                mkdir(public_path('storage/shop'), 0777, true);
            }

            $file->move(public_path('storage/shop'), $filename);

            $data['image'] = 'shop/' . $filename;
        }

        $shop->update($data);

        return redirect()
            ->route('admin.shops.index')
            ->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        if ($shop->image && file_exists(public_path('storage/' . $shop->image))) {
            unlink(public_path('storage/' . $shop->image));
        }

        $shop->delete();

        return back()->with('success', 'Shop deleted successfully.');
    }
    public function show(Shop $shop)
    {
        $shop->load('provider');

        return view('admin.shops.show', compact('shop'));
    }
}