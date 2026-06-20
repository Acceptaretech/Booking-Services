{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="{{ session('theme','light') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In | {{ config('app.name','HandyMan') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca'
                        }
                    }
                }
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Inter, system-ui, sans-serif;
        }

        .glass {
            background: rgba(255,255,255,.12);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,.18);
        }

        .blob {
            position: absolute;
            border-radius: 999px;
            filter: blur(80px);
            opacity: .45;
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden bg-slate-950 text-white">

<div class="blob w-72 h-72 bg-primary-600 top-[-80px] left-[-80px]"></div>
<div class="blob w-96 h-96 bg-purple-600 bottom-[-140px] right-[-120px]"></div>
<div class="blob w-72 h-72 bg-cyan-500 top-[35%] right-[20%]"></div>

<div class="relative min-h-screen grid grid-cols-1 lg:grid-cols-2">

    {{-- Left Section --}}
    <div class="hidden lg:flex flex-col justify-center px-16">
        <div class="max-w-xl">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center mb-8 shadow-xl">
                <i class="fas fa-tools text-2xl"></i>
            </div>

            <h1 class="text-5xl font-extrabold leading-tight mb-5">
                Welcome Back to <br>
                <span class="text-primary-400">{{ config('app.name','HandyMan') }}</span>
            </h1>

            <p class="text-slate-300 text-lg leading-relaxed mb-8">
                Manage bookings, providers, customers, services, packages and addons from one powerful dashboard.
            </p>

            <div class="grid grid-cols-3 gap-4">
                <div class="glass rounded-2xl p-4">
                    <i class="fas fa-calendar-check text-primary-300 text-xl mb-3"></i>
                    <p class="text-sm text-slate-200">Smart Booking</p>
                </div>

                <div class="glass rounded-2xl p-4">
                    <i class="fas fa-user-tie text-primary-300 text-xl mb-3"></i>
                    <p class="text-sm text-slate-200">Provider Panel</p>
                </div>

                <div class="glass rounded-2xl p-4">
                    <i class="fas fa-chart-line text-primary-300 text-xl mb-3"></i>
                    <p class="text-sm text-slate-200">Live Reports</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Login Section --}}
    <div class="flex items-center justify-center p-5">
        <div class="w-full max-w-md glass rounded-3xl p-8 shadow-2xl">

            @php
            $loginType = request()->is('admin/login') ? 'Admin' :
                        (request()->is('provider/login') ? 'Provider' :
                        (request()->is('technician/login') ? 'Technician' : 'Customer'));
        @endphp

        <div class="text-center mb-7">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center mx-auto mb-4 shadow-lg">

                @if($loginType == 'Admin')
                    <i class="fas fa-user-shield text-white text-2xl"></i>
                @elseif($loginType == 'Provider')
                    <i class="fas fa-user-tie text-white text-2xl"></i>
                @elseif($loginType == 'Technician')
                    <i class="fas fa-hard-hat text-white text-2xl"></i>
                @else
                    <i class="fas fa-user text-white text-2xl"></i>
                @endif

            </div>

            <h2 class="text-3xl font-bold">
                {{ $loginType }} Login
            </h2>

            <p class="text-slate-300 text-sm mt-2">
                Login to continue to your dashboard
            </p>
</div>

            @if($errors->any())
                <div class="bg-red-500/15 border border-red-400/40 text-red-200 px-4 py-3 rounded-xl mb-4 text-sm">
                    <i class="fas fa-circle-exclamation mr-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="bg-emerald-500/15 border border-emerald-400/40 text-emerald-200 px-4 py-3 rounded-xl mb-4 text-sm">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if(request()->is('admin/login'))
                    <input type="hidden" name="login_role" value="admin">
                @elseif(request()->is('provider/login'))
                    <input type="hidden" name="login_role" value="provider">
                @elseif(request()->is('technician/login'))
                    <input type="hidden" name="login_role" value="handyman">
                @else
                    <input type="hidden" name="login_role" value="customer">
                @endif
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-200 mb-2">
                        Email Address
                    </label>

                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-3.5 text-slate-400 text-sm"></i>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="customer@demo.com"
                            class="w-full bg-white/10 border border-white/10 rounded-xl pl-11 pr-4 py-3 text-sm text-white placeholder:text-slate-400 outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30 transition">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-200 mb-2">
                        Password
                    </label>

                    <div class="relative">
                        <i class="fas fa-key absolute left-4 top-3.5 text-slate-400 text-sm"></i>

                        <input
                            type="password"
                            name="password"
                            id="passInput"
                            required
                            placeholder="password"
                            class="w-full bg-white/10 border border-white/10 rounded-xl pl-11 pr-12 py-3 text-sm text-white placeholder:text-slate-400 outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-500/30 transition">

                        <button
                            type="button"
                            onclick="togglePass()"
                            class="absolute right-4 top-3.5 text-slate-400 hover:text-white">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-5">
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-300">
                        <input type="checkbox" name="remember" class="rounded text-primary-600">
                        Remember me
                    </label>

                    <a href="{{ route('password.request') }}" class="text-sm text-primary-300 hover:text-primary-200">
                        Forgot Password?
                    </a>
                </div>

             {{--   <div class="grid grid-cols-2 gap-2 mb-5">
                    <button type="button" onclick="fillDemo('customer@demo.com','password')" class="demo-btn">
                        <i class="fas fa-user"></i> Customer
                    </button>

                    <button type="button" onclick="fillDemo('admin@demo.com','password')" class="demo-btn">
                        <i class="fas fa-user-shield"></i> Admin
                    </button>

                    <button type="button" onclick="fillDemo('provider@demo.com','password')" class="demo-btn">
                        <i class="fas fa-user-tie"></i> Provider
                    </button>

                    <button type="button" onclick="fillDemo('handyman@demo.com','password')" class="demo-btn">
                        <i class="fas fa-hard-hat"></i> Handyman
                    </button>
                </div> --}}  
                <div class="mb-5">

                    @if(request()->is('admin/login'))
                
                        <button type="button"
                                onclick="fillDemo('admin@demo.com','password')"
                                class="demo-btn">
                            <i class="fas fa-user-shield"></i>
                            Admin Login
                        </button>
                
                    @elseif(request()->is('provider/login'))
                
                        <button type="button"
                                onclick="fillDemo('provider@demo.com','password')"
                                class="demo-btn">
                            <i class="fas fa-user-tie"></i>
                            Provider Login
                        </button>
                
                    @elseif(request()->is('technician/login'))
                
                        <button type="button"
                                onclick="fillDemo('handyman@demo.com','password')"
                                class="demo-btn">
                            <i class="fas fa-hard-hat"></i>
                            Technician Login
                        </button>
                
                    @else
                
                        <button type="button"
                                onclick="fillDemo('customer@demo.com','password')"
                                class="demo-btn">
                            <i class="fas fa-user"></i>
                            Customer Login
                        </button>
                
                    @endif
                
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-primary-600 to-purple-600 hover:from-primary-700 hover:to-purple-700 text-white py-3 rounded-xl font-semibold shadow-lg shadow-primary-600/30 transition">
                    <i class="fas fa-right-to-bracket mr-2"></i>
                    Login
                </button>

                @if(request()->is('login'))

                <p class="text-center text-slate-300 text-sm mt-5">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-primary-300 font-semibold hover:underline">
                        Sign Up
                    </a>
                </p>
                
                @endif

                <p class="text-center mt-2">
                    <a href="{{ route('provider.register') }}" class="text-slate-400 text-xs hover:text-primary-300">
                        Register as Provider or Technician
                    </a>
                </p>
            </form>

        </div>
    </div>

</div>

<style>
    .demo-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 1px solid rgba(255,255,255,.12);
        color: #cbd5e1;
        font-size: 12px;
        padding: 10px;
        border-radius: 12px;
        background: rgba(255,255,255,.06);
        transition: all .2s ease;
    }

    .demo-btn:hover {
        border-color: #818cf8;
        color: #ffffff;
        background: rgba(99,102,241,.25);
    }
</style>

<script>
    function togglePass() {
        const input = document.getElementById('passInput');
        const icon = document.getElementById('eyeIcon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }

    function fillDemo(email, password) {
        document.querySelector('[name=email]').value = email;
        document.querySelector('[name=password]').value = password;
    }
</script>

</body>
</html>