@extends('layouts.public.app')

@section('title','Review Details')

@section('content')

<div class="min-h-screen bg-[#eef8ff] py-8">
    <div class="max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            @include('customer.partials.sidebar')

            <div>
                <div class="bg-white rounded-3xl p-6 shadow-sm">

                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-extrabold text-black">
                            Review Details
                        </h1>

                        <a href="{{ route('customer.reviews') }}"
                           class="px-4 py-2 rounded-xl bg-gray-100 text-gray-700">
                            Back
                        </a>
                    </div>

                    <h2 class="text-2xl font-bold">
                        {{ $review->service->name ?? 'Service' }}
                    </h2>

                    <p class="text-gray-500 mt-1">
                        Booking #{{ $review->booking->booking_number ?? $review->booking_id }}
                    </p>

                    <div class="text-yellow-500 text-2xl mt-4">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                    </div>

                    <p class="text-gray-700 mt-6 leading-8">
                        {{ $review->review ?: 'No written review.' }}
                    </p>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection