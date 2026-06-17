<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\HandymanCommission;
use Illuminate\Http\Request;

class HandymanCommissionController extends Controller
{
    public function index()
    {
        $commissions = HandymanCommission::where('user_id', auth()->id())->paginate(10);
        return view('provider.commissions.index', compact('commissions'));
    }

    public function create()
    {
        return view('provider.commissions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'commission' => 'required|numeric|min:0',
            'type'       => 'required|in:percent,fixed',
            'status'     => 'required|in:active,inactive',
        ]);
        $data['user_id'] = auth()->id();
        HandymanCommission::create($data);
        return redirect()->route('provider.handyman-commissions.index')->with('success','Commission created.');
    }

    public function edit(HandymanCommission $handymanCommission)
    {
        return view('provider.commissions.edit', ['commission' => $handymanCommission]);
    }

    public function update(Request $request, HandymanCommission $handymanCommission)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'commission' => 'required|numeric|min:0',
            'type'       => 'required|in:percent,fixed',
            'status'     => 'required|in:active,inactive',
        ]);
        $handymanCommission->update($data);
        return redirect()->route('provider.handyman-commissions.index')->with('success','Commission updated.');
    }

    public function destroy(HandymanCommission $handymanCommission)
    {
        $handymanCommission->delete();
        return back()->with('success','Commission deleted.');
    }
}


// ── Job Requests ──────────────────────────────────────────────────────────────
