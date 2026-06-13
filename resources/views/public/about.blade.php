@extends('layouts.public.app')

@section('title', $page->title)

@section('page_header')
    <h1 class="text-4xl font-bold capitalize">{{ $page->title }}</h1>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-10 border border-gray-100 dark:border-gray-700">

        <div class="prose dark:prose-invert max-w-none">
            {!! $page->content !!}
        </div>

    </div>
</div>
@endsection