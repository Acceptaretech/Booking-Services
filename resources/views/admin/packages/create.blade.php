@extends('layouts.admin.app')

@section('title', 'Create Package')
@section('page_title', 'Create Package')

@section('content')

<form method="POST" action="{{ route('admin.packages.store') }}" enctype="multipart/form-data" class="card p-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div>
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-input">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="form-label">Select Provider *</label>
            <select name="user_id" class="form-select" required>
                <option value="">Select Provider</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}" {{ old('user_id') == $provider->id ? 'selected' : '' }}>
                        {{ $provider->full_name ?? $provider->name ?? $provider->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Package Type *</label>
            <select name="package_type" class="form-select" required>
                <option value="single_category" {{ old('package_type') == 'single_category' ? 'selected' : '' }}>
                    Single Category
                </option>
                <option value="multiple_category" {{ old('package_type') == 'multiple_category' ? 'selected' : '' }}>
                    Multiple Category
                </option>
            </select>
        </div>

        <div>
            <label class="form-label">Select Category *</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Select Sub Category</label>
            <select name="sub_category_id" class="form-select">
                <option value="">Select Sub Category</option>
                @foreach($subCategories as $subCategory)
                    <option value="{{ $subCategory->id }}" {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                        {{ $subCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Select Service *</label>
            <select name="service_id" class="form-select" required>
                <option value="">Select Service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                        @if($service->price)
                            - ${{ number_format((float) $service->price, 2) }}
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Start At</label>
            <input type="date" name="start_at" value="{{ old('start_at') }}" class="form-input">
        </div>

        <div>
            <label class="form-label">End At</label>
            <input type="date" name="end_at" value="{{ old('end_at') }}" class="form-input">
        </div>

        <div>
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Original Price</label>
            <input type="number" step="0.01" name="original_price" value="{{ old('original_price') }}" class="form-input">
        </div>

        <div>
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-input">
        </div>

    </div>

    <div class="flex justify-end gap-2 mt-6">
        <a href="{{ route('admin.packages.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Save</button>
    </div>
</form>

@endsection