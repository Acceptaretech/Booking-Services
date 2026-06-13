

<?php $__env->startSection('title','Addresses'); ?>

<?php $__env->startSection('content'); ?>

<div class="min-h-screen bg-[#eef8ff] py-8">

    <div class="max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            <?php echo $__env->make('customer.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <div>

                <div class="flex items-center justify-between border-b border-gray-300 pb-5 mb-8">
                    <h1 class="text-4xl font-extrabold text-black">
                        Addresses
                    </h1>

                    <button onclick="openAddModal()"
                            class="text-pink-500 text-2xl font-medium hover:text-pink-600">
                        + Add new address
                    </button>
                </div>

                <?php if($errors->any()): ?>
                    <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p><?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <?php $__empty_1 = true; $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                        <div class="bg-white rounded-3xl shadow-sm p-6 relative">

                            <div class="flex items-start gap-4">

                                <form method="POST"
                                      action="<?php echo e(route('customer.addresses.default', $address)); ?>">
                                    <?php echo csrf_field(); ?>

                                    <button type="submit"
                                            class="w-14 h-14 rounded-2xl flex items-center justify-center
                                            <?php echo e($address->is_default ? 'bg-pink-100 text-pink-500' : 'bg-gray-100 text-gray-400'); ?>">
                                        <i class="fas fa-check text-2xl"></i>
                                    </button>
                                </form>

                                <div class="flex-1">
                                    <h2 class="text-2xl font-extrabold text-black">
                                        <?php echo e($address->name ?? auth()->user()->name); ?>

                                    </h2>

                                    <p class="text-gray-500 mt-1">
                                        <?php echo e($address->phone ?? auth()->user()->phone); ?>

                                    </p>

                                    <p class="text-gray-400 mt-7">
                                        Addresses :
                                    </p>

                                    <p class="text-lg text-black mt-3 leading-8">
                                        <?php echo e($address->address); ?>

                                        <?php if($address->city): ?>
                                            <br><?php echo e($address->city); ?>

                                        <?php endif; ?>
                                        <?php if($address->state): ?>
                                            , <?php echo e($address->state); ?>

                                        <?php endif; ?>
                                        <?php if($address->pincode): ?>
                                            - <?php echo e($address->pincode); ?>

                                        <?php endif; ?>
                                    </p>
                                </div>

                            </div>

                            <div class="flex justify-end gap-3 mt-6">

                                <button type="button"
                                        onclick="openEditModal(<?php echo e($address->id); ?>)"
                                        class="px-4 py-2 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100">
                                    Edit
                                </button>

                                <form method="POST"
                                      action="<?php echo e(route('customer.addresses.destroy', $address)); ?>"
                                      onsubmit="return confirm('Delete this address?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>

                                    <button type="submit"
                                            class="px-4 py-2 rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </div>

                        
                        <div id="editModal<?php echo e($address->id); ?>"
                             class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">

                            <div class="bg-white rounded-3xl max-w-xl w-full p-6">

                                <div class="flex justify-between items-center mb-5">
                                    <h2 class="text-2xl font-bold">Edit Address</h2>
                                    <button onclick="closeEditModal(<?php echo e($address->id); ?>)" class="text-2xl">&times;</button>
                                </div>

                                <form method="POST" action="<?php echo e(route('customer.addresses.update', $address)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>

                                    <?php echo $__env->make('customer.addresses.partials.form', ['address' => $address], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                                    <button class="w-full mt-5 bg-pink-500 text-white py-3 rounded-2xl font-semibold">
                                        Update Address
                                    </button>
                                </form>

                            </div>

                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <div class="bg-white rounded-3xl p-10 text-center md:col-span-2">
                            <i class="fas fa-map-marker-alt text-5xl text-gray-300"></i>
                            <h3 class="text-xl font-bold mt-4">No address found</h3>
                            <p class="text-gray-500 mt-2">Add your first address.</p>
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>


<div id="addModal" class="hidden fixed inset-0 bg-black/50 z-50 items-center justify-center p-4">

    <div class="bg-white rounded-3xl max-w-xl w-full p-6">

        <div class="flex justify-between items-center mb-5">
            <h2 class="text-2xl font-bold">Add New Address</h2>
            <button onclick="closeAddModal()" class="text-2xl">&times;</button>
        </div>

        <form method="POST" action="<?php echo e(route('customer.addresses.store')); ?>">
            <?php echo csrf_field(); ?>

            <?php echo $__env->make('customer.addresses.partials.form', ['address' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <button class="w-full mt-5 bg-pink-500 text-white py-3 rounded-2xl font-semibold">
                Save Address
            </button>
        </form>

    </div>

</div>

<script>
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.getElementById('addModal').classList.add('flex');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addModal').classList.remove('flex');
}

function openEditModal(id) {
    document.getElementById('editModal' + id).classList.remove('hidden');
    document.getElementById('editModal' + id).classList.add('flex');
}

function closeEditModal(id) {
    document.getElementById('editModal' + id).classList.add('hidden');
    document.getElementById('editModal' + id).classList.remove('flex');
}
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/customer/addresses/index.blade.php ENDPATH**/ ?>