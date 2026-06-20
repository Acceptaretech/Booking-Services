@extends('layouts.public.app')

@section('title','My Wallet')

@section('content')
<div class="min-h-screen bg-[#eef8ff] py-6 md:py-10">
    <div class="max-w-[1400px] mx-auto px-4 flex flex-col lg:flex-row gap-6 lg:gap-8">

        @include('customer.partials.sidebar')

        <div class="flex-1 w-full">

            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div id="walletAlert" class="hidden mb-4 px-4 py-3 rounded-xl"></div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5 mb-6 lg:mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-black">
                    My Wallet :
                    <span class="text-green-500">₹{{ number_format($walletBalance, 0) }}</span>
                </h1>

                <button type="button"
                        onclick="openWalletModal()"
                        class="text-pink-500 text-xl sm:text-2xl lg:text-3xl font-medium text-left sm:text-right">
                    + Add Balance
                </button>
            </div>

            <div class="bg-white rounded-[22px] lg:rounded-[26px] shadow-sm p-4 sm:p-6 lg:p-8">

                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5 mb-7">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-black">
                        Transactions
                    </h2>

                    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <label class="text-gray-500">Date</label>

                        <input type="date"
                               name="date"
                               value="{{ request('date') }}"
                               class="w-full sm:w-auto border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500">

                        <button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl">
                            Filter
                        </button>
                    </form>
                </div>

                <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

                    <div class="flex items-center gap-2">
                        <span>Show</span>

                        <select name="entries"
                                onchange="this.form.submit()"
                                class="border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500">
                            <option value="10" {{ request('entries', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                        </select>

                        <span>entries</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="whitespace-nowrap">Search :</label>

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search"
                               class="w-full md:w-[260px] border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500">
                    </div>

                    @if(request('search') || request('date'))
                        <a href="{{ route('customer.wallet') }}"
                           class="text-sm text-red-500 font-medium">
                            Clear Filter
                        </a>
                    @endif
                </form>

                <div class="overflow-x-auto rounded-xl">
                    <table class="w-full min-w-[850px]">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left p-4 lg:p-5 font-bold">Amount</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Type</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Description</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Reference ID</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-4 lg:p-5 font-semibold">
                                        ₹{{ number_format($transaction->amount, 2) }}
                                    </td>

                                    <td class="p-4 lg:p-5">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            {{ $transaction->type == 'credit'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>

                                    <td class="p-4 lg:p-5">
                                        {{ $transaction->description ?? '-' }}
                                    </td>

                                    <td class="p-4 lg:p-5">
                                        {{ $transaction->reference_id ?? '-' }}
                                    </td>

                                    <td class="p-4 lg:p-5 whitespace-nowrap">
                                        {{ $transaction->created_at->format('d-m-Y h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-16 text-gray-400">
                                        No Records Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<div id="addBalanceModal"
     class="hidden fixed inset-0 bg-black/40 px-4 flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-5 sm:p-8 w-full max-w-[420px] shadow-xl">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-2xl font-bold">Add Balance</h2>

            <button type="button"
                    onclick="closeWalletModal()"
                    class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200">
                ✕
            </button>
        </div>

        <form id="walletTopupForm">
            @csrf

            <input type="number"
                   id="walletAmount"
                   name="amount"
                   min="1"
                   max="100000"
                   placeholder="Enter Amount"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 mb-2 outline-none focus:border-blue-500"
                   required>

            <p id="amountError" class="hidden text-red-500 text-sm mb-3"></p>

            <div class="flex flex-col sm:flex-row gap-3 mt-5">
                <button type="button"
                        onclick="closeWalletModal()"
                        class="w-full bg-gray-200 hover:bg-gray-300 py-3 rounded-xl">
                    Cancel
                </button>

                <button type="submit"
                        id="payBtn"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">
                    Pay Now
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    function openWalletModal() {
        document.getElementById('addBalanceModal').classList.remove('hidden');
    }

    function closeWalletModal() {
        document.getElementById('addBalanceModal').classList.add('hidden');
    }

    function showWalletAlert(message, type = 'success') {
        const alertBox = document.getElementById('walletAlert');

        alertBox.classList.remove('hidden', 'bg-green-100', 'text-green-700', 'bg-red-100', 'text-red-700');

        if (type === 'success') {
            alertBox.classList.add('bg-green-100', 'text-green-700');
        } else {
            alertBox.classList.add('bg-red-100', 'text-red-700');
        }

        alertBox.innerText = message;
    }

    document.getElementById('walletTopupForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const amountInput = document.getElementById('walletAmount');
        const amountError = document.getElementById('amountError');
        const payBtn = document.getElementById('payBtn');

        const amount = amountInput.value;

        amountError.classList.add('hidden');
        amountError.innerText = '';

        if (!amount || amount < 1) {
            amountError.innerText = 'Please enter a valid amount.';
            amountError.classList.remove('hidden');
            return;
        }

        payBtn.disabled = true;
        payBtn.innerText = 'Processing...';

        fetch("{{ route('customer.wallet.create-order') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                amount: amount
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Unable to create payment order.');
            }

            const options = {
                key: data.key,
                amount: data.amount,
                currency: data.currency,
                name: data.name || "Wallet Top-up",
                description: "Add money to wallet",
                order_id: data.order_id,

                prefill: {
                    name: data.customer_name || "",
                    email: data.customer_email || "",
                    contact: data.customer_phone || ""
                },

                handler: function (response) {
                    fetch("{{ route('customer.wallet.payment-success') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            amount: amount
                        })
                    })
                    .then(res => res.json())
                    .then(result => {
                        if (result.success) {
                            closeWalletModal();
                            showWalletAlert('Balance added successfully.', 'success');
                            setTimeout(() => {
                                window.location.reload();
                            }, 1000);
                        } else {
                            showWalletAlert(result.message || 'Payment verification failed.', 'error');
                            payBtn.disabled = false;
                            payBtn.innerText = 'Pay Now';
                        }
                    })
                    .catch(() => {
                        showWalletAlert('Something went wrong while verifying payment.', 'error');
                        payBtn.disabled = false;
                        payBtn.innerText = 'Pay Now';
                    });
                },

                modal: {
                    ondismiss: function () {
                        payBtn.disabled = false;
                        payBtn.innerText = 'Pay Now';
                    }
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        })
        .catch(error => {
            amountError.innerText = error.message;
            amountError.classList.remove('hidden');
            payBtn.disabled = false;
            payBtn.innerText = 'Pay Now';
        });
    });
</script>

@endsection