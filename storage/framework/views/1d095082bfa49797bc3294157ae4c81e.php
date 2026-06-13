<?php $__env->startSection('title','Settings'); ?>

<?php $__env->startSection('content'); ?>

<?php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
?>

<div
    x-data="{ tab: 'general' }"
    class="flex gap-6">

    <?php echo $__env->make('admin.settings.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="flex-1">

        
        <div x-show="tab==='general'" x-cloak>
            <?php echo $__env->make('admin.settings.tabs.general', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        
        <div x-show="tab==='theme'" x-cloak>
            <?php echo $__env->make('admin.settings.tabs.theme', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
       
      

        
        
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>