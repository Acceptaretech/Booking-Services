@extends('layouts.provider.app')

@section('title','Edit Package')
@section('page_title','Edit Package')

@section('content')

<form action="{{ route('provider.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $package->name) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-input">{{ old('description', $package->description) }}</textarea>
            </div>

            <div>
                <label class="form-label">Package Type</label>
                <select name="package_type" id="package_type" class="form-select">
                    <option value="single_category" {{ old('package_type', $package->package_type) == 'single_category' ? 'selected' : '' }}>Single Category</option>
                    <option value="multi_category" {{ old('package_type', $package->package_type) == 'multi_category' ? 'selected' : '' }}>Multiple Category</option>
                </select>
            </div>

            <div>
                <label class="form-label">Select Service <span class="text-red-500">*</span></label>

                @php
                    $selectedServices = old('service_ids', $package->service_ids ?? ($package->service_id ? [$package->service_id] : []));
                    if (is_string($selectedServices)) {
                        $selectedServices = json_decode($selectedServices, true) ?? [];
                    }
                @endphp

                <div class="border rounded-md bg-white">
                    <div class="p-3">
                        <div id="selectedTitle"
                             class="text-sm font-semibold text-gray-600 mb-2 {{ count($selectedServices) ? '' : 'hidden' }}">
                            Selected Services
                        </div>

                        <div id="selectedServices" class="flex flex-wrap gap-2"></div>
                    </div>

                    <div class="border-t">
                        <input type="text"
                               id="serviceSearch"
                               class="w-full px-3 py-2 outline-none"
                               placeholder="Select Service">
                    </div>

                    <div id="serviceOptions" class="max-h-52 overflow-y-auto border-t hidden">
                        @foreach($services ?? [] as $service)
                            <div class="service-option px-3 py-2 cursor-pointer hover:bg-primary-600 hover:text-white"
                                 data-id="{{ $service->id }}"
                                 data-name="{{ $service->name }}">
                                {{ $service->name }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="hiddenServices">
                    @foreach($selectedServices as $serviceId)
                        <input type="hidden" name="service_ids[]" value="{{ $serviceId }}">
                    @endforeach
                </div>
            </div>

            <div>
                <label class="form-label">Start at</label>
                <input type="datetime-local"
                       name="start_at"
                       value="{{ old('start_at', $package->start_at ? \Carbon\Carbon::parse($package->start_at)->format('Y-m-d\TH:i') : '') }}"
                       class="form-input">
            </div>

            <div>
                <label class="form-label">End at</label>
                <input type="datetime-local"
                       name="end_at"
                       value="{{ old('end_at', $package->end_at ? \Carbon\Carbon::parse($package->end_at)->format('Y-m-d\TH:i') : '') }}"
                       class="form-input">
            </div>

            <div>
                <label class="form-label">Price <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $package->price) }}" class="form-input" required>
            </div>

            <div>
                <label class="form-label">Original Price</label>
                <input type="number" step="0.01" name="original_price" value="{{ old('original_price', $package->original_price) }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status', $package->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $package->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-input">

                @if($package->image)
                    <img src="{{ asset('storage/' . $package->image) }}"
                         class="w-20 h-20 rounded-xl object-cover mt-3"
                         alt="Package">
                @endif
            </div>

        </div>

        <div class="flex justify-end mt-8 gap-3">
            <a href="{{ route('provider.packages.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary px-8">Update</button>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const packageType = document.getElementById('package_type');
    const selectedBox = document.getElementById('selectedServices');
    const selectedTitle = document.getElementById('selectedTitle');
    const hiddenBox = document.getElementById('hiddenServices');
    const search = document.getElementById('serviceSearch');
    const serviceOptions = document.getElementById('serviceOptions');

    let selectedObject = {};

    document.querySelectorAll('#hiddenServices input').forEach(input => {
        const id = input.value;
        const option = document.querySelector('.service-option[data-id="' + id + '"]');

        if (option) {
            selectedObject[id] = option.dataset.name;
        }
    });

    function renderSelected() {
        selectedBox.innerHTML = '';
        hiddenBox.innerHTML = '';

        if (Object.keys(selectedObject).length > 0) {
            selectedTitle.classList.remove('hidden');
        } else {
            selectedTitle.classList.add('hidden');
        }

        Object.keys(selectedObject).forEach(id => {
            selectedBox.innerHTML += `
                <span class="bg-primary-600 text-white px-3 py-1 rounded-md text-sm flex items-center gap-2">
                    <button type="button" onclick="removeService('${id}')" class="font-bold">×</button>
                    ${selectedObject[id]}
                </span>
            `;

            hiddenBox.innerHTML += `
                <input type="hidden" name="service_ids[]" value="${id}">
            `;
        });
    }

    window.removeService = function(id) {
        delete selectedObject[id];
        renderSelected();
        search.value = '';
        serviceOptions.classList.remove('hidden');
    }

    document.querySelectorAll('.service-option').forEach(option => {
        option.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;

            if (packageType.value === 'single_category') {
                selectedObject = {};
                selectedObject[id] = name;
                search.value = name;
                serviceOptions.classList.add('hidden');
            } else {
                selectedObject[id] = name;
            }

            renderSelected();
        });
    });

    search.addEventListener('focus', function () {
        serviceOptions.classList.remove('hidden');
    });

    search.addEventListener('keyup', function () {
        const value = this.value.toLowerCase();

        serviceOptions.classList.remove('hidden');

        document.querySelectorAll('.service-option').forEach(option => {
            option.style.display = option.dataset.name.toLowerCase().includes(value)
                ? 'block'
                : 'none';
        });
    });

    packageType.addEventListener('change', function() {
        selectedObject = {};
        renderSelected();
        search.value = '';
        serviceOptions.classList.add('hidden');

        search.placeholder = this.value === 'single_category'
            ? 'Select One Service'
            : 'Select Multiple Services';
    });

    document.addEventListener('click', function(e) {
        if (!search.contains(e.target) && !serviceOptions.contains(e.target)) {
            serviceOptions.classList.add('hidden');
        }
    });

    renderSelected();
});
</script>
@endpush