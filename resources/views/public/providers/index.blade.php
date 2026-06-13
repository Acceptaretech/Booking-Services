{{-- public/providers/index.blade.php --}}
@extends('layouts.public.app')
@section('title','Providers')
@section('page_header')
    <h1 class="text-4xl font-bold mb-2">Providers</h1>
    <p class="text-white/70">Trusted professionals ready to help you</p>
@endsection
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-end mb-6">
        <form method="GET" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 shadow-sm">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search providers..."
                   class="text-sm text-gray-700 dark:text-gray-200 bg-transparent outline-none w-52">
        </form>
    </div>

    @if($providers->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 mb-10">
        @foreach($providers as $provider)
        <a href="{{ route('provider.detail',$provider) }}" class="group text-center bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-primary-300 transition-all">
            <div class="relative mx-auto w-28 h-28 mb-4">
                <img src="{{ $provider->profile_image_url }}" alt="{{ $provider->full_name }}"
                     class="w-28 h-28 rounded-2xl object-cover group-hover:scale-105 transition-transform">
                <span class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-800"></span>
            </div>
            <p class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition-colors">
                {{ $provider->full_name }}
                <i class="fas fa-circle-check text-primary-600 text-xs ml-1"></i>
            </p>
            <p class="text-xs text-gray-400 mt-1">{{ $provider->designation ?? 'Manager' }}</p>
            @if($provider->reviews_avg_rating)
            <div class="flex justify-center gap-0.5 mt-2">
                @for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=round($provider->reviews_avg_rating)?'text-yellow-400':'text-gray-300' }}"></i>@endfor
                <span class="text-xs text-gray-400 ml-1">{{ number_format($provider->reviews_avg_rating,1) }}</span>
            </div>
            @endif
        </a>
        @endforeach
    </div>
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Show <select class="border rounded px-1 py-0.5 text-xs mx-1 dark:bg-gray-700 dark:border-gray-600 outline-none"><option>10</option><option>25</option><option>50</option></select> entries
        </p>
        {{ $providers->withQueryString()->links() }}
    </div>
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-user-slash text-5xl mb-4 block"></i><p>No providers found</p></div>
    @endif
</div>
@endsection
