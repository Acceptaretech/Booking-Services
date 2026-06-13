<?php $__env->startSection('title', 'My Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $user = auth()->user();

    $customerName = $user->first_name
        ?? $user->firstname
        ?? $user->name
        ?? 'Customer';

    $customerEmail = $user->email ?? 'customer@example.com';

    $walletBalance = $stats['wallet_balance'] ?? 500;
    $pendingServices = $stats['pending_bookings'] ?? 4;
    $completedServices = $stats['completed_bookings'] ?? 16;
    $totalBookings = $stats['total_bookings'] ?? 20;
?>

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-blue-50 to-indigo-50 py-6 lg:py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            
            <?php echo $__env->make('customer.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <main class="space-y-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900">
                            Dashboard
                        </h1>
                        <p class="text-slate-500 mt-1">
                            Welcome back, <?php echo e($customerName); ?> 👋
                        </p>
                    </div>
                </div>

                
                <section class="relative overflow-hidden bg-white rounded-[28px] shadow-sm p-6 sm:p-8">

                    <div class="absolute right-0 top-0 w-40 h-40 bg-sky-100 rounded-full -mr-16 -mt-16"></div>
                    <div class="absolute right-20 bottom-0 w-24 h-24 bg-indigo-100 rounded-full -mb-12"></div>

                    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                        <div class="flex flex-col sm:flex-row sm:items-center gap-5 text-center sm:text-left">

                            <?php if(!empty($user->profile_image)): ?>
                                <img
                                    src="<?php echo e(asset('storage/' . $user->profile_image)); ?>"
                                    class="w-24 h-24 sm:w-28 sm:h-28 mx-auto sm:mx-0 rounded-full border-4 border-sky-200 object-cover"
                                    alt="<?php echo e($customerName); ?>">
                            <?php else: ?>
                                <img
                                    src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($customerName)); ?>&background=dff4ff&color=0b86d1&size=160"
                                    class="w-24 h-24 sm:w-28 sm:h-28 mx-auto sm:mx-0 rounded-full border-4 border-sky-200 object-cover"
                                    alt="<?php echo e($customerName); ?>">
                            <?php endif; ?>

                            <div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                                    <?php echo e(strtoupper($customerName)); ?>

                                </h2>

                                <p class="text-slate-500 mt-2 break-all">
                                    <?php echo e($customerEmail); ?>

                                </p>
                            </div>

                        </div>

                        <a href="<?php echo e(Route::has('customer.profile') ? route('customer.profile') : '#'); ?>"
                           class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl border border-sky-400 text-sky-600 hover:bg-sky-50 transition font-semibold">
                            <i class="fas fa-pen-to-square"></i>
                            Edit
                        </a>

                    </div>

                </section>

                
                <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                    <div class="bg-white rounded-[24px] p-6 shadow-sm hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500">Wallet Balance</p>
                                <h3 class="text-4xl font-extrabold mt-4 text-slate-900">
                                    ₹<?php echo e(number_format($walletBalance)); ?>

                                </h3>
                            </div>
                            <div class="w-16 h-16 rounded-2xl bg-sky-100 text-sky-500 flex items-center justify-center text-3xl">
                                <i class="fas fa-wallet"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] p-6 shadow-sm hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500">Pending Services</p>
                                <h3 class="text-4xl font-extrabold mt-4 text-slate-900">
                                    <?php echo e($pendingServices); ?>

                                </h3>
                            </div>
                            <div class="w-16 h-16 rounded-2xl bg-orange-100 text-orange-500 flex items-center justify-center text-3xl">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] p-6 shadow-sm hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500">Completed</p>
                                <h3 class="text-4xl font-extrabold mt-4 text-slate-900">
                                    <?php echo e($completedServices); ?>

                                </h3>
                            </div>
                            <div class="w-16 h-16 rounded-2xl bg-green-100 text-green-500 flex items-center justify-center text-3xl">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] p-6 shadow-sm hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-slate-500">Total Bookings</p>
                                <h3 class="text-4xl font-extrabold mt-4 text-slate-900">
                                    <?php echo e($totalBookings); ?>

                                </h3>
                            </div>
                            <div class="w-16 h-16 rounded-2xl bg-purple-100 text-purple-500 flex items-center justify-center text-3xl">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                    </div>

                </section>

            </main>

        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>