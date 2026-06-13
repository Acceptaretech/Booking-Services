@extends('layouts.admin.app')
@section('page_title','Provider Request List')

@section('content')

<div class="card p-5 mb-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Provider Request List
    </h2>
</div>

<div class="card p-6">

    <div class="flex justify-between items-center mb-8">
        <div class="flex gap-4">
            <select class="bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded px-5 py-3 text-sm">
                <option>No Action</option>
                <option>Approve</option>
                <option>Reject</option>
            </select>

            <button class="bg-indigo-500 text-white px-6 py-3 rounded font-semibold">
                Apply
            </button>
        </div>

        <div class="relative">
            <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
            <input type="text"
                   placeholder="Search..."
                   class="pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded w-80 bg-white dark:bg-gray-800 text-sm">
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Joining Date</th>
                    <th class="p-4 text-left">Provider Commission</th>
                    <th class="p-4 text-left">Contact Number</th>
                    <th class="p-4 text-left">Shop</th>
                    <th class="p-4 text-left">Wallet Amount</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($providers as $provider)
                    <tr class="border-b dark:border-gray-700 odd:bg-gray-100 dark:odd:bg-gray-800">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $provider->image ? asset('storage/'.$provider->image) : asset('assets/admin/img/avatar.png') }}"
                                     class="w-11 h-11 rounded-full object-cover">

                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">
                                        {{ $provider->first_name ?? $provider->name }}
                                        {{ $provider->last_name ?? '' }}
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-300">
                                        {{ $provider->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4 text-gray-700 dark:text-gray-300">
                            {{ $provider->created_at ? $provider->created_at->format('F d, Y h:i A') : '-' }}
                        </td>

                        <td class="p-4 text-gray-700 dark:text-gray-300">
                            {{ $provider->commission ?? '-' }}
                        </td>

                        <td class="p-4 text-gray-700 dark:text-gray-300">
                            {{ $provider->phone ?? $provider->contact_number ?? '-' }}
                        </td>

                        <td class="p-4 font-bold">
                            {{ $provider->shop_count ?? 0 }}
                        </td>

                        <td class="p-4 font-bold">
                            ${{ number_format($provider->wallet_amount ?? 0, 2) }}
                        </td>

                        <td class="p-4">
                            <form method="POST" action="{{ route('admin.providers.approve', $provider->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded font-semibold">
                                    <i class="fas fa-check mr-1"></i> Approve
                                </button>
                            </form>
                        </td>

                        <td class="p-4">
                            <div class="flex gap-3 items-center">
                                <a href="{{ route('admin.providers.show', $provider->id) }}"
                                   class="text-green-500">
                                    <i class="fas fa-lock"></i>
                                </a>

                                <a href="{{ route('admin.providers.edit', $provider->id) }}"
                                   class="text-blue-400">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.providers.reject', $provider->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400">
                            No provider requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $providers->links() }}
    </div>

</div>

@endsection