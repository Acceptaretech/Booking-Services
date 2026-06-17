@extends('layouts.provider.app')

@section('title','Edit Addon')
@section('page_title','Edit Addon')

@section('content')

<form action="{{ route('provider.addons.update', $addon->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">
                    Name <span class="text-red-500">*</span>
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $addon->name) }}"
                       class="form-input"
                       placeholder="Name"
                       required>
            </div>

            <div>
                <label class="form-label">
                    Select Service <span class="text-red-500">*</span>
                </label>

                <select name="service_id" class="form-select" required>
                    <option value="">Select Service</option>

                    @foreach($services as $service)
                        <option value="{{ $service->id }}"
                            {{ old('service_id', $addon->service_id) == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">
                    Price <span class="text-red-500">*</span>
                </label>

                <input type="number"
                       step="0.01"
                       name="price"
                       value="{{ old('price', $addon->price) }}"
                       class="form-input"
                       placeholder="Price"
                       required>
            </div>

            <div>
                <label class="form-label">
                    Status <span class="text-red-500">*</span>
                </label>

                <select name="status" class="form-select" required>
                    <option value="active"
                        {{ old('status', $addon->status) == 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ old('status', $addon->status) == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div>
                <label class="form-label">Current Image</label>

                <div class="mt-2">
                    <img src="{{ $addon->image ? asset('storage/'.$addon->image) : asset('images/default-service.png') }}"
                         alt="Addon"
                         class="w-24 h-24 rounded-lg object-cover border">
                </div>
            </div>

            <div>
                <label class="form-label">New Image</label>

                <input type="file"
                       name="image"
                       class="form-input">

                <small class="text-gray-500">
                    Leave blank to keep existing image.
                </small>
            </div>

        </div>

        <div class="flex justify-end gap-3 mt-8">

            <a href="{{ route('provider.addons.index') }}"
               class="btn-secondary px-6">
                Cancel
            </a>

            <button type="submit"
                    class="btn-primary px-8">
                Update
            </button>

        </div>

    </div>
</form>

@endsection