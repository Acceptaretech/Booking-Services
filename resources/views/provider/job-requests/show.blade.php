@extends('layouts.provider.app')

@section('title','Booking Details')
@section('page_title','Booking Details')

@section('content')

<div class="card p-5 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                Booking Details
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Booking ID: #{{ $jobRequest->booking_number ?? $jobRequest->id }}
            </p>
        </div>

        <a href="{{ route('provider.job-requests.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 space-y-6">

        <div class="card p-6">
            <h3 class="text-lg font-bold mb-5">Service Information</h3>

            <div class="flex flex-col sm:flex-row gap-5">
                <img src="{{ $jobRequest->service?->image ? asset('storage/'.$jobRequest->service->image) : asset('images/default-service.png') }}"
                     class="w-full sm:w-32 h-40 sm:h-32 rounded-2xl object-cover"
                     alt="Service">

                <div class="flex-1">
                    <h4 class="text-xl font-bold">
                        {{ $jobRequest->service->name ?? $jobRequest->service->title ?? '-' }}
                    </h4>

                    <p class="text-gray-500 mt-2">
                        {{ $jobRequest->service->description ?? 'No description available.' }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-5">
                        <div>
                            <p class="text-xs text-gray-400">Booking Date</p>
                            <p class="font-semibold">
                                {{ $jobRequest->booking_date ? \Carbon\Carbon::parse($jobRequest->booking_date)->format('F d, Y h:i A') : '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Quantity</p>
                            <p class="font-semibold">
                                {{ $jobRequest->quantity ?? 1 }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Payment Type</p>
                            <p class="font-semibold capitalize">
                                {{ $jobRequest->payment_type ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400">Payment Status</p>
                            <span class="inline-block mt-1 px-3 py-1 rounded-lg bg-primary-50 text-primary-600 text-sm font-semibold">
                                {{ ucfirst($jobRequest->payment_status ?? 'pending') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-lg font-bold mb-5">Customer Information</h3>

            @if($jobRequest->customer)
                <div class="flex items-center gap-4">
                    <img src="{{ $jobRequest->customer->profile_image ? asset('storage/'.$jobRequest->customer->profile_image) : asset('images/default-user.png') }}"
                         class="w-16 h-16 rounded-full object-cover"
                         alt="Customer">

                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">
                            {{ $jobRequest->customer->first_name }}
                            {{ $jobRequest->customer->last_name }}
                        </h4>

                        <p class="text-sm text-gray-500">
                            <i class="fas fa-envelope mr-1"></i>
                            {{ $jobRequest->customer->email ?? '-' }}
                        </p>

                        <p class="text-sm text-gray-500">
                            <i class="fas fa-phone mr-1"></i>
                            {{ $jobRequest->customer->phone ?? '-' }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-gray-400">Customer not found.</p>
            @endif
        </div>

        <div class="card p-6">
            <h3 class="text-lg font-bold mb-5">Address & Notes</h3>

            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-400">Service Address</p>
                    <p class="font-semibold">
                        {{ $jobRequest->address ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Latitude / Longitude</p>
                    <p class="font-semibold">
                        {{ $jobRequest->latitude ?? '-' }} / {{ $jobRequest->longitude ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400">Notes</p>
                    <p class="font-semibold">
                        {{ $jobRequest->notes ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="space-y-6">

        <div class="card p-6">
            <h3 class="text-lg font-bold mb-5">Booking Status</h3>

            @php
                $status = $jobRequest->status ?? 'pending';

                $statusClass = match($status) {
                    'accepted' => 'bg-green-100 text-green-600',
                    'completed' => 'bg-green-100 text-green-600',
                    'pending' => 'bg-yellow-100 text-yellow-600',
                    'in_progress' => 'bg-blue-100 text-blue-600',
                    'cancelled' => 'bg-red-100 text-red-600',
                    default => 'bg-gray-100 text-gray-600'
                };
            @endphp

            <span class="px-4 py-2 rounded-xl text-sm font-bold {{ $statusClass }}">
                {{ ucfirst(str_replace('_',' ', $status)) }}
            </span>
        </div>

        <div class="card p-6">
            <h3 class="text-lg font-bold mb-5">Provider</h3>

            @if($jobRequest->provider)
                <div class="flex items-center gap-3">
                    <img src="{{ $jobRequest->provider->profile_image ? asset('storage/'.$jobRequest->provider->profile_image) : asset('images/default-user.png') }}"
                         class="w-14 h-14 rounded-full object-cover"
                         alt="Provider">

                    <div>
                        <p class="font-bold">
                            {{ $jobRequest->provider->first_name }}
                            {{ $jobRequest->provider->last_name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $jobRequest->provider->email ?? '-' }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-gray-400">No provider assigned.</p>
            @endif
        </div>

        <div class="card p-6">
          <h3 class="text-lg font-bold mb-5">Assign Technician</h3>
      
          <form method="POST"
                action="{{ route('provider.job-requests.assign-technician', $jobRequest->id) }}">
              @csrf
              
      
              <select name="handyman_id"
                      class="form-select w-full mb-4"
                      required>
      
                  <option value="">Select Technician</option>
      
                  @foreach($handymen as $handyman)
                      <option value="{{ $handyman->id }}"
                          {{ $jobRequest->handyman_id == $handyman->id ? 'selected' : '' }}>
      
                          {{ $handyman->first_name }}
                          {{ $handyman->last_name }}
                          ({{ $handyman->phone }})
      
                      </option>
                  @endforeach
      
              </select>
      
              <button type="submit" class="btn-primary w-full">
                  <i class="fas fa-user-check mr-2"></i>
                  Assign Technician
              </button>
      
          </form>
      </div>
        <div class="card p-6">
            <h3 class="text-lg font-bold mb-5">Price Summary</h3>

            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span>Base Price</span>
                    <strong>₹{{ number_format($jobRequest->base_price ?? 0, 2) }}</strong>
                </div>

                <div class="flex justify-between">
                    <span>Discount</span>
                    <strong class="text-green-600">-₹{{ number_format($jobRequest->discount_amount ?? 0, 2) }}</strong>
                </div>

                <div class="flex justify-between">
                    <span>Coupon Discount</span>
                    <strong class="text-green-600">-₹{{ number_format($jobRequest->coupon_discount ?? 0, 2) }}</strong>
                </div>

                <div class="flex justify-between">
                    <span>Tax</span>
                    <strong class="text-orange-600">₹{{ number_format($jobRequest->tax_amount ?? 0, 2) }}</strong>
                </div>

                <div class="flex justify-between pt-3 border-t text-lg">
                    <span>Total</span>
                    <strong class="text-primary-600">₹{{ number_format($jobRequest->total_amount ?? 0, 2) }}</strong>
                </div>

                <div class="flex justify-between">
                    <span>Paid</span>
                    <strong>₹{{ number_format($jobRequest->paid_amount ?? 0, 2) }}</strong>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection