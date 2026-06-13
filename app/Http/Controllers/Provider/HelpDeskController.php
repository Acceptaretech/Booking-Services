<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\HelpDesk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HelpDeskController extends Controller
{
    public function index()
    {
        $tickets = HelpDesk::where('user_id', auth()->id())->latest()->paginate(10);
        return view('provider.help-desk.index', compact('tickets'));
    }

    public function create()
    {
        return view('provider.help-desk.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'     => 'required|string|max:200',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('helpdesk','public');
        }
        $data['user_id'] = auth()->id();
        $data['role']    = auth()->user()->role;
        HelpDesk::create($data);
        return redirect()->route('provider.help-desk.index')->with('success','Ticket submitted.');
    }

    public function show(HelpDesk $helpDesk)
    {
        abort_unless($helpDesk->user_id === auth()->id(), 403);
        return view('provider.help-desk.show', compact('helpDesk'));
    }

    public function edit(HelpDesk $helpDesk)        { abort(404); }
    public function update(Request $r, HelpDesk $h) { abort(404); }
    public function destroy(HelpDesk $helpDesk)
    {
        abort_unless($helpDesk->user_id === auth()->id(), 403);
        $helpDesk->delete();
        return back()->with('success','Ticket deleted.');
    }
}


// ── Provider Profile ──────────────────────────────────────────────────────────
