@extends('layouts.provider.app')

@section('title','Job Request List')
@section('page_title','Job Request List')

@section('content')

<div class="card p-5 mb-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Job Request List
    </h2>
</div>

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

    <div class="overflow-x-auto">
        <table class="data-table min-w-[1100px]">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleAll(this)">
                    </th>
                    <th>Title</th>
                    <th>Provider</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Price</th>
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
                            <div class="flex items-center gap-3">
                                <img src="{{ $job->image ? asset('storage/' . $job->image) : asset('images/default-service.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Job">

                                <a href="{{ route('provider.job-requests.show', $job->id) }}"
                                   class="font-medium text-primary-600 hover:underline">
                                    {{ $job->title ?? '-' }}
                                </a>
                            </div>
                        </td>

                        <td>
                            @php
                                $providerBid = $job->bids->where('provider_id', auth()->id())->first();
                            @endphp

                            @if($providerBid && $providerBid->provider)
                                <div class="flex items-center gap-3">
                                    <img src="{{ $providerBid->provider->profile_image_url ?? asset('images/default-user.png') }}"
                                         class="w-12 h-12 rounded-full object-cover"
                                         alt="Provider">

                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $providerBid->provider->full_name ?? $providerBid->provider->name ?? 'Provider' }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ $providerBid->provider->email ?? '-' }}
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
                                    <img src="{{ $job->customer->profile_image_url ?? asset('images/default-user.png') }}"
                                         class="w-12 h-12 rounded-full object-cover"
                                         alt="Customer">

                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $job->customer->full_name ?? $job->customer->name ?? '-' }}
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
                            @php
                                $status = $job->status ?? 'requested';

                                $statusClass = match($status) {
                                    'assigned' => 'bg-gray-100 text-gray-700',
                                    'requested' => 'bg-primary-50 text-primary-600',
                                    'completed' => 'bg-green-100 text-green-600',
                                    'cancelled' => 'bg-red-100 text-red-600',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp

                            <span class="px-4 py-2 rounded-md text-sm font-medium {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        <td>
                            ${{ number_format($job->price ?? 0, 2) }}
                        </td>

                        <td>
                            <div class="flex justify-center items-center gap-4">
                                <form method="POST"
                                      action="{{ route('provider.job-requests.destroy', $job->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this job request?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>

                                <a href="{{ route('provider.job-requests.show', $job->id) }}"
                                   class="text-blue-400 hover:text-primary-600">
                                    <i class="far fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-gray-400">
                            No job requests found
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