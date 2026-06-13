<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\Service;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::with(['provider', 'category', 'subCategory', 'service'])
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $providers = User::where('role', 'provider')->get();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $services = Service::all();

        return view('admin.packages.create', compact('providers', 'categories', 'subCategories', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'package_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('package', $filename, 'public');

            $data['image'] = 'package/' . $filename;
        }

        Package::create($data);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
        $providers = User::where('role', 'provider')->get();
        $categories = Category::all();
        $subCategories = SubCategory::all();
        $services = Service::all();

        return view('admin.packages.edit', compact('package', 'providers', 'categories', 'subCategories', 'services'));
    }

    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'package_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if (!empty($package->image) && Storage::disk('public')->exists($package->image)) {
                Storage::disk('public')->delete($package->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('package', $filename, 'public');

            $data['image'] = 'package/' . $filename;
        }

        $package->update($data);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        if (!empty($package->image) && Storage::disk('public')->exists($package->image)) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return back()->with('success', 'Package deleted successfully.');
    }
}