<?php $__env->startSection('title','My Bookings'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Bookings</h1>
        <a href="<?php echo e(route('services')); ?>" class="bg-primary-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-700 transition-colors"><i class="fas fa-plus mr-1"></i> New Booking</a>
    </div>
    <div class="flex gap-2 mb-6 flex-wrap">
        <?php $__currentLoopData = [''=>'All','pending'=>'Pending','accepted'=>'Accepted','completed'=>'Completed','cancelled'=>'Cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('customer.bookings.index')); ?>?status=<?php echo e($val); ?>" class="px-4 py-1.5 rounded-full text-sm border <?php echo e(request('status')===$val ? 'bg-primary-600 text-white border-primary-600' : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:border-primary-400'); ?> transition-all"><?php echo e($label); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('customer.booking.show',$b)); ?>" class="block bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 hover:shadow-md hover:border-primary-300 transition-all">
            <div class="flex gap-4">
                <img src="<?php echo e($b->service->image_url); ?>" class="w-16 h-16 rounded-xl object-cover flex-shrink-0" alt="">
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-gray-200"><?php echo e($b->service->name); ?></p>
                            <p class="text-xs text-gray-400 mt-0.5"><?php echo e($b->booking_date->format('M d, Y · g:i A')); ?> · by <?php echo e($b->provider->full_name); ?></p>
                            <p class="text-xs text-gray-400">#<?php echo e($b->booking_number); ?></p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <?php $sc=['completed'=>'bg-green-100 text-green-700','pending'=>'bg-yellow-100 text-yellow-700','cancelled'=>'bg-red-100 text-red-700','accepted'=>'bg-blue-100 text-blue-700','in_progress'=>'bg-blue-100 text-blue-700']; ?>
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold <?php echo e($sc[$b->status] ?? 'bg-gray-100 text-gray-600'); ?>"><?php echo e(ucwords(str_replace('_',' ',$b->status))); ?></span>
                            <p class="text-base font-bold text-primary-600 mt-1">$<?php echo e(number_format($b->total_amount,2)); ?></p>
                            <p class="text-xs text-gray-400"><?php echo e(ucfirst($b->payment_type)); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-20 text-gray-400"><i class="fas fa-calendar-times text-5xl mb-4 block"></i><p class="text-lg mb-4">No bookings found</p>
        <a href="<?php echo e(route('services')); ?>" class="bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm">Book a Service</a></div>
        <?php endif; ?>
    </div>
    <div class="mt-6"><?php echo e($bookings->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/customer/bookings/index.blade.php ENDPATH**/ ?>