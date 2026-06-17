@extends('layouts.provider.app')

@section('title','Create Service')
@section('page_title','Create Service')

@section('content')

<form action="{{ route('provider.services.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Name --}}
            <div>
                <label class="form-label">Name <span class="text-red-500">*</span></label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-input"
                       placeholder="Name"
                       required>
            </div>

            {{-- Description --}}
            <div class="md:col-span-3">
                <label class="form-label">Description</label>
                <textarea name="description"
                          rows="4"
                          class="form-input"
                          placeholder="Description">{{ old('description') }}</textarea>
            </div>

            {{-- Category --}}
            <div>
                <label class="form-label">
                    Select Category <span class="text-red-500">*</span>
                </label>

                <select name="category_id"
                        id="category_id"
                        class="form-select"
                        required>

                    <option value="">Select Category</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Sub Category --}}
            <div>
                <label class="form-label">
                    Select Sub Category
                </label>

                <select name="subcategory_id"
                        id="subcategory_id"
                        class="form-select">

                    <option value="">Select Sub Category</option>

                </select>
            </div>

            {{-- Shop --}}
            <div>
                <label class="form-label">Select Shop</label>

                <select name="shop_id" class="form-select">
                    <option value="">Select Shop</option>

                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}">
                            {{ $shop->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Price Type --}}
            <div>
                <label class="form-label">
                    Price Type <span class="text-red-500">*</span>
                </label>

                <select name="price_type" class="form-select">
                    <option value="fixed">Fixed</option>
                    <option value="hourly">Hourly</option>
                </select>
            </div>

            {{-- Price --}}
            <div>
                <label class="form-label">
                    Price <span class="text-red-500">*</span>
                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       class="form-input"
                       placeholder="Price"
                       required>
            </div>

            {{-- Discount --}}
            <div>
                <label class="form-label">Discount %</label>

                <input type="number"
                       step="0.01"
                       name="discount"
                       class="form-input"
                       placeholder="Discount">
            </div>

            {{-- Duration --}}
            <div>
                <label class="form-label">Duration (Hours)</label>

                <input type="number"
                       name="duration"
                       class="form-input"
                       placeholder="Duration">
            </div>

            {{-- Status --}}
            <div>
                <label class="form-label">
                    Status <span class="text-red-500">*</span>
                </label>

                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            {{-- Visit Type --}}
            <div>
                <label class="form-label">
                    Visit Type <span class="text-red-500">*</span>
                </label>

                <select name="type" class="form-select">
                    <option value="fixed">On Site</option>
                    <option value="online">Online</option>
                    <option value="both">Both</option>
                </select>
            </div>

            {{-- Image --}}
            <div>
                <label class="form-label">
                    Image <span class="text-red-500">*</span>
                </label>

                <input type="file"
                       name="image"
                       class="form-input"
                       required>
            </div>

        </div>

        {{-- Toggle Options --}}
        <div class="grid md:grid-cols-4 gap-6 mt-8">

            <label class="flex items-center gap-3">
                <input type="checkbox" name="seo">
                <span>Set SEO</span>
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" name="time_slot" checked>
                <span>Time Slot</span>
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" name="featured">
                <span>Set as Featured</span>
            </label>

            <label class="flex items-center gap-3">
                <input type="checkbox" name="advance_payment">
                <span>Advanced Payment For Services</span>
            </label>

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

document.getElementById('category_id').addEventListener('change', function () {

    let categoryId = this.value;
    let subCategorySelect = document.getElementById('subcategory_id');

    subCategorySelect.innerHTML =
        '<option value="">Loading...</option>';

    if(categoryId === '')
    {
        subCategorySelect.innerHTML =
            '<option value="">Select Sub Category</option>';

        return;
    }

    fetch('/provider/services/get-subcategories/' + categoryId)

        .then(response => response.json())

        .then(data => {

            subCategorySelect.innerHTML =
                '<option value="">Select Sub Category</option>';

            data.forEach(function(item){

                subCategorySelect.innerHTML +=
                    `<option value="${item.id}">
                        ${item.name}
                    </option>`;

            });

        })

        .catch(function(){

            subCategorySelect.innerHTML =
                '<option value="">No Sub Category Found</option>';

        });

});
</script>
@endpush