<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('page_header'); ?>
    <h1 class="text-4xl font-bold mb-2">All Categories</h1>
    <p class="text-white/70">Browse services by category</p>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-end mb-6">
        <form method="GET" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 shadow-sm">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search categories..."
                   class="text-sm text-gray-700 dark:text-gray-200 bg-transparent outline-none w-52">
            <button type="submit" class="text-primary-600 text-sm font-medium hover:underline">Search</button>
        </form>
    </div>

    <?php if($categories->count()): ?>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 mb-10">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('services')); ?>?category_id=<?php echo e($cat->id); ?>" class="group bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-gray-100 dark:border-gray-700 hover:border-primary-300 hover:shadow-lg transition-all">
            <div class="w-16 h-16 mx-auto mb-4 bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                <?php if($cat->image): ?>
                    <img src="<?php echo e(asset('storage/'.$cat->image)); ?>" alt="<?php echo e($cat->name); ?>" class="w-10 h-10 object-contain">
                <?php else: ?>
                    <i class="fas fa-tools text-primary-600 text-2xl"></i>
                <?php endif; ?>
            </div>
            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition-colors mb-1"><?php echo e($cat->name); ?></p>
            <p class="text-xs text-gray-400 line-clamp-2"><?php echo e(Str::limit($cat->description,60)); ?></p>
            <span class="mt-2 inline-block text-xs text-primary-500 font-medium"><?php echo e($cat->services_count); ?> services</span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo e($categories->withQueryString()->links()); ?>

    <?php else: ?>
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-layer-group text-5xl mb-4 block"></i>
        <p class="text-lg">No categories found</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/public/categories/index.blade.php ENDPATH**/ ?>