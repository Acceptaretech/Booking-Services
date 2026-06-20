@extends('layouts.admin.app')
@section('page_title','Technician List')

@section('content')

<div class="card p-5 mb-6 flex justify-between items-center">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Technician List
    </h2>

    <a href="{{ route('admin.handymen.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
        <i class="fas fa-plus-circle mr-1"></i> New
    </a>
</div>

<div class="card p-6">

    {{--@if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="flex justify-between items-center mb-8 gap-4 flex-wrap">

        <form method="POST" action="{{ route('admin.handymen.bulk') }}" id="bulkForm" class="flex gap-4">
            @csrf

            <select name="action" required class="bg-gray-200 dark:bg-gray-700 rounded px-5 py-3 text-sm">
                <option value="">No Action</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="delete">Delete</option>
            </select>

            <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded font-semibold">
                Apply
            </button>
        </form>

        <form method="GET" action="{{ route('admin.handymen.index') }}" class="flex gap-3">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="pl-11 pr-4 py-3 border rounded w-72 bg-white dark:bg-gray-800 text-sm">
            </div>

            <button class="bg-indigo-600 text-white px-5 py-3 rounded">
                Search
            </button>

            <a href="{{ route('admin.handymen.index') }}"
               class="bg-gray-500 text-white px-5 py-3 rounded">
                Reset
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="p-4 text-left">
                        <input type="checkbox"
                               onclick="document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked)">
                    </th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Joining Date</th>
                    <th class="p-4 text-left">Provider</th>
                    <th class="p-4 text-left">Contact Number</th>
                    <th class="p-4 text-left">Address</th>
                    <th class="p-4 text-left">Wallet Amount</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($handymen as $handyman)
                    <tr class="border-b odd:bg-gray-100 dark:odd:bg-gray-800">
                        <td class="p-4">
                            <input type="checkbox"
                                   form="bulkForm"
                                   class="row-check"
                                   name="ids[]"
                                   value="{{ $handyman->id }}">
                        </td>
                        
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                        
                                <img
                                    src="{{ !empty($handyman->profile_image)
                                        ? asset('storage/' . $handyman->profile_image)
                                        : asset('assets/admin/img/avatar.png') }}"
                                    alt="Profile"
                                    class="w-14 h-14 rounded-full object-cover border border-gray-300"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/admin/img/avatar.png') }}';"
                                >
                        
                                <div>
                                    <h6 class="font-semibold text-gray-900">
                                        {{ $handyman->first_name }} {{ $handyman->last_name }}
                                    </h6>
                        
                                    <p class="text-sm text-gray-500">
                                        {{ $handyman->email }}
                                    </p>
                                </div>
                        
                            </div>
                        </td>
                        <td class="p-4">
                            {{ $handyman->created_at ? $handyman->created_at->format('F d, Y h:i A') : '-' }}
                        </td>

                        <td class="p-4">
                            @if($handyman->provider)
                                <div>
                                    <p class="font-semibold">
                                        {{ $handyman->provider->first_name }} {{ $handyman->provider->last_name }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $handyman->provider->email }}
                                    </p>
                                </div>
                            @else
                                <span class="text-gray-400">No Provider</span>
                            @endif
                        </td>

                        <td class="p-4">
                            {{ $handyman->phone ?? '-' }}
                        </td>

                        <td class="p-4">
                            {{ $handyman->address ?? '-' }}
                        </td>

                        <td class="p-4 font-bold">
                            ₹{{ number_format($handyman->wallet_amount ?? 0, 2) }}
                        </td>

                        <td class="p-4">
                            <span class="px-4 py-2 rounded bg-green-100 text-green-600 font-semibold">
                                {{ ucfirst($handyman->status ?? 'active') }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.handymen.edit', $handyman->id) }}"
                                   class="text-blue-400">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.handymen.destroy', $handyman->id) }}"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-8 text-center text-gray-400">
                            No handymen found.
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