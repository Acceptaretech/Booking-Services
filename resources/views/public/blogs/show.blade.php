@extends('layouts.public.app')

@section('title', $blog->title ?? 'Blog Details')

@section('content')

<div class="max-w-4xl mx-auto px-4 py-10">

    {{-- Blog Image --}}
    @if(!empty($blog->image))
        <img
            src="{{ asset('storage/' . $blog->image) }}"
            alt="{{ $blog->title }}"
            class="w-full h-72 object-cover rounded-2xl mb-8">
    @endif

    {{-- Blog Meta --}}
    <div class="flex flex-wrap items-center gap-3 mb-5 text-sm text-gray-500">

        <span>
            {{ $blog->author->full_name ?? $blog->author->name ?? 'Admin' }}
        </span>

        <span>•</span>

        <span>
            @if($blog->published_at)
                {{ \Carbon\Carbon::parse($blog->published_at)->format('M d, Y') }}
            @else
                {{ $blog->created_at ? $blog->created_at->format('M d, Y') : '' }}
            @endif
        </span>

        @if(!empty($blog->read_time))
            <span>•</span>
            <span>{{ $blog->read_time }} Min Read</span>
        @endif

        <span>•</span>
        <span>{{ $blog->views ?? 0 }} Views</span>

    </div>

    {{-- Blog Title --}}
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">
        {{ $blog->title }}
    </h1>

    {{-- Blog Content --}}
    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">

        {!! $blog->content !!}

    </div>

    {{-- Related Blogs --}}
    @if(isset($related) && $related->count())

        <div class="mt-16 pt-8 border-t border-gray-200 dark:border-gray-700">

            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Related Posts
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                @foreach($related as $r)

                    <a href="{{ route('blog.detail', $r->id) }}"
                       class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">

                        @if(!empty($r->image))
                            <img
                                src="{{ asset('storage/' . $r->image) }}"
                                alt="{{ $r->title }}"
                                class="w-full h-40 object-cover">
                        @endif

                        <div class="p-4">

                            <h4 class="font-semibold text-gray-800 dark:text-gray-200 group-hover:text-primary-600 transition line-clamp-2">
                                {{ $r->title }}
                            </h4>

                            <p class="text-xs text-gray-500 mt-2">
                                @if($r->published_at)
                                    {{ \Carbon\Carbon::parse($r->published_at)->format('M d, Y') }}
                                @endif
                            </p>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    @endif

</div>

@endsection