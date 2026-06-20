<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class JobRequestController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Booking::with(['service', 'customer', 'provider', 'handyman'])
            ->where('provider_id', auth()->id())
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('booking_number', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('payment_status', 'like', "%{$search}%")
                        ->orWhereHas('service', function ($service) use ($search) {
                            $service->where('name', 'like', "%{$search}%")
                                ->orWhere('title', 'like', "%{$search}%");
                        })
                        ->orWhereHas('customer', function ($customer) use ($search) {
                            $customer->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('provider.job-requests.index', compact('jobs'));
    }

    public function show(Booking $jobRequest)
    {
       
        abort_if($jobRequest->provider_id != auth()->id(), 403);
    
        $jobRequest->load(['service', 'customer', 'provider', 'handyman']);
    
        $serviceCategoryId = (int) ($jobRequest->service->category_id ?? 0);
    
        $handymen = \App\Models\User::where('role', 'handyman')
            ->where('provider_id', (int) $jobRequest->provider_id)
            ->where('status', 'active')
            ->where('category_id', $serviceCategoryId)
            ->latest()
            ->get();
    
        return view('provider.job-requests.show', compact('jobRequest', 'handymen'));
    }
    public function assignTechnician(Request $request, Booking $booking)
{
    $request->validate([
        'handyman_id' => 'required|exists:users,id',
    ]);

    $handyman = \App\Models\User::where('id', $request->handyman_id)
        ->where('role', 'handyman')
        ->where('provider_id', auth()->id())
        ->where('status', 'active')
        ->firstOrFail();

    $booking->update([
        'handyman_id' => $handyman->id,
        'status' => 'assigned',
    ]);

    return back()->with('success', 'Technician assigned successfully.');
}
public function autoAssign()
{
    $providerId = auth()->id();

    $bookings = \App\Models\Booking::where('provider_id', $providerId)
        ->whereNull('handyman_id')
        ->whereIn('status', ['pending', 'accepted'])
        ->get();

    $handymen = \App\Models\User::where('role', 'handyman')
        ->where('provider_id', $providerId)
        ->where('status', 'active')
        ->get();

    if ($handymen->count() == 0) {
        return back()->with('error', 'No active technicians available.');
    }

    $index = 0;

    foreach ($bookings as $booking) {

        $handyman = $handymen[$index % $handymen->count()];

        $booking->update([
            'handyman_id' => $handyman->id,
            'status' => 'assigned',
        ]);

        $index++;
    }

    return back()->with(
        'success',
        $bookings->count().' bookings auto assigned successfully.'
    );
}

    public function destroy(Booking $jobRequest)
    {
        abort_if($jobRequest->provider_id != auth()->id(), 403);

        $jobRequest->delete();

        return back()->with('success', 'Booking deleted successfully.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:bookings,id',
        ]);

        if ($request->action === 'delete') {
            Booking::where('provider_id', auth()->id())
                ->whereIn('id', $request->ids)
                ->delete();
        }

        return back()->with('success', 'Bulk action applied successfully.');
    }
}