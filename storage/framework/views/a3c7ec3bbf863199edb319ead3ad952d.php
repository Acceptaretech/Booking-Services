<?php $__env->startSection('title','Add Sub-Category'); ?>
<?php $__env->startSection('page_title','Add Sub-Category'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-5">
  <a href="<?php echo e(route('admin.sub-categories.index')); ?>" class="btn-secondary text-xs py-2"><i class="fas fa-arrow-left"></i>Back</a>
</div>
<div class="card p-6 max-w-xl">
  <form method="POST" action="<?php echo e(route('admin.sub-categories.store')); ?>" enctype="multipart/form-data">
  <?php echo csrf_field(); ?>
  <div class="mb-5">
    <label class="form-label">Parent Category <span class="text-red-500">*</span></label>
    <select name="category_id" required class="form-select">
      <option value="">Select Category</option>
      <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id')==$cat->id?'selected':''); ?>><?php echo e($cat->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>
  <div class="mb-5">
    <label class="form-label">Sub-Category Name <span class="text-red-500">*</span></label>
    <input name="name" value="<?php echo e(old('name')); ?>" required placeholder="e.g. AC Installation, Pipe Repair…" class="form-input">
  </div>
  <div class="mb-5">
    <label class="form-label">Description</label>
    <textarea name="description" rows="3" class="form-input resize-none" placeholder="Brief description…"><?php echo e(old('description')); ?></textarea>
  </div>
  <div class="mb-5">
    <label class="form-label">Image</label>
    <input type="file" name="image" accept="image/*" class="form-input py-2">
  </div>
  <div class="mb-6">
    <label class="form-label">Status</label>
    <select name="status" class="form-select w-40"><option value="active">Active</option><option value="inactive">Inactive</option></select>
  </div>
  <div class="flex gap-3">
    <button type="submit" class="btn-primary"><i class="fas fa-save"></i>Save</button>
    <a href="<?php echo e(route('admin.sub-categories.index')); ?>" class="btn-secondary">Cancel</a>
  </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/sub-categories/create.blade.php ENDPATH**/ ?>