@extends('layouts.public.app')

@section('title','My Profile')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-blue-50 to-indigo-50 py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            {{-- Sidebar --}}
            @include('customer.partials.sidebar')

            {{-- Profile Content --}}
            <div>

                <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-sky-500 to-indigo-600 p-8">

                        <h1 class="text-3xl font-bold text-white">
                            My Profile
                        </h1>

                        <p class="text-sky-100 mt-2">
                            Manage your personal information and account settings.
                        </p>

                    </div>

                    <div class="p-8">

                        @if($errors->any())
                            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
                                <ul class="list-disc ml-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST"
                              action="{{ route('customer.profile.update') }}"
                              enctype="multipart/form-data">

                            @csrf

                            {{-- Profile Image --}}
                            <div class="flex flex-col md:flex-row md:items-center gap-6 mb-10">

                                <img
                                    src="{{ $user->profile_image_url }}"
                                    alt="{{ $user->name }}"
                                    class="w-28 h-28 rounded-full object-cover border-4 border-sky-100">

                                <div>

                                    <label class="inline-flex items-center gap-2 px-5 py-3 bg-sky-50 text-sky-600 rounded-2xl cursor-pointer hover:bg-sky-100 transition">

                                        <i class="fas fa-camera"></i>

                                        Change Photo

                                        <input
                                            type="file"
                                            name="profile_image"
                                            accept="image/*"
                                            class="hidden">

                                    </label>

                                    <p class="text-sm text-gray-500 mt-3">
                                        JPG, PNG, WEBP allowed. Max 2MB.
                                    </p>

                                </div>

                            </div>

                            {{-- Personal Info --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        First Name
                                    </label>

                                    <input
                                        type="text"
                                        name="first_name"
                                        value="{{ old('first_name',$user->first_name) }}"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Last Name
                                    </label>

                                    <input
                                        type="text"
                                        name="last_name"
                                        value="{{ old('last_name',$user->last_name) }}"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        value="{{ $user->email }}"
                                        disabled
                                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone',$user->phone) }}"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                </div>

                            </div>

                            {{-- Address --}}
                            <div class="mt-6">

                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    rows="4"
                                    class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">{{ old('address',$user->address) }}</textarea>

                            </div>

                            {{-- Password Section --}}
                            <div class="mt-10 border-t pt-8">

                                <h3 class="text-xl font-bold text-gray-900 mb-6">
                                    Change Password
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            Current Password
                                        </label>

                                        <input
                                            type="password"
                                            name="current_password"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3">
                                    </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            New Password
                                        </label>

                                        <input
                                            type="password"
                                            name="new_password"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3">
                                    </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            Confirm Password
                                        </label>

                                        <input
                                            type="password"
                                            name="new_password_confirmation"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3">
                                    </div>

                                </div>

                            </div>

                            {{-- Buttons --}}
                            <div class="flex justify-end gap-4 mt-10">

                                <button
                                    type="reset"
                                    class="px-8 py-3 rounded-2xl border border-gray-300 text-gray-700 hover:bg-gray-50">

                                    Cancel

                                </button>

                                <button
                                    type="submit"
                                    class="px-8 py-3 rounded-2xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-semibold hover:shadow-lg transition">

                                    Save Changes

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection