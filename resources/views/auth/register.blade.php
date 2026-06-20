{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.public.app')

@section('title', 'Register')

@section('content')

<div class="min-h-screen bg-slate-950 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12 relative overflow-hidden">

    <div class="absolute w-56 h-56 sm:w-72 sm:h-72 bg-primary-600/40 rounded-full blur-3xl -top-20 -left-20"></div>
    <div class="absolute w-72 h-72 sm:w-96 sm:h-96 bg-purple-600/30 rounded-full blur-3xl -bottom-32 -right-32"></div>

    <div class="w-full max-w-md sm:max-w-xl lg:max-w-2xl bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl sm:rounded-3xl p-5 sm:p-8 shadow-2xl relative z-10">

        <div class="text-center mb-6 sm:mb-8">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-primary-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="fas fa-user-plus text-white text-xl sm:text-2xl"></i>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-white">Create Account</h1>
            <p class="text-slate-400 text-xs sm:text-sm mt-2">Join us and start booking trusted services</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/15 border border-red-400/40 text-red-200 px-4 py-3 rounded-xl mb-5 text-xs sm:text-sm">
                <i class="fas fa-circle-exclamation mr-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-slate-200 text-sm font-medium mb-2">First Name *</label>
                    <input name="first_name" value="{{ old('first_name') }}" required placeholder="Enter first name"
                           class="w-full bg-white/10 border border-white/10 text-white placeholder:text-slate-400 rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                </div>

                <div>
                    <label class="block text-slate-200 text-sm font-medium mb-2">Last Name *</label>
                    <input name="last_name" value="{{ old('last_name') }}" required placeholder="Enter last name"
                           class="w-full bg-white/10 border border-white/10 text-white placeholder:text-slate-400 rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-slate-200 text-sm font-medium mb-2">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email address"
                           class="w-full bg-white/10 border border-white/10 text-white placeholder:text-slate-400 rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-slate-200 text-sm font-medium mb-2">Contact Number</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <span class="bg-white/10 border border-white/10 text-white rounded-xl px-4 py-3 text-sm flex items-center justify-center sm:justify-start gap-2">
                            🇮🇳 +91
                        </span>

                        <input name="phone" value="{{ old('phone') }}" placeholder="Enter contact number"
                               class="flex-1 bg-white/10 border border-white/10 text-white placeholder:text-slate-400 rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                    </div>
                </div>

                <div>
                    <label class="block text-slate-200 text-sm font-medium mb-2">Password *</label>
                    <input type="password" name="password" required placeholder="Enter password"
                           class="w-full bg-white/10 border border-white/10 text-white placeholder:text-slate-400 rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                </div>

                <div>
                    <label class="block text-slate-200 text-sm font-medium mb-2">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Confirm password"
                           class="w-full bg-white/10 border border-white/10 text-white placeholder:text-slate-400 rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30">
                </div>

            </div>

            <button type="submit"
                    class="w-full mt-6 bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 text-white py-3 rounded-xl font-semibold shadow-lg transition">
                <i class="fas fa-user-plus mr-2"></i>
                Create Account
            </button>

            <p class="text-center text-slate-400 text-sm mt-5">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary-300 font-semibold hover:underline">Sign In</a>
            </p>

            <p class="text-center mt-2">
                <a href="{{ route('provider.register') }}" class="text-slate-500 text-xs hover:text-primary-300">
                    Register as Provider or Technician
                </a>
            </p>
        </form>
    </div>
</div>

@endsection