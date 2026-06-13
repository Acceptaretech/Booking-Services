@extends('layouts.admin.app')
@section('page_title','Provider Commission List')

@section('content')

<div class="card p-5 mb-6 flex justify-between items-center">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Provider Commission List
    </h2>
</div>

<div class="card p-6">

   {{--}} @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif --}}

    <div class="flex justify-between items-center mb-5 gap-4 flex-wrap">


        <form method="GET" action="{{ route('admin.providers.commissions') }}" class="flex gap-4">

            <select name="status" class="border rounded px-5 py-3 text-sm bg-white dark:bg-gray-800">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="pl-11 pr-4 py-3 border rounded w-44 bg-white dark:bg-gray-800 text-sm">
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-5 py-3 rounded font-semibold">
                Search
            </button>

            <a href="{{ route('admin.providers.commissions') }}"
               class="bg-gray-500 text-white px-5 py-3 rounded font-semibold">
                Reset
            </a>
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
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($providers as $provider)
                    <tr class="border-b odd:bg-gray-100 dark:odd:bg-gray-800">
                        <td class="p-4">
                            <input type="checkbox"
                                   form="bulkForm"
                                   class="row-check"
                                   name="ids[]"
                                   value="{{ $provider->id }}">
                        </td>

                        <td class="p-4">
                            <span class="text-indigo-600 font-medium">
                                {{ $provider->first_name ?? $provider->name ?? 'Provider' }}
                                {{ $provider->last_name ?? '' }}
                            </span>
                            <div class="text-xs text-gray-500">
                                {{ $provider->email ?? '' }}
                            </div>
                        </td>

                        <td class="p-4 text-gray-800 dark:text-gray-200">
                            @if(($provider->commission_type ?? '') == 'fixed')
                                ₹{{ number_format($provider->commission ?? 0, 2) }}
                            @else
                                {{ $provider->commission ?? 0 }}%
                            @endif
                        </td>

                        <td class="p-4">
                            <form method="POST" action="{{ route('admin.providers.commissions.toggle', $provider->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="w-14 h-7 rounded-full relative {{ ($provider->status ?? 'active') == 'active' ? 'bg-indigo-600' : 'bg-gray-300' }}">
                                    <span class="absolute top-1 w-5 h-5 bg-white rounded-full transition-all {{ ($provider->status ?? 'active') == 'active' ? 'right-1' : 'left-1' }}"></span>
                                </button>
                            </form>
                        </td>

                        <td class="p-4">
                            <form method="POST"
                                  action="{{ route('admin.providers.commissions.delete', $provider->id) }}"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-500">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            No commission records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-5">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Total: {{ $providers->total() }}
        </div>

        <div>
            {{ $providers->links() }}
        </div>
    </div>

</div>

@endsection