@extends('layouts.public.app')
@section('title','Register as Provider')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4 py-12">
    <div class="w-full max-w-lg bg-gray-800 rounded-2xl p-8 shadow-2xl">

        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tools text-white text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white">Get started</h1>
            <p class="text-gray-400 text-sm mt-1">Register as Provider or Handyman</p>
        </div>

        @if($errors->any())
            <div class="bg-red-900/30 border border-red-500 text-red-300 px-4 py-3 rounded-xl mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('provider.register') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-primary-400 text-sm mb-1.5">Username *</label>
                <input name="username" value="{{ old('username') }}" required placeholder="Enter Username"
                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">First Name *</label>
                    <input name="first_name" value="{{ old('first_name') }}" required placeholder="Enter First Name"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Last Name *</label>
                    <input name="last_name" value="{{ old('last_name') }}" required placeholder="Enter Last Name"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-primary-400 text-sm mb-1.5">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter Email"
                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
            </div>

            <div class="mb-4">
                <label class="block text-primary-400 text-sm mb-1.5">Contact Number *</label>
                <div class="flex gap-2">
                    <span class="bg-gray-700 border border-gray-600 text-white rounded-xl px-3 py-3 text-sm flex items-center gap-1">
                        <span>🇮🇳</span> +91
                    </span>
                    <input name="phone" value="{{ old('phone') }}" required placeholder="Contact Number"
                           class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Password *</label>
                    <input type="password" name="password" required placeholder="Enter Password"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>
                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-primary-400 text-sm mb-1.5">User Type *</label>
                <select name="user_type" required
                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                    <option value="provider" {{ old('user_type') === 'provider' ? 'selected' : '' }}>Provider</option>
                    <option value="handyman" {{ old('user_type') === 'handyman' ? 'selected' : '' }}>Handyman</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-primary-400 text-sm mb-1.5">Select Zone *</label>
                <select name="zone_id" required
                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                    <option value="">Select Zone</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                            {{ $zone->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-primary-400 text-sm mb-1.5">Designation</label>
                <input name="designation" value="{{ old('designation') }}" placeholder="e.g. Manager"
                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
            </div>

            {{-- Document Upload Labels Fixed --}}
            {{-- DOCUMENTS SECTION --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                    Document Uploads
                </h3>
            
                <div class="grid grid-cols-2 gap-4">
            
                    <div>
                        <label class="block text-white font-medium mb-2">
                            Aadhar Card *
                        </label>
                        <input type="file"
                               name="aadhar_card"
                               required
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2">
                    </div>
            
                    <div>
                        <label class="block text-white font-medium mb-2">
                            Pan Card *
                        </label>
                        <input type="file"
                               name="pan_card"
                               required
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2">
                    </div>
            
                    <div>
                        <label class="block text-white font-medium mb-2">
                            Passport 
                        </label>
                        <input type="file"
                               name="passport"
                              
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2">
                    </div>
            
                    <div>
                        <label class="block text-white font-medium mb-2">
                            Driving Licence *
                        </label>
                        <input type="file"
                               name="driving_licence"
                               required
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2">
                    </div>
            
                </div>
            </div>

            <label class="flex items-start gap-3 mb-6 cursor-pointer">
                <input type="checkbox" name="terms" required class="mt-0.5 rounded text-primary-600">
                <span class="text-gray-300 text-sm">
                    I agree to the
                    <a href="{{ route('terms') }}" class="text-primary-400 hover:underline">Terms Of Service</a>
                    &amp;
                    <a href="{{ route('privacy') }}" class="text-primary-400 hover:underline">Privacy Policy</a>
                </span>
            </label>

            <button type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-xl font-semibold transition-colors">
                Create Account
            </button>

            <p class="text-center text-gray-400 text-sm mt-4">
                Already Have Account?
                <a href="{{ route('login') }}" class="text-primary-400 font-semibold hover:underline">Sign In</a>
            </p>
        </form>
    </div>
</div>
@endsection