<?php $__env->startSection('title','Forgot Password'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
<div class="w-full max-w-md bg-gray-800 rounded-2xl p-8 shadow-2xl">
    <div class="text-center mb-6">
        <div class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4"><i class="fas fa-lock text-white text-2xl"></i></div>
        <h1 class="text-2xl font-bold text-white">Forgot Password</h1>
        <p class="text-gray-400 text-sm mt-1">Enter your email to reset your password</p>
    </div>
    <?php if(session('status')): ?><div class="bg-green-900/30 border border-green-500 text-green-300 px-4 py-3 rounded-xl mb-4 text-sm"><?php echo e(session('status')); ?></div><?php endif; ?>
    <?php if($errors->any()): ?><div class="bg-red-900/30 border border-red-500 text-red-300 px-4 py-3 rounded-xl mb-4 text-sm"><?php echo e($errors->first()); ?></div><?php endif; ?>
    <form method="POST" action="<?php echo e(route('password.email')); ?>">
        <?php echo csrf_field(); ?>
        <div class="mb-6"><label class="block text-primary-400 text-sm mb-1.5">Email *</label>
        <input type="email" name="email" value="<?php echo e(old('email')); ?>" required placeholder="Enter your email" class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500"></div>
        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-xl font-semibold transition-colors">Send Reset Link</button>
        <p class="text-center text-gray-400 text-sm mt-4"><a href="<?php echo e(route('login')); ?>" class="text-primary-400 hover:underline">Back to Login</a></p>
    </form>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>