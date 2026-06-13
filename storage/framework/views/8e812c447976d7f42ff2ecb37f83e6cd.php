<?php $__env->startSection('title', 'All Users'); ?>
<?php $__env->startSection('page_title', 'All Users'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
            <input
                type="text"
                name="search"
                value="<?php echo e(request('search')); ?>"
                placeholder="Search users..."
                class="form-input pl-8 py-2 w-56 text-xs">
        </div>

        <select name="status" class="form-select text-xs py-2 w-36" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>Pending</option>
            <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Rejected</option>
        </select>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-primary-600 text-white">
                    <th class="px-4 py-4 text-left">Name</th>
                    <th class="px-4 py-4 text-left">User Type</th>
                    <th class="px-4 py-4 text-left">Joining Date</th>
                    <th class="px-4 py-4 text-left">Contact Number</th>
                    <th class="px-4 py-4 text-left">Address</th>
                    <th class="px-4 py-4 text-left">Total Points</th>
                    <th class="px-4 py-4 text-left">Current Points</th>
                    <th class="px-4 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $status = $user->status ?? 'inactive';

                        $statusClasses = [
                            'active'   => 'bg-green-100 text-green-700',
                            'pending'  => 'bg-yellow-100 text-yellow-700',
                            'rejected' => 'bg-red-100 text-red-700',
                            'inactive' => 'bg-red-100 text-red-700',
                        ];

                        $fullName = $user->full_name
                            ?? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))
                            ?: ($user->name ?? 'User');
                    ?>

                    <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition">
                        <td class="px-4 py-5">
                            <div class="flex items-center gap-3">
                                <img
                                    src="<?php echo e($user->profile_image_url ?? asset('images/default-user.png')); ?>"
                                    class="w-11 h-11 rounded-full object-cover bg-gray-100"
                                    alt="User">

                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        <?php echo e($fullName); ?>

                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <?php echo e($user->email ?? '-'); ?>

                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            <?php echo e(ucfirst($user->role ?? $user->user_type ?? 'user')); ?>

                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            <?php echo e(optional($user->created_at)->format('F d, Y')); ?>

                            <br>
                            <span class="text-sm text-gray-500">
                                <?php echo e(optional($user->created_at)->format('g:i A')); ?>

                            </span>
                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            <?php echo e($user->phone ?? '-'); ?>

                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300 max-w-xs">
                            <?php echo e($user->address ?? '-'); ?>

                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            <?php echo e($user->total_points ?? 0); ?>

                        </td>

                        <td class="px-4 py-5 text-gray-700 dark:text-gray-300">
                            <?php echo e($user->current_points ?? 0); ?>

                        </td>

                        <td class="px-4 py-5 text-center">
                            <span class="px-4 py-1.5 rounded-lg text-sm font-medium <?php echo e($statusClasses[$status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e(ucfirst($status)); ?>

                            </span>
                        </td>

                        <td class="px-4 py-5">
                            <div class="flex items-center justify-center gap-3">
                        
                                
                        
                                <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                   class="text-blue-400 hover:text-blue-600"
                                   title="Edit">
                                    <i class="fas fa-pen"></i>
                                </a>
                        
                                <form method="POST"
                                      action="<?php echo e(route('admin.users.destroy', $user->id)); ?>"
                                      onsubmit="return confirm('Delete this user?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                        
                                    <button type="submit" class="text-red-500 hover:text-red-600" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                        
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-12 text-gray-400">
                            <i class="fas fa-users text-4xl mb-3 block"></i>
                            No users found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if($users->hasPages()): ?>
    <div class="mt-5">
        <?php echo e($users->withQueryString()->links()); ?>

    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/users/index.blade.php ENDPATH**/ ?>