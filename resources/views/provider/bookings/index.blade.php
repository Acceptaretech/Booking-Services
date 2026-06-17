@extends('layouts.provider.app')

@section('title', 'Bookings')
@section('page_title', 'Bookings')

@section('content')

<div class="card p-6">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-8">
        <div class="flex flex-wrap items-center gap-4">
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                Total Amount:
                <span class="text-primary-600">
                    ${{ number_format($bookings->sum('total_amount'), 2) }}
                </span>
            </p>

            <a href="#" class="text-green-600 text-sm hover:underline">
                View Breakdown
            </a>

            <a href="{{ route('provider.bookings.export') }}"
               class="btn-primary">
                Export
            </a>
        </div>

        <form method="GET" action="{{ route('provider.bookings.index') }}" class="flex gap-3">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="form-input pl-11 w-64">
            </div>

            <button type="submit" class="btn-primary">
                Filter
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table min-w-[1100px]">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>User</th>
                    <th>Shop</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td>
                            <a href="#" class="text-primary-600 font-medium">
                                #{{ $booking->id }}
                            </a>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $booking->service->image_url ?? asset('images/default-service.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Service">

                                <span class="font-medium">
                                    {{ $booking->service->name ?? 'N/A' }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <p class="font-medium">
                                {{ optional($booking->booking_date)->format('F d, Y') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ optional($booking->booking_date)->format('g:i A') }}
                            </p>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $booking->customer->profile_image_url ?? asset('images/default-user.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="User">

                                <div>
                                    <p class="font-semibold text-sm">
                                        {{ $booking->customer->full_name ?? $booking->customer->name ?? 'N/A' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $booking->customer->email ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $booking->shop->name ?? '-' }}
                        </td>

                        <td>
                            @php
                                $statusClass = match($booking->status) {
                                    'completed' => 'bg-green-100 text-green-600',
                                    'cancelled' => 'bg-gray-300 text-gray-900',
                                    'pending_approval' => 'bg-red-100 text-red-500',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    default => 'bg-gray-100 text-gray-600',
                                };

                                $statusText = str_replace('_', ' ', ucfirst($booking->status));
                            @endphp

                            <span class="px-4 py-2 rounded-md text-sm font-medium {{ $statusClass }}">
                                {{ ucwords($statusText) }}
                            </span>
                        </td>

                        <td>
                            ${{ number_format($booking->total_amount ?? 0, 2) }}
                        </td>

                        <td>
                            @php
                                $paymentClass = match($booking->payment_status) {
                                    'paid' => 'bg-green-100 text-green-600',
                                    'pending_by_provider' => 'bg-primary-600 text-white',
                                    'pending' => 'bg-primary-50 text-primary-600',
                                    default => 'bg-gray-100 text-gray-600',
                                };

                                $paymentText = str_replace('_', ' ', ucfirst($booking->payment_status ?? 'pending'));
                            @endphp

                            <span class="px-4 py-2 rounded-md text-sm font-medium {{ $paymentClass }}">
                                {{ ucwords($paymentText) }}
                            </span>
                        </td>

                        <td class="text-center">
                            <form method="POST"
                                  action="{{ route('provider.bookings.destroy', $booking->id) }}"
                                  onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-400">
                            No bookings found
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

@endsection