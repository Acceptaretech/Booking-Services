<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\PromotionalBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromotionalBannerController extends Controller
{
    public function index()
    {
        $banners = PromotionalBanner::where('user_id', auth()->id())->latest()->paginate(10);
        return view('provider.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('provider.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image'          => 'required|image|max:4096',
            'short_description'=> 'nullable|string|max:500',
            'start_date'     => 'required|date|after_or_equal:today',
            'end_date'       => 'required|date|after:start_date',
            'per_day_charge' => 'required|numeric|min:0',
            'select_type'    => 'required|in:featured,banner,both',
            'payment_method' => 'required|in:online,wallet',
        ]);

        $data['image']         = $request->file('image')->store('banners','public');
        $data['user_id']       = auth()->id();
        $data['duration_days'] = \Carbon\Carbon::parse($data['start_date'])
                                    ->diffInDays($data['end_date']);
        $data['total_amount']  = $data['duration_days'] * $data['per_day_charge'];
        $data['status']        = 'pending';

        PromotionalBanner::create($data);
        return redirect()->route('provider.banners.index')->with('success','Banner request submitted.');
    }

    public function show(PromotionalBanner $banner)
    {
        abort_unless($banner->user_id === auth()->id(), 403);
        return view('provider.banners.show', compact('banner'));
    }

    public function destroy(PromotionalBanner $banner)
    {
        abort_unless($banner->user_id === auth()->id(), 403);
        Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return back()->with('success','Banner deleted.');
    }

    public function edit(PromotionalBanner $banner)   { abort(404); }
    public function update(Request $r, PromotionalBanner $b) { abort(404); }
}


// ── Help Desk ─────────────────────────────────────────────────────────────────
