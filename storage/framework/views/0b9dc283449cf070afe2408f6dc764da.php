

<?php $__env->startSection('title', 'Service Configuration'); ?>

<?php $__env->startSection('content'); ?>

<?php
$getConfig = fn($key, $default = null)
=> $configs->get($key)?->value ?? $default;

$services = [
    'advanced_payment_services' => 'Advanced Payment for Services',
    'slot_services'             => 'Slot Services',
    'digital_services'          => 'Digital Services',
    'service_packages'          => 'Service Packages',
    'service_addons'            => 'Service Add-ons',
    'job_request'               => 'Job Request',
    'shop'                      => 'Shop',
    'default_advance_payment'   => 'Default Advance Payment',
    'cancellation_charge'       => 'Cancellation Charge',
];
?>

<div class="flex gap-6">

    
    <?php echo $__env->make('admin.settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="mb-6">
                <h2 class="text-xl font-semibold">
                    Service Configuration
                </h2>
            </div>

            <form method="POST"
                  action="<?php echo e(route('admin.settings.service.update')); ?>">

                <?php echo csrf_field(); ?>

                <div class="space-y-4">

                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="border rounded-lg px-5 py-4 flex items-center justify-between">

                            <span class="text-gray-800 font-medium">
                                <?php echo e($label); ?>

                            </span>

                            <label class="relative inline-flex items-center cursor-pointer">

                                <input type="hidden"
                                       name="<?php echo e($key); ?>"
                                       value="0">

                                <input type="checkbox"
                                       name="<?php echo e($key); ?>"
                                       value="1"
                                       class="sr-only peer"
                                       <?php echo e($getConfig($key,'1') == '1' ? 'checked' : ''); ?>>

                                <div
                                    class="w-11 h-6 bg-gray-300 rounded-full peer
                                    peer-checked:bg-indigo-600
                                    after:content-['']
                                    after:absolute
                                    after:top-[2px]
                                    after:left-[2px]
                                    after:bg-white
                                    after:border-gray-300
                                    after:border
                                    after:rounded-full
                                    after:h-5
                                    after:w-5
                                    after:transition-all
                                    peer-checked:after:translate-x-full">
                                </div>

                            </label>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>

                <div class="mt-8 text-right">

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg">

                        Save Settings

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/pages/service.blade.php ENDPATH**/ ?>