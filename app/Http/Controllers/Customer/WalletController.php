<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class WalletController extends Controller
{
    private function getRazorpayConfig()
    {
        $key = SystemConfig::where('key', 'razorpay_key')->value('value');
        $secret = SystemConfig::where('key', 'razorpay_secret')->value('value');

        if (!$key || !$secret) {
            throw new \Exception('Razorpay key or secret is missing.');
        }

        return [
            'key' => $key,
            'secret' => $secret,
        ];
    }
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

        $perPage = in_array((int) $request->entries, [10, 25, 50, 100])
            ? (int) $request->entries
            : 10;

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

    // private function getRazorpayConfig()
    // {
    //     $config = PaymentRequest::where('payment_method', 'razor_pay')
    //         ->where('is_active', 1)
    //         ->first();

    //     if (!$config) {
    //         throw new \Exception('Razorpay payment method is not configured.');
    //     }

    //     $values = $config->mode === 'live'
    //         ? json_decode($config->live_values)
    //         : json_decode($config->test_values);

    //     if (!$values || empty($values->api_key) || empty($values->api_secret)) {
    //         throw new \Exception('Razorpay API key or secret is missing.');
    //     }

    //     return $values;
    // }

    public function createRazorpayOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:100000',
        ]);

        try {
            $razor = $this->getRazorpayConfig();

            $amount = round($request->amount, 2);
            $amountInPaise = (int) ($amount * 100);

            $razor = $this->getRazorpayConfig();

            $api = new \Razorpay\Api\Api(
                $razor['key'],
                $razor['secret']
            );

            $order = $api->order->create([
                'receipt' => 'wallet_' . auth()->id() . '_' . time(),
                'amount' => $amountInPaise,
                'currency' => 'INR',
            ]);

            return response()->json([
                'success' => true,
                'key' => $razor->api_key,
                'order_id' => $order['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'name' => config('app.name', 'HandyMan'),
                'customer_name' => auth()->user()->name ?? trim((auth()->user()->first_name ?? '') . ' ' . (auth()->user()->last_name ?? '')),
                'customer_email' => auth()->user()->email,
                'customer_phone' => auth()->user()->phone,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'amount' => 'required|numeric|min:1|max:100000',
        ]);

        try {
            $razor = $this->getRazorpayConfig();

            $razor = $this->getRazorpayConfig();

            $api = new \Razorpay\Api\Api(
                $razor['key'],
                $razor['secret']
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            DB::transaction(function () use ($request) {
                $exists = WalletTransaction::where('reference_id', $request->razorpay_payment_id)->exists();

                if (!$exists) {
                    WalletTransaction::create([
                        'user_id' => auth()->id(),
                        'amount' => round($request->amount, 2),
                        'type' => 'credit',
                        'description' => 'Wallet top-up via Razorpay',
                        'reference_id' => $request->razorpay_payment_id,
                    ]);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Wallet balance added successfully.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 422);
        }
    }
}