@extends('layouts.handyman.app')

@section('title','Bookings')
@section('page_title','Bookings')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar{
        height:8px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track{
        background:#e5e7eb;
        border-radius:10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb{
        background:#4f46e5;
        border-radius:10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover{
        background:#4338ca;
    }
    </style>
<div>

    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
            <div class="flex flex-wrap items-center gap-4">
                <p class="font-semibold text-gray-700">
                    Total Amount:
                    <span class="text-indigo-600">
                        ₹{{ number_format($totalAmount ?? 0, 2) }}
                    </span>
                </p>

                <a href="#" class="text-green-600 text-sm">View Breakdown</a>

                <button class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm font-semibold">
                    Export
                </button>
            </div>

            <form method="GET" action="{{ route('handyman.bookings.index') }}"
                  class="flex flex-col sm:flex-row gap-3">

                <div class="relative">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search..."
                           class="w-full sm:w-72 border rounded-lg pl-11 pr-4 py-3 text-sm">
                </div>

                <select name="status" class="border rounded-lg px-4 py-3 text-sm">
                    <option value="">All Status</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-x-auto custom-scrollbar rounded-2xl border border-gray-200 bg-white">

            <table class="min-w-[1200px] w-full text-sm">
        
                <thead>
                    <tr class="bg-indigo-600 text-white">
                        <th class="p-4 text-left whitespace-nowrap">ID</th>
                        <th class="p-4 text-left whitespace-nowrap">Service</th>
                        <th class="p-4 text-left whitespace-nowrap">Booking Date</th>
                        <th class="p-4 text-left whitespace-nowrap">User</th>
                        <th class="p-4 text-left whitespace-nowrap">Shop</th>
                        <th class="p-4 text-left whitespace-nowrap">Provider</th>
                        <th class="p-4 text-left whitespace-nowrap">Status</th>
                        <th class="p-4 text-left whitespace-nowrap">Total Amount</th>
                        <th class="p-4 text-left whitespace-nowrap">Payment Status</th>
                        <th class="p-4 text-left whitespace-nowrap">Action</th>
                    </tr>
                </thead>
        
                <tbody>
                    @forelse($bookings as $booking)
        
                        <tr class="border-b hover:bg-gray-50">
        
                            <td class="p-4 font-semibold text-indigo-600 whitespace-nowrap">
                                #{{ $booking->id }}
                            </td>
        
                            <td class="p-4">
                                <div class="flex items-center gap-3">
        
                                    <img
                                        src="{{ $booking->service?->image ? asset('storage/'.$booking->service->image) : asset('images/default-service.png') }}"
                                        class="w-12 h-12 rounded-full object-cover"
                                        alt="Service">
        
                                    <div>
                                        <p class="font-semibold">
                                            {{ $booking->service->name ?? '-' }}
                                        </p>
                                    </div>
        
                                </div>
                            </td>
        
                            <td class="p-4 whitespace-nowrap">
                                {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') : '-' }}
                                <br>
                                <span class="text-xs text-gray-500">
                                    {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('h:i A') : '' }}
                                </span>
                            </td>
        
                            <td class="p-4">
                                <div class="flex items-center gap-3">
        
                                    <img
                                        src="{{ $booking->customer?->profile_image ? asset('storage/'.$booking->customer->profile_image) : asset('images/default-user.png') }}"
                                        class="w-10 h-10 rounded-full object-cover"
                                        alt="Customer">
        
                                    <div>
                                        <p class="font-semibold">
                                            {{ $booking->customer->first_name ?? '-' }}
                                            {{ $booking->customer->last_name ?? '' }}
                                        </p>
        
                                        <p class="text-xs text-gray-500">
                                            {{ $booking->customer->email ?? '-' }}
                                        </p>
                                    </div>
        
                                </div>
                            </td>
        
                            <td class="p-4">
                                -
                            </td>
        
                            <td class="p-4">
                                <div class="flex items-center gap-3">
        
                                    <img
                                        src="{{ $booking->provider?->profile_image ? asset('storage/'.$booking->provider->profile_image) : asset('images/default-user.png') }}"
                                        class="w-10 h-10 rounded-full object-cover"
                                        alt="Provider">
        
                                    <div>
                                        <p class="font-semibold">
                                            {{ $booking->provider->first_name ?? '-' }}
                                            {{ $booking->provider->last_name ?? '' }}
                                        </p>
        
                                        <p class="text-xs text-gray-500">
                                            {{ $booking->provider->email ?? '-' }}
                                        </p>
                                    </div>
        
                                </div>
                            </td>
        
                            <td class="p-4 whitespace-nowrap">
        
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
        
                            </td>
        
                            <td class="p-4 font-bold whitespace-nowrap">
                                ₹{{ number_format($booking->total_amount ?? 0,2) }}
                            </td>
        
                            <td class="p-4">
        
                                <span class="px-3 py-2 rounded-lg text-xs font-semibold bg-indigo-100 text-indigo-700">
                                    {{ ucfirst($booking->payment_status ?? 'Pending') }}
                                </span>
        
                            </td>
        
                            <td class="p-4">
        
                                <div class="flex items-center gap-2">
        
                                    <a href="{{ route('handyman.bookings.show',$booking->id) }}"
                                       class="w-9 h-9 flex items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
        
                                    <form action="{{ route('handyman.bookings.status',$booking->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PATCH')
        
                                        <select name="status"
                                                onchange="this.form.submit()"
                                                class="border rounded-lg px-2 py-1 text-xs">
                                            <option value="">Change</option>
                                            <option value="accepted">Accepted</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </form>
        
                                </div>
        
                            </td>
        
                        </tr>
        
                    @empty
        
                        <tr>
                            <td colspan="10" class="text-center py-16 text-gray-400">
                                No bookings found.
                            </td>
                        </tr>
        
                    @endforelse
                </tbody>
        
            </table>
        
        </div>

        <div class="mt-5">
            {{ $bookings->links() }}
        </div>

    </div>
</div>

@endsection