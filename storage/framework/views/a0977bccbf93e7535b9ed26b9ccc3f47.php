

<?php $__env->startSection('title', 'Edit Shop'); ?>
<?php $__env->startSection('page_title', 'Edit Shop'); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.shops.update', $shop->id)); ?>" enctype="multipart/form-data" class="card p-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
            <label class="form-label">Shop Name *</label>
            <input name="name" value="<?php echo e(old('name', $shop->name)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Provider *</label>
            <select name="user_id" class="form-select" required>
                <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($provider->id); ?>" <?php echo e(old('user_id', $shop->user_id) == $provider->id ? 'selected' : ''); ?>>
                        <?php echo e($provider->full_name ?? $provider->name ?? $provider->email); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Registration Number *</label>
            <input name="registration_number" value="<?php echo e(old('registration_number', $shop->registration_number)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Email *</label>
            <input type="email" name="email" value="<?php echo e(old('email', $shop->email)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Contact Number *</label>
            <div class="flex">
                <input name="country_code" value="<?php echo e(old('country_code', $shop->country_code ?? '+91')); ?>" class="form-input w-24 rounded-r-none">
                <input name="phone" value="<?php echo e(old('phone', $shop->phone)); ?>" class="form-input rounded-l-none" required>
            </div>
        </div>

        <div>
            <label class="form-label">Latitude *</label>
            <input name="latitude" value="<?php echo e(old('latitude', $shop->latitude)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Longitude *</label>
            <input name="longitude" value="<?php echo e(old('longitude', $shop->longitude)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Address *</label>
            <input name="address" value="<?php echo e(old('address', $shop->address)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Country *</label>
            <input name="country" value="<?php echo e(old('country', $shop->country)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">State *</label>
            <input name="state" value="<?php echo e(old('state', $shop->state)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">City *</label>
            <input name="city" value="<?php echo e(old('city', $shop->city)); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active" <?php echo e($shop->status === 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="inactive" <?php echo e($shop->status === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            </select>
        </div>

        <div>
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-input">
            <?php if($shop->image): ?>
                <img src="<?php echo e(asset('storage/'.$shop->image)); ?>" class="w-16 h-16 rounded-xl object-cover mt-2">
            <?php endif; ?>
        </div>

        <div>
            <label class="form-label">Languages</label>
            <select name="languages[]" multiple class="form-select">
                <?php $__currentLoopData = ['en'=>'English','hi'=>'Hindi','gu'=>'Gujarati']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($key); ?>" <?php echo e(in_array($key, old('languages', $shop->languages ?? [])) ? 'selected' : ''); ?>>
                        <?php echo e($label); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-6">
        <a href="<?php echo e(route('admin.shops.index')); ?>" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/shops/edit.blade.php ENDPATH**/ ?>