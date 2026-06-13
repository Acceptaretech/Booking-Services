

<?php $__env->startSection('page_title', 'Add New Document'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    <div class="card flex items-center justify-between p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Add New Document</h2>

        <a href="<?php echo e(route('admin.documents.index')); ?>" class="btn-primary">
            <i class="fas fa-angle-double-left mr-1"></i> Back
        </a>
    </div>

    <div class="max-w-4xl mx-auto card p-8">
        <form method="POST" action="<?php echo e(route('admin.documents.store')); ?>">
            <?php echo csrf_field(); ?>

            <?php echo $__env->make('admin.documents.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div class="flex justify-end mt-8">
                <button class="btn-primary px-8">Save</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/documents/create.blade.php ENDPATH**/ ?>