@extends('layouts.provider.app')

@section('title','Technician List')
@section('page_title','Technician List')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
            Technician List
        </h2>

        <a href="{{ route('provider.handymen.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle mr-1"></i>
            New
        </a>
    </div>
</div>

<div class="card p-6">

    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">

        <form id="bulkActionForm"
              method="POST"
              action="{{ route('provider.handymen.bulk-action') }}"
              class="flex gap-4">
            @csrf

            <select name="action" class="form-select w-56" required>
                <option value="">No Action</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="delete">Delete</option>
            </select>

            <button type="submit" class="btn-primary">
                Apply
            </button>
        </form>

        <form method="GET"
              action="{{ route('provider.handymen.index') }}"
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
                    <th>
                        <input type="checkbox" onclick="toggleAll(this)">
                    </th>
                    <th>Name</th>
                    <th>Joining Date</th>
                    <th>Provider</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Commission Amount</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($handymen as $handyman)
                    <tr>
                        <td>
                            <input type="checkbox"
                                   name="ids[]"
                                   value="{{ $handyman->id }}"
                                   form="bulkActionForm">
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $handyman->profile_image ? asset('storage/'.$handyman->profile_image) : asset('images/default-user.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Technician">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ trim(($handyman->first_name ?? '').' '.($handyman->last_name ?? '')) ?: ($handyman->name ?? '-') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $handyman->email ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $handyman->created_at ? $handyman->created_at->format('F j, Y g:i A') : '-' }}
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ auth()->user()->profile_image ? asset('storage/'.auth()->user()->profile_image) : asset('images/default-user.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Provider">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ trim((auth()->user()->first_name ?? '').' '.(auth()->user()->last_name ?? '')) ?: auth()->user()->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>
                            {{ $handyman->phone ?? '-' }}
                        </td>

                        <td>
                            {{ $handyman->address ?? '-' }}
                        </td>

                        <td>
                            @if($handyman->commission_type && $handyman->commission !== null)
                                <strong>
                                    @if($handyman->commission_type === 'percentage')
                                        {{ number_format($handyman->commission, 2) }}%
                                    @else
                                        ₹{{ number_format($handyman->commission, 2) }}
                                    @endif
                                </strong>
                        
                                <p class="text-xs text-gray-500 capitalize">
                                    {{ $handyman->commission_type }}
                                </p>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td>
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('provider.handymen.edit', $handyman->id) }}"
                                   class="text-gray-500 hover:text-primary-600">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('provider.handymen.destroy', $handyman->id) }}"
                                      onsubmit="return confirm('Delete this Technician?')">
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
                        <td colspan="8" class="text-center py-10 text-gray-400">
                            No Technician found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $handymen->links() }}
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