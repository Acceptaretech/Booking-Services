@extends('layouts.public.app')
@section('title','Services')
@section('page_header')
    <h1 class="text-4xl font-bold mb-2">Our Services</h1>
    <p class="text-white/70">Find the perfect service for your needs</p>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- Filters bar --}}
    <form method="GET" class="flex flex-wrap gap-3 mb-8 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
        <select name="category_id" class="flex-1 min-w-40 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <select name="provider_id" class="flex-1 min-w-40 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">All Providers</option>
            @foreach($providers as $p)
            <option value="{{ $p->id }}" {{ request('provider_id')==$p->id?'selected':'' }}>{{ $p->full_name }}</option>
            @endforeach
        </select>

        <select name="price" class="flex-1 min-w-32 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">All Price</option>
            <option value="free" {{ request('price')==='free'?'selected':'' }}>Free</option>
            <option value="0-25" {{ request('price')==='0-25'?'selected':'' }}>$0 - $25</option>
            <option value="25-50" {{ request('price')==='25-50'?'selected':'' }}>$25 - $50</option>
            <option value="50+" {{ request('price')==='50+'?'selected':'' }}>$50+</option>
        </select>

        <select name="sort" class="flex-1 min-w-36 px-3 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 outline-none focus:ring-2 focus:ring-primary-500">
            <option value="">Sort By</option>
            <option value="top_rated"    {{ request('sort')==='top_rated'?'selected':'' }}>Top Rated</option>
            <option value="best_selling" {{ request('sort')==='best_selling'?'selected':'' }}>Best Selling</option>
            <option value="newest"       {{ request('sort')==='newest'?'selected':'' }}>Newest</option>
        </select>

        <div class="flex items-center gap-2 flex-1 min-w-44 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl px-3">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                   class="w-full py-2.5 bg-transparent text-sm text-gray-700 dark:text-gray-200 outline-none">
        </div>

        <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-colors">
            <i class="fas fa-filter mr-1"></i> Filter
        </button>
        <a href="{{ route('services') }}" class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-200 transition-colors">Reset</a>
    </form>

    {{-- Results count --}}
    <p class="text-sm text-gray-500 mb-6">
        Showing <strong class="text-gray-800 dark:text-gray-200">{{ $services->total() }}</strong> services
        @if(request('search')) for "<strong>{{ request('search') }}</strong>" @endif
    </p>

    {{-- Services grid --}}
    @if($services->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        @foreach($services as $service)
            @include('components.service-card', compact('service'))
        @endforeach
    </div>
    {{ $services->withQueryString()->links() }}
    @else
    <div class="text-center py-20">
        <i class="fas fa-search text-6xl text-gray-300 mb-4 block"></i>
        <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">No services found</h3>
        <p class="text-gray-400">Try adjusting your filters or search terms</p>
        <a href="{{ route('services') }}" class="mt-4 inline-block bg-primary-600 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-700 transition-colors">Browse All Services</a>
    </div>
    @endif
</div>
@endsection
