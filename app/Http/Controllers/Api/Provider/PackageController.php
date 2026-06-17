<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\Service;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::where('user_id', auth()->id())
            ->with(['category', 'service'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.packages.index', compact('packages'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();

        $services = Service::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('provider.packages.create', compact('categories', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'service_id' => 'nullable|exists:services,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'package_type' => 'required|in:single_category,multi_category',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $data['user_id'] = auth()->id();

        Package::create($data);

        return redirect()
            ->route('provider.packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function edit(Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);

        $categories = Category::where('status', 'active')->get();

        $subCategories = SubCategory::where('category_id', $package->category_id)
            ->where('status', 'active')
            ->get();

        $services = Service::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view(
            'provider.packages.edit',
            compact('package', 'categories', 'subCategories', 'services')
        );
    }

    public function update(Request $request, Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
            'service_id' => 'nullable|exists:services,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'package_type' => 'required|in:single_category,multi_category',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image) {
                Storage::disk('public')->delete($package->image);
            }

            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $package->update($data);

        return redirect()
            ->route('provider.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);

        if ($package->image) {
            Storage::disk('public')->delete($package->image);
        }

        $package->delete();

        return back()->with('success', 'Package deleted successfully.');
    }

    public function toggleStatus(Package $package)
    {
        abort_unless($package->user_id === auth()->id(), 403);

        $package->update([
            'status' => $package->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Package status updated successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:active,inactive,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:packages,id',
        ]);

        $packages = Package::where('user_id', auth()->id())
            ->whereIn('id', $request->ids);

        if ($request->action === 'delete') {
            $packages->get()->each(function ($package) {
                if ($package->image) {
                    Storage::disk('public')->delete($package->image);
                }

                $package->delete();
            });
        } else {
            $packages->update([
                'status' => $request->action,
            ]);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }

    public function getSubCategories($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json($subCategories);
    }
}
