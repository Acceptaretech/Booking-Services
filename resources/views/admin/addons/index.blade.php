@extends('layouts.admin.app')

@section('title', 'Addons')
@section('page_title', 'Addons')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search addons..." class="form-input w-52 text-xs">

        <select name="status" class="form-select w-36 text-xs" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </form>

    <a href="{{ route('admin.addons.create') }}" class="btn-primary text-xs">
        <i class="fas fa-plus"></i> New Addon
    </a>
</div>

<div class="card overflow-hidden">
    <table class="data-table w-full">
        <thead>
            <tr>
                <th>Name</th>
                <th>Service</th>
                <th>Provider</th>
                <th>Price</th>
                <th>Status</th>
                <th width="120">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($addons as $addon)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="{{ $addon->image_url }}" class="w-10 h-10 rounded-xl object-cover">
                            <div>
                                <p class="font-semibold text-sm">{{ $addon->name }}</p>
                                <p class="text-xs text-gray-400">{{ Str::limit($addon->description, 35) }}</p>
                            </div>
                        </div>
                    </td>

                    <td>{{ $addon->service->name ?? 'No Service' }}</td>

                    <td>
                        {{ $addon->provider->full_name ?? $addon->provider->name ?? 'No Provider' }}
                        <p class="text-xs text-gray-400">{{ $addon->provider->email ?? '' }}</p>
                    </td>

                    <td>
                        <span class="font-semibold text-primary-600">
                            ${{ number_format((float) $addon->price, 2) }}
                        </span>
                    </td>

                    <td>
                        <span class="badge {{ $addon->status === 'active' ? 'badge-success' : 'badge-pending' }}">
                            {{ ucfirst($addon->status) }}
                        </span>
                    </td>

                    <td>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.addons.edit', $addon->id) }}"
                               class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <form method="POST" action="{{ route('admin.addons.destroy', $addon->id) }}" onsubmit="return confirm('Delete this addon?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-gray-400">
                        No addons found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-5 py-3">
        {{ $addons->withQueryString()->links() }}
    </div>
</div>

@endsection