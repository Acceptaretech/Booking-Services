<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $query = WalletTransaction::where('user_id', auth()->id());

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('amount', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('reference_id', 'like', "%{$search}%");
            });
        }

        $perPage = $request->entries ?? 10;

        $transactions = $query->latest()->paginate($perPage)->withQueryString();

        $credit = WalletTransaction::where('user_id', auth()->id())
            ->where('type', 'credit')
            ->sum('amount');

        $debit = WalletTransaction::where('user_id', auth()->id())
            ->where('type', 'debit')
            ->sum('amount');

        $walletBalance = $credit - $debit;

        return view('customer.wallet.index', compact('transactions', 'walletBalance'));
    }

    public function addBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        WalletTransaction::create([
            'user_id'      => auth()->id(),
            'amount'       => $request->amount,
            'type'         => 'credit',
            'description'  => 'Wallet balance added',
            'reference_id' => 'WALLET-' . time(),
        ]);

        return back()->with('success', 'Balance added successfully.');
    }
}