<?php $__env->startSection('title','Job Service List'); ?>
<?php $__env->startSection('page_title','Job Service List'); ?>
<?php $__env->startSection('content'); ?>
<div class="card overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
    <h3 class="font-semibold text-sm text-gray-800 dark:text-white">All Services Available for Jobs</h3>
    <form method="GET" class="flex gap-2">
      <div class="relative"><i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
      <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search…" class="form-input pl-8 py-2 w-44 text-xs"></div>
    </form>
  </div>
  <table class="data-table w-full">
    <thead><tr><th>Service</th><th>Provider</th><th>Category</th><th>Price</th><th>Bookings</th><th>Status</th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><div class="flex items-center gap-2">
        <?php if($s->image): ?><img src="<?php echo e(asset('storage/'.$s->image)); ?>" class="w-8 h-8 rounded-lg object-cover"><?php endif; ?>
        <span class="text-sm font-medium text-gray-800 dark:text-gray-200"><?php echo e($s->name); ?></span>
      </div></td>
      <td><span class="text-xs text-gray-500"><?php echo e($s->provider->full_name); ?></span></td>
      <td><span class="badge badge-info"><?php echo e($s->category->name); ?></span></td>
      <td><span class="font-semibold text-primary-600">$<?php echo e(number_format($s->price,2)); ?></span></td>
      <td><span class="badge badge-pending"><?php echo e($s->total_bookings); ?></span></td>
      <td><span class="badge <?php echo e($s->status==='active'?'badge-success':'badge-pending'); ?>"><?php echo e(ucfirst($s->status)); ?></span></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="6" class="text-center py-10 text-gray-400">No services found</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700"><?php echo e($services->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/jobs/services.blade.php ENDPATH**/ ?>