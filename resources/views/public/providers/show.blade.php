@extends('layouts.public.app')
@section('title', $user->full_name)
@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Provider card --}}
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 text-center sticky top-24">
                <img src="{{ $user->profile_image_url }}" class="w-28 h-28 rounded-2xl object-cover mx-auto mb-4" alt="{{ $user->full_name }}">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $user->full_name }}
                    <i class="fas fa-circle-check text-primary-600 text-sm ml-1"></i>
                </h1>
                <p class="text-gray-500 text-sm mb-3">{{ $user->designation ?? 'Service Provider' }}</p>

                @if($user->reviews_avg_rating)
                <div class="flex justify-center gap-1 mb-4">
                    @for($i=1;$i<=5;$i++)<i class="fas fa-star {{ $i<=round($user->reviews_avg_rating)?'text-yellow-400':'text-gray-300' }}"></i>@endfor
                    <span class="text-sm text-gray-500 ml-1">{{ number_format($user->reviews_avg_rating,1) }}</span>
                </div>
                @endif

                <div class="space-y-2 text-sm text-left border-t border-gray-100 dark:border-gray-700 pt-4">
                    @if($user->zone)<div class="flex items-center gap-2 text-gray-500"><i class="fas fa-map-marker-alt text-primary-500 w-4"></i> {{ $user->zone->name }}</div>@endif
                    @if($user->phone)<div class="flex items-center gap-2 text-gray-500"><i class="fas fa-phone text-primary-500 w-4"></i> {{ $user->phone }}</div>@endif
                    <div class="flex items-center gap-2 text-gray-500"><i class="fas fa-calendar text-primary-500 w-4"></i> Member since {{ $user->created_at->format('M Y') }}</div>
                </div>
            </div>
        </div>

        {{-- Services --}}
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Services by {{ $user->first_name }}</h2>
            @if($user->services->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-10">
                @foreach($user->services->where('status','active') as $service)
                    @include('components.service-card', compact('service'))
                @endforeach
            </div>
            @else
            <div class="text-center py-12 text-gray-400"><i class="fas fa-tools text-4xl mb-3 block"></i><p>No active services yet</p></div>
            @endif

            {{-- Reviews --}}
            @if($user->reviews->count())
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Reviews</h3>
            <div class="space-y-4">
                @foreach($user->reviews->take(5) as $review)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 flex gap-4">
                    <img src="{{ $review->customer->profile_image_url }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $review->customer->full_name }}</p>
                            <div class="flex">@for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$review->rating?'text-yellow-400':'text-gray-300' }}"></i>@endfor</div>
                        </div>
                        @if($review->review)<p class="text-sm text-gray-500">{{ $review->review }}</p>@endif
                        <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
