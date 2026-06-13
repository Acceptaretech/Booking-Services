<?php $__env->startSection('page_title','Update User'); ?>

<?php $__env->startSection('content'); ?>

<div class="card p-5 mb-6 flex justify-between items-center">
    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
        Update User
    </h2>

    <a href="<?php echo e(route('admin.users.index')); ?>"
       class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold">
        <i class="fas fa-angle-double-left mr-1"></i> Back
    </a>
</div>

<div class="card p-6">

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-5">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-5">

            <div>
                <label class="block mb-2">First Name <span class="text-red-500">*</span></label>
                <input name="first_name"
                       value="<?php echo e(old('first_name', $user->first_name)); ?>"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Last Name <span class="text-red-500">*</span></label>
                <input name="last_name"
                       value="<?php echo e(old('last_name', $user->last_name)); ?>"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Username <span class="text-red-500">*</span></label>
                <input name="username"
                       value="<?php echo e(old('username', $user->username)); ?>"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">User Type <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="user" <?php echo e(old('role', $user->role) == 'user' ? 'selected' : ''); ?>>user</option>
                    <option value="customer" <?php echo e(old('role', $user->role) == 'customer' ? 'selected' : ''); ?>>customer</option>
                    <option value="provider" <?php echo e(old('role', $user->role) == 'provider' ? 'selected' : ''); ?>>provider</option>
                    <option value="handyman" <?php echo e(old('role', $user->role) == 'handyman' ? 'selected' : ''); ?>>handyman</option>
                    <option value="admin" <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>admin</option>
                </select>
            </div>

            <div>
                <label class="block mb-2">Contact Number <span class="text-red-500">*</span></label>
                <div class="flex">
                    <span class="px-4 py-4 bg-gray-100 border border-r-0 rounded-l">
                        🇮🇳 +91
                    </span>
                    <input name="phone"
                           value="<?php echo e(old('phone', $user->phone)); ?>"
                           required
                           class="w-full border rounded-r px-5 py-4 bg-white dark:bg-gray-800">
                </div>
            </div>

            <div>
                <label class="block mb-2">Email <span class="text-red-500">*</span></label>
                <input type="email"
                       name="email"
                       value="<?php echo e(old('email', $user->email)); ?>"
                       required
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
                    <option value="active" <?php echo e(old('status', $user->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(old('status', $user->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="pending" <?php echo e(old('status', $user->status) == 'pending' ? 'selected' : ''); ?>>Pending</option>
                    <option value="rejected" <?php echo e(old('status', $user->status) == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
            </div>

        </div>

        <div class="mb-5">
            <label class="block mb-2">Address</label>
            <textarea name="address"
                      rows="4"
                      class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800"><?php echo e(old('address', $user->address)); ?></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            <div>
                <label class="block mb-2">Select Country</label>
                <input name="country"
                       value="<?php echo e(old('country', $user->country)); ?>"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select State</label>
                <input name="state"
                       value="<?php echo e(old('state', $user->state)); ?>"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

            <div>
                <label class="block mb-2">Select City</label>
                <input name="city"
                       value="<?php echo e(old('city', $user->city)); ?>"
                       class="w-full border rounded px-5 py-4 bg-white dark:bg-gray-800">
            </div>

        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold">
                Update
            </button>
        </div>

    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>