<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HandymanCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandymanCommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = HandymanCommission::with('user');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $commissions = $query->latest()->paginate(10)->withQueryString();

        return view('admin.handyman-commissions.index', compact('commissions'));
    }

    public function toggle(HandymanCommission $commission)
    {
        $commission->update([
            'status' => $commission->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    public function bulkAction(Request $request)
    {
        if (empty($request->ids)) {
            return back()->with('error', 'Please select at least one commission.');
        }

        if ($request->action === 'active') {
            HandymanCommission::whereIn('id', $request->ids)->update(['status' => 'active']);
        }

        if ($request->action === 'inactive') {
            HandymanCommission::whereIn('id', $request->ids)->update(['status' => 'inactive']);
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}