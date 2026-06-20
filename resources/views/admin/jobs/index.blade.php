@extends('layouts.admin.app')

@section('title','Job Requests')
@section('page_title','Job Request List')

@section('content')

<div class="card p-6">

    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
            Job Request List
        </h2>

        <form method="GET"
              action="{{ route('admin.jobs.index') }}"
              class="flex gap-4">

            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="form-input pl-11 w-72">
            </div>

            <button type="submit" class="btn-primary">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="data-table min-w-[1200px]">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Provider</th>
                    <th>Customer</th>
                    <th>Technician</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>
                            <span class="font-semibold text-primary-600">
                                #{{ $job->booking_number ?? $job->id }}
                            </span>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $job->service?->image ? asset('storage/'.$job->service->image) : asset('images/default-service.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Service">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $job->service->name ?? $job->service->title ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($job->booking_date)
                                {{ \Carbon\Carbon::parse($job->booking_date)->format('F d, Y') }}
                                <br>
                                <span class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($job->booking_date)->format('h:i A') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($job->provider)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $job->provider->profile_image ? asset('storage/'.$job->provider->profile_image) : asset('images/default-user.png') }}"
                                         class="w-10 h-10 rounded-full object-cover"
                                         alt="Provider">

                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $job->provider->first_name ?? '-' }}
                                            {{ $job->provider->last_name ?? '' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $job->provider->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($job->customer)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $job->customer->profile_image ? asset('storage/'.$job->customer->profile_image) : asset('images/default-user.png') }}"
                                         class="w-10 h-10 rounded-full object-cover"
                                         alt="Customer">

                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $job->customer->first_name ?? '-' }}
                                            {{ $job->customer->last_name ?? '' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $job->customer->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if($job->handyman)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $job->handyman->profile_image ? asset('storage/'.$job->handyman->profile_image) : asset('images/default-user.png') }}"
                                         class="w-10 h-10 rounded-full object-cover"
                                         alt="Technician">

                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $job->handyman->first_name ?? '-' }}
                                            {{ $job->handyman->last_name ?? '' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $job->handyman->email ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400">Not Assigned</span>
                            @endif
                        </td>

                        <td>
                            @php
                                $status = $job->status ?? 'pending';

                                $statusClass = match($status) {
                                    'accepted' => 'bg-green-100 text-green-600',
                                    'completed' => 'bg-green-100 text-green-600',
                                    'pending' => 'bg-yellow-100 text-yellow-600',
                                    'in_progress' => 'bg-blue-100 text-blue-600',
                                    'cancelled' => 'bg-red-100 text-red-600',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp

                            <span class="px-4 py-2 rounded-md text-sm font-medium {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>

                        <td>
                            <span class="font-bold text-primary-600">
                                ₹{{ number_format($job->total_amount ?? 0, 2) }}
                            </span>
                        </td>

                        <td>
                            <span class="px-4 py-2 rounded-md text-sm font-medium bg-primary-50 text-primary-600">
                                {{ ucfirst($job->payment_status ?? 'pending') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-12 text-gray-400">
                            <i class="fas fa-briefcase text-4xl text-gray-200 mb-2 block"></i>
                            <p>No bookings found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $jobs->withQueryString()->links() }}
    </div>

</div>

@endsection