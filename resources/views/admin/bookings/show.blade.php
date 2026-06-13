@extends('layouts.admin.app')

@section('page_title', 'Booking Details')

@section('content')
<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Booking Details</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $booking->booking_number }}</p>
        </div>

        <a href="{{ route('admin.bookings.index') }}"
           class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-5 text-gray-800 dark:text-white">Service Information</h3>

            <div class="flex gap-5">
                <img src="{{ $booking->service?->image ? asset('storage/'.$booking->service->image) : asset('images/default-service.png') }}"
                     class="w-28 h-28 rounded-2xl object-cover">

                <div>
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $booking->service->name ?? 'N/A' }}
                    </h4>

                    <p class="text-gray-500 mt-2">
                        {{ $booking->service->description ?? 'No description available.' }}
                    </p>

                    <p class="mt-3 font-bold text-indigo-600">
                        ₹{{ number_format($booking->total_amount ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-5 text-gray-800 dark:text-white">Booking Status</h3>

            <span class="px-4 py-2 rounded-full text-sm font-bold
                @if($booking->status == 'completed') bg-green-100 text-green-700
                @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-700
                @elseif($booking->status == 'cancelled') bg-red-100 text-red-700
                @elseif($booking->status == 'accepted') bg-blue-100 text-blue-700
                @else bg-gray-100 text-gray-700
                @endif">
                {{ ucfirst($booking->status) }}
            </span>

            <div class="mt-5 space-y-3 text-sm">
                <p><b>Booking Date:</b> {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y, h:i A') : '-' }}</p>
                <p><b>Created:</b> {{ $booking->created_at->format('d M Y, h:i A') }}</p>
                <p><b>Address:</b> {{ $booking->address ?? '-' }}</p>
                <p><b>Note:</b> {{ $booking->note ?? '-' }}</p>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Customer</h3>

            <p class="font-bold">
                {{ trim(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?: ($booking->customer->name ?? 'N/A') }}
            </p>
            <p class="text-gray-500">{{ $booking->customer->email ?? '-' }}</p>
            <p class="text-gray-500">{{ $booking->customer->phone ?? '-' }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Provider</h3>

            <p class="font-bold">
                {{ trim(($booking->provider->first_name ?? '') . ' ' . ($booking->provider->last_name ?? '')) ?: ($booking->provider->name ?? 'N/A') }}
            </p>
            <p class="text-gray-500">{{ $booking->provider->email ?? '-' }}</p>
            <p class="text-gray-500">{{ $booking->provider->phone ?? '-' }}</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
            <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Handyman</h3>

            <p class="font-bold">
                {{ $booking->handyman
                    ? trim(($booking->handyman->first_name ?? '') . ' ' . ($booking->handyman->last_name ?? ''))
                    : 'Not Assigned' }}
            </p>
            <p class="text-gray-500">{{ $booking->handyman->email ?? '-' }}</p>
            <p class="text-gray-500">{{ $booking->handyman->phone ?? '-' }}</p>
        </div>

    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <h3 class="text-lg font-bold mb-5 text-gray-800 dark:text-white">Payment Summary</h3>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900">
                <p class="text-sm text-gray-500">Base Price</p>
                <h4 class="text-xl font-bold">₹{{ number_format($booking->base_price ?? 0, 2) }}</h4>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900">
                <p class="text-sm text-gray-500">Discount</p>
                <h4 class="text-xl font-bold">₹{{ number_format($booking->discount ?? 0, 2) }}</h4>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900">
                <p class="text-sm text-gray-500">Total Amount</p>
                <h4 class="text-xl font-bold text-indigo-600">₹{{ number_format($booking->total_amount ?? 0, 2) }}</h4>
            </div>

            <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-900">
                <p class="text-sm text-gray-500">Payment Status</p>
                <h4 class="text-xl font-bold">
                    {{ ucfirst($booking->payment->status ?? 'unpaid') }}
                </h4>
            </div>
        </div>
    </div>

</div>
@endsection