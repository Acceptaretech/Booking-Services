

<?php $__env->startSection('title','My Profile'); ?>

<?php $__env->startSection('content'); ?>

<div class="min-h-screen bg-gradient-to-br from-sky-50 via-blue-50 to-indigo-50 py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            
            <?php echo $__env->make('customer.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            
            <div>

                <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

                    
                    <div class="bg-gradient-to-r from-sky-500 to-indigo-600 p-8">

                        <h1 class="text-3xl font-bold text-white">
                            My Profile
                        </h1>

                        <p class="text-sky-100 mt-2">
                            Manage your personal information and account settings.
                        </p>

                    </div>

                    <div class="p-8">

                        <?php if($errors->any()): ?>
                            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
                                <ul class="list-disc ml-5">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST"
                              action="<?php echo e(route('customer.profile.update')); ?>"
                              enctype="multipart/form-data">

                            <?php echo csrf_field(); ?>

                            
                            <div class="flex flex-col md:flex-row md:items-center gap-6 mb-10">

                                <img
                                    src="<?php echo e($user->profile_image_url); ?>"
                                    alt="<?php echo e($user->name); ?>"
                                    class="w-28 h-28 rounded-full object-cover border-4 border-sky-100">

                                <div>

                                    <label class="inline-flex items-center gap-2 px-5 py-3 bg-sky-50 text-sky-600 rounded-2xl cursor-pointer hover:bg-sky-100 transition">

                                        <i class="fas fa-camera"></i>

                                        Change Photo

                                        <input
                                            type="file"
                                            name="profile_image"
                                            accept="image/*"
                                            class="hidden">

                                    </label>

                                    <p class="text-sm text-gray-500 mt-3">
                                        JPG, PNG, WEBP allowed. Max 2MB.
                                    </p>

                                </div>

                            </div>

                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        First Name
                                    </label>

                                    <input
                                        type="text"
                                        name="first_name"
                                        value="<?php echo e(old('first_name',$user->first_name)); ?>"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Last Name
                                    </label>

                                    <input
                                        type="text"
                                        name="last_name"
                                        value="<?php echo e(old('last_name',$user->last_name)); ?>"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        value="<?php echo e($user->email); ?>"
                                        disabled
                                        class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-700">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        value="<?php echo e(old('phone',$user->phone)); ?>"
                                        class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                </div>

                            </div>

                            
                            <div class="mt-6">

                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Address
                                </label>

                                <textarea
                                    name="address"
                                    rows="4"
                                    class="w-full border border-gray-200 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-sky-500 focus:border-sky-500"><?php echo e(old('address',$user->address)); ?></textarea>

                            </div>

                            
                            <div class="mt-10 border-t pt-8">

                                <h3 class="text-xl font-bold text-gray-900 mb-6">
                                    Change Password
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            Current Password
                                        </label>

                                        <input
                                            type="password"
                                            name="current_password"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3">
                                    </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            New Password
                                        </label>

                                        <input
                                            type="password"
                                            name="new_password"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3">
                                    </div>

                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-700">
                                            Confirm Password
                                        </label>

                                        <input
                                            type="password"
                                            name="new_password_confirmation"
                                            class="w-full border border-gray-200 rounded-2xl px-5 py-3">
                                    </div>

                                </div>

                            </div>

                            
                            <div class="flex justify-end gap-4 mt-10">

                                <button
                                    type="reset"
                                    class="px-8 py-3 rounded-2xl border border-gray-300 text-gray-700 hover:bg-gray-50">

                                    Cancel

                                </button>

                                <button
                                    type="submit"
                                    class="px-8 py-3 rounded-2xl bg-gradient-to-r from-sky-500 to-indigo-600 text-white font-semibold hover:shadow-lg transition">

                                    Save Changes

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/customer/profile/index.blade.php ENDPATH**/ ?>