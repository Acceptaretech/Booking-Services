<?php $__env->startSection('title','Services'); ?>
<?php $__env->startSection('page_header'); ?>
    <h1 class="text-4xl font-bold mb-2">Our Services</h1>
    <p class="text-white/70">Find the perfect service for your needs</p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-10">

    
    <form method="GET" class="flex flex-wrap gap-3 mb-8 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <select name="category_id" class="flex-1 min-w-40 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">All Categories</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id')==$cat->id?'selected':''); ?>><?php echo e($cat->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="provider_id" class="flex-1 min-w-40 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">All Providers</option>
            <?php $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($p->id); ?>" <?php echo e(request('provider_id')==$p->id?'selected':''); ?>><?php echo e($p->full_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="price" class="flex-1 min-w-32 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">All Price</option>
            <option value="free" <?php echo e(request('price')==='free'?'selected':''); ?>>Free</option>
            <option value="0-25" <?php echo e(request('price')==='0-25'?'selected':''); ?>>$0 - $25</option>
            <option value="25-50" <?php echo e(request('price')==='25-50'?'selected':''); ?>>$25 - $50</option>
            <option value="50+" <?php echo e(request('price')==='50+'?'selected':''); ?>>$50+</option>
        </select>

        <select name="sort" class="flex-1 min-w-36 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Sort By</option>
            <option value="top_rated"    <?php echo e(request('sort')==='top_rated'?'selected':''); ?>>Top Rated</option>
            <option value="best_selling" <?php echo e(request('sort')==='best_selling'?'selected':''); ?>>Best Selling</option>
            <option value="newest"       <?php echo e(request('sort')==='newest'?'selected':''); ?>>Newest</option>
        </select>

        <div class="flex items-center gap-2 flex-1 min-w-44 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search..."
                   class="w-full py-2.5 bg-transparent text-sm text-gray-700 dark:text-gray-200 outline-none">
        </div>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
        <a href="<?php echo e(route('services')); ?>" class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">Reset</a>
    </form>

    
    <p class="text-sm text-gray-500 mb-6">
        Showing <strong class="text-gray-800 dark:text-gray-200"><?php echo e($services->total()); ?></strong> services
        <?php if(request('search')): ?> for "<strong><?php echo e(request('search')); ?></strong>" <?php endif; ?>
    </p>

    
    <?php if($services->count()): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('components.service-card', compact('service'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo e($services->withQueryString()->links()); ?>

    <?php else: ?>
    <div class="text-center py-20">
        <i class="fas fa-search text-6xl text-gray-300 mb-4 block"></i>
        <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">No services found</h3>
        <p class="text-gray-400">Try adjusting your filters or search terms</p>
        <a href="<?php echo e(route('services')); ?>" class="mt-4 inline-block bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-700 transition-colors">Browse All Services</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/public/services/index.blade.php ENDPATH**/ ?>