@extends('layouts.admin.app')

@section('title', 'Packages')
@section('page_title', 'Packages')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search packages..."
            class="form-input w-52 text-xs">

        <select name="status" class="form-select w-36 text-xs" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </form>

    <a href="{{ route('admin.packages.create') }}" class="btn-primary text-xs">
        <i class="fas fa-plus"></i>
        New Package
    </a>
</div>

<div class="card overflow-hidden">
    <table class="data-table w-full">
        <thead>
            <tr>
                <th>Package</th>
                <th>Provider</th>
                <th>Category</th>
                <th>Service</th>
                <th>Price</th>
                <th>Status</th>
                <th width="120">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($packages as $package)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ $package->image_url }}"
                                 class="w-10 h-10 rounded-xl object-cover">

                            <div>
                                <p class="font-semibold text-sm">
                                    {{ $package->name }}
                                </p>

                                <p class="text-xs text-gray-400">
                                    {{ ucfirst(str_replace('_', ' ', $package->package_type ?? 'single_category')) }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td>
                        {{ $package->provider->full_name ?? $package->provider->name ?? 'No Provider' }}
                    </td>

                    <td>
                        {{ $package->category->name ?? 'No Category' }}
                    </td>

                    <td>
                        {{ $package->service->name ?? 'No Service' }}
                    </td>

                    <td>
                        <span class="font-semibold text-primary-600">
                            ${{ number_format((float) $package->price, 2) }}
                        </span>

                        @if($package->original_price)
                            <p class="text-xs text-red-500">
                                <s>${{ number_format((float) $package->original_price, 2) }}</s>
                            </p>
                        @endif
                    </td>

                    <td>
                        <span class="badge {{ $package->status === 'active' ? 'badge-success' : 'badge-pending' }}">
                            {{ ucfirst($package->status ?? 'inactive') }}
                        </span>
                    </td>

                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.packages.edit', $package->id) }}"
                               class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.packages.destroy', $package->id) }}"
                                  onsubmit="return confirm('Delete this package?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-400">
                        No packages found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-5 py-3">
        {{ $packages->withQueryString()->links() }}
    </div>
</div>

@endsection