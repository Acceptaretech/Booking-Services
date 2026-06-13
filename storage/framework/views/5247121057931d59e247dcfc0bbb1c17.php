<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo e(session('theme','light')); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>
        <?php echo $__env->yieldContent('title',
        \App\Models\SystemConfig::where('key','company_name')->value('value')
        ?? 'Service Booking'); ?>
        - Your Instant Service Partner
    </title>
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Book trusted home services online'); ?>">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT:'#6366f1', 50:'#eef2ff', 100:'#e0e7ff', 600:'#4f46e5', 700:'#4338ca' },
                        secondary: '#f59e0b',
                    },
                    fontFamily: { sans: ['Inter','sans-serif'] },
                }
            }
        }
    </script>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg,#6366f1 0%,#8b5cf6 50%,#a78bfa 100%); }
        .card-hover { transition: all .3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,.12); }
        .star-filled { color: #f59e0b; }
        .rating-star i { font-size: 12px; }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:none} }
        .fade-in { animation: fadeInUp .5s ease forwards; }
        .dark body { background:#0f172a; color:#e2e8f0; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">


<?php if($topBarPhone = \App\Models\SystemConfig::where('key','contact_number')->value('value')): ?>
<div class="bg-primary-600 text-white text-sm py-1.5 text-center">
    <i class="fas fa-phone-alt mr-2"></i>
    Call us: <a href="tel:<?php echo e($topBarPhone); ?>" class="font-semibold hover:underline"><?php echo e($topBarPhone); ?></a>
    <span class="mx-4 opacity-50">|</span>
    <select onchange="changeLang(this.value)" class="bg-transparent text-white text-sm border-none cursor-pointer outline-none">
        <option>EN</option><option>HI</option><option>AR</option>
    </select>
</div>
<?php endif; ?>


<nav class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                <?php if($logo = \App\Models\SystemConfig::where('key','logo')->value('value')): ?>
                    <img src="<?php echo e(asset('storage/'.$logo)); ?>" alt="Logo" class="h-9 w-auto">
                    <span class="font-bold text-xl text-primary-600">
                        <?php echo e(\App\Models\SystemConfig::where('key','company_name')->value('value') ?? 'Service Booking'); ?>

                    </span>
                <?php else: ?>
                    <div class="w-9 h-9 bg-primary-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tools text-white text-lg"></i>
                    </div>
                    <span class="font-bold text-xl text-primary-600">
                        <?php echo e(\App\Models\SystemConfig::where('key','company_name')->value('value') ?? 'Service Booking'); ?>

                    </span>
                <?php endif; ?>
            </a>

            
            <div class="hidden md:flex items-center gap-8">
                <a href="<?php echo e(route('home')); ?>"       class="nav-link <?php echo e(request()->routeIs('home') ? 'text-primary-600 font-semibold' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors text-sm font-medium">Home</a>
                <a href="<?php echo e(route('categories')); ?>" class="nav-link <?php echo e(request()->routeIs('categories') ? 'text-primary-600 font-semibold' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors text-sm font-medium">Categories</a>
                <a href="<?php echo e(route('services')); ?>"   class="nav-link <?php echo e(request()->routeIs('services') ? 'text-primary-600 font-semibold' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors text-sm font-medium">Services</a>
                <a href="<?php echo e(route('blogs')); ?>"      class="nav-link <?php echo e(request()->routeIs('blogs') ? 'text-primary-600 font-semibold' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors text-sm font-medium">Blogs</a>
                <a href="<?php echo e(route('providers')); ?>"  class="nav-link <?php echo e(request()->routeIs('providers') ? 'text-primary-600 font-semibold' : 'text-gray-600 hover:text-primary-600'); ?> transition-colors text-sm font-medium">Providers</a>
            </div>

            
            <div class="flex items-center gap-3">
                
                <button onclick="toggleDark()" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Toggle theme">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:block text-yellow-400"></i>
                </button>

                <?php if(auth()->guard()->check()): ?>
                    
                    <button class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 relative">
                        <i class="fas fa-bell"></i>
                    </button>

                    <div class="relative group">
                        <button class="flex items-center gap-2 rounded-full hover:opacity-80 transition">
                            <img src="<?php echo e(auth()->user()->profile_image_url); ?>" class="w-8 h-8 rounded-full object-cover" alt="">
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-1">
                                <div class="px-4 py-2 text-sm text-gray-500 border-b dark:border-gray-700">
                                    <?php echo e(auth()->user()->full_name); ?>

                                </div>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="dd-item"><i class="fas fa-tachometer-alt w-4"></i> Admin Panel</a>
                                <?php elseif(auth()->user()->isProvider() || auth()->user()->isHandyman()): ?>
                                    <a href="<?php echo e(route('provider.dashboard')); ?>" class="dd-item"><i class="fas fa-tachometer-alt w-4"></i> Dashboard</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('customer.dashboard')); ?>" class="dd-item"><i class="fas fa-tachometer-alt w-4"></i> Dashboard</a>
                                    <a href="<?php echo e(route('customer.bookings.index')); ?>" class="dd-item"><i class="fas fa-calendar-check w-4"></i> My Bookings</a>
                                <?php endif; ?>
                                <a href="#" class="dd-item"><i class="fas fa-user w-4"></i> Profile</a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="border-t dark:border-gray-700 mt-1 pt-1">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dd-item w-full text-left text-red-500"><i class="fas fa-sign-out-alt w-4"></i> Log Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 bg-primary-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors">
                        <i class="fas fa-user text-xs"></i> Login
                    </a>
                <?php endif; ?>

                
                <button onclick="toggleMobileNav()" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

    
    <div id="mobileNav" class="hidden md:hidden bg-white dark:bg-gray-800 border-t dark:border-gray-700">
        <div class="px-4 py-3 space-y-2">
            <a href="<?php echo e(route('home')); ?>"       class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">Home</a>
            <a href="<?php echo e(route('categories')); ?>" class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">Categories</a>
            <a href="<?php echo e(route('services')); ?>"   class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">Services</a>
            <a href="<?php echo e(route('blogs')); ?>"      class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">Blogs</a>
            <a href="<?php echo e(route('providers')); ?>"  class="block px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700">Providers</a>
        </div>
    </div>
</nav>


<?php if(session('success')): ?>
    <div class="fixed top-20 right-4 z-50 bg-green-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 fade-in" id="flashMsg">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
    </div>
<?php endif; ?>
<?php if(session('error') || $errors->any()): ?>
    <div class="fixed top-20 right-4 z-50 bg-red-500 text-white px-5 py-3 rounded-xl shadow-lg flex items-center gap-3 fade-in">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo e(session('error') ?? $errors->first()); ?>

        <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100"><i class="fas fa-times"></i></button>
    </div>
<?php endif; ?>


<?php if (! empty(trim($__env->yieldContent('page_header')))): ?>
<div class="bg-gradient-to-r from-primary-600 to-purple-600 text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid)"/></svg>
    </div>
    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
        <?php echo $__env->yieldContent('page_header'); ?>
    </div>
</div>
<?php endif; ?>


<main>
    <?php echo $__env->yieldContent('content'); ?>
</main>


<footer class="bg-gray-900 dark:bg-gray-950 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tools text-white"></i>
                    </div>
                    <span class="font-bold text-white text-lg">
                        <?php echo e(\App\Models\SystemConfig::where('key','company_name')->value('value') ?? 'Service Booking'); ?>

                    </span>
                </div>
                <p class="text-sm text-gray-400 mb-4"><?php echo e(\App\Models\SystemConfig::where('key','footer_description')->value('value') ?? 'Your trusted platform for home services.'); ?></p>
                <div class="flex gap-3">
                    <?php $__currentLoopData = ['facebook','twitter','instagram','linkedin','youtube']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($url = \App\Models\SystemConfig::where('key','social_'.$s)->value('value')): ?>
                        <a href="<?php echo e($url); ?>" class="w-9 h-9 rounded-full bg-gray-700 hover:bg-primary-600 flex items-center justify-center transition-colors">
                            <i class="fab fa-<?php echo e($s); ?> text-sm"></i>
                        </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('pages.about')); ?>" class="hover:text-primary-400 transition-colors">About Us</a></li>
                    <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-primary-400 transition-colors">Contact</a></li>
                    <li><a href="<?php echo e(route('services')); ?>" class="hover:text-primary-400 transition-colors">All Services</a></li>
                    <li><a href="<?php echo e(route('providers')); ?>" class="hover:text-primary-400 transition-colors">Find Provider</a></li>
                    <li><a href="<?php echo e(route('blogs')); ?>" class="hover:text-primary-400 transition-colors">Blog</a></li>
                </ul>
            </div>

            
            <div>
                <h4 class="text-white font-semibold mb-4">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('pages.terms')); ?>" class="hover:text-primary-400 transition-colors">Terms &amp; Conditions</a></li>
                    <li><a href="<?php echo e(route('pages.privacy')); ?>" class="hover:text-primary-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="<?php echo e(route('pages.refund')); ?>" class="hover:text-primary-400 transition-colors">Refund Policy</a></li>
                    <li><a href="<?php echo e(route('pages.help')); ?>" class="hover:text-primary-400 transition-colors">Help &amp; Support</a></li>
                </ul>
            </div>

            
            <div>
                <h4 class="text-white font-semibold mb-4">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <?php if($email = \App\Models\SystemConfig::where('key','contact_email')->value('value')): ?>
                    <li class="flex gap-3"><i class="fas fa-envelope mt-0.5 text-primary-400"></i> <a href="mailto:<?php echo e($email); ?>" class="hover:text-primary-400"><?php echo e($email); ?></a></li>
                    <?php endif; ?>
                    <?php if($phone = \App\Models\SystemConfig::where('key','contact_number')->value('value')): ?>
                    <li class="flex gap-3"><i class="fas fa-phone mt-0.5 text-primary-400"></i> <a href="tel:<?php echo e($phone); ?>" class="hover:text-primary-400"><?php echo e($phone); ?></a></li>
                    <?php endif; ?>

                    
                    <li class="mt-4 flex flex-col gap-2">
                        <?php if($gplay = \App\Models\SystemConfig::where('key','google_play_url')->value('value')): ?>
                        <a href="<?php echo e($gplay); ?>" class="inline-block"><img src="<?php echo e(asset('images/google-play-badge.png')); ?>" alt="Google Play" class="h-10"></a>
                        <?php endif; ?>
                        <?php if($astore = \App\Models\SystemConfig::where('key','app_store_url')->value('value')): ?>
                        <a href="<?php echo e($astore); ?>" class="inline-block"><img src="<?php echo e(asset('images/app-store-badge.png')); ?>" alt="App Store" class="h-10"></a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>© <?php echo e(date('Y')); ?> <?php echo e(\App\Models\SystemConfig::where('key','company_name')->value('value') ?? 'Service Booking'); ?>. All rights reserved.</p>
            <p>Built with ❤️ for better home services</p>
        </div>
    </div>
</footer>


<script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
<script>
    // Dark mode
    function toggleDark(){
        document.documentElement.classList.toggle('dark');
        const isDark = document.documentElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        fetch('/settings/theme', {method:'POST',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content,'Content-Type':'application/json'},body:JSON.stringify({theme:isDark?'dark':'light'})}).catch(()=>{});
    }
    // Load saved theme
    if(localStorage.getItem('theme')==='dark'||(!localStorage.getItem('theme')&&window.matchMedia('(prefers-color-scheme: dark)').matches)){
        document.documentElement.classList.add('dark');
    }

    function toggleMobileNav(){
        document.getElementById('mobileNav').classList.toggle('hidden');
    }

    // Auto-hide flash
    setTimeout(()=>{ const m=document.getElementById('flashMsg'); if(m) m.style.opacity='0'; }, 4000);

    // Dropdown item styles (set via JS to avoid repetition)
    document.querySelectorAll('.dd-item').forEach(el=>{
        el.classList.add('flex','items-center','gap-2','px-4','py-2','text-sm','text-gray-700','dark:text-gray-200','hover:bg-gray-50','dark:hover:bg-gray-700','transition-colors','cursor-pointer');
    });
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/layouts/public/app.blade.php ENDPATH**/ ?>