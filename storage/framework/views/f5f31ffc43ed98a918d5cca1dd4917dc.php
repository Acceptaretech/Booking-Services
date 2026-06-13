<?php $__env->startSection('page_title','Create Blog'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.blogs.form', [
    'blog' => null,
    'action' => route('admin.blogs.store'),
    'method' => 'POST',
    'title' => 'Create Blog'
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/blogs/create.blade.php ENDPATH**/ ?>