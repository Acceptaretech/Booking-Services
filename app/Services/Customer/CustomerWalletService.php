<?php

namespace App\Services\Customer;

use App\Models\WalletTransaction;
use App\Services\Interfaces\CustomerWalletServiceInterface;
use Illuminate\Http\Request;
use Exception;

class CustomerWalletService implements CustomerWalletServiceInterface
{
    public function index($user, Request $request)
    {
        try {
            $query = WalletTransaction::where('user_id', $user->id);

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

            $transactions = $query->latest()->paginate($perPage);

            $credit = WalletTransaction::where('user_id', $user->id)
                ->where('type', 'credit')
                ->sum('amount');

            $debit = WalletTransaction::where('user_id', $user->id)
                ->where('type', 'debit')
                ->sum('amount');

            return [
                'wallet_balance' => $credit - $debit,
                'total_credit' => $credit,
                'total_debit' => $debit,
                'transactions' => $transactions,
            ];

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function addBalance($user, Request $request)
    {
        try {
            $data = $request->validate([
                'amount' => 'required|numeric|min:1',
            ]);

            return WalletTransaction::create([
                'user_id'      => $user->id,
                'amount'       => $data['amount'],
                'type'         => 'credit',
                'description'  => 'Wallet balance added',
                'reference_id' => 'WALLET-' . time(),
            ]);

        } catch (Exception $e) {
            throw $e;
        }
    }
}