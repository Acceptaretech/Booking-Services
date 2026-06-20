@extends('layouts.public.app')
@section('title','Register as Provider')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="w-full max-w-md sm:max-w-xl lg:max-w-2xl bg-gray-800 rounded-2xl p-5 sm:p-8 shadow-2xl">

        <div class="text-center mb-6">
            <div class="w-14 h-14 sm:w-16 sm:h-16 bg-primary-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-tools text-white text-xl sm:text-2xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-white">Get started</h1>
            <p class="text-gray-400 text-xs sm:text-sm mt-1">Register as Provider or Technician</p>
        </div>

        @if($errors->any())
            <div class="bg-red-900/30 border border-red-500 text-red-300 px-4 py-3 rounded-xl mb-4 text-xs sm:text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('provider.register') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="sm:col-span-2">
                    <label class="block text-primary-400 text-sm mb-1.5">Username *</label>
                    <input name="username" value="{{ old('username') }}" required placeholder="Enter Username"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">First Name *</label>
                    <input name="first_name" value="{{ old('first_name') }}" required placeholder="Enter First Name"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Last Name *</label>
                    <input name="last_name" value="{{ old('last_name') }}" required placeholder="Enter Last Name"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-primary-400 text-sm mb-1.5">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter Email"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-primary-400 text-sm mb-1.5">Contact Number *</label>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <span class="bg-gray-700 border border-gray-600 text-white rounded-xl px-3 py-3 text-sm flex items-center justify-center gap-1">
                            🇮🇳 +91
                        </span>
                        <input name="phone" value="{{ old('phone') }}" required placeholder="Contact Number"
                               class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                    </div>
                </div>

                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Password *</label>
                    <input type="password" name="password" required placeholder="Enter Password"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="Confirm Password"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>

                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">User Type *</label>
                    <select name="user_type" id="user_type" required
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                        <option value="provider" {{ old('user_type') === 'provider' ? 'selected' : '' }}>Provider</option>
                        <option value="handyman" {{ old('user_type') === 'handyman' ? 'selected' : '' }}>Technician</option>
                    </select>
                </div>

                <div>
                    <label class="block text-primary-400 text-sm mb-1.5">Select Zone *</label>
                    <select name="zone_id" id="zone_id" required
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                        <option value="">Select Zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2 hidden" id="providerBox">
                    <label class="block text-primary-400 text-sm mb-1.5">Select Provider *</label>
                    <select name="provider_id" id="provider_id"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                        <option value="">Select Provider</option>
                    </select>
                </div>
                <div class="sm:col-span-2 hidden" id="categoryBox">
                    <label class="block text-primary-400 text-sm mb-1.5">Select Category *</label>
                    <select name="category_id" id="category_id"
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                        <option value="">Select Category</option>
                
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-primary-400 text-sm mb-1.5">Designation</label>
                    <input name="designation" value="{{ old('designation') }}" placeholder="e.g. Manager"
                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl px-4 py-3 text-sm outline-none focus:border-primary-500">
                </div>
            </div>

            <div class="mt-6 mb-6">
                <h3 class="text-base sm:text-lg font-semibold text-white mb-4 border-b border-gray-700 pb-2">
                    Document Uploads
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Aadhar Card *</label>
                        <input type="file" name="aadhar_card" required
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Pan Card *</label>
                        <input type="file" name="pan_card" required
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Passport</label>
                        <input type="file" name="passport"
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2 text-xs sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-white text-sm font-medium mb-2">Driving Licence *</label>
                        <input type="file" name="driving_licence" required
                               class="w-full bg-gray-700 border border-gray-600 text-white rounded-xl p-2 text-xs sm:text-sm">
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-xl font-semibold transition-colors">
                Create Account
            </button>

            <p class="text-center text-gray-400 text-sm mt-4">
                Already Have Account?
                <a href="{{ route('login') }}" class="text-primary-400 font-semibold hover:underline">Sign In</a>
            </p>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const userType = document.getElementById('user_type');
const zoneSelect = document.getElementById('zone_id');
const providerBox = document.getElementById('providerBox');
const providerSelect = document.getElementById('provider_id');
const categoryBox = document.getElementById('categoryBox');
const categorySelect = document.getElementById('category_id');

function toggleTechnicianFields() {
    if (userType.value === 'handyman') {
        providerBox.classList.remove('hidden');
        categoryBox.classList.remove('hidden');

        providerSelect.setAttribute('required', 'required');
        categorySelect.setAttribute('required', 'required');

        loadProviders();
    } else {
        providerBox.classList.add('hidden');
        categoryBox.classList.add('hidden');

        providerSelect.removeAttribute('required');
        categorySelect.removeAttribute('required');

        providerSelect.innerHTML = '<option value="">Select Provider</option>';
        categorySelect.value = '';
    }
}

function loadProviders() {
    const zoneId = zoneSelect.value;

    if (!zoneId || userType.value !== 'handyman') {
        providerSelect.innerHTML = '<option value="">Select Provider</option>';
        return;
    }

    providerSelect.innerHTML = '<option value="">Loading...</option>';

    fetch(`/providers-by-zone/${zoneId}`)
        .then(response => response.json())
        .then(data => {
            providerSelect.innerHTML = '<option value="">Select Provider</option>';

            if (data.length === 0) {
                providerSelect.innerHTML = '<option value="">No provider found</option>';
                return;
            }

            data.forEach(provider => {
                providerSelect.innerHTML += `
                    <option value="${provider.id}">
                        ${provider.first_name} ${provider.last_name} - ${provider.email}
                    </option>
                `;
            });
        })
        .catch(() => {
            providerSelect.innerHTML = '<option value="">Unable to load providers</option>';
        });
}

userType.addEventListener('change', toggleTechnicianFields);
zoneSelect.addEventListener('change', loadProviders);

toggleTechnicianFields();
</script>
@endpush