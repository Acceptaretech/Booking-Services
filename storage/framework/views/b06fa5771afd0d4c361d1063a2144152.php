<?php $__env->startSection('title','Add Zone'); ?>
<?php $__env->startSection('page_title','Add New Zone'); ?>
<?php $__env->startSection('content'); ?>
<a href="<?php echo e(route('admin.zones.index')); ?>" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="card p-6 max-w-lg">
  <form method="POST" action="<?php echo e(route('admin.zones.store')); ?>"><?php echo csrf_field(); ?>
  <div class="mb-4"><label class="form-label">Zone Name <span class="text-red-500">*</span></label>
  <input name="name" value="<?php echo e(old('name')); ?>" required placeholder="e.g. Mumbai North, Delhi South" class="form-input"></div>
  <div class="grid grid-cols-2 gap-4 mb-4">
    <div><label class="form-label">Country</label>
    <select name="country" class="form-select"><option value="">Select Country</option>
      <?php $__currentLoopData = ['India','USA','UK','Australia','Canada','UAE','Singapore']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($c); ?>" <?php echo e(old('country')===$c?'selected':''); ?>><?php echo e($c); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select></div>
    <div><label class="form-label">State / Province</label><input name="state" value="<?php echo e(old('state')); ?>" placeholder="e.g. Maharashtra" class="form-input"></div>
  </div>
  <div class="mb-5"><label class="form-label">City</label><input name="city" value="<?php echo e(old('city')); ?>" placeholder="e.g. Mumbai" class="form-input"></div>
  <div class="mb-6"><label class="form-label">Status</label>
  <select name="status" class="form-select w-40"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
  <div class="flex gap-3"><button type="submit" class="btn-primary"><i class="fas fa-save"></i>Save Zone</button><a href="<?php echo e(route('admin.zones.index')); ?>" class="btn-secondary">Cancel</a></div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/zones/create.blade.php ENDPATH**/ ?>