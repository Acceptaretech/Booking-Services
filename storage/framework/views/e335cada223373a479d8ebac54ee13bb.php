

<?php $__env->startSection('title', 'Unverified Users'); ?>
<?php $__env->startSection('page_title', 'Unverified Users'); ?>

<?php $__env->startSection('content'); ?>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-primary-600 text-white">
                    <th class="px-4 py-4 text-left">Name</th>
                    <th class="px-4 py-4 text-left">Joining Date</th>
                    <th class="px-4 py-4 text-left">Contact Number</th>
                    <th class="px-4 py-4 text-left">Address</th>
                    <th class="px-4 py-4 text-left">Total Points</th>
                    <th class="px-4 py-4 text-left">Current Points</th>
                    <th class="px-4 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center">Verify</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40">

                        <td class="px-4 py-5">
                            <div class="flex items-center gap-3">
                                <img src="<?php echo e($user->profile_image_url ?? asset('images/default-user.png')); ?>"
                                     class="w-11 h-11 rounded-full object-cover">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        <?php echo e($user->full_name ?? $user->name ?? 'User'); ?>

                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo e($user->email ?? '-'); ?>

                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-5">
                            <?php echo e(optional($user->created_at)->format('F d, Y')); ?>

                            <br>
                            <span class="text-sm text-gray-500">
                                <?php echo e(optional($user->created_at)->format('g:i A')); ?>

                            </span>
                        </td>

                        <td class="px-4 py-5">
                            <?php echo e($user->phone ?? '-'); ?>

                        </td>

                        <td class="px-4 py-5 max-w-xs">
                            <?php echo e($user->address ?? '-'); ?>

                        </td>

                        <td class="px-4 py-5">
                            <?php echo e($user->total_points ?? 0); ?>

                        </td>

                        <td class="px-4 py-5">
                            <?php echo e($user->current_points ?? 0); ?>

                        </td>

                        <td class="px-4 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-lg text-sm font-medium bg-green-100 text-green-700">
                                <?php echo e(ucfirst($user->status ?? 'active')); ?>

                            </span>
                        </td>

                        <td class="px-4 py-5 text-center">
                            <form method="POST" action="<?php echo e(route('admin.unverified-users.verify', $user->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>

                                <button type="submit"
                                        onclick="return confirm('Verify this user?')"
                                        class="relative inline-flex h-6 w-12 items-center rounded-full bg-gray-300 transition hover:bg-primary-500">
                                    <span class="inline-block h-5 w-5 transform rounded-full bg-white transition translate-x-1"></span>
                                </button>
                            </form>
                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-12 text-gray-400">
                            No unverified users found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5">
    <?php echo e($users->withQueryString()->links()); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/users/unverified.blade.php ENDPATH**/ ?>