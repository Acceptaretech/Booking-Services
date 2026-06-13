<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page_title', 'Platform Settings'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $getConfig = fn($key, $default = null) => $configs->get($key)?->value ?? $default;
?>

<div x-data="{ tab: 'general' }" class="space-y-6">

    
    <div class="card p-3">
        <div class="flex gap-2 overflow-x-auto">
            <?php $__currentLoopData = [
                'general' => ['icon' => 'fas fa-cog', 'label' => 'General'],
                'branding' => ['icon' => 'fas fa-image', 'label' => 'Branding'],
                'social' => ['icon' => 'fas fa-share-alt', 'label' => 'Social Media'],
                'payment' => ['icon' => 'fas fa-credit-card', 'label' => 'Payment'],
                'tax_zone' => ['icon' => 'fas fa-map-marked-alt', 'label' => 'Tax & Zones'],
                'seo' => ['icon' => 'fas fa-search', 'label' => 'SEO'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button"
                        @click="tab='<?php echo e($key); ?>'"
                        :class="tab === '<?php echo e($key); ?>'
                            ? 'bg-primary-600 text-white shadow'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300'"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition">
                    <i class="<?php echo e($item['icon']); ?> text-xs"></i>
                    <?php echo e($item['label']); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <form method="POST"
          action="<?php echo e(route('admin.settings.update')); ?>"
          enctype="multipart/form-data"
          class="space-y-6">
        <?php echo csrf_field(); ?>

        
        <div x-show="tab === 'general'" x-cloak>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-building text-primary-500"></i>
                        Company Information
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Company Name</label>
                            <input type="text"
                                   name="company_name"
                                   value="<?php echo e($getConfig('company_name', $getConfig('app_name', config('app.name')))); ?>"
                                   class="form-input"
                                   placeholder="Enter company name">
                        </div>

                        <div>
                            <label class="form-label">Contact Number</label>
                            <input type="text"
                                   name="contact_number"
                                   value="<?php echo e($getConfig('contact_number')); ?>"
                                   class="form-input"
                                   placeholder="+91 9876543210">
                        </div>

                        <div>
                            <label class="form-label">Contact Email</label>
                            <input type="email"
                                   name="contact_email"
                                   value="<?php echo e($getConfig('contact_email')); ?>"
                                   class="form-input"
                                   placeholder="support@example.com">
                        </div>

                        <div>
                            <label class="form-label">Company Address</label>
                            <textarea name="company_address"
                                      rows="3"
                                      class="form-input resize-none"
                                      placeholder="Enter company address"><?php echo e($getConfig('company_address')); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-mobile-alt text-primary-500"></i>
                        App Download Links
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Google Play Store URL</label>
                            <input type="url"
                                   name="google_play_url"
                                   value="<?php echo e($getConfig('google_play_url')); ?>"
                                   class="form-input"
                                   placeholder="https://play.google.com/store/apps/details?id=...">
                        </div>

                        <div>
                            <label class="form-label">Apple App Store URL</label>
                            <input type="url"
                                   name="app_store_url"
                                   value="<?php echo e($getConfig('app_store_url')); ?>"
                                   class="form-input"
                                   placeholder="https://apps.apple.com/app/...">
                        </div>

                        <div>
                            <label class="form-label">Footer Description</label>
                            <textarea name="footer_description"
                                      rows="4"
                                      class="form-input resize-none"
                                      placeholder="Short description about your platform"><?php echo e($getConfig('footer_description')); ?></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        
        <div x-show="tab === 'branding'" x-cloak>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-image text-primary-500"></i>
                        Website Logo
                    </h3>

                    <?php if($getConfig('logo')): ?>
                        <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <p class="text-xs text-gray-500 mb-2">Current Logo</p>
                            <img src="<?php echo e(asset('storage/'.$getConfig('logo'))); ?>"
                                 alt="Logo"
                                 class="h-14 w-auto">
                        </div>
                    <?php endif; ?>

                    <input type="file"
                           name="logo"
                           accept="image/*"
                           class="form-input py-2">

                    <p class="text-xs text-gray-400 mt-2">
                        Recommended size: 200x60px. Supported: PNG, JPG, JPEG, WEBP.
                    </p>
                </div>

                <div class="card p-6">
                    <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                        <i class="fas fa-star text-primary-500"></i>
                        Favicon
                    </h3>

                    <?php if($getConfig('favicon')): ?>
                        <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <p class="text-xs text-gray-500 mb-2">Current Favicon</p>
                            <img src="<?php echo e(asset('storage/'.$getConfig('favicon'))); ?>"
                                 alt="Favicon"
                                 class="h-10 w-10 object-contain">
                        </div>
                    <?php endif; ?>

                    <input type="file"
                           name="favicon"
                           accept="image/*"
                           class="form-input py-2">

                    <p class="text-xs text-gray-400 mt-2">
                        Recommended size: 32x32px or 64x64px.
                    </p>
                </div>

            </div>
        </div>

        
        <div x-show="tab === 'social'" x-cloak>
            <div class="card p-6 max-w-4xl">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                    <i class="fas fa-share-alt text-primary-500"></i>
                    Social Media Links
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = [
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter',
                        'instagram' => 'Instagram',
                        'linkedin' => 'LinkedIn',
                        'youtube' => 'YouTube',
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label class="form-label"><?php echo e($label); ?> URL</label>
                            <div class="relative">
                                <i class="fab fa-<?php echo e($key); ?> absolute left-3 top-3 text-gray-400"></i>
                                <input type="url"
                                       name="social_<?php echo e($key); ?>"
                                       value="<?php echo e($getConfig('social_'.$key)); ?>"
                                       class="form-input pl-10"
                                       placeholder="https://<?php echo e($key); ?>.com/yourpage">
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        
        <div x-show="tab === 'payment'" x-cloak>
            <div class="card p-6 max-w-4xl">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                    <i class="fas fa-credit-card text-primary-500"></i>
                    Payment Configuration
                </h3>

                <div class="space-y-6">

                    <div class="p-5 border border-gray-200 dark:border-gray-700 rounded-xl">
                        <h4 class="font-semibold text-sm mb-4 flex items-center gap-2">
                            <i class="fas fa-rupee-sign text-blue-500"></i>
                            Razorpay
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Razorpay Key ID</label>
                                <input type="password"
                                       name="razorpay_key"
                                       value="<?php echo e($getConfig('razorpay_key')); ?>"
                                       class="form-input"
                                       placeholder="rzp_live_xxxxx">
                            </div>

                            <div>
                                <label class="form-label">Razorpay Secret</label>
                                <input type="password"
                                       name="razorpay_secret"
                                       value="<?php echo e($getConfig('razorpay_secret')); ?>"
                                       class="form-input"
                                       placeholder="Secret key">
                            </div>
                        </div>
                    </div>

                    <div class="p-5 border border-gray-200 dark:border-gray-700 rounded-xl">
                        <h4 class="font-semibold text-sm mb-4 flex items-center gap-2">
                            <i class="fab fa-stripe-s text-purple-500"></i>
                            Stripe
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Stripe Publishable Key</label>
                                <input type="password"
                                       name="stripe_key"
                                       value="<?php echo e($getConfig('stripe_key')); ?>"
                                       class="form-input"
                                       placeholder="pk_live_xxxxx">
                            </div>

                            <div>
                                <label class="form-label">Stripe Secret Key</label>
                                <input type="password"
                                       name="stripe_secret"
                                       value="<?php echo e($getConfig('stripe_secret')); ?>"
                                       class="form-input"
                                       placeholder="sk_live_xxxxx">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
        <div x-show="tab === 'seo'" x-cloak>
            <div class="card p-6 max-w-3xl">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                    <i class="fas fa-search text-primary-500"></i>
                    SEO Settings
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="form-label">Meta Title</label>
                        <input type="text"
                               name="meta_title"
                               value="<?php echo e($getConfig('meta_title')); ?>"
                               class="form-input"
                               placeholder="HandyMan - Your Instant Service Partner">
                    </div>

                    <div>
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description"
                                  rows="4"
                                  class="form-input resize-none"
                                  placeholder="Book trusted home services online"><?php echo e($getConfig('meta_description')); ?></textarea>
                    </div>

                    <div>
                        <label class="form-label">Meta Keywords</label>
                        <input type="text"
                               name="meta_keywords"
                               value="<?php echo e($getConfig('meta_keywords')); ?>"
                               class="form-input"
                               placeholder="home service, handyman, repair, cleaning">
                    </div>
                </div>
            </div>
        </div>

        
        <div x-show="tab !== 'tax_zone'" x-cloak class="flex justify-end">
            <button type="submit" class="btn-primary px-8">
                <i class="fas fa-save"></i>
                Save Settings
            </button>
        </div>

    </form>

    
    <div x-show="tab === 'tax_zone'" x-cloak>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            
            <div class="card p-6">
                <h3 class="font-semibold text-gray-800 dark:text-white mb-5 flex items-center gap-2">
                    <i class="fas fa-percent text-primary-500"></i>
                    Tax Settings
                </h3>

                <div class="overflow-x-auto mb-5">
                    <table class="data-table w-full">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Value</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="font-medium"><?php echo e($tax->title); ?></td>
                                    <td>
                                        <?php echo e($tax->value); ?>

                                        <?php echo e($tax->type === 'percent' ? '%' : '₹'); ?>

                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            <?php echo e(ucfirst($tax->type)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo e($tax->status === 'active' ? 'badge-success' : 'badge-pending'); ?>">
                                            <?php echo e(ucfirst($tax->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-gray-400 py-5">
                                        No tax records found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <form method="POST" action="<?php echo e(route('admin.settings.tax')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>

                    <h4 class="font-semibold text-sm text-gray-700 dark:text-gray-300">
                        Add New Tax
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <input type="text"
                               name="title"
                               required
                               placeholder="Tax Name"
                               class="form-input">

                        <input type="number"
                               name="value"
                               required
                               min="0"
                               step="0.01"
                               placeholder="Value"
                               class="form-input">

                        <select name="type" class="form-select">
                            <option value="percent">Percent %</option>
                            <option value="fixed">Fixed ₹</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <select name="status" class="form-select w-40">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>

                        <button type="submit" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Add Tax
                        </button>
                    </div>
                </form>
            </div>

            
            <div class="card p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-primary-500"></i>
                        Zones Management
                    </h3>

                    <a href="<?php echo e(route('admin.zones.create')); ?>" class="btn-primary text-xs">
                        <i class="fas fa-plus"></i>
                        Add Zone
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="data-table w-full">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="font-medium"><?php echo e($zone->name); ?></td>
                                    <td class="text-gray-500"><?php echo e($zone->country ?? '—'); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($zone->status === 'active' ? 'badge-success' : 'badge-pending'); ?>">
                                            <?php echo e(ucfirst($zone->status)); ?>

                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-gray-400 py-5">
                                        No zones found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>