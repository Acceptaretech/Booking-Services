{{-- public/categories/index.blade.php --}}
@extends('layouts.public.app')
@section('title','Categories')
@section('page_header')
    <h1 class="text-4xl font-bold mb-2">All Categories</h1>
    <p class="text-white/70">Browse services by category</p>
@endsection
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-end mb-6">
        <form method="GET" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 shadow-sm">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..."
                   class="text-sm text-gray-700 dark:text-gray-200 bg-transparent outline-none w-52">
            <button type="submit" class="text-primary-600 text-sm font-medium hover:underline">Search</button>
        </form>
    </div>

    @if($categories->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5 mb-10">
        @foreach($categories as $cat)
        <a href="{{ route('services') }}?category_id={{ $cat->id }}" class="group bg-white dark:bg-gray-800 rounded-2xl p-6 text-center border border-gray-100 dark:border-gray-700 hover:border-primary-300 hover:shadow-lg transition-all">
            <div class="w-16 h-16 mx-auto mb-4 bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center group-hover:bg-primary-100 transition-colors">
                @if($cat->image)
                    <img src="{{ asset('storage/'.$cat->image) }}" alt="{{ $cat->name }}" class="w-10 h-10 object-contain">
                @else
                    <i class="fas fa-tools text-primary-600 text-2xl"></i>
                @endif
            </div>
            <p class="font-semibold text-sm text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition-colors mb-1">{{ $cat->name }}</p>
            <p class="text-xs text-gray-400 line-clamp-2">{{ Str::limit($cat->description,60) }}</p>
            <span class="mt-2 inline-block text-xs text-primary-500 font-medium">{{ $cat->services_count }} services</span>
        </a>
        @endforeach
    </div>
    {{ $categories->withQueryString()->links() }}
    @else
    <div class="text-center py-20 text-gray-400">
        <i class="fas fa-layer-group text-5xl mb-4 block"></i>
        <p class="text-lg">No categories found</p>
    </div>
    @endif
</div>
@endsection
