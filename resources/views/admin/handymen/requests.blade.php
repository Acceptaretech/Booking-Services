@extends('layouts.admin.app')
@section('page_title','Handyman Request List')

@section('content')

<div class="card p-5 mb-6">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Handyman Request List
    </h2>
</div>

<div class="card p-6">

    @if(session('success'))
        <div class="mb-5 rounded-lg bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 rounded-lg bg-red-100 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <form method="POST"
              action="{{ route('admin.handymen.requests.bulk') }}"
              id="bulkForm"
              class="flex gap-4"
              onsubmit="return validateBulkAction()">
            @csrf

            <select name="action"
                    class="bg-gray-200 dark:bg-gray-700 rounded-lg px-5 py-3 text-sm">
                <option value="">No Action</option>
                <option value="accept">Accept</option>
                <option value="reject">Reject</option>
            </select>

            <button type="submit"
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold">
                Apply
            </button>
        </form>

        <form method="GET"
              action="{{ route('admin.handymen.requests') }}"
              class="flex gap-3">
            <div class="relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search..."
                       class="pl-11 pr-4 py-3 border rounded-lg w-72 bg-white dark:bg-gray-800 text-sm">
            </div>

            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-lg">
                Search
            </button>

            <a href="{{ route('admin.handymen.requests') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg">
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
                    <th class="p-4 text-left">Joining Date</th>
                    <th class="p-4 text-left">Provider</th>
                    <th class="p-4 text-left">Contact Number</th>
                    <th class="p-4 text-left">Address</th>
                    <th class="p-4 text-left">Wallet Amount</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($requests as $requestUser)
                    <tr class="border-b odd:bg-gray-100 dark:odd:bg-gray-800">
                        <td class="p-4">
                            <input type="checkbox"
                                   form="bulkForm"
                                   class="row-check"
                                   name="ids[]"
                                   value="{{ $requestUser->id }}">
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $requestUser->profile_image ? asset('storage/'.$requestUser->profile_image) : asset('assets/admin/img/avatar.png') }}"
                                     class="w-11 h-11 rounded-full object-cover border"
                                     onerror="this.onerror=null;this.src='{{ asset('assets/admin/img/avatar.png') }}';">

                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">
                                        {{ $requestUser->first_name }}
                                        {{ $requestUser->last_name }}
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-300">
                                        {{ $requestUser->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="p-4">
                            {{ $requestUser->created_at ? $requestUser->created_at->format('F d, Y h:i A') : '-' }}
                        </td>

                        <td class="p-4">-</td>

                        <td class="p-4">
                            {{ $requestUser->phone ?? '-' }}
                        </td>

                        <td class="p-4">
                            {{ $requestUser->address ?? '-' }}
                        </td>

                        <td class="p-4 font-bold">
                            ₹{{ number_format($requestUser->wallet_amount ?? 0, 2) }}
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <form method="POST"
                                      action="{{ route('admin.handymen.requests.accept', $requestUser->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                        Accept
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.handymen.requests.reject', $requestUser->id) }}"
                                      onsubmit="return confirm('Reject this handyman request?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400">
                            No handyman requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $requests->links() }}
    </div>

</div>

<script>
function validateBulkAction() {
    const action = document.querySelector('#bulkForm select[name="action"]').value;
    const checked = document.querySelectorAll('.row-check:checked').length;

    if (!action) {
        alert('Please select an action.');
        return false;
    }

    if (checked === 0) {
        alert('Please select at least one handyman.');
        return false;
    }

    return true;
}
</script>

@endsection