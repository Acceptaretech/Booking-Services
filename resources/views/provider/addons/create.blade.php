@extends('layouts.provider.app')

@section('title','Create Addon')
@section('page_title','Create Addon')

@section('content')

<form action="{{ route('provider.addons.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">Name <span class="text-red-500">*</span></label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-input"
                       placeholder="Name"
                       required>
            </div>

            <div>
                <label class="form-label">Select Service <span class="text-red-500">*</span></label>
                <select name="service_id" class="form-select" required>
                    <option value="">Select Service</option>
                    @foreach($services ?? [] as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Price <span class="text-red-500">*</span></label>
                <input type="number"
                       step="0.01"
                       name="price"
                       value="{{ old('price') }}"
                       class="form-input"
                       placeholder="Price"
                       required>
            </div>

            <div>
                <label class="form-label">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="form-label">Image <span class="text-red-500">*</span></label>
                <input type="file"
                       name="image"
                       class="form-input">
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