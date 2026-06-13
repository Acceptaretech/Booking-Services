<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['customer','service','provider','handyman'])
            ->when($request->search, fn($q)=>$q->whereHas('customer',fn($c)=>$c->where('first_name','like','%'.$request->search.'%')))
            ->latest()->paginate(15);
        return view('admin.ratings.index', compact('reviews'));
    }
}
