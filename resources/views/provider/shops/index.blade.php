@extends('layouts.provider.app')

@section('title', 'Shops')
@section('page_title', 'All Shop')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">All Shop</h2>

        <a href="{{ route('provider.shops.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i> New Shop
        </a>
    </div>
</div>

<div class="card p-6">

    <div class="flex flex-col lg:flex-row justify-between gap-4 mb-8">

        <form id="bulkActionForm" method="POST" action="{{ route('provider.shops.bulk-action') }}" class="flex gap-4">
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

        <form method="GET" action="{{ route('provider.shops.index') }}" class="flex gap-4">
            <select name="status" class="form-select w-36">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-input w-64">
        </form>

    </div>

    <div class="overflow-x-auto">
        <table class="data-table min-w-[900px]">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggleAll(this)"></th>
                    <th>Shop Name</th>
                    <th>City</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($shops as $shop)
                    <tr>
                        <td>
                            <input type="checkbox" name="ids[]" value="{{ $shop->id }}" form="bulkActionForm">
                        </td>

                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $shop->image_url }}"
                                     class="w-12 h-12 rounded-full object-cover"
                                     alt="Shop">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $shop->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $shop->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>

                        <td>{{ $shop->city ?? '-' }}</td>
                        <td>{{ $shop->phone ?? '-' }}</td>

                        <td>
                            <form method="POST" action="{{ route('provider.shops.toggle', $shop->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="relative inline-flex h-6 w-12 items-center rounded-full {{ $shop->status == 'active' ? 'bg-primary-600' : 'bg-gray-300' }}">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition {{ $shop->status == 'active' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                            </form>
                        </td>

                        <td>
                            <div class="flex justify-center items-center gap-3">
                               {{--   <a href="{{ route('provider.shops.show', $shop->id) }}" class="text-green-500">
                                    <i class="far fa-clock"></i>
                                </a> --}}

                                <a href="{{ route('provider.shops.edit', $shop->id) }}" class="text-gray-400">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <form method="POST" action="{{ route('provider.shops.destroy', $shop->id) }}" onsubmit="return confirm('Delete this shop?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-400">
                            No shops found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $shops->links() }}
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