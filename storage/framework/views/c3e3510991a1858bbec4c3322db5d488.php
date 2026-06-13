<?php $__env->startSection('title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $customerName = auth()->user()->first_name
        ?? auth()->user()->firstname
        ?? auth()->user()->name
        ?? 'Customer';
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Welcome back, <?php echo e($customerName); ?> 👋
        </h1>
        <p class="text-gray-500 dark:text-gray-400 mt-2">
            Track your bookings, service status, and recent activity from one place.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
        <?php $__currentLoopData = [
            ['Total Bookings', 'fas fa-calendar-check', $stats['total_bookings'] ?? 0, 'bg-blue-100 text-blue-600'],
            ['Pending Bookings', 'fas fa-clock', $stats['pending_bookings'] ?? 0, 'bg-yellow-100 text-yellow-600'],
            ['Completed', 'fas fa-check-circle', $stats['completed_bookings'] ?? 0, 'bg-green-100 text-green-600'],
            ['Cancelled', 'fas fa-times-circle', $stats['cancelled_bookings'] ?? 0, 'bg-red-100 text-red-600'],
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            <?php echo e($card[0]); ?>

                        </p>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                            <?php echo e($card[2]); ?>

                        </h2>
                    </div>

                    <div class="w-14 h-14 <?php echo e($card[3]); ?> rounded-2xl flex items-center justify-center">
                        <i class="<?php echo e($card[1]); ?> text-xl"></i>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-6 border-b border-gray-100 dark:border-gray-700">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    Recent Bookings
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Your latest service booking activity.
                </p>
            </div>

            <?php if(Route::has('customer.bookings.index')): ?>
                <a href="<?php echo e(route('customer.bookings.index')); ?>"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-primary-600 text-white text-sm font-semibold hover:bg-primary-700 transition">
                    View All
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            <?php endif; ?>
        </div>

        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $statusClasses = [
                        'completed' => 'bg-green-100 text-green-700',
                        'pending' => 'bg-yellow-100 text-yellow-700',
                        'cancelled' => 'bg-red-100 text-red-700',
                        'accepted' => 'bg-blue-100 text-blue-700',
                    ];

                    $serviceImage = $booking->service->image_url
                        ?? (!empty($booking->service->image) ? asset('storage/'.$booking->service->image) : asset('images/default-service.png'));

                    $serviceName = $booking->service->name ?? 'Service not available';

                    $providerName = $booking->provider->full_name
                        ?? trim(($booking->provider->first_name ?? '') . ' ' . ($booking->provider->last_name ?? ''))
                        ?: 'Provider not assigned';

                    $bookingDate = $booking->booking_date
                        ? \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y · g:i A')
                        : $booking->created_at->format('M d, Y');
                ?>

                <div class="p-6 flex flex-col md:flex-row md:items-center gap-5 hover:bg-gray-50 dark:hover:bg-gray-900 transition">
                    <div class="flex items-center gap-4 flex-1 min-w-0">
                        <img src="<?php echo e($serviceImage); ?>"
                             class="w-16 h-16 rounded-2xl object-cover bg-gray-100 border border-gray-100"
                             alt="<?php echo e($serviceName); ?>">

                        <div class="min-w-0">
                            <h3 class="font-semibold text-gray-900 dark:text-white truncate">
                                <?php echo e($serviceName); ?>

                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <i class="far fa-calendar-alt mr-1"></i>
                                <?php echo e($bookingDate); ?>

                            </p>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <i class="fas fa-user-tie mr-1"></i>
                                <?php echo e($providerName); ?>

                            </p>
                        </div>
                    </div>

                    <div class="flex md:flex-col items-start md:items-end justify-between gap-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-600'); ?>">
                            <?php echo e(ucfirst($booking->status ?? 'pending')); ?>

                        </span>

                        <p class="text-lg font-bold text-primary-600">
                            ₹<?php echo e(number_format($booking->total_amount ?? $booking->amount ?? 0, 2)); ?>

                        </p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 mx-auto rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                        <i class="fas fa-calendar-times text-3xl"></i>
                    </div>

                    <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-white">
                        No bookings yet
                    </h3>

                    <p class="text-gray-500 dark:text-gray-400 mt-2">
                        Start by booking your first service.
                    </p>

                    <?php if(Route::has('services')): ?>
                        <a href="<?php echo e(route('services')); ?>"
                           class="mt-5 inline-flex items-center px-5 py-2.5 rounded-xl bg-primary-600 text-white text-sm font-semibold hover:bg-primary-700 transition">
                            Book a Service
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/services')); ?>"
                           class="mt-5 inline-flex items-center px-5 py-2.5 rounded-xl bg-primary-600 text-white text-sm font-semibold hover:bg-primary-700 transition">
                            Book a Service
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>