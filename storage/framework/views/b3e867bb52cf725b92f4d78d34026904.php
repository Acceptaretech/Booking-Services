

<?php $__env->startSection('title','Site Setup'); ?>

<?php $__env->startSection('content'); ?>

<?php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
?>

<div class="flex gap-6">

    <?php echo $__env->make('admin.settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex-1">

        <form method="POST"
              action="<?php echo e(route('admin.settings.update')); ?>"
              class="bg-white rounded-xl shadow-sm p-8">

            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div>
                    <label class="block mb-2 font-medium">
                        Date Format
                    </label>

                    <select name="date_format"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="F j, Y">June 5, 2026</option>
                        <option value="d-m-Y">05-06-2026</option>
                        <option value="Y-m-d">2026-06-05</option>
                    </select>
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Longitude
                    </label>

                    <input type="text"
                           name="longitude"
                           value="<?php echo e($getConfig('longitude','-74.0060')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Time Format
                    </label>

                    <select name="time_format"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="h:i A">1:47 AM</option>
                        <option value="H:i">13:47</option>
                    </select>
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Distance Type
                    </label>

                    <select name="distance_type"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="km">km</option>
                        <option value="mile">mile</option>
                    </select>
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Timezone
                    </label>

                    <select name="timezone"
                            class="w-full border rounded-lg px-4 py-3">
                        <?php $__currentLoopData = timezone_identifiers_list(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($timezone); ?>"
                                <?php echo e($getConfig('timezone') == $timezone ? 'selected' : ''); ?>>
                                <?php echo e($timezone); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Radius
                    </label>

                    <input type="number"
                           name="radius"
                           value="<?php echo e($getConfig('radius',100)); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Default Language
                    </label>

                    <input type="text"
                           name="default_language"
                           value="<?php echo e($getConfig('default_language','English')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Decimal Point
                    </label>

                    <input type="number"
                           name="decimal_point"
                           value="<?php echo e($getConfig('decimal_point',2)); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Default Currency
                    </label>

                    <input type="text"
                           name="currency"
                           value="<?php echo e($getConfig('currency','USD')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Copyright Text
                    </label>

                    <input type="text"
                           name="copyright_text"
                           value="<?php echo e($getConfig('copyright_text')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Currency Position
                    </label>

                    <select name="currency_position"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                </div>

                
                <div>
                    <label class="block mb-2 font-medium">
                        Latitude
                    </label>

                    <input type="text"
                           name="latitude"
                           value="<?php echo e($getConfig('latitude','40.7128')); ?>"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

            </div>

            
            <div class="mt-8 bg-gray-100 rounded-lg p-5">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">
                        Android App Links
                    </h3>

                    <input type="checkbox"
                           name="android_status"
                           value="1">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <input type="text"
                           name="playstore_url"
                           placeholder="Play Store Url"
                           class="border rounded-lg px-4 py-3">

                    <input type="text"
                           name="provider_playstore_url"
                           placeholder="Provider Play Store Url"
                           class="border rounded-lg px-4 py-3">

                </div>

            </div>

            
            <div class="mt-6 bg-gray-100 rounded-lg p-5">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">
                        IOS App Links
                    </h3>

                    <input type="checkbox"
                           name="ios_status"
                           value="1">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <input type="text"
                           name="appstore_url"
                           placeholder="App Store Url"
                           class="border rounded-lg px-4 py-3">

                    <input type="text"
                           name="provider_appstore_url"
                           placeholder="Provider App Store Url"
                           class="border rounded-lg px-4 py-3">

                </div>

            </div>

            <div class="text-right mt-8">

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg">
                    Save
                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/pages/site.blade.php ENDPATH**/ ?>