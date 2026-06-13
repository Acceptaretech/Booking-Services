
<div class="service-card bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl card-hover border border-gray-100 dark:border-gray-700">
    
    <div class="relative overflow-hidden h-48">
        <img src="<?php echo e($service->image_url); ?>" alt="<?php echo e($service->name); ?>"
             class="w-full h-full object-cover">
        <?php if($service->discount > 0): ?>
        <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">
            <?php echo e($service->discount); ?>% OFF
        </span>
        <?php endif; ?>
        <?php if($service->is_featured): ?>
        <span class="absolute top-3 right-3 bg-yellow-400 text-gray-900 text-xs font-bold px-2.5 py-1 rounded-full">
            <i class="fas fa-star text-xs mr-1"></i>Featured
        </span>
        <?php endif; ?>
    </div>

    
    <div class="p-4">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-1 line-clamp-1">
            <a href="<?php echo e(route('service.detail', $service)); ?>" class="hover:text-primary-600 transition-colors">
                <?php echo e($service->name); ?>

            </a>
        </h3>

        
        <div class="flex items-center gap-2 mb-2">
            <?php if($service->discount > 0): ?>
                <span class="text-gray-400 line-through text-xs">$<?php echo e(number_format($service->price, 2)); ?></span>
                <span class="font-bold text-primary-600">$<?php echo e(number_format($service->discounted_price, 2)); ?></span>
            <?php else: ?>
                <span class="font-bold text-primary-600">
                    <?php echo e($service->price == 0 ? 'Free' : '$'.number_format($service->price,2)); ?>

                </span>
            <?php endif; ?>
            <?php if($service->duration): ?>
            <span class="text-gray-400 text-xs">• <?php echo e($service->duration); ?> min</span>
            <?php endif; ?>
        </div>

        
        <div class="flex items-center gap-2 mb-3">
            <img src="<?php echo e($service->provider->profile_image_url); ?>" class="w-6 h-6 rounded-full object-cover" alt="">
            <span class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($service->provider->full_name); ?></span>
        </div>

        
        <?php if($service->total_reviews > 0): ?>
        <div class="flex items-center gap-1 mb-3">
            <?php for($i = 1; $i <= 5; $i++): ?>
            <i class="fas fa-star text-xs <?php echo e($i <= round($service->avg_rating) ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
            <?php endfor; ?>
            <span class="text-xs text-gray-500 ml-1"><?php echo e($service->avg_rating); ?> (<?php echo e($service->total_reviews); ?>)</span>
        </div>
        <?php endif; ?>

        <a href="<?php echo e(route('service.detail', $service)); ?>"
           class="block w-full text-center bg-primary-50 hover:bg-primary-600 text-primary-600 hover:text-white border border-primary-200 hover:border-transparent py-2 rounded-xl text-sm font-medium transition-all">
            Book Now
        </a>
    </div>
</div>
<?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/components/service-card.blade.php ENDPATH**/ ?>