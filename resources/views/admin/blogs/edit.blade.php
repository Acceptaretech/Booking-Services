@extends('layouts.admin.app')

@section('page_title','Edit Blog')

@section('content')
@include('admin.blogs.form', [
    'blog' => $blog,
    'action' => route('admin.blogs.update', $blog->id),
    'method' => 'PUT',
    'title' => 'Edit Blog'
])
@endsection