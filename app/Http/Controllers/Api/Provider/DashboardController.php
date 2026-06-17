<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $provider = Auth::user();

        $stats = [
            'total_bookings' => Booking::where('provider_id', $provider->id)->count(),
            'total_services' => Service::where('user_id', $provider->id)->count(),
            'remaining_payout' => $provider->wallet_amount ?? 0,
            'total_revenue' => Payment::where('provider_id', $provider->id)
                ->where('status', 'paid')
                ->sum('provider_earning'),
        ];

        $monthlyRevenue = Payment::where('provider_id', $provider->id)
            ->where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(provider_earning) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $revenueData = [];

        for ($m = 1; $m <= 12; $m++) {
            $revenueData[] = $monthlyRevenue[$m] ?? 0;
        }

        // Top Handymen
        $topHandymen = User::where('role', 'handyman')
            ->latest()
            ->take(5)
            ->get();

        // Recent Bookings
        $recentBookings = Booking::with(['service', 'customer'])
            ->where('provider_id', $provider->id)
            ->latest()
            ->take(5)
            ->get();

        $commissionSetting = $provider->commissionSetting;

        return view('provider.dashboard', compact(
            'stats',
            'revenueData',
            'topHandymen',
            'recentBookings',
            'commissionSetting',
            'provider'
        ));
    }
}
