

<?php $__env->startSection('title','Social Media'); ?>

<?php $__env->startSection('content'); ?>

<?php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
?>

<div class="flex gap-6">

    <?php echo $__env->make('admin.settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <h2 class="text-xl font-semibold mb-6">
                Social Media Settings
            </h2>

            <form method="POST"
                  action="<?php echo e(route('admin.settings.social.update')); ?>">

                <?php echo csrf_field(); ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    
                    <div>
                        <label class="block mb-2 font-medium">
                            Facebook URL
                        </label>

                        <input
                            type="url"
                            name="social_facebook"
                            value="<?php echo e($getConfig('social_facebook')); ?>"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://facebook.com/yourpage">
                    </div>

                    
                    <div>
                        <label class="block mb-2 font-medium">
                            Instagram URL
                        </label>

                        <input
                            type="url"
                            name="social_instagram"
                            value="<?php echo e($getConfig('social_instagram')); ?>"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://instagram.com/yourpage">
                    </div>

                    
                    <div>
                        <label class="block mb-2 font-medium">
                            Twitter URL
                        </label>

                        <input
                            type="url"
                            name="social_twitter"
                            value="<?php echo e($getConfig('social_twitter')); ?>"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://twitter.com/yourpage">
                    </div>

                    
                    <div>
                        <label class="block mb-2 font-medium">
                            YouTube URL
                        </label>

                        <input
                            type="url"
                            name="social_youtube"
                            value="<?php echo e($getConfig('social_youtube')); ?>"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://youtube.com/@yourchannel">
                    </div>

                    
                    <div>
                        <label class="block mb-2 font-medium">
                            LinkedIn URL
                        </label>

                        <input
                            type="url"
                            name="social_linkedin"
                            value="<?php echo e($getConfig('social_linkedin')); ?>"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://linkedin.com/company/yourcompany">
                    </div>

                </div>

                <div class="flex justify-end mt-8">

                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/pages/social.blade.php ENDPATH**/ ?>