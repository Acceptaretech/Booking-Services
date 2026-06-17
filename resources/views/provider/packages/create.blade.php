@extends('layouts.provider.app')

@section('title','Create Package')
@section('page_title','Create Package')

@section('content')

<form action="{{ route('provider.packages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card p-6">

     

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Name" required>
            </div>

            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-input" placeholder="Description">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="form-label">Package Type</label>
                <select name="package_type" id="package_type" class="form-select">
                    <option value="single_category">Single Category</option>
                    <option value="multi_category" selected>Multiple Category</option>
                </select>
            </div>

            {{-- Custom Multi Service Select --}}
            <div>
                <label class="form-label">Select Service <span class="text-red-500">*</span></label>

                <div class="border rounded-md bg-white">
                    <div id="selectedServices" class="min-h-[58px] p-3 flex flex-wrap gap-2"></div>

                    <div class="border-t">
                        <input type="text"
                               id="serviceSearch"
                               class="w-full px-3 py-2 outline-none"
                               placeholder="Searching...">
                    </div>

                    <div id="serviceOptions" class="max-h-52 overflow-y-auto">
                        @foreach($services ?? [] as $service)
                            <div class="service-option px-3 py-2 cursor-pointer hover:bg-primary-600 hover:text-white"
                                 data-id="{{ $service->id }}"
                                 data-name="{{ $service->name }}">
                                {{ $service->name }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="hiddenServices"></div>
            </div>

            <div>
                <label class="form-label">Start at</label>
                <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" class="form-input">
            </div>

            <div>
                <label class="form-label">End at</label>
                <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" class="form-input">
            </div>

            <div>
                <label class="form-label">Price <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-input" placeholder="Price" required>
            </div>

            <div>
                <label class="form-label">Original Price</label>
                <input type="number" step="0.01" name="original_price" value="{{ old('original_price') }}" class="form-input" placeholder="Original Price">
            </div>

            <div>
                <label class="form-label">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div>
                <label class="form-label">Image <span class="text-red-500">*</span></label>
                <input type="file" name="image" class="form-input">
            </div>

        </div>

        <div class="flex justify-end mt-8">
            <button type="submit" class="btn-primary px-8">
                Save
            </button>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const packageType = document.getElementById('package_type');
    const selectedBox = document.getElementById('selectedServices');
    const hiddenBox = document.getElementById('hiddenServices');
    const search = document.getElementById('serviceSearch');
    const serviceOptions = document.getElementById('serviceOptions');

    let selected = {};

    // Hide dropdown initially
    serviceOptions.classList.add('hidden');

    function renderSelected()
    {
        selectedBox.innerHTML = '';
        hiddenBox.innerHTML = '';

        Object.keys(selected).forEach(id => {

            selectedBox.innerHTML += `
                <span class="bg-primary-600 text-white px-3 py-1 rounded-md text-sm flex items-center gap-2">
                    <button type="button"
                            onclick="removeService('${id}')"
                            class="font-bold">
                        ×
                    </button>
                    ${selected[id]}
                </span>
            `;

            hiddenBox.innerHTML += `
                <input type="hidden"
                       name="service_ids[]"
                       value="${id}">
            `;
        });
    }

    window.removeService = function(id)
    {
        delete selected[id];
        renderSelected();

        if(packageType.value === 'single_category')
        {
            search.value = '';
            serviceOptions.classList.remove('hidden');
        }
    }

    document.querySelectorAll('.service-option').forEach(option => {

        option.addEventListener('click', function () {

            let id = this.dataset.id;
            let name = this.dataset.name;

            if(packageType.value === 'single_category')
            {
                selected = {};
                selected[id] = name;

                renderSelected();

                search.value = name;

                // Hide after selecting one
                serviceOptions.classList.add('hidden');
            }
            else
            {
                selected[id] = name;
                renderSelected();
            }

        });

    });

    search.addEventListener('focus', function () {
        serviceOptions.classList.remove('hidden');
    });

    search.addEventListener('keyup', function () {

        let value = this.value.toLowerCase();

        serviceOptions.classList.remove('hidden');

        document.querySelectorAll('.service-option').forEach(option => {

            option.style.display =
                option.dataset.name.toLowerCase().includes(value)
                ? 'block'
                : 'none';

        });

    });

    packageType.addEventListener('change', function(){

        selected = {};
        renderSelected();

        search.value = '';

        serviceOptions.classList.add('hidden');

        if(this.value === 'single_category')
        {
            search.placeholder = 'Select One Service';
        }
        else
        {
            search.placeholder = 'Select Multiple Services';
        }

    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e){

        if(
            !search.contains(e.target) &&
            !serviceOptions.contains(e.target)
        ){
            serviceOptions.classList.add('hidden');
        }

    });

});
</script>
@endpush