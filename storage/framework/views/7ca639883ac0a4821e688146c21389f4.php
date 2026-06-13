<?php $__env->startSection('title','Zones'); ?>
<?php $__env->startSection('page_title','Zone List'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-5">
  <h2 class="text-sm text-gray-600 dark:text-gray-400">Manage service zones and locations</h2>
  <a href="<?php echo e(route('admin.zones.create')); ?>" class="btn-primary text-xs"><i class="fas fa-plus"></i>New Zone</a>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Zone Name</th><th>Country</th><th>State</th><th>City</th><th>Providers</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><p class="font-semibold text-sm text-gray-800 dark:text-gray-200"><?php echo e($zone->name); ?></p></td>
      <td><span class="text-xs text-gray-500"><?php echo e($zone->country ?? '—'); ?></span></td>
      <td><span class="text-xs text-gray-500"><?php echo e($zone->state ?? '—'); ?></span></td>
      <td><span class="text-xs text-gray-500"><?php echo e($zone->city ?? '—'); ?></span></td>
      <td><span class="badge badge-info"><?php echo e($zone->users_count ?? 0); ?> users</span></td>
      <td><span class="badge <?php echo e($zone->status==='active'?'badge-success':'badge-pending'); ?>"><?php echo e(ucfirst($zone->status)); ?></span></td>
      <td>
        <div class="flex items-center gap-1">
          <a href="<?php echo e(route('admin.zones.edit',$zone)); ?>" class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100"><i class="fas fa-edit text-xs"></i></a>
          <form method="POST" action="<?php echo e(route('admin.zones.destroy',$zone)); ?>" id="del-z-<?php echo e($zone->id); ?>"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
          <button type="button" onclick="confirmDelete('del-z-<?php echo e($zone->id); ?>')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
        </div>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="text-center py-12 text-gray-400">
      <i class="fas fa-map-marked-alt text-4xl text-gray-200 mb-2 block"></i>
      <p class="font-medium text-gray-500 mb-2">No zones yet</p>
      <a href="<?php echo e(route('admin.zones.create')); ?>" class="btn-primary text-xs"><i class="fas fa-plus"></i>Add Zone</a>
    </td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700"><?php echo e($zones->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/zones/index.blade.php ENDPATH**/ ?>