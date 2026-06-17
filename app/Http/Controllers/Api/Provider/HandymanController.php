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
        $handymen = User::where('role', 'handyman')
            ->where('zone_id', auth()->user()->zone_id)
            ->with('zone')
            ->when($request->search, function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                    ->orWhere('email', 'like', '%'.$request->search.'%');
            })
            ->paginate(10);

        return view('provider.handymen.index', compact('handymen'));
    }

    public function create()
    {
        $commissions = HandymanCommission::where('user_id', auth()->id())->where('status', 'active')->get();

        return view('provider.handymen.create', compact('commissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'country' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'commission_id' => 'required|exists:handyman_commissions,id',
        ]);

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }

        $data['role'] = 'handyman';
        $data['password'] = Hash::make($data['password']);
        $data['zone_id'] = auth()->user()->zone_id;
        $handyman = User::create($data);

        return redirect()->route('provider.handymen.index')->with('success', 'Handyman added.');
    }

    public function edit(User $user)
    {
        $commissions = HandymanCommission::where('user_id', auth()->id())->where('status', 'active')->get();

        return view('provider.handymen.edit', compact('user', 'commissions'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string',
            'status' => 'required|in:active,inactive',
        ]);
        if ($request->hasFile('profile_image')) {
            Storage::disk('public')->delete($user->profile_image);
            $data['profile_image'] = $request->file('profile_image')->store('profiles', 'public');
        }
        $user->update($data);

        return redirect()->route('provider.handymen.index')->with('success', 'Handyman updated.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'Handyman deleted.');
    }

    public function requests(Request $request)
    {
        $handymen = User::handymen()
            ->where('zone_id', auth()->user()->zone_id)
            ->where('status', 'pending')
            ->paginate(10);

        return view('provider.handymen.requests', compact('handymen'));
    }

    public function unassigned(Request $request)
    {
        $handymen = User::handymen()
            ->where('zone_id', auth()->user()->zone_id)
            ->doesntHave('handymanBookings')
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
            ->whereIn('id', $request->ids);

        if ($request->action === 'delete') {
            $handymen->delete();
        } else {
            $handymen->update([
                'status' => $request->action,
            ]);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}

// ── Handyman Commission ───────────────────────────────────────────────────────
