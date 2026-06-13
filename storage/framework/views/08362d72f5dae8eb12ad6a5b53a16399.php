<?php $__env->startSection('title','Withdrawal Requests'); ?>
<?php $__env->startSection('page_title','Withdrawal Requests'); ?>
<?php $__env->startSection('content'); ?>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Bank Name</th><th>Provider</th><th>Amount</th><th>Payment Type</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><p class="font-medium text-sm text-gray-800 dark:text-gray-200"><?php echo e($w->bank_name); ?></p><p class="text-xs text-gray-400"><?php echo e($w->account_number); ?></p></td>
      <td><div class="flex items-center gap-2"><img src="<?php echo e($w->user->profile_image_url); ?>" class="w-7 h-7 rounded-full">
      <div><p class="text-xs font-medium"><?php echo e($w->user->full_name); ?></p><p class="text-xs text-gray-400"><?php echo e($w->user->email); ?></p></div></div></td>
      <td><span class="font-bold text-lg text-gray-800 dark:text-white">$<?php echo e(number_format($w->amount,2)); ?></span></td>
      <td><span class="badge badge-info capitalize"><?php echo e($w->payment_type); ?></span></td>
      <td><span class="text-xs text-gray-500"><?php echo e($w->created_at->format('M d, Y')); ?></span></td>
      <td><?php $sc=['pending'=>'badge-warning','approved'=>'badge-success','rejected'=>'badge-danger']; ?>
      <span class="badge <?php echo e($sc[$w->status]); ?>"><?php echo e(ucfirst($w->status)); ?></span></td>
      <td>
        <?php if($w->status==='pending'): ?>
        <form method="POST" action="<?php echo e(route('admin.withdrawals.approve',$w)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <button type="submit" class="btn-primary text-xs py-1.5 px-3"><i class="fas fa-check"></i>Approve</button></form>
        <?php else: ?>
        <span class="text-xs text-gray-400">—</span>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-money-bill-wave text-4xl text-gray-200 mb-2 block"></i><p>No withdrawal requests</p></td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700"><?php echo e($withdrawals->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/payments/withdrawals.blade.php ENDPATH**/ ?>