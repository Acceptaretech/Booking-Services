@extends('layouts.admin.app')

@section('title', 'Shops')
@section('page_title', 'All Shop')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input name="search" value="{{ request('search') }}" placeholder="Search shop..." class="form-input w-52 text-xs">

        <select name="status" class="form-select w-36 text-xs" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </form>

    <a href="{{ route('admin.shops.create') }}" class="btn-primary">
        <i class="fas fa-plus-circle"></i> New Shop
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th>Provider</th>
                    <th>City</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th width="130">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($shops as $shop)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <img src="{{ $shop->image_url }}" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold">{{ $shop->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $shop->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div>
                                <p class="font-semibold">{{ $shop->provider->full_name ?? $shop->provider->name ?? 'No Provider' }}</p>
                                <p class="text-xs text-gray-400">{{ $shop->provider->email ?? '' }}</p>
                            </div>
                        </td>

                        <td>{{ $shop->city ?? '-' }}</td>

                        <td>{{ $shop->country_code ?? '+91' }} {{ $shop->phone ?? '-' }}</td>

                        <td>
                            <span class="badge {{ $shop->status === 'active' ? 'badge-success' : 'badge-pending' }}">
                                {{ ucfirst($shop->status) }}
                            </span>
                        </td>

                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.shops.show', $shop->id) }}" class="text-green-600" title="View">
                                    <i class="far fa-clock"></i>
                                </a>

                                <a href="{{ route('admin.shops.edit', $shop->id) }}" class="text-blue-500" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.shops.destroy', $shop->id) }}" onsubmit="return confirm('Delete this shop?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">No shops found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-3">
        {{ $shops->withQueryString()->links() }}
    </div>
</div>

@endsection