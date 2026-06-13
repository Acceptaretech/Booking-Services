<?php $__env->startSection('title', 'Services'); ?>
<?php $__env->startSection('page_title', 'Service List'); ?>

<?php $__env->startSection('content'); ?>

<div class="flex flex-wrap items-center justify-between gap-3 mb-5">

    <form method="GET" class="flex gap-2 flex-wrap">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>

            <input
                type="text"
                name="search"
                value="<?php echo e(request('search')); ?>"
                placeholder="Search services..."
                class="form-input pl-8 py-2 w-48 text-xs">
        </div>

        <select name="category_id"
                class="form-select text-xs py-2 w-40"
                onchange="this.form.submit()">
            <option value="">All Categories</option>

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($id); ?>"
                    <?php echo e(request('category_id') == $id ? 'selected' : ''); ?>>
                    <?php echo e($name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="status"
                class="form-select text-xs py-2 w-32"
                onchange="this.form.submit()">

            <option value="">All Status</option>

            <option value="active"
                <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>
                Active
            </option>

            <option value="inactive"
                <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>
                Inactive
            </option>

        </select>
    </form>

    <a href="<?php echo e(route('admin.services.create')); ?>" class="btn-primary text-xs">
        <i class="fas fa-plus"></i>
        New Service
    </a>

</div>

<div class="card overflow-hidden">

    <table class="data-table w-full">

        <thead>
        <tr>
            <th>Service</th>
            <th>Provider</th>
            <th>Category</th>
            <th>Price</th>
            <th>Bookings</th>
            <th>Rating</th>
            <th>Status</th>
            <th width="120">Action</th>
        </tr>
        </thead>

        <tbody>

        <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <tr>

                
                <td>
                    <div class="flex items-center gap-3">

                        <?php if($s->image): ?>
                            <img src="<?php echo e(asset('storage/'.$s->image)); ?>"
                                 class="w-10 h-10 rounded-xl object-cover flex-shrink-0">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-concierge-bell text-primary-500 text-sm"></i>
                            </div>
                        <?php endif; ?>

                        <div>
                            <p class="font-medium text-sm text-gray-800 dark:text-gray-200">
                                <?php echo e($s->name); ?>

                            </p>

                            <?php if($s->discount > 0): ?>
                                <p class="text-xs text-red-500">
                                    <s>$<?php echo e(number_format($s->price,2)); ?></s>
                                    <?php echo e($s->discount); ?>% off
                                </p>
                            <?php endif; ?>
                        </div>

                    </div>
                </td>

                
                <td>
                    <div class="flex items-center gap-2">

                        <?php if($s->provider): ?>

                            <img
                                src="<?php echo e($s->provider->profile_image_url ?? asset('images/default-user.png')); ?>"
                                class="w-6 h-6 rounded-full">

                            <span class="text-xs">
                                <?php echo e($s->provider->full_name ?? $s->provider->name ?? 'Provider'); ?>

                            </span>

                        <?php else: ?>

                            <span class="text-xs text-red-500">
                                No Provider
                            </span>

                        <?php endif; ?>

                    </div>
                </td>

                
                <td>

                    <?php if($s->category): ?>

                        <span class="badge badge-info text-xs">
                            <?php echo e($s->category->name); ?>

                        </span>

                    <?php else: ?>

                        <span class="badge badge-pending text-xs">
                            No Category
                        </span>

                    <?php endif; ?>

                </td>

                
                <td>
                    <span class="font-semibold text-primary-600">
                        $<?php echo e(number_format($s->price, 2)); ?>

                    </span>
                </td>

                
                <td>
                    <span class="badge badge-pending">
                        <?php echo e($s->total_bookings ?? 0); ?>

                    </span>
                </td>

                
                <td>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400 text-xs"></i>

                        <span class="text-xs">
                            <?php echo e($s->avg_rating ?? 0); ?>

                        </span>
                    </div>
                </td>

                
                <td>
                    <span class="badge <?php echo e($s->status === 'active' ? 'badge-success' : 'badge-pending'); ?>">
                        <?php echo e(ucfirst($s->status)); ?>

                    </span>
                </td>

                
                <td>

                    <div class="flex items-center gap-1">

                        <a href="<?php echo e(route('admin.services.edit', $s->id)); ?>"
                           class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100">
                            <i class="fas fa-edit text-xs"></i>
                        </a>

                        <form method="POST"
                              action="<?php echo e(route('admin.services.destroy', $s->id)); ?>"
                              id="del-svc-<?php echo e($s->id); ?>">

                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>

                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to delete this service?')"
                                    class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100">

                                <i class="fas fa-trash text-xs"></i>

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

            <tr>
                <td colspan="8" class="text-center py-14 text-gray-400">

                    <i class="fas fa-concierge-bell text-4xl mb-2 block"></i>

                    <p>No services found</p>

                    <a href="<?php echo e(route('admin.services.create')); ?>"
                       class="btn-primary text-xs mt-3 inline-flex">

                        <i class="fas fa-plus"></i>
                        Add First Service

                    </a>

                </td>
            </tr>

        <?php endif; ?>

        </tbody>

    </table>

    <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700">
        <?php echo e($services->withQueryString()->links()); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/services/index.blade.php ENDPATH**/ ?>