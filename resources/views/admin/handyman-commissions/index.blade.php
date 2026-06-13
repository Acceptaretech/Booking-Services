@extends('layouts.admin.app')
@section('page_title','Handyman Commission List')

@section('content')

<div class="card p-5 mb-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Handyman Commission List
    </h2>
</div>

<div class="card p-6">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-8 flex-wrap gap-4">

        <form method="POST" action="{{ route('admin.handyman-commissions.bulk') }}" id="bulkForm" class="flex gap-4">
            @csrf

            <select name="action" class="bg-gray-200 dark:bg-gray-700 rounded px-5 py-3 text-sm">
                <option value="">No Action</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="delete">Delete</option>
            </select>

            <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded font-semibold">
                Apply
            </button>
        </form>

        <form method="GET" action="{{ route('admin.handyman-commissions.index') }}" class="flex gap-4">

            <select name="status" class="border rounded px-5 py-3 text-sm bg-white dark:bg-gray-800">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="pl-11 pr-4 py-3 border rounded w-44 bg-white dark:bg-gray-800 text-sm">
            </div>

            <button class="bg-indigo-600 text-white px-5 py-3 rounded">
                Search
            </button>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border rounded-xl overflow-hidden">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="p-4 text-left">
                        <input type="checkbox"
                               onclick="document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked)">
                    </th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Commission</th>
                    <th class="p-4 text-left">Created By</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($commissions as $commission)
                    <tr class="border-b odd:bg-gray-100 dark:odd:bg-gray-800">
                        <td class="p-4">
                            <input type="checkbox"
                                   form="bulkForm"
                                   class="row-check"
                                   name="ids[]"
                                   value="{{ $commission->id }}">
                        </td>

                        <td class="p-4">
                            <span class="text-indigo-600 font-medium">
                                {{ $commission->name }}
                            </span>
                        </td>

                        <td class="p-4">
                            @if($commission->type === 'fixed')
                                ₹{{ number_format($commission->commission, 2) }}
                            @else
                                {{ $commission->commission }}%
                            @endif
                        </td>

                        <td class="p-4">
                            {{ $commission->created_by ?? 'Super Admin' }}
                        </td>

                        <td class="p-4">
                            <form method="POST" action="{{ route('admin.handyman-commissions.toggle', $commission->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="w-14 h-7 rounded-full relative {{ $commission->status == 'active' ? 'bg-indigo-600' : 'bg-gray-300' }}">
                                    <span class="absolute top-1 w-5 h-5 bg-white rounded-full transition-all {{ $commission->status == 'active' ? 'right-1' : 'left-1' }}"></span>
                                </button>
                            </form>
                        </td>

                        <td class="p-4">
                            <form method="POST"
                                  action="{{ route('admin.handyman-commissions.destroy', $commission->id) }}"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-500">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">
                            No commission records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $commissions->links() }}
    </div>

</div>

@endsection