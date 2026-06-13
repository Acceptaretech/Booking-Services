<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Payment, User};
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? now()->year;

        $monthlyRevenue = Payment::where('status','paid')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total, SUM(admin_commission) as admin_earn')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->get()
            ->keyBy('month');

        $stats = [
            'total_revenue'    => Payment::where('status','paid')->sum('amount'),
            'total_commission' => Payment::where('status','paid')->sum('admin_commission'),
            'total_bookings'   => Booking::count(),
            'total_providers'  => User::providers()->count(),
        ];

        return view('admin.reports.index', compact('monthlyRevenue','stats','year'));
    }
}


// ── Admin HelpDesk ────────────────────────────────────────────────────────────
