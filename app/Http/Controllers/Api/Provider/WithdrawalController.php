<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $requests = WithdrawalRequest::where('user_id', auth()->id())->latest()->paginate(10);
        return view('provider.withdrawals.index', compact('requests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name'      => 'required|string',
            'account_number' => 'required|string',
            'ifsc_code'      => 'nullable|string',
            'amount'         => 'required|numeric|min:1|max:'.auth()->user()->wallet_amount,
            'payment_type'   => 'required|in:bank,paypal,other',
        ]);

        if (auth()->user()->wallet_amount < $request->amount) {
            return back()->withErrors(['amount'=>'Insufficient wallet balance.']);
        }

        WithdrawalRequest::create([
            'user_id'        => auth()->id(),
            'bank_name'      => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc_code'      => $request->ifsc_code,
            'amount'         => $request->amount,
            'payment_type'   => $request->payment_type,
            'status'         => 'pending',
        ]);

        return back()->with('success','Withdrawal request submitted.');
    }
}


// ── Rating ────────────────────────────────────────────────────────────────────
