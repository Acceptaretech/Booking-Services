{{-- Provider uses the same admin layout but with provider nav --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | Provider Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca'
                        }
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        #sidebar {
            width: 260px;
            min-width: 260px;
            transition: width .25s ease;
        }

        #sidebar.collapsed {
            width: 72px;
            min-width: 72px;
        }

        #sidebar.collapsed .sb-label,
        #sidebar.collapsed .sb-section-label,
        #sidebar.collapsed .sb-badge,
        #sidebar.collapsed .sb-profile-info,
        #sidebar.collapsed .sb-commission,
        #sidebar.collapsed .sb-logo-text {
            display: none !important;
        }

        #sidebar.collapsed .sb-link {
            justify-content: center;
            padding: 11px 0;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, .58);
            cursor: pointer;
            text-decoration: none;
            transition: all .18s ease;
            white-space: nowrap;
        }

        .sb-link:hover {
            background: rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .95);
        }

        .sb-link.active {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(79, 70, 229, .32);
        }

        .sb-link .sb-icon {
            width: 18px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .sb-section {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .24);
            padding: 15px 13px 5px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 18px;
            border: 1px solid #f1f5f9;
            transition: box-shadow .2s, transform .2s;
        }

        .stat-card:hover {
            box-shadow: 0 6px 24px rgba(99, 102, 241, .1);
            transform: translateY(-2px);
        }

        .dark .stat-card {
            background: #1a2235;
            border-color: #2a3347;
        }

        .card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #f1f5f9;
        }

        .dark .card {
            background: #1a2235;
            border-color: #2a3347;
        }

        .badge {
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-pending {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .15s;
        }

        .btn-primary:hover {
            opacity: .9;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f8fafc;
            color: #475569;
            padding: 8px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            text-decoration: none;
            transition: background .15s;
        }

        .dark .btn-secondary {
            background: #2a3347;
            color: #94a3b8;
            border-color: #374151;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef2f2;
            color: #dc2626;
            padding: 8px 16px;
            border-radius: 9px;
            font-size: 13px;
            border: 1px solid #fecaca;
            cursor: pointer;
            text-decoration: none;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 5px;
        }

        .dark .form-label {
            color: #d1d5db;
        }

        .form-input {
            width: 100%;
            padding: 9px 13px;
            border-radius: 9px;
            border: 1.5px solid #e5e7eb;
            font-size: 13px;
            outline: none;
            transition: border .15s, box-shadow .15s;
            background: #ffffff;
            color: #111827;
        }

        .dark .form-input {
            background: #111827;
            border-color: #374151;
            color: #f9fafb;
        }

        .form-input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, .1);
        }

        .form-select {
            width: 100%;
            padding: 9px 13px;
            border-radius: 9px;
            border: 1.5px solid #e5e7eb;
            font-size: 13px;
            outline: none;
            background: #ffffff;
            color: #111827;
        }

        .dark .form-select {
            background: #111827;
            border-color: #374151;
            color: #f9fafb;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 11px 13px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
        }

        .dark .data-table th {
            background: #1e293b;
            color: #94a3b8;
            border-color: #2a3347;
        }

        .data-table td {
            padding: 12px 13px;
            font-size: 13px;
            color: #374151;
            border-bottom: 1px solid #f8fafc;
        }

        .dark .data-table td {
            color: #cbd5e1;
            border-color: #2a3347;
        }

        .data-table tr:hover td {
            background: #f8fafc;
        }

        .dark .data-table tr:hover td {
            background: #1e293b;
        }

        #sb-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 40;
        }

        @media(max-width: 768px) {
            #sidebar {
                position: fixed;
                z-index: 50;
                height: 100%;
                transform: translateX(-100%);
                transition: transform .25s;
            }

            #sidebar.mobile-open {
                transform: translateX(0);
            }

            #sb-overlay.active {
                display: block;
            }
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 10px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .fade-in {
            animation: fadeInUp .3s ease forwards;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-gray-800 dark:text-gray-200">

<div id="sb-overlay" onclick="closeMobileSidebar()"></div>

<div class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="bg-gray-950 flex flex-col overflow-hidden flex-shrink-0">

        <div class="flex items-center justify-between px-4 h-14 border-b border-white/5 flex-shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-tools text-white text-xs"></i>
                </div>
                <span class="sb-logo-text text-white font-bold text-[14px]">Provider Panel</span>
            </div>

            <button onclick="toggleSidebar()"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-white/30 hover:text-white/60 hover:bg-white/5 transition-all flex-shrink-0">
                <i class="fas fa-chevron-left text-[10px]" id="sb-chevron"></i>
            </button>
        </div>

        <div class="px-3 pt-3 pb-2 border-b border-white/5 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <img src="{{ auth()->user()->profile_image_url ?? asset('images/default-user.png') }}"
                     class="w-9 h-9 rounded-xl object-cover ring-2 ring-primary-500/50 flex-shrink-0"
                     alt="Profile">

                <div class="sb-profile-info min-w-0">
                    <p class="text-white text-xs font-semibold truncate">
                        {{ auth()->user()->full_name ?? auth()->user()->name ?? 'Provider' }}
                    </p>
                    <p class="text-primary-400 text-[11px] truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>
            </div>

            @if($cs = auth()->user()->commissionSetting ?? null)
                <p class="sb-commission mt-1.5 text-[11px] text-gray-500 pl-0.5">
                    Commission Value:
                    <span class="text-primary-400 font-semibold">
                        {{ $cs->commission_value }}{{ $cs->commission_type === 'percent' ? '%' : '' }}
                    </span>
                    <br>
                    Commission Type:
                    <span class="text-gray-400">
                        {{ ucfirst($cs->commission_type) }}
                    </span>
                </p>
            @endif
        </div>

        <nav class="flex-1 overflow-y-auto py-3 px-2 space-y-1">

            <div class="sb-section">
                <span class="sb-section-label">Main</span>
            </div>

            <a href="{{ route('provider.dashboard') }}"
               class="sb-link {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}"
               title="Dashboard">
                <i class="fas fa-chart-pie sb-icon"></i>
                <span class="sb-label">Dashboard</span>
            </a>

            <a href="{{ route('provider.bookings.index') }}"
               class="sb-link {{ request()->routeIs('provider.bookings*') ? 'active' : '' }}"
               title="Booking">
                <i class="fas fa-calendar-check sb-icon"></i>
                <span class="sb-label">Booking</span>
            </a>

            <a href="{{ route('provider.shops.index') }}"
               class="sb-link {{ request()->routeIs('provider.shops*') ? 'active' : '' }}"
               title="Shop">
                <i class="fas fa-store sb-icon"></i>
                <span class="sb-label">Shop</span>
            </a>


           <div class="sb-section">
    <span class="sb-section-label">Service</span>
</div>

@php
    $serviceOpen = request()->routeIs(
        'provider.services*',
        'provider.packages*',
        'provider.addons*'
    );
@endphp

<div class="space-y-1">

    <button type="button"
            onclick="toggleServiceMenu()"
            class="sb-link w-full {{ $serviceOpen ? 'active' : '' }}">
        <i class="fas fa-th-large sb-icon"></i>
        <span class="sb-label flex-1 text-left">Services</span>
        <i id="serviceArrow"
           class="fas fa-chevron-down text-xs transition-transform {{ $serviceOpen ? 'rotate-180' : '' }}"></i>
    </button>

    <div id="serviceSubMenu"
         class="{{ $serviceOpen ? '' : 'hidden' }} ml-8 mt-1 space-y-1 border-l border-white/10 pl-3">

        <a href="{{ route('provider.services.index') }}"
           class="sb-link {{ request()->routeIs('provider.services.index') ? 'active' : '' }}">
            <i class="far fa-check-square sb-icon"></i>
            <span class="sb-label">All Services</span>
        </a>

        <a href="{{ route('provider.packages.index') }}"
           class="sb-link {{ request()->routeIs('provider.packages*') ? 'active' : '' }}">
            <i class="fas fa-cube sb-icon"></i>
            <span class="sb-label">Packages</span>
        </a>

        <a href="{{ route('provider.addons.index') }}"
           class="sb-link {{ request()->routeIs('provider.addons*') ? 'active' : '' }}">
            <i class="fas fa-plus-square sb-icon"></i>
            <span class="sb-label">Addons</span>
        </a>

        <a href="{{ route('provider.services.requests') }}"
           class="sb-link {{ request()->routeIs('provider.services.requests') ? 'active' : '' }}">
            <i class="far fa-list-alt sb-icon"></i>
            <span class="sb-label">Service Request List</span>
        </a>

    </div>
</div>

            <a href="{{ route('provider.job-requests.index') }}"
               class="sb-link {{ request()->routeIs('provider.job-requests*') ? 'active' : '' }}"
               title="Job Request List">
                <i class="fas fa-briefcase sb-icon"></i>
                <span class="sb-label">Job Request List</span>
            </a>

            <div class="sb-section">
                <span class="sb-section-label">User</span>
            </div>
            
            @php
                $handymanOpen = request()->routeIs(
                    'provider.handymen*',
                    'provider.handyman-requests*',
                    'provider.unassigned-handymen*',
                    'provider.handyman-commissions*'
                );
            @endphp
            
            <div class="space-y-1">
            
                <button type="button"
                        onclick="toggleHandymanMenu()"
                        class="sb-link w-full {{ $handymanOpen ? 'active' : '' }}">
                    <i class="fas fa-user-cog sb-icon"></i>
                    <span class="sb-label flex-1 text-left">Technician</span>
                    <i id="handymanArrow"
                       class="fas fa-chevron-down text-xs transition-transform {{ $handymanOpen ? 'rotate-180' : '' }}"></i>
                </button>
            
                <div id="handymanSubMenu"
                     class="{{ $handymanOpen ? '' : 'hidden' }} ml-8 mt-1 space-y-1 border-l border-white/10 pl-3">
            
                    <a href="{{ route('provider.handymen.index') }}"
                       class="sb-link {{ request()->routeIs('provider.handymen*') ? 'active' : '' }}">
                        <i class="fas fa-list sb-icon"></i>
                        <span class="sb-label">Technician List</span>
                    </a>
            
                    <a href="{{ route('provider.handymen.requests') }}"
                    class="sb-link {{ request()->routeIs('provider.handymen.requests') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list sb-icon"></i>
                        <span class="sb-label">Technician Request List</span>
                    </a>

                    <a href="{{ route('provider.handymen.unassigned') }}"
                    class="sb-link {{ request()->routeIs('provider.handymen.unassigned') ? 'active' : '' }}">
                        <i class="fas fa-user-clock sb-icon"></i>
                        <span class="sb-label">Unassigned Technician</span>
                    </a>
                                
                    <a href="{{ route('provider.handyman-commissions.index') }}"
                       class="sb-link {{ request()->routeIs('provider.handyman-commissions*') ? 'active' : '' }}">
                        <i class="fas fa-user-tag sb-icon"></i>
                        <span class="sb-label">Technician Commission List</span>
                    </a>
            
                </div>
            </div>
            
           

            <div class="sb-section">
                <span class="sb-section-label">Finance</span>
            </div>

            <a href="{{ route('provider.payments.index') }}"
               class="sb-link {{ request()->routeIs('provider.payments.index') ? 'active' : '' }}"
               title="Payments">
                <i class="fas fa-credit-card sb-icon"></i>
                <span class="sb-label">Payments</span>
            </a>

            <a href="{{ route('provider.payments.cash') }}"
               class="sb-link {{ request()->routeIs('provider.payments.cash') ? 'active' : '' }}"
               title="Cash Payments">
                <i class="fas fa-money-bill-wave sb-icon"></i>
                <span class="sb-label">Cash Payments</span>
            </a>

            <a href="{{ route('provider.withdrawal.index') }}"
               class="sb-link {{ request()->routeIs('provider.withdrawal*') ? 'active' : '' }}"
               title="Provider Withdrawal Requests">
                <i class="fas fa-wallet sb-icon"></i>
                <span class="sb-label">Provider Withdrawal Requests</span>
            </a>

            <a href="{{ route('provider.payments.handyman') }}"
               class="sb-link {{ request()->routeIs('provider.payments.handyman') ? 'active' : '' }}"
               title="Handyman Earning List">
                <i class="fas fa-coins sb-icon"></i>
                <span class="sb-label">Technician Earning List</span>
            </a>

            <div class="sb-section">
                <span class="sb-section-label">Promotion</span>
            </div>

            <a href="{{ route('provider.banners.index') }}"
               class="sb-link {{ request()->routeIs('provider.banners*') ? 'active' : '' }}"
               title="Provider Promotional Banner">
                <i class="fas fa-images sb-icon"></i>
                <span class="sb-label">Provider Promotional Banner</span>
            </a>

            <div class="sb-section">
                <span class="sb-section-label">Support</span>
            </div>

            <a href="{{ route('provider.ratings.index') }}"
               class="sb-link {{ request()->routeIs('provider.ratings*') ? 'active' : '' }}"
               title="Handyman Rating List">
                <i class="fas fa-star sb-icon"></i>
                <span class="sb-label">Technician Rating List</span>
            </a>

            <a href="{{ route('provider.help-desk.index') }}"
               class="sb-link {{ request()->routeIs('provider.help-desk*') ? 'active' : '' }}"
               title="Help Desk">
                <i class="fas fa-headset sb-icon"></i>
                <span class="sb-label">Help Desk</span>
            </a>

        </nav>

        <div class="px-4 py-2 border-t border-white/5 flex-shrink-0">
            <p class="sb-section-label text-[10px] text-center text-gray-700">
                © {{ date('Y') }} All Rights Reserved
            </p>
        </div>

    </aside>

    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <header class="h-14 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between px-5 flex-shrink-0 shadow-sm">

            <div class="flex items-center gap-3">
                <button onclick="openMobileSidebar()"
                        class="md:hidden w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500">
                    <i class="fas fa-bars text-sm"></i>
                </button>

                <h1 class="text-sm font-semibold text-gray-900 dark:text-white">
                    @yield('page_title', 'Dashboard')
                </h1>
            </div>

            <div class="flex items-center gap-1.5">

              {{--  <button onclick="toggleDark()"
                        class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-yellow-400">
                    <i class="fas fa-moon dark:hidden text-sm"></i>
                    <i class="fas fa-sun hidden dark:block text-sm"></i>
                </button> --}}

                <button class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 relative">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-gray-800"></span>
                </button>

                <div class="relative">
                    <button type="button"
                            onclick="toggleProfileMenu()"
                            class="flex items-center gap-2 pl-2">
                
                        <img src="{{ auth()->user()->profile_image_url ?? asset('images/default-user.png') }}"
                             class="w-10 h-10 rounded-full object-cover"
                             alt="Profile">
                
                        <span class="text-sm font-medium text-gray-700 hidden sm:block">
                            {{ strtoupper(auth()->user()->full_name ?? auth()->user()->name ?? 'PROVIDER') }}
                        </span>
                    </button>
                
                    <div id="profileDropdown"
                         class="hidden absolute right-0 mt-3 w-64 bg-white rounded-md shadow-lg border z-50">
                
                        <a href="{{ route('provider.dashboard') }}"
                           class="flex items-center gap-4 px-5 py-4 text-gray-600 hover:bg-gray-50">
                            <i class="fas fa-home text-xl text-gray-400"></i>
                            <span>HOME</span>
                        </a>
                
                        <a href="{{ route('provider.profile') }}"
                           class="flex items-center gap-4 px-5 py-4 text-gray-600 hover:bg-gray-50">
                            <i class="far fa-user-circle text-xl text-gray-400"></i>
                            <span>MY PROFILE</span>
                        </a>
                
                        <a href="{{ route('provider.profile.info') }}"
                           class="flex items-center gap-4 px-5 py-4 text-gray-600 hover:bg-gray-50">
                            <i class="far fa-user-circle text-xl text-gray-400"></i>
                            <span>MY INFO</span>
                        </a>
                
                        <a href="{{ route('provider.profile.settings') }}"
                           class="flex items-center gap-4 px-5 py-4 text-gray-600 hover:bg-gray-50 border-t">
                            <i class="fas fa-cog text-xl text-gray-400"></i>
                            <span>SETTINGS</span>
                        </a>
                
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                
                            <button type="submit"
                                    class="w-full flex items-center gap-4 px-5 py-4 text-gray-600 hover:bg-gray-50 border-t">
                                <i class="fas fa-sign-out-alt text-xl text-gray-400"></i>
                                <span>LOG OUT</span>
                            </button>
                        </form>
                    </div>
                </div>
        

            </div>

        </header>

        @if(session('success'))
            <div class="mx-5 mt-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-2.5 rounded-xl flex items-center gap-3 text-sm fade-in"
                 id="alert-ok">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto opacity-50 hover:opacity-100">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-5 mt-3 bg-red-50 dark:bg-red-900/20 border border-red-200 text-red-700 px-4 py-2.5 rounded-xl flex items-center gap-3 text-sm fade-in">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span>{{ $errors->first() }}</span>
                <button onclick="this.parentElement.remove()" class="ml-auto opacity-50">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif

        <main class="flex-1 overflow-y-auto p-5">
            @yield('content')
        </main>

    </div>

</div>

<script>
    function toggleDark() {
        document.documentElement.classList.toggle('dark');

        localStorage.setItem(
            'theme',
            document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        );
    }

    (function () {
        const theme = localStorage.getItem('theme') ||
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();

    let collapsed = localStorage.getItem('sb') === '1';

    const sidebar = document.getElementById('sidebar');
    const chevron = document.getElementById('sb-chevron');

    function applySidebarState() {
        if (collapsed) {
            sidebar.classList.add('collapsed');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            sidebar.classList.remove('collapsed');
            chevron.style.transform = '';
        }
    }

    function toggleSidebar() {
        if (window.innerWidth < 768) {
            return;
        }

        collapsed = !collapsed;
        localStorage.setItem('sb', collapsed ? '1' : '0');
        applySidebarState();
    }

    applySidebarState();

    function openMobileSidebar() {
        sidebar.classList.add('mobile-open');
        document.getElementById('sb-overlay').classList.add('active');
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        document.getElementById('sb-overlay').classList.remove('active');
    }

    function confirmDelete(id, message) {
        if (confirm(message || 'Are you sure?')) {
            document.getElementById(id).submit();
        }
    }

    function toggleStatus(url, element) {
        fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                element.checked = data.status === 'active';
            })
            .catch(() => {});
    }

    setTimeout(() => {
        const alertBox = document.getElementById('alert-ok');

        if (alertBox) {
            alertBox.style.opacity = 0;
        }
    }, 5000);
</script>
<script>
    function toggleServiceMenu() {
        const menu = document.getElementById('serviceSubMenu');
        const arrow = document.getElementById('serviceArrow');
    
        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }
</script>
<script>
    function toggleHandymanMenu() {
        document.getElementById('handymanSubMenu').classList.toggle('hidden');
        document.getElementById('handymanArrow').classList.toggle('rotate-180');
    }
</script>
<script>
    function toggleProfileMenu() {
        document.getElementById('profileDropdown').classList.toggle('hidden');
    }
    
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        const button = e.target.closest('button');
    
        if (!e.target.closest('#profileDropdown') && !button) {
            dropdown.classList.add('hidden');
        }
    });
    </script>

@stack('scripts')


</body>
</html>