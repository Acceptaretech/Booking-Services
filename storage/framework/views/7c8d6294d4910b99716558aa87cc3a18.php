<?php $__env->startSection('title','Edit Category'); ?>
<?php $__env->startSection('page_title','Edit Category'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-5">
  <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn-secondary text-xs py-2"><i class="fas fa-arrow-left"></i>Back</a>
  <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Editing: <span class="text-primary-600"><?php echo e($category->name); ?></span></h2>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
  <div class="lg:col-span-2 card p-6">
    <form method="POST" action="<?php echo e(route('admin.categories.update',$category)); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <?php if($errors->any()): ?>
      <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><p><?php echo e($e); ?></p><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
    <div class="mb-5">
      <label class="form-label">Category Name <span class="text-red-500">*</span></label>
      <input name="name" value="<?php echo e(old('name',$category->name)); ?>" required class="form-input">
    </div>
    <div class="mb-5">
      <label class="form-label">Description</label>
      <textarea name="description" rows="4" class="form-input resize-none"><?php echo e(old('description',$category->description)); ?></textarea>
    </div>
    <div class="mb-5">
      <label class="form-label">Category Image</label>
      <?php if($category->image): ?>
        <div class="mb-3 flex items-center gap-3">
          <img src="<?php echo e(asset('storage/'.$category->image)); ?>" class="w-20 h-20 rounded-xl object-cover shadow">
          <p class="text-xs text-gray-400">Current image — upload new to replace</p>
        </div>
      <?php endif; ?>
      <input type="file" name="image" accept="image/*" class="form-input py-2" onchange="previewEdit(this)">
      <div id="editPreview" class="hidden mt-3">
        <img id="editImg" class="w-20 h-20 rounded-xl object-cover shadow">
      </div>
    </div>
    <div class="grid grid-cols-2 gap-5 mb-5">
      <div>
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="active"   <?php echo e(($category->status==='active')?'selected':''); ?>>Active</option>
          <option value="inactive" <?php echo e(($category->status==='inactive')?'selected':''); ?>>Inactive</option>
        </select>
      </div>
      <div>
        <label class="form-label">Sort Order</label>
        <input type="number" name="sort_order" value="<?php echo e(old('sort_order',$category->sort_order)); ?>" min="0" class="form-input">
      </div>
    </div>
    <label class="flex items-center gap-2.5 cursor-pointer mb-6 select-none">
      <div class="relative">
        <input type="checkbox" name="is_featured" value="1" <?php echo e($category->is_featured?'checked':''); ?> class="sr-only peer">
        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-primary-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
      </div>
      <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Set as Featured</span>
    </label>
    <div class="flex gap-3 pt-2 border-t border-gray-100 dark:border-gray-700">
      <button type="submit" class="btn-primary"><i class="fas fa-save"></i>Update Category</button>
      <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn-secondary">Cancel</a>
    </div>
    </form>
  </div>
  <div class="card p-5 h-fit">
    <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-3">Category Info</h3>
    <div class="space-y-2 text-xs text-gray-500">
      <p>Created: <span class="text-gray-700 dark:text-gray-300"><?php echo e($category->created_at->format('M d, Y')); ?></span></p>
      <p>Updated: <span class="text-gray-700 dark:text-gray-300"><?php echo e($category->updated_at->format('M d, Y')); ?></span></p>
      <p>Services: <span class="text-primary-600 font-semibold"><?php echo e($category->services()->count()); ?></span></p>
    </div>
    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
      <form method="POST" action="<?php echo e(route('admin.categories.destroy',$category)); ?>" id="del-edit-cat">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="button" onclick="confirmDelete('del-edit-cat','Delete this category? All associated sub-categories may be affected.')"
                class="btn-danger w-full justify-center text-xs py-2">
          <i class="fas fa-trash"></i>Delete Category
        </button>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function previewEdit(input){
  if(!input.files||!input.files[0]) return;
  const reader=new FileReader();
  reader.onload=e=>{
    document.getElementById('editImg').src=e.target.result;
    document.getElementById('editPreview').classList.remove('hidden');
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>