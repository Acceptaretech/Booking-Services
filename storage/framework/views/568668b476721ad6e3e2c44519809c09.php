

<?php $__env->startSection('title', 'Create Package'); ?>
<?php $__env->startSection('page_title', 'Create Package'); ?>

<?php $__env->startSection('content'); ?>

<form method="POST" action="<?php echo e(route('admin.packages.store')); ?>" enctype="multipart/form-data" class="card p-6">
    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div>
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-input"><?php echo e(old('description')); ?></textarea>
        </div>

        <div>
            <label class="form-label">Select Provider *</label>
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
            <label class="form-label">Package Type *</label>
            <select name="package_type" class="form-select" required>
                <option value="single_category" <?php echo e(old('package_type') == 'single_category' ? 'selected' : ''); ?>>
                    Single Category
                </option>
                <option value="multiple_category" <?php echo e(old('package_type') == 'multiple_category' ? 'selected' : ''); ?>>
                    Multiple Category
                </option>
            </select>
        </div>

        <div>
            <label class="form-label">Select Category *</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Select Sub Category</label>
            <select name="sub_category_id" class="form-select">
                <option value="">Select Sub Category</option>
                <?php $__currentLoopData = $subCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subCategory->id); ?>" <?php echo e(old('sub_category_id') == $subCategory->id ? 'selected' : ''); ?>>
                        <?php echo e($subCategory->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Select Service *</label>
            <select name="service_id" class="form-select" required>
                <option value="">Select Service</option>
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($service->id); ?>" <?php echo e(old('service_id') == $service->id ? 'selected' : ''); ?>>
                        <?php echo e($service->name); ?>

                        <?php if($service->price): ?>
                            - $<?php echo e(number_format((float) $service->price, 2)); ?>

                        <?php endif; ?>
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="form-label">Start At</label>
            <input type="date" name="start_at" value="<?php echo e(old('start_at')); ?>" class="form-input">
        </div>

        <div>
            <label class="form-label">End At</label>
            <input type="date" name="end_at" value="<?php echo e(old('end_at')); ?>" class="form-input">
        </div>

        <div>
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" name="price" value="<?php echo e(old('price')); ?>" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Original Price</label>
            <input type="number" step="0.01" name="original_price" value="<?php echo e(old('original_price')); ?>" class="form-input">
        </div>

        <div>
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active" <?php echo e(old('status', 'active') == 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            </select>
        </div>

        <div>
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-input">
        </div>

    </div>

    <div class="flex justify-end gap-2 mt-6">
        <a href="<?php echo e(route('admin.packages.index')); ?>" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Save</button>
    </div>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/packages/create.blade.php ENDPATH**/ ?>