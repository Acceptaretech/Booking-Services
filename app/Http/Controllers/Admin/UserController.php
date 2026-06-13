<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{CommissionSetting, User, UserDocument, Zone};
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function providers(Request $request)
    {
        $providers = User::providers()
            ->with(['document','commissionSetting','shops'])
            ->withCount(['providerBookings','services'])
            ->when($request->search, fn($q,$s) => $q->where('email','like',"%$s%")
                ->orWhere('first_name','like',"%$s%"))
            ->when($request->status, fn($q,$s) => $q->where('status',$s))
            ->latest()->paginate(15);
        return view('admin.providers.index', compact('providers'));
    }

    public function editProvider(User $user)
    {
        return view('admin.providers.edit', compact('user'));
    }

    public function updateProvider(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name'  => 'nullable|string|max:100',
        'name'       => 'nullable|string|max:150',
        'email'      => 'required|email|unique:users,email,' . $user->id,
        'phone'      => 'nullable|string|max:20',
        'status'     => 'required|in:active,pending,rejected,inactive',
    ]);

        $user->update($data);

        return redirect()
            ->route('admin.providers.index')
            ->with('success', 'Provider updated successfully.');
    }
    public function showProvider(User $user)
    {
        $user->load(['document','commissionSetting','shops','services','reviews']);
        $zones = Zone::active()->get();
        return view('admin.providers.show', compact('user','zones'));
    }

    public function approveProvider(User $user)
    {
        $user->update(['status' => 'active']);
        return back()->with('success','Provider approved.');
    }

    public function rejectProvider(Request $request, User $user)
    {
        $user->update(['status' => 'rejected']);
        return back()->with('success','Provider rejected.');
    }

    public function providerRequests()
    {
        $providers = User::where('role', 'provider')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.providers.requests', compact('providers'));
    }

    public function providerCommissions()
    {
        $providers = User::where('role', 'provider')
            ->latest()
            ->paginate(10);

        return view('admin.providers.commissions', compact('providers'));
    }



    public function customers(Request $request)
    {
        $customers = User::customers()
            ->withCount('customerBookings')
            ->when($request->search, fn($q,$s) => $q->where('email','like',"%$s%"))
            ->latest()->paginate(15);
        return view('admin.users.customers', compact('customers'));
    }

    public function handymen(Request $request)
    {
        $handymen = User::where('role', 'handyman')
            ->with('zone')
            ->withCount('handymanBookings')
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('first_name', 'like', '%' . $request->search . '%')
                          ->orWhere('last_name', 'like', '%' . $request->search . '%')
                          ->orWhere('email', 'like', '%' . $request->search . '%')
                          ->orWhere('phone', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(15);
    
        return view('admin.users.handymen', compact('handymen'));
    }

    public function setCommission(Request $request, User $user)
    {
        $request->validate([
            'commission_value' => 'required|numeric|min:0',
            'commission_type'  => 'required|in:percent,fixed',
        ]);
        CommissionSetting::updateOrCreate(
            ['provider_id' => $user->id],
            $request->only('commission_value','commission_type')
        );
        return back()->with('success','Commission updated.');
    }

    public function toggleStatus(User $user)
    {
        $user->update(['status' => $user->status === 'active' ? 'inactive' : 'active']);
        return response()->json(['status' => $user->status]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','User deleted.');
    }
    // User 
    public function allUsers(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('first_name', 'like', '%' . $request->search . '%')
                        ->orWhere('last_name', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('phone', 'like', '%' . $request->search . '%')
                        ->orWhere('role', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
{
    return view('admin.users.edit', compact('user'));
}

public function updateUser(Request $request, User $user)
{
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'required|string|max:30',
        'role' => 'required|in:customer,user,provider,handyman,admin',
        'status' => 'required|in:active,inactive,pending,rejected',
        'address' => 'nullable|string|max:1000',
        'country' => 'nullable|string|max:255',
        'state' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:255',
    ]);

    $user->update($data);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User updated successfully.');
}
    
    public function unverifiedUsers(Request $request)
    {
        $users = User::where('is_verified', 0)
            ->latest()
            ->paginate(15);

        return view('admin.users.unverified', compact('users'));
    }

    public function verifyUser(User $user)
    {
        $user->update([
            'is_verified' => 1,
            'status' => 'active',
        ]);

        return back()->with('success', 'User verified successfully.');
    }
}

// ── Settings ─────────────────────────────────────────────────────────────────
