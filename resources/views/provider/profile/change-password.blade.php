@extends('layouts.provider.app')

@section('page_title','Change Password')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    <div class="lg:col-span-3">
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <a href="{{ route('provider.profile') }}"
               class="block px-5 py-4 rounded-xl bg-indigo-50 text-indigo-600">
                PROFILE
            </a>

            <a href="{{ route('provider.profile.change-password') }}"
               class="mt-4 block px-5 py-4 rounded-xl bg-indigo-600 text-white">
                CHANGE PASSWORD
            </a>
        </div>
    </div>

    <div class="lg:col-span-9">
        <div class="bg-white rounded-2xl p-8 shadow-sm">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('provider.profile.password') }}" method="POST" class="max-w-xl mx-auto space-y-6">
                @csrf

                <div>
                    <label class="block mb-2 text-sm font-medium">Old Password <span class="text-red-500">*</span></label>
                    <input type="password" name="current_password" placeholder="Old Password"
                           class="w-full rounded-xl border px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">New Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" placeholder="New Password"
                           class="w-full rounded-xl border px-4 py-3">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium">Confirm New Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" placeholder="Confirm New Password"
                           class="w-full rounded-xl border px-4 py-3">
                </div>

                <div class="text-right">
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection