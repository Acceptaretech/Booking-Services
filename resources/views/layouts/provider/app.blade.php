{{-- Provider uses the same admin layout but with provider nav --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Dashboard') | Provider Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class',theme:{extend:{colors:{primary:{50:'#eef2ff',500:'#6366f1',600:'#4f46e5',700:'#4338ca'}}}}}</script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        *{box-sizing:border-box;}body{font-family:'Inter',sans-serif;}
        #sidebar{width:240px;min-width:240px;transition:width .25s;}
        #sidebar.collapsed{width:68px;min-width:68px;}
        #sidebar.collapsed .sb-label,#sidebar.collapsed .sb-section-label,#sidebar.collapsed .sb-badge,#sidebar.collapsed .sb-profile-info,#sidebar.collapsed .sb-commission,#sidebar.collapsed .sb-logo-text{display:none!important;}
        #sidebar.collapsed .sb-link{justify-content:center;padding:10px 0;}
        .sb-link{display:flex;align-items:center;gap:10px;padding:8px 11px;border-radius:9px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,.5);cursor:pointer;text-decoration:none;transition:all .15s;white-space:nowrap;}
        .sb-link:hover{background:rgba(255,255,255,.07);color:rgba(255,255,255,.9);}
        .sb-link.active{background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;box-shadow:0 4px 12px rgba(79,70,229,.3);}
        .sb-link .sb-icon{width:16px;text-align:center;font-size:13px;flex-shrink:0;}
        .sb-section{font-size:9.5px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(255,255,255,.2);padding:13px 13px 3px;}
        .sb-badge{font-size:10px;margin-left:auto;background:#ef4444;color:#fff;padding:1px 6px;border-radius:20px;font-weight:700;flex-shrink:0;}
        .stat-card{background:#fff;border-radius:14px;padding:18px;border:1px solid #f1f5f9;transition:box-shadow .2s,transform .2s;}
        .stat-card:hover{box-shadow:0 6px 24px rgba(99,102,241,.1);transform:translateY(-2px);}
        .dark .stat-card{background:#1a2235;border-color:#2a3347;}
        .card{background:#fff;border-radius:14px;border:1px solid #f1f5f9;}
        .dark .card{background:#1a2235;border-color:#2a3347;}
        .badge{padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600;display:inline-block;}
        .badge-success{background:#d1fae5;color:#065f46;}.badge-warning{background:#fef3c7;color:#92400e;}
        .badge-danger{background:#fee2e2;color:#991b1b;}.badge-info{background:#dbeafe;color:#1e40af;}.badge-pending{background:#f1f5f9;color:#475569;}
        .btn-primary{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;padding:8px 16px;border-radius:9px;font-size:13px;font-weight:500;border:none;cursor:pointer;text-decoration:none;transition:opacity .15s;}
        .btn-primary:hover{opacity:.9;}
        .btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#f8fafc;color:#475569;padding:8px 16px;border-radius:9px;font-size:13px;font-weight:500;border:1px solid #e2e8f0;cursor:pointer;text-decoration:none;transition:background .15s;}
        .dark .btn-secondary{background:#2a3347;color:#94a3b8;border-color:#374151;}
        .btn-danger{display:inline-flex;align-items:center;gap:6px;background:#fef2f2;color:#dc2626;padding:8px 16px;border-radius:9px;font-size:13px;border:1px solid #fecaca;cursor:pointer;text-decoration:none;}
        .form-label{display:block;font-size:13px;font-weight:500;color:#374151;margin-bottom:5px;}
        .dark .form-label{color:#d1d5db;}
        .form-input{width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid #e5e7eb;font-size:13px;outline:none;transition:border .15s,box-shadow .15s;background:#fff;color:#111827;}
        .dark .form-input{background:#111827;border-color:#374151;color:#f9fafb;}
        .form-input:focus{border-color:#6366f1;box-shadow:0 0 0 3px rgba(99,102,241,.1);}
        .form-select{width:100%;padding:9px 13px;border-radius:9px;border:1.5px solid #e5e7eb;font-size:13px;outline:none;background:#fff;color:#111827;}
        .dark .form-select{background:#111827;border-color:#374151;color:#f9fafb;}
        .data-table{width:100%;border-collapse:collapse;}
        .data-table th{text-align:left;padding:11px 13px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#64748b;background:#f8fafc;border-bottom:1px solid #f1f5f9;}
        .dark .data-table th{background:#1e293b;color:#94a3b8;border-color:#2a3347;}
        .data-table td{padding:12px 13px;font-size:13px;color:#374151;border-bottom:1px solid #f8fafc;}
        .dark .data-table td{color:#cbd5e1;border-color:#2a3347;}
        .data-table tr:hover td{background:#f8fafc;}.dark .data-table tr:hover td{background:#1e293b;}
        #sb-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:40;}
        @media(max-width:768px){#sidebar{position:fixed;z-index:50;height:100%;transform:translateX(-100%);transition:transform .25s;}#sidebar.mobile-open{transform:translateX(0);}#sb-overlay.active{display:block;}}
        ::-webkit-scrollbar{width:4px;height:4px;}::-webkit-scrollbar-track{background:transparent;}::-webkit-scrollbar-thumb{background:#c7d2fe;border-radius:10px;}
        @keyframes fadeInUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}.fade-in{animation:fadeInUp .3s ease forwards;}
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-gray-800 dark:text-gray-200">
<div id="sb-overlay" onclick="closeMobileSidebar()"></div>
<div class="flex h-screen overflow-hidden">

    <aside id="sidebar" class="bg-gray-950 flex flex-col overflow-hidden flex-shrink-0">
        <div class="flex items-center justify-between px-4 h-14 border-b border-white/5 flex-shrink-0">
            <div class="flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary-500 to-purple-600 flex items-center justify-center flex-shrink-0"><i class="fas fa-tools text-white text-xs"></i></div>
                <span class="sb-logo-text text-white font-bold text-[14px]">Provider</span>
            </div>
            <button onclick="toggleSidebar()" class="w-6 h-6 rounded-lg flex items-center justify-center text-white/30 hover:text-white/60 hover:bg-white/5 transition-all flex-shrink-0">
                <i class="fas fa-chevron-left text-[10px]" id="sb-chevron"></i>
            </button>
        </div>
        <div class="px-3 pt-3 pb-2 border-b border-white/5 flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <img src="{{ auth()->user()->profile_image_url }}" class="w-9 h-9 rounded-xl object-cover ring-2 ring-primary-500/50 flex-shrink-0" alt="">
                <div class="sb-profile-info min-w-0">
                    <p class="text-white text-xs font-semibold truncate">{{ auth()->user()->full_name }}</p>
                    <p class="text-primary-400 text-[11px] truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
            @if($cs = auth()->user()->commissionSetting)
            <p class="sb-commission mt-1.5 text-[11px] text-gray-500 pl-0.5">Commission Value: <span class="text-primary-400 font-semibold">{{ $cs->commission_value }}{{ $cs->commission_type==='percent'?'%':'' }}</span><br>Commission Type: <span class="text-gray-400">{{ ucfirst($cs->commission_type) }}</span></p>
            @endif
        </div>

        <nav class="flex-1 overflow-y-auto py-2 px-2 space-y-0.5">
            <div class="sb-section"><span class="sb-section-label">Main</span></div>
            <a href="{{ route('provider.dashboard') }}" class="sb-link {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}" title="Dashboard"><i class="fas fa-chart-pie sb-icon"></i><span class="sb-label">Dashboard</span></a>
            <a href="{{ route('provider.bookings.index') }}" class="sb-link {{ request()->routeIs('provider.bookings*') ? 'active' : '' }}" title="Bookings"><i class="fas fa-calendar-check sb-icon"></i><span class="sb-label">Bookings</span></a>

            <div class="sb-section"><span class="sb-section-label">Shop</span></div>
            <a href="{{ route('provider.shops.index') }}" class="sb-link {{ request()->routeIs('provider.shops*') ? 'active' : '' }}" title="Shops"><i class="fas fa-store sb-icon"></i><span class="sb-label">Shops</span></a>

            <div class="sb-section"><span class="sb-section-label">Service</span></div>
            <a href="{{ route('provider.services.index') }}" class="sb-link {{ request()->routeIs('provider.services*') ? 'active' : '' }}" title="Services"><i class="fas fa-concierge-bell sb-icon"></i><span class="sb-label">All Services</span></a>
            <a href="{{ route('provider.packages.index') }}" class="sb-link {{ request()->routeIs('provider.packages*') ? 'active' : '' }}" title="Packages"><i class="fas fa-box-open sb-icon"></i><span class="sb-label">Packages</span></a>
            <a href="{{ route('provider.addons.index') }}" class="sb-link {{ request()->routeIs('provider.addons*') ? 'active' : '' }}" title="Addons"><i class="fas fa-puzzle-piece sb-icon"></i><span class="sb-label">Addons</span></a>
            <a href="{{ route('provider.services.requests') }}" class="sb-link {{ request()->routeIs('provider.services.requests') ? 'active' : '' }}" title="Service Requests"><i class="fas fa-clipboard sb-icon"></i><span class="sb-label">Service Request List</span></a>

            <div class="sb-section"><span class="sb-section-label">Custom Job</span></div>
            <a href="{{ route('provider.job-requests.index') }}" class="sb-link {{ request()->routeIs('provider.job-requests*') ? 'active' : '' }}" title="Job Requests"><i class="fas fa-briefcase sb-icon"></i><span class="sb-label">Job Request List</span></a>

            <div class="sb-section"><span class="sb-section-label">User</span></div>
            <a href="{{ route('provider.handymen.index') }}" class="sb-link {{ request()->routeIs('provider.handymen*') ? 'active' : '' }}" title="Handyman"><i class="fas fa-hard-hat sb-icon"></i><span class="sb-label">Handyman</span></a>
            <a href="{{ route('provider.handyman-commissions.index') }}" class="sb-link {{ request()->routeIs('provider.handyman-commissions*') ? 'active' : '' }}" title="Commissions"><i class="fas fa-percent sb-icon"></i><span class="sb-label">Handyman Commission</span></a>

            <div class="sb-section"><span class="sb-section-label">Transactions</span></div>
            <a href="{{ route('provider.payments.index') }}" class="sb-link {{ request()->routeIs('provider.payments.index') ? 'active' : '' }}" title="Payments"><i class="fas fa-credit-card sb-icon"></i><span class="sb-label">Payments</span></a>
            <a href="{{ route('provider.payments.cash') }}" class="sb-link {{ request()->routeIs('provider.payments.cash') ? 'active' : '' }}" title="Cash Payments"><i class="fas fa-money-bill sb-icon"></i><span class="sb-label">Cash Payments</span></a>
            <a href="{{ route('provider.withdrawal.index') }}" class="sb-link {{ request()->routeIs('provider.withdrawal*') ? 'active' : '' }}" title="Withdrawals"><i class="fas fa-wallet sb-icon"></i><span class="sb-label">Withdrawal Requests</span></a>
            <a href="{{ route('provider.payments.handyman') }}" class="sb-link {{ request()->routeIs('provider.payments.handyman') ? 'active' : '' }}" title="Handyman Earnings"><i class="fas fa-coins sb-icon"></i><span class="sb-label">Handyman Earning List</span></a>

            <div class="sb-section"><span class="sb-section-label">Promotion</span></div>
            <a href="{{ route('provider.banners.index') }}" class="sb-link {{ request()->routeIs('provider.banners*') ? 'active' : '' }}" title="Banners"><i class="fas fa-images sb-icon"></i><span class="sb-label">Provider Promotional Banner</span></a>

            <div class="sb-section"><span class="sb-section-label">Ratings</span></div>
            <a href="{{ route('provider.ratings.index') }}" class="sb-link {{ request()->routeIs('provider.ratings*') ? 'active' : '' }}" title="Ratings"><i class="fas fa-star sb-icon"></i><span class="sb-label">Handyman Ratings List</span></a>
            <a href="{{ route('provider.help-desk.index') }}" class="sb-link {{ request()->routeIs('provider.help-desk*') ? 'active' : '' }}" title="Help Desk"><i class="fas fa-headset sb-icon"></i><span class="sb-label">Help Desk</span></a>

            <div class="my-2 border-t border-white/5"></div>
            <a href="{{ route('home') }}" class="sb-link" title="Go Home"><i class="fas fa-home sb-icon"></i><span class="sb-label">Home</span></a>
            <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="sb-link w-full text-red-400 hover:bg-red-500/10 hover:text-red-300" title="Logout"><i class="fas fa-sign-out-alt sb-icon"></i><span class="sb-label">Log Out</span></button></form>
        </nav>
        <div class="px-4 py-2 border-t border-white/5 flex-shrink-0"><p class="sb-section-label text-[10px] text-center text-gray-700">© {{ date('Y') }} All Rights Reserved</p></div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden min-w-0">
        <header class="h-14 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between px-5 flex-shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <button onclick="openMobileSidebar()" class="md:hidden w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500"><i class="fas fa-bars text-sm"></i></button>
                <h1 class="text-sm font-semibold text-gray-900 dark:text-white">@yield('page_title','Dashboard')</h1>
            </div>
            <div class="flex items-center gap-1.5">
                <button onclick="toggleDark()" class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 dark:text-yellow-400"><i class="fas fa-moon dark:hidden text-sm"></i><i class="fas fa-sun hidden dark:block text-sm"></i></button>
                <button class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-500 relative"><i class="fas fa-bell text-sm"></i><span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-gray-800"></span></button>
                <div class="flex items-center gap-2 pl-2">
                    <img src="{{ auth()->user()->profile_image_url }}" class="w-7 h-7 rounded-lg object-cover ring-2 ring-primary-500/40" alt="">
                    <span class="text-xs font-semibold text-gray-800 dark:text-white hidden sm:block">{{ strtoupper(auth()->user()->full_name) }}</span>
                </div>
            </div>
        </header>
        @if(session('success'))<div class="mx-5 mt-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-2.5 rounded-xl flex items-center gap-3 text-sm fade-in" id="alert-ok"><i class="fas fa-check-circle text-emerald-500"></i><span>{{ session('success') }}</span><button onclick="this.parentElement.remove()" class="ml-auto opacity-50 hover:opacity-100"><i class="fas fa-times text-xs"></i></button></div>@endif
        @if($errors->any())<div class="mx-5 mt-3 bg-red-50 dark:bg-red-900/20 border border-red-200 text-red-700 px-4 py-2.5 rounded-xl flex items-center gap-3 text-sm fade-in"><i class="fas fa-exclamation-circle text-red-500"></i><span>{{ $errors->first() }}</span><button onclick="this.parentElement.remove()" class="ml-auto opacity-50"><i class="fas fa-times text-xs"></i></button></div>@endif
        <main class="flex-1 overflow-y-auto p-5">@yield('content')</main>
    </div>
</div>
<script>
function toggleDark(){document.documentElement.classList.toggle('dark');localStorage.setItem('theme',document.documentElement.classList.contains('dark')?'dark':'light');}
(function(){const t=localStorage.getItem('theme')||(window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');if(t==='dark')document.documentElement.classList.add('dark');})();
let collapsed=localStorage.getItem('sb')==='1';
const sb=document.getElementById('sidebar'),ch=document.getElementById('sb-chevron');
function applySb(){if(collapsed){sb.classList.add('collapsed');ch.style.transform='rotate(180deg)';}else{sb.classList.remove('collapsed');ch.style.transform='';}}
function toggleSidebar(){if(window.innerWidth<768)return;collapsed=!collapsed;localStorage.setItem('sb',collapsed?'1':'0');applySb();}
applySb();
function openMobileSidebar(){sb.classList.add('mobile-open');document.getElementById('sb-overlay').classList.add('active');}
function closeMobileSidebar(){sb.classList.remove('mobile-open');document.getElementById('sb-overlay').classList.remove('active');}
function confirmDelete(id,msg){if(confirm(msg||'Are you sure?')){document.getElementById(id).submit();}}
function toggleStatus(url,el){fetch(url,{method:'PATCH',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,'Accept':'application/json'}}).then(r=>r.json()).then(d=>{el.checked=d.status==='active';}).catch(()=>{});}
setTimeout(()=>document.getElementById('alert-ok')&&(document.getElementById('alert-ok').style.opacity=0),5000);
</script>
@stack('scripts')
</body>
</html>
