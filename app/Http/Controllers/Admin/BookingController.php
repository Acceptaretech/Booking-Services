<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index(Request $request)
    {
        $query = Booking::with([
            'service',
            'customer',
            'provider',
            'handyman',
            'shop'
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('handyman_id')) {
            $query->where('handyman_id', $request->handyman_id);
        }

        if ($request->filled('date_range')) {

            $dates = explode(' - ', $request->date_range);

            if (count($dates) == 2) {
                $query->whereBetween('booking_date', [
                    trim($dates[0]),
                    trim($dates[1])
                ]);
            }
        }

        if ($request->filled('search')) {
            $query->where('booking_number', 'like', '%' . $request->search . '%');
        }

        $totalAmount = (clone $query)->sum('total_amount');

        $bookings = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $services = Service::where('status', 'active')
            ->pluck('name', 'id');

        $customers = User::where('role', 'customer')
            ->pluck('email', 'id');

        $handymen = User::where('role', 'handyman')
            ->pluck('email', 'id');

        return view('admin.bookings.index', compact(
            'bookings',
            'totalAmount',
            'services',
            'customers',
            'handymen'
        ));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'service',
            'customer',
            'provider',
            'handyman',
            'shop',
            'statusLogs.changedBy',
            'payment',
            'review',
            'coupon'
        ]);

        $zoneId = $booking->provider->zone_id ?? null;

        $handymen = User::where('role', 'handyman')
            ->when($zoneId, function ($query) use ($zoneId) {
                $query->where('zone_id', $zoneId);
            })
            ->get();

        return view('admin.bookings.show', compact(
            'booking',
            'handymen'
        ));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $this->bookingService->updateStatus(
            $booking,
            $request->status,
            auth()->id(),
            $request->notes
        );

        return back()->with(
            'success',
            'Booking status updated successfully.'
        );
    }

    public function assignHandyman(Request $request, Booking $booking)
    {
        $request->validate([
            'handyman_id' => 'required|exists:users,id'
        ]);

        $booking->update([
            'handyman_id' => $request->handyman_id,
            'status' => 'assigned'
        ]);

        return back()->with(
            'success',
            'Handyman assigned successfully.'
        );
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with(
                'success',
                'Booking deleted successfully.'
            );
    }

    public function export(Request $request)
    {
        $bookings = Booking::with([
            'service',
            'customer',
            'provider'
        ])->get();

        $columns = $request->columns ?? [
            'id',
            'booking_number',
            'status',
            'total_amount'
        ];

        return response()->json([
            'success' => true,
            'columns' => $columns,
            'data' => $bookings
        ]);
    }
}