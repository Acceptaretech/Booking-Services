

<?php $__env->startSection('title', $page->title); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="text-4xl font-bold capitalize"><?php echo e($page->title); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 border border-gray-100 dark:border-gray-700">

        <div class="prose dark:prose-invert max-w-none">
            <?php echo $page->content; ?>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/public/pages/show.blade.php ENDPATH**/ ?>