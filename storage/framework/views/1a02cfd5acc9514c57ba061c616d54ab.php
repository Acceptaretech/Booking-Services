<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startSection('panel_name','Admin'); ?>
<?php $__env->startSection('page_title','Dashboard'); ?>
<?php $__env->startSection('breadcrumb','Overview of platform performance'); ?>

<?php $__env->startSection('content'); ?>


<?php if(!\App\Models\SystemConfig::where('key','razorpay_key')->whereNotNull('value')->exists()): ?>
<div class="flex items-start gap-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-4 py-3 rounded-xl mb-5 text-sm fade-in">
    <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
    <span>Important Notice: Please enable RazorpayX from <a href="<?php echo e(route('admin.settings.index')); ?>" class="font-semibold underline">PAYMENT CONFIGURATION</a> to allow providers to withdraw funds. <a href="<?php echo e(route('admin.settings.index')); ?>" class="underline font-medium ml-1">Here is the link ↗</a></span>
</div>
<?php endif; ?>


<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <div class="stat-card fade-in" style="animation-delay:.05s">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-violet-200 dark:shadow-violet-900/30">
            <i class="fas fa-concierge-bell text-white text-lg"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($stats['total_services'])); ?></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Services</p>
            <p class="text-xs text-emerald-500 font-medium mt-1 flex items-center gap-1"><i class="fas fa-arrow-up text-[10px]"></i> Active now</p>
        </div>
    </div>

    <div class="stat-card fade-in" style="animation-delay:.1s">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-200 dark:shadow-blue-900/30">
            <i class="fas fa-receipt text-white text-lg"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">$<?php echo e(number_format($stats['total_revenue']*0.135,2)); ?></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Tax</p>
            <p class="text-xs text-blue-500 font-medium mt-1 flex items-center gap-1"><i class="fas fa-percentage text-[10px]"></i> 13.5% rate</p>
        </div>
    </div>

    <div class="stat-card fade-in" style="animation-delay:.15s">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-200 dark:shadow-emerald-900/30">
            <i class="fas fa-wallet text-white text-lg"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">$<?php echo e(number_format($stats['my_earning'],2)); ?></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">My Earning</p>
            <p class="text-xs text-emerald-500 font-medium mt-1 flex items-center gap-1"><i class="fas fa-arrow-up text-[10px]"></i> Commission earned</p>
        </div>
    </div>

    <div class="stat-card fade-in" style="animation-delay:.2s">
        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-rose-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-orange-200 dark:shadow-orange-900/30">
            <i class="fas fa-chart-line text-white text-lg"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-bold text-gray-900 dark:text-white">$<?php echo e(number_format($stats['total_revenue'],2)); ?></p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Revenue</p>
            <p class="text-xs text-orange-500 font-medium mt-1 flex items-center gap-1"><i class="fas fa-calendar-alt text-[10px]"></i> All time</p>
        </div>
    </div>
</div>


<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">

    <?php $__currentLoopData = [
        ['Total Bookings', $stats['total_bookings'], 'fas fa-calendar-check', 'text-primary-600', 'bg-primary-50 dark:bg-primary-900/20'],
        ['Pending Bookings', $stats['pending_bookings'], 'fas fa-clock', 'text-amber-600', 'bg-amber-50 dark:bg-amber-900/20'],
        ['Total Providers', $stats['total_providers'], 'fas fa-user-tie', 'text-violet-600', 'bg-violet-50 dark:bg-violet-900/20'],
        ['Total Customers', $stats['total_customers'], 'fas fa-users', 'text-cyan-600', 'bg-cyan-50 dark:bg-cyan-900/20'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <div class="card p-4 flex items-center gap-3 fade-in">

        <div class="w-10 h-10 rounded-xl <?php echo e($s[4]); ?> flex items-center justify-center flex-shrink-0">
            <i class="<?php echo e($s[2]); ?> <?php echo e($s[3]); ?> text-sm"></i>
        </div>

        <div>
            <p class="text-xl font-bold <?php echo e($s[3]); ?>">
                <?php echo e(number_format((float) $s[1])); ?>

            </p>

            <p class="text-xs text-gray-500 dark:text-gray-400">
                <?php echo e($s[0]); ?>

            </p>
        </div>

    </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>


<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">

    
    <div class="xl:col-span-2 card p-5 fade-in">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="font-semibold text-gray-900 dark:text-white">Monthly Revenue</h2>
                <p class="text-xs text-gray-400 mt-0.5"><?php echo e(now()->year); ?> earnings overview</p>
            </div>
            <div class="flex items-center gap-2">
                <select id="chartYear" class="text-xs border border-gray-200 dark:border-gray-700 rounded-lg px-2 py-1.5 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 outline-none">
                    <?php for($y = now()->year; $y >= now()->year-3; $y--): ?>
                    <option value="<?php echo e($y); ?>"><?php echo e($y); ?></option>
                    <?php endfor; ?>
                </select>
                <button class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 hover:text-primary-600 text-xs"><i class="fas fa-expand"></i></button>
                <button class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400 hover:text-primary-600 text-xs"><i class="fas fa-download"></i></button>
            </div>
        </div>
        <div class="relative">
            <canvas id="revenueChart" height="220"></canvas>
        </div>
    </div>

    
    <div class="card p-5 fade-in">
        <h2 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <?php $__currentLoopData = [
                ['Add Service','fas fa-plus-circle','from-violet-500 to-purple-600',route('admin.services.create')],
                ['Add Category','fas fa-layer-group','from-blue-500 to-cyan-500',route('admin.categories.create')],
                ['Add Coupon','fas fa-ticket-alt','from-emerald-500 to-teal-500',route('admin.coupons.create')],
                ['Add Blog','fas fa-newspaper','from-orange-500 to-rose-500',route('admin.blogs.create')],
                ['View Bookings','fas fa-calendar-check','from-pink-500 to-rose-500',route('admin.bookings.index')],
                ['View Reports','fas fa-chart-bar','from-indigo-500 to-blue-600',route('admin.reports.index')],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($qa[3]); ?>" class="flex flex-col items-center gap-2 p-3 rounded-xl bg-gradient-to-br <?php echo e($qa[2]); ?> text-white hover:opacity-90 hover:scale-105 transition-all text-center shadow-sm">
                <i class="<?php echo e($qa[1]); ?> text-xl"></i>
                <span class="text-xs font-medium leading-tight"><?php echo e($qa[0]); ?></span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Platform Health</p>
            <?php
                $total = max($stats['total_bookings'],1);
                $completed = \App\Models\Booking::where('status','completed')->count();
                $completionRate = round($completed/$total*100);
            ?>
            <div class="space-y-2">
                <div>
                    <div class="flex justify-between text-xs mb-1"><span class="text-gray-500">Completion Rate</span><span class="font-semibold text-gray-700 dark:text-gray-200"><?php echo e($completionRate); ?>%</span></div>
                    <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-primary-500 to-purple-500 rounded-full" style="width:<?php echo e($completionRate); ?>%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between text-xs mb-1"><span class="text-gray-500">Provider Approval</span><span class="font-semibold text-gray-700 dark:text-gray-200"><?php echo e($stats['total_providers']); ?> active</span></div>
                    <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden"><div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full" style="width:75%"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    
    <div class="card fade-in">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Recent Providers</h3>
                <p class="text-xs text-gray-400"><?php echo e($stats['total_providers']); ?> total</p>
            </div>
            <a href="<?php echo e(route('admin.providers.index')); ?>" class="text-xs text-primary-600 hover:underline font-medium">View All →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/50">
            <?php $__empty_1 = true; $__currentLoopData = $recentProviders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center gap-3 px-5 py-3">
                <div class="relative flex-shrink-0">
                    <img src="<?php echo e($p->profile_image_url); ?>" class="w-9 h-9 rounded-xl object-cover" alt="">
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full <?php echo e($p->isActive() ? 'bg-emerald-400' : 'bg-gray-300'); ?> border-2 border-white dark:border-gray-800"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate"><?php echo e($p->full_name); ?></p>
                    <p class="text-xs text-gray-400 truncate"><?php echo e($p->email); ?></p>
                </div>
                <div class="flex-shrink-0 text-right">
                    <div class="flex items-center gap-0.5"><i class="fas fa-star text-yellow-400 text-[10px]"></i><span class="text-xs text-gray-400"><?php echo e(number_format($p->reviews_avg_rating ?? 0, 1)); ?></span></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center text-sm text-gray-400">No providers yet</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card fade-in">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Recent Customers</h3>
                <p class="text-xs text-gray-400"><?php echo e($stats['total_customers']); ?> total</p>
            </div>
            <a href="<?php echo e(route('admin.customers.index')); ?>" class="text-xs text-primary-600 hover:underline font-medium">View All →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/50">
            <?php $__empty_1 = true; $__currentLoopData = $recentCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center gap-3 px-5 py-3">
                <img src="<?php echo e($c->profile_image_url); ?>" class="w-9 h-9 rounded-xl object-cover flex-shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate"><?php echo e($c->full_name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($c->created_at->format('M d, Y')); ?></p>
                </div>
                <span class="text-xs bg-primary-50 dark:bg-primary-900/20 text-primary-600 px-2 py-0.5 rounded-full flex-shrink-0">
                    <?php echo e($c->customerBookings->count() ?? 0); ?> bookings
                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center text-sm text-gray-400">No customers yet</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card fade-in">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h3 class="font-semibold text-sm text-gray-900 dark:text-white">Recent Bookings</h3>
                <p class="text-xs text-gray-400"><?php echo e($stats['total_bookings']); ?> total</p>
            </div>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-xs text-primary-600 hover:underline font-medium">View All →</a>
        </div>
        <div class="divide-y divide-gray-50 dark:divide-gray-700/50">
            <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('admin.bookings.show',$b)); ?>" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-100 to-purple-100 dark:from-primary-900/30 dark:to-purple-900/30 flex items-center justify-center flex-shrink-0">
                    <span class="text-primary-600 text-xs font-bold">#<?php echo e($b->id); ?></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate"><?php echo e(Str::limit($b->service->name,22)); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($b->booking_date->format('M d · g:i A')); ?></p>
                </div>
                <?php $bc=['completed'=>'badge-success','pending'=>'badge-warning','cancelled'=>'badge-danger','accepted'=>'badge-info','in_progress'=>'badge-info']; ?>
                <span class="badge <?php echo e($bc[$b->status]??'badge-pending'); ?> flex-shrink-0"><?php echo e(ucfirst($b->status)); ?></span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center text-sm text-gray-400">No bookings yet</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const revenueData = <?php echo json_encode($revenueData, 15, 512) ?>;
const isDark = document.documentElement.classList.contains('dark');

const gridColor = isDark ? 'rgba(255,255,255,.05)' : 'rgba(0,0,0,.04)';
const labelColor = isDark ? '#94a3b8' : '#94a3b8';

const ctx = document.getElementById('revenueChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 250);
gradient.addColorStop(0, 'rgba(99,102,241,.25)');
gradient.addColorStop(1, 'rgba(99,102,241,0)');

const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Revenue ($)',
            data: revenueData,
            borderColor: '#6366f1',
            backgroundColor: gradient,
            borderWidth: 2.5,
            tension: 0.45,
            fill: true,
            pointRadius: 4,
            pointBackgroundColor: '#6366f1',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointHoverRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode:'index', intersect:false },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: isDark ? '#1e293b' : '#fff',
                titleColor: isDark ? '#e2e8f0' : '#1e293b',
                bodyColor: '#6366f1',
                borderColor: isDark ? '#334155' : '#f1f5f9',
                borderWidth: 1,
                padding: 12,
                displayColors: false,
                callbacks: { label: v => '$'+Number(v.raw).toLocaleString() }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: gridColor, drawBorder: false },
                ticks: { color: labelColor, font:{size:11}, callback: v => '$'+v }
            },
            x: {
                grid: { display: false },
                ticks: { color: labelColor, font:{size:11} }
            }
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>