<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\{JobBid, JobRequest};
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobRequest::with(['customer','bids'])
            ->when($request->search, fn($q) => $q->where('title','like','%'.$request->search.'%'))
            ->latest()->paginate(10);
        return view('provider.jobs.index', compact('jobs'));
    }

    public function show(JobRequest $jobRequest)
    {
        $jobRequest->load(['customer','bids.provider']);
        $myBid = JobBid::where('job_request_id',$jobRequest->id)
                       ->where('provider_id',auth()->id())->first();
        return view('provider.jobs.show', compact('jobRequest','myBid'));
    }

    public function placeBid(Request $request, JobRequest $jobRequest)
    {
        $request->validate([
            'price'    => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'notes'    => 'nullable|string',
        ]);
        JobBid::updateOrCreate(
            ['job_request_id'=>$jobRequest->id,'provider_id'=>auth()->id()],
            ['price'=>$request->price,'duration'=>$request->duration,'notes'=>$request->notes,'status'=>'pending']
        );
        return back()->with('success','Bid placed.');
    }
}
