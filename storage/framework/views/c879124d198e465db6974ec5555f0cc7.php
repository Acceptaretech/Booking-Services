
<?php $__env->startSection('page_title','Provider Commission List'); ?>

<?php $__env->startSection('content'); ?>

<div class="card p-5 mb-6 flex justify-between items-center">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Provider Commission List
    </h2>
</div>

<div class="card p-6">

   

    <div class="flex justify-between items-center mb-5 gap-4 flex-wrap">


        <form method="GET" action="<?php echo e(route('admin.providers.commissions')); ?>" class="flex gap-4">

            <select name="status" class="border rounded px-5 py-3 text-sm bg-white dark:bg-gray-800">
                <option value="all" <?php echo e(request('status') == 'all' ? 'selected' : ''); ?>>All</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
            </select>

            <div class="relative">
                <i class="fas fa-search absolute left-4 top-4 text-gray-500"></i>
                <input type="text"
                       name="search"
                       value="<?php echo e(request('search')); ?>"
                       placeholder="Search..."
                       class="pl-11 pr-4 py-3 border rounded w-44 bg-white dark:bg-gray-800 text-sm">
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-5 py-3 rounded font-semibold">
                Search
            </button>

            <a href="<?php echo e(route('admin.providers.commissions')); ?>"
               class="bg-gray-500 text-white px-5 py-3 rounded font-semibold">
                Reset
            </a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm border rounded-xl overflow-hidden">
            <thead>
                <tr class="bg-indigo-600 text-white">
                    <th class="p-4 text-left">
                        <input type="checkbox"
                               onclick="document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked)">
                    </th>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Commission</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b odd:bg-gray-100 dark:odd:bg-gray-800">
                        <td class="p-4">
                            <input type="checkbox"
                                   form="bulkForm"
                                   class="row-check"
                                   name="ids[]"
                                   value="<?php echo e($provider->id); ?>">
                        </td>

                        <td class="p-4">
                            <span class="text-indigo-600 font-medium">
                                <?php echo e($provider->first_name ?? $provider->name ?? 'Provider'); ?>

                                <?php echo e($provider->last_name ?? ''); ?>

                            </span>
                            <div class="text-xs text-gray-500">
                                <?php echo e($provider->email ?? ''); ?>

                            </div>
                        </td>

                        <td class="p-4 text-gray-800 dark:text-gray-200">
                            <?php if(($provider->commission_type ?? '') == 'fixed'): ?>
                                ₹<?php echo e(number_format($provider->commission ?? 0, 2)); ?>

                            <?php else: ?>
                                <?php echo e($provider->commission ?? 0); ?>%
                            <?php endif; ?>
                        </td>

                        <td class="p-4">
                            <form method="POST" action="<?php echo e(route('admin.providers.commissions.toggle', $provider->id)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>

                                <button type="submit"
                                        class="w-14 h-7 rounded-full relative <?php echo e(($provider->status ?? 'active') == 'active' ? 'bg-indigo-600' : 'bg-gray-300'); ?>">
                                    <span class="absolute top-1 w-5 h-5 bg-white rounded-full transition-all <?php echo e(($provider->status ?? 'active') == 'active' ? 'right-1' : 'left-1'); ?>"></span>
                                </button>
                            </form>
                        </td>

                        <td class="p-4">
                            <form method="POST"
                                  action="<?php echo e(route('admin.providers.commissions.delete', $provider->id)); ?>"
                                  onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button type="submit" class="text-red-500">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400">
                            No commission records found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="flex justify-between items-center mt-5">
        <div class="text-sm text-gray-700 dark:text-gray-300">
            Total: <?php echo e($providers->total()); ?>

        </div>

        <div>
            <?php echo e($providers->links()); ?>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/providers/commissions.blade.php ENDPATH**/ ?>