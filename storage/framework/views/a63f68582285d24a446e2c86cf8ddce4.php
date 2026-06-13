

<?php $__env->startSection('title', 'Create Shop'); ?>
<?php $__env->startSection('page_title', 'Create Shop'); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.shops.store')); ?>" enctype="multipart/form-data" class="card p-6">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
            <label class="form-label">Shop Name *</label>
            <input name="name" value="<?php echo e(old('name')); ?>" placeholder="Enter Shop Name" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Provider *</label>
            <select name="user_id" class="form-select" required>
                <option value="">Select Provider</option>
                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($provider->id); ?>" <?php echo e(old('user_id') == $provider->id ? 'selected' : ''); ?>>
                        <?php echo e($provider->full_name ?? $provider->name ?? $provider->email); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Registration Number *</label>
            <input name="registration_number" value="<?php echo e(old('registration_number')); ?>" placeholder="Enter Registration Number" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Email *</label>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="Enter Email" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Contact Number *</label>
            <div class="flex">
                <input name="country_code" value="<?php echo e(old('country_code', '+91')); ?>" class="form-input w-24 rounded-r-none">
                <input name="phone" value="<?php echo e(old('phone')); ?>" placeholder="Enter Contact Number" class="form-input rounded-l-none" required>
            </div>
        </div>

        <div>
            <label class="form-label">Latitude *</label>
            <input name="latitude" value="<?php echo e(old('latitude')); ?>" placeholder="e.g. 12.3456" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Longitude *</label>
            <input name="longitude" value="<?php echo e(old('longitude')); ?>" placeholder="e.g. 77.1234" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Address *</label>
            <input name="address" value="<?php echo e(old('address')); ?>" placeholder="Enter Shop Address" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Country *</label>
            <input name="country" value="<?php echo e(old('country')); ?>" placeholder="Enter Country" class="form-input" required>
        </div>

        <div>
            <label class="form-label">State *</label>
            <input name="state" value="<?php echo e(old('state')); ?>" placeholder="Enter State" class="form-input" required>
        </div>

        <div>
            <label class="form-label">City *</label>
            <input name="city" value="<?php echo e(old('city')); ?>" placeholder="Enter City" class="form-input" required>
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
        <a href="<?php echo e(route('admin.shops.index')); ?>" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Save</button>
    </div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/shops/create.blade.php ENDPATH**/ ?>