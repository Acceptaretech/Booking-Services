@extends('layouts.provider.app')

@section('title', 'Packages')
@section('page_title', 'Packages')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Packages</h2>

        <a href="{{ route('provider.packages.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i>
            New
        </a>
    </div>
</div>

<div class="card p-6">

    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">

        <form id="bulkActionForm"
              method="POST"
              action="{{ route('provider.packages.bulk-action') }}"
              class="flex gap-4">
            @csrf

            <select name="action" class="form-select w-72" required>
                <option value="">No Action</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="delete">Delete</option>
            </select>

            <button type="submit" class="btn-primary">Apply</button>
        </form>

        <form method="GET"
              action="{{ route('provider.packages.index') }}"
              class="flex gap-4">

            <select name="status" class="form-select w-36" onchange="this.form.submit()">
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
        <table class="data-table min-w-[1000px]">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggleAll(this)"></th>
                    <th>Name</th>
                    <th>Provider</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($packages as $package)
                    <tr>
                        <td>
                            <input type="checkbox"
                                   name="ids[]"
                                   value="{{ $package->id }}"
                                   form="bulkActionForm">
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $package->image_url ?? asset('images/default-service.png') }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Package">

                                <span class="font-medium text-primary-600">
                                    {{ $package->name }}
                                </span>
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
                            ${{ number_format($package->price ?? 0, 2) }}
                        </td>

                        <td>
                            <form method="POST" action="{{ route('provider.packages.toggle', $package->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="relative inline-flex h-6 w-12 items-center rounded-full {{ $package->status == 'active' ? 'bg-primary-600' : 'bg-gray-300' }}">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition {{ $package->status == 'active' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        </td>

                        <td>
                            <div class="flex justify-center items-center gap-3">
                                <a href="{{ route('provider.packages.edit', $package->id) }}"
                                   class="text-gray-400 hover:text-primary-600">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('provider.packages.destroy', $package->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this package?')">
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
                        <td colspan="6" class="text-center py-8 text-gray-400">
                            No packages found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $packages->links() }}
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