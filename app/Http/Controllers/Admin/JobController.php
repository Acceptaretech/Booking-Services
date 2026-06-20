<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
{
    $jobs = \App\Models\Booking::with(['service', 'customer', 'provider', 'handyman'])
        ->when($request->search, function ($query) use ($request) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('payment_status', 'like', "%{$search}%")
                    ->orWhereHas('service', function ($service) use ($search) {
                        $service->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.jobs.index', compact('jobs'));
}

    public function serviceList(Request $request)
    {
        $services = Service::with(['provider', 'category'])
            ->when($request->search, fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.jobs.services', compact('services'));
    }
}