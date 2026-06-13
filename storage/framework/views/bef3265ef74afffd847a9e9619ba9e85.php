<?php $__env->startSection('title','Add Category'); ?>
<?php $__env->startSection('page_title','Add New Category'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-5">
  <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn-secondary text-xs py-2">
    <i class="fas fa-arrow-left"></i>Back
  </a>
  <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Create a new service category</h2>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
  <div class="lg:col-span-2">
    <div class="card p-6">
      <form method="POST" action="<?php echo e(route('admin.categories.store')); ?>" enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php if($errors->any()): ?>
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
          <ul class="list-disc list-inside space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="mb-5">
        <label class="form-label">Category Name <span class="text-red-500">*</span></label>
        <input name="name" value="<?php echo e(old('name')); ?>" required placeholder="e.g. Plumbing, Electrician…"
               class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="mb-5">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" placeholder="Describe what this category covers…"
                  class="form-input resize-none"><?php echo e(old('description')); ?></textarea>
      </div>

      <div class="mb-5">
        <label class="form-label">Category Image <span class="text-red-500">*</span></label>
        <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-2xl p-8 text-center
                    hover:border-primary-400 dark:hover:border-primary-500 transition-colors cursor-pointer"
             onclick="document.getElementById('imgInput').click()">
          <div id="imgPreview" class="hidden mb-4">
            <img id="previewImg" class="w-28 h-28 rounded-2xl object-cover mx-auto shadow-md" alt="">
          </div>
          <div id="uploadPlaceholder">
            <div class="w-14 h-14 rounded-2xl bg-primary-50 dark:bg-primary-900/20 flex items-center justify-center mx-auto mb-3">
              <i class="fas fa-cloud-upload-alt text-primary-500 text-2xl"></i>
            </div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Click to upload image</p>
            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP · Max 2MB</p>
          </div>
          <input type="file" id="imgInput" name="image" accept="image/*" required class="hidden"
                 onchange="previewImage(this)">
        </div>
      </div>

      <div class="grid grid-cols-2 gap-5 mb-5">
        <div>
          <label class="form-label">Status <span class="text-red-500">*</span></label>
          <select name="status" class="form-select">
            <option value="active"   <?php echo e(old('status','active')==='active'?'selected':''); ?>>Active</option>
            <option value="inactive" <?php echo e(old('status')==='inactive'?'selected':''); ?>>Inactive</option>
          </select>
        </div>
        <div>
          <label class="form-label">Sort Order</label>
          <input type="number" name="sort_order" value="<?php echo e(old('sort_order',0)); ?>" min="0" class="form-input">
          <p class="text-xs text-gray-400 mt-1">Lower number = appears first</p>
        </div>
      </div>

      <div class="flex gap-5 items-center mb-6">
        <label class="flex items-center gap-2.5 cursor-pointer select-none">
          <div class="relative">
            <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured')?'checked':''); ?>

                   class="sr-only peer" id="featuredChk">
            <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-primary-600
                        after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white
                        after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-4"></div>
          </div>
          <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Set as Featured</span>
        </label>
      </div>

      <div class="flex gap-3 pt-2 border-t border-gray-100 dark:border-gray-700">
        <button type="submit" class="btn-primary px-8"><i class="fas fa-save"></i>Save Category</button>
        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn-secondary">Cancel</a>
      </div>
      </form>
    </div>
  </div>

  <div class="space-y-4">
    <div class="card p-5">
      <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-3 flex items-center gap-2">
        <i class="fas fa-lightbulb text-yellow-500"></i> Tips
      </h3>
      <ul class="space-y-2.5 text-xs text-gray-500 dark:text-gray-400">
        <li class="flex gap-2"><i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>Use a clear icon-style image (white bg or transparent)</li>
        <li class="flex gap-2"><i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>Keep the name short (1–3 words)</li>
        <li class="flex gap-2"><i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>Featured categories appear on the homepage</li>
        <li class="flex gap-2"><i class="fas fa-check-circle text-emerald-500 mt-0.5 flex-shrink-0"></i>Sort order controls display position (0 = top)</li>
      </ul>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function previewImage(input){
  if(!input.files||!input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('previewImg').src = e.target.result;
    document.getElementById('imgPreview').classList.remove('hidden');
    document.getElementById('uploadPlaceholder').classList.add('hidden');
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>