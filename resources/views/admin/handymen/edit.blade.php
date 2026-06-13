@extends('layouts.admin.app')
@section('page_title','Update Handyman')

@section('content')

<div class="card p-5 mb-6 flex justify-between items-center">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Update Handyman</h2>

    <a href="{{ route('admin.handymen.index') }}"
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

    <form method="POST"
          action="{{ route('admin.handymen.update', $user->id) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-5">

            <div>
                <label class="block mb-2">First Name <span class="text-red-500">*</span></label>
                <input name="first_name" value="{{ old('first_name', $user->first_name) }}" required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Last Name <span class="text-red-500">*</span></label>
                <input name="last_name" value="{{ old('last_name', $user->last_name) }}" required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Username <span class="text-red-500">*</span></label>
                <input name="username" value="{{ old('username', $user->username) }}" required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep old password"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select Providers</label>
                <select name="provider_id" class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="">Select Providers</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}"
                            {{ old('provider_id', $user->handyman->provider_id ?? '') == $provider->id ? 'selected' : '' }}>
                            {{ $provider->first_name }} {{ $provider->last_name }} - {{ $provider->email }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2">Commission Type <span class="text-red-500">*</span></label>
                <select name="commission_type" required class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="percent" {{ old('commission_type', $user->handyman->commission_type ?? 'percent') == 'percent' ? 'selected' : '' }}>Percent</option>
                    <option value="fixed" {{ old('commission_type', $user->handyman->commission_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                </select>
            </div>

            <div>
                <label class="block mb-2">Commission <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="commission"
                       value="{{ old('commission', $user->handyman->commission ?? 0) }}" required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Contact Number <span class="text-red-500">*</span></label>
                <div class="flex">
                    <span class="px-4 py-4 bg-gray-100 border border-r-0 rounded-l">🇮🇳 +91</span>
                    <input name="phone" value="{{ old('phone', $user->phone) }}" required
                           class="w-full border rounded-r px-5 py-4 bg-white dark:bg-gray-800">
                </div>
            </div>

            <div>
                <label class="block mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="pending" {{ old('status', $user->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <div>
                <label class="block mb-2">Profile Image</label>

                @if($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}"
                         class="w-20 h-20 rounded-full object-cover mb-3 border">
                @endif

                <input type="file" name="profile_image" accept="image/*"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>
        </div>

        <div class="mb-5">
            <label class="block mb-2">Address</label>
            <textarea name="address" rows="4"
                      class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">{{ old('address', $user->handyman->address ?? $user->address) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            <div>
                <label class="block mb-2">Select Country</label>
                <input name="country" value="{{ old('country', $user->handyman->country ?? $user->country) }}"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select State</label>
                <input name="state" value="{{ old('state', $user->handyman->state ?? $user->state) }}"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select City</label>
                <input name="city" value="{{ old('city', $user->handyman->city ?? $user->city) }}"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold">
                Update
            </button>
        </div>

    </form>
</div>

@endsection