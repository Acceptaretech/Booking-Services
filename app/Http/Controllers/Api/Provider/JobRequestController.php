<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\JobBid;
use App\Models\JobRequest;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobRequest::with(['customer', 'bids.provider'])
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->search.'%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.job-requests.index', compact('jobs'));
    }

    public function show(JobRequest $jobRequest)
    {
        $jobRequest->load(['customer', 'bids.provider']);

        $myBid = JobBid::where('job_request_id', $jobRequest->id)
            ->where('provider_id', auth()->id())
            ->first();

        return view('provider.job-requests.show', compact('jobRequest', 'myBid'));
    }

    public function placeBid(Request $request, JobRequest $jobRequest)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        JobBid::updateOrCreate(
            [
                'job_request_id' => $jobRequest->id,
                'provider_id' => auth()->id(),
            ],
            [
                'price' => $request->price,
                'duration' => $request->duration,
                'notes' => $request->notes,
                'status' => 'pending',
            ]
        );

        return back()->with('success', 'Bid placed successfully.');
    }

    public function destroy(JobRequest $jobRequest)
    {
        $jobRequest->delete();

        return back()->with('success', 'Job request deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:job_requests,id',
        ]);

        if ($request->action === 'delete') {
            JobRequest::whereIn('id', $request->ids)->delete();
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}
