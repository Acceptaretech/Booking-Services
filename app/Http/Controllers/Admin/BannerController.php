<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionalBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $banners = PromotionalBanner::with('user')
            ->when($request->status, fn($q,$s)=>$q->where('status',$s))
            ->latest()->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function approve(PromotionalBanner $b)
    {
        $b->update(['status'=>'accepted']);
        return back()->with('success','Banner approved.');
    }

    public function reject(Request $request, PromotionalBanner $b)
    {
        $b->update(['status'=>'rejected','reason'=>$request->reason]);
        return back()->with('success','Banner rejected.');
    }
}


// ── Admin Report ──────────────────────────────────────────────────────────────
