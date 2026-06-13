

<?php $__env->startSection('title','My Wallet'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-[#eef8ff] py-6 md:py-10">
    <div class="max-w-[1400px] mx-auto px-4 flex flex-col lg:flex-row gap-6 lg:gap-8">

        <?php echo $__env->make('customer.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="flex-1 w-full">

            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-gray-200 pb-5 mb-6 lg:mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-black">
                    My Wallet :
                    <span class="text-green-500">₹<?php echo e(number_format($walletBalance, 0)); ?></span>
                </h1>

                <button type="button"
                        onclick="document.getElementById('addBalanceModal').classList.remove('hidden')"
                        class="text-pink-500 text-xl sm:text-2xl lg:text-3xl font-medium text-left sm:text-right">
                    + Add Balance
                </button>
            </div>

            <div class="bg-white rounded-[22px] lg:rounded-[26px] shadow-sm p-4 sm:p-6 lg:p-8">

                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5 mb-7">
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-black">
                        Transactions
                    </h2>

                    <form method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3">
                        <label class="text-gray-500">Date</label>

                        <input type="date"
                               name="date"
                               value="<?php echo e(request('date')); ?>"
                               class="w-full sm:w-auto border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500">

                        <button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl">
                            Filter
                        </button>
                    </form>
                </div>

                <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

                    <div class="flex items-center gap-2">
                        <span>Show</span>

                        <select name="entries"
                                onchange="this.form.submit()"
                                class="border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500">
                            <option value="10" <?php echo e(request('entries', 10) == 10 ? 'selected' : ''); ?>>10</option>
                            <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25</option>
                            <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100</option>
                        </select>

                        <span>entries</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="whitespace-nowrap">Search :</label>

                        <input type="text"
                               name="search"
                               value="<?php echo e(request('search')); ?>"
                               placeholder="Search"
                               class="w-full md:w-[260px] border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-blue-500">
                    </div>

                    <?php if(request('search') || request('date')): ?>
                        <a href="<?php echo e(route('customer.wallet')); ?>"
                           class="text-sm text-red-500 font-medium">
                            Clear Filter
                        </a>
                    <?php endif; ?>
                </form>

                <div class="overflow-x-auto rounded-xl">
                    <table class="w-full min-w-[850px]">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-left p-4 lg:p-5 font-bold">Amount</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Type</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Description</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Reference ID</th>
                                <th class="text-left p-4 lg:p-5 font-bold">Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="border-b border-gray-100 hover:bg-gray-50">
                                    <td class="p-4 lg:p-5 font-semibold">
                                        ₹<?php echo e(number_format($transaction->amount, 2)); ?>

                                    </td>

                                    <td class="p-4 lg:p-5">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium
                                            <?php echo e($transaction->type == 'credit'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-red-100 text-red-700'); ?>">
                                            <?php echo e(ucfirst($transaction->type)); ?>

                                        </span>
                                    </td>

                                    <td class="p-4 lg:p-5">
                                        <?php echo e($transaction->description ?? '-'); ?>

                                    </td>

                                    <td class="p-4 lg:p-5">
                                        <?php echo e($transaction->reference_id ?? '-'); ?>

                                    </td>

                                    <td class="p-4 lg:p-5 whitespace-nowrap">
                                        <?php echo e($transaction->created_at->format('d-m-Y h:i A')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-16 text-gray-400">
                                        No Records Found
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    <?php echo e($transactions->links()); ?>

                </div>

            </div>
        </div>
    </div>
</div>

<div id="addBalanceModal"
     class="hidden fixed inset-0 bg-black/40 px-4 flex items-center justify-center z-50">

    <div class="bg-white rounded-2xl p-5 sm:p-8 w-full max-w-[420px] shadow-xl">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-2xl font-bold">Add Balance</h2>

            <button type="button"
                    onclick="document.getElementById('addBalanceModal').classList.add('hidden')"
                    class="w-9 h-9 rounded-full bg-gray-100 hover:bg-gray-200">
                ✕
            </button>
        </div>

        <form method="POST" action="<?php echo e(route('customer.wallet.add-balance')); ?>">
            <?php echo csrf_field(); ?>

            <input type="number"
                   name="amount"
                   min="1"
                   placeholder="Enter Amount"
                   class="w-full border border-gray-200 rounded-xl px-4 py-3 mb-2 outline-none focus:border-blue-500"
                   required>

            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-sm mb-3"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <div class="flex flex-col sm:flex-row gap-3 mt-5">
                <button type="button"
                        onclick="document.getElementById('addBalanceModal').classList.add('hidden')"
                        class="w-full bg-gray-200 hover:bg-gray-300 py-3 rounded-xl">
                    Cancel
                </button>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl">
                    Add
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/customer/wallet/index.blade.php ENDPATH**/ ?>