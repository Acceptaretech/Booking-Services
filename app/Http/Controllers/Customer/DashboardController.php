<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     $totalBookings = Booking::where('customer_id', $user->id)->count();

    //     $pendingBookings = Booking::where('customer_id', $user->id)
    //         ->where('status', 'pending')
    //         ->count();

    //     $completedBookings = Booking::where('customer_id', $user->id)
    //         ->where('status', 'completed')
    //         ->count();

    //     $cancelledBookings = Booking::where('customer_id', $user->id)
    //         ->where('status', 'cancelled')
    //         ->count();

    //     $recentBookings = Booking::where('customer_id', $user->id)
    //         ->latest()
    //         ->take(5)
    //         ->get();

    //     $services = Service::where('status', 'active')
    //         ->latest()
    //         ->take(6)
    //         ->get();

    //     return view('customer.dashboard', compact(
    //         'user',
    //         'totalBookings',
    //         'pendingBookings',
    //         'completedBookings',
    //         'cancelledBookings',
    //         'recentBookings',
    //         'services'
    //     ));
    // }
    public function index()
    {
        $user = auth()->user();

        $customerColumn = 'customer_id';

        $stats = [
            'total_bookings' => Booking::where($customerColumn, $user->id)->count(),

            'pending_bookings' => Booking::where($customerColumn, $user->id)
                ->where('status', 'pending')
                ->count(),

            'completed_bookings' => Booking::where($customerColumn, $user->id)
                ->where('status', 'completed')
                ->count(),

            'cancelled_bookings' => Booking::where($customerColumn, $user->id)
                ->where('status', 'cancelled')
                ->count(),
        ];

        $recentBookings = Booking::with(['service', 'provider'])
            ->where($customerColumn, $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('customer.dashboard', compact('stats', 'recentBookings'));
    }
}