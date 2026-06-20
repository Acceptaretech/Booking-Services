<?php

namespace App\Http\Controllers\Handyman;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $handyman = Auth::user();

        $bookings = Booking::where('handyman_id', $handyman->id)->get();

        $totalBooking = $bookings->count();
        $completeBooking = $bookings->where('status', 'completed')->count();
        $totalRevenue = $bookings->where('status', 'completed')->sum('total_amount');
        $remainingPayout = $totalRevenue - ($handyman->wallet_amount ?? 0);

        $calendarBookings = Booking::where('handyman_id', $handyman->id)
            ->select('id', 'booking_date', 'status', 'total_amount')
            ->get();

        return view('handyman.dashboard.index', compact(
            'handyman',
            'totalBooking',
            'completeBooking',
            'remainingPayout',
            'totalRevenue',
            'calendarBookings'
        ));
    }
}