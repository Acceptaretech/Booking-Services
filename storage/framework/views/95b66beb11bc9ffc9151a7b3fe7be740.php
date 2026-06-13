

<?php $__env->startSection('title', 'Packages'); ?>
<?php $__env->startSection('page_title', 'Packages'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input
            type="text"
            name="search"
            value="<?php echo e(request('search')); ?>"
            placeholder="Search packages..."
            class="form-input w-52 text-xs">

        <select name="status" class="form-select w-36 text-xs" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
        </select>
    </form>

    <a href="<?php echo e(route('admin.packages.create')); ?>" class="btn-primary text-xs">
        <i class="fas fa-plus"></i>
        New Package
    </a>
</div>

<div class="card overflow-hidden">
    <table class="data-table w-full">
        <thead>
            <tr>
                <th>Package</th>
                <th>Provider</th>
                <th>Category</th>
                <th>Service</th>
                <th>Price</th>
                <th>Status</th>
                <th width="120">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="<?php echo e($package->image_url); ?>"
                                 class="w-10 h-10 rounded-xl object-cover">

                            <div>
                                <p class="font-semibold text-sm">
                                    <?php echo e($package->name); ?>

                                </p>

                                <p class="text-xs text-gray-400">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $package->package_type ?? 'single_category'))); ?>

                                </p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <?php echo e($package->provider->full_name ?? $package->provider->name ?? 'No Provider'); ?>

                    </td>

                    <td>
                        <?php echo e($package->category->name ?? 'No Category'); ?>

                    </td>

                    <td>
                        <?php echo e($package->service->name ?? 'No Service'); ?>

                    </td>

                    <td>
                        <span class="font-semibold text-primary-600">
                            $<?php echo e(number_format((float) $package->price, 2)); ?>

                        </span>

                        <?php if($package->original_price): ?>
                            <p class="text-xs text-red-500">
                                <s>$<?php echo e(number_format((float) $package->original_price, 2)); ?></s>
                            </p>
                        <?php endif; ?>
                    </td>

                    <td>
                        <span class="badge <?php echo e($package->status === 'active' ? 'badge-success' : 'badge-pending'); ?>">
                            <?php echo e(ucfirst($package->status ?? 'inactive')); ?>

                        </span>
                    </td>

                    <td>
                        <div class="flex items-center gap-1">
                            <a href="<?php echo e(route('admin.packages.edit', $package->id)); ?>"
                               class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                <i class="fas fa-edit text-xs"></i>
                            </a>

                            <form method="POST"
                                  action="<?php echo e(route('admin.packages.destroy', $package->id)); ?>"
                                  onsubmit="return confirm('Delete this package?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button type="submit"
                                        class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-12 text-gray-400">
                        No packages found
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="px-5 py-3">
        <?php echo e($packages->withQueryString()->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/packages/index.blade.php ENDPATH**/ ?>