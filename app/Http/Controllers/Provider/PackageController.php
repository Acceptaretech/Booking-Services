<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\{Category, Package, Service, SubCategory};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::where('user_id', auth()->id())
            ->with('category')
            ->when($request->search, fn($q) => $q->where('name','like','%'.$request->search.'%'))
            ->when($request->status, fn($q,$s) => $q->where('status',$s))
            ->paginate(10);
        return view('provider.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        $services   = Service::where('user_id',auth()->id())->active()->get();
        return view('provider.packages.create', compact('categories','services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:150',
            'description'  => 'nullable|string',
            'category_id'  => 'nullable|exists:categories,id',
            'service_id'   => 'nullable|exists:services,id',
            'price'        => 'required|numeric|min:0',
            'original_price'=> 'nullable|numeric|min:0',
            'package_type' => 'required|in:single_category,multi_category',
            'start_at'     => 'nullable|date',
            'end_at'       => 'nullable|date|after_or_equal:start_at',
            'image'        => 'nullable|image|max:2048',
            'status'       => 'required|in:active,inactive',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages','public');
        }
        $data['user_id'] = auth()->id();
        Package::create($data);
        return redirect()->route('provider.packages.index')->with('success','Package created.');
    }

    public function edit(Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);
        $categories = Category::active()->get();
        $services   = Service::where('user_id',auth()->id())->active()->get();
        return view('provider.packages.edit', compact('package','categories','services'));
    }

    public function update(Request $request, Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);
        $data = $request->validate([
            'name'    => 'required|string|max:150',
            'price'   => 'required|numeric|min:0',
            'status'  => 'required|in:active,inactive',
        ]);
        $package->update($data);
        return redirect()->route('provider.packages.index')->with('success','Package updated.');
    }

    public function destroy(Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);
        $package->delete();
        return back()->with('success','Package deleted.');
    }
}


// ── Addons ───────────────────────────────────────────────────────────────────
