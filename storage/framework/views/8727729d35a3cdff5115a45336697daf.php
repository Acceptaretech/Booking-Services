<form method="POST"
      action="<?php echo e(route('admin.settings.update')); ?>"
      enctype="multipart/form-data"
      class="bg-white rounded-lg shadow-sm p-8">

    <?php echo csrf_field(); ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Logo
            </label>

            <div class="flex items-center gap-6">

                <div class="w-28 h-28 border rounded flex items-center justify-center bg-gray-50">

                    <?php if($getConfig('logo')): ?>
                        <img src="<?php echo e(asset('storage/'.$getConfig('logo'))); ?>"
                             class="max-h-24 max-w-24 object-contain">
                    <?php endif; ?>

                </div>

                <input
                    type="file"
                    name="logo"
                    class="block w-full text-sm border rounded-md">
            </div>
        </div>

        

        
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Favicon
            </label>

            <div class="flex items-center gap-6">

                <div class="w-20 h-20 border rounded flex items-center justify-center bg-gray-50">

                    <?php if($getConfig('favicon')): ?>
                        <img src="<?php echo e(asset('storage/'.$getConfig('favicon'))); ?>"
                             class="max-h-16 max-w-16 object-contain">
                    <?php endif; ?>

                </div>

                <input
                    type="file"
                    name="favicon"
                    class="block w-full text-sm border rounded-md">
            </div>
        </div>

        

    </div>

    

    

    
    <div class="flex justify-end mt-12">

        <button
            type="submit"
            class="px-8 py-3 rounded-md text-white font-medium"
            style="background:<?php echo e($getConfig('primary_color','#5B5FC7')); ?>">
            Save
        </button>

    </div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const picker = document.querySelector('input[name="primary_color"]');
    const preview = document.getElementById('colorPreview');

    if (picker) {
        picker.addEventListener('input', function () {
            preview.style.background = this.value;
        });
    }

});
</script><?php /**PATH C:\Users\sales\Desktop\handyman\handyman\resources\views/admin/settings/tabs/theme.blade.php ENDPATH**/ ?>