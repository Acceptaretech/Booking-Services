@extends('layouts.public.app')

@section('title','My Reviews')

@section('content')

<div class="min-h-screen bg-[#eef8ff] py-8">

    <div class="max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-6">

            {{-- Customer Sidebar --}}
            @include('customer.partials.sidebar')

            {{-- Content --}}
            <div>

                <div class="flex items-center justify-between border-b border-gray-300 pb-5 mb-8">
                    <div>
                        <h1 class="text-4xl font-extrabold text-black">
                            My Reviews
                        </h1>
                        <p class="text-gray-500 mt-1">
                            Manage your service reviews and ratings
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    @forelse($reviews as $review)

                        <div class="bg-white rounded-3xl shadow-sm p-6">

                            <div class="flex justify-between items-start mb-4">

                                <div>
                                    <h3 class="text-xl font-bold">
                                        {{ $review->service->name ?? 'Service' }}
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Booking #{{ $review->booking->booking_number ?? $review->booking_id }}
                                    </p>
                                </div>

                                <div class="text-yellow-500">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                </div>

                            </div>

                            <p class="text-gray-600 leading-7">
                                {{ $review->review }}
                            </p>

                            <div class="mt-5 pt-4 border-t">

                                <div class="flex justify-between items-center">

                                    <div>
                                        <p class="font-semibold">
                                            {{ $review->provider->first_name ?? '' }}
                                            {{ $review->provider->last_name ?? '' }}
                                        </p>

                                        <p class="text-sm text-gray-500">
                                            Provider
                                        </p>
                                    </div>

                                    <a href="{{ route('customer.reviews.show',$review->id) }}"
                                       class="px-4 py-2 bg-indigo-600 text-white rounded-xl">
                                        View
                                    </a>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="md:col-span-2 bg-white rounded-3xl p-10 text-center">

                            <i class="far fa-star text-5xl text-gray-300"></i>

                            <h3 class="text-xl font-bold mt-4">
                                No Reviews Found
                            </h3>

                            <p class="text-gray-500 mt-2">
                                You haven't submitted any reviews yet.
                            </p>

                        </div>

                    @endforelse

                </div>

                <div class="mt-8">
                    {{ $reviews->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection