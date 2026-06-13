<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderCommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'provider');

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $providers = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.providers.commissions',
            compact('providers')
        );
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status == 'active'
                ? 'inactive'
                : 'active'
        ]);

        return back()->with(
            'success',
            'Provider status updated successfully.'
        );
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with(
            'success',
            'Provider deleted successfully.'
        );
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required',
            'ids' => 'required|array'
        ]);

        switch ($request->action) {

            case 'active':
                User::whereIn('id', $request->ids)
                    ->update(['status' => 'active']);
                break;

            case 'inactive':
                User::whereIn('id', $request->ids)
                    ->update(['status' => 'inactive']);
                break;

            case 'delete':
                User::whereIn('id', $request->ids)
                    ->delete();
                break;
        }

        return back()->with(
            'success',
            'Bulk action applied successfully.'
        );
    }
}