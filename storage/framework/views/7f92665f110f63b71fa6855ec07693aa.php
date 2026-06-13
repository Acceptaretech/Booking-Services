<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('page_title','Category List'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
  <form method="GET" class="flex gap-2">
    <div class="relative">
      <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
      <input name="search" value="<?php echo e(request('search')); ?>" placeholder="Search categories…" class="form-input pl-8 py-2 w-52 text-xs">
    </div>
    <button class="btn-secondary text-xs py-2"><i class="fas fa-search"></i>Search</button>
  </form>
  <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn-primary text-xs">
    <i class="fas fa-plus"></i>New Category
  </a>
</div>

<div class="card overflow-hidden">
  <div class="overflow-x-auto">
  <table class="data-table w-full">
    <thead>
      <tr>
        <th class="w-8"><input type="checkbox" class="rounded" id="sa"
              onclick="document.querySelectorAll('.rc').forEach(c=>c.checked=this.checked)"></th>
        <th>Name</th><th>Description</th><th>Services</th><th>Featured</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
      <td><input type="checkbox" class="rc rounded" value="<?php echo e($cat->id); ?>"></td>
      <td>
        <div class="flex items-center gap-3">
          <?php if($cat->image): ?>
            <img src="<?php echo e(asset('storage/'.$cat->image)); ?>" class="w-10 h-10 rounded-xl object-cover flex-shrink-0" alt="">
          <?php else: ?>
            <div class="w-10 h-10 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0">
              <i class="fas fa-layer-group text-primary-500 text-sm"></i>
            </div>
          <?php endif; ?>
          <div>
            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200"><?php echo e($cat->name); ?></p>
            <p class="text-xs text-gray-400">Sort: <?php echo e($cat->sort_order); ?></p>
          </div>
        </div>
      </td>
      <td><p class="text-xs text-gray-500 dark:text-gray-400 max-w-xs line-clamp-2"><?php echo e($cat->description ?? '—'); ?></p></td>
      <td><span class="badge badge-info"><?php echo e($cat->services_count ?? 0); ?></span></td>
      <td>
        <?php if($cat->is_featured): ?>
          <span class="badge badge-warning"><i class="fas fa-star mr-1 text-xs"></i>Featured</span>
        <?php else: ?>
          <span class="text-gray-300 text-xs">—</span>
        <?php endif; ?>
      </td>
      <td>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer" <?php echo e($cat->status==='active'?'checked':''); ?>

                 onchange="toggleStatus('<?php echo e(route('admin.categories.toggle',$cat)); ?>',this)">
          <div class="w-9 h-5 bg-gray-200 dark:bg-gray-600 rounded-full peer peer-checked:bg-primary-600
                      after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white
                      after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
        </label>
      </td>
      <td>
        <div class="flex items-center gap-1">
          <a href="<?php echo e(route('admin.categories.edit',$cat)); ?>"
             class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 hover:bg-blue-100 transition-colors" title="Edit">
            <i class="fas fa-edit text-xs"></i>
          </a>
          <form method="POST" action="<?php echo e(route('admin.categories.destroy',$cat)); ?>" id="del-cat-<?php echo e($cat->id); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="button" onclick="confirmDelete('del-cat-<?php echo e($cat->id); ?>')"
                    class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 hover:bg-red-100 transition-colors" title="Delete">
              <i class="fas fa-trash text-xs"></i>
            </button>
          </form>
        </div>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
      <td colspan="7" class="text-center py-14">
        <div class="flex flex-col items-center gap-2 text-gray-400">
          <i class="fas fa-layer-group text-5xl text-gray-200 mb-2"></i>
          <p class="font-semibold text-gray-500">No categories found</p>
          <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn-primary text-xs mt-2">
            <i class="fas fa-plus"></i>Add First Category
          </a>
        </div>
      </td>
    </tr>
    <?php endif; ?>
    </tbody>
  </table>
  </div>
  <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between flex-wrap gap-2">
    <p class="text-xs text-gray-500">
      Showing <?php echo e($cats->firstItem()); ?>–<?php echo e($cats->lastItem()); ?> of <?php echo e($cats->total()); ?> categories
    </p>
    <?php echo e($cats->withQueryString()->links()); ?>

  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>