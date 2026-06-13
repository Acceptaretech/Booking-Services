<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index()
    {
        $taxes = Tax::latest()->paginate(10);
        return view('admin.taxes.index', compact('taxes'));
    }

    public function create()  { return view('admin.taxes.create'); }

    public function store(Request $request)
    {
        $request->validate(['title'=>'required','value'=>'required|numeric','type'=>'required|in:percent,fixed','status'=>'required']);
        Tax::create($request->all());
        return redirect()->route('admin.taxes.index')->with('success','Tax added.');
    }

    public function show(Tax $tax)  { return view('admin.taxes.show', compact('tax')); }

    public function edit(Tax $tax)  { return view('admin.taxes.edit', compact('tax')); }

    public function update(Request $request, Tax $tax)
    {
        $request->validate(['title'=>'required','value'=>'required|numeric']);
        $tax->update($request->all());
        return redirect()->route('admin.taxes.index')->with('success','Tax updated.');
    }

    public function destroy(Tax $tax)
    {
        $tax->delete();
        return back()->with('success','Tax deleted.');
    }
}


// ── Admin Job ─────────────────────────────────────────────────────────────────
