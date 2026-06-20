<?php

namespace App\Http\Controllers\Handyman;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['service', 'customer', 'provider'])
            ->where('handyman_id', auth()->id());

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_number', 'like', '%'.$request->search.'%')
                  ->orWhere('status', 'like', '%'.$request->search.'%')
                  ->orWhereHas('service', fn($s) => $s->where('name', 'like', '%'.$request->search.'%'))
                  ->orWhereHas('customer', fn($c) => $c->where('first_name', 'like', '%'.$request->search.'%')
                      ->orWhere('last_name', 'like', '%'.$request->search.'%')
                      ->orWhere('email', 'like', '%'.$request->search.'%'));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        $totalAmount = Booking::where('handyman_id', auth()->id())->sum('total_amount');

        return view('handyman.bookings.index', compact('bookings', 'totalAmount'));
    }

    public function show($id)
    {
        $booking = \App\Models\Booking::with([
            'service',
            'customer',
            'provider',
            'handyman'
        ])
        ->where('handyman_id', auth()->id())
        ->findOrFail($id);

        return view('handyman.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        abort_if($booking->handyman_id != auth()->id(), 403);

        $request->validate([
            'status' => 'required|in:accepted,in_progress,completed,cancelled',
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Booking status updated.');
    }
}