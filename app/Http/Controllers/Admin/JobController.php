<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{JobRequest, Service};
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobRequest::with(['customer','bids.provider'])
            ->when($request->search, fn($q)=>$q->where('title','like','%'.$request->search.'%'))
            ->latest()->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function serviceList(Request $request)
    {
        $services = Service::with(['provider','category'])
            ->when($request->search, fn($q)=>$q->where('name','like','%'.$request->search.'%'))
            ->latest()->paginate(15);
        return view('admin.jobs.services', compact('services'));
    }
}


// ── Admin Banner ──────────────────────────────────────────────────────────────
