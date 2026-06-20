@extends('layouts.public.app')
@section('title', 'Home - Your Instant Technician Service')

@push('styles')
<style>
    .hero-section { min-height: 500px; }
    .service-card img { transition: transform .4s ease; }
    .service-card:hover img { transform: scale(1.06); }
    .category-icon { width: 70px; height: 70px; }
    .swiper-provider .card { min-width: 220px; }
</style>
@endpush

@section('content')

{{-- ═══════════════════════ HERO BANNER ═══════════════════════ --}}
<section class="hero-section hero-gradient relative overflow-hidden flex items-center">
    {{-- Background pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 right-10 w-64 h-64 rounded-full bg-white/20 blur-3xl"></div>
        <div class="absolute -bottom-10 -left-10 w-80 h-80 rounded-full bg-white/10 blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
        {{-- Text --}}
        <div class="text-white fade-in">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">
                Your Instant Link To The <span class="text-yellow-300">Perfect Technician</span> Service
            </h1>
            <p class="text-lg text-white/80 mb-8">
                Experience the ease. Trust our Technician service, from fixes to installs. Count on us to meet your greatest household helper.
            </p>

            {{-- Search Bar --}}
            <div class="bg-white rounded-2xl p-2 flex flex-col sm:flex-row gap-2 shadow-2xl">
                <div class="flex items-center gap-2 flex-1 px-3">
                    <i class="fas fa-map-marker-alt text-primary-600"></i>
                    <input type="text" placeholder="Current Location" class="w-full text-gray-700 text-sm outline-none py-2 bg-transparent">
                </div>
                <div class="w-px bg-gray-200 hidden sm:block"></div>
                <div class="flex items-center gap-2 flex-1 px-3">
                    <i class="fas fa-search text-primary-600"></i>
                    <input type="text" id="searchService" placeholder="Search Service..." class="w-full text-gray-700 text-sm outline-none py-2 bg-transparent">
                </div>
                <button onclick="doSearch()" class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap">
                    Search
                </button>
            </div>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-2 mt-4">
                <span class="text-white/60 text-sm">Popular:</span>
                @foreach(['Plumber','Electrician','Cleaning','Painting','AC Repair'] as $tag)
                <a href="{{ route('services') }}?search={{ $tag }}"
                   class="bg-white/10 hover:bg-white/20 text-white text-xs px-3 py-1.5 rounded-full transition-colors cursor-pointer">
                    {{ $tag }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Provider cards --}}
        <div class="hidden lg:grid grid-cols-3 gap-4 fade-in">
            @foreach($featuredProviders->take(3) as $provider)
            <div class="bg-white rounded-2xl overflow-hidden shadow-xl {{ $loop->index === 0 ? 'transform translate-y-4' : '' }} {{ $loop->index === 2 ? 'transform -translate-y-4' : '' }}">
                <img src="{{ $provider->profile_image_url }}" class="w-full h-48 object-cover" alt="{{ $provider->full_name }}">
                <div class="p-3 text-center">
                    <p class="font-semibold text-gray-800 text-sm">{{ $provider->full_name }}</p>
                    {{--<div class="flex justify-center mt-1">
                        @for($i=1;$i<=5;$i++)
                        <i class="fas fa-star text-yellow-400 text-xs"></i>
                        @endfor
                    </div> --}}
                </div>
            </div>
            @endforeach
        </div> 
    </div>
</section>

{{-- ═══════════════════════ POPULAR CATEGORIES ═══════════════════════ --}}
@if($categories->count())
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider mb-1">Browse</p>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Our Top Categories</h2>
            </div>
            <a href="{{ route('categories') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center gap-1">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach($categories as $cat)
            <a href="{{ route('services') }}?category_id={{ $cat->id }}" class="group text-center card-hover">
                <div class="bg-primary-50 dark:bg-gray-700 rounded-2xl p-5 mb-3 flex items-center justify-center mx-auto w-20 h-20 group-hover:bg-primary-100 transition-colors">
                    @if($cat->image)
                        <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" class="w-12 h-12 object-contain">
                    @else
                        <i class="fas fa-tools text-primary-600 text-2xl"></i>
                    @endif
                </div>
                <p class="font-semibold text-sm text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition-colors">{{ $cat->name }}</p>
                <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ Str::limit($cat->description,50) }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════ TOP RATED SERVICES ═══════════════════════ --}}
@if($topRatedServices->count())
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider mb-1">Quality</p>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Top Rated Services</h2>
            </div>
            <a href="{{ route('services') }}?sort=top_rated" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center gap-1">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($topRatedServices as $service)
                @include('components.service-card', ['service' => $service])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════ FEATURED SERVICES ═══════════════════════ --}}
@if($featuredServices->count())
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <p class="text-primary-600 text-sm font-semibold uppercase tracking-wider mb-1">Handpicked</p>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Featured Services</h2>
            </div>
            <a href="{{ route('services') }}?featured=1" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center gap-1">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredServices as $service)
                @include('components.service-card', ['service' => $service])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════ HOW IT WORKS ═══════════════════════ --}}
<section class="py-20 bg-gradient-to-br from-primary-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-primary-200 text-sm font-semibold uppercase tracking-wider mb-2">Simple Process</p>
        <h2 class="text-3xl font-bold mb-12">How It Works</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach([['fa-search','Search Service','Browse from hundreds of verified services in your area.'],
                      ['fa-calendar-check','Book Appointment','Select your date, time slot, and confirm your booking.'],
                      ['fa-star','Get Service','Our expert Technician arrives and completes the job perfectly.']] as $i => $step)
            <div class="relative">
                @if(!$loop->last)
                <div class="hidden md:block absolute top-10 left-2/3 w-1/2 border-t-2 border-dashed border-white/30"></div>
                @endif
                <div class="w-20 h-20 rounded-full bg-white/15 flex items-center justify-center mx-auto mb-5 text-3xl">
                    <i class="fas {{ $step[0] }}"></i>
                </div>
                <div class="w-8 h-8 rounded-full bg-yellow-400 text-gray-900 font-bold flex items-center justify-center mx-auto -mt-3 mb-4 text-sm">{{ $i+1 }}</div>
                <h3 class="text-xl font-bold mb-2">{{ $step[1] }}</h3>
                <p class="text-white/70 text-sm">{{ $step[2] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════ POPULAR PROVIDERS ═══════════════════════ --}}
@if($popularProviders->count())
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Popular Providers</h2>
            <a href="{{ route('providers') }}" class="text-primary-600 hover:text-primary-700 font-medium text-sm flex items-center gap-1">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach($popularProviders as $provider)
            <a href="{{ route('provider.detail',$provider) }}" class="text-center group card-hover">
                <div class="relative mx-auto w-24 h-24 mb-3">
                    <img src="{{ $provider->profile_image_url }}" alt="{{ $provider->full_name }}"
                         class="w-24 h-24 rounded-2xl object-cover shadow-md group-hover:shadow-xl transition-shadow">
                    <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></span>
                </div>
                <p class="font-semibold text-sm text-gray-800 dark:text-gray-200 group-hover:text-primary-600">{{ $provider->full_name }}</p>
                <p class="text-xs text-gray-400">{{ $provider->designation ?? 'Provider' }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════ JOIN US / CTA ═══════════════════════ --}}
<section class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 rounded-3xl p-10 text-white text-center">
            <h2 class="text-3xl font-bold mb-3">Become a Service Provider</h2>
            <p class="text-white/80 mb-8 max-w-lg mx-auto">Join thousands of professionals earning with our platform. Register today and start accepting bookings.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <input type="email" placeholder="Enter your email" class="px-5 py-3 rounded-xl text-gray-800 text-sm outline-none w-full sm:w-80">
                <a href="{{ route('provider.register') }}" class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-xl font-bold text-sm hover:bg-yellow-300 transition-colors whitespace-nowrap">
                    Join Us Now
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════ DISCOVER APP ═══════════════════════ --}}
<section class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-primary-600 font-semibold uppercase tracking-wider text-sm mb-2">Mobile App</p>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Discover Our App</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">Book services, track progress, and pay — all from your phone. Download our app and get your first service 20% off.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:opacity-90 transition-opacity">
                    <img src="{{ asset('images/google-play-badge.png') }}" alt="Google Play" class="h-12">
                </a>
                <a href="#" class="hover:opacity-90 transition-opacity">
                    <img src="{{ asset('images/app-store-badge.png') }}" alt="App Store" class="h-12">
                </a>
            </div>
        </div>
        <div class="flex justify-center">
            <img src="{{ asset('images/app-mockup.png') }}" alt="App" class="max-h-80 object-contain drop-shadow-2xl">
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function doSearch(){
    const q = document.getElementById('searchService').value;
    if(q) window.location = '{{ route("services") }}?search='+encodeURIComponent(q);
}
document.getElementById('searchService').addEventListener('keypress', e => {
    if(e.key === 'Enter') doSearch();
});
</script>
@endpush
