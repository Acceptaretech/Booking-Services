<?php $__env->startSection('title','Provider Dashboard'); ?>
<?php $__env->startSection('page_title','Dashboard'); ?>

<?php $__env->startSection('content'); ?>


<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <?php $__currentLoopData = [
        ['Total Booking','fas fa-calendar-check',$stats['total_bookings'],'bg-blue-100 text-blue-600'],
        ['Total Service','fas fa-tools',$stats['total_services'],'bg-purple-100 text-purple-600'],
        ['Remaining Payout','fas fa-wallet','$'.number_format($stats['remaining_payout'],2),'bg-green-100 text-green-600'],
        ['Total Revenue','fas fa-chart-line','$'.number_format($stats['total_revenue'],2),'bg-orange-100 text-orange-600'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="stat-card">
        <div class="w-12 h-12 <?php echo e($card[3]); ?> rounded-xl flex items-center justify-center flex-shrink-0 text-lg">
            <i class="<?php echo e($card[1]); ?>"></i>
        </div>
        <div>
            <p class="text-xl font-bold text-gray-900 dark:text-white"><?php echo e($card[2]); ?></p>
            <p class="text-xs text-gray-500"><?php echo e($card[0]); ?></p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="card p-6 mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-gray-900 dark:text-white">Monthly Revenue</h2>
    </div>
    <canvas id="revenueChart" height="90"></canvas>
</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Top Handyman</h3>
            <a href="<?php echo e(route('provider.handymen.index')); ?>" class="text-primary-600 text-xs hover:underline">View All</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $topHandymen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center gap-3">
                <img src="<?php echo e($h->profile_image_url); ?>" class="w-10 h-10 rounded-full object-cover" alt="">
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo e($h->full_name); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($h->created_at->format('M d, Y g:i A')); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-400 text-center py-4">No handymen yet</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-sm text-gray-900 dark:text-white">Recent Bookings</h3>
            <a href="<?php echo e(route('provider.bookings.index')); ?>" class="text-primary-600 text-xs hover:underline">View All</a>
        </div>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <img src="<?php echo e($b->customer->profile_image_url); ?>" class="w-10 h-10 rounded-full object-cover" alt="">
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-500">#<?php echo e($b->id); ?></p>
                    <p class="text-xs text-gray-400"><?php echo e($b->booking_date->format('M d, Y g:i A')); ?></p>
                </div>
                <?php $sc=['completed'=>'badge-success','pending'=>'badge-warning','cancelled'=>'badge-danger']; ?>
                <span class="badge <?php echo e($sc[$b->status] ?? 'badge-pending'); ?>"><?php echo e(ucfirst($b->status)); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-400 text-center py-4">No recent bookings</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [{
            data: <?php echo json_encode($revenueData, 15, 512) ?>,
            borderColor:'#6366f1',backgroundColor:'rgba(99,102,241,0.06)',
            borderWidth:2,tension:0.4,fill:true,
            pointBackgroundColor:'#6366f1',pointRadius:3,
        }]
    },
    options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{callback:v=>'$'+v}},x:{grid:{display:false}}}}
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/provider/dashboard.blade.php ENDPATH**/ ?>