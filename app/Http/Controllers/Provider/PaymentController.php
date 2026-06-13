<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::where('provider_id', auth()->id())
            ->with(['booking.service','booking.customer'])
            ->when($request->search, fn($q) => $q->whereHas('booking',fn($b)=>$b->where('booking_number','like','%'.$request->search.'%')))
            ->latest()->paginate(10);
        return view('provider.payments.index', compact('payments'));
    }

    public function cash(Request $request)
    {
        $payments = Payment::where('provider_id', auth()->id())
            ->where('type','cash')
            ->with(['booking.service','booking.customer'])
            ->latest()->paginate(10);
        return view('provider.payments.cash', compact('payments'));
    }

    public function handymanEarnings(Request $request)
    {
        $earnings = Payment::where('provider_id', auth()->id())
            ->with(['booking.handyman'])
            ->latest()->paginate(10);
        return view('provider.payments.handyman-earnings', compact('earnings'));
    }
}


// ── Withdrawal ────────────────────────────────────────────────────────────────
