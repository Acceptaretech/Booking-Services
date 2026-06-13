<?php $__env->startSection('title','Job Requests'); ?>
<?php $__env->startSection('page_title','Job Request List'); ?>
<?php $__env->startSection('content'); ?>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th><input type="checkbox" class="rounded"></th><th>Title</th><th>Provider</th><th>Customer</th><th>Status</th><th>Price</th><th>Action</th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><input type="checkbox" class="rounded"></td>
      <td>
        <div class="flex items-center gap-2">
          <div class="w-9 h-9 rounded-xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center flex-shrink-0"><i class="fas fa-briefcase text-primary-500 text-sm"></i></div>
          <div><p class="font-medium text-sm text-gray-800 dark:text-gray-200"><?php echo e($job->title); ?></p>
          <p class="text-xs text-gray-400"><?php echo e(Str::limit($job->description,40)); ?></p></div>
        </div>
      </td>
      <td><span class="text-xs text-gray-500"><?php echo e($job->bids->first()?->provider->full_name ?? '—'); ?></span></td>
      <td><div class="flex items-center gap-2"><img src="<?php echo e($job->customer->profile_image_url); ?>" class="w-6 h-6 rounded-full">
      <span class="text-xs text-gray-600 dark:text-gray-400"><?php echo e($job->customer->full_name); ?></span></div></td>
      <td><?php $sc=['pending'=>'badge-warning','accepted'=>'badge-success','rejected'=>'badge-danger','completed'=>'badge-info']; ?>
      <span class="badge <?php echo e($sc[$job->status]??'badge-pending'); ?>"><?php echo e(ucfirst($job->status)); ?></span></td>
      <td><span class="font-semibold text-primary-600"><?php echo e($job->price ? '$'.number_format($job->price,2) : '—'); ?></span></td>
      <td><span class="badge badge-info"><?php echo e($job->bids->count()); ?> bids</span></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-briefcase text-4xl text-gray-200 mb-2 block"></i><p>No job requests</p></td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700"><?php echo e($jobs->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/jobs/index.blade.php ENDPATH**/ ?>