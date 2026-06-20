@extends('layouts.handyman.app')

@section('title','Booking Details')
@section('page_title','Booking Details')

@section('content')

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">
                Booking #{{ $booking->id }}
            </h2>
            <p class="text-sm text-gray-500">
                Complete booking information
            </p>
        </div>

        <a href="{{ route('handyman.bookings.index') }}"
           class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Service Details --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border p-6">

            <div class="flex items-center gap-4 mb-6">

                <img
                    src="{{ $booking->service?->image ? asset('public/storage/'.$booking->service->image) : asset('images/default-service.png') }}"
                    class="w-24 h-24 rounded-2xl object-cover border"
                    alt="Service">

                <div>
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ $booking->service->name ?? '-' }}
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Booking ID #{{ $booking->id }}
                    </p>

                    <div class="mt-3">
                        @php
                            $statusClass = match($booking->status){
                                'accepted' => 'bg-green-100 text-green-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                                default => 'bg-blue-100 text-blue-700',
                            };
                        @endphp

                        <span class="px-3 py-2 rounded-lg text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst(str_replace('_',' ',$booking->status)) }}
                        </span>
                    </div>
                </div>

            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="text-xs uppercase text-gray-500">Booking Date</label>
                    <p class="font-semibold text-gray-800 mt-1">
                        {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y h:i A') : '-' }}
                    </p>
                </div>

                <div>
                    <label class="text-xs uppercase text-gray-500">Payment Status</label>
                    <p class="font-semibold text-indigo-600 mt-1">
                        {{ ucfirst($booking->payment_status ?? 'Pending') }}
                    </p>
                </div>

                <div>
                    <label class="text-xs uppercase text-gray-500">Amount</label>
                    <p class="font-bold text-green-600 text-lg mt-1">
                        ₹{{ number_format($booking->total_amount ?? 0,2) }}
                    </p>
                </div>

                <div>
                    <label class="text-xs uppercase text-gray-500">Address</label>
                    <p class="font-medium text-gray-700 mt-1">
                        {{ $booking->address ?? '-' }}
                    </p>
                </div>

            </div>

            <div class="mt-8">
                <h4 class="font-bold text-gray-800 mb-3">
                    Customer Note
                </h4>

                <div class="bg-gray-50 rounded-xl p-4 border">
                    {{ $booking->note ?? 'No note available.' }}
                </div>
            </div>

        </div>

        {{-- Right Sidebar --}}
        <div class="space-y-6">

            {{-- Customer --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6">

                <h3 class="font-bold text-indigo-600 mb-4">
                    Customer Information
                </h3>

                <div class="flex items-center gap-3 mb-4">

                    <img
                        src="{{ $booking->customer?->profile_image ? asset('public/storage/'.$booking->customer->profile_image) : asset('images/default-user.png') }}"
                        class="w-14 h-14 rounded-full object-cover border"
                        alt="Customer">

                    <div>
                        <h4 class="font-semibold">
                            {{ $booking->customer->first_name ?? '-' }}
                            {{ $booking->customer->last_name ?? '' }}
                        </h4>

                        <p class="text-xs text-gray-500">
                            Customer
                        </p>
                    </div>

                </div>

                <div class="space-y-3 text-sm">

                    <p>
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                        {{ $booking->customer->email ?? '-' }}
                    </p>

                    <p>
                        <i class="fas fa-phone text-indigo-500 mr-2"></i>
                        {{ $booking->customer->phone ?? '-' }}
                    </p>

                </div>

            </div>

            {{-- Provider --}}
            <div class="bg-white rounded-2xl shadow-sm border p-6">

                <h3 class="font-bold text-indigo-600 mb-4">
                    Provider Information
                </h3>

                <div class="flex items-center gap-3 mb-4">

                    <img
                        src="{{ $booking->provider?->profile_image ? asset('public/storage/'.$booking->provider->profile_image) : asset('images/default-user.png') }}"
                        class="w-14 h-14 rounded-full object-cover border"
                        alt="Provider">

                    <div>
                        <h4 class="font-semibold">
                            {{ $booking->provider->first_name ?? '-' }}
                            {{ $booking->provider->last_name ?? '' }}
                        </h4>

                        <p class="text-xs text-gray-500">
                            Provider
                        </p>
                    </div>

                </div>

                <div class="space-y-3 text-sm">

                    <p>
                        <i class="fas fa-envelope text-indigo-500 mr-2"></i>
                        {{ $booking->provider->email ?? '-' }}
                    </p>

                    <p>
                        <i class="fas fa-phone text-indigo-500 mr-2"></i>
                        {{ $booking->provider->phone ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection