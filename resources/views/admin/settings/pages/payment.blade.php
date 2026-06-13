@extends('layouts.admin.app')

@section('title', 'Payment Configuration')

@section('content')

@php
$getConfig = fn($key, $default = null) => $configs->get($key)?->value ?? $default;

$gateways = [
    'cash_on_delivery' => 'CASH ON DELIVERY',
    'stripe'           => 'STRIPE',
    'razorpay'         => 'RAZORPAY',
    'flutterwave'      => 'FLUTTERWAVE',
    'paypal'           => 'PAYPAL',
    'cinet'            => 'CINET',
    'sadad'            => 'SADAD',
    'airtel_money'     => 'AIRTEL MONEY',
    'paystack'         => 'PAYSTACK',
    'phonepe'          => 'PHONEPE',
    'midtrans'         => 'MIDTRANS',
];

$activeGateway = request('gateway', 'stripe');
@endphp

<div class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-6">

            {{-- Gateway Tabs --}}
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-10">

                @foreach($gateways as $key => $label)
                    <a href="{{ route('admin.settings.payment', ['gateway' => $key]) }}"
                       class="text-center px-5 py-3 rounded-md text-sm font-medium transition
                       {{ $activeGateway === $key ? 'bg-[#5B5FC7] text-white' : 'bg-[#F0F0FA] text-[#5B5FC7]' }}">
                        {{ $label }}
                    </a>
                @endforeach

            </div>

            <form method="POST"
                  action="{{ route('admin.settings.payment.update') }}">

                @csrf

                <input type="hidden"
                       name="gateway"
                       value="{{ $activeGateway }}">

                {{-- Enable Payment --}}
                <div class="border rounded-md px-5 py-4 flex items-center justify-between mb-5">

                    <span class="font-medium">
                        Enable {{ ucfirst(str_replace('_', ' ', $activeGateway)) }} payment
                    </span>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden"
                               name="{{ $activeGateway }}_status"
                               value="0">

                        <input type="checkbox"
                               name="{{ $activeGateway }}_status"
                               value="1"
                               class="sr-only peer"
                               {{ $getConfig($activeGateway.'_status', '1') == '1' ? 'checked' : '' }}>

                        <div class="w-11 h-6 bg-gray-300 rounded-full peer
                                    peer-checked:bg-[#5B5FC7]
                                    after:content-['']
                                    after:absolute
                                    after:top-[2px]
                                    after:left-[2px]
                                    after:bg-white
                                    after:border-gray-300
                                    after:border
                                    after:rounded-full
                                    after:h-5
                                    after:w-5
                                    after:transition-all
                                    peer-checked:after:translate-x-full">
                        </div>
                    </label>

                </div>

                {{-- Option --}}
                <div class="mb-6">
                    <label class="block mb-3 font-medium">
                        {{ ucfirst(str_replace('_', ' ', $activeGateway)) }} option
                    </label>

                    <div class="flex items-center gap-8">

                        <label class="flex items-center gap-2">
                            <input type="radio"
                                   name="{{ $activeGateway }}_credential_type"
                                   value="test"
                                   {{ $getConfig($activeGateway.'_credential_type', 'test') == 'test' ? 'checked' : '' }}>
                            Test credential
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio"
                                   name="{{ $activeGateway }}_credential_type"
                                   value="live"
                                   {{ $getConfig($activeGateway.'_credential_type') == 'live' ? 'checked' : '' }}>
                            Live credential
                        </label>

                    </div>
                </div>

                {{-- Gateway Name --}}
                <div class="mb-6">
                    <label class="block mb-2 font-medium">
                        Gateway Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="{{ $activeGateway }}_gateway_name"
                           value="{{ $getConfig($activeGateway.'_gateway_name', ucwords(str_replace('_', ' ', $activeGateway)).' Payment') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Gateway URL --}}
                <div class="mb-6">
                    <label class="block mb-2 font-medium">
                        {{ ucfirst(str_replace('_', ' ', $activeGateway)) }} URL <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="{{ $activeGateway }}_url"
                           value="{{ $getConfig($activeGateway.'_url') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Gateway Key --}}
                <div class="mb-6">
                    <label class="block mb-2 font-medium">
                        {{ ucfirst(str_replace('_', ' ', $activeGateway)) }} Key <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="{{ $activeGateway }}_key"
                           value="{{ $getConfig($activeGateway.'_key') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Public Key --}}
                <div class="mb-8">
                    <label class="block mb-2 font-medium">
                        {{ ucfirst(str_replace('_', ' ', $activeGateway)) }} Public Key <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="{{ $activeGateway }}_public_key"
                           value="{{ $getConfig($activeGateway.'_public_key') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-[#5B5FC7] hover:bg-[#4b4fb3] text-white px-8 py-3 rounded-lg">
                        Save
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection