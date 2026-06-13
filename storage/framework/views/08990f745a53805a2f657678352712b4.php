<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> | <?php echo $__env->yieldContent('panel_name', 'Admin'); ?> Panel</title>

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
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca'
                        }
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            width: 270px;
            min-width: 270px;
            transition: width .25s cubic-bezier(.4, 0, .2, 1);
        }

        #sidebar.collapsed {
            width: 76px;
            min-width: 76px;
        }

        #sidebar.collapsed .sb-label,
        #sidebar.collapsed .sb-section-label,
        #sidebar.collapsed .sb-badge,
        #sidebar.collapsed .sb-profile-info,
        #sidebar.collapsed .sb-commission,
        #sidebar.collapsed .sb-logo-text,
        #sidebar.collapsed .sb-arrow,
        #sidebar.collapsed .sb-submenu {
            display: none !important;
        }

        #sidebar.collapsed .sb-link {
            justify-content: center;
            padding: 10px 0;
        }

        #sidebar.collapsed .sb-icon {
            margin: 0;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,.55);
            cursor: pointer;
            text-decoration: none;
            transition: all .18s ease;
            white-space: nowrap;
            width: 100%;
        }

        .sb-link:hover {
            background: rgba(255,255,255,.075);
            color: rgba(255,255,255,.95);
        }

        .sb-link.active {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            box-shadow: 0 6px 18px rgba(79,70,229,.32);
        }

        .sb-icon {
            width: 18px;
            text-align: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .sb-section {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
            padding: 16px 14px 5px;
        }

        .sb-badge {
            font-size: 10px;
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            padding: 2px 7px;
            border-radius: 20px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .sb-submenu {
            margin-left: 21px;
            margin-top: 8px;
            padding-left: 14px;
            border-left: 1px solid rgba(255,255,255,.12);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sb-submenu .sb-link {
            padding: 8px 10px;
            font-size: 12px;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
        }

        .dark .card {
            background: #1a2235;
            border-color: #2a3347;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #f1f5f9;
            transition: box-shadow .2s, transform .2s;
        }

        .stat-card:hover {
            box-shadow: 0 8px 30px rgba(99,102,241,.12);
            transform: translateY(-2px);
        }

        .dark .stat-card {
            background: #1a2235;
            border-color: #2a3347;
        }

        .badge {
            padding: 3px 10px;
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
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg,#4f46e5,#7c3aed);
            color: #fff;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: opacity .15s;
            text-decoration: none;
        }

        .btn-primary:hover {
            opacity: .9;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #f8fafc;
            color: #475569;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: background .15s;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #f1f5f9;
        }

        .dark .btn-secondary {
            background: #2a3347;
            color: #94a3b8;
            border-color: #374151;
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: #fef2f2;
            color: #dc2626;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #fecaca;
            cursor: pointer;
            text-decoration: none;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .dark .form-label {
            color: #d1d5db;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1.5px solid #e5e7eb;
            font-size: 13px;
            outline: none;
            background: #fff;
            color: #111827;
            transition: border .15s, box-shadow .15s;
        }

        .dark .form-input,
        .dark .form-select {
            background: #111827;
            border-color: #374151;
            color: #f9fafb;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.12);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 12px 14px;
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
            padding: 13px 14px;
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
            background: rgba(0,0,0,.55);
            z-index: 40;
            backdrop-filter: blur(2px);
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

        .dark ::-webkit-scrollbar-thumb {
            background: #3730a3;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
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

    <?php echo $__env->yieldPushContent('styles'); ?>
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

                <span class="sb-logo-text text-white font-bold text-[15px] tracking-tight truncate">
                    <?php echo $__env->yieldContent('panel_name','Admin'); ?>
                </span>
            </div>

            <button onclick="toggleSidebar()" id="sb-toggle"
                    class="w-6 h-6 rounded-lg flex items-center justify-center text-white/30 hover:text-white/60 hover:bg-white/5 transition-all flex-shrink-0">
                <i class="fas fa-chevron-left text-[10px]" id="sb-chevron"></i>
            </button>
        </div>

        <div class="px-3 pt-3 pb-2 border-b border-white/5 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <img src="<?php echo e(auth()->user()->profile_image_url ?? asset('images/default-user.png')); ?>"
                     class="w-9 h-9 rounded-xl object-cover ring-2 ring-primary-500/50 flex-shrink-0"
                     alt="User">

                <div class="sb-profile-info min-w-0 flex-1">
                    <p class="text-white text-xs font-semibold truncate">
                        <?php echo e(auth()->user()->full_name ?? auth()->user()->name ?? 'Admin'); ?>

                    </p>

                    <p class="text-primary-400 text-[11px] truncate">
                        <?php echo e(auth()->user()->email); ?>

                    </p>
                </div>
            </div>

            <?php if($cs = auth()->user()->commissionSetting ?? null): ?>
                <div class="sb-commission mt-1.5 text-[11px] text-gray-500 pl-0.5">
                    Commission
                    <span class="text-primary-400 font-semibold">
                        <?php echo e($cs->commission_value); ?><?php echo e($cs->commission_type === 'percent' ? '%' : ' fixed'); ?>

                    </span>
                    <span class="text-gray-600">· <?php echo e(ucfirst($cs->commission_type)); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <nav class="flex-1 overflow-y-auto py-2 px-2 space-y-0.5" id="sidebar-nav">

            <div class="sb-section"><span class="sb-section-label">Main</span></div>

            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-chart-pie sb-icon"></i>
                <span class="sb-label">Dashboard</span>
            </a>

            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.bookings*') ? 'active' : ''); ?>">
                <i class="fas fa-calendar-check sb-icon"></i>
                <span class="sb-label">Bookings</span>

                <?php
                    try {
                        $pendingBookings = \App\Models\Booking::where('status','pending')->count();
                    } catch(\Exception $e) {
                        $pendingBookings = 0;
                    }
                ?>

                <?php if($pendingBookings > 0): ?>
                    <span class="sb-badge"><?php echo e($pendingBookings); ?></span>
                <?php endif; ?>
            </a>

            <div class="sb-section"><span class="sb-section-label">Service</span></div>

            <a href="<?php echo e(route('admin.categories.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.categories*') ? 'active' : ''); ?>">
                <i class="fas fa-layer-group sb-icon"></i>
                <span class="sb-label">Category</span>
            </a>

            <a href="<?php echo e(route('admin.sub-categories.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.sub-categories*') ? 'active' : ''); ?>">
                <i class="fas fa-sitemap sb-icon"></i>
                <span class="sb-label">Sub Category</span>
            </a>

            <?php
                $serviceMenuOpen =
                    request()->routeIs('admin.services*') ||
                    request()->routeIs('admin.packages*') ||
                    request()->routeIs('admin.addons*') ||
                    request()->routeIs('admin.service-requests*');
            ?>

            <div>
                <button type="button"
                        onclick="toggleMenu('services-menu','services-arrow')"
                        class="sb-link justify-between <?php echo e($serviceMenuOpen ? 'active' : ''); ?>">

                    <span class="flex items-center gap-3">
                        <i class="fas fa-th-large sb-icon"></i>
                        <span class="sb-label">Services</span>
                    </span>

                    <i id="services-arrow" class="fas fa-chevron-down text-xs sb-arrow transition-transform <?php echo e($serviceMenuOpen ? 'rotate-180' : ''); ?>"></i>
                </button>

                <div id="services-menu" class="sb-submenu <?php echo e($serviceMenuOpen ? '' : 'hidden'); ?>">
                    <a href="<?php echo e(route('admin.services.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.services*') ? 'active' : ''); ?>">
                        <i class="far fa-list-alt sb-icon"></i>
                        <span class="sb-label">All Services</span>
                    </a>

                    <a href="<?php echo e(route('admin.packages.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.packages*') ? 'active' : ''); ?>">
                        <i class="fas fa-cube sb-icon"></i>
                        <span class="sb-label">Packages</span>
                    </a>

                    <a href="<?php echo e(route('admin.addons.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.addons*') ? 'active' : ''); ?>">
                        <i class="fas fa-plus-square sb-icon"></i>
                        <span class="sb-label">Addons</span>
                    </a>

                    <?php if(Route::has('admin.service-requests.index')): ?>
                        <a href="<?php echo e(route('admin.service-requests.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.service-requests*') ? 'active' : ''); ?>">
                            <i class="far fa-file-alt sb-icon"></i>
                            <span class="sb-label">Service Request List</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <a href="<?php echo e(route('admin.zones.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.zones*') ? 'active' : ''); ?>">
                <i class="fas fa-map-marked-alt sb-icon"></i>
                <span class="sb-label">Zones</span>
            </a>

            <div class="sb-section"><span class="sb-section-label">Custom Job</span></div>

            <a href="<?php echo e(route('admin.jobs.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.jobs.index') ? 'active' : ''); ?>">
                <i class="fas fa-clipboard-list sb-icon"></i>
                <span class="sb-label">Job Request List</span>
            </a>

            <a href="<?php echo e(route('admin.jobs.services')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.jobs.services') ? 'active' : ''); ?>">
                <i class="fas fa-list-ul sb-icon"></i>
                <span class="sb-label">Job Service List</span>
            </a>



            <div class="sb-section">
                <span class="sb-section-label">Shop</span>
            </div>
            
            <a href="<?php echo e(route('admin.shops.index')); ?>"
               class="sb-link <?php echo e(request()->routeIs('admin.shops*') ? 'active' : ''); ?>"
               title="Shops">
                <i class="fas fa-store sb-icon"></i>
                <span class="sb-label">Shops</span>
            </a>

            <div class="sb-section"><span class="sb-section-label">Users</span></div>

            <?php
                $providerMenuOpen = request()->routeIs('admin.providers*');
                $handymanMenuOpen = request()->routeIs('admin.handymen*');
            ?>

            <div>
                <button type="button"
                        onclick="toggleMenu('provider-menu','provider-arrow')"
                        class="sb-link justify-between <?php echo e($providerMenuOpen ? 'active' : ''); ?>">

                    <span class="flex items-center gap-3">
                        <i class="fas fa-user-tie sb-icon"></i>
                        <span class="sb-label">Providers</span>
                    </span>

                    <i id="provider-arrow" class="fas fa-chevron-down text-xs sb-arrow transition-transform <?php echo e($providerMenuOpen ? 'rotate-180' : ''); ?>"></i>
                </button>

                <div id="provider-menu" class="sb-submenu <?php echo e($providerMenuOpen ? '' : 'hidden'); ?>">

                    <a href="<?php echo e(route('admin.providers.index')); ?>"
                       class="sb-link <?php echo e(request()->routeIs('admin.providers.index') ? 'active' : ''); ?>">
                        <i class="fas fa-list sb-icon"></i>
                        <span class="sb-label">Provider List</span>
                    </a>
                
                    <a href="<?php echo e(route('admin.providers.requests')); ?>"
                       class="sb-link <?php echo e(request()->routeIs('admin.providers.requests') ? 'active' : ''); ?>">
                        <i class="fas fa-clipboard-list sb-icon"></i>
                        <span class="sb-label">Provider Request List</span>
                    </a>
                
                    <a href="<?php echo e(route('admin.providers.commissions')); ?>"
                       class="sb-link <?php echo e(request()->routeIs('admin.providers.commissions') ? 'active' : ''); ?>">
                        <i class="fas fa-hand-holding-usd sb-icon"></i>
                        <span class="sb-label">Provider Commission List</span>
                    </a>
                
                </div>
            </div>

            <div>
                <button type="button"
                        onclick="toggleMenu('handyman-menu','handyman-arrow')"
                        class="sb-link justify-between <?php echo e($handymanMenuOpen ? 'active' : ''); ?>">

                    <span class="flex items-center gap-3">
                        <i class="fas fa-hard-hat sb-icon"></i>
                        <span class="sb-label">Handyman</span>
                    </span>

                    <i id="handyman-arrow" class="fas fa-chevron-down text-xs sb-arrow transition-transform <?php echo e($handymanMenuOpen ? 'rotate-180' : ''); ?>"></i>
                </button>

                <div id="handyman-menu" class="sb-submenu <?php echo e($handymanMenuOpen ? '' : 'hidden'); ?>">
                    <a href="<?php echo e(route('admin.handymen.index')); ?>"
                    class="sb-link <?php echo e(request()->routeIs('admin.handymen.index') ? 'active' : ''); ?>">
                        <i class="fas fa-list sb-icon"></i>
                        <span class="sb-label">Handyman List</span>
                    </a>

                    <a href="<?php echo e(route('admin.handymen.requests')); ?>"
                    class="sb-link <?php echo e(request()->routeIs('admin.handymen.requests') ? 'active' : ''); ?>">
                        <i class="fas fa-clipboard-list sb-icon"></i>
                        <span class="sb-label">Handyman Request List</span>
                    </a>

                    <a href="<?php echo e(route('admin.handymen.index')); ?>" class="sb-link">
                        <i class="fas fa-user-clock sb-icon"></i>
                        <span class="sb-label">Unassigned Handyman</span>
                    </a>

                    <a href="<?php echo e(route('admin.handyman-commissions.index')); ?>"
                    class="sb-link <?php echo e(request()->routeIs('admin.handyman-commissions.*') ? 'active' : ''); ?>">
                        <i class="fas fa-hand-holding-usd sb-icon"></i>
                        <span class="sb-label">Handyman Commission List</span>
                    </a>
                </div>
            </div>
            
            <a href="<?php echo e(route('admin.unverified-users.index')); ?>"
            class="sb-link <?php echo e(request()->routeIs('admin.unverified-users*') ? 'active' : ''); ?>">

                <i class="fas fa-user-clock sb-icon"></i>
                <span class="sb-label">Unverified Users</span>
            </a>

            
            <a href="<?php echo e(route('admin.customers.index')); ?>"
            class="sb-link <?php echo e(request()->routeIs('admin.customers*') ? 'active' : ''); ?>">

                <i class="fas fa-users sb-icon"></i>
                <span class="sb-label">Customers</span>
            </a>

            
            <a href="<?php echo e(route('admin.users.index')); ?>"
            class="sb-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">

                <i class="fas fa-user-friends sb-icon"></i>
                <span class="sb-label">All Users</span>
            </a>

            <div class="sb-section">
                <span class="sb-section-label">Transactions</span>
            </div>
            
            <a href="<?php echo e(route('admin.payments.index')); ?>"
               class="sb-link <?php echo e(request()->routeIs('admin.payments*') ? 'active' : ''); ?>">
                <i class="far fa-credit-card sb-icon"></i>
                <span class="sb-label">Payments</span>
            </a>
            
           <a href="<?php echo e(route('admin.payments.cash')); ?>"
               class="sb-link <?php echo e(request()->routeIs('admin.payments.cash') ? 'active' : ''); ?>">
                <i class="far fa-money-bill-alt sb-icon"></i>
                <span class="sb-label">Cash Payments</span>
            </a>
            
            <a href="<?php echo e(route('admin.provider-earnings.index')); ?>"
               class="sb-link <?php echo e(request()->routeIs('admin.provider-earnings*') ? 'active' : ''); ?>">
                <i class="fas fa-dollar-sign sb-icon"></i>
                <span class="sb-label">Provider Earnings</span>
            </a>
            
            <a href="<?php echo e(route('admin.withdrawals.index')); ?>"
               class="sb-link <?php echo e(request()->routeIs('admin.withdrawals*') ? 'active' : ''); ?>">
                <i class="fas fa-dollar-sign sb-icon"></i>
                <span class="sb-label">Provider Withdrawal<br>Requests</span>
            </a>
            
            <a href="<?php echo e(route('admin.wallet.index')); ?>"
               class="sb-link <?php echo e(request()->routeIs('admin.wallet*') ? 'active' : ''); ?>">
                <i class="far fa-wallet sb-icon"></i>
                <span class="sb-label">Wallet</span>
            </a> 
            <div class="sb-section"><span class="sb-section-label">Promotion</span></div>

            <a href="<?php echo e(route('admin.banners.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.banners*') ? 'active' : ''); ?>">
                <i class="fas fa-images sb-icon"></i>
                <span class="sb-label">Banners</span>
            </a>

            <a href="<?php echo e(route('admin.coupons.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.coupons*') ? 'active' : ''); ?>">
                <i class="fas fa-ticket-alt sb-icon"></i>
                <span class="sb-label">Coupons</span>
            </a>

            <div class="sb-section"><span class="sb-section-label">Content</span></div>

            <a href="<?php echo e(route('admin.blogs.index')); ?>"
                class="sb-link <?php echo e(request()->routeIs('admin.blogs*') ? 'active' : ''); ?>">
                    <i class="fas fa-newspaper sb-icon"></i>
                    <span class="sb-label">Blogs</span>
                </a>
                <?php
                $pagesMenuOpen = request()->routeIs('admin.pages.*')
                    || request()->is('admin/pages*');
            ?>

            <div>
                <button type="button"
                        onclick="toggleMenu('pages-menu','pages-arrow')"
                        class="sb-link justify-between <?php echo e($pagesMenuOpen ? 'active' : ''); ?>">

                    <span class="flex items-center gap-3">
                        <i class="fas fa-file-alt sb-icon"></i>
                        <span class="sb-label">Pages</span>
                    </span>

                    <i id="pages-arrow"
                    class="fas fa-chevron-down text-xs sb-arrow transition-transform <?php echo e($pagesMenuOpen ? 'rotate-180' : ''); ?>">
                    </i>
                </button>

                <div id="pages-menu" class="sb-submenu <?php echo e($pagesMenuOpen ? '' : 'hidden'); ?>">

                    <a href="<?php echo e(route('admin.pages.edit', 'about-us')); ?>"
                    class="sb-link <?php echo e(request()->is('admin/pages/about-us*') ? 'active' : ''); ?>">
                        <i class="fas fa-info-circle sb-icon"></i>
                        <span class="sb-label">About Us</span>
                    </a>

                    <a href="<?php echo e(route('admin.pages.edit', 'terms-and-conditions')); ?>"
                    class="sb-link <?php echo e(request()->is('admin/pages/terms-and-conditions*') ? 'active' : ''); ?>">
                        <i class="fas fa-file-contract sb-icon"></i>
                        <span class="sb-label">Terms And Conditions</span>
                    </a>

                    <a href="<?php echo e(route('admin.pages.edit', 'privacy-policy')); ?>"
                    class="sb-link <?php echo e(request()->is('admin/pages/privacy-policy*') ? 'active' : ''); ?>">
                        <i class="fas fa-shield-alt sb-icon"></i>
                        <span class="sb-label">Privacy Policy</span>
                    </a>

                    <a href="<?php echo e(route('admin.pages.edit', 'help-and-support')); ?>"
                    class="sb-link <?php echo e(request()->is('admin/pages/help-and-support*') ? 'active' : ''); ?>">
                        <i class="fas fa-question-circle sb-icon"></i>
                        <span class="sb-label">Help And Support</span>
                    </a>

                    <a href="<?php echo e(route('admin.pages.edit', 'refund-and-cancellation-policy')); ?>"
                    class="sb-link <?php echo e(request()->is('admin/pages/refund-and-cancellation-policy*') ? 'active' : ''); ?>">
                        <i class="fas fa-calendar-times sb-icon"></i>
                        <span class="sb-label">Refund And Cancellation Policy</span>
                    </a>

                </div>
            </div>
            <?php
                $documentsMenuOpen = request()->routeIs('admin.documents.*');
            ?>

            <div>
                <button type="button"
                        onclick="toggleMenu('documents-menu','documents-arrow')"
                        class="sb-link justify-between <?php echo e($documentsMenuOpen ? 'active' : ''); ?>">

                    <span class="flex items-center gap-3">
                        <i class="far fa-file-alt sb-icon"></i>
                        <span class="sb-label">Documents</span>
                    </span>

                    <i id="documents-arrow"
                    class="fas fa-chevron-down text-xs sb-arrow transition-transform <?php echo e($documentsMenuOpen ? 'rotate-180' : ''); ?>">
                    </i>
                </button>

                <div id="documents-menu" class="sb-submenu <?php echo e($documentsMenuOpen ? '' : 'hidden'); ?>">

                    <a href="<?php echo e(route('admin.documents.index')); ?>"
                    class="sb-link <?php echo e(request()->routeIs('admin.documents.index') ? 'active' : ''); ?>">
                        <i class="far fa-clipboard sb-icon"></i>
                        <span class="sb-label">Document List</span>
                    </a>

                    <a href="<?php echo e(route('admin.documents.create')); ?>"
                    class="sb-link <?php echo e(request()->routeIs('admin.documents.create') ? 'active' : ''); ?>">
                        <i class="far fa-plus-circle sb-icon"></i>
                        <span class="sb-label">Add Document</span>
                    </a>

                </div>
            </div>

            <a href="<?php echo e(route('admin.ratings.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.ratings*') ? 'active' : ''); ?>">
                <i class="fas fa-star sb-icon"></i>
                <span class="sb-label">Ratings</span>
            </a>

            <a href="<?php echo e(route('admin.help-desk.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.help-desk*') ? 'active' : ''); ?>">
                <i class="fas fa-headset sb-icon"></i>
                <span class="sb-label">Help Desk</span>
            </a>

            <div class="sb-section"><span class="sb-section-label">System</span></div>

            <a href="<?php echo e(route('admin.settings.general')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.settings*') ? 'active' : ''); ?>">
                <i class="fas fa-sliders-h sb-icon"></i>
                <span class="sb-label">Settings</span>
            </a>

            <a href="<?php echo e(route('admin.reports.index')); ?>" class="sb-link <?php echo e(request()->routeIs('admin.reports*') ? 'active' : ''); ?>">
                <i class="fas fa-chart-bar sb-icon"></i>
                <span class="sb-label">Reports</span>
            </a>

            <div class="my-2 border-t border-white/5"></div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>

                <button type="submit" class="sb-link text-red-400 hover:bg-red-500/10 hover:text-red-300">
                    <i class="fas fa-sign-out-alt sb-icon"></i>
                    <span class="sb-label">Log Out</span>
                </button>
            </form>

        </nav>

        <div class="px-4 py-2 border-t border-white/5 flex-shrink-0">
            <p class="sb-section-label text-[10px] text-center text-gray-700">
                © <?php echo e(date('Y')); ?> HandyMan. All Rights Reserved
            </p>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden min-w-0">

        <header class="h-14 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between px-5 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <button onclick="openMobileSidebar()" class="md:hidden w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-gray-400">
                    <i class="fas fa-bars text-sm"></i>
                </button>

                <div>
                    <h1 class="text-sm font-semibold text-gray-900 dark:text-white leading-tight">
                        <?php echo $__env->yieldContent('page_title','Dashboard'); ?>
                    </h1>

                    <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                        <p class="text-xs text-gray-400 leading-tight">
                            <?php echo $__env->yieldContent('breadcrumb'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex items-center gap-1.5">
                <a href="<?php echo e(route('home')); ?>" target="_blank"
                   class="hidden sm:flex items-center gap-1.5 text-xs text-gray-500 hover:text-primary-600 px-3 py-1.5 rounded-lg hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                    <i class="fas fa-external-link-alt text-xs"></i>
                    <span>View Site</span>
                </a>

                <button onclick="toggleDark()" class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-yellow-400 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-moon dark:hidden text-sm"></i>
                    <i class="fas fa-sun hidden dark:block text-sm"></i>
                </button>

                <button class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors relative">
                    <i class="fas fa-bell text-sm"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-gray-800"></span>
                </button>

                <div class="relative group ml-1">
                    <button class="flex items-center gap-2 pl-1 pr-2 py-1 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <img src="<?php echo e(auth()->user()->profile_image_url ?? asset('images/default-user.png')); ?>"
                             class="w-7 h-7 rounded-lg object-cover ring-2 ring-primary-500/40"
                             alt="User">

                        <div class="hidden sm:block text-left">
                            <p class="text-xs font-semibold text-gray-800 dark:text-white leading-tight">
                                <?php echo e(Str::limit(auth()->user()->full_name ?? auth()->user()->name ?? 'Admin',18)); ?>

                            </p>

                            <p class="text-[10px] text-gray-400 uppercase leading-tight">
                                <?php echo e(auth()->user()->role ?? 'admin'); ?>

                            </p>
                        </div>

                        <i class="fas fa-chevron-down text-gray-400 text-[10px] hidden sm:block"></i>
                    </button>

                    <div class="absolute right-0 top-11 w-52 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 overflow-hidden">
                        <div class="p-3 border-b border-gray-100 dark:border-gray-700">
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                <?php echo e(auth()->user()->full_name ?? auth()->user()->name ?? 'Admin'); ?>

                            </p>

                            <p class="text-xs text-gray-400 truncate">
                                <?php echo e(auth()->user()->email); ?>

                            </p>
                        </div>

                        <div class="py-1">
                            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-home w-4 text-gray-400 text-xs"></i>
                                Home
                            </a>

                            <a href="<?php echo e(Route::has('admin.settings.generalx') ? route('admin.settings.general') : '#'); ?>" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="fas fa-sliders-h w-4 text-gray-400 text-xs"></i>
                                Settings
                            </a>
                        </div>

                        <div class="border-t border-gray-100 dark:border-gray-700">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>

                                <button type="submit" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-gray-700 w-full transition-colors">
                                    <i class="fas fa-sign-out-alt w-4 text-xs"></i>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php if(session('success')): ?>
            <div class="mx-5 mt-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-2.5 rounded-xl flex items-center gap-3 text-sm fade-in" id="alert-ok">
                <i class="fas fa-check-circle text-emerald-500"></i>
                <span><?php echo e(session('success')); ?></span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-400 hover:text-emerald-600">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        <?php endif; ?>

        <?php if(session('error') || $errors->any()): ?>
            <div class="mx-5 mt-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-2.5 rounded-xl flex items-center gap-3 text-sm fade-in" id="alert-err">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                <span><?php echo e(session('error') ?? $errors->first()); ?></span>
                <button onclick="this.parentElement.remove()" class="ml-auto text-red-400 hover:text-red-600">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        <?php endif; ?>

        <main class="flex-1 overflow-y-auto p-5">
            <?php echo $__env->yieldContent('content'); ?>
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
        const theme = localStorage.getItem('theme')
            || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();

    let collapsed = localStorage.getItem('sb') === '1';

    const sidebar = document.getElementById('sidebar');
    const sidebarChevron = document.getElementById('sb-chevron');

    function applySidebarState() {
        if (collapsed) {
            sidebar.classList.add('collapsed');
            sidebarChevron.style.transform = 'rotate(180deg)';
        } else {
            sidebar.classList.remove('collapsed');
            sidebarChevron.style.transform = '';
        }
    }

    function toggleSidebar() {
        if (window.innerWidth < 768) return;

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

    function confirmDelete(id, msg) {
        if (confirm(msg || 'Are you sure? This cannot be undone.')) {
            document.getElementById(id).submit();
        }
    }

    function toggleStatus(url, el) {
        fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            el.checked = data.status === 'active';
        })
        .catch(() => {});
    }

    function toggleMenu(menuId, arrowId) {
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(arrowId);

        if (!menu || !arrow) return;

        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    setTimeout(() => {
        ['alert-ok', 'alert-err'].forEach(id => {
            const element = document.getElementById(id);

            if (element) {
                element.style.transition = 'opacity .5s';
                element.style.opacity = '0';

                setTimeout(() => element.remove(), 500);
            }
        });
    }, 5000);
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/layouts/admin/app.blade.php ENDPATH**/ ?>