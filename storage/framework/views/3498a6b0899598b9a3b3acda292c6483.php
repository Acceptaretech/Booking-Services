

<?php $__env->startSection('title', 'Mail Settings'); ?>

<?php $__env->startSection('content'); ?>

<?php
$getConfig = fn($key, $default = null) => $configs->get($key)?->value ?? $default;
?>

<div class="flex gap-6">

    <?php echo $__env->make('admin.settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-8">

            <form method="POST"
                  action="<?php echo e(route('admin.settings.mail.update')); ?>">

                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-medium">Mail Mailer</label>
                        <input type="text"
                               name="mail_mailer"
                               value="<?php echo e($getConfig('mail_mailer', 'smtp')); ?>"
                               placeholder="smtp"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Host</label>
                        <input type="text"
                               name="mail_host"
                               value="<?php echo e($getConfig('mail_host', 'smtp.gmail.com')); ?>"
                               placeholder="smtp.gmail.com"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Port</label>
                        <input type="text"
                               name="mail_port"
                               value="<?php echo e($getConfig('mail_port', '587')); ?>"
                               placeholder="587"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Encryption</label>
                        <input type="text"
                               name="mail_encryption"
                               value="<?php echo e($getConfig('mail_encryption', 'tls')); ?>"
                               placeholder="tls"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Username</label>
                        <input type="text"
                               name="mail_username"
                               value="<?php echo e($getConfig('mail_username')); ?>"
                               placeholder="demo@admin.com"
                               class="w-full border rounded-lg px-4 py-3 bg-blue-50">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Password</label>
                        <input type="password"
                               name="mail_password"
                               value="<?php echo e($getConfig('mail_password')); ?>"
                               placeholder="********"
                               class="w-full border rounded-lg px-4 py-3 bg-blue-50">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail From Address</label>
                        <input type="email"
                               name="mail_from_address"
                               value="<?php echo e($getConfig('mail_from_address')); ?>"
                               placeholder="youremail@gmail.com"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit"
                            class="bg-[#5B5FC7] hover:bg-[#4b4fb3] text-white px-8 py-3 rounded-lg">
                        Save
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/pages/mail.blade.php ENDPATH**/ ?>