

<?php $__env->startSection('title', 'Shop Detail'); ?>
<?php $__env->startSection('page_title', 'Shop Detail'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex items-center gap-3 mb-5">
    <a href="<?php echo e(route('admin.shops.index')); ?>" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <a href="<?php echo e(route('admin.shops.edit', $shop->id)); ?>" class="btn-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="card p-6 text-center">
        <img src="<?php echo e($shop->image_url); ?>"
             class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4">

        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            <?php echo e($shop->name); ?>

        </h2>

        <p class="text-sm text-gray-400 mt-1">
            <?php echo e($shop->email); ?>

        </p>

        <span class="badge <?php echo e($shop->status === 'active' ? 'badge-success' : 'badge-pending'); ?> mt-4">
            <?php echo e(ucfirst($shop->status)); ?>

        </span>
    </div>

    <div class="lg:col-span-2 card p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-5">
            Shop Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

            <div>
                <p class="text-gray-400">Provider</p>
                <p class="font-semibold">
                    <?php echo e($shop->provider->full_name ?? $shop->provider->name ?? 'No Provider'); ?>

                </p>
            </div>

            <div>
                <p class="text-gray-400">Registration Number</p>
                <p class="font-semibold"><?php echo e($shop->registration_number ?? '-'); ?></p>
            </div>

            <div>
                <p class="text-gray-400">Phone</p>
                <p class="font-semibold"><?php echo e($shop->country_code ?? '+91'); ?> <?php echo e($shop->phone ?? '-'); ?></p>
            </div>

            <div>
                <p class="text-gray-400">City</p>
                <p class="font-semibold"><?php echo e($shop->city ?? '-'); ?></p>
            </div>

            <div>
                <p class="text-gray-400">State</p>
                <p class="font-semibold"><?php echo e($shop->state ?? '-'); ?></p>
            </div>

            <div>
                <p class="text-gray-400">Country</p>
                <p class="font-semibold"><?php echo e($shop->country ?? '-'); ?></p>
            </div>

            <div>
                <p class="text-gray-400">Latitude</p>
                <p class="font-semibold"><?php echo e($shop->latitude ?? '-'); ?></p>
            </div>

            <div>
                <p class="text-gray-400">Longitude</p>
                <p class="font-semibold"><?php echo e($shop->longitude ?? '-'); ?></p>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-400">Address</p>
                <p class="font-semibold"><?php echo e($shop->address ?? '-'); ?></p>
            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/shops/show.blade.php ENDPATH**/ ?>