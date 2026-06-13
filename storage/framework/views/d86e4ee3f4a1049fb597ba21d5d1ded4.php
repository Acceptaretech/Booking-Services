<?php $__env->startSection('page_title','Edit Blog'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.blogs.form', [
    'blog' => $blog,
    'action' => route('admin.blogs.update', $blog->id),
    'method' => 'PUT',
    'title' => 'Edit Blog'
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/blogs/edit.blade.php ENDPATH**/ ?>