@extends('layouts.admin.app')
@section('page_title','Update User')

@section('content')

<div class="card p-5 mb-6 flex justify-between items-center">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Update User
    </h2>

    <a href="{{ route('admin.users.index') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold">
        <i class="fas fa-angle-double-left mr-1"></i> Back
    </a>
</div>

<div class="card p-6">

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-5">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-5">

            <div>
                <label class="block mb-2">First Name <span class="text-red-500">*</span></label>
                <input name="first_name"
                       value="{{ old('first_name', $user->first_name) }}"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Last Name <span class="text-red-500">*</span></label>
                <input name="last_name"
                       value="{{ old('last_name', $user->last_name) }}"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Username <span class="text-red-500">*</span></label>
                <input name="username"
                       value="{{ old('username', $user->username) }}"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">User Type <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>user</option>
                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>customer</option>
                    <option value="provider" {{ old('role', $user->role) == 'provider' ? 'selected' : '' }}>provider</option>
                    <option value="handyman" {{ old('role', $user->role) == 'handyman' ? 'selected' : '' }}>handyman</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>admin</option>
                </select>
            </div>

            <div>
                <label class="block mb-2">Contact Number <span class="text-red-500">*</span></label>
                <div class="flex">
                    <span class="px-4 py-4 bg-gray-100 border border-r-0 rounded-l">
                        🇮🇳 +91
                    </span>
                    <input name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           required
                           class="w-full border rounded-r px-5 py-4 bg-white dark:bg-gray-800">
                </div>
            </div>

            <div>
                <label class="block mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ old('status', $user->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

        </div>

        <div class="mb-5">
            <label class="block mb-2">Address</label>
            <textarea name="address"
                      rows="4"
                      class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            <div>
                <label class="block mb-2">Select Country</label>
                <input name="country"
                       value="{{ old('country', $user->country) }}"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select State</label>
                <input name="state"
                       value="{{ old('state', $user->state) }}"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select City</label>
                <input name="city"
                       value="{{ old('city', $user->city) }}"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold">
                Update
            </button>
        </div>

    </form>
</div>

@endsection