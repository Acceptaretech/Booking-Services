<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AddonController extends Controller
{
    public function index(Request $request)
    {
        $addons = Addon::where('user_id', auth()->id())
            ->with('service')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.addons.index', compact('addons'));
    }

    public function create()
    {
        $services = Service::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('provider.addons.create', compact('services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('addons', 'public');
        }

        $data['user_id'] = auth()->id();

        Addon::create($data);

        return redirect()
            ->route('provider.addons.index')
            ->with('success', 'Addon created successfully.');
    }

    public function edit(Addon $addon)
    {
        abort_unless($addon->user_id === auth()->id(), 403);

        $services = Service::where('user_id', auth()->id())
            ->where('status', 'active')
            ->get();

        return view('provider.addons.edit', compact('addon', 'services'));
    }

    public function update(Request $request, Addon $addon)
    {
        abort_unless($addon->user_id === auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'service_id' => 'required|exists:services,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($addon->image) {
                Storage::disk('public')->delete($addon->image);
            }

            $data['image'] = $request->file('image')->store('addons', 'public');
        }

        $addon->update($data);

        return redirect()
            ->route('provider.addons.index')
            ->with('success', 'Addon updated successfully.');
    }

    public function destroy(Addon $addon)
    {
        abort_unless($addon->user_id === auth()->id(), 403);

        if ($addon->image) {
            Storage::disk('public')->delete($addon->image);
        }

        $addon->delete();

        return back()->with('success', 'Addon deleted successfully.');
    }

    public function toggleStatus(Addon $addon)
    {
        abort_unless($addon->user_id === auth()->id(), 403);

        $addon->update([
            'status' => $addon->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Addon status updated successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:active,inactive,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:addons,id',
        ]);

        $addons = Addon::where('user_id', auth()->id())
            ->whereIn('id', $request->ids);

        if ($request->action === 'delete') {
            $addons->get()->each(function ($addon) {
                if ($addon->image) {
                    Storage::disk('public')->delete($addon->image);
                }

                $addon->delete();
            });
        } else {
            $addons->update([
                'status' => $request->action,
            ]);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}
