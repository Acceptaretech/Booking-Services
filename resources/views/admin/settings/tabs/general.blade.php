<form
    method="POST"
    action="{{ route('admin.settings.update') }}"
    enctype="multipart/form-data"
    class="bg-white rounded-xl shadow-sm p-8">

    @csrf

    <h2 class="text-xl font-semibold mb-6">
        General Settings
    </h2>

    <div class="grid grid-cols-2 gap-6">

        <div>
            <label class="block mb-2">
                Company Name
            </label>

            <input
                type="text"
                name="company_name"
                value="{{ $getConfig('company_name') }}"
                class="w-full border rounded-lg px-4 py-3">
        </div>

        <div>
            <label class="block mb-2">
                Contact Number
            </label>

            <input
                type="text"
                name="contact_number"
                value="{{ $getConfig('contact_number') }}"
                class="w-full border rounded-lg px-4 py-3">
        </div>

        <div>
            <label class="block mb-2">
                Email
            </label>

            <input
                type="email"
                name="contact_email"
                value="{{ $getConfig('contact_email') }}"
                class="w-full border rounded-lg px-4 py-3">
        </div>
         <!-- Address -->
    <div class="lg:col-span-2">
        <label class="block mb-2">Address</label>

        <textarea
            name="company_address"
            rows="4"
            class="w-full border rounded-lg px-4 py-3">{{ $getConfig('company_address') }}</textarea>
    </div>

        <div>
            <label class="block mb-2">
                Website
            </label>

            <input
                type="text"
                name="google_play_url"
                value="{{ $getConfig('google_play_url') }}"
                class="w-full border rounded-lg px-4 py-3">
        </div>

    </div>

    <div class="mt-6">
        <button
            type="submit"
            class="bg-indigo-600 text-white px-6 py-3 rounded-lg">

            Save Settings

        </button>
    </div>

</form>