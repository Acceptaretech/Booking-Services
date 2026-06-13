

<?php $__env->startSection('title', 'Create Addon'); ?>
<?php $__env->startSection('page_title', 'Create Addon'); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.addons.store')); ?>" enctype="multipart/form-data" class="card p-6">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Select Service *</label>
            <select name="service_id" class="form-select" required>
                <option value="">Select Service</option>
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($service->id); ?>"><?php echo e($service->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Select Provider *</label>
            <select name="user_id" class="form-select" required>
                <option value="">Select Provider</option>
                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($provider->id); ?>">
                        <?php echo e($provider->full_name ?? $provider->name ?? $provider->email); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" name="price" value="<?php echo e(old('price')); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div>
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-input">
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-6">
        <a href="<?php echo e(route('admin.addons.index')); ?>" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Save</button>
    </div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/addons/create.blade.php ENDPATH**/ ?>