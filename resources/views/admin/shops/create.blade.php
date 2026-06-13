@extends('layouts.admin.app')

@section('title', 'Create Shop')
@section('page_title', 'Create Shop')

@section('content')

<form method="POST" action="{{ route('admin.shops.store') }}" enctype="multipart/form-data" class="card p-6">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div>
            <label class="form-label">Shop Name *</label>
            <input name="name" value="{{ old('name') }}" placeholder="Enter Shop Name" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Provider *</label>
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
            <label class="form-label">Registration Number *</label>
            <input name="registration_number" value="{{ old('registration_number') }}" placeholder="Enter Registration Number" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Contact Number *</label>
            <div class="flex">
                <input name="country_code" value="{{ old('country_code', '+91') }}" class="form-input w-24 rounded-r-none">
                <input name="phone" value="{{ old('phone') }}" placeholder="Enter Contact Number" class="form-input rounded-l-none" required>
            </div>
        </div>

        <div>
            <label class="form-label">Latitude *</label>
            <input name="latitude" value="{{ old('latitude') }}" placeholder="e.g. 12.3456" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Longitude *</label>
            <input name="longitude" value="{{ old('longitude') }}" placeholder="e.g. 77.1234" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Address *</label>
            <input name="address" value="{{ old('address') }}" placeholder="Enter Shop Address" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Country *</label>
            <input name="country" value="{{ old('country') }}" placeholder="Enter Country" class="form-input" required>
        </div>

        <div>
            <label class="form-label">State *</label>
            <input name="state" value="{{ old('state') }}" placeholder="Enter State" class="form-input" required>
        </div>

        <div>
            <label class="form-label">City *</label>
            <input name="city" value="{{ old('city') }}" placeholder="Enter City" class="form-input" required>
        </div>

        <div>
            <label class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div>
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-input">
        </div>

    </div>

    <div class="flex justify-end gap-2 mt-6">
        <a href="{{ route('admin.shops.index') }}" class="btn-secondary">Cancel</a>
        <button type="submit" class="btn-primary">Save</button>
    </div>
</form>

@endsection