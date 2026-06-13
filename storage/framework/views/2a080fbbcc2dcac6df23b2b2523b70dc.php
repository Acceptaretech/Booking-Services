

<?php $__env->startSection('title', 'Payment Configuration'); ?>

<?php $__env->startSection('content'); ?>

<?php
$getConfig = fn($key, $default = null) => $configs->get($key)?->value ?? $default;

$gateways = [
    'cash_on_delivery' => 'CASH ON DELIVERY',
    'stripe'           => 'STRIPE',
    'razorpay'         => 'RAZORPAY',
    'flutterwave'      => 'FLUTTERWAVE',
    'paypal'           => 'PAYPAL',
    'cinet'            => 'CINET',
    'sadad'            => 'SADAD',
    'airtel_money'     => 'AIRTEL MONEY',
    'paystack'         => 'PAYSTACK',
    'phonepe'          => 'PHONEPE',
    'midtrans'         => 'MIDTRANS',
];

$activeGateway = request('gateway', 'stripe');
?>

<div class="flex gap-6">

    <?php echo $__env->make('admin.settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-6">

            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-10">

                <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.settings.payment', ['gateway' => $key])); ?>"
                       class="text-center px-5 py-3 rounded-md text-sm font-medium transition
                       <?php echo e($activeGateway === $key ? 'bg-[#5B5FC7] text-white' : 'bg-[#F0F0FA] text-[#5B5FC7]'); ?>">
                        <?php echo e($label); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

            <form method="POST"
                  action="<?php echo e(route('admin.settings.payment.update')); ?>">

                <?php echo csrf_field(); ?>

                <input type="hidden"
                       name="gateway"
                       value="<?php echo e($activeGateway); ?>">

                
                <div class="border rounded-md px-5 py-4 flex items-center justify-between mb-5">

                    <span class="font-medium">
                        Enable <?php echo e(ucfirst(str_replace('_', ' ', $activeGateway))); ?> payment
                    </span>

                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden"
                               name="<?php echo e($activeGateway); ?>_status"
                               value="0">

                        <input type="checkbox"
                               name="<?php echo e($activeGateway); ?>_status"
                               value="1"
                               class="sr-only peer"
                               <?php echo e($getConfig($activeGateway.'_status', '1') == '1' ? 'checked' : ''); ?>>

                        <div class="w-11 h-6 bg-gray-300 rounded-full peer
                                    peer-checked:bg-[#5B5FC7]
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

                
                <div class="mb-6">
                    <label class="block mb-3 font-medium">
                        <?php echo e(ucfirst(str_replace('_', ' ', $activeGateway))); ?> option
                    </label>

                    <div class="flex items-center gap-8">

                        <label class="flex items-center gap-2">
                            <input type="radio"
                                   name="<?php echo e($activeGateway); ?>_credential_type"
                                   value="test"
                                   <?php echo e($getConfig($activeGateway.'_credential_type', 'test') == 'test' ? 'checked' : ''); ?>>
                            Test credential
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio"
                                   name="<?php echo e($activeGateway); ?>_credential_type"
                                   value="live"
                                   <?php echo e($getConfig($activeGateway.'_credential_type') == 'live' ? 'checked' : ''); ?>>
                            Live credential
                        </label>

                    </div>
                </div>

                
                <div class="mb-6">
                    <label class="block mb-2 font-medium">
                        Gateway Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="<?php echo e($activeGateway); ?>_gateway_name"
                           value="<?php echo e($getConfig($activeGateway.'_gateway_name', ucwords(str_replace('_', ' ', $activeGateway)).' Payment')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div class="mb-6">
                    <label class="block mb-2 font-medium">
                        <?php echo e(ucfirst(str_replace('_', ' ', $activeGateway))); ?> URL <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="<?php echo e($activeGateway); ?>_url"
                           value="<?php echo e($getConfig($activeGateway.'_url')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div class="mb-6">
                    <label class="block mb-2 font-medium">
                        <?php echo e(ucfirst(str_replace('_', ' ', $activeGateway))); ?> Key <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="<?php echo e($activeGateway); ?>_key"
                           value="<?php echo e($getConfig($activeGateway.'_key')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div class="mb-8">
                    <label class="block mb-2 font-medium">
                        <?php echo e(ucfirst(str_replace('_', ' ', $activeGateway))); ?> Public Key <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="<?php echo e($activeGateway); ?>_public_key"
                           value="<?php echo e($getConfig($activeGateway.'_public_key')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                <div class="flex justify-end">
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
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/pages/payment.blade.php ENDPATH**/ ?>