<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\{Payment, WithdrawalRequest};
// use Illuminate\Http\Request;

// class PaymentController extends Controller
// {
//     public function index(Request $request)
//     {
//         $payments = Payment::with(['booking.service','booking.customer','booking.provider'])
//             ->when($request->search, fn($q) => $q->whereHas('booking',fn($b)=>$b->where('booking_number','like','%'.$request->search.'%')))
//             ->when($request->status, fn($q,$s) => $q->where('status',$s))
//             ->latest()->paginate(15);
//         return view('admin.payments.index', compact('payments'));
//     }

//     public function withdrawals(Request $request)
//     {
//         $withdrawals = WithdrawalRequest::with('user')
//             ->when($request->status, fn($q,$s) => $q->where('status',$s))
//             ->latest()->paginate(15);
//         return view('admin.payments.withdrawals', compact('withdrawals'));
//     }

//     public function approveWithdrawal(WithdrawalRequest $wr)
//     {
//         $user = $wr->user;
//         if ($user->wallet_amount < $wr->amount) {
//             return back()->withErrors(['error'=>'Insufficient wallet balance.']);
//         }
//         $user->decrement('wallet_amount', $wr->amount);
//         \App\Models\WalletTransaction::create([
//             'user_id'     => $user->id,
//             'amount'      => $wr->amount,
//             'type'        => 'debit',
//             'description' => 'Withdrawal approved',
//             'reference_id'=> $wr->id,
//         ]);
//         $wr->update(['status'=>'approved']);
//         return back()->with('success','Withdrawal approved.');
//     }
// }


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['booking.service', 'customer', 'provider', 'handyman'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('transaction_id', 'like', '%' . $request->search . '%')
                  ->orWhere('booking_id', 'like', '%' . $request->search . '%');
            });
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.service', 'customer', 'provider', 'handyman']);

        return view('admin.payments.show', compact('payment'));
    }
}

// ── Admin Coupon ──────────────────────────────────────────────────────────────
