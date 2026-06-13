<?php $__env->startSection('page_title', 'Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Payments</h2>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6">

        <form method="GET" class="flex flex-col md:flex-row justify-end gap-4 mb-8">
            <select name="status" class="rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                <option value="">All</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Approved</option>
                <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                <option value="refunded" <?php echo e(request('status') == 'refunded' ? 'selected' : ''); ?>>Refunded</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-4 top-3.5 text-gray-400"></i>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Search..."
                       class="pl-11 rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
            </div>

            <button class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold">
                Filter
            </button>
        </form>

        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700">
            <table class="w-full min-w-[1100px]">
                <thead class="bg-indigo-600 text-white">
                    <tr>
                        <th class="p-5 text-left">Booking ID</th>
                        <th class="p-5 text-left">Transaction ID</th>
                        <th class="p-5 text-left">Service</th>
                        <th class="p-5 text-left">User</th>
                        <th class="p-5 text-left">Payment Type</th>
                        <th class="p-5 text-left">Status</th>
                        <th class="p-5 text-left">Date & Time</th>
                        <th class="p-5 text-left">Total Paid Amount</th>
                        <th class="p-5 text-center">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                            <td class="p-5 text-indigo-600 font-semibold">
                                <?php echo e($payment->booking_id); ?>

                            </td>

                            <td class="p-5">
                                #<?php echo e($payment->transaction_id ?? $payment->id); ?>

                            </td>

                            <td class="p-5">
                                <p class="font-semibold text-gray-800 dark:text-white">
                                    <?php echo e($payment->booking->service->name ?? 'N/A'); ?>

                                </p>
                                <p class="text-sm text-gray-500">(Service)</p>
                            </td>

                            <td class="p-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        <?php echo e(strtoupper(substr($payment->customer->first_name ?? $payment->customer->firstname ?? $payment->customer->name ?? 'U', 0, 1))); ?>

                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-900 dark:text-white">
                                            <?php echo e(trim(($payment->customer->first_name ?? $payment->customer->firstname ?? '') . ' ' . ($payment->customer->last_name ?? $payment->customer->lastname ?? '')) ?: ($payment->customer->name ?? 'No User')); ?>

                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <?php echo e($payment->customer->email ?? '-'); ?>

                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="p-5">
                                <?php echo e(ucfirst($payment->type ?? 'N/A')); ?>

                            </td>

                            <td class="p-5">
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                    <?php if($payment->status == 'approved'): ?> bg-green-100 text-green-700
                                    <?php elseif($payment->status == 'pending'): ?> bg-yellow-100 text-yellow-700
                                    <?php elseif($payment->status == 'failed'): ?> bg-red-100 text-red-700
                                    <?php else: ?> bg-gray-100 text-gray-700
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $payment->status ?? 'pending'))); ?>

                                </span>
                            </td>

                            <td class="p-5">
                                <?php echo e($payment->created_at->format('M d, Y h:i A')); ?>

                            </td>

                            <td class="p-5 font-bold text-gray-900 dark:text-white">
                                ₹<?php echo e(number_format($payment->amount ?? 0, 2)); ?>

                            </td>

                            <td class="p-5 text-center">
                                <a href="<?php echo e(route('admin.payments.show', $payment->id)); ?>"
                                   class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="p-10 text-center text-gray-500">
                                No payments found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <?php echo e($payments->links()); ?>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>