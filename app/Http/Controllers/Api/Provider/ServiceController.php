<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceFaq;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::with(['category', 'shop'])
            ->where('user_id', auth()->id())
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();

        $shops = Shop::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('provider.services.create', compact('categories', 'shops'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'price_type' => 'required|in:fixed,hourly',
            'duration' => 'nullable|integer',
            'type' => 'required|in:fixed,online,both',
            'image' => 'required|image|max:2048',
            'shop_id' => 'nullable|exists:shops,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $data['user_id'] = auth()->id();

        Service::create($data);

        return redirect()
            ->route('provider.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        $service->load(['category', 'shop']);

        return view('provider.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        $categories = Category::where('status', 'active')->get();

        $shops = Shop::where('user_id', auth()->id())->get();

        return view('provider.services.edit', compact('service', 'categories', 'shops'));
    }

    public function update(Request $request, Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'price_type' => 'required|in:fixed,hourly',
            'duration' => 'nullable|integer',
            'type' => 'required|in:fixed,online,both',
            'image' => 'nullable|image|max:2048',
            'shop_id' => 'nullable|exists:shops,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        return redirect()
            ->route('provider.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return back()->with('success', 'Service deleted successfully.');
    }

    public function toggleStatus(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        $service->update([
            'status' => $service->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Service status updated successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:active,inactive,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:services,id',
        ]);

        $services = Service::where('user_id', auth()->id())
            ->whereIn('id', $request->ids);

        if ($request->action === 'delete') {
            $services->get()->each(function ($service) {
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }

                $service->delete();
            });
        } else {
            $services->update([
                'status' => $request->action,
            ]);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }

    public function faqs(Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        $faqs = ServiceFaq::where('service_id', $service->id)
            ->latest()
            ->get();

        return view('provider.services.faqs', compact('service', 'faqs'));
    }

    public function storeFaq(Request $request, Service $service)
    {
        abort_unless($service->user_id === auth()->id(), 403);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data['service_id'] = $service->id;

        ServiceFaq::create($data);

        return back()->with('success', 'FAQ added successfully.');
    }

    public function requestList(Request $request)
    {
        $services = Service::with(['category', 'shop'])
            ->where('user_id', auth()->id())
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.services.index', compact('services'));
    }
    
    public function getSubCategories(Category $category)
    {
        $subCategories = SubCategory::where('category_id', $category->id)
            ->where('status', 'active')
            ->select('id', 'name')
            ->get();

        return response()->json($subCategories);
    }
}
