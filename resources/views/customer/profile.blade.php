@extends('layouts.public.app')
@section('title','My Profile')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">My Profile</h1>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-8">
        @if(session('success'))<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('POST')
            <div class="flex items-center gap-5 mb-8">
                <img src="{{ $user->profile_image_url }}" class="w-20 h-20 rounded-2xl object-cover" alt="">
                <div><label class="cursor-pointer bg-primary-50 dark:bg-primary-900/20 text-primary-600 px-4 py-2 rounded-xl text-sm font-medium hover:bg-primary-100 transition-colors">
                    <i class="fas fa-camera mr-1"></i> Change Photo
                    <input type="file" name="profile_image" class="hidden" accept="image/*">
                </label></div>
            </div>
            <div class="grid grid-cols-2 gap-5 mb-5">
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">First Name</label>
                <input name="first_name" value="{{ old('first_name',$user->first_name) }}" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Last Name</label>
                <input name="last_name" value="{{ old('last_name',$user->last_name) }}" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500"></div>
            </div>
            <div class="mb-5"><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
            <input value="{{ $user->email }}" disabled class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400"></div>
            <div class="mb-5"><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Phone</label>
            <input name="phone" value="{{ old('phone',$user->phone) }}" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500"></div>
            <div class="mb-8"><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Address</label>
            <textarea name="address" rows="2" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500 resize-none">{{ old('address',$user->address) }}</textarea></div>
            <div class="border-t border-gray-100 dark:border-gray-700 pt-6 mb-5"><h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-4">Change Password</h3>
            <div class="grid grid-cols-1 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Current Password</label>
                <input type="password" name="current_password" placeholder="Enter current password" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">New Password</label>
                    <input type="password" name="new_password" placeholder="New password" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500"></div>
                    <div><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Confirm Password</label>
                    <input type="password" name="new_password_confirmation" placeholder="Confirm password" class="w-full border border-gray-200 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500"></div>
                </div>
            </div></div>
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-xl font-semibold transition-colors">Save Changes</button>
        </form>
    </div>
</div>
@endsection
