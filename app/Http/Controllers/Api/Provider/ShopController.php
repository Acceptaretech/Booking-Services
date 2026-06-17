<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::where('user_id', auth()->id())
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('phone', 'like', '%' . $request->search . '%')
                        ->orWhere('city', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.shops.index', compact('shops'));
    }

    public function create()
    {
        $services = Service::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('provider.shops.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:150',
            'email'               => 'nullable|email|max:150',
            'phone'               => 'nullable|string|max:30',
            'registration_number' => 'nullable|string|max:100',
            'address'             => 'nullable|string',
            'country'             => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'city'                => 'required|string|max:100',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'image'               => 'nullable|image|max:2048',
            'status'              => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('shops', 'public');
        }

        $data['user_id'] = auth()->id();

        Shop::create($data);

        return redirect()
            ->route('provider.shops.index')
            ->with('success', 'Shop created successfully.');
    }

    public function edit(Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);

        $services = Service::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('provider.shops.edit', compact('shop', 'services'));
    }

    public function update(Request $request, Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);

        $data = $request->validate([
            'name'                => 'required|string|max:150',
            'email'               => 'nullable|email|max:150',
            'phone'               => 'nullable|string|max:30',
            'registration_number' => 'nullable|string|max:100',
            'address'             => 'nullable|string',
            'country'             => 'required|string|max:100',
            'state'               => 'required|string|max:100',
            'city'                => 'required|string|max:100',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'image'               => 'nullable|image|max:2048',
            'status'              => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($shop->image) {
                Storage::disk('public')->delete($shop->image);
            }

            $data['image'] = $request->file('image')->store('shops', 'public');
        }

        $shop->update($data);

        return redirect()
            ->route('provider.shops.index')
            ->with('success', 'Shop updated successfully.');
    }

    public function destroy(Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);

        if ($shop->image) {
            Storage::disk('public')->delete($shop->image);
        }

        $shop->delete();

        return back()->with('success', 'Shop deleted successfully.');
    }

    public function toggleStatus(Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);

        $shop->update([
            'status' => $shop->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Shop status updated successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:active,inactive,delete',
            'ids'    => 'required|array',
            'ids.*'  => 'exists:shops,id',
        ]);

        $shops = Shop::where('user_id', auth()->id())
            ->whereIn('id', $request->ids);

        if ($request->action === 'delete') {
            $shops->get()->each(function ($shop) {
                if ($shop->image) {
                    Storage::disk('public')->delete($shop->image);
                }

                $shop->delete();
            });
        } else {
            $shops->update([
                'status' => $request->action,
            ]);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}