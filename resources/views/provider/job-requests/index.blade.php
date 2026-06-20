@extends('layouts.provider.app')

@section('title','Job Request List')
@section('page_title','Job Request List')

@section('content')

<div class="card p-6">

    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">

        <form id="bulkActionForm"
              method="POST"
              action="{{ route('provider.job-requests.bulk-action') }}"
              class="flex gap-4">
            @csrf

            <select name="action" class="form-select w-56" required>
                <option value="">No Action</option>
                <option value="delete">Delete</option>
            </select>

            <button type="submit" class="btn-primary">
                Apply
            </button>
        </form>

        <div class="flex flex-wrap gap-3">

            <form action="{{ route('provider.job-requests.auto-assign') }}"
                  method="POST">
                @csrf
        
                <button type="submit"
                        onclick="return confirm('Auto assign technicians to pending bookings?')"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg font-semibold">
        
                    <i class="fas fa-magic mr-2"></i>
                    Auto Assign Technician
                </button>
            </form>
        
            <form method="GET"
                  action="{{ route('provider.job-requests.index') }}"
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

    </div>

    <div class="overflow-x-auto">
        <table class="data-table min-w-[1200px]">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleAll(this)">
                    </th>
                    <th>Booking ID</th>
                    <th>Service</th>
                    <th>Booking Date</th>
                    <th>Customer</th>
                    <th>Provider</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Payment Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td>
                            <input type="checkbox"
                                   name="ids[]"
                                   value="{{ $job->id }}"
                                   form="bulkActionForm">
                        </td>

                        <td>
                            <a href="{{ route('provider.job-requests.show', $job->id) }}"
                               class="font-semibold text-primary-600 hover:underline">
                                #{{ $job->booking_number ?? $job->id }}
                            </a>
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
                            @if($job->customer)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $job->customer->profile_image ? asset('storage/'.$job->customer->profile_image) : asset('images/default-user.png') }}"
                                         class="w-12 h-12 rounded-full object-cover"
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
                            @if($job->provider)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $job->provider->profile_image ? asset('storage/'.$job->provider->profile_image) : asset('images/default-user.png') }}"
                                         class="w-12 h-12 rounded-full object-cover"
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
                            ₹{{ number_format($job->total_amount ?? 0, 2) }}
                        </td>

                        <td>
                            <span class="px-4 py-2 rounded-md text-sm font-medium bg-primary-50 text-primary-600">
                                {{ ucfirst($job->payment_status ?? 'pending') }}
                            </span>
                        </td>

                        <td>
                            <div class="flex justify-center items-center gap-4">

                                <a href="{{ route('provider.job-requests.show', $job->id) }}"
                                   class="text-blue-400 hover:text-primary-600">
                                    <i class="far fa-eye"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('provider.job-requests.destroy', $job->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-10 text-gray-400">
                            No bookings found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $jobs->links() }}
    </div>

</div>

@endsection

@push('scripts')
<script>
function toggleAll(source) {
    document.querySelectorAll('input[name="ids[]"]').forEach(function (checkbox) {
        checkbox.checked = source.checked;
    });
}
</script>
@endpush