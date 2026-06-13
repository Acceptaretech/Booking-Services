<?php $__env->startSection('title', $blog->title ?? 'Blog Details'); ?>

<?php $__env->startSection('content'); ?>

<div class="max-w-4xl mx-auto px-4 py-10">

    
    <?php if(!empty($blog->image)): ?>
        <img
            src="<?php echo e(asset('storage/' . $blog->image)); ?>"
            alt="<?php echo e($blog->title); ?>"
            class="w-full h-72 object-cover rounded-2xl mb-8">
    <?php endif; ?>

    
    <div class="flex flex-wrap items-center gap-3 mb-5 text-sm text-gray-500">

        <span>
            <?php echo e($blog->author->full_name ?? $blog->author->name ?? 'Admin'); ?>

        </span>

        <span>•</span>

        <span>
            <?php if($blog->published_at): ?>
                <?php echo e(\Carbon\Carbon::parse($blog->published_at)->format('M d, Y')); ?>

            <?php else: ?>
                <?php echo e($blog->created_at ? $blog->created_at->format('M d, Y') : ''); ?>

            <?php endif; ?>
        </span>

        <?php if(!empty($blog->read_time)): ?>
            <span>•</span>
            <span><?php echo e($blog->read_time); ?> Min Read</span>
        <?php endif; ?>

        <span>•</span>
        <span><?php echo e($blog->views ?? 0); ?> Views</span>

    </div>

    
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
        <?php echo e($blog->title); ?>

    </h1>

    
    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">

        <?php echo $blog->content; ?>


    </div>

    
    <?php if(isset($related) && $related->count()): ?>

        <div class="mt-16 pt-8 border-t border-gray-200 dark:border-gray-700">

            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Related Posts
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <a href="<?php echo e(route('blog.detail', $r->id)); ?>"
                       class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">

                        <?php if(!empty($r->image)): ?>
                            <img
                                src="<?php echo e(asset('storage/' . $r->image)); ?>"
                                alt="<?php echo e($r->title); ?>"
                                class="w-full h-40 object-cover">
                        <?php endif; ?>

                        <div class="p-4">

                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition line-clamp-2">
                                <?php echo e($r->title); ?>

                            </h4>

                            <p class="text-xs text-gray-500 mt-2">
                                <?php if($r->published_at): ?>
                                    <?php echo e(\Carbon\Carbon::parse($r->published_at)->format('M d, Y')); ?>

                                <?php endif; ?>
                            </p>

                        </div>

                    </a>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>

        </div>

    <?php endif; ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/public/blogs/show.blade.php ENDPATH**/ ?>