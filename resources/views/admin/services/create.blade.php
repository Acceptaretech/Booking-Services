@extends('layouts.admin.app')

@section('title','Add Service')
@section('page_title','Add New Service')

@section('content')
<div class="card flex items-center justify-between p-5 mb-8">
    <h2 class="text-lg font-bold">Add New Service</h2>

    <a href="{{ route('admin.services.index') }}" class="btn-primary">
        <i class="fas fa-angle-double-left mr-1"></i> Back
    </a>
</div>

<div class="card p-6">
    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="mb-5">
            <label class="form-label">Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-input max-w-md" placeholder="Name" required>
        </div>

        <div class="mb-5">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" maxlength="250" class="form-input" placeholder="Description">{{ old('description') }}</textarea>
            <p class="text-xs text-gray-400 mt-1">0/250</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
            <div>
                <label class="form-label">Select Category <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Select Sub Category</label>
                <select name="subcategory_id" id="subcategory_id" class="form-select">
                    <option value="">Select Sub Category</option>
                </select>
            </div>

            <div>
                <label class="form-label">Price type <span class="text-red-500">*</span></label>
                <select name="price_type" class="form-select" required>
                    <option value="fixed">Fixed</option>
                    <option value="hourly">Hourly</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
            <div>
                <label class="form-label">Select Provider <span class="text-red-500">*</span></label>
                <select name="user_id" id="provider_id" class="form-select" required>
                    <option value="">Select Provider</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">
                            {{ $provider->first_name }} {{ $provider->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Select Zone <span class="text-red-500">*</span></label>
                <select name="zone_id" id="zone_id" class="form-select" required>
                    <option value="">Select Zone</option>
                    @foreach($zones as $zone)
                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">duration (hours)</label>
                <input type="number" name="duration" class="form-input" placeholder="duration" min="1">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-5">
            <div>
                <label class="form-label">Price <span class="text-red-500">*</span></label>
                <input type="number" name="price" class="form-input" placeholder="Price" min="0" step="0.01" required>
            </div>

            <div>
                <label class="form-label">Discount %</label>
                <input type="number" name="discount" class="form-input" placeholder="Discount" min="0" max="100">
            </div>

            <div>
                <label class="form-label">Image <span class="text-red-500">*</span></label>
                <input type="file" name="image" class="form-input" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div>
                <label class="form-label">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div>
                <label class="form-label">Visit Type</label>
                <select name="type" class="form-select">
                    <option value="fixed">On Site</option>
                    <option value="online">Online</option>
                    <option value="both">Both</option>
                </select>
            </div>
        </div>

      {{--  <div class="flex flex-wrap gap-12 mb-8">
            <label class="flex items-center gap-3">
                <input type="checkbox" name="set_seo" value="1"> Set SEO
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" name="time_slot" value="1"> Time Slot
            </label>

            

            <label class="flex items-center gap-3">
                <input type="checkbox" name="advance_payment" value="1"> Advanced Payment for Services
            </label>
        </div> --}}
        <label class="flex items-center gap-3">
          <input type="checkbox" name="is_featured" value="1"> Set as featured
      </label>
        <div class="flex justify-end">
            <button type="submit" class="btn-primary px-8 py-3">Save</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const categorySelect = document.getElementById('category_id');
    const subCategorySelect = document.getElementById('subcategory_id');
    const providerSelect = document.getElementById('provider_id');
    const zoneSelect = document.getElementById('zone_id');

    categorySelect.addEventListener('change', function () {
        let categoryId = this.value;

        subCategorySelect.innerHTML = '<option value="">Loading...</option>';

        if (!categoryId) {
            subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';
            return;
        }

        fetch(`/admin/services/get-subcategories/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

                if (data.length === 0) {
                    subCategorySelect.innerHTML = '<option value="">No Sub Category Found</option>';
                    return;
                }

                data.forEach(item => {
                    subCategorySelect.innerHTML += `<option value="${item.id}">${item.name}</option>`;
                });
            })
            .catch(() => {
                subCategorySelect.innerHTML = '<option value="">Error Loading</option>';
            });
    });

    providerSelect.addEventListener('change', function () {
        let providerId = this.value;

        zoneSelect.innerHTML = '<option value="">Loading...</option>';

        if (!providerId) {
            zoneSelect.innerHTML = '<option value="">Select Zone</option>';
            return;
        }

        fetch(`/admin/services/get-zones-by-provider/${providerId}`)
            .then(response => response.json())
            .then(data => {
                zoneSelect.innerHTML = '<option value="">Select Zone</option>';

                if (data.length === 0) {
                    zoneSelect.innerHTML = '<option value="">No Zone Found</option>';
                    return;
                }

                data.forEach(item => {
                    zoneSelect.innerHTML += `<option value="${item.id}" selected>${item.name}</option>`;
                });
            })
            .catch(() => {
                zoneSelect.innerHTML = '<option value="">Error Loading</option>';
            });
    });

});
</script>
@endpush