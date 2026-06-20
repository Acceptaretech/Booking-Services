<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create($serviceId)
    {
        $service = Service::findOrFail($serviceId);

        return view('customer.bookings.create', compact('service'));
    }

    public function store(Request $request, $serviceId)
    {
        $service = Service::findOrFail($serviceId);

        $request->validate([
            'booking_date' => 'required|date',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string',
        ]);

        $basePrice = $service->price ?? 0;
        $discount = $service->discount ?? 0;
        $totalAmount = $basePrice - $discount;

        Booking::create([
            'booking_number' => 'BK-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
            'customer_id' => auth()->id(),
            'service_id' => $service->id,
            'provider_id' => $service->user_id ?? null,
            'booking_date' => $request->booking_date,
            'address' => $request->address,
            'note' => $request->note,
            'base_price' => $basePrice,
            'discount' => $discount,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('customer.dashboard')
            ->with('success', 'Booking created successfully.');
    }

    public function index(Request $request)
    {
        $query = Booking::with(['service', 'provider', 'review'])
            ->where('customer_id', auth()->id());
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        $bookings = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    
        return view('customer.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        abort_if($booking->customer_id != auth()->id(), 403);

        $booking->load([
            'service.category',
            'provider',
            'handyman',
            'statusLogs.changedBy',
            'review'
        ]);

        return view('customer.bookings.show', compact('booking'));
    }

    public function review(Request $request, Booking $booking)
    {
        abort_if($booking->customer_id != auth()->id(), 403);

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can review only completed bookings.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            [
                'booking_id' => $booking->id,
            ],
            [
                'service_id' => $booking->service_id,
                'provider_id' => $booking->provider_id,
                'customer_id' => auth()->id(),
                'rating' => $request->rating,
                'review' => $request->review,
            ]
        );

        return back()->with('success', 'Review submitted successfully.');
    }
    public function addReview(Request $request, \App\Models\Booking $booking)
    {
        abort_if($booking->customer_id != auth()->id(), 403);

        if ($booking->status !== 'completed') {
            return back()->with('error', 'Review can be added only after booking is completed.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        \App\Models\Review::updateOrCreate(
            [
                'booking_id' => $booking->id,
                'customer_id' => auth()->id(),
            ],
            [
                'service_id'  => $booking->service_id,
                'provider_id' => $booking->provider_id,
                'handyman_id' => $booking->handyman_id,
                'rating'      => $request->rating,
                'review'      => $request->review,
                'status'      => 'active',
            ]
        );

        return back()->with('success', 'Review submitted successfully.');
    }
}