@extends('layouts.admin.app')

@section('page_title','Create Blog')

@section('content')
@include('admin.blogs.form', [
    'blog' => null,
    'action' => route('admin.blogs.store'),
    'method' => 'POST',
    'title' => 'Create Blog'
])
@endsection