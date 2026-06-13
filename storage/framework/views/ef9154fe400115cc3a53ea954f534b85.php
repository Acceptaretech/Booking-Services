<?php $__env->startSection('title','Page'); ?>
<?php $__env->startSection('page_header'); ?><h1 class="text-4xl font-bold capitalize">Page</h1><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 py-16">
  <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 border border-gray-100 dark:border-gray-700">
    <p class="text-gray-500">This content is managed by the admin and will appear here.</p>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/public/privacy.blade.php ENDPATH**/ ?>