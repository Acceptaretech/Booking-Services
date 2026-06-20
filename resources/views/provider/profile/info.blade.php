@extends('layouts.provider.app')

@section('page_title','Provider Details')

@section('content')
<div class="space-y-6">

    <div class="bg-white rounded-xl p-5 shadow-sm">
        <h2 class="text-lg font-semibold">Provider Details</h2>
    </div>

    @php
        $tabs = [
            'overview' => 'OVERVIEW',
            'bookings' => 'BOOKINGS',
            'Technician' => 'TECHNICIAN',
            'commission' => 'COMMISSION',
            'reviews' => 'REVIEWS',
            'documents' => 'DOCUMENT LIST',
            'payouts' => 'PAYOUT LIST',
            'addresses' => 'ADDRESS LIST',
            'bank' => 'BANK LIST',
            'slots' => 'SLOT LIST',
            'shops' => 'SHOP LIST',
            'shop_documents' => 'SHOP DOCUMENT LIST',
        ];
    @endphp

    <div class="flex flex-wrap gap-4">
        @foreach($tabs as $key => $label)
            <a href="{{ route('provider.profile.info', ['tab' => $key]) }}"
               class="px-5 py-3 rounded-lg text-sm font-medium {{ $tab == $key ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-600' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl p-6 shadow-sm">

        @if($tab == 'overview')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-6 rounded-xl border bg-indigo-50">
                        <h3 class="text-3xl font-bold text-indigo-600">$0.00</h3>
                        <p class="mt-3">Withdrawal Pending</p>
                    </div>

                    <div class="p-6 rounded-xl border bg-green-50">
                        <h3 class="text-3xl font-bold text-green-600">$0.00</h3>
                        <p class="mt-3">Already Withdrawn</p>
                    </div>

                    <div class="p-6 rounded-xl border bg-orange-50">
                        <h3 class="text-3xl font-bold text-orange-500">{{ $totalBooking }}</h3>
                        <p class="mt-3">Total Booking</p>
                    </div>

                    <div class="p-6 rounded-xl border bg-red-50">
                        <h3 class="text-3xl font-bold text-red-500">$0.00</h3>
                        <p class="mt-3">Wallet Balance</p>
                    </div>
                </div>

                <div class="border rounded-xl p-6">
                    <h3 class="text-center font-semibold mb-6">Booking Overview</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span>Completed</span>
                            <strong>{{ $completed }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Pending</span>
                            <strong>{{ $pending }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Cancelled</span>
                            <strong>{{ $cancelled }}</strong>
                        </div>
                        <div class="flex justify-between">
                            <span>Total</span>
                            <strong>{{ $totalBooking }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 max-w-xl border rounded-xl p-6 shadow-sm">
                <div class="flex gap-6">
                    <img src="{{ $provider->profile_image ?  asset('storage/'.$provider->profile_image) : 'https://ui-avatars.com/api/?name='.urlencode($provider->first_name.' '.$provider->last_name) }}"
                         class="w-36 h-36 rounded-lg object-cover">

                    <div>
                        <h3 class="text-xl font-bold mb-4">
                            {{ $provider->first_name }} {{ $provider->last_name }}
                        </h3>

                        <p class="mb-3">📱 {{ $provider->phone ?? 'N/A' }}</p>
                        <p class="mb-3">✉️ {{ $provider->email ?? 'N/A' }}</p>
                        <p>📍 {{ $provider->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-gray-100 rounded-xl p-6">
                <h3 class="text-xl font-bold mb-5">Zone Available</h3>

                <div class="flex flex-wrap gap-4">
                  @if($zone)
                      <span class="px-5 py-3 rounded-lg bg-white shadow-sm">
                          📍 {{ $zone->name }}
                      </span>
                  @else
                      <p class="text-gray-500">No zone assigned.</p>
                  @endif
              </div>
            </div>
        @endif

        @if($tab == 'bookings')
            <h3 class="text-xl font-semibold mb-4">Bookings</h3>

            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Booking ID</th>
                            <th class="p-3 text-left">Customer</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="border-t">
                                <td class="p-3">#{{ $booking->id }}</td>
                                <td class="p-3">{{ $booking->customer->first_name ?? 'N/A' }}</td>
                                <td class="p-3">{{ ucfirst($booking->status) }}</td>
                                <td class="p-3">₹{{ $booking->total_amount ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-5 text-center text-gray-500">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

        @if(!in_array($tab, ['overview','bookings']))
            <div class="text-center py-16">
                <i class="fas fa-folder-open text-5xl text-indigo-300"></i>
                <h3 class="mt-4 text-xl font-semibold">{{ $tabs[$tab] ?? 'Details' }}</h3>
                <p class="text-gray-500 mt-2">This tab is ready to connect with your data.</p>
            </div>
        @endif

    </div>
</div>
@endsection