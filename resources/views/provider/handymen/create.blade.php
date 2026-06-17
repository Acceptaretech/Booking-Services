@extends('layouts.provider.app')

@section('title','Add New Handyman')
@section('page_title','Add New Handyman')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">Add New Handyman</h2>

        <a href="{{ route('provider.handymen.index') }}" class="btn-primary">
            <i class="fas fa-angle-double-left mr-1"></i> Back
        </a>
    </div>
</div>

<form action="{{ route('provider.handymen.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="card p-6">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="form-label">First Name <span class="text-red-500">*</span></label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-input" placeholder="First Name" required>
            </div>

            <div>
                <label class="form-label">Last Name <span class="text-red-500">*</span></label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-input" placeholder="Last Name" required>
            </div>

            <div>
                <label class="form-label">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-input" placeholder="Username" required>
            </div>

            <div>
                <label class="form-label">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="Email" required>
            </div>

            <div>
                <label class="form-label">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" class="form-input" placeholder="Password" required>
            </div>

            <div>
              <label class="form-label">
                  Select Handyman Commission <span class="text-red-500">*</span>
              </label>
          
              <select name="commission_id" class="form-select" required>
                  <option value="">Select Handyman Commission</option>
          
                  @foreach($commissions ?? [] as $commission)
                      <option value="{{ $commission->id }}"
                          {{ old('commission_id') == $commission->id ? 'selected' : '' }}>
          
                          {{ $commission->name ?? $commission->title }}
                          @if(($commission->type ?? '') == 'percentage')
                              ({{ $commission->commission }}%)
                          @else
                              (${{ number_format($commission->commission ?? $commission->amount ?? 0, 2) }})
                          @endif
          
                      </option>
                  @endforeach
              </select>
          </div>

            <div>
                <label class="form-label">Contact Number <span class="text-red-500">*</span></label>
                <div class="flex">
                    <span class="inline-flex items-center px-3 border border-r-0 rounded-l-md bg-gray-100">
                        🇮🇳 +91
                    </span>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-input rounded-l-none" placeholder="Contact Number" required>
                </div>
            </div>

            <div>
                <label class="form-label">Status <span class="text-red-500">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="form-label">Profile Image</label>
                <input type="file" name="profile_image" class="form-input">
            </div>

            <div class="md:col-span-3">
                <label class="form-label">Address</label>
                <textarea name="address" rows="4" class="form-input" placeholder="Address">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="form-label">Select Country</label>
                <input type="text" name="country" value="{{ old('country') }}" class="form-input" placeholder="Country">
            </div>

            <div>
                <label class="form-label">Select State</label>
                <input type="text" name="state" value="{{ old('state') }}" class="form-input" placeholder="State">
            </div>

            <div>
                <label class="form-label">Select City</label>
                <input type="text" name="city" value="{{ old('city') }}" class="form-input" placeholder="City">
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