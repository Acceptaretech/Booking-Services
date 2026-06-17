@extends('layouts.provider.app')

@section('title', 'Edit Shop')
@section('page_title', 'Edit Shop')

@section('content')

<form action="{{ route('provider.shops.update', $shop->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">Shop Name <span class="text-red-500">*</span></label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $shop->name) }}"
                       class="form-input"
                       placeholder="Enter Shop Name"
                       required>
            </div>

            <div>
                <label class="form-label">Registration Number</label>
                <input type="text"
                       name="registration_number"
                       value="{{ old('registration_number', $shop->registration_number) }}"
                       class="form-input"
                       placeholder="Enter Registration Number">
            </div>

            <div>
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $shop->email) }}"
                       class="form-input"
                       placeholder="Enter Email">
            </div>

            <div>
                <label class="form-label">Contact Number</label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 bg-gray-100 text-sm">
                        🇮🇳 +91
                    </span>
                    <input type="text"
                           name="phone"
                           value="{{ old('phone', $shop->phone) }}"
                           class="form-input rounded-l-none"
                           placeholder="Enter Contact Number">
                </div>
            </div>

            <div>
                <label class="form-label">Latitude</label>
                <input type="text"
                       name="latitude"
                       value="{{ old('latitude', $shop->latitude) }}"
                       class="form-input"
                       placeholder="e.g. 12.3456">
            </div>

            <div>
                <label class="form-label">Longitude</label>
                <input type="text"
                       name="longitude"
                       value="{{ old('longitude', $shop->longitude) }}"
                       class="form-input"
                       placeholder="e.g. 77.1234">
            </div>

            <div>
                <label class="form-label">Address</label>
                <input type="text"
                       name="address"
                       value="{{ old('address', $shop->address) }}"
                       class="form-input"
                       placeholder="Enter Shop Address">
            </div>

            <div>
                <label class="form-label">Country <span class="text-red-500">*</span></label>
                <input type="text"
                       name="country"
                       value="{{ old('country', $shop->country) }}"
                       class="form-input"
                       placeholder="Enter Country"
                       required>
            </div>

            <div>
                <label class="form-label">State <span class="text-red-500">*</span></label>
                <input type="text"
                       name="state"
                       value="{{ old('state', $shop->state) }}"
                       class="form-input"
                       placeholder="Enter State"
                       required>
            </div>

            <div>
                <label class="form-label">City <span class="text-red-500">*</span></label>
                <input type="text"
                       name="city"
                       value="{{ old('city', $shop->city) }}"
                       class="form-input"
                       placeholder="Enter City"
                       required>
            </div>

            <div>
                <label class="form-label">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status', $shop->status) == 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive" {{ old('status', $shop->status) == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>
            </div>

            <div>
                <label class="form-label">Image</label>
                <input type="file"
                       name="image"
                       class="form-input">

                @if($shop->image)
                    <div class="mt-3">
                        <img src="{{ $shop->image_url }}"
                             class="w-20 h-20 rounded-xl object-cover"
                             alt="Shop Image">
                    </div>
                @endif
            </div>

        </div>

        <div class="flex justify-end mt-10 gap-3">
            <a href="{{ route('provider.shops.index') }}" class="btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn-primary px-8">
                Update
            </button>
        </div>

    </div>
</form>

@endsection