@extends('layouts.provider.app')

@section('page_title','Provider Profile')

@section('content')
<div class="max-w-7xl mx-auto">
   

    @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-100 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <a href="{{ route('provider.profile') }}"
                class="block px-5 py-4 rounded-xl {{ request()->routeIs('provider.profile') ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-600' }}">
                 PROFILE
             </a>
             
             <a href="{{ route('provider.profile.change-password') }}"
                class="mt-4 block px-5 py-4 rounded-xl {{ request()->routeIs('provider.profile.change-password') ? 'bg-indigo-600 text-white' : 'bg-indigo-50 text-indigo-600' }}">
                 CHANGE PASSWORD
             </a>
            </div>
        </div>

        <div class="lg:col-span-9">
            <div class="bg-white rounded-2xl p-8 shadow-sm">
                <form action="{{ route('provider.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <img src="{{ $provider->profile_image ? asset('storage/'.$provider->profile_image) : asset('default-user.png') }}"
                                 class="w-28 h-28 rounded-full object-cover mx-auto bg-gray-200">

                            <h3 class="mt-4 text-lg font-medium text-gray-800">
                                {{ $provider->first_name }} {{ $provider->last_name }}
                            </h3>

                            <input type="file" name="profile_image"
                                   class="mt-5 block w-full text-sm border rounded-lg p-2">
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="text-sm font-medium">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name', $provider->first_name) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name', $provider->last_name) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="username" value="{{ old('username', $provider->username) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Designation</label>
                                <input type="text" name="designation" value="{{ old('designation', $provider->designation) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-sm font-medium">Address</label>
                                <textarea name="address" rows="3"
                                          class="mt-2 w-full rounded-lg border px-4 py-3">{{ old('address', $provider->address) }}</textarea>
                            </div>

                            <div>
                                <label class="text-sm font-medium">Country</label>
                                <input type="text" name="country" value="{{ old('country', $provider->country) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">State</label>
                                <input type="text" name="state" value="{{ old('state', $provider->state) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">City</label>
                                <input type="text" name="city" value="{{ old('city', $provider->city) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email', $provider->email) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Contact Number <span class="text-red-500">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone', $provider->phone) }}"
                                       class="mt-2 w-full rounded-lg border px-4 py-3">
                            </div>

                            <div>
                                <label class="text-sm font-medium">Status</label>
                                <select name="status" class="mt-2 w-full rounded-lg border px-4 py-3">
                                    <option value="active" {{ $provider->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $provider->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="pending" {{ $provider->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ $provider->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit"
                                        class="px-8 py-3 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="passwordBox" class="hidden mt-10 border-t pt-8">
                    <h3 class="text-lg font-semibold mb-5">Change Password</h3>

                    <form action="{{ route('provider.profile.password') }}" method="POST"
                          class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        @csrf

                        <input type="password" name="current_password" placeholder="Current Password"
                               class="rounded-lg border px-4 py-3">

                        <input type="password" name="password" placeholder="New Password"
                               class="rounded-lg border px-4 py-3">

                        <input type="password" name="password_confirmation" placeholder="Confirm Password"
                               class="rounded-lg border px-4 py-3">

                        <div class="md:col-span-3">
                            <button class="px-8 py-3 rounded-lg bg-gray-900 text-white font-semibold">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection