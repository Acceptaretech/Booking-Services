<?php $__env->startSection('page_title','Help-Desk Index'); ?>
<?php $__env->startSection('content'); ?>
<div class="card p-8 text-center">
  <i class="fas fa-tools text-4xl mb-3 block text-primary-400"></i>
  <p class="font-semibold text-gray-700 dark:text-gray-200">Help-Desk Index</p>
  <p class="text-sm text-gray-400 mt-1">This view is ready to be customized.</p>
  <a href="<?php echo e(url()->previous()); ?>" class="mt-4 inline-block btn-secondary text-xs"><i class="fas fa-arrow-left mr-1"></i> Back</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/help-desk/index.blade.php ENDPATH**/ ?>