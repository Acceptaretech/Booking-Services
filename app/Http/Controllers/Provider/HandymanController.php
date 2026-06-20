<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\HandymanCommission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HandymanController extends Controller
{
    public function index(Request $request)
    {
        // dd(auth()->id());
        $handymen = User::where('role', 'handyman')
            ->where('provider_id', auth()->id())
            ->with(['zone', 'provider'])
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%'.$request->search.'%')
                        ->orWhere('last_name', 'like', '%'.$request->search.'%')
                        ->orWhere('email', 'like', '%'.$request->search.'%')
                        ->orWhere('phone', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('provider.handymen.index', compact('handymen'));
    }

    public function create()
    {
        return view('provider.handymen.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'username'       => 'required|string|unique:users,username',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            'phone'          => 'required|string',
            'address'        => 'nullable|string',
            'country'        => 'nullable|string',
            'state'          => 'nullable|string',
            'city'           => 'nullable|string',
            'profile_image'  => 'nullable|image|max:2048',
            'status'         => 'required|in:active,inactive',
            'commission_type' => 'required|in:fixed,percentage',
            'commission'      => 'required|numeric|min:0',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $data['role'] = 'handyman';
        $data['provider_id'] = auth()->id();
        $data['password'] = Hash::make($data['password']);
        $data['zone_id'] = auth()->user()->zone_id;

        User::create($data);

        return redirect()->route('provider.handymen.index')->with('success', 'Handyman added.');
    }

    public function edit(User $user)
    {
        abort_if(
            $user->role !== 'handyman' ||
            $user->provider_id != auth()->id(),
            403
        );

        return view('provider.handymen.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(
            $user->role !== 'handyman' ||
            $user->provider_id != auth()->id(),
            403
        );

        $data = $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'phone'           => 'required|string',
            'address'         => 'nullable|string',
            'country'         => 'nullable|string',
            'state'           => 'nullable|string',
            'city'            => 'nullable|string',
            'status'          => 'required|in:active,inactive',
            'commission_type' => 'required|in:fixed,percentage',
            'commission'      => 'required|numeric|min:0',
            'profile_image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {

            if (
                $user->profile_image &&
                Storage::disk('public')->exists($user->profile_image)
            ) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $data['profile_image'] = $request->file('profile_image')
                ->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('provider.handymen.index')
            ->with('success', 'Technician updated successfully.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role !== 'handyman' || $user->provider_id != auth()->id(), 403);

        if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->delete();

        return back()->with('success', 'Handyman deleted.');
    }

    public function requests(Request $request)
    {
        $handymen = User::where('role', 'handyman')
            ->where('provider_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('provider.handymen.requests', compact('handymen'));
    }

    public function unassigned(Request $request)
    {
        $handymen = User::where('role', 'handyman')
            ->where('provider_id', auth()->id())
            ->doesntHave('handymanBookings')
            ->latest()
            ->paginate(10);

        return view('provider.handymen.unassigned', compact('handymen'));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:active,inactive,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        $handymen = User::where('role', 'handyman')
            ->where('provider_id', auth()->id())
            ->whereIn('id', $request->ids);

        if ($request->action === 'delete') {
            $handymen->each(function ($handyman) {
                if ($handyman->profile_image && Storage::disk('public')->exists($handyman->profile_image)) {
                    Storage::disk('public')->delete($handyman->profile_image);
                }

                $handyman->delete();
            });
        } else {
            $handymen->update([
                'status' => $request->action,
            ]);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}