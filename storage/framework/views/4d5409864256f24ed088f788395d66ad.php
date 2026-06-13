<div class="space-y-6">

    <div>
        <label class="block mb-2 font-medium">
            Name <span class="text-red-500">*</span>
        </label>

        <input type="text"
               name="name"
               value="<?php echo e(old('name', $document->name ?? '')); ?>"
               placeholder="Name"
               class="form-input w-full">

        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Document Type <span class="text-red-500">*</span>
        </label>

        <select name="document_type" class="form-input w-full">
            <option value="">Select Type</option>
            <option value="provider" <?php echo e(old('document_type', $document->document_type ?? '') == 'provider' ? 'selected' : ''); ?>>
                Provider Document
            </option>
            <option value="shop" <?php echo e(old('document_type', $document->document_type ?? '') == 'shop' ? 'selected' : ''); ?>>
                Shop Document
            </option>
        </select>

        <?php $__errorArgs = ['document_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Status <span class="text-red-500">*</span>
        </label>

        <select name="status" class="form-input w-full">
            <option value="active" <?php echo e(old('status', $document->status ?? 'active') == 'active' ? 'selected' : ''); ?>>
                Active
            </option>
            <option value="inactive" <?php echo e(old('status', $document->status ?? '') == 'inactive' ? 'selected' : ''); ?>>
                Inactive
            </option>
        </select>

        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <label class="inline-flex items-center gap-2">
        <input type="checkbox"
               name="is_required"
               value="1"
               class="rounded"
               <?php echo e(old('is_required', $document->is_required ?? false) ? 'checked' : ''); ?>>

        <span>Required</span>
    </label>
</div><?php /**PATH D:\Downloads\handyman-platform (1) (1)\handyman\resources\views/admin/documents/form.blade.php ENDPATH**/ ?>