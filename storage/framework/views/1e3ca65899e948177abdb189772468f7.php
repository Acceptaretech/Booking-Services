<?php $__env->startSection('title', 'Edit Provider'); ?>
<?php $__env->startSection('page_title', 'Edit Provider'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-5xl mx-auto">

    <div class="card p-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                    Edit Provider
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Update provider information and account status.
                </p>
            </div>

            <a href="<?php echo e(route('admin.providers.index')); ?>"
               class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>

        <form action="<?php echo e(route('admin.providers.update', $user->id)); ?>"
              method="POST">

            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="form-label">
                        First Name
                    </label>

                    <input type="text"
                           name="first_name"
                           value="<?php echo e(old('first_name', $user->first_name)); ?>"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">
                        Last Name
                    </label>

                    <input type="text"
                           name="last_name"
                           value="<?php echo e(old('last_name', $user->last_name)); ?>"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">
                        Full Name
                    </label>

                    <input type="text"
                           name="name"
                           value="<?php echo e(old('name', $user->name)); ?>"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           value="<?php echo e(old('email', $user->email)); ?>"
                           class="form-input"
                           required>
                </div>

                <div>
                    <label class="form-label">
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           value="<?php echo e(old('phone', $user->phone)); ?>"
                           class="form-input">
                </div>

                <div>
                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="active"
                            <?php echo e($user->status == 'active' ? 'selected' : ''); ?>>
                            Active
                        </option>

                        <option value="pending"
                            <?php echo e($user->status == 'pending' ? 'selected' : ''); ?>>
                            Pending
                        </option>

                        <option value="inactive"
                            <?php echo e($user->status == 'inactive' ? 'selected' : ''); ?>>
                            Inactive
                        </option>

                        <option value="rejected"
                            <?php echo e($user->status == 'rejected' ? 'selected' : ''); ?>>
                            Rejected
                        </option>

                    </select>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8">

                <a href="<?php echo e(route('admin.providers.index')); ?>"
                   class="btn-secondary">
                    Cancel
                </a>

                <button type="submit"
                        class="btn-primary">
                    <i class="fas fa-save mr-2"></i>
                    Update Provider
                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/providers/edit.blade.php ENDPATH**/ ?>