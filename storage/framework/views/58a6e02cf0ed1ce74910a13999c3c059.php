

<?php $__env->startSection('title', 'Shops'); ?>
<?php $__env->startSection('page_title', 'All Shop'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form method="GET" class="flex gap-2 flex-wrap">
        <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search shop..." class="form-input w-52 text-xs">

        <select name="status" class="form-select w-36 text-xs" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
        </select>
    </form>

    <a href="<?php echo e(route('admin.shops.create')); ?>" class="btn-primary">
        <i class="fas fa-plus-circle"></i> New Shop
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="data-table w-full">
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th>Provider</th>
                    <th>City</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th width="130">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <img src="<?php echo e($shop->image_url); ?>" class="w-10 h-10 rounded-full object-cover">
                                <div>
                                    <p class="font-semibold"><?php echo e($shop->name); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo e($shop->email); ?></p>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div>
                                <p class="font-semibold"><?php echo e($shop->provider->full_name ?? $shop->provider->name ?? 'No Provider'); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e($shop->provider->email ?? ''); ?></p>
                            </div>
                        </td>

                        <td><?php echo e($shop->city ?? '-'); ?></td>

                        <td><?php echo e($shop->country_code ?? '+91'); ?> <?php echo e($shop->phone ?? '-'); ?></td>

                        <td>
                            <span class="badge <?php echo e($shop->status === 'active' ? 'badge-success' : 'badge-pending'); ?>">
                                <?php echo e(ucfirst($shop->status)); ?>

                            </span>
                        </td>

                        <td>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.shops.show', $shop->id)); ?>" class="text-green-600" title="View">
                                    <i class="far fa-clock"></i>
                                </a>

                                <a href="<?php echo e(route('admin.shops.edit', $shop->id)); ?>" class="text-blue-500" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form method="POST" action="<?php echo e(route('admin.shops.destroy', $shop->id)); ?>" onsubmit="return confirm('Delete this shop?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-500" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-10 text-gray-400">No shops found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="px-5 py-3">
        <?php echo e($shops->withQueryString()->links()); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/shops/index.blade.php ENDPATH**/ ?>