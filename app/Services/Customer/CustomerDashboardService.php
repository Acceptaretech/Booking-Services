<?php

namespace App\Services\Customer;

use App\Models\Booking;

class CustomerDashboardService
{
    public function dashboard($user)
    {
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

        return [
            'stats' => $stats,
            'recent_bookings' => $recentBookings
        ];
    }
}