<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white"><?php echo e($title); ?></h2>

        <a href="<?php echo e(route('admin.blogs.index')); ?>"
           class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            <i class="fas fa-angle-double-left mr-1"></i> Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <form method="POST" action="<?php echo e($action); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <?php if($method == 'PUT'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title"
                           value="<?php echo e(old('title', $blog->title ?? '')); ?>"
                           class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                           placeholder="Enter blog title">
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Author <span class="text-red-500">*</span>
                    </label>
                    <select name="author_id"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                        <option value="">Select Author</option>
                        <?php $__currentLoopData = $authors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $author): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($author->id); ?>"
                            <?php echo e(old('author_id', $blog->author_id ?? '') == $author->id ? 'selected' : ''); ?>>
                            <?php echo e(trim(($author->first_name ?? '') . ' ' . ($author->last_name ?? '')) ?: $author->email); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['author_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-fullborder-gray-300 dark:bg-gray-900 dark:text-white">
                        <option value="published" <?php echo e(old('status', $blog->status ?? '') == 'published' ? 'selected' : ''); ?>>
                            Published
                        </option>
                        <option value="draft" <?php echo e(old('status', $blog->status ?? '') == 'draft' ? 'selected' : ''); ?>>
                            Draft
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Image
                    </label>
                    <input type="file" name="image"
                           class="w-full  border border-gray-300 p-2 dark:bg-gray-900 dark:text-white">

                    <?php if(!empty($blog?->image)): ?>
                        <img src="<?php echo e(asset('storage/'.$blog->image)); ?>"
                             class="w-24 h-24 object-cover mt-3">
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Read Time
                    </label>
                    <input type="number" name="read_time"
                           value="<?php echo e(old('read_time', $blog->read_time ?? '')); ?>"
                           class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                           placeholder="5">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Meta Title
                    </label>
                    <input type="text" name="meta_title"
                           value="<?php echo e(old('meta_title', $blog->meta_title ?? '')); ?>"
                           class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                           placeholder="SEO title">
                </div>

                <div class="lg:col-span-3">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Meta Description
                    </label>
                    <textarea name="meta_description" rows="3"
                              class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                              placeholder="SEO description"><?php echo e(old('meta_description', $blog->meta_description ?? '')); ?></textarea>
                </div>

                <div class="lg:col-span-3">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Content <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="editor" rows="10"
                              class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                              placeholder="Write blog content"><?php echo e(old('content', $blog->content ?? '')); ?></textarea>
                    <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="<?php echo e(route('admin.blogs.index')); ?>"
                   class="px-5 py-2.5 rounded-xl bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                    <i class="fas fa-save mr-1"></i>
                    <?php echo e($blog ? 'Update Blog' : 'Save Blog'); ?>

                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
</script><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/blogs/form.blade.php ENDPATH**/ ?>