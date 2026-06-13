<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HandymanRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'handyman')
            ->where('status', 'pending');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.handymen.requests', compact('requests'));
    }

    public function accept(User $user)
    {
        if ($user->role !== 'handyman') {
            return back()->with('error', 'Invalid handyman request.');
        }

        $user->update([
            'status' => 'active',
            'is_verified' => 1,
        ]);

        return back()->with('success', 'Handyman request accepted successfully.');
    }

    public function reject(User $user)
    {
        if ($user->role !== 'handyman') {
            return back()->with('error', 'Invalid handyman request.');
        }

        $user->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Handyman request rejected successfully.');
    }

    public function bulkAction(Request $request)
    {
        if (!$request->filled('action')) {
            return back()->with('error', 'Please select an action.');
        }

        if (empty($request->ids) || !is_array($request->ids)) {
            return back()->with('error', 'Please select at least one handyman.');
        }

        if ($request->action === 'accept') {
            User::whereIn('id', $request->ids)
                ->where('role', 'handyman')
                ->update([
                    'status' => 'active',
                    'is_verified' => 1,
                ]);
        }

        if ($request->action === 'reject') {
            User::whereIn('id', $request->ids)
                ->where('role', 'handyman')
                ->update([
                    'status' => 'rejected',
                ]);
        }

        return back()->with('success', 'Bulk action completed successfully.');
    }
}