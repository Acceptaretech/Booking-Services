

<?php $__env->startSection('page_title', $page->title); ?>

<?php $__env->startSection('content'); ?>

<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">
            <?php echo e($page->title); ?>

        </h2>

        <a href="<?php echo e(url()->previous()); ?>"
           class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            <i class="fas fa-angle-double-left mr-1"></i> Back
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">

        <form method="POST" action="<?php echo e(route('admin.pages.update', $page->slug)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label class="block mb-2 font-semibold text-gray-800 dark:text-white">
                    <?php echo e($page->title); ?> <span class="text-red-500">*</span>
                </label>

                <textarea name="content" id="editor" rows="15"
                    class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"><?php echo e(old('content', $page->content)); ?></textarea>

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

            <div class="mt-6 flex items-center justify-between bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl p-5 max-w-md">
                <span class="font-semibold text-gray-800 dark:text-white">Status</span>

                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="status" class="sr-only peer" <?php echo e($page->status ? 'checked' : ''); ?>>
                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:bg-indigo-600
                        after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full
                        after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-7">
                    </div>
                </label>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit"
                    class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                    Save
                </button>
            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>

<script>
tinymce.init({
    selector: '#editor',
    height: 500,
    menubar: false,
    plugins: 'lists link image table code',
    toolbar: 'blocks | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify | bullist numlist | code image',
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/pages/edit.blade.php ENDPATH**/ ?>