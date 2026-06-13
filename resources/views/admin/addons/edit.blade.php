@extends('layouts.admin.app')

@section('title', 'Edit Addon')
@section('page_title', 'Edit Addon')

@section('content')

<form method="POST" action="{{ route('admin.addons.update', $addon->id) }}" enctype="multipart/form-data" class="card p-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="{{ old('name', $addon->name) }}" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Select Service *</label>
            <select name="service_id" class="form-select" required>
                <option value="">Select Service</option>
                @foreach($services as $service)
                    <option value="{{ $service->id }}" {{ $addon->service_id == $service->id ? 'selected' : '' }}>
                        {{ $service->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Select Provider *</label>
            <select name="user_id" class="form-select" required>
                <option value="">Select Provider</option>
                @foreach($providers as $provider)
                    <option value="{{ $provider->id }}" {{ $addon->user_id == $provider->id ? 'selected' : '' }}>
                        {{ $provider->full_name ?? $provider->name ?? $provider->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $addon->price) }}" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active" {{ $addon->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $addon->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div>
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-input">

            @if($addon->image)
                <img src="{{ asset('storage/' . $addon->image) }}" class="w-16 h-16 rounded-xl object-cover mt-2">
            @endif
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-6">
        <a href="{{ route('admin.addons.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>

@endsection