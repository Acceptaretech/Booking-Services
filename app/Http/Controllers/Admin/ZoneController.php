<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    public function index()
    {
        $zones = Zone::withCount('users')->latest()->paginate(10);
        return view('admin.zones.index', compact('zones'));
    }

    public function create()  { return view('admin.zones.create'); }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required|string','status'=>'required|in:active,inactive']);
        Zone::create($request->all());
        return redirect()->route('admin.zones.index')->with('success','Zone added.');
    }

    public function show(Zone $zone)  { return view('admin.zones.show', compact('zone')); }

    public function edit(Zone $zone)  { return view('admin.zones.edit', compact('zone')); }

    public function update(Request $request, Zone $zone)
    {
        $request->validate(['name'=>'required|string','status'=>'required']);
        $zone->update($request->all());
        return redirect()->route('admin.zones.index')->with('success','Zone updated.');
    }

    public function destroy(Zone $zone)
    {
        $zone->delete();
        return back()->with('success','Zone deleted.');
    }
}


// ── Admin Tax ─────────────────────────────────────────────────────────────────
