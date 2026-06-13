@extends('layouts.admin.app')

@section('title', 'All Users')
@section('page_title', 'All Users')

@section('content')

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search users..."
                class="form-input pl-8 py-2 w-56 text-xs">
        </div>

        <select name="status" class="form-select text-xs py-2 w-36" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-primary-600 text-white">
                    <th class="px-4 py-4 text-left">Name</th>
                    <th class="px-4 py-4 text-left">User Type</th>
                    <th class="px-4 py-4 text-left">Joining Date</th>
                    <th class="px-4 py-4 text-left">Contact Number</th>
                    <th class="px-4 py-4 text-left">Address</th>
                    <th class="px-4 py-4 text-left">Total Points</th>
                    <th class="px-4 py-4 text-left">Current Points</th>
                    <th class="px-4 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    @php
                        $status = $user->status ?? 'inactive';

                        $statusClasses = [
                            'active'   => 'bg-green-100 text-green-700',
                            'pending'  => 'bg-yellow-100 text-yellow-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            'inactive' => 'bg-red-100 text-red-700',
                        ];

                        $fullName = $user->full_name
                            ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))
                            ?: ($user->name ?? 'User');
                    @endphp

                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                        <td class="px-4 py-5">
                            <div class="flex items-center gap-3">
                                <img
                                    src="{{ $user->profile_image_url ?? asset('images/default-user.png') }}"
                                    class="w-11 h-11 rounded-full object-cover bg-gray-100"
                                    alt="User">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $fullName }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $user->email ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            {{ ucfirst($user->role ?? $user->user_type ?? 'user') }}
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            {{ optional($user->created_at)->format('F d, Y') }}
                            <br>
                            <span class="text-sm text-gray-500">
                                {{ optional($user->created_at)->format('g:i A') }}
                            </span>
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            {{ $user->phone ?? '-' }}
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300 max-w-xs">
                            {{ $user->address ?? '-' }}
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            {{ $user->total_points ?? 0 }}
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            {{ $user->current_points ?? 0 }}
                        </td>

                        <td class="px-4 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-lg text-sm font-medium {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>

                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-3">
                        
                               {{--}} <form method="POST"
                                      action="{{ route('admin.users.toggle', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                        
                                    <button type="submit"
                                            class="{{ $status === 'active' ? 'text-green-600' : 'text-gray-400' }}"
                                            title="Toggle Status">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                </form> --}} 
                        
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="text-blue-400 hover:text-blue-600"
                                   title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                        
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user->id) }}"
                                      onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                        
                                    <button type="submit" class="text-red-500 hover:text-red-600" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                        
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-12 text-gray-400">
                            <i class="fas fa-users text-4xl mb-3 block"></i>
                            No users found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
    <div class="mt-5">
        {{ $users->withQueryString()->links() }}
    </div>
@endif

@endsection