<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\{Category, Service, Shop, SubCategory};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $shops = Shop::where('user_id', auth()->id())
            ->when($request->search, fn($q) => $q->where('name','like','%'.$request->search.'%'))
            ->when($request->status, fn($q,$s) => $q->where('status',$s))
            ->paginate(10);
        return view('provider.shops.index', compact('shops'));
    }

    public function create()
    {
        $services = Service::where('user_id',auth()->id())->active()->get();
        return view('provider.shops.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                => 'required|string|max:150',
            'email'               => 'nullable|email',
            'phone'               => 'nullable|string',
            'registration_number' => 'nullable|string',
            'address'             => 'nullable|string',
            'country'             => 'required|string',
            'state'               => 'required|string',
            'city'                => 'required|string',
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'image'               => 'nullable|image|max:2048',
            'status'              => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('shops','public');
        }
        $data['user_id'] = auth()->id();
        Shop::create($data);
        return redirect()->route('provider.shops.index')->with('success','Shop created.');
    }

    public function edit(Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);
        $services = Service::where('user_id',auth()->id())->active()->get();
        return view('provider.shops.edit', compact('shop','services'));
    }

    public function update(Request $request, Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);
        $data = $request->validate([
            'name'    => 'required|string|max:150',
            'email'   => 'nullable|email',
            'phone'   => 'nullable|string',
            'address' => 'nullable|string',
            'country' => 'required|string',
            'state'   => 'required|string',
            'city'    => 'required|string',
            'image'   => 'nullable|image|max:2048',
            'status'  => 'required|in:active,inactive',
        ]);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($shop->image);
            $data['image'] = $request->file('image')->store('shops','public');
        }
        $shop->update($data);
        return redirect()->route('provider.shops.index')->with('success','Shop updated.');
    }

    public function destroy(Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);
        Storage::disk('public')->delete($shop->image);
        $shop->delete();
        return back()->with('success','Shop deleted.');
    }

    public function toggleStatus(Shop $shop)
    {
        abort_unless($shop->user_id === auth()->id(), 403);
        $shop->update(['status' => $shop->status === 'active' ? 'inactive' : 'active']);
        return response()->json(['status' => $shop->status]);
    }
}


// ── Packages ─────────────────────────────────────────────────────────────────
