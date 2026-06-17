<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index(Request $request)
    {
        $query = Booking::with([
            'service',
            'customer',
            'handyman',
            'shop',
        ])->where('provider_id', auth()->id());

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

        if ($request->filled('handyman_id')) {
            $query->where('handyman_id', $request->handyman_id);
        }

        if ($request->filled('date_range')) {
            [$from, $to] = explode(' - ', $request->date_range);

            $query->whereBetween('booking_date', [
                trim($from),
                trim($to),
            ]);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('booking_number', 'like', '%'.$request->search.'%')
                    ->orWhere('id', 'like', '%'.$request->search.'%');
            });
        }

        $bookings = $query->latest()->paginate(10);

        $totalAmount = Booking::where('provider_id', auth()->id())
            ->sum('total_amount');

        $services = Service::where('user_id', auth()->id())
            ->pluck('name', 'id');

        $handymen = User::where('role', 'handyman')
            ->pluck('email', 'id');

        return view(
            'provider.bookings.index',
            compact(
                'bookings',
                'totalAmount',
                'services',
                'handymen'
            )
        );
    }

    public function show(Booking $booking)
    {
        abort_unless(
            $booking->provider_id === auth()->id(),
            403
        );

        $booking->load([
            'service',
            'customer',
            'handyman',
            'statusLogs.changedBy',
            'payment',
            'review',
        ]);

        $handymen = User::where('role', 'handyman')->get();

        return view(
            'provider.bookings.show',
            compact(
                'booking',
                'handymen'
            )
        );
    }

    public function updateStatus(
        Request $request,
        Booking $booking
    ) {
        abort_unless(
            $booking->provider_id === auth()->id(),
            403
        );

        $request->validate([
            'status' => 'required|string',
        ]);

        $this->bookingService->updateStatus(
            $booking,
            $request->status,
            auth()->id(),
            $request->notes
        );

        return back()->with(
            'success',
            'Status updated successfully.'
        );
    }

    public function assignHandyman(
        Request $request,
        Booking $booking
    ) {
        abort_unless(
            $booking->provider_id === auth()->id(),
            403
        );

        $request->validate([
            'handyman_id' => 'required|exists:users,id',
        ]);

        $booking->update([
            'handyman_id' => $request->handyman_id,
            'status' => 'assigned',
        ]);

        return back()->with(
            'success',
            'Handyman assigned successfully.'
        );
    }

    public function destroy(Booking $booking)
    {
        abort_unless(
            $booking->provider_id === auth()->id(),
            403
        );

        $booking->delete();

        return back()->with(
            'success',
            'Booking deleted successfully.'
        );
    }
}
