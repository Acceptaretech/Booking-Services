{{-- public/blogs/index.blade.php --}}
@extends('layouts.public.app')
@section('title','Blogs')
@section('page_header')
    <h1 class="text-4xl font-bold mb-2">Blogs</h1>
    <p class="text-white/70">Tips, guides and home service advice</p>
@endsection
@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-end mb-6">
        <form method="GET" class="flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 shadow-sm">
            <i class="fas fa-search text-gray-400 text-sm"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search blogs..."
                   class="text-sm bg-transparent outline-none w-52 text-gray-700 dark:text-gray-200">
        </form>
    </div>

    @if($blogs->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-10">
        @foreach($blogs as $blog)
        <a href="{{ route('blog.detail',$blog) }}" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg hover:border-primary-300 transition-all">
            <div class="relative h-44 overflow-hidden">
                @if($blog->image)
                    <img src="{{ asset('storage/'.$blog->image) }}" alt="{{ $blog->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-4xl"></i>
                    </div>
                @endif
                @if($blog->read_time)
                <span class="absolute top-3 right-3 bg-primary-600 text-white text-xs px-2 py-1 rounded-full">{{ $blog->read_time }} min</span>
                @endif
                <span class="absolute bottom-3 left-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full">{{ $blog->published_at?->format('M d, Y') }}</span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-sm text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition-colors line-clamp-2 mb-3">{{ $blog->title }}</h3>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ $blog->author->profile_image_url }}" class="w-6 h-6 rounded-full object-cover" alt="">
                        <span class="text-xs text-gray-500">{{ $blog->author->full_name }}</span>
                    </div>
                    <span class="text-primary-600 text-xs font-medium">Read More →</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    {{ $blogs->withQueryString()->links() }}
    @else
    <div class="text-center py-20 text-gray-400"><i class="fas fa-blog text-5xl mb-4 block"></i><p>No blogs yet</p></div>
    @endif
</div>
@endsection
