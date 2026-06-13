<?php $__env->startSection('title','Handymen'); ?>
<?php $__env->startSection('page_title','Handyman List'); ?>
<?php $__env->startSection('content'); ?>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Handyman</th><th>Provider</th><th>Zone</th><th>Phone</th><th>Bookings</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $handymen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><div class="flex items-center gap-3"><img src="<?php echo e($h->profile_image_url); ?>" class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
      <div><p class="font-medium text-sm text-gray-800 dark:text-gray-200"><?php echo e($h->full_name); ?></p><p class="text-xs text-gray-400"><?php echo e($h->email); ?></p></div></div></td>
      <td><span class="text-xs text-gray-500"><?php echo e($h->zone?->name ?? '—'); ?></span></td>
      <td><span class="badge badge-info"><?php echo e($h->zone?->name ?? '—'); ?></span></td>
      <td><span class="text-xs text-gray-500"><?php echo e($h->phone ?? '—'); ?></span></td>
      <td><span class="badge badge-pending"><?php echo e($h->handyman_bookings_count ?? 0); ?></span></td>
      <td>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" <?php echo e($h->status==='active'?'checked':''); ?> onchange="toggleStatus('<?php echo e(route('admin.users.toggle',$h)); ?>',this)">
          <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-primary-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
        </label>
      </td>
      <td>
        <form method="POST" action="<?php echo e(route('admin.users.destroy',$h)); ?>" id="del-hman-<?php echo e($h->id); ?>"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="button" onclick="confirmDelete('del-hman-<?php echo e($h->id); ?>')" class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100"><i class="fas fa-trash text-xs"></i></button></form>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-hard-hat text-4xl text-gray-200 mb-2 block"></i><p>No handymen found</p></td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700"><?php echo e($handymen->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/users/handymen.blade.php ENDPATH**/ ?>