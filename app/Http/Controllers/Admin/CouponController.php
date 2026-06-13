<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::when($request->search,fn($q)=>$q->where('code','like','%'.$request->search.'%'))
            ->latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'          => 'required|string|unique:coupons|max:20',
            'discount_type' => 'required|in:percent,fixed',
            'discount'      => 'required|numeric|min:0',
            'min_amount'    => 'nullable|numeric|min:0',
            'max_discount'  => 'nullable|numeric|min:0',
            'usage_limit'   => 'nullable|integer|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date',
            'status'        => 'required|in:active,inactive',
        ]);
        Coupon::create($request->all());
        return redirect()->route('admin.coupons.index')->with('success','Coupon created.');
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate(['code'=>'required|string','discount'=>'required|numeric','status'=>'required']);
        $coupon->update($request->all());
        return redirect()->route('admin.coupons.index')->with('success','Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return back()->with('success','Coupon deleted.');
    }
}


// ── Admin Blog ────────────────────────────────────────────────────────────────
