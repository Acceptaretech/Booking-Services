@extends('layouts.provider.app')

@section('title', 'Create Shop')
@section('page_title', 'Create Shop')

@section('content')

<form action="{{ route('provider.shops.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">Shop Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Enter Shop Name" required>
            </div>

            <div>
                <label class="form-label">Services <span class="text-red-500">*</span></label>
                <select name="service_id" class="form-select" required>
                    <option value="">Select Services</option>
                    @foreach($services ?? [] as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                            {{ $service->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Registration Number <span class="text-red-500">*</span></label>
                <input type="text" name="registration_number" value="{{ old('registration_number') }}" class="form-input" placeholder="Enter Registration Number" required>
            </div>

            <div>
                <label class="form-label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Enter Email" required>
            </div>

            <div>
                <label class="form-label">Contact Number <span class="text-red-500">*</span></label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-200 bg-gray-100 text-sm">
                        🇮🇳 +91
                    </span>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input rounded-l-none" placeholder="Enter Contact Number" required>
                </div>
            </div>

            <div>
                <label class="form-label">Latitude <span class="text-red-500">*</span></label>
                <input type="text" name="latitude" value="{{ old('latitude') }}" class="form-input" placeholder="e.g. 12.3456" required>
            </div>

            <div>
                <label class="form-label">Longitude <span class="text-red-500">*</span></label>
                <input type="text" name="longitude" value="{{ old('longitude') }}" class="form-input" placeholder="e.g. 77.1234" required>
            </div>

            <div>
                <label class="form-label">Address <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="{{ old('address') }}" class="form-input" placeholder="Enter Shop Address" required>
            </div>

            <div>
                <label class="form-label">Country <span class="text-red-500">*</span></label>
                <select name="country" class="form-select" required>
                    <option value="">Select Country</option>
                    <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                    <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                    <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                </select>
            </div>

            <div>
                <label class="form-label">State <span class="text-red-500">*</span></label>
                <select name="state" class="form-select" required>
                    <option value="">Select State</option>
                    <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                    <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                    <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                </select>
            </div>

            <div>
                <label class="form-label">City <span class="text-red-500">*</span></label>
                <select name="city" class="form-select" required>
                    <option value="">Select City</option>
                    <option value="Ahmedabad" {{ old('city') == 'Ahmedabad' ? 'selected' : '' }}>Ahmedabad</option>
                    <option value="Surat" {{ old('city') == 'Surat' ? 'selected' : '' }}>Surat</option>
                    <option value="Mumbai" {{ old('city') == 'Mumbai' ? 'selected' : '' }}>Mumbai</option>
                    <option value="Delhi" {{ old('city') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                    <option value="Bangalore" {{ old('city') == 'Bangalore' ? 'selected' : '' }}>Bangalore</option>
                </select>
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
                <input type="file" name="image" class="form-input" required>
            </div>

        </div>

        <div class="flex justify-end mt-10">
            <button type="submit" class="btn-primary px-8">
                Save
            </button>
        </div>

    </div>
</form>

@endsection