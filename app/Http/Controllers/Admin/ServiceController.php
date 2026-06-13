<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SubCategory;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with(['provider', 'category'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(15);

        $categories = Category::where('status', 'active')->pluck('name', 'id');

        return view('admin.services.index', compact('services', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
    
        $providers = User::where('role', 'provider')       
            ->get();
    
        $zones = Zone::where('status', 'active')->get();
    
        return view('admin.services.create', compact(
            'categories',
            'providers',
            'zones'
        ));
    }

    public function getSubcategories($categoryId)
    {
        try {
            $subcategories = SubCategory::where('category_id', $categoryId)
                ->select('id', 'name')
                ->orderBy('name', 'asc')
                ->get();
    
            return response()->json($subcategories);
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getZonesByProvider($provider)
    {
        $provider = User::findOrFail($provider);

        $zones = Zone::where('id', $provider->zone_id)
            ->select('id', 'name')
            ->get();

        return response()->json($zones);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'zone_id'        => 'nullable|exists:zones,id',
            'name'           => 'required|string|max:150',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'price_type'     => 'required|in:fixed,hourly',
            'duration'       => 'nullable|integer',
            'type'           => 'required|in:fixed,online,both',
            'image'          => 'required|image|max:2048',
            'status'         => 'required|in:active,inactive',
            'is_featured'    => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('services', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');

        Service::create($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        $service->load(['provider', 'category']);

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
{
    $categories = Category::where('status', 'active')->get();

    $providers = User::where('role', 'provider')
        ->where('status', 'active')
        ->get();

    $zones = Zone::where('status', 'active')->get();

    return view('admin.services.edit', compact(
        'service',
        'categories',
        'providers',
        'zones'
    ));
}

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'zone_id'        => 'nullable|exists:zones,id',
            'name'           => 'required|string|max:150',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount'       => 'nullable|numeric|min:0|max:100',
            'price_type'     => 'required|in:fixed,hourly',
            'duration'       => 'nullable|integer',
            'type'           => 'required|in:fixed,online,both',
            'image'          => 'nullable|image|max:2048',
            'status'         => 'required|in:active,inactive',
            'is_featured'    => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {

            if (
                $service->image &&
                Storage::disk('public')->exists($service->image)
            ) {
                Storage::disk('public')->delete($service->image);
            }

            $data['image'] = $request->file('image')
                ->store('services', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');

        $service->update($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        if (
            $service->image &&
            Storage::disk('public')->exists($service->image)
        ) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}