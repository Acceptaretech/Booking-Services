<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpDesk;
use Illuminate\Http\Request;

class HelpDeskController extends Controller
{
    public function index(Request $request)
    {
        $tickets = HelpDesk::with('user')
            ->when($request->status, fn($q,$s)=>$q->where('status',$s))
            ->when($request->role,   fn($q,$r)=>$q->where('role',$r))
            ->latest()->paginate(15);
        return view('admin.help-desk.index', compact('tickets'));
    }

    public function show(HelpDesk $helpDesk)
    {
        $helpDesk->load('user');
        return view('admin.help-desk.show', compact('helpDesk'));
    }

    public function create() { return view('admin.help-desk.create'); }

    public function store(Request $request)
    {
        $request->validate(['subject'=>'required','description'=>'required']);
        HelpDesk::create($request->all() + ['user_id'=>auth()->id(),'role'=>'admin']);
        return redirect()->route('admin.help-desk.index')->with('success','Ticket created.');
    }

    public function edit(HelpDesk $helpDesk)  { return view('admin.help-desk.edit', compact('helpDesk')); }

    public function update(Request $request, HelpDesk $helpDesk)
    {
        $helpDesk->update($request->only('status','subject','description'));
        return redirect()->route('admin.help-desk.index')->with('success','Ticket updated.');
    }

    public function destroy(HelpDesk $helpDesk)
    {
        $helpDesk->delete();
        return back()->with('success','Ticket deleted.');
    }
}


// ── Admin Rating ──────────────────────────────────────────────────────────────
