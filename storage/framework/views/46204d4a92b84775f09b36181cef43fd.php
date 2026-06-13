<?php $__env->startSection('title','Blogs'); ?>
<?php $__env->startSection('page_header'); ?>
    <h1 class="text-4xl font-bold mb-2">Blogs</h1>
    <p class="text-white/70">Tips, guides and home service advice</p>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-end mb-6">
        <form method="GET" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 shadow-sm">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search blogs..."
                   class="text-sm bg-transparent outline-none w-52 text-gray-700 dark:text-gray-200">
        </form>
    </div>

    <?php if($blogs->count()): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('blog.detail',$blog)); ?>" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-primary-300 transition-all">
            <div class="relative h-44 overflow-hidden">
                <?php if($blog->image): ?>
                    <img src="<?php echo e(asset('storage/'.$blog->image)); ?>" alt="<?php echo e($blog->title); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-primary-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-4xl"></i>
                    </div>
                <?php endif; ?>
                <?php if($blog->read_time): ?>
                <span class="absolute top-3 right-3 bg-primary-600 text-white text-xs px-2 py-1 rounded-full"><?php echo e($blog->read_time); ?> min</span>
                <?php endif; ?>
                <span class="absolute bottom-3 left-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full"><?php echo e($blog->published_at?->format('M d, Y')); ?></span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-sm text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition-colors line-clamp-2 mb-3"><?php echo e($blog->title); ?></h3>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="<?php echo e($blog->author->profile_image_url); ?>" class="w-6 h-6 rounded-full object-cover" alt="">
                        <span class="text-xs text-gray-500"><?php echo e($blog->author->full_name); ?></span>
                    </div>
                    <span class="text-primary-600 text-xs font-medium">Read More →</span>
                </div>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php echo e($blogs->withQueryString()->links()); ?>

    <?php else: ?>
    <div class="text-center py-20 text-gray-400"><i class="fas fa-blog text-5xl mb-4 block"></i><p>No blogs yet</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/public/blogs/index.blade.php ENDPATH**/ ?>