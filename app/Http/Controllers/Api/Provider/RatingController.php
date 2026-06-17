<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::where('provider_id', auth()->id())
            ->with(['customer','service','handyman'])
            ->when($request->search, fn($q) => $q->whereHas('customer',fn($c)=>$c->where('first_name','like','%'.$request->search.'%')))
            ->latest()->paginate(10);
        return view('provider.ratings.index', compact('reviews'));
    }
}


// ── Promotional Banner ────────────────────────────────────────────────────────
