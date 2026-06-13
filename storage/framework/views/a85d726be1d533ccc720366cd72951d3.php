<?php $__env->startSection('title','Ratings'); ?>
<?php $__env->startSection('page_title','Ratings & Reviews'); ?>
<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
  <?php
    $avgRating = \App\Models\Review::avg('rating') ?? 0;
    $totalReviews = \App\Models\Review::count();
    $fiveStars = \App\Models\Review::where('rating',5)->count();
  ?>
  <div class="card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl bg-yellow-100 flex items-center justify-center"><i class="fas fa-star text-yellow-500 text-xl"></i></div>
    <div><p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e(number_format($avgRating,1)); ?></p><p class="text-xs text-gray-400">Average Rating</p></div>
  </div>
  <div class="card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl bg-primary-100 flex items-center justify-center"><i class="fas fa-comments text-primary-500 text-xl"></i></div>
    <div><p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($totalReviews); ?></p><p class="text-xs text-gray-400">Total Reviews</p></div>
  </div>
  <div class="card p-5 flex items-center gap-4">
    <div class="w-12 h-12 rounded-2xl bg-emerald-100 flex items-center justify-center"><i class="fas fa-thumbs-up text-emerald-500 text-xl"></i></div>
    <div><p class="text-2xl font-bold text-gray-800 dark:text-white"><?php echo e($fiveStars); ?></p><p class="text-xs text-gray-400">5-Star Reviews</p></div>
  </div>
</div>
<div class="card overflow-hidden">
  <table class="data-table w-full">
    <thead><tr><th>Customer</th><th>Service</th><th>Provider</th><th>Handyman</th><th>Rating</th><th>Review</th><th>Date</th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><div class="flex items-center gap-2"><img src="<?php echo e($r->customer->profile_image_url); ?>" class="w-7 h-7 rounded-full">
      <span class="text-xs font-medium"><?php echo e($r->customer->full_name); ?></span></div></td>
      <td><span class="text-xs text-gray-600 dark:text-gray-400"><?php echo e(Str::limit($r->service->name,20)); ?></span></td>
      <td><span class="text-xs text-gray-500"><?php echo e($r->provider->full_name); ?></span></td>
      <td><span class="text-xs text-gray-500"><?php echo e($r->handyman?->full_name ?? '—'); ?></span></td>
      <td>
        <div class="flex items-center gap-0.5">
          <?php for($i=1;$i<=5;$i++): ?><i class="fas fa-star text-xs <?php echo e($i<=$r->rating?'text-yellow-400':'text-gray-300'); ?>"></i><?php endfor; ?>
          <span class="text-xs text-gray-500 ml-1"><?php echo e($r->rating); ?></span>
        </div>
      </td>
      <td><p class="text-xs text-gray-500 max-w-xs line-clamp-2"><?php echo e($r->review ?? '—'); ?></p></td>
      <td><span class="text-xs text-gray-400"><?php echo e($r->created_at->format('M d, Y')); ?></span></td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="7" class="text-center py-12 text-gray-400"><i class="fas fa-star text-4xl text-gray-200 mb-2 block"></i><p>No reviews yet</p></td></tr>
    <?php endif; ?>
    </tbody>
  </table>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700"><?php echo e($reviews->withQueryString()->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/ratings/index.blade.php ENDPATH**/ ?>