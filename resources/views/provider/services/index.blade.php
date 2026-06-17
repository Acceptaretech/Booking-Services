@extends('layouts.provider.app')

@section('title', 'All Services')
@section('page_title', 'All Services')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
            All Services
        </h2>

        <a href="{{ route('provider.services.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>
            New
        </a>
    </div>
</div>

<div class="card p-6">

    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">

        <form id="bulkActionForm"
              method="POST"
              action="{{ route('provider.services.bulk-action') }}"
              class="flex gap-4">
            @csrf

            <select name="action" class="form-select w-72" required>
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
              action="{{ route('provider.services.index') }}"
              class="flex gap-4">

            <select name="status" class="form-select w-36">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="form-input pl-11 w-64">
            </div>

        </form>

    </div>

    <div class="overflow-x-auto">
        <table class="data-table min-w-[1100px]">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" onclick="toggleAll(this)">
                    </th>
                    <th>Name</th>
                    <th>Provider</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>
                            <input type="checkbox"
                                   name="ids[]"
                                   value="{{ $service->id }}"
                                   form="bulkActionForm">
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $service->image_url ?? asset('images/default-service.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Service">

                                <a href="{{ route('provider.services.edit', $service->id) }}"
                                   class="font-medium text-primary-600 hover:underline">
                                    {{ $service->name }}
                                </a>
                            </div>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ auth()->user()->profile_image_url ?? asset('images/default-user.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Provider">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ auth()->user()->full_name ?? auth()->user()->name ?? 'Provider' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-lg">
                                    <i class="fas fa-tools text-yellow-600"></i>
                                </span>

                                <span>
                                    {{ $service->category->name ?? '-' }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <p class="font-medium text-gray-800 dark:text-gray-200">
                                ${{ number_format($service->price ?? 0, 2) }}-
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ ucfirst($service->price_type ?? 'fixed') }}
                            </p>
                        </td>

                        <td>
                            <form method="POST"
                                  action="{{ route('provider.services.toggle', $service->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="relative inline-flex h-6 w-12 items-center rounded-full {{ $service->status == 'active' ? 'bg-primary-600' : 'bg-gray-300' }}">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition {{ $service->status == 'active' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        </td>

                        <td>
                            <div class="flex justify-center items-center gap-3">
                                <form method="POST"
                                      action="{{ route('provider.services.destroy', $service->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this service?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>

                                <a href="{{ route('provider.services.faqs', $service->id) }}"
                                   class="text-primary-600 hover:text-primary-800">
                                    <i class="far fa-question-circle"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400">
                            No services found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $services->links() }}
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