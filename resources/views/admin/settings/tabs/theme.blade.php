<form method="POST"
      action="{{ route('admin.settings.update') }}"
      enctype="multipart/form-data"
      class="bg-white rounded-lg shadow-sm p-8">

    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- Logo --}}
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Logo
            </label>

            <div class="flex items-center gap-6">

                <div class="w-28 h-28 border rounded flex items-center justify-center bg-gray-50">

                    @if($getConfig('logo'))
                        <img src="{{ asset('storage/'.$getConfig('logo')) }}"
                             class="max-h-24 max-w-24 object-contain">
                    @endif

                </div>

                <input
                    type="file"
                    name="logo"
                    class="block w-full text-sm border rounded-md">
            </div>
        </div>

        {{-- Footer Logo 
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Footer Logo
            </label>

            <div class="flex items-center gap-6">

                <div class="w-28 h-28 border rounded flex items-center justify-center bg-gray-50">

                    @if($getConfig('footer_logo'))
                        <img src="{{ asset('storage/'.$getConfig('footer_logo')) }}"
                             class="max-h-24 max-w-24 object-contain">
                    @endif

                </div>

                <input
                    type="file"
                    name="footer_logo"
                    class="block w-full text-sm border rounded-md">
            </div>
        </div> --}}

        {{-- Favicon --}}
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Favicon
            </label>

            <div class="flex items-center gap-6">

                <div class="w-20 h-20 border rounded flex items-center justify-center bg-gray-50">

                    @if($getConfig('favicon'))
                        <img src="{{ asset('storage/'.$getConfig('favicon')) }}"
                             class="max-h-16 max-w-16 object-contain">
                    @endif

                </div>

                <input
                    type="file"
                    name="favicon"
                    class="block w-full text-sm border rounded-md">
            </div>
        </div>

        {{-- Loader 
        <div>
            <label class="block text-gray-700 font-medium mb-3">
                Loader
            </label>

            <div class="flex items-center gap-6">

                <div class="w-20 h-20 border rounded flex items-center justify-center bg-gray-50">

                    @if($getConfig('loader'))
                        <img src="{{ asset('storage/'.$getConfig('loader')) }}"
                             class="max-h-16 max-w-16 object-contain">
                    @endif

                </div>

                <input
                    type="file"
                    name="loader"
                    class="block w-full text-sm border rounded-md">
            </div>
        </div>  --}}

    </div>

    {{-- Color Settings
    <div class="mt-12">

        <h3 class="font-semibold text-xl mb-4">
            Color Settings
        </h3>

        <div class="max-w-md">

            <label class="block mb-2 text-sm font-medium">
                Primary Color
            </label>

            <input
                type="color"
                name="primary_color"
                value="{{ $getConfig('primary_color','#5B5FC7') }}"
                class="w-full h-12 border rounded cursor-pointer">

        </div>

    </div>  --}}

    {{-- Preview 
    <div class="mt-6">

        <div
            id="colorPreview"
            class="h-5 rounded"
            style="background:{{ $getConfig('primary_color','#5B5FC7') }}">
        </div>

    </div> --}}

    {{-- Save --}}
    <div class="flex justify-end mt-12">

        <button
            type="submit"
            class="px-8 py-3 rounded-md text-white font-medium"
            style="background:{{ $getConfig('primary_color','#5B5FC7') }}">
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
</script>