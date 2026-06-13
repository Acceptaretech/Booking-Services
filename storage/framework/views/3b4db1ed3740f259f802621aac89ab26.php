<?php $__env->startSection('title','Provider Detail'); ?>
<?php $__env->startSection('page_title','Provider Detail'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center gap-3 mb-5">
  <a href="<?php echo e(route('admin.providers.index')); ?>" class="btn-secondary text-xs py-2"><i class="fas fa-arrow-left"></i>Back</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
  <div class="space-y-5">
    <div class="card p-6 text-center">
      <img src="<?php echo e($user->profile_image_url); ?>" class="w-20 h-20 rounded-2xl object-cover mx-auto mb-3">
      <h2 class="font-bold text-gray-900 dark:text-white"><?php echo e($user->full_name); ?></h2>
      <p class="text-sm text-gray-400"><?php echo e($user->designation ?? 'Provider'); ?></p>
      <p class="text-xs text-gray-400 mt-1"><?php echo e($user->email); ?></p>
      <?php $sc=['active'=>'badge-success','pending'=>'badge-warning','rejected'=>'badge-danger']; ?>
      <div class="mt-3"><span class="badge <?php echo e($sc[$user->status]??'badge-pending'); ?>"><?php echo e(ucfirst($user->status)); ?></span></div>
      <?php if($user->status==='pending'): ?>
      <div class="flex gap-2 mt-4">
        <form method="POST" action="<?php echo e(route('admin.providers.approve',$user)); ?>" class="flex-1"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <button class="btn-primary w-full justify-center text-xs py-2"><i class="fas fa-check"></i>Approve</button></form>
        <form method="POST" action="<?php echo e(route('admin.providers.reject',$user)); ?>" class="flex-1"><?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
        <button class="btn-danger w-full justify-center text-xs py-2"><i class="fas fa-times"></i>Reject</button></form>
      </div>
      <?php endif; ?>
    </div>
    <div class="card p-5">
      <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-4">Commission Setting</h3>
      <form method="POST" action="<?php echo e(route('admin.providers.commission',$user)); ?>"><?php echo csrf_field(); ?>
        <div class="mb-3"><label class="form-label text-xs">Commission Value</label>
        <input type="number" name="commission_value" value="<?php echo e($user->commissionSetting?->commission_value ?? 10); ?>" min="0" max="100" step="0.01" class="form-input"></div>
        <div class="mb-3"><label class="form-label text-xs">Commission Type</label>
        <select name="commission_type" class="form-select">
          <option value="percent" <?php echo e(($user->commissionSetting?->commission_type==='percent')?'selected':''); ?>>Percent (%)</option>
          <option value="fixed" <?php echo e(($user->commissionSetting?->commission_type==='fixed')?'selected':''); ?>>Fixed ($)</option>
        </select></div>
        <button class="btn-primary w-full justify-center text-xs py-2"><i class="fas fa-save"></i>Save Commission</button>
      </form>
    </div>
    <?php if($user->document): ?>
    <div class="card p-5">
      <h3 class="font-semibold text-sm text-gray-800 dark:text-white mb-4">KYC Documents</h3>
      <?php $__currentLoopData = ['passport'=>'Passport','aadhar_card'=>'Aadhar Card','pan_card'=>'PAN Card','driving_licence'=>'Driving Licence','voting_card'=>'Voting Card']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if($user->document->$field): ?>
      <div class="mb-2"><p class="text-xs text-gray-500 mb-1"><?php echo e($label); ?></p>
      <a href="<?php echo e(asset('storage/'.$user->document->$field)); ?>" target="_blank" class="text-xs text-primary-600 hover:underline flex items-center gap-1"><i class="fas fa-file-alt"></i>View Document</a></div>
      <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
  </div>
  <div class="lg:col-span-2 space-y-5">
    <div class="grid grid-cols-3 gap-4">
      <?php $__currentLoopData = [['Total Bookings','fas fa-calendar-check',$user->providerBookings->count(),'bg-primary-100 text-primary-600'],['Total Services','fas fa-concierge-bell',$user->services->count(),'bg-purple-100 text-purple-600'],['Avg Rating','fas fa-star',number_format($user->reviews->avg('rating')??0,1),'bg-yellow-100 text-yellow-600']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="card p-4 text-center"><div class="w-10 h-10 rounded-xl <?php echo e($s[3]); ?> flex items-center justify-center mx-auto mb-2"><i class="<?php echo e($s[1]); ?> text-sm"></i></div>
      <p class="text-xl font-bold text-gray-800 dark:text-white"><?php echo e($s[2]); ?></p><p class="text-xs text-gray-400"><?php echo e($s[0]); ?></p></div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="card overflow-hidden">
      <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-700"><h3 class="font-semibold text-sm text-gray-800 dark:text-white">Services</h3></div>
      <table class="data-table w-full">
        <thead><tr><th>Service</th><th>Category</th><th>Price</th><th>Bookings</th><th>Status</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $user->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
          <td><div class="flex items-center gap-2"><?php if($s->image): ?><img src="<?php echo e(asset('storage/'.$s->image)); ?>" class="w-8 h-8 rounded-lg object-cover"><?php endif; ?><span class="text-sm font-medium"><?php echo e($s->name); ?></span></div></td>
          <td>
            <span class="text-xs text-gray-500">
                <?php echo e($s->category->name ?? 'No Category'); ?>

            </span>
        </td>
          <td><span class="font-medium text-primary-600">$<?php echo e(number_format($s->price,2)); ?></span></td>
          <td><span class="badge badge-info"><?php echo e($s->total_bookings); ?></span></td>
          <td><span class="badge <?php echo e($s->status==='active'?'badge-success':'badge-pending'); ?>"><?php echo e(ucfirst($s->status)); ?></span></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="5" class="text-center py-6 text-gray-400 text-sm">No services</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/providers/show.blade.php ENDPATH**/ ?>