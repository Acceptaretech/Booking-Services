<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Category, CommissionSetting, Coupon, Payment, Service, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_services'   => Service::count(),
            'total_bookings'   => Booking::count(),
            'total_revenue'    => Payment::where('status','paid')->sum('amount'),
            'total_providers'  => User::providers()->count(),
            'total_customers'  => User::customers()->count(),
            // 'total_handymen'   => User::handymen()->count(),
            'pending_bookings' => Booking::where('status','pending')->count(),
            'my_earning'       => Payment::where('status','paid')->sum('admin_commission'),
            'total_providers'  => User::providers()->count(),
            'total_customers'  => User::customers()->count(),
            // 'total_handymen'   => User::handymen()->count(),
            'pending_bookings' => Booking::pending()->count(),
        ];

        $monthlyRevenue = Payment::where('status','paid')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total','month')
            ->toArray();

        $revenueData = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueData[] = $monthlyRevenue[$m] ?? 0;
        }

        $recentProviders = User::providers()->with('commissionSetting')->withAvg('reviews','rating')->latest()->take(5)->get();
        $recentCustomers = User::customers()->withCount('customerBookings')->latest()->take(5)->get();
        $recentBookings  = Booking::with(['service','customer','provider'])
                            ->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats','revenueData','recentProviders','recentCustomers','recentBookings'
        ));
    }
}

// ── Bookings ─────────────────────────────────────────────────────────────────
