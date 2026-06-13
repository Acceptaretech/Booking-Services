<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Booking;
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

    public function index()
    {
        $bookings = Booking::with(['service', 'provider'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.bookings.index', compact('bookings'));
    }
}