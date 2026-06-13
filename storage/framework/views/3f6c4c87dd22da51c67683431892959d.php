<?php $__env->startSection('title','Banners'); ?>
<?php $__env->startSection('page_title','Promotional Banners'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex gap-2 mb-5">
  <?php $__currentLoopData = [''=>'All','pending'=>'Pending','accepted'=>'Approved','rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <a href="<?php echo e(request()->fullUrlWithQuery(['status'=>$val])); ?>"
     class="px-4 py-1.5 rounded-full text-xs font-medium border transition-all <?php echo e(request('status')===$val?'bg-primary-600 text-white border-primary-600':'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300'); ?>">
    <?php echo e($label); ?>

  </a>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
  <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <div class="card overflow-hidden">
    <div class="relative h-36 overflow-hidden bg-gray-100 dark:bg-gray-700">
      <img src="<?php echo e(asset('storage/'.$b->image)); ?>" class="w-full h-full object-cover">
      <?php $sc=['pending'=>'badge-warning','accepted'=>'badge-success','rejected'=>'badge-danger']; ?>
      <span class="absolute top-2 right-2 badge <?php echo e($sc[$b->status]??'badge-pending'); ?>"><?php echo e(ucfirst($b->status)); ?></span>
    </div>
    <div class="p-4">
      <div class="flex items-center gap-2 mb-2">
        <img src="<?php echo e($b->user->profile_image_url); ?>" class="w-6 h-6 rounded-full">
        <span class="text-xs text-gray-500"><?php echo e($b->user->full_name); ?></span>
      </div>
      <p class="text-xs text-gray-500 mb-2">
        <?php echo e(\Carbon\Carbon::parse($b->start_date)->format('M d')); ?> — <?php echo e(\Carbon\Carbon::parse($b->end_date)->format('M d, Y')); ?>

        · $<?php echo e(number_format($b->total_amount,2)); ?>

      </p>
      <div class="flex gap-2">
        <?php if($b->status==='pending'): ?>
        <form method="POST" action="<?php echo e(route('admin.banners.approve',$b)); ?>" class="flex-1"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <button class="btn-primary w-full justify-center text-xs py-1.5"><i class="fas fa-check"></i>Approve</button></form>
        <form method="POST" action="<?php echo e(route('admin.banners.reject',$b)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <button class="btn-danger text-xs py-1.5 px-3"><i class="fas fa-times"></i></button></form>
        <?php else: ?>
        <span class="text-xs text-gray-400 flex items-center">Decision made</span>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <div class="col-span-3 card p-14 text-center text-gray-400">
    <i class="fas fa-images text-5xl text-gray-200 mb-3 block"></i>
    <p class="font-medium text-gray-500">No banners submitted</p>
  </div>
  <?php endif; ?>
</div>
<div class="mt-5"><?php echo e($banners->withQueryString()->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>