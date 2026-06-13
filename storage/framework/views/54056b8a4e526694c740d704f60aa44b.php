<?php $__env->startSection('page_title','Blogs'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Blogs</h2>

        <a href="<?php echo e(route('admin.blogs.create')); ?>"
           class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            <i class="fas fa-plus-circle mr-1"></i> New
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Search blogs..."
                       class="rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">

                <select name="status"
                        class="rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                    <option value="">All Status</option>
                    <option value="published" <?php echo e(request('status')=='published'?'selected':''); ?>>Published</option>
                    <option value="draft" <?php echo e(request('status')=='draft'?'selected':''); ?>>Draft</option>
                </select>

                <button class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white">
                    Search
                </button>
            </form>
        </div>

        <form method="POST" action="<?php echo e(route('admin.blogs.bulk')); ?>">
            <?php echo csrf_field(); ?>

            

            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="w-full min-w-[1000px]">
                    <thead class="bg-indigo-600 text-white">
                        <tr>
                            <th class="p-4 text-left">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="p-4 text-left">Title</th>
                            <th class="p-4 text-left">Author</th>
                            <th class="p-4 text-left">Views</th>
                            <th class="p-4 text-left">Read Time</th>
                            <th class="p-4 text-left">Status</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-900">
                                <td class="p-4">
                                    <input type="checkbox" name="ids[]" value="<?php echo e($blog->id); ?>" class="rowCheck">
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <img src="<?php echo e($blog->image ? asset('storage/'.$blog->image) : asset('assets/admin/img/placeholder.png')); ?>"
                                             class="w-12 h-12 rounded-full object-cover">

                                        <div>
                                            <p class="font-semibold text-indigo-600"><?php echo e($blog->title); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($blog->slug); ?></p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4">
                                  <p class="font-semibold text-gray-800 dark:text-white">
                                      <?php echo e($blog->author ? $blog->author->first_name . ' ' . $blog->author->last_name : 'No Author'); ?>

                                  </p>
                              
                                  <p class="text-sm text-gray-500">
                                      <?php echo e($blog->author->email ?? '-'); ?>

                                  </p>
                              </td>

                                <td class="p-4 text-gray-700 dark:text-gray-300">
                                    <?php echo e($blog->views ?? 0); ?>

                                </td>

                                <td class="p-4 text-gray-700 dark:text-gray-300">
                                    <?php echo e($blog->read_time ?? 0); ?> min
                                </td>

                                <td class="p-4">
                                    <form method="POST" action="<?php echo e(route('admin.blogs.toggle', $blog->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>

                                        <button type="submit"
                                            class="px-4 py-1.5 rounded-full text-sm font-semibold
                                            <?php echo e($blog->status == 'published'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-yellow-100 text-yellow-700'); ?>">
                                            <?php echo e(ucfirst($blog->status)); ?>

                                        </button>
                                    </form>
                                </td>

                                <td class="p-4 text-center">
                                    <a href="<?php echo e(route('admin.blogs.edit', $blog->id)); ?>"
                                       class="text-indigo-600 hover:text-indigo-800 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form method="POST" action="<?php echo e(route('admin.blogs.destroy', $blog->id)); ?>"
                                          class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>

                                        <button onclick="return confirm('Delete this blog?')"
                                                class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-500">
                                    No blogs found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>

        <div class="mt-6">
            <?php echo e($blogs->links()); ?>

        </div>

    </div>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function () {
    document.querySelectorAll('.rowCheck').forEach(cb => cb.checked = this.checked);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/blogs/index.blade.php ENDPATH**/ ?>