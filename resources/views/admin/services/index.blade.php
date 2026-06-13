@extends('layouts.admin.app')

@section('title', 'Services')
@section('page_title', 'Service List')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">

    <form method="GET" class="flex gap-2 flex-wrap">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search services..."
                class="form-input pl-8 py-2 w-48 text-xs">
        </div>

        <select name="category_id"
                class="form-select text-xs py-2 w-40"
                onchange="this.form.submit()">
            <option value="">All Categories</option>

            @foreach($categories as $id => $name)
                <option value="{{ $id }}"
                    {{ request('category_id') == $id ? 'selected' : '' }}>
                    {{ $name }}
                </option>
            @endforeach
        </select>

        <select name="status"
                class="form-select text-xs py-2 w-32"
                onchange="this.form.submit()">

            <option value="">All Status</option>

            <option value="active"
                {{ request('status') == 'active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="inactive"
                {{ request('status') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>

        </select>
    </form>

    <a href="{{ route('admin.services.create') }}" class="btn-primary text-xs">
        <i class="fas fa-plus"></i>
        New Service
    </a>

</div>

<div class="card overflow-hidden">

    <table class="data-table w-full">

        <thead>
        <tr>
            <th>Service</th>
            <th>Provider</th>
            <th>Category</th>
            <th>Price</th>
            <th>Bookings</th>
            <th>Rating</th>
            <th>Status</th>
            <th width="120">Action</th>
        </tr>
        </thead>

        <tbody>

        @forelse($services as $s)

            <tr>

                {{-- Service --}}
                <td>
                    <div class="flex items-center gap-3">

                        @if($s->image)
                            <img src="{{ asset('storage/'.$s->image) }}"
                                 class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-concierge-bell text-primary-500 text-sm"></i>
                            </div>
                        @endif

                        <div>
                            <p class="font-medium text-sm text-gray-800 dark:text-gray-200">
                                {{ $s->name }}
                            </p>

                            @if($s->discount > 0)
                                <p class="text-xs text-red-500">
                                    <s>${{ number_format($s->price,2) }}</s>
                                    {{ $s->discount }}% off
                                </p>
                            @endif
                        </div>

                    </div>
                </td>

                {{-- Provider --}}
                <td>
                    <div class="flex items-center gap-2">

                        @if($s->provider)

                            <img
                                src="{{ $s->provider->profile_image_url ?? asset('images/default-user.png') }}"
                                class="w-6 h-6 rounded-full">

                            <span class="text-xs">
                                {{ $s->provider->full_name ?? $s->provider->name ?? 'Provider' }}
                            </span>

                        @else

                            <span class="text-xs text-red-500">
                                No Provider
                            </span>

                        @endif

                    </div>
                </td>

                {{-- Category --}}
                <td>

                    @if($s->category)

                        <span class="badge badge-info text-xs">
                            {{ $s->category->name }}
                        </span>

                    @else

                        <span class="badge badge-pending text-xs">
                            No Category
                        </span>

                    @endif

                </td>

                {{-- Price --}}
                <td>
                    <span class="font-semibold text-primary-600">
                        ${{ number_format($s->price, 2) }}
                    </span>
                </td>

                {{-- Bookings --}}
                <td>
                    <span class="badge badge-pending">
                        {{ $s->total_bookings ?? 0 }}
                    </span>
                </td>

                {{-- Rating --}}
                <td>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>

                        <span class="text-xs">
                            {{ $s->avg_rating ?? 0 }}
                        </span>
                    </div>
                </td>

                {{-- Status --}}
                <td>
                    <span class="badge {{ $s->status === 'active' ? 'badge-success' : 'badge-pending' }}">
                        {{ ucfirst($s->status) }}
                    </span>
                </td>

                {{-- Actions --}}
                <td>

                    <div class="flex items-center gap-1">

                        <a href="{{ route('admin.services.edit', $s->id) }}"
                           class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100">
                            <i class="fas fa-edit text-xs"></i>
                        </a>

                        <form method="POST"
                              action="{{ route('admin.services.destroy', $s->id) }}"
                              id="del-svc-{{ $s->id }}">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this service?')"
                                    class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100">

                                <i class="fas fa-trash text-xs"></i>

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>
                <td colspan="8" class="text-center py-14 text-gray-400">

                    <i class="fas fa-concierge-bell text-4xl mb-2 block"></i>

                    <p>No services found</p>

                    <a href="{{ route('admin.services.create') }}"
                       class="btn-primary text-xs mt-3 inline-flex">

                        <i class="fas fa-plus"></i>
                        Add First Service

                    </a>

                </td>
            </tr>

        @endforelse

        </tbody>

    </table>

    <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">
        {{ $services->withQueryString()->links() }}
    </div>

</div>

@endsection