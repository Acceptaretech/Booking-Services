<?php $__env->startSection('title','Edit Zone'); ?>
<?php $__env->startSection('page_title','Edit Zone'); ?>
<?php $__env->startSection('content'); ?>
<a href="<?php echo e(route('admin.zones.index')); ?>" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="card p-6 max-w-lg">
  <form method="POST" action="<?php echo e(route('admin.zones.update',$zone)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
  <div class="mb-4"><label class="form-label">Zone Name <span class="text-red-500">*</span></label>
  <input name="name" value="<?php echo e(old('name',$zone->name)); ?>" required class="form-input"></div>
  <div class="grid grid-cols-2 gap-4 mb-4">
    <div><label class="form-label">Country</label><input name="country" value="<?php echo e(old('country',$zone->country)); ?>" class="form-input"></div>
    <div><label class="form-label">State</label><input name="state" value="<?php echo e(old('state',$zone->state)); ?>" class="form-input"></div>
  </div>
  <div class="mb-5"><label class="form-label">City</label><input name="city" value="<?php echo e(old('city',$zone->city)); ?>" class="form-input"></div>
  <div class="mb-6"><label class="form-label">Status</label>
  <select name="status" class="form-select w-40"><option value="active" <?php echo e($zone->status==='active'?'selected':''); ?>>Active</option><option value="inactive" <?php echo e($zone->status==='inactive'?'selected':''); ?>>Inactive</option></select></div>
  <div class="flex gap-3"><button type="submit" class="btn-primary"><i class="fas fa-save"></i>Update Zone</button><a href="<?php echo e(route('admin.zones.index')); ?>" class="btn-secondary">Cancel</a></div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/zones/edit.blade.php ENDPATH**/ ?>