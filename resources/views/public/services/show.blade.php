@extends('layouts.public.app')
@section('title', $service->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-primary-600">Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('services') }}" class="hover:text-primary-600">Services</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span>{{ $service->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Left: details --}}
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $service->name }}</h1>

            <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-500">
                @if($service->total_reviews > 0)
                <span class="flex items-center gap-1">
                    @for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=round($service->avg_rating)?'text-yellow-400':'text-gray-300' }}"></i>@endfor
                    <strong class="text-gray-700 dark:text-gray-200 ml-1">{{ $service->avg_rating }}</strong>
                    ({{ $service->total_reviews }} reviews)
                </span>
                @endif
                @if($service->duration)<span><i class="fas fa-clock mr-1 text-primary-500"></i>{{ $service->duration }} min</span>@endif
                <span>Created By: <a href="{{ route('provider.detail',$service->provider) }}" class="text-primary-600 hover:underline font-medium">{{ $service->provider->full_name }}</a></span>
            </div>

            {{-- Main image --}}
            <div class="rounded-2xl overflow-hidden mb-6 bg-gray-100 dark:bg-gray-800">
                <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="w-full h-80 object-cover">
            </div>

            {{-- Description --}}
            @if($service->description)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-6 border border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-lg text-gray-900 dark:text-white mb-3">About this Service</h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">{{ $service->description }}</p>
            </div>
            @endif

            {{-- Available Locations --}}
            @if($service->available_locations)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-6 border border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-lg text-gray-900 dark:text-white mb-3">Available Location</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($service->available_locations as $loc)
                    <span class="bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-300 px-3 py-1.5 rounded-full text-sm">{{ $loc }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- FAQs --}}
            @if($service->faqs->count())
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-6 border border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Frequently Asked Questions</h2>
                <div class="space-y-3" x-data="{open:null}">
                    @foreach($service->faqs as $i => $faq)
                    <div class="border border-gray-100 dark:border-gray-700 rounded-xl overflow-hidden">
                        <button class="w-full flex items-center justify-between p-4 text-left hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors" onclick="toggleFaq({{ $i }})">
                            <span class="font-medium text-sm text-gray-800 dark:text-gray-200">{{ $faq->title }}</span>
                            <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" id="faq-icon-{{ $i }}"></i>
                        </button>
                        <div id="faq-body-{{ $i }}" class="hidden px-4 pb-4 text-sm text-gray-500 dark:text-gray-400">{{ $faq->description }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Reviews --}}
            @if($service->reviews->count())
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 mb-6 border border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-lg text-gray-900 dark:text-white mb-4">Customer Reviews</h2>
                <div class="space-y-5">
                    @foreach($service->reviews as $review)
                    <div class="flex gap-4">
                        <img src="{{ $review->customer->profile_image_url }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0" alt="">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $review->customer->full_name }}</p>
                                <div class="flex">
                                    @for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$review->rating?'text-yellow-400':'text-gray-300' }}"></i>@endfor
                                </div>
                            </div>
                            @if($review->review)<p class="text-sm text-gray-500 dark:text-gray-400">{{ $review->review }}</p>@endif
                            <p class="text-xs text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Right: booking card --}}
        <div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 sticky top-24">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        @if($service->discount > 0)
                        <p class="text-gray-400 line-through text-sm">${{ number_format($service->price,2) }}</p>
                        @endif
                        <p class="text-3xl font-bold text-primary-600">
                            {{ $service->price == 0 ? 'Free' : '$'.number_format($service->discounted_price,2) }}
                        </p>
                        @if($service->duration)<p class="text-xs text-gray-400">/ {{ $service->duration }} min</p>@endif
                    </div>
                    @if($service->discount > 0)
                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">{{ $service->discount }}% OFF</span>
                    @endif
                </div>

                <a href="{{ auth()->check() ? route('customer.booking.create',$service) : route('login') }}"
                   class="block w-full text-center bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-xl font-semibold text-sm transition-colors mb-4">
                    Continue
                </a>

                {{-- Provider card --}}
                <div class="border-t border-gray-100 dark:border-gray-700 pt-4 mt-4">
                    <p class="text-xs text-gray-500 mb-3">Service Provider</p>
                    <div class="flex items-center gap-3">
                        <img src="{{ $service->provider->profile_image_url }}" class="w-12 h-12 rounded-full object-cover" alt="">
                        <div>
                            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200">{{ $service->provider->full_name }}</p>
                            <p class="text-xs text-gray-400">{{ $service->provider->designation ?? 'Service Provider' }}</p>
                            @if($service->provider->reviews_avg_rating)
                            <div class="flex items-center gap-1 mt-0.5">
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                <span class="text-xs text-gray-500">{{ number_format($service->provider->reviews_avg_rating,1) }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Related services --}}
            @if($relatedServices->count())
            <div class="mt-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-4">Related Services</h3>
                <div class="space-y-3">
                    @foreach($relatedServices as $rs)
                    <a href="{{ route('service.detail',$rs) }}" class="flex items-center gap-3 bg-white dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary-300 transition-colors">
                        <img src="{{ $rs->image_url }}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0" alt="">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $rs->name }}</p>
                            <p class="text-xs text-primary-600 font-semibold">${{ number_format($rs->discounted_price,2) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
function toggleFaq(i){
    const b=document.getElementById('faq-body-'+i);
    const ic=document.getElementById('faq-icon-'+i);
    b.classList.toggle('hidden');
    ic.style.transform=b.classList.contains('hidden')?'':'rotate(180deg)';
}
</script>
@endpush
