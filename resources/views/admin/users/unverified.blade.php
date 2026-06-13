@extends('layouts.admin.app')

@section('title', 'Unverified Users')
@section('page_title', 'Unverified Users')

@section('content')

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-primary-600 text-white">
                    <th class="px-4 py-4 text-left">Name</th>
                    <th class="px-4 py-4 text-left">Joining Date</th>
                    <th class="px-4 py-4 text-left">Contact Number</th>
                    <th class="px-4 py-4 text-left">Address</th>
                    <th class="px-4 py-4 text-left">Total Points</th>
                    <th class="px-4 py-4 text-left">Current Points</th>
                    <th class="px-4 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center">Verify</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40">

                        <td class="px-4 py-5">
                            <div class="flex items-center gap-3">
                                <img src="{{ $user->profile_image_url ?? asset('images/default-user.png') }}"
                                     class="w-11 h-11 rounded-full object-cover">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $user->full_name ?? $user->name ?? 'User' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $user->email ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-5">
                            {{ optional($user->created_at)->format('F d, Y') }}
                            <br>
                            <span class="text-sm text-gray-500">
                                {{ optional($user->created_at)->format('g:i A') }}
                            </span>
                        </td>

                        <td class="px-4 py-5">
                            {{ $user->phone ?? '-' }}
                        </td>

                        <td class="px-4 py-5 max-w-xs">
                            {{ $user->address ?? '-' }}
                        </td>

                        <td class="px-4 py-5">
                            {{ $user->total_points ?? 0 }}
                        </td>

                        <td class="px-4 py-5">
                            {{ $user->current_points ?? 0 }}
                        </td>

                        <td class="px-4 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-lg text-sm font-medium bg-green-100 text-green-700">
                                {{ ucfirst($user->status ?? 'active') }}
                            </span>
                        </td>

                        <td class="px-4 py-5 text-center">
                            <form method="POST" action="{{ route('admin.unverified-users.verify', $user->id) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        onclick="return confirm('Verify this user?')"
                                        class="relative inline-flex h-6 w-12 items-center rounded-full bg-gray-300 transition hover:bg-primary-500">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition translate-x-1"></span>
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-12 text-gray-400">
                            No unverified users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">
    {{ $users->withQueryString()->links() }}
</div>

@endsection